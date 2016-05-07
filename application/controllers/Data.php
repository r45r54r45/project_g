<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	 public function searchName(){
		 header('Content-Type: application/json');
		 $arr=["France","김우현","Germany","fff"];
		 echo json_encode($arr);
	 }
}
