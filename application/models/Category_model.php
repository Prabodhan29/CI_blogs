<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model
{
    public function createCategory($form_data) {
        $this->db->insert('categories', $form_data);
    }
}