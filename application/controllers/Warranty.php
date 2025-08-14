<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warranty extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Manually include the root config file to get MSG91 constants
        require_once(APPPATH . '../config.php');

        // Load the warranty model
        $this->load->model('Warranty_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('warranty/register');
    }

    public function register() {
        // This is a simplified registration process
        // In a real application, you would have more validation and error handling

        $data = array(
            'customer_name' => $this->input->post('customer_name'),
            'customer_contact' => $this->input->post('customer_contact'),
            'customer_email' => $this->input->post('customer_email'),
            'dealer_name' => $this->input->post('dealer_name'),
            'bill_number' => $this->input->post('bill_number')
        );

        $warranty_id = $this->Warranty_model->add_warranty($data);

        $product_names = $this->input->post('product_name');
        $product_sizes = $this->input->post('product_size');
        $products = [];

        if (!empty($product_names)) {
            for ($i = 0; $i < count($product_names); $i++) {
                $products[] = array(
                    'product_name' => $product_names[$i],
                    'product_size' => $product_sizes[$i]
                );
            }
            $this->Warranty_model->add_warranty_products($warranty_id, $products);
        }

        // Generate and save OTP
        $otp = rand(100000, 999999);
        $this->Warranty_model->save_otp($data['customer_contact'], $otp);

        // Send OTP via MSG91
        $this->_send_otp_msg91($data['customer_contact'], $otp);

        // Set data in session to use on verification page
        $this->session->set_userdata('contact_for_verification', $data['customer_contact']);
        $this->session->set_userdata('warranty_id_for_verification', $warranty_id);

        // Redirect to OTP verification page
        redirect('warranty/verify_otp');
    }

    public function verify_otp() {
        $this->load->view('warranty/verify_otp');
    }

    public function process_otp() {
        $otp = $this->input->post('otp');
        $contact_number = $this->session->userdata('contact_for_verification');
        $warranty_id = $this->session->userdata('warranty_id_for_verification');

        if ($contact_number && $warranty_id && $this->Warranty_model->verify_otp($contact_number, $otp)) {
            // Send success SMS
            $this->_send_success_sms($contact_number, $warranty_id);

            // Clean up session
            $this->session->unset_userdata('contact_for_verification');
            $this->session->unset_userdata('warranty_id_for_verification');

            redirect('warranty/success');
        } else {
            $this->session->set_flashdata('error', 'Invalid or expired OTP. Please try again.');
            redirect('warranty/verify_otp');
        }
    }

    public function success() {
        $this->load->view('warranty/success');
    }

    private function _send_otp_msg91($mobile, $otp) {
        // Your provided Auth Key and Template ID
        $authKey = MSG91_AUTH_KEY;
        $templateId = MSG91_TEMPLATE_ID;

        // API URL
        $url = "https://api.msg91.com/api/v5/otp?template_id={$templateId}&mobile=91{$mobile}&authkey={$authKey}&otp={$otp}";

        // Use cURL to send the request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        curl_close($ch);

        // Log the response from MSG91 for debugging
        log_message('info', 'MSG91 OTP Response: ' . $response);
    }

    private function _send_success_sms($mobile, $warranty_id) {
        $product = $this->Warranty_model->get_first_product_for_warranty($warranty_id);
        if (!$product) {
            return; // No product found, so don't send SMS
        }

        $authKey = MSG91_AUTH_KEY;
        $senderId = MSG91_SENDER_ID;
        $flowId = MSG91_SUCCESS_TEMPLATE_ID;

        $data = array(
            'sender' => $senderId,
            'flow_id' => $flowId,
            'mobiles' => '91' . $mobile,
            'VAR1' => $product['product_name'],
            'VAR2' => $product['product_name'], // User specified Var2: Product name
            'VAR3' => $product['product_size']
        );

        $url = 'https://api.msg91.com/api/v5/flow/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authkey: ' . $authKey,
            'Content-Type: application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        log_message('info', 'MSG91 Success SMS Response: ' . $response);
    }
}
