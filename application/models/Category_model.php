<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model {
    public function createCategory($form_data) {
        $this->db->insert('categories', $form_data);
    }

    public function getCategories($params = []) {
        if(!empty($params['queryString'])) {
            $this->db->like('Name', $params['queryString']); // search based on Name column
        }

        $result = $this->db->get('categories')->result_array();
        return $result;
    }

    public function getCategoryById($id) {
        $this->db->where('categoryID', $id);
        $category = $this->db->get('categories')->row_array();
        return $category;
    } 

    public function updateCategory($id, $form_data) {
        $this->db->where('categoryID', $id);
        $this->db->update('categories', $form_data);
    }

    public function deleteCategory($id) {
        $this->db->where('categoryID', $id);
        $this->db->delete('categories');
    }
}
