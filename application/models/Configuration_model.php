<?php

class configuration_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_configurations()
    {
        $query = $this->db->get('configuration_note');
        return $query->result();
    }

    public function modifier_valeur_config($code, $new_valeur)
    {
        $this->db->where('code', $code);
        $this->db->update('configuration_note', array('valeur' => $new_valeur));
        return $this->db->affected_rows();
    }
    
}