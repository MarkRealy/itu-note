<?php

class Etudiants extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Matiere_model');
        $this->load->model('Note_model');
        $this->load->model('Etudiant_model');
        $this->load->model('Promotion_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('etudiant/dashboard_view');
    }

    public function login()
    {
        $this->load->view('etudiant/login_view');
    }

    public function do_login()
    {
        $unique_etu = $this->input->post('unique_etu');

        $etudiant = $this->Etudiant_model->check_user($unique_etu);
        if ($etudiant)
        {
            
            $this->session->set_userdata('unique_etu', $etudiant);
            redirect('etudiants/accueil');
        }
        else
        {
            $this->session->set_flashdata('error', 'Invalid login credentials.');
            redirect('etudiants/login');
        }        
    }

    public function accueil()
    {
        $this->load->view('etudiant/accueil');
    }

    public function logout()
    {
        // Déconnecter l'utilisateur
        $this->session->sess_destroy();

        // Rediriger vers la page de login (ou une autre page si nécessaire)
        redirect('etudiants/login'); // Assurez-vous que 'login' correspond à l'URL de votre page de login
    }

    public function liste_semestre()
    {
        $unique_etu = $this->session->userdata('unique_etu');
        // var_dump($unique_etu);
        $semestres = $this->Etudiant_model->get_semestres();
        foreach ($semestres as $semestre)
        {
            // var_dump($unique_etu['num_etu']);
            $result = $this->Note_model->get_notes_par_semestre($semestre->id_semestre, $unique_etu['num_etu']);
            $semestre->moyenne = $result['average'];
        }
        $data['semestres'] = $semestres;
        $this->load->view('etudiant/liste_semestre', $data);
    }

    public function releve_notes($id_semestre)
    {
        $num_etu = $this->session->userdata('unique_etu');
        $data = $this->Note_model->get_notes_par_semestre($id_semestre, $num_etu['num_etu']);
        $data['etudiant'] = $this->Etudiant_model->get_etudiant_by_num_etu($num_etu['num_etu']);
        // var_dump($data);
        $this->load->view('etudiant/releve_notes', $data);
    }

    public function rattrapage()
    {
        $unique_etu = $this->session->userdata('unique_etu');
        $semestres = $this->Etudiant_model->get_semestres();
        $data['semestres'] = $semestres;
        $this->load->view('etudiant/rattrapage', $data);
    }

    public function liste_rattrapage($id_semestre)
    {
        $unique_etu = $this->session->userdata('unique_etu');
        $notes = $this->Note_model->get_notes_par_semestre($id_semestre, $unique_etu['num_etu']);
        $rattrapage = [];
        $count = 0;
        // Parcourir toutes les notes du semestre
        foreach ($notes['notes'] as $note)
        {
            // Vérifier si la valeur de la note est inférieure à 10
            if ($note->valeur < 10)
            {
                // Ajouter la note au tableau rattrapage
                $rattrapage[] = $note;
                $count++;
            }
        }

        $data['rattrapage'] = $rattrapage;
        $data['count'] = $count;
        $data['vola'] = 25000;
        $this->load->view('etudiant/liste_rattrapage', $data);
    }
}

?>