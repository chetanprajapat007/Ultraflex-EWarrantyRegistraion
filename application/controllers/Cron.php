<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Warranty_model');
    }

    public function send_feedback_requests() {
        $warranties = $this->Warranty_model->get_all_warranties();
        $today = new DateTime();

        foreach ($warranties as $warranty) {
            $registration_date = new DateTime($warranty['registration_date']);
            $diff = $today->diff($registration_date)->days;

            if ($diff == 30 || $diff == 60) {
                // Here you would implement the email sending logic
                // For example, using CodeIgniter's email library
                /*
                $this->load->library('email');
                $this->email->from('your@example.com', 'Your Name');
                $this->email->to($warranty['customer_email']);
                $this->email->subject('Feedback Request');
                $this->email->message('Please provide your feedback on our product.');
                $this->email->send();
                */

                // For now, we'll just log a message
                log_message('info', 'Feedback request sent to ' . $warranty['customer_email'] . ' for warranty ID ' . $warranty['id']);
            }
        }
    }
}
