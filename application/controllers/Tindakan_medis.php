<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_medis extends CI_Controller {

    private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('tindakan_medis_model', 'model');

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
        $id_antrian = !empty($_GET['id_antrian']) ? $_GET['id_antrian'] : null;

        $data['tampil_pasien'] = $this->model->_get_pasien();

        // Diagnosa
        // Resep
        $data['_getObat'] = $this->model->_getObat();
        $data['_getAddedResep'] = $this->model->_getAddedResep($id_antrian);
        // Tindakan
        $data['_getTindakan'] = $this->model->_getTindakan($id_antrian);
        $data['_getAddedTindakan'] = $this->model->_getAddedTindakan($id_antrian);

        $this->load->view('tindakan_medis', $data);
    }

    
    /* DIAGNOSA */
    
    public function addDiagnosa() {}
    public function editAddedDiagnosa() {}
    public function deleteAddedDiagnosa() {}
    
    
    /* RESEP */

    public function addResep()
    {
        $langkah = $_GET['langkah'];
        $id_antrian = $_GET['id_antrian'];

        // Data
        $pilih = $this->input->post('pilih');
        $id = $this->input->post('id');

        $id_resep = '';
        $id_obat = $this->input->post('id_obat');
        $nama_obat = $this->input->post('nama_obat');
        $harga_jual_obat = $this->input->post('harga_jual_obat');
        $satuan = $this->input->post('satuan');
        $aturan_pakai = $this->input->post('aturan_pakai');

        /* exit;
        // Cek apakah data sudah ada atau masih kosong
        if (!$this->model->_cekTindakanPasien($id_antrian)) {
            // Buat data baru
            echo "masuk if<br>";
            $this->model->_addTindakanBaru($id_antrian);
        }

        // Get id_resep
        $id_resep = $this->model->_getIdTindakanPasien($id_antrian);
        echo $id_resep . "<br>"; */

        // Insert data sebanyak checkbox yang dipilih
        for ($i=0; $i<=count($pilih)-1; $i++) {
            if ($pilih[$i] == 'checked') {
                $this->model->_addResep($id[$i], $id_resep, $keterangan_tindakan_pasien[$i]);
            }
        }

        // redirect(base_url() . 'tindakan-medis?langkah=' . $langkah . '&id_antrian=' . $id_antrian);
    }

    function editAddedResep() {}
    function deleteAddedResep() {}

    
    /* TINDAKAN */
    
    public function addTindakan()
    {
        $langkah = $_GET['langkah'];
        $id_antrian = $_GET['id_antrian'];
        $nama_pasien = $_GET['nama_pasien'];
        $nama_dokter = $_GET['nama_dokter'];
        $diagnosa = $_GET['diagnosa'];
        $tindak_lanjut = $_GET['tindak_lanjut'];
        $keterangan_tindak_lanjut = $_GET['keterangan_tindak_lanjut'];

        // Data
        $pilih = $this->input->post('pilih');
        $id_biaya_medis = $this->input->post('id_biaya_medis');
        $keterangan_tindakan_pasien = $this->input->post('keterangan_tindakan_pasien');
        $id_tindakan_pasien = '';
        $id_dokter = '18'; // TODO: benerin $id_dokter

        // Cek apakah data sudah ada atau masih kosong
        if (!$this->model->_cekTindakanPasien($id_antrian)) {
            // Buat data baru
            echo "masuk if<br>";
            $this->model->_addTindakanBaru($id_antrian, $id_dokter);
        }

        // Get id_tindakan_pasien
        $id_tindakan_pasien = $this->model->_getIdTindakanPasien($id_antrian);

        echo "Jumlah data: " . count($pilih);

        // Insert data sebanyak checkbox yang dipilih
        for ($i=0; $i<=count($pilih)-1; $i++) {
            if ($pilih[$i] == 'checked') {
                $this->model->_addTindakan($id_tindakan_pasien, $id_biaya_medis[$i], $keterangan_tindakan_pasien[$i]);
            }
        }

        redirect(base_url() . 'tindakan-medis?langkah=' . $langkah . '&id_antrian=' . $id_antrian . '&nama_pasien=' . $nama_pasien . '&nama_dokter=' . $nama_dokter . '&diagnosa=' . $diagnosa . '&tindak_lanjut=' . $tindak_lanjut . '&keterangan_tindak_lanjut=' . $keterangan_tindak_lanjut);
    }

    function _editAddedTindakan() {}
    
    public function deleteAddedTindakan()
    {
        // $langkah = $_GET['langkah'];
        // $id_antrian = $_GET['id_antrian'];
        $id_tindakan_pasien_detail = $_GET['id_tindakan_pasien_detail'];
        // $nama_pasien = $_GET['nama_pasien'];
        // $nama_dokter = $_GET['nama_dokter'];
        // $diagnosa = $_GET['diagnosa'];
        // $tindak_lanjut = $_GET['tindak_lanjut'];
        // $keterangan_tindak_lanjut = $_GET['keterangan_tindak_lanjut'];

        $this->model->_deleteAddedTindakan($id_tindakan_pasien_detail);
        
        // redirect(base_url() . 'tindakan-medis?langkah=' . $langkah . '&id_antrian=' . $id_antrian . '&nama_pasien=' . $nama_pasien . '&nama_dokter=' . $nama_dokter . '&diagnosa=' . $diagnosa . '&tindak_lanjut=' . $tindak_lanjut . '&keterangan_tindak_lanjut=' . $keterangan_tindak_lanjut);
    }

    /* SIMPAN SEMUA DATA */
    public function simpanTindakanMedis()
    {
        $id_antrian = $_GET['id_antrian'];
        $diagnosa = $_GET['diagnosa'];
        $tindak_lanjut = $_GET['tindak_lanjut'];
        $keterangan_tindak_lanjut = $_GET['keterangan_tindak_lanjut'];

        // Data
        $id_tindakan_pasien = '';
        $id_dokter = '18'; // TODO: benerin $id_dokter

        // Cek apakah data sudah ada atau masih kosong
        if (!$this->model->_cekTindakanPasien($id_antrian)) {
            // Buat data baru
            echo "data belum ada<br>";
            $this->model->_addTindakanBaru($id_antrian, $id_dokter);
        }
        
        // Get id_tindakan_pasien
        $id_tindakan_pasien = $this->model->_getIdTindakanPasien($id_antrian);
        /* echo $id_tindakan_pasien;
        exit; */

        $this->model->_simpanTindakanMedis($id_tindakan_pasien, $diagnosa, $tindak_lanjut, $keterangan_tindak_lanjut);

        redirect(base_url() . 'tindakan-medis');
    }
}

/* 
TODO:
- buat agar semua baris di tabel di-submit, tidak hanya yang 
  ada pada halaman tabel yang sedang ditampilkan
*/