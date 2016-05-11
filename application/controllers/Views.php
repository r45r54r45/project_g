<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('cookie');
	}
	public function index(){
		// echo $this->session->userdata('uid');
		// echo $this->session->userdata('name');
		// set_cookie('c_test',1,0);
		// echo get_cookie('c_test');
		if($uid=$this->input->cookie('auto_login',TRUE)){
			$this->session->set_userdata("uid",$uid);
		}
		$this->load->model('vote');
		if(!isset($_GET['ssid'])){
			$ssid=$this->vote->get_random_ssid()->SSID;
		}else {
			$ssid=$_GET['ssid'];
		}
		$data['ssid']=$ssid;
		$randResult=$this->vote->get_random_2($ssid);
		$data['left']=$randResult[0];
		$data['right']=$randResult[1];
		$this->load->view('header');
		$this->load->view('vote',$data);
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
