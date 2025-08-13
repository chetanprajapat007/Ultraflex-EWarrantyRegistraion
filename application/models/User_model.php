<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // NOTE: This method is not currently used by the Admin controller's login function
    // as a temporary fix has been applied to use hardcoded credentials.
    public function get_user($email, $password) {
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return false;
    }
}
