<?php

class User extends CI_Model{
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
  public function isUser($name){
    $query=$this->db->query("select * from USER where NAME='$name'");
    return $query->num_rows();
  }
  public function login($name,$password){
    $query=$this->db->query("select * from USER where NAME='$name' and PASSWORD='$password'");
    return $query->row();
  }
  public function getUser($UID){
    $query=$this->db->query("select * from USER where UID='$UID'");
    return $query->row();
  }

}
