<?php

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_user($login, $mdp)
    {
        $query = $this->db->get_where('admin', array('login' => $login, 'mdp' => $mdp));
        $admin = $query->row_array();

        if ($admin)
        {
            return $admin;
        }
        else
        {
            return false;
        }
    }

    public function clear_database()
    {
        $tables = [
            'configuration_note',
            //'semestre_inscrit',
            'note',
            'etudiant',
            'promotion'  
        ];
        $this->db->trans_off();
        foreach( $tables as $table )
        {
            //echo $table;
            $this->db->query('truncate table '.$table.' restart identity cascade');
            // sleep(1);
        }
    }

    
    public function insert_config($datas)
    {
        $query ="TRUNCATE TABLE configuration_note RESTART IDENTITY CASCADE";
        $this->db->query($query);
        foreach ($datas as $data)
        {
            $d = array(
                'code'=>trim($data[0]),
                'config'=>trim($data[1]),
                'valeur'=>trim($data[2])
            );
            $this->db->insert('configuration_note', $d);
        }
    }
    

    public function import_into_temporary_note($datas)
    {       
        $query ="TRUNCATE TABLE temporary_note RESTART IDENTITY CASCADE";
        $this->db->query($query);
            $this->db->trans_begin();
            foreach( $datas as $data )
            {
                $d8 = str_replace( ',', '.', trim($data[8]));
                $date4 = DateTime::createFromFormat('d/m/Y', trim($data[4]));
                $d4 = $date4->format('Y-m-d');
                $d = array(
                    'num_etu'=>trim($data[0]),
                    'nom_etudiant'=>trim($data[1]),
                    'prenom_etudiant'=>trim($data[2]),
                    'genre'=>trim($data[3]),
                    'date_naissance'=>trim($d4),
                    'promotion'=>trim($data[5]),
                    'code_matiere'=>trim($data[6]),
                    'semestre'=>trim($data[7]),
                    'note'=>trim($d8),
                    
                );
                $this->db->insert('temporary_note', $d);
            }

            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return $this->db->error()['message'];
            }
            else
            {
                // Okey inona ny ato
                // Antsoina ilay fonction iny
                $insert_function = "insert_via_temp_note()";
                
                if($this->db->query( 'select ' .$insert_function))
                {
                    $this->db->trans_commit();
                }
                else
                {
                    $this->db->trans_rollback();
                    return $this->db->error()['message'];
                }

            }
    }
}

