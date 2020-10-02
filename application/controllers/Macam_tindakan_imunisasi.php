<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Macam_tindakan_imunisasi extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('macam_tindakan_imunisasi_model', 'model');

		$this->userData = array(
			'session'	=> $this->session->userdata('userSession'),
			'host'		=> $this->input->get_request_header('Host', TRUE),
			'referer'	=> $this->input->get_request_header('Referer', TRUE),
			'agent'		=> $this->input->get_request_header('User-Agent', TRUE),
			'ipaddr'	=> $this->input->ip_address()
		);

		$auth = $this->login->auth($this->userData);
		if(!$auth){
			if ($this->agent->is_browser()) {
				redirect();
			} else{
				$response = array(
					'result'	=> false,
					'msg'		=> 'Unauthorized access.'
				);
				echo json_encode($response, JSON_PRETTY_PRINT);
			}
		}
	}

    public function select( $id = 0 )
    {
    	$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$response = $this->model->select();
    	echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
}