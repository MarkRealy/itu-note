<?php

class Note_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function ajuster_resultat($valeur, $average)
    {
        if ($valeur < 6)
        {
            return 'ajourne';
        }
        elseif ($valeur >= 6 && $valeur < 10 && $average >= 10)
        {
            return 'compense';
        }
        elseif ($valeur >= 10 && $valeur < 12)
        {
            return 'passable';
        }
        elseif ($valeur >= 12 && $valeur < 14)
        {
            return 'assez bien';
        }
        elseif ($valeur >= 14 && $valeur < 16)
        {
            return 'bien';
        }
        elseif ($valeur >= 16 && $valeur < 18)
        {
            return 'tres bien';
        }
        elseif ($valeur >= 18)
        {
            return 'honorable';
        }
        return '';
    }


    public function insert_note($data)
    {
        return $this->db->insert('note', $data);
    }

    public function moyenne_note($notes)
    {
        $total_points = 0;
        $total_credits = 0;

        foreach ($notes as $note)
        {
            $total_points += $note->valeur * $note->credit;
            $total_credits += $note->credit;
        }

        if ($total_credits > 0)
        {
            return $total_points / $total_credits;
        }
        else
        {
            return 0;
        }
    }


    public function get_config_limit_note()
    {
        $query = $this->db->get_where('configuration_note',array('code'=>'CONF1'));
        return $query->row();
    }
    public function get_config_nbr_ajournee()
    {
        $query = $this->db->get_where('configuration_note',array('code'=>'CONF2'));
        return $query->row();
    }
    
    public function get_config_type_calcul()
    {
        $query = $this->db->get_where('configuration_note',array('code'=>'CONF3'));
        return $query->row();
    }
    
    public function get_notes_par_semestre($id_semestre, $num_etu)
    {
        // Récupérer la configuration pour le type de calcul des notes (1 ou 2)
        $conf3 = $this->get_config_type_calcul();
        $conf3_value = (int)$conf3->valeur;
        // Récupérer toutes les notes pour le semestre donné
        $this->db->select('matiere.id_matiere, matiere.code_matiere, matiere.nom_matiere, matiere.credit, matiere.option, note.num_etu, etudiant.unique_etu, note.valeur, note.resultat, note.date_session');
        $this->db->from('matiere');
        $this->db->join('note', 'matiere.id_matiere = note.id_matiere AND note.num_etu = '.$this->db->escape($num_etu), 'left');
        $this->db->join('etudiant', 'etudiant.num_etu = note.num_etu', 'left');
        $this->db->where('matiere.id_semestre', $id_semestre);
        // $this->db->group_by('matiere.id_matiere, matiere.code_matiere, matiere.nom_matiere, matiere.credit, matiere.option, note.num_etu, etudiant.unique_etu, note.valeur, note.resultat, note.date_session');
        $query = $this->db->get();
        $notes = $query->result();
        // Organiser les notes par matière
        $grouped_notes = [];
        foreach ($notes as $note) {
            $grouped_notes[$note->code_matiere][] = $note;
        }

        // var_dump( $this->db->last_query() );
    
        $filtered_notes = [];
        $option_max_notes = [];
    
        foreach ($grouped_notes as $code_matiere => $notes_matiere) {
            if (count($notes_matiere) > 1) {
                // Si la matière a plusieurs notes, appliquer la logique selon la valeur de CONF3
                if ($conf3_value == 1) {
                    $selected_note = $notes_matiere[0];
                    for($i=1;$i < count($notes_matiere);$i++){
                        if($selected_note->valeur < $notes_matiere[$i]->valeur){
                            $selected_note = $notes_matiere[$i];
                        }else{
                            $selected_note = $selected_note;
                        }
                    }
                } elseif ($conf3_value == 2) {
                    $selected_note = $notes_matiere[0];
                    $value = 0;
                    for($i=0;$i < count($notes_matiere);$i++){
                        $value += $notes_matiere[$i]->valeur ;
                    }
                    $selected_note->valeur = $value / count($notes_matiere) ;
                }
            
            } elseif (count($notes_matiere) == 1) {
                // S'il n'y a qu'une seule note pour la matière, on la garde telle quelle
                $selected_note = $notes_matiere[0];
            } else {
                // Gérer le cas où il n'y a aucune note (facultatif, selon votre logique)
                continue; // Ou définir $selected_note à null, selon ce qui est plus approprié.
            }
        
            // Vérifier si la matière est optionnelle et traiter les options 19, 22, et 32
            if (isset($selected_note) && in_array($selected_note->option, [19, 22, 32])) {
                if (!isset($option_max_notes[$selected_note->option]) || $selected_note->valeur > $option_max_notes[$selected_note->option]->valeur) {
                    $option_max_notes[$selected_note->option] = $selected_note;
                }
            } elseif (isset($selected_note)) {
                $filtered_notes[] = $selected_note;
            }
        }               
    
        // Ajouter les notes maximales des options 19, 22, et 32 au tableau des notes filtrées
        foreach ($option_max_notes as $max_note) {
            $filtered_notes[] = $max_note;
        }
    
        $total_credits = 0;
        $nbr_valide = 0;
    
        foreach ($filtered_notes as $note) {
            if ($note->valeur >= 10) {
                $total_credits += $note->credit;
                $nbr_valide += 1;
            }
        }
    
        $nbr_non_valid = count($filtered_notes) - $nbr_valide;
    
        $limit_note = $this->get_config_limit_note();
        $nbr_ajournee = $this->get_config_nbr_ajournee();
        $average = $this->moyenne_note($filtered_notes);
    
        foreach ($filtered_notes as &$note) {
            if ($note->valeur < $limit_note->valeur) {
                $note->deliberation = 'ajournee';
            } elseif ($note->valeur >= $limit_note->valeur && $note->valeur < 10) {
                if ($average < 10) {
                    $note->deliberation = 'ajournee';
                } elseif ($average >= 10) {
                    if ($nbr_non_valid <= $nbr_ajournee->valeur) {
                        $note->deliberation = 'compensee';
                    } else {
                        $note->deliberation = 'ajournee';
                    }
                }
            } elseif ($note->valeur >= 10 && $note->valeur < 12) {
                $note->deliberation = 'Passable';
            } elseif ($note->valeur >= 12 && $note->valeur < 14) {
                $note->deliberation = 'Assez Bien';
            } elseif ($note->valeur >= 14 && $note->valeur < 16) {
                $note->deliberation = 'Bien';
            } elseif ($note->valeur >= 16 && $note->valeur < 18) {
                $note->deliberation = 'Tres Bien';
            } elseif ($note->valeur >= 18) {
                $note->deliberation = 'Honorable';
            }
        }
    
        return array('notes' => $filtered_notes, 'total_credits' => $total_credits, 'average' => $average);
    }
    
    public function get_semestre($id_semestre)
    {
        $this->db->select('id_semestre, numero_semestre');
        $this->db->from('semestre');
        $this->db->where('id_semestre', $id_semestre);
        $query = $this->db->get();
        return $query->row(); // Return a single row as an object
    }

    
}


?>
