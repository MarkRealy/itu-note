<?php

class Annee_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_annee_by_level($level)
    {
        $this->db->select('id_annee');
        $this->db->from('annee');
        $this->db->where('id_annee', $level);
        $query = $this->db->get();
        return $query->result();
    }
}

?>