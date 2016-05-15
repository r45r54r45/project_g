<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Func extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('cookie');
	}
	public function join_func(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('user');
		echo json_encode($this->user->addUser($req));
	}
	public function name_check($name){
		$this->load->model('user');
		$result=$this->user->isUser($name);
		$data['result']=($result==1?false:true);
		echo json_encode($data);
	}
	public function login_data_func($name,$password){
		$this->load->model('user');
		$data=$this->user->login(urldecode($name),$password);
		echo json_encode($data);
	}
	public function login_func($UID){
		$this->session->set_userdata("uid",$UID);
		$this->load->model('user');
		$data=$this->user->getUser($UID);
		$this->session->set_userdata("name",$data->NAME);
		redirect('/');
	}
	public function add_big_subject($name){
		$this->load->model('vote');
		$this->vote->add_big_subject(urldecode($name));
	}
	public function add_small_subject($bsid, $name_kor, $name_eng, $check){
		$this->load->model('vote');
		$this->vote->add_small_subject($bsid, urldecode($name_kor), $name_eng,$check);
	}
	public function add_person(){
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$this->load->model('vote');
		$this->vote->add_person($request);
	}
	public function add_notice(){
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->add_notice($request);
	}
	public function add_vote_result(){
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$this->load->model('vote');
		$this->vote->add_vote_result($request);
	}
	public function fume()
	{
		$this->load->view('capstone');
	}
}
