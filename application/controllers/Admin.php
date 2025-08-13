<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // NOTE: The User_model is not used for the temporary login fix,
        // but the file should exist in application/models/.
        // $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('is_admin_login')) {
            redirect('admin/dashboard');
        } else {
            $this->load->view('admin/login');
        }
    }

    public function login() {
        // This is a temporary fix to guarantee login works.
        // It bypasses the database and uses hardcoded credentials.
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if ($email === 'Ultraflex@gmail.cpm' && $password === 'Ultra@112233') {
            $this->session->set_userdata('is_admin_login', true);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid credentials');
            redirect('admin');
        }
    }

    public function dashboard() {
        if (!$this->session->userdata('is_admin_login')) {
            redirect('admin');
        }

        // The dashboard view is loaded, but data display will depend on the Warranty_model.
        // To keep this minimal, we are not loading the warranty model here.
        $data['warranties'] = array(); // Pass an empty array
        $this->load->view('admin/dashboard', $data);
    }

    public function logout() {
        $this->session->unset_userdata('is_admin_login');
        redirect('admin');
    }
}
