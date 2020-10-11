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

        // Data pasien
        $data['tampil_pasien'] = $this->model->_get_pasien();

        // Data tindakan
        $data['_getTindakan'] = $this->model->_getTindakan($id_antrian);
        $data['_getAddedTindakan'] = $this->model->_getAddedTindakan($id_antrian);
        
        // Data resep
        $data['_getObat'] = $this->model->_getObat($id_antrian);
        $data['_getAddedResep'] = $this->model->_getAddedResep($id_antrian);

        $this->load->view('tindakan_medis', $data);
    }

    
    /* TINDAKAN */
    
    public function addTindakan()
    {
        $langkah = $_GET['langkah'];
        $id_antrian = $_GET['id_antrian'];
        $id_dokter = $_GET['id_dokter'];
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

        // Cek apakah data sudah ada atau masih kosong
        if (!$this->model->_cekTindakanPasien($id_antrian)) {
            // Buat data baru
            echo "Data belum ada, menambah data baru.<br>";
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

        redirect(base_url() . 'tindakan-medis?langkah=' . $langkah . '&id_antrian=' . $id_antrian . '&id_dokter=' . $id_dokter . '&nama_pasien=' . $nama_pasien . '&nama_dokter=' . $nama_dokter . '&diagnosa=' . $diagnosa . '&tindak_lanjut=' . $tindak_lanjut . '&keterangan_tindak_lanjut=' . $keterangan_tindak_lanjut);
    }

    public function editAddedTindakan()
    {
        $langkah = $_GET['langkah'];
        $id_antrian = $_GET['id_antrian'];
        $id_dokter = $_GET['id_dokter'];
        $nama_pasien = $_GET['nama_pasien'];
        $nama_dokter = $_GET['nama_dokter'];
        $diagnosa = $_GET['diagnosa'];
        $tindak_lanjut = $_GET['tindak_lanjut'];
        $keterangan_tindak_lanjut = $_GET['keterangan_tindak_lanjut'];

        // Data
        $id_tindakan_pasien_detail = $this->input->post('id_tindakan_pasien_detail');
        $keterangan_tindakan_pasien = $this->input->post('keterangan_tindakan_pasien');

        $this->model->_editAddedTindakan($id_tindakan_pasien_detail, $keterangan_tindakan_pasien);

        echo $id_tindakan_pasien_detail;
        echo $keterangan_tindakan_pasien;

        redirect(base_url() . 'tindakan-medis?langkah=' . $langkah . '&id_antrian=' . $id_antrian . '&id_dokter=' . $id_dokter . '&nama_pasien=' . $nama_pasien . '&nama_dokter=' . $nama_dokter . '&diagnosa=' . $diagnosa . '&tindak_lanjut=' . $tindak_lanjut . '&keterangan_tindak_lanjut=' . $keterangan_tindak_lanjut);
    }
    
    public function deleteAddedTindakan()
    {
        $id_tindakan_pasien_detail = $_GET['id_tindakan_pasien_detail'];
        $this->model->_deleteAddedTindakan($id_tindakan_pasien_detail);
    }

    
    /* RESEP */

    public function addResep()
    {
        $langkah = $_GET['langkah'];
        $id_antrian = $_GET['id_antrian'];
        $id_dokter = $_GET['id_dokter'];
        $nama_pasien = $_GET['nama_pasien'];
        $nama_dokter = $_GET['nama_dokter'];
        $diagnosa = $_GET['diagnosa'];
        $tindak_lanjut = $_GET['tindak_lanjut'];
        $keterangan_tindak_lanjut = $_GET['keterangan_tindak_lanjut'];

        // Data
        $pilih = $this->input->post('pilih');
        $id_obat = $this->input->post('id_obat');
        $qty = $this->input->post('qty');
        $aturan_pakai = $this->input->post('aturan_pakai');
        $id_resep = '';

        // Cek apakah data sudah ada atau masih kosong
        if (!$this->model->_cekResep($id_antrian)) {
            // Buat data baru
            echo "Data belum ada, menambah data baru.<br>";
            $this->model->_addResepBaru($id_antrian, $id_dokter);
        }

        // Get id_resep
        $id_resep = $this->model->_getIdResep($id_antrian);
        echo $id_resep . "<br>";

        // Insert data sebanyak checkbox yang dipilih
        for ($i=0; $i<=count($pilih)-1; $i++) {
            if ($pilih[$i] == 'checked') {
                $this->model->_addResep($id_resep, $id_obat[$i], $qty[$i], $aturan_pakai[$i]);
            }
        }

        redirect(base_url() . 'tindakan-medis?langkah=' . $langkah . '&id_antrian=' . $id_antrian . '&id_dokter=' . $id_dokter . '&nama_pasien=' . $nama_pasien . '&nama_dokter=' . $nama_dokter . '&diagnosa=' . $diagnosa . '&tindak_lanjut=' . $tindak_lanjut . '&keterangan_tindak_lanjut=' . $keterangan_tindak_lanjut);
    }

    function editAddedResep() {}
    function deleteAddedResep()
    {
        $id_resep_detail = $_GET['id_resep_detail'];
        $this->model->_deleteAddedResep($id_resep_detail);
    }


    /* SIMPAN SEMUA DATA */
    public function simpanTindakanMedis()
    {
        $id_antrian = $_GET['id_antrian'];
        $id_dokter = $_GET['id_dokter'];
        $diagnosa = $_GET['diagnosa'];
        $tindak_lanjut = $_GET['tindak_lanjut'];
        $keterangan_tindak_lanjut = $_GET['keterangan_tindak_lanjut'];

        // Data
        $id_tindakan_pasien = '';

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