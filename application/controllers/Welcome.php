<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function index(){
		 $this->load->view('header');
		 $this->load->view('vote');

	 }
	public function fuck($v1,$v2)
	{

		echo $v1."<br>";
		echo $v2;
	}
	public function test()
	{
		$this->load->view('test');
	}
	public function join()
	{
		$this->load->view('header');
		$this->load->view('join');
	}
	public function notice()
	{
		$this->load->view('header');
		$this->load->view('notice');
	}
	public function help()
	{
		$this->load->view('header');
		$this->load->view('help');
	}
	public function admin()
	{
		$this->load->view('header');
		$this->load->view('admin/admin');
	}
	public function person($v1,$v2)
	{
		$this->load->view('header');
		$this->load->view('person');
	}
	public function sitemap()
	{
		$this->load->view('header');
		$this->load->view('sitemap');
	}
	public function ranking_all()
	{
		$this->load->view('header');
		$this->load->view('ranking_all');
	}
	public function ranking_small($v1)
	{
		$data['target']=urldecode($v1);
		$this->load->view('header');
		$this->load->view('ranking_small',$data);
	}
	public function ranking_sitemap()
	{
		$this->load->view('header');
		$this->load->view('ranking_sitemap');
	}

}
