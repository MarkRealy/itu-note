<?php

class Admins extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Matiere_model');
        $this->load->model('Note_model');
        $this->load->model('Etudiant_model');
        $this->load->model('Promotion_model');
        $this->load->model('Configuration_model');
        $this->load->model('Annee_model');
        $this->load->model('Semestre_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('admin/dashboard_view');
    }

    // POUR LOGIN
    public function login()
    {
        $this->load->view('admin/login_view');
    }

    public function do_login()
    {
        $login = $this->input->post('login');
        $mdp = $this->input->post('mdp');

        $admin = $this->Admin_model->check_user($login, $mdp);

        if ($admin)
        {
            $this->session->set_userdata('id_admin', $admin['id_admin']);

            redirect('admins/accueil');
        }
        else
        {
            $this->session->set_flashdata('error', 'Invalid login credentials.');
            redirect('admins/login');
        }        
    }

    public function accueil()
    {
        $this->load->view('admin/accueil');
    }

    public function drop_data()
	{
        $this->Admin_model->clear_database();
        redirect(site_url('admins/accueil'));
    }

    public function logout()
    {
        // Déconnecter l'utilisateur
        $this->session->sess_destroy();

        // Rediriger vers la page de login (ou une autre page si nécessaire)
        redirect('admins/login'); // Assurez-vous que 'login' correspond à l'URL de votre page de login
    }

    // Pour saisir les notes

    public function saisir_note()
    {
        $data['matieres'] = $this->Matiere_model->get_matieres();
        $this->load->view('admin/saisir_note_view', $data);
    }

    public function inserer_note()
    {
        $num_etu = $this->input->post('num_etu');
        $id_matiere = $this->input->post('id_matiere');
        $valeur = $this->input->post('valeur');

        $data = array(
            'num_etu' => $num_etu,
            'id_matiere' => $id_matiere,
            'valeur' => $valeur,
            'resultat' => $resultat,
            'date_session' => date('Y-m-d')
        );

        $this->Note_model->insert_note($data);
        redirect(site_url('admins/saisir_note'));
    }

    // Pour liste etudiants

    public function liste_etudiants()
    {
        $promotion = $this->input->get('promotion');
        $nom = $this->input->get('nom');

        $data['promotions'] = $this->Promotion_model->get_all_promotions();

        if ($promotion)
        {
            $data['etudiants'] = $this->Etudiant_model->get_etudiant_by_promotion($promotion);
        }
        elseif ($nom)
        {
            $data['etudiants'] = $this->Etudiant_model->get_etudiant_by_nom($nom);
        }
        else
        {
            $data['etudiants'] = $this->Etudiant_model->get_all_etudiants();
        }

        $this->load->view('admin/liste_etudiant_view', $data);
    }


    // Afficher liste semestres d'un etudiant selectionnée

    public function details_etudiant($num_etu, $unique_etu)
    {
        // Obtenir les informations de l'étudiant
        $data['etudiant'] = $this->Etudiant_model->get_etudiant_by_num_etu($num_etu);

        // Obtenir les semestres
        $semestres = $this->Etudiant_model->get_semestres();

        // Calculer la moyenne pour chaque semestre
        foreach ($semestres as $semestre)
        {
            $result = $this->Note_model->get_notes_par_semestre($semestre->id_semestre, $num_etu);
            $semestre->moyenne = $result['average'];
        
            if ($result['average'] < 10)
            {
                $semestre->deliberation = 'ajournee';
            }
            elseif ($result['average'] >= 10)
            {
                foreach ($result['notes'] as $r)
                {
                    if ($r->deliberation != 'ajournee')
                    {
                        $semestre->deliberation = 'valide';
                    }
                    else
                    {
                        $semestre->deliberation = 'ajournee';
                        break;
                    }
                }
            }

            // Obtenir le rang de l'étudiant pour ce semestre
            $semestre->rang = $this->get_rank_by_students($num_etu, $semestre->id_semestre);
        }

        // Calculer les rangs denses basés sur les moyennes (pour afficher le rang dense global, si nécessaire)
        $moyennes = array_map(function($semestre) {
            return $semestre->moyenne;
        }, $semestres);

        $rangs_dense = $this->get_dense_ranks($moyennes);

        // Associer les rangs denses aux semestres (si vous avez besoin d'un rang dense global)
        foreach ($semestres as $index => $semestre)
        {
            $semestre->rang_dense = $rangs_dense[$index];
        }

        // Assigner les semestres aux données
        $data['semestres'] = $semestres;

        // Charger la vue
        $this->load->view('admin/details_etudiant', $data);
    }

    public function get_rank_by_students($num_etu, $id_semestre)
    {
        // Obtenir les informations de l'étudiant actuel
        $etudiant = $this->Etudiant_model->get_etudiant_by_num_etu($num_etu);
    
        // Obtenir tous les étudiants de la même promotion
        $etudiants = $this->Etudiant_model->get_etudiantByIdProm($etudiant->id_promotion);

        // Initialiser un tableau pour stocker les moyennes des étudiants
        $moyennes = [];
        

        foreach ($etudiants as $student) {
            // Obtenir les notes pour chaque étudiant
            $resultat = $this->Note_model->get_notes_par_semestre($id_semestre, $student->num_etu);
        
            // Ajouter la moyenne à notre tableau
            $moyennes[$student->num_etu] = $resultat['average'];
        }

        // Calculer les rangs denses basés sur les moyennes
        $rangs_dense = $this->get_dense_ranks(array_values($moyennes));
        
        // Trouver le rang de l'étudiant actuel
        $etudiant_moyenne = $moyennes[$num_etu];
        $rang_etudiant = $rangs_dense[array_search($etudiant_moyenne, array_values($moyennes))];

        return $rang_etudiant;
    }

    private function get_dense_ranks($array) {
        // Cloner et trier les valeurs en ordre décroissant
        $sorted_array = $array;
        arsort($sorted_array);

        // Associer les rangs aux valeurs triées
        $ranks = [];
        $current_rank = 1;
        $previous_value = null;

        foreach ($sorted_array as $key => $value) {
            if ($value !== $previous_value) {
                $current_rank = $current_rank;
            }
            $ranks[$key] = $current_rank;
            $previous_value = $value;
            $current_rank++;
        }

        return $ranks;
    }

    public function dash()
    {
        // Récupération de tous les étudiants et semestres
        $etudiants = $this->Etudiant_model->get_all_etudiants();
        $semestres = $this->Etudiant_model->get_semestres();
    
        // Initialisation des variables de résultats
        $nbr_non_admis = 0;
    
        // Parcourir chaque étudiant
        foreach ($etudiants as $etudiant)
        {
            $admis = true; // Suppose que l'étudiant est admis par défaut
    
            // Parcourir chaque semestre pour chaque étudiant
            foreach ($semestres as $semestre)
            {
                $result = $this->Note_model->get_notes_par_semestre($semestre->id_semestre, $etudiant->num_etu);
    
                // Vérifier les notes pour le semestre en question
                foreach ($result['notes'] as $note)
                {
                    if ($note->deliberation == 'ajournee')
                    {
                        $nbr_non_admis += 1;
                        $admis = false; // Si une note est ajournée, l'étudiant n'est pas admis
                        break 2; // Sortir des deux boucles (pour le semestre et l'étudiant)
                    }
                }
            }
        }
    
        // Calcul des résultats totaux
        $resultat['nbr_total'] = count($etudiants);
        $resultat['nbr_valide'] = $resultat['nbr_total'] - $nbr_non_admis;
        $resultat['nbr_non_valide'] = $nbr_non_admis;

        $resultat['etudiants'] = $etudiants;
        $resultat['semestres'] = $semestres;
    
        // Charger la vue avec les résultats
        $this->load->view('admin/dash', $resultat);
    }
    

    // Afficher relevé de notes d'un semestre selectionnée
    public function releve_notes($num_etu, $unique_etu, $id_semestre)
    {
        //$data['matieres'] = $this->Matiere_model->get_matieres_par_semestre($id_semestre);
        // Fetch the semester information based on $id_semestre
        $semestre = $this->Note_model->get_semestre($id_semestre);
        $data = $this->Note_model->get_notes_par_semestre($id_semestre, $num_etu);
        $data['etudiant'] = $this->Etudiant_model->get_etudiant_by_num_etu($num_etu);
        $data['semestre'] = $semestre;
        $this->load->view('admin/releve_notes', $data);
    }

    // IMPORT
    public function redirect_import_config()
    {
        $this->load->view('admin/import_config');
    }

    public function redirect_import_note()
    {
        $this->load->view('admin/import_note');
    }

    public function upload_config()
    {
        $file = $_FILES['config'];
        $readed_file = fopen($file['tmp_name'], 'r');
        $header = fgetcsv($readed_file);
        $datas = [];
        $errors = [];
        $ligne = 0;
        $success = '';
        while ($line = fgetcsv($readed_file))
        {
            
            $ligne = $ligne + 1;
            try
            {
                $datas[] = $line;
                // var_dump($line);
            }
            catch (Exception $e)
            {
                $errors[] = "Une erreur s'est produite à la ligne " . $ligne ." : " . $e->getMessage();
            }
        }

        if( count($errors) == 0 )
        {
            $success = 'Import réussi';
            $response = $this->Admin_model->insert_config( $datas );
            if( $response != NULL && $response != '' )
            {
                $errors[] = $response;
                var_dump( $errors );
                $success = '';
            }

        }
        Redirect('admins/redirect_import_note');
    }

    public function upload_note()
    {
        $file = $_FILES['note'];
        $readed_file = fopen($file['tmp_name'], 'r');
        $header = fgetcsv($readed_file);
        $datas = [];
        $errors = [];
        $ligne = 0;
        $success = '';
        while ($line = fgetcsv($readed_file))
        {      
            $ligne = $ligne + 1;
            try
            {
                $datas[] = $line;
                // var_dump($line);
            }
            catch (Exception $e)
            {
                $errors[] = "Une erreur s'est produite à la ligne " . $ligne ." : " . $e->getMessage();
            }
        }

        if( count($errors) == 0 )
        {
            $success = 'Import réussi';
            $response = $this->Admin_model->import_into_temporary_note( $datas );
            if( $response != NULL && $response != '' )
            {
                $errors[] = $response;
                var_dump( $errors );
                $success = '';
            }

        }
        Redirect('admins/accueil');
    }

    // Pour lister etudiants par rang par semestre
    public function choisir_semestre_promotion()
    {
        $data['semestres'] = $this->Etudiant_model->get_all_semestres();
        //$data['promotions'] = $this->Promotion_model->get_all_promotions();
        $this->load->view('admin/choisir_semestre_promotion_view', $data);
    }

    public function etudiants_par_semestre_promotion()
    {
        $id_semestre = $this->input->get('semestre');

        // Obtenir tous les étudiants inscrits dans ce semestre
        $etudiants = $this->Etudiant_model->get_etudiants_par_semestre($id_semestre);
        // var_dump($etudiants);
        // Passer les données à la vue
        $data['etudiants'] = $etudiants;
        $data['semestre'] = $this->Etudiant_model->get_semestre($id_semestre);

        $this->load->view('admin/etudiants_par_semestre_promotion_view', $data);
    }

    public function liste_annee($num_etu)
    {
        $data['etudiant'] = $this->Etudiant_model->get_etudiant_by_num_etu($num_etu);
        $this->load->view('admin/liste_annee', $data);
    }
    
    public function annee_detail($num_etu, $level)
    {
        // Get the year information based on the level
        $annee = $this->Annee_model->get_annee_by_level($level);

        // Get semesters for the given year
        $semestres = $this->Semestre_model->get_semestres_by_annee($level);

        $data['etudiant'] = $this->Etudiant_model->get_etudiant_by_num_etu($num_etu);
        
        // Ensure that we have the expected two semesters for the year
        if (count($semestres) == 2) {
            $data['semestre1'] = $this->Note_model->get_notes_par_semestre($semestres[0]->id_semestre, $num_etu);
            $data['semestre2'] = $this->Note_model->get_notes_par_semestre($semestres[1]->id_semestre, $num_etu);

            $data['moyenne_generale_annee'] = ($data['semestre1']['average'] + $data['semestre2']['average']) / 2;

            $this->load->view('admin/annee_detail', $data);
        } else {
            show_error('Invalid semester data for the selected year.');
        }
    }


    // Modifier la valeur d'une config

    public function modifier_config()
    {
        // Charger les configurations disponibles depuis la table configuration_note
        $data['configurations'] = $this->Configuration_model->get_all_configurations();

        // Charger la vue avec les données
        $this->load->view('admin/modifier_valeur_conf', $data);
    }

    public function modifier_valeur_config()
    {
        $code = $this->input->post('code');
        $new_valeur = $this->input->post('valeur');
    
        $result = $this->Configuration_model->modifier_valeur_config($code, $new_valeur);
    
        if ($result > 0)
        {
            $this->session->set_flashdata('success', 'La valeur a été modifiée avec succès.');
        }
        else
        {
            $this->session->set_flashdata('error', 'Aucune modification effectuée.');
        }
    
        redirect('admins/modifier_config');
    }
    
    public function saisir_note_prom()
    {
        $data['matieres'] = $this->Matiere_model->get_matieres();
        $data['promotions'] = $this->Promotion_model->get_all_promotions();
        
        $this->load->view('admin/saisir_note_prom', $data);
    }

    public function inserer_note_prom()
    {
        echo 'mandalo';
        $id_promotion = $this->input->post('id_promotion');
        $id_matiere = $this->input->post('id_matiere');
        $valeur = $this->input->post('valeur');
        $result = '';
        
        // Fetch all students in the given promotion
        $etudiants = $this->Etudiant_model->get_etudiants_by_idpromotion($id_promotion);
        
        var_dump($etudiants);
        foreach ($etudiants as $etudiant) {
            $data = array(
                'num_etu' => $etudiant->num_etu,
                'id_matiere' => $id_matiere,
                'valeur' => $valeur,
                'resultat' => $result,
                'date_session' => date('Y-m-d')
            );

            var_dump($data);

            $this->Note_model->insert_note($data);
        }


        redirect('admins/saisir_note_prom');
    }

    public function releve_notes_categorie($id_semestre, $num_etu)
    {
        // Retrieve notes by semester and student
        $notes_data = $this->Note_model->get_notes_par_semestre($id_semestre, $num_etu);

        $notes = $notes_data['notes'];

        // Initialize categories
        $categories = [
            'Informatique' => [],
            'Mathematique' => [],
            'Ouverture' => [],
        ];

        // Categorize the notes
        foreach ($notes as $note) {
            if (strpos($note->code_matiere, 'INF') === 0) {
                $categories['Informatique'][] = $note;
            } elseif (strpos($note->code_matiere, 'MTH') === 0) {
                $categories['Mathematique'][] = $note;
            } else {
                $categories['Ouverture'][] = $note;
            }
        }

        // Calculate averages for each category
        $averages = [];
        foreach ($categories as $category => $category_notes) {
            $averages[$category] = $this->Note_model->moyenne_note($category_notes);
        }

        // Pass data to the view
        $data = [
            'categories' => $categories,
            'averages' => $averages,
            'total_credits' => $notes_data['total_credits'],
            'average' => $notes_data['average']
        ];

        $this->load->view('admin/releve_notes_categorie', $data);
    }



}

?>