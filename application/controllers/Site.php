<?php
error_reporting(0);
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {	
 
public function index(){
		$this->home();
		}

public function home() {	
    $this->load->model('prime_model');
	$data['user_pol'] = $this->prime_model->get_pol();
	$data['user_find'] = $this->prime_model->get_user();
    $this->load->view('c_home',$data);
		}

public function mricipt() {	
		$this->load->model('mricipt_model');
		$data['user_find'] = $this->mricipt_model->get_user();
		$data['col_found'] = $this->mricipt_model->get_col();
		$this->load->view('m_ricipt',$data);
		}
		
public function creceipt() {	
		$this->load->model('reverse_model');
		$data['user_find'] = $this->reverse_model->get_user();
		$data['col_mreceipt'] = $this->reverse_model->get_mreceipt();
		$this->load->view('c_mreceipt',$data);
		}
}


