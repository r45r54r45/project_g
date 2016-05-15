<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reply extends CI_Controller {
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
}
