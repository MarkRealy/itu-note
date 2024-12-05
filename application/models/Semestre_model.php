<?php

class Semestre_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_semestres_by_annee($id_annee)
    {
        $this->db->select('id_semestre');
        $this->db->from('semestre');
        $this->db->where('id_annee', $id_annee);
        $query = $this->db->get();
        return $query->result();

    }
}

?>