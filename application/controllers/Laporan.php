<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('laporan_model', 'model');

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

	public function index()
	{
		$this->load->view('laporan');
    }

  //   public function edit($id = 0)
  //   {
  //   	$response = $this->model->edit($id);
		// echo json_encode($response, JSON_PRETTY_PRINT);	
  //   }

    public function datatable()
    {
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param 		= $_GET;
		$response 	= $this->model->datatable($param);
    	echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function save()
    {
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $_POST
		);
		$response = $this->model->save($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function delete()
    {
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $_POST
		);
		$response = $this->model->delete($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function select_jenis_laporan($id = 0)
    {
    	$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$response = $this->model->select_jenis_laporan($id);
    	echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function cetak($id = 0)
    {
    	$response = $this->model->cetak($id);
    	if ($response['result']) {
    		$idJenisLaporan = $response['data']['id_jenis_laporan'];
    		switch ($idJenisLaporan) {
    			case '1':
    				$this->load->view('laporan_bulanan_cetak', $response);
    				break;
    			case '2':
    				$this->load->view('laporan_rekap_penyakit_cetak', $response);
    				break;
    			case '3':
    				$this->load->view('laporan_program_ispa_cetak', $response);
    				break;
    			case '4':
    				$this->load->view('laporan_pemeriksaan_kb_cetak', $response);
    				break;
    			case '5':
    				$this->load->view('laporan_imunisasi_cetak', $response);
    				break;
    			case '6':
    				$this->load->view('laporan_persalinan_cetak', $response);
    				break;
    			case '7':
    				$this->load->view('laporan_pemeriksaan_kehamilan_cetak', $response);
					break;
				case '8':
    				$this->load->view('laporan_harian_cetak', $response);
    				break;
    			default:
    				# code...
    				break;
    		}
    	}
    }
    
}