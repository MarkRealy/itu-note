<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

	public function index()
	{
		$this->load->view('home');
	}	
}
