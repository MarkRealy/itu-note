<?php

class Matiere_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_matieres()
    {
        $query = $this->db->get('matiere');
        return $query->result();
    }

    public function get_matieres_par_semestre($id_semestre)
    {
        $this->db->select('id_matiere, ue, nom_matiere');
        $this->db->from('matiere');
        $this->db->where('id_semestre', $id_semestre);
        $query = $this->db->get();
        return $query->result();
    }

}