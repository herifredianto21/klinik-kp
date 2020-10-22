<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apotek extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('apotek_model', 'model');

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
		$data = array(
			'jasa' => $this->model->get_jasa(),
			'obat' => $this->model->get_obat()
		);

		$this->load->view('apotek', $data);
	}

	public function laporan()
	{
		$this->load->view('apotek_laporan');
	}
	
	public function penjualan()
	{
		$data = array(
			'obat' => $this->model->get_obat()
		);

		$this->load->view('apotek_penjualan', $data);
	}

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
	
	public function datatable_penjualan()
    {
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param 		= $_GET;
		$response 	= $this->model->datatable_penjualan($param);
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
	
	public function save_penjualan()
    {
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $_POST
		);
		$response = $this->model->save_penjualan($param);

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
	
	public function cetak($id = 0)
	{
		$data = $this->model->cetak($id, false, false);
		if (!$data['result']) {
			redirect('apotek/');
		}
		$this->load->view('cetak_biaya', $data);
	}

	public function cetak_detail($id = 0)
	{
		$data = $this->model->cetak($id, true, false);
		if (!$data['result']) {
			redirect('apotek/');
		}
		$this->load->view('cetak_biaya', $data);
	}

	public function cetak_detail_pemeriksaan($id = 0)
	{
		$data = $this->model->cetak($id, false, true);
		if (!$data['result']) {
			redirect('apotek/');
		}
		$this->load->view('cetak_biaya', $data);
	}

	public function cetak_langsung($id = 0)
	{
		$data = $this->model->cetak_langsung($id);
		if (!$data['result']) {
			redirect('apotek/');
		}
		$this->load->view('cetak_biaya_langsung', $data);
	}

	public function cetak_laporan_harian()
	{
		$tanggal = $_GET['tanggal'];
		$data = $this->model->cetak_laporan_harian($tanggal);
		$this->load->view('apotek_cetak_laporan_harian', $data);
	}

	public function cetak_laporan_bulanan()
	{
		$bulan = $_GET['bulan'];
		$data = $this->model->cetak_laporan_bulanan($bulan);
		$this->load->view('apotek_cetak_laporan_bulanan', $data);
	}
    
}