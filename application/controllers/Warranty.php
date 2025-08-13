<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warranty extends CI_Controller {

    public function __construct() {
        parent::__construct();
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
        log_message('info', 'OTP for ' . $data['customer_contact'] . ' is ' . $otp);

        // Set contact number in session to use on verification page
        $this->session->set_userdata('contact_for_verification', $data['customer_contact']);

        // Redirect to OTP verification page
        redirect('warranty/verify_otp');
    }

    public function verify_otp() {
        $this->load->view('warranty/verify_otp');
    }

    public function process_otp() {
        $otp = $this->input->post('otp');
        $contact_number = $this->session->userdata('contact_for_verification');

        if ($this->Warranty_model->verify_otp($contact_number, $otp)) {
            $this->session->unset_userdata('contact_for_verification');
            redirect('warranty/success');
        } else {
            $this->session->set_flashdata('error', 'Invalid or expired OTP');
            redirect('warranty/verify_otp');
        }
    }

    public function success() {
        $this->load->view('warranty/success');
    }
}
