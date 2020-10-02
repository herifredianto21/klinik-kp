<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanRm extends CI_Controller {

	private $userData;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('LaporanRm_model', 'model');

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
		$this->load->view('laporan_rm');
	}

	public function cetakRm(){
		$tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
		$tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
		$id = isset($_GET['id']) ? $_GET['id'] : null;

		$this->controller = $this;

		if($id==9){
			$data['lapRekamMedisUmum'] = $this->model->_lapRekamMedisUmum($tgl1, $tgl2, $id);
			$this->load->view('cetak_rm', $data);
		} else if($id==3){
			$data['lapRekamMedis_model'] = $this->model->_lapRekamMedis_model($tgl1, $tgl2, $id);
			$this->load->view('cetak_rm', $data);
		} else if($id==34){
			$data['lapRekamMedisIspaa'] = $this->model->_lapRekamMedisIspaa($tgl1, $tgl2, $id);
			$this->load->view('cetak_rm', $data);
		} else if($id==37){
			$data['lapRekamMedisKb'] = $this->model->_lapRekamMedisKb($tgl1, $tgl2, $id);
			$this->load->view('cetak_rm', $data);
		} else if($id==1){
			$data['lapRekamMedisKehamilan'] = $this->model->_lapRekamMedisKehamilan($tgl1, $tgl2, $id);
			$this->load->view('cetak_rm', $data);
		} else if($id==8){
			$data['lapRekamMedisImunisasi'] = $this->model->_lapRekamMedisImunisasi($tgl1, $tgl2, $id);
			$this->load->view('cetak_rm', $data);
		}

	}

	public function detailRm(){
		$tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
		$tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
		$id = isset($_GET['id']) ? $_GET['id'] : null;

		$this->controller = $this;

		if($id==9){
			$data['lapRekamMedisUmum'] = $this->model->_lapRekamMedisUmum($tgl1, $tgl2, $id);
			$this->load->view('detail_Laprm', $data);
		} else if($id==3){
			$data['lapRekamMedis_model'] = $this->model->_lapRekamMedis_model($tgl1, $tgl2, $id);
			$this->load->view('detail_Laprm', $data);
		} else if($id==34){
			$data['lapRekamMedisIspaa'] = $this->model->_lapRekamMedisIspaa($tgl1, $tgl2, $id);
			$this->load->view('detail_Laprm', $data);
		} else if($id==37){
			$data['lapRekamMedisKb'] = $this->model->_lapRekamMedisKb($tgl1, $tgl2, $id);
			$this->load->view('detail_Laprm', $data);
		} else if($id==1){
			$data['lapRekamMedisKehamilan'] = $this->model->_lapRekamMedisKehamilan($tgl1, $tgl2, $id);
			$this->load->view('detail_Laprm', $data);
		} else if($id==8){
			$data['lapRekamMedisImunisasi'] = $this->model->_lapRekamMedisImunisasi($tgl1, $tgl2, $id);
			$this->load->view('detail_Laprm', $data);
		}

	}

	//EXCEL
	public function cetakRmEx(){
		$tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
		$tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
		$id = isset($_GET['id']) ? $_GET['id'] : null;

		$this->controller = $this;

		if($id==9){
			$data['lapRekamMedisUmum'] = $this->model->_lapRekamMedisUmum($tgl1, $tgl2, $id);
			$this->load->view('cetak_rmex', $data);
		} else if($id==3){
			$data['lapRekamMedis_model'] = $this->model->_lapRekamMedis_model($tgl1, $tgl2, $id);
			$this->load->view('cetak_rmex', $data);
		} else if($id==34){
			$data['lapRekamMedisIspaa'] = $this->model->_lapRekamMedisIspaa($tgl1, $tgl2, $id);
			$this->load->view('cetak_rmex', $data);
		} else if($id==37){
			$data['lapRekamMedisKb'] = $this->model->_lapRekamMedisKb($tgl1, $tgl2, $id);
			$this->load->view('cetak_rmex', $data);
		} else if($id==1){
			$data['lapRekamMedisKehamilan'] = $this->model->_lapRekamMedisKehamilan($tgl1, $tgl2, $id);
			$this->load->view('cetak_rmex', $data);
		} else if($id==8){
			$data['lapRekamMedisImunisasi'] = $this->model->_lapRekamMedisImunisasi($tgl1, $tgl2, $id);
			$this->load->view('cetak_rmex', $data);
		}

	}

	public function lapRekamMedis()
	{
		// define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        // $this->load->library('fpdf');
		$tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
		$tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
		$id = isset($_GET['id']) ? $_GET['id'] : null;

		$this->controller = $this;

		$data['lapRekamMedis_model'] = $this->model->_lapRekamMedis_model($tgl1, $tgl2, $id);
		$data['lapRekamMedisIspaa'] = $this->model->_lapRekamMedisIspaa($tgl1, $tgl2, $id);
		$data['lapRekamMedisUmum'] = $this->model->_lapRekamMedisUmum($tgl1, $tgl2, $id);
		$data['lapRekamMedisKb'] = $this->model->_lapRekamMedisKb($tgl1, $tgl2, $id);
		$data['lapRekamMedisKehamilan'] = $this->model->_lapRekamMedisKehamilan($tgl1, $tgl2, $id);
		$data['lapRekamMedisImunisasi'] = $this->model->_lapRekamMedisImunisasi($tgl1, $tgl2, $id);
		$this->load->view('laporan_rm', $data);
	}

	//___________________________________________________________________________________________________
	//Laporan Rekam Medis Imunisasi Menampilkan data Obat perPasien
	public function RmObatImunisasi($id_antrian)
	{
		return $this->model->_RmImunisasiObat($id_antrian);
		// return "lapRekamMedisObat()";
	}

	//Laporan Rekam Medis Imunisasi Menampilkan data Tindakan Medis perPasien
	public function TindakanMedisImun($id_antrian)
	{
		return $this->model->_TindakanMedisImun($id_antrian);
		// return "lapRekamMedisObat()";
	}
	//___________________________________________________________________________________________________

	//___________________________________________________________________________________________________
	//Laporan Rekam Medis Imunisasi Menampilkan data Obat perPasien
	public function RmObatKehamilan($id_antrian)
	{
		return $this->model->_RmKehamilanObat($id_antrian);
		// return "lapRekamMedisObat()";
	}

	//Laporan Rekam Medis Imunisasi Menampilkan data Tindakan Medis perPasien
	public function TindakanMedisKehamilan($id_antrian)
	{
		return $this->model->_TindakanMedisKehamilan($id_antrian);
		// return "lapRekamMedisObat()";
	}
	//___________________________________________________________________________________________________

	//___________________________________________________________________________________________________
	//Laporan Rekam Medis Ispa Menampilkan data Obat perPasien
	public function RmObatIspa($id_antrian)
	{
		return $this->model->_RmIspaObat($id_antrian);
		// return "lapRekamMedisObat()";
	}

	//Laporan Rekam Medis Ispa Menampilkan data Tindakan Medis perPasien
	public function RmTindakanMedisIspa($id_antrian)
	{
		return $this->model->_RmTindakanMedisIspa($id_antrian);
		// return "lapRekamMedisObat()";
	}
	//___________________________________________________________________________________________________

	//___________________________________________________________________________________________________
	//Laporan Rekam Medis Persalinan Menampilkan data Obat perPasien
	public function RmObatPersalinan($id_antrian)
	{
		return $this->model->_RmPersalinanObat($id_antrian);
		// return "lapRekamMedisObat()";
	}

	//Laporan Rekam Medis Persalinan Menampilkan data Tindakan Medis perPasien
	public function RmTindakanMedisPersalinan($id_antrian)
	{
		return $this->model->_RmTindakanMedisPersalinan($id_antrian);
		// return "lapRekamMedisObat()";
	}
	//___________________________________________________________________________________________________

	//___________________________________________________________________________________________________
	//Laporan Rekam Medis Pemeriksaan Umum Menampilkan data Obat perPasien
	public function RmObatUmum($id_antrian)
	{
		return $this->model->_RmUmumObat($id_antrian);
		// return "lapRekamMedisObat()";
	}

	//Laporan Rekam Medis Pemeriksaan Umum Menampilkan data Tindakan Medis perPasien
	public function RmTindakanMedisUmum($id_antrian)
	{
		return $this->model->_RmTindakanMedisUmum($id_antrian);
		// return "lapRekamMedisObat()";
	}
	//___________________________________________________________________________________________________

	//___________________________________________________________________________________________________
	//Laporan Rekam Medis Pemeriksaan KB Menampilkan data Obat perPasien
	public function RmObatKb($id_antrian)
	{
		return $this->model->_RmUmumObat($id_antrian);
		// return "lapRekamMedisObat()";
	}

	//Laporan Rekam Medis Pemeriksaan KB Menampilkan data Tindakan Medis perPasien
	public function RmTindakanMedisKb($id_antrian)
	{
		return $this->model->_RmTindakanMedisKb($id_antrian);
		// return "lapRekamMedisObat()";
	}
	//___________________________________________________________________________________________________

}