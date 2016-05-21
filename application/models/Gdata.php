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
    // return $this->db->query("select PROFILE as profile, USER_ASSESS as user_assess, u.NAME as name from PERSON p join USER u on p.USER_ASSESS_USER=u.UID where p.PID='$pid' ")->row();
    return $this->db->query("select PROFILE as profile, USER_ASSESS as user_assess, u.NAME as name from PERSON p left outer join USER u on p.USER_ASSESS_USER=u.UID where p.PID='$pid' ")->row();
  }
  public function update_user_assess($req){
    return $this->db->query("update PERSON set USER_ASSESS='$req->assess' ,USER_ASSESS_USER = '$req->uid' where PID='$req->pid'");
  }
  public function get_user_info($uid){
    return $this->db->query("select NAME, TIME from USER where UID='$uid'")->row();
  }
  public function get_reply_count($uid){
    return $this->db->query("select count(*) as count from REPLY where UID='$uid'")->row();
  }
  public function get_user_by_rid($rid){
    return $this->db->query("select * from REPLY where RID='$rid'")->row();
  }
  public function get_person_info($pid){
    return $this->db->query("select p.NAME as name, ss.NAME_ENG as small_subject from PERSON p join SMALL_SUBJECT ss on p.SSID=ss.SSID where p.PID='$pid'")->row();
  }
  public function add_help($req){
    return $this->db->query("insert into HELP (PASSWORD,TITLE, BODY) values('$req->PASSWORD','$req->TITLE','$req->BODY')");
  }
  public function add_response($req){
    return $this->db->query("update HELP set RESPONSE='$req->RESPONSE' where HID='$req->HID'");
  }
  public function get_help(){
    return $this->db->query("select * from HELP")->result_array();
  }
  public function reset_person($pid){
    $this->db->query("update PERSON set TOTAL=0 where PID='$pid' ");
    $this->db->query("delete from VOTE_RESULT where PID1='$pid' or PID2='$pid'");
  }
  public function edit_ss($req){
    $this->db->query("update SMALL_SUBJECT set NAME_KOR='$req->name_kor', NAME_ENG='$req->name_eng' where SSID='$req->ssid'");
  }
  public function edit_bs($req){
    $this->db->query("update BIG_SUBJECT set NAME='$req->name' where BSID='$req->bsid'");
  }
  public function edit_person($req){
    $this->db->query("update PERSON set NAME='$req->name', PROFILE='$req->profile' where PID='$req->pid'");
  }
  public function delete_person($pid){
    $this->db->query("delete from PERSON where PID='$pid'");
  }
  public function get_recent_reply_by_ssid($ssid){
    return $this->db->query("select RID as rid, r.PID as pid, p.NAME as pname, ss.NAME_ENG as ss_name from REPLY r join PERSON p on p.PID=r.PID
    join SMALL_SUBJECT ss on ss.SSID=p.SSID where r.PRID=0 and r.PID in (select distinct PID from PERSON where SSID='$ssid') order by r.TIME desc limit 0,15")->result_array();
  }
  public function get_ssinfo_with_rid($rid){
    return $this->db->query("select p.NAME as pname, ss.NAME_ENG as ss_name, r.PID as pid from REPLY r join PERSON p on p.PID=r.PID
    join SMALL_SUBJECT ss on ss.SSID=p.SSID
    where r.RID='$rid'
    limit 1")->row();
  }
  }
