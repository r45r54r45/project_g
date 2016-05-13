<?php

class Gdata extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function add_notice($req){
    $this->db->query("insert into NOTICE (TITLE,BODY) values ('$req->title','$req->body')");
  }
  public function get_notice(){
    return $this->db->query("select * from NOTICE")->result();
  }
  public function get_auth_profile($pid){
    return $this->db->query("select d.UID as uid,u.NAME as name from DONATION d join USER u on u.UID=d.UID where DATE_ADD(CURRENT_DATE() ,INTERVAL -(DAYOFWEEK(CURRENT_DATE( ) )-1) day)<TIME and PID='$pid' order by POINT desc limit 1")->row();
  }
  public function get_PID_by_info($SS_ENG,$PNAME){
    return $this->db->query("select p.PID as pid, ss.NAME_KOR as ss_name_kor from PERSON p join SMALL_SUBJECT ss on ss.SSID=p.SSID where ss.NAME_ENG='$SS_ENG' and p.NAME='$PNAME'")->row();
  }

  }
