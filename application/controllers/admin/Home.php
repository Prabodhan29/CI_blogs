<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        // to give admin dashboard access to only the authorized user
        $admin = $this->session->userdata('admin_data');
        $this->session->set_flashdata('msg','Your session has been expired');
        if(empty($admin)) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        $this->load->helper('url');
        $this->load->view('admin/dashboard');
    }
}
