<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index()
    {
        $this->load->view('admin/login');
    }

    public function authenticate(){
        $this->load->library('form_validation');
        $this->load->model('Admin_model');

        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');

        if ($this->form_validation->run() == true) {
            // Success
            $entered_username = $this->input->post('username');
            $admin = $this->Admin_model->getByUsername($entered_username);
            
            if (!empty($admin)){
                $entered_password = $this->input->post('password');
                if (strcmp($entered_password , $admin['Password']) == 0) {
                    $admin_arr['admin_id'] = $admin['adminID'];
                    $admin_arr['username'] = $admin['Username'];
                    $this->session->set_userdata('admin_data', $admin_arr);
                    redirect(base_url('admin/home'));
                } 
                else {
                    $this->session->set_flashdata('msg','Either username or password is incorrect');
                    redirect(base_url('admin/login'));
                }
            } 
            else {
                $this->session->set_flashdata('msg','Either username or password is incorrect');
                redirect(base_url('admin/login'));
            }

        }
         else {
            // Form Error
            $this->load->view('admin/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_data');
        redirect(base_url('admin/login'));
    }
}

?>