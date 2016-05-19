<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reply extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}
	public function insert_reply(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('m_reply');
		echo json_encode($this->m_reply->insert_reply($req));
	}
	public function boomUpDown(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('m_reply');
		echo json_encode($this->m_reply->boomUpDown($req));
	}
	public function getBest($pid){
		$this->load->model('m_reply');
		echo json_encode($this->m_reply->getBest($pid));
	}
	public function add_child_reply(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('m_reply');
		echo json_encode($this->m_reply->add_child_reply($req));
	}
	public function alarm(){
		$pid=$this->input->get('pid');
		$rid=$this->input->get('rid');
		$this->load->model('gdata');
		$result=$this->gdata->get_person_info($pid);
		$name=$result->name;
		$subject=$result->small_subject;
		redirect('/'.$subject."/".$name);
	}
}
