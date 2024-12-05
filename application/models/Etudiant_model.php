<?php

class Etudiant_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_user($num_etu)
    {
        $query = $this->db->get_where('etudiant', array('unique_etu' => $num_etu));
        $etudiant = $query->row_array();

        if ($etudiant)
        {
            return $etudiant;
        }
        else
        {
            return false;
        }
    }

    public function get_etudiantByIdProm($id){
        $query = $this->db->get_where('etudiant', array('id_promotion' => $id));
        return $query->result();
    }

    public function get_etudiants_par_semestre($id_semestre)
    {
        // Obtenir tous les étudiants
        $this->db->select('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant');
        $this->db->from('etudiant');
        $etudiants = $this->db->get()->result();

        $moyennes = [];

        // Obtenir tous les étudiants pour le semestre donné, même ceux sans notes
        // $this->db->select('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant');
        // $this->db->from('etudiant');
        // $this->db->join('note', 'etudiant.num_etu = note.num_etu', 'left'); // Utiliser LEFT JOIN
        // $this->db->join('matiere', 'note.id_matiere = matiere.id_matiere', 'left'); // Utiliser LEFT JOIN
        // $this->db->where('matiere.id_semestre', $id_semestre);
        // $this->db->group_by('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant');

        // $query = $this->db->get();
        // $etudiants = $query->result();

        // Calculer la moyenne pour chaque étudiant
        foreach ($etudiants as $etudiant) {
            $result = $this->Note_model->get_notes_par_semestre($id_semestre, $etudiant->num_etu);
            $etudiant->moyenne = isset($result['average']) && $result['average'] !== null ? $result['average'] : 0.0;
            $moyennes[$etudiant->num_etu] = $etudiant->moyenne;
        }

        // Trier les étudiants par moyenne décroissante après avoir assigné les rangs
        usort($etudiants, function($a, $b)
        {
            if ($a->moyenne == $b->moyenne) {
                return 0;
            }
            return ($a->moyenne < $b->moyenne) ? 1 : -1;
        });

        // Calculer les rangs denses
        $dernier_rang = 0;
        $rang_precedent = 0;
        $moyenne_precedente = null;

        foreach ($etudiants as $index => $etudiant) {
            if ($etudiant->moyenne !== $moyenne_precedente) {
                // Si la moyenne est différente, on avance le rang
                $dernier_rang = $rang_precedent + 1;
            }
            $etudiant->rang = $dernier_rang;

            // Mettre à jour les variables pour la prochaine itération
            $moyenne_precedente = $etudiant->moyenne;
            $rang_precedent = $dernier_rang;
        }

        return $etudiants;
    }

    private function get_dense_ranks($array)
    {
        $sorted_array = array_values(array_unique($array));
        rsort($sorted_array);

        $ranks = [];
        $rank = 1;

        foreach ($sorted_array as $value) {
            foreach ($array as $key => $original_value) {
                if ($original_value == $value && !isset($ranks[$key])) {
                    $ranks[$key] = $rank;
                }
            }
            $rank++;
        }

        return $ranks;
    }


    
    public function get_all_etudiants()
    {
        $this->db->select('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant, promotion.nom_promotion');
        $this->db->from('etudiant');
        $this->db->join('promotion', 'etudiant.id_promotion = promotion.id_promotion');
        $this->db->order_by('etudiant.num_etu', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_etudiant_by_promotion($promotion)
    {
        $this->db->select('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant, promotion.nom_promotion');
        $this->db->from('etudiant');
        $this->db->join('promotion', 'etudiant.id_promotion = promotion.id_promotion');
        $this->db->where('promotion.nom_promotion', $promotion);
        $this->db->order_by('etudiant.num_etu', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_etudiants_by_idpromotion($id_promotion)
    {
        $this->db->select('num_etu');
        $this->db->from('etudiant');
        $this->db->where('id_promotion', $id_promotion);

        $query = $this->db->get();
        return $query->result();
    }


    public function get_etudiant_by_nom($nom)
    {
        $this->db->select('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant, promotion.nom_promotion');
        $this->db->from('etudiant');
        $this->db->join('promotion', 'etudiant.id_promotion = promotion.id_promotion');
        $this->db->where('LOWER(etudiant.nom_etudiant) ILIKE', '%' . strtolower($nom) . '%');
        $this->db->order_by('etudiant.num_etu', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_etudiant_by_unique_etu($unique_etu)
    {
        $this->db->select('num_etu, unique_etu, nom_etudiant, prenom_etudiant');
        $this->db->from('etudiant');
        $this->db->where('unique_etu', $unique_etu);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_etudiant_by_num_etu($num_etu)
    {
        $this->db->select('num_etu, unique_etu, nom_etudiant, prenom_etudiant,id_promotion');
        $this->db->from('etudiant');
        $this->db->where('num_etu', $num_etu);
        $query = $this->db->get();
        return $query->row();
    }

    /*public function get_etudiant_by_num($num_etu)
    {
        $this->db->select('num_etu, unique_etu, nom_etudiant, prenom_etudiant');
        $this->db->from('etudiant');
        $this->db->where('num_etu', $num_etu);
        $query = $this->db->get();
        return $query->row();
    }

    /*public function get_etudiant_by_promotion_and_nom($promotion, $nom)
    {
        $this->db->select('*');
        $this->db->from('etudiants');
        $this->db->where('promotion', $promotion);
        $this->db->like('nom', $nom);  // Utilisation de 'like' pour permettre des recherches partielles
        $query = $this->db->get();
        return $query->result();
    }*/

    /*public function get_semestres_by_etudiant($num_etu)
    {
        // Exemple de requête pour récupérer les semestres
        $this->db->select('semestre_inscrit.id_semestre_inscrit, semestre.id_semestre, semestre.numero_semestre');
        $this->db->from('semestre_inscrit');
        $this->db->join('semestre', 'semestre_inscrit.id_semestre = semestre.id_semestre');
        $this->db->where('semestre_inscrit.num_etu', $num_etu);
        $query = $this->db->get();
        return $query->result();
    }*/

    public function get_semestres()
    {
        $this->db->select('semestre.id_semestre, semestre.numero_semestre');
        $this->db->from('semestre');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_etudiants_par_semestre_promotion_tries_par_moyenne($id_semestre, $promotion)
    {
        $this->db->select('etudiant.num_etu, etudiant.unique_etu, etudiant.nom_etudiant, etudiant.prenom_etudiant, AVG(note.valeur) as moyenne');
        $this->db->from('etudiant');
        $this->db->join('note', 'etudiant.num_etu = note.num_etu');
        $this->db->join('matiere', 'note.id_matiere = matiere.id_matiere');
        $this->db->where('matiere.id_semestre', $id_semestre);
        $this->db->where('etudiant.id_promotion', $promotion);
        $this->db->group_by('etudiant.num_etu');
        $this->db->order_by('moyenne', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_semestre($id_semestre)
    {
        $this->db->where('id_semestre', $id_semestre);
        $query = $this->db->get('semestre');
        return $query->row();
    }

    public function get_all_semestres()
    {
        $query = $this->db->get('semestre');
        return $query->result();
    }

}

?>