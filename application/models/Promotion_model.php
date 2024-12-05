<?php

class Promotion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_promotions()
    {
        $query = $this->db->get('promotion');
        return $query->result();
    }

    public function get_promotion($promotion)
    {
        $this->db->where('id_promotion', $promotion);
        $query = $this->db->get('promotion');
        return $query->row();
    }
}

?>