<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antrian extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('Antrian_model');
		$this->load->model('Pasien_model');

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
		$data['kunjunganPasien'] = $this->Antrian_model->getKunjunganPasien();
		$this->load->view('antrian',$data);

		
    }
    public function hapusDataAntrian()
	{
		$id = $this->uri->segment(3);
		$proses = $this->Antrian_model->hapusDataAntrian($id);
		if (!$proses) {
				echo "<script>alert('Data Berhasil Di Hapus');history.go(-1);</script>";
				
		} else {
			echo "Data Gagal dihapus";
			echo "<br>";
			echo "<a href='".base_url('index.php/Antrian')."'>Tampil data Dokter</a>";
		}
	}
	

    public function getDataAntrian(){
    	$id=$this->uri->segment(3);
    	$data['query'] = $this->Antrian_model->getDataAntrian($id);
    	$data['getPk'] = $this->Antrian_model->getPemeriksaanKehamilan($id);
    	$data['getPu'] = $this->Antrian_model->getPemeriksaanUmum($id);
    	$data['getKb'] = $this->Antrian_model->getPemeriksaanKb($id);
    	$data['getImunisasi'] = $this->Antrian_model->getPemeriksaanImunisasi($id);
    	$data['getPersalinan'] = $this->Antrian_model->getPemeriksaanPersalinan($id);
    	$data['getIspa']=$this->Antrian_model->getPemeriksaanIspa($id);
    	$data['getDp'] = $this->Antrian_model->getDataPenyakit();
    	$data['getRu'] = $this->Antrian_model->getDataRentangUmur();
    	$data['getMt'] = $this->Antrian_model->getDataMacamTindakan();

    	//model pasien
    	$data['alatKontra'] = $this->Pasien_model->getAlatKontrasepsi();

    	$this->load->view('antrianEdit',$data);
    	
    }  

    public function updatePemeriksaanKehamilan(){
    	$id=$this->input->post('getIdAntrian');
    	$dateNow =  gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data = array('updated_at'=>$dateNow,			
    			'buku_kia'=>$this->input->post('bukuKia'),
                'hpht'=>$this->input->post('hpht'),
                'tp'=>$this->input->post('tp'),
                'bb'=>$this->input->post('bb'),
                'tb'=>$this->input->post('tb'),
                'usia_kehamilan'=>$this->input->post('usiaKehamilan'),
                'gpa'=>$this->input->post('gpa'),
                'k1'=>$this->input->post('k1'),
                'k4'=>$this->input->post('k4'),
                'tt'=>$this->input->post('tt'),
                'lila'=>$this->input->post('lila'),
                'hb'=>$this->input->post('hb'),
                'resiko'=>$this->input->post('resiko'),
                'keterangan'=>$this->input->post('keterangan'),
                'baru_lama'=>$this->input->post('baruLama'),
                'catatan'=>$this->input->post('catatan'));
    	$proses = $this->Antrian_model->updatePemeriksaanKehamilan($id, $data);
		if (!$proses) {
			echo "<script>alert('Data Berhasil Di Update');history.go(-2)</script>";
		} else {
			echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
		}
    }

    public function updatePemeriksaanPersalinan(){
    	$id=$this->input->post('getIdAntrian');
    	$dateNow =  gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data = array('updated_at'=>$dateNow,
    				'anak_ke'=>$this->input->post('anakKe'),
                    'bb'=>$this->input->post('bb'),
                    'pb'=>$this->input->post('pb'),
                    'tgl_lahir'=>$this->input->post('tglLahir'),
                    'jam_lahir'=>$this->input->post('jamLahir'),
                    'jenis_kelamin'=>$this->input->post('jenisKelamin'),
                    'imd'=>$this->input->post('imd'),
                    'lingkar_kepala'=>$this->input->post('lingkarKepala'),
                    'resiko'=>$this->input->post('resikoPersalinan'),
                    'keterangan'=>$this->input->post('keteranganPersalinan'),
                    'catatan'=>$this->input->post('catatanPersalinan'));
    	$proses = $this->Antrian_model->updatePemeriksaanPersalinan($id, $data);
		if (!$proses) {
			echo "<script>alert('Data Berhasil Di Update');history.go(-2)</script>";
		} else {
			echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
		}

    }

    public function updateImunisasi(){
    	$id=$this->input->post('getIdAntrian');
    	$dateNow =  gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data=array( 'updated_at'=>$dateNow,
                     'bb_lahir'=>$this->input->post('bbLahir'),
                     'bb'=>$this->input->post('bbImunisasi'),
                     'pb'=>$this->input->post('pbImunisasi'),
                     'catatan'=>$this->input->post('catatanImunisasi'),
                     'hb0'=>$this->input->post('hb0'),
                     'bcg'=>$this->input->post('bcg'),
                     'polio1'=>$this->input->post('polio1'),
                     'polio2'=>$this->input->post('polio2'),
                     'polio3'=>$this->input->post('polio3'),
                     'polio4'=>$this->input->post('polio4'),
                     'pentabio1'=>$this->input->post('pentabio1'),
                     'pentabio2'=>$this->input->post('pentabio2'),
                     'pentabio3'=>$this->input->post('pentabio3'),
                     'campak'=>$this->input->post('campak'),
                     'tt'=>$this->input->post('tt'),
                     'pentabio_ulang'=>$this->input->post('pentabioUlang'),
                     'campak_ulang'=>$this->input->post('campakUlang'),
                     'id_macam_tindakan_imunisasi'=>$this->input->post('idMacamTindakanImunisasi'));
        $proses = $this->Antrian_model->updateImunisasi($id, $data);
		if (!$proses) {
			echo "<script>alert('Data Berhasil Di Update');history.go(-2)</script>";
		} else {
			echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
		}       
    }

    public function updatePemeriksaanUmum(){
    	$id=$this->input->post('getIdAntrian');
    	$dateNow = gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data = array('updated_at'=>$dateNow,
                      'id_penyakit'=>$this->input->post('idPenyakitUmum'),
                      'id_rentang_umur'=>$this->input->post('idRentangUmurUmum'),
                      'id_macam_tindakan_imunisasi'=>$this->input->post('idTindakanUmum'),
                      'catatan'=>$this->input->post('catatanDokterUmum'));
    	$proses = $this->Antrian_model->updatePemeriksaanUmum($id, $data);
		if (!$proses) {
			echo "<script>alert('Data Berhasil Di Update');history.go(-2)</script>";
		} else {
			echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
		}
                
    }

    public function updatePemeriksaanIspa(){
    	$id=$this->input->post('getIdAntrian');
    	$dateNow = gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data = array('updated_at'=>$dateNow,
                      'tb_pb'=>$this->input->post('tbPbIspa'),
                      'bb'=>$this->input->post('bbIspa'),
                      'catatan'=>$this->input->post('catatanIspa'));
    	$proses = $this->Antrian_model->updatePemeriksaanIspa($id, $data);
		if (!$proses) {
			echo "<script>alert('Data Berhasil Di Update');history.go(-2)</script>";
		} else {
			echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
		}
    }

    public function updatePemeriksaanKb(){
    	$id=$this->input->post('getIdAntrian');
    	$dateNow = gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$satu = $this->input->post('jmlAnakLakiKb');
        $dua =  $this->input->post('jmlAnakPerempuanKb');
        $hitung = $satu + $dua;            
    	$data = array('updated_at'=>$dateNow,
                      'jml_anak_laki'=>$satu,
                      'jml_anak_perempuan'=>$dua,
                      'jml_anak'=>$hitung,
                      'usia_anak_terkecil'=>$this->input->post('usiaAnakTerkecilKb'),
                      'id_satuan_usia'=>$this->input->post('idSatuanUsiaKb'),
                      'pasang_baru'=>$this->input->post('pasangBaruKb'),
                      'pasang_cabut'=>$this->input->post('pasangCabutKb'),
                      'id_alat_kontrasepsi'=>$this->input->post('idAlatKontraKb'),
                      'akli'=>$this->input->post('akliKb'),
                      't_4'=>$this->input->post('t4Kb'),
                      'ganti_cara'=>$this->input->post('gantiCaraKb'),
                      'catatan'=>$this->input->post('catatanKb'));
    	$proses = $this->Antrian_model->updatePemeriksaanKb($id, $data);
			if (!$proses) {
				echo "<script>alert('Data Berhasil Di Update');history.go(-2)</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
    }

    public function filter(){
      $data['cariData'] = $this->Antrian_model->filter();
      $this->load->view('filterKunjungan',$data);
    }
    

}


  