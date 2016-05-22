<?php

class User extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function addUser($req){
    @$loc=mysql_escape_string($req->loc);
    @$pw=mysql_escape_string($req->pw);
    $this->db->query("insert into USER (NAME,PASSWORD,AGE,SEX,LOC) values ('$req->name','$pw','$req->age','$req->sex','$loc')");
    return $this->db->query("select UID from USER order by UID desc limit 1")->row();
  }
  public function isUser($name){
    $query=$this->db->query("select * from USER where NAME='$name' and QUIT='0'");
    return $query->num_rows();
  }
  public function login($name,$password){
    $query=$this->db->query("select * from USER where NAME='$name' and PASSWORD='$password' and QUIT='0'");
    return $query->row();
  }
  public function getUser($UID){
    $query=$this->db->query("select * from USER where UID='$UID'");
    return $query->row();
  }
  public function exit_user($uid){
    $this->db->query("update USER set QUIT=1 where UID='$uid' ");
  }
  public function get_all_user(){
    $query=$this->db->query("select * from USER where QUIT='0'");
    return $query->result_array();
  }
}
