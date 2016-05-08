<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	public function searchName(){
		header('Content-Type: application/json');
		$arr=["France","김우현","Germany","fff"];
		echo json_encode($arr);
	}
	public function get_big_subjects(){
		$this->load->model('vote');
		echo json_encode($this->vote->get_big_subjects());
	}
	public function get_small_subjects($bsid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_small_subjects($bsid));
	}
	public function get_vote_menu(){
		$this->load->model('vote');
		echo json_encode($this->vote->get_vote_menu());
	}
	public function get_people($ssid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_people($ssid));
	}
	public function get_notice(){
		$this->load->model('gdata');
		header('Content-Type: application/json');
		$result['data']=$this->gdata->get_notice();
		echo json_encode($result);
	}
}
