<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Histori_tindakan_medis extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('histori_tindakan_medis_model', 'model');

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
		// Karena Histori Tindakan Medis Pertenaga Medis adalah halaman default, maka alihkan ke halaman tersebut
		redirect(base_url('histori_tindakan_medis/tenaga_medis'));
	}
	
	public function tenaga_medis()
	{
		$filter_dari = isset($_GET['filter_dari']) ? $_GET['filter_dari'] : null;
		$filter_sampai = isset($_GET['filter_sampai']) ? $_GET['filter_sampai'] : null;
		$id_dokter = isset($_GET['id_dokter']) ? $_GET['id_dokter'] : null;

		if ($filter_dari == null || $filter_sampai == null || $id_dokter == null) {
			$data['histori_pertenaga_medis'] = null;
		} else {
			$data['histori_pertenaga_medis'] = $this->model->_histori_pertenaga_medis($filter_dari, $filter_sampai, $id_dokter);
		}

		$data['tampil_dokter'] = $this->model->_get_dokter();

		if ($id_dokter == null) {
			$data['tampil_dokter_by_id'] = null;
		} else {
			$data['tampil_dokter_by_id'] = $this->model->_get_dokter_by_id($id_dokter);
		}

		$this->load->view('histori_tindakan_medis_pertenaga_medis', $data);
	}

	public function pasien()
	{
		$this->load->view('histori_tindakan_medis_perpasien');
	}

	public function tenaga_medis_cetak()
	{
		$filter_dari = isset($_GET['filter_dari']) ? $_GET['filter_dari'] : null;
		$filter_sampai = isset($_GET['filter_sampai']) ? $_GET['filter_sampai'] : null;
		$id_dokter = isset($_GET['id_dokter']) ? $_GET['id_dokter'] : null;

		$data['histori_pertenaga_medis'] = $this->model->_histori_pertenaga_medis($filter_dari, $filter_sampai, $id_dokter);
		$data['tampil_dokter'] = $this->model->_get_dokter();
		$data['tampil_dokter_by_id'] = $this->model->_get_dokter_by_id($id_dokter);
		
		$this->load->view('histori_tindakan_medis_pertenaga_medis_cetak', $data);
	}
    
}