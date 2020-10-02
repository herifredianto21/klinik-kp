<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'model');

		$this->userData = array(
			'session'	=> $this->session->userdata('userSession'),
			'host'		=> $this->input->get_request_header('Host', TRUE),
			'referer'	=> $this->input->get_request_header('Referer', TRUE),
			'agent'		=> $this->input->get_request_header('User-Agent', TRUE),
			'ipaddr'	=> $this->input->ip_address()
		);

		$auth = $this->model->auth($this->userData);
		if($auth){
			redirect('dashboard/');
		}
	}

	private function get_param($param = '', $needNumber = false)
	{
		if (isset($_GET[$param])) {
			return $_GET[$param];
		} else{
			if ($needNumber) {
				return 0;
			} else{
				return '';
			}
		}
	}

	public function services()
	{
		$request 	= $this->get_param('request');
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		switch($request)
		{
			case 'login':
				$param = array(
					'userData' => $this->userData,
					'postData' => $_POST
				);
				$response = $this->model->login($param);
				break;
			default:
				$response['msg'] = 'Bad request.';
				break;
		}

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function index()
	{
		$this->load->view('login');
    }
    
}
