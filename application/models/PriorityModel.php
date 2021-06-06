<?php

class PriorityModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getPriorities()
    {
        try {
            $query = $this->db->get('priorities');
            return $query->result();
        } catch (Exception $e) {
            return null;
        }
    }
}