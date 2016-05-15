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
		if($uid=$this->input->cookie('auto_login',TRUE)){
			// echo "autologined";
			$this->session->set_userdata("uid",str_replace( "\"","",$uid));
		}else{
			//no autologin
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
		$this->load->model('gdata');
		$PID_info=$this->gdata->get_PID_by_info($v1,urldecode($v2));
		$data['pid']=$PID_info->pid;
		$data['ssname']=$PID_info->ss_name_kor;
		$this->load->view('header');
		$this->load->view('person',$data);
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
		$this->load->model('vote');
		$SS= $this->vote->getSSByEng($v1);
		$data['target']=$SS->NAME_KOR;
		$data['ssid']=$SS->SSID;
		$this->load->view('header');
		$this->load->view('ranking_small',$data);
	}
	public function ranking_sitemap()
	{
		$this->load->view('header');
		$this->load->view('ranking_sitemap');
	}


}
