<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	private $userData;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('Dashboard_model');


		$this->userData = array(
			'session'	=> $this->session->userdata('userSession'),
			'host'		=> $this->input->get_request_header('Host', TRUE),
			'referer'	=> $this->input->get_request_header('Referer', TRUE),
			'agent'		=> $this->input->get_request_header('User-Agent', TRUE),
			'ipaddr'	=> $this->input->ip_address()
		);

		$auth = $this->login->auth($this->userData);
		if(!$auth){
			redirect();
		}
     
	}

	public function index()
	{
		// $data['query'] = $this->Dashboard_model->tampilPasienDilayani();
		$data['query'] = $this->Dashboard_model->tampilPasienDilayani();
		$data['harusDilayani'] = $this->Dashboard_model->tampilPasienHarusDilayani();
		$data['sedangDilayani'] = $this->Dashboard_model->tampilPasienSedangDilayani();
		$data['hitungPengunjung'] = $this->Dashboard_model->counterKunjungan();
		$data['penyakit'] = $this->Dashboard_model->getJenisPenyakit();
		$data['rUmur'] = $this->Dashboard_model->getRentangUmur();
		$data['tindakan'] = $this->Dashboard_model->getTindakan();
		$data['satuanUsia'] = $this->Dashboard_model->getSatuanUsia();
		$data['alatKontra'] = $this->Dashboard_model->getAlatKontrasepsi();
        $data['pelayanan'] = $this->Dashboard_model->getJenisPelayanan();
        $data['kdAntrian'] = $this->Dashboard_model->getKodeAntrian();

        $data['pasien']  = $this->Dashboard_model->getPasien();
        $data['dokter'] = $this->Dashboard_model->getDokter();
        // $data['bbLahir'] = $this->Dashboard_model->getBbLahir();
        
        //buat get data dari view di kirim ke model
        $this->controller=$this;
        
        
		
		
		$this->load->view('dashboard',$data);

    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
    }
    
    public function simpanDataPasien()
    {
        
    	$data = array('jk_pasien'=>$this->input->post('jk_pasien'),
                'no_registrasi'=>$this->input->post('no_registrasi'),
                'nik'=>$this->input->post('nik'),
                'nama_pasien'=>$this->input->post('nama_pasien'),
                'tgl_lahir'=>$this->input->post('tgl_lahir'),
                'pendidikan_pasien'=>$this->input->post('pendidikan_pasien'),
                'agama_pasien'=>$this->input->post('agama_pasien'),
                'pekerjaan_pasien'=>$this->input->post('pekerjaan_pasien'),
                'alamat_ktp_pasien'=>$this->input->post('alamat_ktp_pasien'),
                'alamat_pasien'=>$this->input->post('alamat_pasien'),
                'nama_ayah_kandung'=>$this->input->post('nama_ayah_kandung'),
                'nama_pj'=>$this->input->post('nama_pj'),
                'tgl_lahir_pj'=>$this->input->post('tgl_lahir_pj'),
                'pendidikan_pj'=>$this->input->post('pendidikan_pj'),
                'agama_pj'=>$this->input->post('agama_pj'),
                'pekerjaan_pj'=>$this->input->post('pekerjaan_pj'),
                'alamat_ktp_pj'=>$this->input->post('alamat_ktp_pj'),
                'alamat_pj'=>$this->input->post('alamat_pj'),
                'kota'=>$this->input->post('kota'),
                'desa'=>$this->input->post('desa'),
                'gol_darah'=>$this->input->post('gol_darah'),
                'no_telp_pasien'=>$this->input->post('no_telp_pasien'),
                'email'=>$this->input->post('email'),
                'medsos'=>$this->input->post('medsos'),
                'catatan_bidan'=>$this->input->post('catatan_bidan').".");
		$proses=$this->Dashboard_model->simpanDataPasien($data);
			if (!$proses) {
				//script pake print kartu berobat
                    $url = base_url('index.php/CetakKartuPasien');
                    echo "<script>window.open('".$url."','_blank');</script>";
                    echo "<script>history.go(-2);</script>";
                //script ga pake print kartu berobat
                // echo "<script>alert('Data Berhasil Di Simpan');history.go(-1);</script>";
				
			} else {
				echo "Data Gagal Disimpan";
				echo "<br>";
				echo "<a href='".base_url('index.php/DataDokter/index/')."'>Kembali ke form</a>";
			}

    }

    public function simpanPemeriksaanUmum(){
	    $data = array('id_antrian'=>$this->input->post('idAntrian'),
	    		'jenis_kelamin'=>$this->input->post('jenisKelamin'),
	    		'id_penyakit'=>$this->input->post('idPenyakit'),
	    		'id_rentang_umur'=>$this->input->post('idRentangUmur'),
	    		'id_macam_tindakan_imunisasi'=>$this->input->post('idTindakan'),
	    		'catatan'=>$this->input->post('catatanDokter'));
		$proses=$this->Dashboard_model->simpanPemeriksaanUmum($data);
			if (!$proses) {
				// header('Location: index');
				echo "<script>alert('Data Berhasil Disimpan');window.location='index#pasienSedangDilayani'</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
    }

    public function simpanPemeriksaanKb(){
    	$satu = $this->input->post('jmlAnakLaki');
    	$dua =  $this->input->post('jmlAnakPerempuan');
    	$hitung = $satu + $dua;
        $waktuSekarang = gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data = array('id_antrian'=>$this->input->post('idAntrian'),
                'created_at'=>$waktuSekarang,
    			'id_pasien'=>$this->input->post('idPasien'),
                'umur'=>$this->input->post('umurPasien'),
                'nama_pasien'=>$this->input->post('namaPasien'),
    			'nama_pj'=>$this->input->post('namapj'),
    			'alamat'=>$this->input->post('alamatPasien'),
    			'jml_anak_laki'=>$this->input->post('jmlAnakLaki'),
    			'jml_anak_perempuan'=>$this->input->post('jmlAnakPerempuan'),
    			'jml_anak'=>$hitung,
    			'usia_anak_terkecil'=>$this->input->post('usiaAnakTerkecil'),
    			'id_satuan_usia'=>$this->input->post('idSatuanUsia'),
    			'pasang_baru'=>$this->input->post('pasangBaru'),
    			'pasang_cabut'=>$this->input->post('pasangCabut'),
    			'id_alat_kontrasepsi'=>$this->input->post('idAlatKontra'),
    			'akli'=>$this->input->post('akli'),
    			't_4'=>$this->input->post('t4'),
    			'ganti_cara'=>$this->input->post('gantiCara'),
    			'catatan'=>$this->input->post('catatan'));
    	$proses=$this->Dashboard_model->simpanPemeriksaanKb($data);
    		if (!$proses) {
				// header('Location: index');
				echo "<script>alert('Data Berhasil Disimpan');window.location='index#pasienSedangDilayani'</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
    }

    public function simpanDataProgramIspa(){
    	$data=array('id_antrian'=>$this->input->post('idAntrian'),
    		'nama_anak'=>$this->input->post('namaAnak'),
    		'jenis_kelamin'=>$this->input->post('jk'),
    		'umur_tahun'=>$this->input->post('umurTahun'),
    		'umur_bulan'=>$this->input->post('umurBulan'),
    		'tb_pb'=>$this->input->post('tbPb'),
    		'bb'=>$this->input->post('bb'),
    		'catatan'=>$this->input->post('catatan'));
    	$proses=$this->Dashboard_model->simpanDataProgramIspa($data);
    		if (!$proses) {
				// header('Location: index');
				echo "<script>alert('Data Berhasil Disimpan');window.location='index#pasienSedangDilayani'</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
    }
    public function simpanDataImunisasi(){
        //start data yang disimpan ke table detail_imunisasi
        $waktuSekarang = gmdate("Y-m-d H:i:s", time()+60*60*7);
    	$data=array('id_antrian'=>$this->input->post('idAntrian'),
             'created_at'=>$waktuSekarang,
             'id_pasien'=>$this->input->post('idPasien'),
    		 'nama_anak'=>$this->input->post('namaAnak'),
    		 'no_kk'=>$this->input->post('noKk'),
    		 'alamat'=>$this->input->post('alamat'),
    		 'tgl_lahir'=>$this->input->post('tglLahir'),
    		 'bb_lahir'=>$this->input->post('bbLahir'),
    		 'bb'=>$this->input->post('bb'),
    		 'pb'=>$this->input->post('pb'),
    		 'catatan'=>$this->input->post('catatan'),
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
            //end data yang disimpan ke table detail imunisasi

            //start untuk update no_kk Pasien di table pasiens
            $id=$this->input->post('idPasien');
            $kk=array('no_kk'=>$this->input->post('noKk'));
            $updateKk = $this->Dashboard_model->updateNoKk($id, $kk);
			// end untuk update no_kk pasien di table pasiens

            //start validasi simpan data imunisasi ke table detail_imunisasi
            $proses=$this->Dashboard_model->simpanDataImunisasi($data);
    		if (!$proses) {
				// header('Location: index');
				echo "<script>alert('Data Berhasil Disimpan');window.location='index#pasienSedangDilayani'</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
            //end validasi simpan data imunisasi ke table detail_imunisasi
    }
    public function simpanDataPemeriksaanKehamilan(){
    	$data = array('id_antrian'=>$this->input->post('idAntrian'),
    			'id_pasien'=>$this->input->post('idPasien'),
    			'tgl_lahir'=>$this->input->post('tglLahir'),
    			'nik'=>$this->input->post('nik'),
    			'umur'=>$this->input->post('umur'),
    			'nama_pj'=>$this->input->post('namapj'),
    			'no_kk'=>$this->input->post('noKk'),
    			'buku_kia'=>$this->input->post('bukuKia'),
    			'alamat'=>$this->input->post('alamat'),
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
        
        //start untuk update no_kk Pasien di table pasiens
            $id=$this->input->post('idPasien');
            $kk=array('no_kk'=>$this->input->post('noKk'));
            $updateKk = $this->Dashboard_model->updateNoKk($id, $kk);
        // end untuk update no_kk pasien di table pasiens

		$proses=$this->Dashboard_model->simpanDataPemeriksaanKehamilan($data);
    		if (!$proses) {
				// header('Location: index');
				echo "<script>alert('Data Berhasil Disimpan');window.location='index#pasienSedangDilayani'</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
    }
    public function simpanDataPersalinan(){
    	$data = array('id_antrian'=>$this->input->post('idAntrian'),
    			'id_pasien'=>$this->input->post('idPasien'),
    			'umur'=>$this->input->post('umur'),
    			'alamat'=>$this->input->post('alamat'),
    			'anak_ke'=>$this->input->post('anakKe'),
    			'bb'=>$this->input->post('bb'),
    			'pb'=>$this->input->post('pb'),
    			'tgl_lahir'=>$this->input->post('tglLahir'),
    			'jam_lahir'=>$this->input->post('jamLahir'),
    			'jenis_kelamin'=>$this->input->post('jenisKelamin'),
    			'imd'=>$this->input->post('imd'),
    			'lingkar_kepala'=>$this->input->post('lingkarKepala'),
    			'resiko'=>$this->input->post('resiko'),
    			'keterangan'=>$this->input->post('keterangan'),
    			'catatan'=>$this->input->post('catatan'));
   		$proses=$this->Dashboard_model->simpanDataPersalinan($data);
    		if (!$proses) {
				// header('Location: index');
				echo "<script>alert('Data Berhasil Disimpan');window.location='index#pasienSedangDilayani'</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
    }
    public function simpanAntrian(){
        $dateNow = $waktuSekarang = gmdate("Y-m-d H:i:s", time()+60*60*7);
        $statusAntrian = "Proses";
        $antrian = $this->input->post('noAntrian');
        
        if (empty($antrian)) {
            $no = "1";
            $data = array('created_at'=>$dateNow,
                      'id_dokter'=>$this->input->post('namaDokter'),
                      'id_pasien'=>$this->input->post('namaPasien'),
                      'no_antrian'=>$no,
                      'status_antrian'=>$statusAntrian,
                      'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                      'tgl_antrian'=>$dateNow,
                       'kode_antrian'=>$this->input->post('kode_antrian'));
            $proses = $this->Dashboard_model->simpanAntrian($data);
            if (!$proses) {
                    //script pake print nomor antrian
                    $url = base_url('index.php/cetakAntrian');
                    echo "<script>window.open('".$url."','_blank');</script>";
                    echo "<script>history.go(-2);</script>";

                    //script ga pake print
                    // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";
                } else {
                    echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                }


        } else {
            $data = array('created_at'=>$dateNow,
                      'id_dokter'=>$this->input->post('namaDokter'),
                      'id_pasien'=>$this->input->post('namaPasien'),
                      'no_antrian'=>$this->input->post('noAntrian'),
                      'status_antrian'=>$statusAntrian,
                      'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                      'tgl_antrian'=>$dateNow,
                      'kode_antrian'=>$this->input->post('kode_antrian'));
            $proses = $this->Dashboard_model->simpanAntrian($data);
            if (!$proses) {
                    // header('Location: antrian.php');
                    //script pake print nomot antrian
                    $url = base_url('index.php/cetakAntrian');
                    echo "<script>window.open('".$url."','_blank');</script>";
                    echo "<script>history.go(-2);</script>";
                    // echo "<script>alert('Data Berhasil Disimpan');window.location='".$url."'</script>"; 

                    //script ga pake print nomor antrian
                    // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";
                } else {
                    echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                }

        }
    }


    public function updateDataAntrian(){
    	// $id = $this->input->post('id');
    	$id = $this->uri->segment(3);
        $noAntrian = $this->uri->segment(4);
        $jenisPel  = $this->uri->segment(5);

    	$status="Selesai";
		$data = array('id'=> $id ,'status_antrian' => $status);
		
		$proses = $this->Dashboard_model->updateAntrian($id, $data);
			if (!$proses) {
				// echo "Berhasil";
				// echo $id;
				redirect('index.php/Dashboard/?panggil='.$noAntrian.'-'.$jenisPel);
				//echo "<script>history.go(-1)</script>";
			} else {
				echo "<script>alert('Data Gagal Di Update');history.go(-1)</script>";
			}
		
    }
    public function getBbLahir($kirimIdPasien){
        return $this->Dashboard_model->getBbLahir($kirimIdPasien);   
    }
    public function getJmlAnak($idPasienKb){
        return $this->Dashboard_model->getJmlAnak($idPasienKb);
    }

    public function getNoPelayanan()
    {
        $idpelayanan = $this->input->post('id');
        $data = $this->Dashboard_model->getNoPelayanan($idpelayanan);
        
        $output = "";
     
        foreach ($data as $row) {
            $getNo = $row->no_antrian;

            $counterNumber = $getNo+1;
            $output .= $counterNumber; 
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }



   

    
}
