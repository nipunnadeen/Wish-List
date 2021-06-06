<?php

class CategoryModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getCategories()
    {
        try {
            $query = $this->db->get('categories');
            return $query->result();
        } catch (Exception $e) {
            return null;
        }
    }
}