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


  }
