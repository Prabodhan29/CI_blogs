<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // to give admin dashboard access to only the authorized user
        $admin = $this->session->userdata('admin_data');
        $this->session->set_flashdata('msg', 'Your session has been expired');
        if (empty($admin)) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        $this->load->model('Category_model');

        // the search box functionality
        $queryString = $this->input->get('q');
        $params['queryString'] = $queryString;

        $categories = $this->Category_model->getCategories($params);
        $data['categories'] = $categories;
        $data['queryString'] = $queryString;

        $data['mainModule'] = 'category';
        $data['subModule'] = 'viewCategory';

        $this->load->view('admin/category/categoryListing', $data);
    }

    public function create_category() {
        $data['mainModule'] = 'category';
        $data['subModule'] = 'createCategory';

        // to upload images to the desired folder
        $config['upload_path'] = './admin_section/uploads/category';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        $this->load->library('form_validation');
        $this->load->model('Category_model');

        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == true) {
            // save to database

            // get uploaded image using $_FILES superglobal variable
            if(!empty($_FILES['image']['name'])) { 
                // if image is selected

                if($this->upload->do_upload('image')) { // 'image' is input file component name
                    $image_data = $this->upload->data();

                    // to resize the uploaded image
                    $this->load->library('image_lib');
                    $config_img['image_library'] = 'gd2';
                    $config_img['allowed_types'] = 'png|jpg|jpeg';
                    $config_img['source_image'] = './admin_section/uploads/category/'.$image_data['file_name'];
                    $config_img['new_image'] = './admin_section/uploads/category/thumbnails/'.$image_data['file_name'];
                    $config_img['create_thumb'] = TRUE;
                    $config_img['maintain_ratio'] = TRUE;
                    $config_img['thumb_marker'] = '';
                    $config_img['width'] = 300;
                    $config_img['height'] = 270;
                    $this->image_lib->initialize($config_img);
                    $this->image_lib->resize();
                    $this->image_lib->clear(); 
                   
                    $form_arr['Image'] = $image_data['file_name'];
                    $form_arr['Name'] = $this->input->post('name');
                    $form_arr['Status'] = $this->input->post('status');
                    $form_arr['createdAt'] = date('Y-m-d H:i:s');
                    $this->Category_model->createCategory($form_arr);

                    $this->session->set_flashdata('success', 'Category added successfully');
                    redirect(base_url('admin/category'));   
                } 
                else {
                    $error = $this->upload->display_errors("<p class='invalid-feedback'>", "</p>");
                    $data['errorImageUpload'] = $error;
                    $this->load->view('admin/category/categoryCreate', $data);
                }
            }
            else { 
                // save category without image
                $form_arr['Name'] = $this->input->post('name');
                $form_arr['Status'] = $this->input->post('status');
                $form_arr['createdAt'] = date('Y-m-d H:i:s');
                $this->Category_model->createCategory($form_arr);

                $this->session->set_flashdata('success', 'Category added successfully');
                redirect(base_url('admin/category'));
            }
        } 
        else {
            // show error message
            $this->load->view('admin/category/categoryCreate', $data);
        }
    }

   
    public function edit_category($id) {
        $this->load->model('Category_model');
        $category = $this->Category_model->getCategoryById($id);
        if(empty($category)) {
            $this->session->set_flashdata('error','Category not found');
            redirect(base_url().'admin/category');
        }

        // to upload images to the desired folder
        $config['upload_path'] = './admin_section/uploads/category';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == true) {
            // save to database

            // get uploaded image using $_FILES superglobal variable
            if (!empty($_FILES['image']['name'])) {
                // if image is selected

                if ($this->upload->do_upload('image')) { // 'image' is input file component name
                    $image_data = $this->upload->data();

                    // to resize the uploaded image
                    $this->load->library('image_lib');
                    $config_img['image_library'] = 'gd2';
                    $config_img['allowed_types'] = 'png|jpg|jpeg';
                    $config_img['source_image'] = './admin_section/uploads/category/' . $image_data['file_name'];
                    $config_img['new_image'] = './admin_section/uploads/category/thumbnails/' . $image_data['file_name'];
                    $config_img['create_thumb'] = TRUE;
                    $config_img['maintain_ratio'] = TRUE;
                    $config_img['thumb_marker'] = '';
                    $config_img['width'] = 300;
                    $config_img['height'] = 270;
                    $this->image_lib->initialize($config_img);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $form_arr['Image'] = $image_data['file_name'];
                    $form_arr['Name'] = $this->input->post('name');
                    $form_arr['Status'] = $this->input->post('status');
                    $form_arr['updatedAt'] = date('Y-m-d H:i:s');
                    $this->Category_model->updateCategory($id, $form_arr);

                    // once updated, delete the old image and only keep the new image
                    if (file_exists('./admin_section/uploads/category/' . $category['Image'])) {
                        unlink('./admin_section/uploads/category/' . $category['Image']);
                    }
                    if (file_exists('./admin_section/uploads/category/thumbnails/' . $category['Image'])) {
                        unlink('./admin_section/uploads/category/thumbnails/' . $category['Image']);
                    }

                    $this->session->set_flashdata('success', 'Category updated successfully');
                    redirect(base_url('admin/category'));
                } 
                else {
                    $error = $this->upload->display_errors("<p class='invalid-feedback'>", "</p>");
                    $data['errorImageUpload'] = $error;
                    $this->load->view('admin/category/categoryCreate', $data);
                }
            } 
            else {
                // save category without image
                $form_arr['Name'] = $this->input->post('name');
                $form_arr['Status'] = $this->input->post('status');
                $form_arr['updatedAt'] = date('Y-m-d H:i:s');
                $this->Category_model->updateCategory($id, $form_arr);

                $this->session->set_flashdata('success', 'Category updated successfully');
                redirect(base_url('admin/category'));
            }
        }
        else {
            $data['category'] = $category;
            $this->load->view('admin/category/categoryEdit', $data);
        }

    }

    public function delete_category($id) {
        $this->load->model('Category_model');
        $category = $this->Category_model->getCategoryById($id);
        if (empty($category)) {
            $this->session->set_flashdata('error', 'Category not found');
            redirect(base_url() . 'admin/category');
        }

        // before deleting the row, delete the old images
        if (file_exists('./admin_section/uploads/category/' . $category['Image'])) {
            unlink('./admin_section/uploads/category/' . $category['Image']);
        }
        if (file_exists('./admin_section/uploads/category/thumbnails/' . $category['Image'])) {
            unlink('./admin_section/uploads/category/thumbnails/' . $category['Image']);
        }

        $this->Category_model->deleteCategory($id);

        $this->session->set_flashdata('success', 'Category deleted successfully');
        redirect(base_url().'admin/category');
    }

}
