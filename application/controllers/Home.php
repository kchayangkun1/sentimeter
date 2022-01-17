<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation'); 
	}
    
	public function index()
    {   
        $this->load->view('script-header');
        $this->load->view('home');
        $this->load->view('script-footer');
    }
}
