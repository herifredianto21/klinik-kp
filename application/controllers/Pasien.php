<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {

  private $userData;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model('login_model', 'login');
    $this->load->model('Pasien_model');

    $this->userData = array(
      'session' => $this->session->userdata('userSession'),
      'host'    => $this->input->get_request_header('Host', TRUE),
      'referer' => $this->input->get_request_header('Referer', TRUE),
      'agent'   => $this->input->get_request_header('User-Agent', TRUE),
      'ipaddr'  => $this->input->ip_address()
    );

    $auth = $this->login->auth($this->userData);
    if(!$auth){
      if ($this->agent->is_browser()) {
        redirect();
      } else{
        $response = array(
          'result'  => false,
          'msg'   => 'Unauthorized access.'
        );
        echo json_encode($response, JSON_PRETTY_PRINT);
      }
    }
  }

  public function index()
  {
    $data['tPasien']=$this->Pasien_model->tampilDataPasien();
    $this->load->view('pasien',$data);
    }

    public function getDataKunjungan(){
      $id=$this->uri->segment(3);
      $data['gBb'] = $this->Pasien_model->getBbLahir($id);
      $data['gDp'] = $this->Pasien_model->getDaftarPenyakit();
      $data['gRu'] = $this->Pasien_model->getRentangUmur();
      $data['gTi'] = $this->Pasien_model->getTindakanImunisasi();
      $data['query'] = $this->Pasien_model->getDataKunjungan($id);
      $data['jmlAnak'] = $this->Pasien_model->getJmlAnak($id);
      $data['pelayanan'] = $this->Pasien_model->getJenisPelayanan();
      $data['kdAntrian'] = $this->Pasien_model->getKodeAntrian();
      $data['tDokter'] = $this->Pasien_model->getDokter();
      $data['alatKontra'] = $this->Pasien_model->getAlatKontrasepsi();
      $this->load->view('kunjungan',$data);
    }



    public function getNoPelayanan()
    {
        $idpelayanan = $this->input->post('id');
        $data = $this->Pasien_model->getNoPelayanan($idpelayanan);
        
        $output = "";
     
        foreach ($data as $row) {
            $getNo = $row->no_antrian;

            $counterNumber = $getNo+1;
            $output .= $counterNumber; 
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function simpanKunjungan(){
      $dateNow = $waktuSekarang = gmdate("Y-m-d H:i:s", time()+60*60*7);
        $statusAntrian = "Proses";
        $antrian = $this->input->post('noAntrian');
        $idLayanan = $this->input->post('jenisPelayanan');
        $getIdAntrian = $this->input->post('idAntrian');
        $kodeAntrian = $getIdAntrian + 1;
        if ($idLayanan == 1) {
            // start fungsi simpan data ke table pemeriksaan kehamilan
            if (empty($antrian)) {
            //untuk simpan ke table antrian
            $no = "1";
            $data = array('created_at'=>$dateNow,
                      'id_dokter'=>$this->input->post('namaDokter'),
                      'id_pasien'=>$this->input->post('namaPasien'),
                      'no_antrian'=>$no,
                      'status_antrian'=>$statusAntrian,
                      'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                      'tgl_antrian'=>$dateNow,
                       'kode_antrian'=>$this->input->post('kode_antrian'));
            
            //untuk simpan ke table detail_pemeriksaan kehamilan
             
            $dataDpk = array('id_antrian'=>$kodeAntrian,
                'id_pasien'=>$this->input->post('namaPasien'),
                'tgl_lahir'=>$this->input->post('tglLahir'),
                'nik'=>$this->input->post('nik'),
                'umur'=>$this->input->post('umur'),
                'nama_suami'=>$this->input->post('namaPj'),
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
                $prosesDpk = $this->Pasien_model->simpanPemeriksaanKehamilan($dataDpk); //simpan data ke table detail_pemeriksaan kehamilan ke table detail_pemeriksaan_kehamilan
                $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                    
                    if (!$proses & !$prosesDpk) {
                            //script pake print nomor antrian
                            $url = base_url('index.php/cetakKartu');
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
                    //untuk simpan ke db detail_pemeriksaan kehamilan
                    $dataDpk = array('id_antrian'=>$kodeAntrian,
                        'id_pasien'=>$this->input->post('namaPasien'),
                        'tgl_lahir'=>$this->input->post('tglLahir'),
                        'nik'=>$this->input->post('nik'),
                        'umur'=>$this->input->post('umur'),
                        'nama_suami'=>$this->input->post('namaPj'),
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
                    $prosesDpk = $this->Pasien_model->simpanPemeriksaanKehamilan($dataDpk); 
                    $proses = $this->Pasien_model->simpanAntrian($data);
                    if (!$proses & !$prosesDpk) {
                            // header('Location: antrian.php');
                            //script pake print nomot antrian
                            $url = base_url('index.php/cetakKartu');
                            echo "<script>window.open('".$url."','_blank');</script>";
                            echo "<script>history.go(-2);</script>";

                            //script ga pake print nomor antrian
                            // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";

                        } else {
                            echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                        }
                }
                // end fungsi simpan data ke table detail pemeriksaan kehamilan
      
        } else if ($idLayanan == 3){
                // start fungsi simpan data ke table persalinan
                if (empty($antrian)) {
                //untuk simpan ke table antrian
                $no = "1";
                $data = array('created_at'=>$dateNow,
                          'id_dokter'=>$this->input->post('namaDokter'),
                          'id_pasien'=>$this->input->post('namaPasien'),
                          'no_antrian'=>$no,
                          'status_antrian'=>$statusAntrian,
                          'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                          'tgl_antrian'=>$dateNow,
                           'kode_antrian'=>$this->input->post('kode_antrian'));
                
                //untuk simpan ke table persalinan
                $dataPs = array('id_antrian'=>$kodeAntrian,
                    'id_pasien'=>$this->input->post('namaPasien'),
                    'umur'=>$this->input->post('umur'),
                    'alamat'=>$this->input->post('alamat'),
                    'anak_ke'=>$this->input->post('anakKe'),
                    'bb'=>$this->input->post('bbPersalinan'),
                    'pb'=>$this->input->post('pb'),
                    'tgl_lahir'=>$this->input->post('tglLahir'),
                    'jam_lahir'=>$this->input->post('jamLahir'),
                    'jenis_kelamin'=>$this->input->post('jenisKelamin'),
                    'imd'=>$this->input->post('imd'),
                    'lingkar_kepala'=>$this->input->post('lingkarKepala'),
                    'resiko'=>$this->input->post('resikoPersalinan'),
                    'keterangan'=>$this->input->post('keteranganPersalinan'),
                    'catatan'=>$this->input->post('catatanPersalinan'));

                $prosesPs = $this->Pasien_model->simpanDataPersalinan($dataPs); // simpan data ke table detail_persalinan
                $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                        
                        if (!$proses & !$prosesPs) {
                                //script pake print nomor antrian
                                $url = base_url('index.php/cetakKartu');
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
                        //untuk simpan ke table persalinan
                        $dataPs = array('id_antrian'=>$kodeAntrian,
                            'id_pasien'=>$this->input->post('namaPasien'),
                            'umur'=>$this->input->post('umur'),
                            'alamat'=>$this->input->post('alamat'),
                            'anak_ke'=>$this->input->post('anakKe'),
                            'bb'=>$this->input->post('bbPersalinan'),
                            'pb'=>$this->input->post('pb'),
                            'tgl_lahir'=>$this->input->post('tglLahir'),
                            'jam_lahir'=>$this->input->post('jamLahir'),
                            'jenis_kelamin'=>$this->input->post('jenisKelamin'),
                            'imd'=>$this->input->post('imd'),
                            'lingkar_kepala'=>$this->input->post('lingkarKepala'),
                            'resiko'=>$this->input->post('resikoPersalinan'),
                            'keterangan'=>$this->input->post('keteranganPersalinan'),
                            'catatan'=>$this->input->post('catatanPersalinan'));

                        $prosesPs = $this->Pasien_model->simpanDataPersalinan($dataPs); // simpan data ke table detail_persalinan
                        $proses = $this->Pasien_model->simpanAntrian($data);
                        if (!$proses & !$prosesPs ) {
                                // header('Location: antrian.php');
                                //script pake print nomot antrian
                                $url = base_url('index.php/cetakKartu');
                                echo "<script>window.open('".$url."','_blank');</script>";
                                echo "<script>history.go(-2);</script>";

                                //script ga pake print nomor antrian
                                // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";

                            } else {
                                echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                            }
                    }
                    // end fungsi simpan data ke table persalinan
            
        } else if ($idLayanan == 8){
            if (empty($antrian)) {
                //untuk simpan ke table antrian
                $no = "1";
                $data = array('created_at'=>$dateNow,
                          'id_dokter'=>$this->input->post('namaDokter'),
                          'id_pasien'=>$this->input->post('namaPasien'),
                          'no_antrian'=>$no,
                          'status_antrian'=>$statusAntrian,
                          'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                          'tgl_antrian'=>$dateNow,
                           'kode_antrian'=>$this->input->post('kode_antrian'));
                
                //untuk simpan ke table detail_imunisasi
                $dataIm=array('id_antrian'=>$kodeAntrian,
                     'created_at'=>$dateNow,
                     'id_pasien'=>$this->input->post('namaPasien'),
                     'nama_anak'=>$this->input->post('namaAnak'),
                     'no_kk'=>$this->input->post('noKkImunisasi'),
                     'alamat'=>$this->input->post('alamat'),
                     'tgl_lahir'=>$this->input->post('tglLahir'),
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
                //start untuk update no_kk Pasien di table pasiens
                $id=$this->input->post('namaPasien');
                $kk=array('no_kk'=>$this->input->post('noKkImunisasi'));
                // end untuk update no_kk pasien di table pasiens
                    
                $updateKk = $this->Pasien_model->updateNoKk($id, $kk);// update no_kk di table pasien                
                $prosesIm = $this->Pasien_model->simpanDataImunisasi($dataIm); // simpan data ke table detail_imunisasi
                $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                        
                        if (!$proses & !$prosesIm) {
                                //script pake print nomor antrian
                                $url = base_url('index.php/cetakKartu');
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
                         //untuk simpan ke table detail_imunisasi
                            $dataIm=array('id_antrian'=>$kodeAntrian,
                                 'created_at'=>$dateNow,
                                 'id_pasien'=>$this->input->post('namaPasien'),
                                 'nama_anak'=>$this->input->post('namaAnak'),
                                 'no_kk'=>$this->input->post('noKkImunisasi'),
                                 'alamat'=>$this->input->post('alamat'),
                                 'tgl_lahir'=>$this->input->post('tglLahir'),
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
                            //start untuk update no_kk Pasien di table pasiens
                            $id=$this->input->post('namaPasien');
                            $kk=array('no_kk'=>$this->input->post('noKkImunisasi'));
                            // end untuk update no_kk pasien di table pasiens
                                
                            $updateKk = $this->Pasien_model->updateNoKk($id, $kk);// update no_kk di table pasien                
                            $prosesIm = $this->Pasien_model->simpanDataImunisasi($dataIm); // simpan data ke table detail_imunisasi
                            $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                        if (!$proses & !$prosesIm ) {
                                // header('Location: antrian.php');
                                //script pake print nomot antrian
                                $url = base_url('index.php/cetakKartu');
                                echo "<script>window.open('".$url."','_blank');</script>";
                                echo "<script>history.go(-2);</script>";

                                //script ga pake print nomor antrian
                                // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";

                            } else {
                                echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                            }
                    }
                    // end fungsi simpan data ke table persalinan


        } else if ($idLayanan == 9){
            if (empty($antrian)) {
                //untuk simpan ke table antrian
                $no = "1";
                $data = array('created_at'=>$dateNow,
                          'id_dokter'=>$this->input->post('namaDokter'),
                          'id_pasien'=>$this->input->post('namaPasien'),
                          'no_antrian'=>$no,
                          'status_antrian'=>$statusAntrian,
                          'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                          'tgl_antrian'=>$dateNow,
                           'kode_antrian'=>$this->input->post('kode_antrian'));
                
                //untuk simpan ke table detail_pemeriksaan_umum
                $dataUmum = array('id_antrian'=>$kodeAntrian,
                      'jenis_kelamin'=>$this->input->post('jenisKelaminUmum'),
                      'id_penyakit'=>$this->input->post('idPenyakitUmum'),
                      'id_rentang_umur'=>$this->input->post('idRentangUmurUmum'),
                      'id_macam_tindakan_imunisasi'=>$this->input->post('idTindakanUmum'),
                      'catatan'=>$this->input->post('catatanDokterUmum'));
                $prosesUmum = $this->Pasien_model->simpanPemeriksaanUmum($dataUmum); // simpan data ke table pemeriksaan umum
                $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                        
                        if (!$proses & !$prosesUmum) {
                                //script pake print nomor antrian
                                $url = base_url('index.php/cetakKartu');
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
                         //untuk simpan ke table detail_pemeriksaan_umum
                          $dataUmum = array('id_antrian'=>$kodeAntrian,
                                'jenis_kelamin'=>$this->input->post('jenisKelaminUmum'),
                                'id_penyakit'=>$this->input->post('idPenyakitUmum'),
                                'id_rentang_umur'=>$this->input->post('idRentangUmurUmum'),
                                'id_macam_tindakan_imunisasi'=>$this->input->post('idTindakanUmum'),
                                'catatan'=>$this->input->post('catatanDokterUmum'));
                          $prosesUmum = $this->Pasien_model->simpanPemeriksaanUmum($dataUmum); // simpan data ke table pemeriksaan umum
                          $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                                  
                        if (!$proses & !$prosesUmum) {
                                //script pake print nomor antrian
                                $url = base_url('index.php/cetakKartu');
                                echo "<script>window.open('".$url."','_blank');</script>";
                                echo "<script>history.go(-2);</script>";

                                //script ga pake print
                                // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";
                            } else {
                                echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                            }
                    }
                    // end fungsi simpan data ke table persalinan  

        } else if ($idLayanan == 34){
              if (empty($antrian)) {
                    //untuk simpan ke table antrian
                    $no = "1";
                    $data = array('created_at'=>$dateNow,
                              'id_dokter'=>$this->input->post('namaDokter'),
                              'id_pasien'=>$this->input->post('namaPasien'),
                              'no_antrian'=>$no,
                              'status_antrian'=>$statusAntrian,
                              'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                              'tgl_antrian'=>$dateNow,
                               'kode_antrian'=>$this->input->post('kode_antrian'));
                    
                    //untuk simpan ke table detail_pemeriksaan_ispa
                    $dataIs=array('id_antrian'=>$kodeAntrian,
                      'nama_anak'=>$this->input->post('namaAnakIspa'),
                      'jenis_kelamin'=>$this->input->post('jkIspa'),
                      'umur_tahun'=>$this->input->post('umurTahun'),
                      'umur_bulan'=>$this->input->post('umurBulan'),
                      'tb_pb'=>$this->input->post('tbPbIspa'),
                      'bb'=>$this->input->post('bbIspa'),
                      'catatan'=>$this->input->post('catatanIspa'));
                    $prosesIs=$this->Pasien_model->simpanDataProgramIspa($dataIs); // simpan data pemeriksaan ispa
                    $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                            
                            if (!$proses & !$prosesIspa) {
                                    //script pake print nomor antrian
                                    $url = base_url('index.php/cetakKartu');
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
                             //untuk simpan ke table detail_pemeriksaan_ispa
                             $dataIs=array('id_antrian'=>$kodeAntrian,
                                'nama_anak'=>$this->input->post('namaAnakIspa'),
                                'jenis_kelamin'=>$this->input->post('jkIspa'),
                                'umur_tahun'=>$this->input->post('umurTahun'),
                                'umur_bulan'=>$this->input->post('umurBulan'),
                                'tb_pb'=>$this->input->post('tbPbIspa'),
                                'bb'=>$this->input->post('bbIspa'),
                                'catatan'=>$this->input->post('catatanIspa'));
                             $prosesIs=$this->Pasien_model->simpanDataProgramIspa($dataIs); // simpan data pemeriksaan ispa
                             $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                                      
                            if (!$proses & !$prosesIs) {
                                    //script pake print nomor antrian
                                    $url = base_url('index.php/cetakKartu');
                                    echo "<script>window.open('".$url."','_blank');</script>";
                                    echo "<script>history.go(-2);</script>";

                                    //script ga pake print
                                    // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";
                                } else {
                                    echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                                }
                        }
                        // end fungsi simpan data ke table persalinan  
        } else if($idLayanan == 37){
              if (empty($antrian)) {
                    //untuk simpan ke table antrian
                    $no = "1";
                    $data = array('created_at'=>$dateNow,
                              'id_dokter'=>$this->input->post('namaDokter'),
                              'id_pasien'=>$this->input->post('namaPasien'),
                              'no_antrian'=>$no,
                              'status_antrian'=>$statusAntrian,
                              'id_jenis_pelayanan'=>$this->input->post('jenisPelayanan'),
                              'tgl_antrian'=>$dateNow,
                              'kode_antrian'=>$this->input->post('kode_antrian'));
                    
                    //untuk simpan ke table detail_pemeriksaan_kb
                    $satu = $this->input->post('jmlAnakLakiKb');
                    $dua =  $this->input->post('jmlAnakPerempuanKb');
                    $hitung = $satu + $dua;
                    $dataKb = array('id_antrian'=>$kodeAntrian,
                              'created_at'=>$dateNow,
                              'id_pasien'=>$this->input->post('namaPasien'),
                              'umur'=>$this->input->post('umurPasienKb'),
                              'nama_pasien'=>$this->input->post('namaP'),
                              'nama_suami'=>$this->input->post('namaPjKb'),
                              'alamat'=>$this->input->post('alamatPasienKb'),
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
                    $prosesKb=$this->Pasien_model->simpanPemeriksaanKb($dataKb);
                    $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                            
                            if (!$proses & !$prosesKb) {
                                    //script pake print nomor antrian
                                    $url = base_url('index.php/cetakKartu');
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
                             //untuk simpan ke table detail_pemeriksaan_kb
                              $satu = $this->input->post('jmlAnakLakiKb');
                              $dua =  $this->input->post('jmlAnakPerempuanKb');
                              $hitung = $satu + $dua;
                              $dataKb = array('id_antrian'=>$kodeAntrian,
                                        'created_at'=>$dateNow,
                                        'id_pasien'=>$this->input->post('namaPasien'),
                                        'umur'=>$this->input->post('umurPasienKb'),
                                        'nama_pasien'=>$this->input->post('namaP'),
                                        'nama_suami'=>$this->input->post('namaPjKb'),
                                        'alamat'=>$this->input->post('alamatPasienKb'),
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
                              $prosesKb=$this->Pasien_model->simpanPemeriksaanKb($dataKb);
                              $proses = $this->Pasien_model->simpanAntrian($data); //simpan data antrian ke table antrian
                                      
                            if (!$proses & !$prosesKb) {
                                    //script pake print nomor antrian
                                    $url = base_url('index.php/cetakKartu');
                                    echo "<script>window.open('".$url."','_blank');</script>";
                                    echo "<script>history.go(-2);</script>";

                                    //script ga pake print
                                    // echo "<script>alert('Data Berhasil Disimpan');window.location='index'</script>";
                                } else {
                                    echo "<script>alert('Data Gagal Di Simpan');history.go(-2)</script>";
                                }
                        }
                        // end fungsi simpan data ke table persalinan  
              }
        
            
        
      
    }
    public function simpanPendaftaranBaru(){
      
      $dateNow = $waktuSekarang = gmdate("Y-m-d H:i:s", time()+60*60*7);
      $null = "0";
      //get foto
      $img = $this->input->post('image');
      if ($img == null) 
      {
        $data = array('created_at'=>$dateNow,
                  'no_kk'=>$this->input->post('nokk'),
                  'jk_pasien'=>$this->input->post('jk_pasien'),
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
                  'catatan_bidan'=>$this->input->post('catatan_bidan'),
                  'image'=>$null);
                  $proses=$this->Pasien_model->simpanDataPasien($data);

                    if (!$proses) {
                      //script pake print kartu berobat
                        $getId = $this->input->post('idPasien');
                        $idPasien= $getId + 1;
                        $url = base_url('CetakKartu/CetakKartuPasien/'.$idPasien.'/1'.'');

                        $urlKunjungan = base_url('index.php/Pasien/getDataKunjungan/'.$idPasien.'');
                        echo "<script>window.open('".$url."','_blank');</script>";
                        // echo "<script>history.go(-2);</script>";  
                        echo "<script>window.location='".$urlKunjungan."'</script>";
                        //script ga pake print kartu berobat
                        // echo "<script>alert('Data Berhasil Di Simpan');history.go(-2);</script>";
                      
                    } else {
                      echo "Data Gagal Disimpan";
                      echo "<br>";
                      echo "<a href='".base_url('index.php/DataDokter/index/')."'>Kembali ke form</a>";
                    }
      } 
      else 
      {
        $folderPath = "upload/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
      
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
      
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        
        // simpan data

        $data = array('created_at'=>$dateNow,
                  'no_kk'=>$this->input->post('nokk'),
                  'jk_pasien'=>$this->input->post('jk_pasien'),
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
                  'catatan_bidan'=>$this->input->post('catatan_bidan'),
                  'image'=>$fileName);
                  $proses=$this->Pasien_model->simpanDataPasien($data);

                    if (!$proses) {
                      //script pake print kartu berobat
                        $getId = $this->input->post('idPasien');
                        $idPasien= $getId + 1;
                        $url = base_url('CetakKartu/CetakKartuPasien/'.$idPasien.'/1'.'');

                        $urlKunjungan = base_url('index.php/Pasien/getDataKunjungan/'.$idPasien.'');
                        echo "<script>window.open('".$url."','_blank');</script>";
                        // echo "<script>history.go(-2);</script>";  
                        echo "<script>window.location='".$urlKunjungan."'</script>";
                        //script ga pake print kartu berobat
                        // echo "<script>alert('Data Berhasil Di Simpan');history.go(-2);</script>";
                      
                    } else {
                      echo "Data Gagal Disimpan";
                      echo "<br>";
                      echo "<a href='".base_url('index.php/DataDokter/index/')."'>Kembali ke form</a>";
                    }

      }
      
    }
    public function pendaftaranBaru(){
      $data['tNoRegis']=$this->Pasien_model->getNoRegis();
      $data['tPekerjaan']=$this->Pasien_model->getPekerjaan();
      $data['tKota'] = $this->Pasien_model->getKota();
      $data['tDesa'] = $this->Pasien_model->getDesa();
      $this->load->view('form_pendaftaran',$data);
    }

    public function hapusDataPasien(){

      $id = $this->uri->segment(3);
      $dateNow = gmdate("Y-m-d H:i:s", time()+60*60*7);
      
      $data = array('deleted_at'=> $dateNow);
      
      $proses = $this->Pasien_model->hapusDataPasien($id, $data);
        if (!$proses) {
           $_SESSION['pesan'] = 'Data Berhasil Dihapus';
           echo "<script>history.go(-1)</script>";
          // echo "<script>alert('Data Berhasil Di Hapus');history.go(-1)</script>";
        } else {
          echo "<script>alert('Data Gagal Di Hapus');history.go(-1)</script>";
        }
    
    }

    public function editDataPasien(){
      $id=$this->input->post('id');
      $dateNow = gmdate("Y-m-d H:i:s", time()+60*60*7);
      $img = $this->input->post('image');
      
      if ($img == null) 
      {
        //update tanpa foto
        $data = array('updated_at'=> $dateNow,
                    'no_kk'=>$this->input->post('noKk'),
                    'nik'=>$this->input->post('nik'),
                    'nama_pasien'=>$this->input->post('nama_pasien'),
                    'tgl_lahir'=>$this->input->post('tgl_lahir'),
                    'jk_pasien'=>$this->input->post('jk_pasien'),
                    'pendidikan_pasien'=>$this->input->post('pendidikan_pasien'),
                    'agama_pasien'=>$this->input->post('agama_pasien'),
                    'pekerjaan_pasien'=>$this->input->post('pekerjaan_pasien'),
                    'alamat_ktp_pasien'=>$this->input->post('alamat_ktp_pasien'),
                    'alamat_pasien'=>$this->input->post('alamat_pasien'),
                    'nama_ayah_kandung'=>$this->input->post('nama_ayah_kandung'),
                    'nama_pj'=>$this->input->post('nama_pj'),
                    'tgl_lahir_pj'=>$this->input->post('tgl_lahir_pj'),
                    'pendidikan_pj'=>$this->input->post('nik'),
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
                    'catatan_bidan'=>$this->input->post('catatan_bidan'));
                    $proses = $this->Pasien_model->editDataPasien($id, $data);
                    if (!$proses) 
                    {
                       $_SESSION['pesan'] = 'Data Berhasil Diperbarui';
                       echo "<script>history.go(-2)</script>";
                       // echo "<script>alert('Data Berhasil Di Hapus');history.go(-1)</script>";
                    } 
                    else 
                    {
                        echo "<script>alert('Data Gagal Di Hapus');history.go(-1)</script>";
                    }

      }
      else
      {
        //update foto baru
        $folderPath = "upload/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        
        $data = array('updated_at'=> $dateNow,
                    'image'=>$fileName,
                    'no_kk'=>$this->input->post('noKk'),
                    'nik'=>$this->input->post('nik'),
                    'nama_pasien'=>$this->input->post('nama_pasien'),
                    'tgl_lahir'=>$this->input->post('tgl_lahir'),
                    'jk_pasien'=>$this->input->post('jk_pasien'),
                    'pendidikan_pasien'=>$this->input->post('pendidikan_pasien'),
                    'agama_pasien'=>$this->input->post('agama_pasien'),
                    'pekerjaan_pasien'=>$this->input->post('pekerjaan_pasien'),
                    'alamat_ktp_pasien'=>$this->input->post('alamat_ktp_pasien'),
                    'alamat_pasien'=>$this->input->post('alamat_pasien'),
                    'nama_ayah_kandung'=>$this->input->post('nama_ayah_kandung'),
                    'nama_pj'=>$this->input->post('nama_pj'),
                    'tgl_lahir_pj'=>$this->input->post('tgl_lahir_pj'),
                    'pendidikan_pj'=>$this->input->post('nik'),
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
                    'catatan_bidan'=>$this->input->post('catatan_bidan'));
                    $proses = $this->Pasien_model->editDataPasien($id, $data);
                    if (!$proses) 
                    {
                       $_SESSION['pesan'] = 'Data Berhasil Diperbarui';
                       echo "<script>history.go(-2)</script>";
                       // echo "<script>alert('Data Berhasil Di Hapus');history.go(-1)</script>";
                    } 
                    else 
                    {
                        echo "<script>alert('Data Gagal Di Hapus');history.go(-1)</script>";
                    }
      }
      
    
    }
    
    public function detailPasien($id){
   
      $id=$this->uri->segment(3);
      
      if ($this->uri->segment(4) == null) {
        $data['tKota'] = $this->Pasien_model->getKota();
        $data['tDesa'] = $this->Pasien_model->getDesa();
        $data['tPekerjaan']=$this->Pasien_model->getPekerjaan();
        $data['gDataPasien'] = $this->Pasien_model->getDataPasien($id);
        $data['gDataHistory'] = $this->Pasien_model->getDataHistory($id);
        $this->load->view('pasien_detail',$data);
      } else {
        $data['tKota'] = $this->Pasien_model->getKota();
        $data['tDesa'] = $this->Pasien_model->getDesa();
        $data['tPekerjaan']=$this->Pasien_model->getPekerjaan();
        $data['gDataPasien'] = $this->Pasien_model->getDataPasien($id);
        $this->load->view('pasien_edit',$data);
      }
      
    }

}