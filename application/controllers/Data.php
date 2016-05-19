<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	public function searchName(){
		// header('Content-Type: application/json');
		// $arr=["France","김우현","Germany","fff"];
		// echo json_encode($arr);
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
	public function get_all_people_name(){
		$this->load->model('vote');
		echo json_encode($this->vote->get_all_people_name());
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
	public function get_all_rank($from){
		$this->load->model('vote');
		echo json_encode($this->vote->get_all_rank($from));
	}
	public function get_ss_rank($ss,$from){
		$this->load->model('vote');
		echo json_encode($this->vote->get_ss_rank($ss,$from));
	}
	public function get_person_rank($pid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_person_rank($pid));
	}
	public function add_to_total($pid,$amount){
		$this->load->model('vote');
		$this->vote->add_to_total($pid,$amount);
	}
	public function minus_to_total($pid,$amount){
		$this->load->model('vote');
		$this->vote->minus_to_total($pid,$amount);
	}
	public function give_donation(){
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$this->load->model('vote');
		echo json_encode($this->vote->give_donation($request));
	}
	public function get_auth_profile($pid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_auth_profile($pid));
	}
	public function get_bs_byorder(){
		$this->load->model('vote');
		echo json_encode($this->vote->get_bs_byorder());
	}
	public function get_ss_byorder($bsid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_ss_byorder($bsid));
	}
	public function get_stat_by_info(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('vote');
		echo json_encode($this->vote->get_stat_by_info($req));
	}
	public function get_profile($pid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_profile($pid));
	}
	public function update_user_assess(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->update_user_assess($req);
	}
	public function get_user_info($uid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_user_info($uid));
	}
	public function get_user_info_with_index($uid,$idx){
		$this->load->model('gdata');
		$result=$this->gdata->get_user_info($uid);
		$result->index=$idx;
		echo json_encode($result);
	}
	public function get_reply_count($uid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_reply_count($uid));
	}
	public function get_user_by_rid($rid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_user_by_rid($rid));
	}
}
