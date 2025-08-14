<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warranty_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_warranty($data) {
        $this->db->insert('warranties', $data);
        return $this->db->insert_id();
    }

    public function add_warranty_products($warranty_id, $products) {
        foreach ($products as $product) {
            $product['warranty_id'] = $warranty_id;
            $this->db->insert('warranty_products', $product);
        }
    }

    public function save_otp($contact_number, $otp) {
        $data = array(
            'contact_number' => $contact_number,
            'otp' => $otp
        );
        $this->db->insert('otps', $data);
    }

    public function verify_otp($contact_number, $otp) {
        $this->db->where('contact_number', $contact_number);
        $this->db->where('otp', $otp);
        // Also check if OTP is recent, e.g., created in the last 10 minutes
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-10 minutes')));
        $query = $this->db->get('otps');
        return $query->num_rows() > 0;
    }

    public function get_all_warranties() {
        // Fetch all warranties
        $warranties = $this->db->order_by('registration_date', 'DESC')->get('warranties')->result_array();

        // For each warranty, fetch its products
        foreach ($warranties as $key => $warranty) {
            $products = $this->db->get_where('warranty_products', array('warranty_id' => $warranty['id']))->result_array();
            $warranties[$key]['products'] = $products;
        }

        return $warranties;
    }

    public function get_first_product_for_warranty($warranty_id) {
        return $this->db->get_where('warranty_products', array('warranty_id' => $warranty_id), 1)->row_array();
    }
}
