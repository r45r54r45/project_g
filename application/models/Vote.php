<?php

class Vote extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function addUser($name,$password){
    $data = array(
      'NAME' => $name,
      'PASSWORD' => $password
    );
    $this->db->trans_start();
    $this->db->insert('USER', $data);
    $result=$this->db->query('select * from USER order by UID desc limit 1');
    $this->db->trans_complete();
    return $result->row();
  }
  public function add_big_subject($name){
    $this->db->query("insert into BIG_SUBJECT (NAME) values  ('$name')");
  }
  public function add_small_subject($bsid,$name_kor,$name_eng,$check){
    $this->db->query("insert into SMALL_SUBJECT (BSID,NAME_KOR,NAME_ENG,MENU_CHECK) values  ($bsid,'$name_kor','$name_eng',$check)");
  }
  public function get_big_subjects(){
    return $this->db->query("select * from BIG_SUBJECT")->result();
  }
  public function get_small_subjects($bsid){
    return $this->db->query("select * from SMALL_SUBJECT where BSID='$bsid'")->result();
  }
  public function get_vote_menu(){
    return $this->db->query("select * from SMALL_SUBJECT where MENU_CHECK='1'")->result();
  }
  public function get_people($ssid){
    return $this->db->query("select * from PERSON where SSID='$ssid'")->result();
  }
  public function add_person($req){
    return $this->db->query("insert into PERSON (SSID,NAME,URL,PROFILE) values ('$req->ssid','$req->name','$req->url_address','$req->profile')")->result();
  }
}
