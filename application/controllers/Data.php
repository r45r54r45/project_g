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
	public function get_people_pid($ssid){
		$this->load->model('vote');
		echo json_encode($this->vote->get_people_pid($ssid));
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
	public function add_help(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->add_help($req);
	}
	public function add_response(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->add_response($req);
	}
	public function get_help(){
		$this->load->model('gdata');
		$data['data']=$this->gdata->get_help();
		echo json_encode($data);
	}
	public function remove_person($pid){

	}
	public function reset_person($pid){
		$this->load->model('gdata');
		$this->gdata->reset_person($pid);
	}
	public function edit_ss(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->edit_ss($req);
	}
	public function edit_bs(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->edit_bs($req);
	}
	public function edit_person(){
		$postdata = file_get_contents("php://input");
		$req = json_decode($postdata);
		$this->load->model('gdata');
		$this->gdata->edit_person($req);
	}
	public function delete_person($pid){
		$this->load->model('gdata');
		$this->gdata->delete_person($pid);
	}
	public function get_recent_reply_by_ssid($ssid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_recent_reply_by_ssid($ssid));
	}
	public function get_ssinfo_with_rid($rid){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_ssinfo_with_rid($rid));
	}
	public function get_loc(){
		$this->load->model('gdata');
		echo json_encode($this->gdata->get_loc());
	}
	public function change_order_ss($ssid,$order){
		$this->load->model('gdata');
		$this->gdata->change_order_ss($ssid,$order);
	}
	public function change_order_bs($bsid,$order){
		$this->load->model('gdata');
		$this->gdata->change_order_bs($bsid,$order);
	}
	public function get_all_reply(){
		$this->load->model('gdata');
		$res=$this->gdata->get_all_reply();
		$params = array('baseURI' => 'https://projectg2016.firebaseio.com/', 'token' => 'kKe9WUIprBBZrkacyQ2hfRn7hAre8ZH9Svd0Brym');
		$this->load->library('firebaseLib',$params);

		for($i=0; $i<count($res); $i++){
			$res[$i]['reply_data']=$this->firebaselib->get("/reply/".$res[$i]['pid']."/".$res[$i]['rid']."/data");
		}

		$result['data']=$res;
		echo json_encode($result);
	}
	public function get_all_user(){
		$this->load->model('user');
		$params = array('baseURI' => 'https://projectg2016.firebaseio.com/', 'token' => 'kKe9WUIprBBZrkacyQ2hfRn7hAre8ZH9Svd0Brym');
		$this->load->library('firebaseLib',$params);
		$res=$this->user->get_all_user();
		$level_array=array(100,200,300,400,500,600,700,800,900,1000,1200,1400,1600,1800,2000,2200,2400,2600,2800,3000,3300,3600,3900,4200,4500,4800,5100,5400,5700,6000,6400,6800,7200,7600,8000,8400,8800,9200,9600,10000,10500,11000,11500,12000,12500,13000,13500,14000,14500,15000,15600,16200,16800,17400,18000,18600,19200,19800,20400,21000,21700,22400,23100,23800,24500,25200,25900,26600,27300,28000,28800,29600,30400,31200,32000,32800,33600,34400,35200,36000,36900,37800,38700,39600,40500,41400,42300,43200,44100,45000,46000,47000,48000,49000,50000,51000,52000,53000,54000);

		for($i=0; $i<count($res); $i++){
			$res[$i]['VOTE_POINT']=floor($this->firebaselib->get("/user/".$res[$i]['UID']."/vote_point"));
			$res[$i]['LEVEL_POINT']=floor($this->firebaselib->get("/user/".$res[$i]['UID']."/level_point"));
			$res[$i]['LEVEL']=array_search($this->findNearest($res[$i]['LEVEL_POINT'],$level_array),$level_array);
		}

		$result['data']=$res;
		echo json_encode($result);
	}
	public function findNearest($number,$Array)
	{
    //First check if we have an exact number
    if(false !== ($exact = array_search($number,$Array)))
    {
         return $Array[$exact];
    }

    //Sort the array
    // sort($Array);

   //make sure our search is greater then the smallest value
   if ($number < $Array[0] )
   {
       return $Array[0];
   }

    $closest = $Array[0]; //Set the closest to the lowest number to start

    foreach($Array as $value)
    {
        // if(abs($number - $closest) > abs($value - $number))
				if($number>$closest)
        {
            $closest = $value;
        }
    }

    return $closest;
}
}
