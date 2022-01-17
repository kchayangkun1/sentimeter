<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation'); 
	}
    
	public function index()
    {   
        $this->load->view('Contact');  // load script css
        $this->load->view('home');  // reder content
        $this->load->view('Contact'); // load script js
    }
}
