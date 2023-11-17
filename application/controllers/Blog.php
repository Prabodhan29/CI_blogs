<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller {
    public function index($page=1) {
        $this->load->model('Article_model');
        $this->load->helper('text');
        $this->load->helper('common_helper');

        $perpage = 4;
        $param['offset'] = $perpage;
        $param['limit'] = ($page * $perpage) - $perpage;

        $base_url = base_url('blog/index');
        $total_rows = $this->Article_model->getArticlesCount();
        $pagination_links = addPagination($base_url, $total_rows, $perpage);

        $articles = $this->Article_model->getArticlesFront($param);
        $data['articles'] = $articles;
        $data['pagination_links'] = $pagination_links;

        $this->load->view('front/blog', $data);
    }

    public function categories() {
        $this->load->model('Category_model');
        $categories = $this->Category_model->getCategoriesFront();

        $data['categories'] = $categories;
        $this->load->view('front/categories', $data);
    }

    public function detail($id) {
        $this->load->model('Article_model');
        $this->load->model('Comment_model');
        $this->load->library('form_validation');

        $article = $this->Article_model->getArticle($id);

        if (empty($article)) {
            redirect(base_url('blog'));
        }
      
        $data['article'] = $article;

        $comments = $this->Comment_model->getComments($id, true);
        $data['comments'] = $comments;

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('comment', 'Comment', 'required');
        $this->form_validation->set_error_delimiters('<p class="mb-0">', '</p>');

        if ($this->form_validation->run() == true) {
            // Insert here
            $formArray = [];
            $formArray['Name'] = $this->input->post('name');
            $formArray['Comment'] = $this->input->post('comment');
            $formArray['articleID'] = $id;
            $formArray['createdAt'] = date('Y-m-d H:i:s');
            $this->Comment_model->create($formArray);

            $this->session->set_flashdata('message', 'Your comment has been posted successfully.');
            redirect(base_url('blog/detail/' . $id));
        } 
        else {
            $this->load->view('front/detail', $data);
        }
    }

    public function category($category_id, $page = 1) {
        $this->load->model('Category_model');
        $this->load->model('Article_model');
        $this->load->helper('text');
        $this->load->helper('common_helper');

        $category = $this->Category_model->getCategoryById($category_id);
        if (empty($category)) {
            redirect(base_url('blog'));
        }

        $perpage = 2;
        $param['offset'] = $perpage;
        $param['limit'] = ($page * $perpage) - $perpage;
        $param['category_id'] = $category_id;

        $base_url = base_url('blog/category/' . $category_id);
        $total_rows = $this->Article_model->getArticlesCount($param);
        $pagination_links = addPagination($base_url, $total_rows, $perpage);

        $articles = $this->Article_model->getArticlesFront($param);

        $data['articles'] = $articles;
        $data['category'] = $category;
        $data['pagination_links'] = $pagination_links;

        $this->load->view('front/category_articles', $data);
    }
}
