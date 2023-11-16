<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Article_model extends CI_Model {
    function getArticle($id) {
        $this->db->select('articles.*,categories.Name as category_name');
        $this->db->where('articles.articleID', $id);
        $this->db->join('categories', 'categories.categoryID = articles.Category', 'left');
        
        $query = $this->db->get('articles');
        $article = $query->row_array();
        return $article;
    }

    function getArticles($param = array()) {
        if (isset($param['offset']) && isset($param['limit'])) {
            $this->db->limit($param['offset'], $param['limit']);
        }

        if (isset($param['q'])) {
            $this->db->or_like('title', trim($param['q']));
            $this->db->or_like('author', trim($param['q']));
        }

        $query = $this->db->get('articles');
        $articles = $query->result_array();
        return $articles;
    }

    function getArticlesCount($param = array()) {
        if (isset($param['q'])) {
            $this->db->or_like('Title', trim($param['q']));
            $this->db->or_like('Author', trim($param['q']));
        }

        if (isset($param['category_id'])) {
            $this->db->where('Category', $param['category_id']);
        }

        $count = $this->db->count_all_results('articles'); // to count number of rows
        return $count;
    }


    // This method will save a article in DB
    function addArticle($formArray) {
        $this->db->insert('articles', $formArray);
        return $this->db->insert_id();
    }

    function updateArticle($id, $formArray) {
        $this->db->where('articleID', $id);
        $this->db->update('articles', $formArray);
    }

    function deleteArticle($id) {
        $this->db->where('articleID', $id);
        $this->db->delete('articles');
    }


    /* Frontend Methods */
    function getArticlesFront($param = array()) {
        if (isset($param['offset']) && isset($param['limit'])) {
            $this->db->limit($param['offset'], $param['limit']);
        }

        if (isset($param['q'])) {
            $this->db->or_like('Title', trim($param['q']));
            $this->db->or_like('Author', trim($param['q']));
        }

        if (isset($param['category_id'])) {
            $this->db->where('Category', $param['category_id']);
        }

        $this->db->select('articles.*,categories.Name as category_name');
        $this->db->where('articles.Status', 1);
        $this->db->order_by('articles.createdAt', 'DESC');
        $this->db->join('categories', 'categories.categoryID = articles.Category', 'left');

        $query = $this->db->get('articles');
        $articles = $query->result_array();
        return $articles;
    }
}
