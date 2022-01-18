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
        $this->load->view('script-header');  // load script css
		$this->load->view('header'); // render navbar
		$this->load->view('siderbar-menu'); // donut
		$this->load->view('banner'); // home banner
        $this->load->view('home');  // reder content
		$this->load->view('footer');
        $this->load->view('script-footer'); // load script js
    }
}
