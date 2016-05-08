<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {
	public function __construct(){
		parent::__construct();
		session_start();
		$this->load->helper('url');
	}
	public function index(){
		echo $_SESSION['uid'];
		$this->load->view('header');
		$this->load->view('vote');

	}
	public function join()
	{
		$this->load->view('header');
		$this->load->view('join');
	}
	public function notice()
	{
		$this->load->view('header');
		$this->load->view('notice');
	}
	public function help()
	{
		$this->load->view('header');
		$this->load->view('help');
	}
	public function admin()
	{
		$this->load->view('header');
		$this->load->view('admin/admin');
	}
	public function person($v1,$v2)
	{
		$this->load->view('header');
		$this->load->view('person');
	}
	public function sitemap()
	{
		$this->load->view('header');
		$this->load->view('sitemap');
	}
	public function ranking_all()
	{
		$this->load->view('header');
		$this->load->view('ranking_all');
	}
	public function ranking_small($v1)
	{
		$data['target']=urldecode($v1);
		$this->load->view('header');
		$this->load->view('ranking_small',$data);
	}
	public function ranking_sitemap()
	{
		$this->load->view('header');
		$this->load->view('ranking_sitemap');
	}

}
