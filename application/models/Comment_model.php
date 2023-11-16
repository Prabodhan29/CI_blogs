<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment_model extends CI_Model  {
    public function create($formArray) {
        $this->db->insert('comments', $formArray);
    }

    public function getComments($article_id, $status = null) {
        $this->db->where('articleID', $article_id);

        if ($status == true) {
            $this->db->where('Status', 1);
        }

        $this->db->order_by('createdAt', 'DESC');
        $comments = $this->db->get('comments')->result_array();
        return $comments;
    }
}

?>