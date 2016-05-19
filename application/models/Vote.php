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
    return $this->db->query("select * from SMALL_SUBJECT ss where (select count(*) from PERSON p where p.SSID =ss.SSID)>2 and MENU_CHECK='1' ")->result();
  }
  public function get_people($ssid){
    return $this->db->query("select PID,SSID,NAME,PROFILE from PERSON where SSID='$ssid'")->result();
  }
  public function get_all_people_name(){
    return $this->db->query("select p.NAME, ss.NAME_ENG from PERSON p join SMALL_SUBJECT ss on ss.SSID=p.SSID ")->result_array();
  }
  public function add_person($req){
    return $this->db->query("insert into PERSON (SSID,NAME,URL,PROFILE) values ('$req->ssid','$req->name','$req->url_address','$req->profile')")->result();
  }
  public function get_random_ssid(){
    return $this->db->query("select ss.SSID from SMALL_SUBJECT ss where MENU_CHECK=1 and (select count(*) from PERSON p where p.SSID =ss.SSID)>2 order by rand()  limit 1")->row();
  }
  public function get_random_ssid_all(){
    return $this->db->query("select ss.SSID from SMALL_SUBJECT ss where (select count(*) from PERSON p where p.SSID =ss.SSID)>2 order by rand() limit 1")->row();
  }
  public function get_ssid_info($ssid){
    return $this->db->query("select * from SMALL_SUBJECT where SSID='$ssid'")->row();
  }
  public function get_random_2($ssid){
    return $this->db->query("select PID,NAME from PERSON where SSID='$ssid' order by rand() limit 2")->result_array();
  }
  public function add_vote_result($req){
    return $this->db->query("insert into VOTE_RESULT (UID,LID,SSID,PID1,PID2,RESULT) values ('$req->uid','$req->lid','$req->ssid','$req->pid1','$req->pid2','$req->result')");
  }
  public function get_result_stat($req){
    return $this->db->query("select round((select count(*) from VOTE_RESULT where PID1='$req->pid1' and PID2='$req->pid2' and RESULT='$req->result')/count(*)*100) as PERCENTAGE  from VOTE_RESULT where PID1='$req->pid1' and PID2='$req->pid2'")->row();
  }
  public function get_all_rank($start){
    return $this->db->query("select ss.NAME_KOR as ss_name, ss.NAME_ENG as ss_eng, p1.PID as pid, p1.NAME as name,  (select count(*) from PERSON p2 where p2.TOTAL > p1.TOTAL)+1 as all_rank, (select count(*) from PERSON p2 where p1.SSID=p2.SSID and p2.TOTAL > p1.TOTAL)+1 as ss_rank from PERSON p1 join SMALL_SUBJECT ss on ss.SSID=p1.SSID order by TOTAL desc limit $start , 20")->result_array();
  }
  public function get_ss_rank($ss,$start){
    return $this->db->query("
    select ss.NAME_KOR as ss_name, ss.NAME_ENG as ss_eng, p1.PID as pid, p1.NAME as name,
     (select count(*) from PERSON p2 where p2.TOTAL > p1.TOTAL)+1
      as all_rank,
      (select count(*) from PERSON p2 where p1.SSID=p2.SSID and p2.SSID='$ss' and p2.TOTAL > p1.TOTAL)+1 as ss_rank
       from PERSON p1
       join SMALL_SUBJECT ss on ss.SSID=p1.SSID
       where p1.SSID='$ss'
       order by TOTAL desc limit $start , 20")->result_array();
  }
  public function getSSByEng($eng){
    return $this->db->query("select * from SMALL_SUBJECT where NAME_ENG='$eng'")->row();
  }
  public function add_to_total($pid,$amount){
    return $this->db->query("update PERSON set TOTAL=TOTAL+$amount where PID='$pid'");
  }
  public function minus_to_total($pid,$amount){
    return $this->db->query("update PERSON set TOTAL=TOTAL-$amount where PID='$pid'");
  }
  public function give_donation($request){
    return $this->db->query("insert into DONATION (UID,PID,POINT,PLUS) values ('$request->uid','$request->pid','$request->point',$request->plus)");
  }
  public function get_bs_ss(){
    return $this->db->query("select * from SMALL_SUBJECT ss join BIG_SUBJECT bs on ss.BSID=bs.BSID  ")->result_array();
  }
  public function get_bs_byorder(){
    return $this->db->query("select * from BIG_SUBJECT order by ORDERING")->result_array();
  }
  public function get_ss_byorder($bsid){
      return $this->db->query("select * from SMALL_SUBJECT where BSID='$bsid' order by ORDERING")->result_array();
  }
  public function get_person_rank($pid){
    return $this->db->query("select count(*)+1 as total_rank, (select count(*)+1 as ss_rank from PERSON where (select TOTAL from PERSON where PID = '$pid')<TOTAL and SSID=(select SSID from PERSON where PID = '$pid')) as ss_rank from PERSON where (select TOTAL from PERSON where PID = '$pid')<TOTAL")->row();
  }
  public function get_stat_by_info($req){
    return $this->db->query("select count(*) as win, (select count(*) from (select PID1,PID2,RESULT from VOTE_RESULT vr join USER u on vr.UID=u.UID where u.AGE like '%$req->age%' and u.SEX like '%$req->sex%' and u.LOC like '%$req->loc%' and vr.UID!='0') vr2 where (vr2.PID1='$req->pid' or vr2.PID2='$req->pid') and vr2.RESULT!='$req->pid') as lose from (select PID1, PID2, RESULT from VOTE_RESULT vr join USER u on vr.UID=u.UID where u.AGE like '%$req->age%' and u.SEX like '%$req->sex%' and u.LOC like '%$req->loc%' and vr.UID!='0') vr2 where (vr2.PID1='$req->pid' and vr2.RESULT='$req->pid') or (vr2.PID2='$req->pid' and  vr2.RESULT='$req->pid')")->row();
  }

}
