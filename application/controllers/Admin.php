<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Warranty_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        // If user is logged in, show dashboard, else show login
        if ($this->session->userdata('is_admin_login')) {
            redirect('admin/dashboard');
        } else {
            $this->load->view('admin/login');
        }
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->get_user($email, $password);

        if ($user) {
            $this->session->set_userdata('is_admin_login', true);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid credentials');
            redirect('admin');
        }
    }

    public function dashboard() {
        // If user is not logged in, redirect to login
        if (!$this->session->userdata('is_admin_login')) {
            redirect('admin');
        }

        // Load dashboard view
        $data['warranties'] = $this->Warranty_model->get_all_warranties();
        $this->load->view('admin/dashboard', $data);
    }

    public function logout() {
        $this->session->unset_userdata('is_admin_login');
        redirect('admin');
    }
}
