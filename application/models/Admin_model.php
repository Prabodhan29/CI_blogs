<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getByUsername($username) {
        $this->db->where('Username', $username);
        $admin = $this->db->get('admins')->row_array();
        return $admin;
    }
}