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
    return $this->db->query("select d.UID as uid,u.NAME as name from DONATION d join USER u on u.UID=d.UID where DATE_SUB(CURRENT_DATE() ,INTERVAL weekday(now()) day) <d.TIME and PID='$pid' order by POINT desc limit 1")->row();
  }
  public function get_PID_by_info($SS_ENG,$PNAME){
    return $this->db->query("select p.PID as pid, ss.NAME_KOR as ss_name_kor from PERSON p join SMALL_SUBJECT ss on ss.SSID=p.SSID where ss.NAME_ENG='$SS_ENG' and p.NAME='$PNAME'")->row();
  }
  public function get_profile($pid){
    return $this->db->query("select PROFILE as profile, USER_ASSESS as user_assess, u.NAME as name from PERSON p join USER u on p.USER_ASSESS_USER=u.UID where p.PID='$pid' ")->row();
  }
  public function update_user_assess($req){
    return $this->db->query("update PERSON set USER_ASSESS='$req->assess' ,USER_ASSESS_USER = '$req->uid' where PID='$req->pid'");
  }
  public function get_user_info($uid){
    return $this->db->query("select NAME, TIME from USER where UID='$uid'")->row();
  }

  }
