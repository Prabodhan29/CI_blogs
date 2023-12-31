<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller {
    public function about() {
        $this->load->view('front/about');
    }

    public function services() {
        $this->load->view('front/services');
    }

    public function contact() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');

        if ($this->form_validation->run() == true) {
            // Email functionality
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => '', // replace this with your email id
                'smtp_pass' => '******', // replace this with your password
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            $this->email->to(''); // receiver's email
            $this->email->from('test@test.com'); // sender's address
            $this->email->subject('You have received an enquiry'); // email subject

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $msg = $this->input->post('message');

            $message = "Name: " . $name;
            $message .= "<br>";
            $message .= "Email: " . $email;
            $message .= "<br>";
            $message .= "Message: " . $msg;
            $message .= "<br>";
            $message .= "<br>";

            $message .= "Email Example by Prabodhan";

            $this->email->message($message);
            $this->email->send();

            $this->session->set_flashdata('msg', 'Thanks for your enquiry, we will get back to you soon.');
            redirect(base_url('page/contact'));
        } 
        else {
            $this->load->view('front/contact-us');
        }
    }
}
