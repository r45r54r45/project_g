<?php

class M_reply extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function insert_reply($req){
    $this->db->trans_start();
    $this->db->query("insert into REPLY (PID, PRID, UID) values ('$req->pid','$req->prid','$req->uid')");
    $result=$this->db->query("select NAME, PID, RID, PRID from REPLY r join USER u on r.UID=u.UID order by RID desc limit 1");
    $this->db->trans_complete();
    return $result->row();
  }
  public function boomUpDown($req){
    return $this->db->query("update REPLY set UP=UP+$req->up, DOWN=DOWN+$req->down where RID='$req->rid'");
  }
  public function getBest($pid){
    return $this->db->query("select *,r.TIME as time from REPLY r join USER u on r.UID=u.UID where PID='$pid' and UP>DOWN and if(hour(now())<12,date_add(date_sub(curdate(),interval 1 day),interval 12 hour),date_add(curdate(),interval 12 hour))<r.TIME  and r.PRID='0' order by UP+DOWN desc limit 5")->result_array();
  }
  public function add_child_reply($req){
    $this->db->trans_start();
    $this->db->query("insert into REPLY (PID, PRID, UID) values ('$req->pid','$req->prid','$req->uid')");
    $result=$this->db->query("select NAME,PID, RID, PRID from REPLY r join USER u on r.UID=u.UID order by RID desc limit 1");
    $this->db->trans_complete();
    return $result->row();
  }
}
