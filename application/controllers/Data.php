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
	public function get_random_2($ssid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_random_2($ssid));
	}
	public function get_result_stat(){
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$this->load->model('vote');
		echo json_encode($this->vote->get_result_stat($request));
	}
	public function get_ssid_info($ssid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_ssid_info($ssid));
	}
	public function get_random_ssid_all(){
		$this->load->model('vote');
		echo json_encode($this->vote->get_random_ssid_all());
	}
}
