<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.png');?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Klinik Nur Khadijah | Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?php echo base_url('assets/css/gf.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/fa/css/all.min.css'); ?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/css/now-ui-dashboard.css?v=1.3.0'); ?>" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/DataTables/datatables.min.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css'); ?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-bootstrap4.css'); ?>"/>
  <script type="text/javascript">
    var baseurl = "<?php echo base_url(); ?>";
  </script>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="blue">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
      <div class="logo">
        <a href="<?php echo base_url(); ?>" class="simple-text logo-mini">
          <i class="now-ui-icons media-2_sound-wave"></i>
        </a>
        <a href="<?php echo base_url(); ?>" class="simple-text logo-normal">
          Klinik Nur Khadijah
        </a>
      </div>
      <?php $this->load->view('sidebar'); ?>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="menuProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuProfile">
                  <a class="dropdown-item" href="#">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>Profile</p>
                  </a>
                  <a class="dropdown-item" href="<?php echo base_url('dashboard/logout/'); ?>">
                    <i class="now-ui-icons media-1_button-power"></i>
                    <p>Logout</p>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>

      <!-- start content -->
      <div class="content">
    <!-- start = row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card" >
              <div class="card-header">
                <div class="row">
                  <div class="col-12">
                    <h4 class="card-title"> Ubah Data kunjungan </h4>
                    <hr>
                  </div>
                </div>
              </div>
              <!-- start = body form tambah kunjungan -->
              <div class="card-body">
                  <div class="row">
                    <?php
                      foreach ($query->result() as $kp ) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>Jenis Pelayanan</label>
                              <br>
                              <input type="text" value="<?php echo $kp->nama_pelayanan;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>Pasien</label>
                                             
                                <input type="text" class="form-control" value="<?php echo $kp->nama_pasien;?>" readonly>
                           
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Dokter</label>
                            <input type="text" class="form-control" value="<?php echo $kp->nama_dokter;?>" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No. Antrian</label>
                            <textarea id="noPelayanan" name="noAntrian" class="form-control" style="height:30px; padding-top: 5px; padding-left: 20px;" readonly><?php echo $kp->no_antrian;?> </textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Kunjungan</label>
                            <input type="text" name="tgl_antrian" class="form-control" placeholder="Tanggal Antrian" value="<?php echo $kp->tgl_antrian;?>" required readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Kode Antrian</label>
                            <input type="text" name="kode_antrian" class="form-control" placeholder="Kode Antrian" value="<?php echo $kp->kode_antrian;?>"readonly>
                          
                            
                          </div>
                        </div>
                       <?php } ?>
                      </div>
                      <div class="modal-footer">
                       <!--  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                       
                        <button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</button> -->
                      </div>    
                

              </div>
              <!-- end = body form tambah kunjungan -->
              <?php 
                  $jenisPelayanan = $this->uri->segment(4);
                  $idAntrian = $this->uri->segment(3);
                  if($jenisPelayanan == 'PemeriksaanKehamilan'){ ?>
              <!-- start form pemeriksaan kehamilan -->
                  <form method="POST" action="<?php echo base_url('Antrian/updatePemeriksaanKehamilan');?>">     
                  <div id="1" class="myDiv">
                    <div class="modal-body">
                        <div class="row">
                        <input type="text" name="getIdAntrian" value="<?php echo $idAntrian;?>" hidden>                         
                          <div class="col-md-12">
                            <h3><b>Hasil Pemeriksaan Awal:</b></h3>
                          </div>
                          <?php foreach ($query->result() as $kp ) { ?>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Tanggal Lahir</label>
                              <input type="date" name="tglLahir" value="<?php echo $kp->tgl_lahir;?>" class="form-control" placeholder="Tanggal Lahir" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>NIK</label>
                              <input type="text" name="nik" class="form-control" value="<?php echo $kp->nik;?>" placeholder="NIK" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Umur</label>
                              <?php
                                //waktu sekarang
                                $tglSekarang = date('yy-m-d');
                                $waktuSekarang = explode('-', $tglSekarang);
                                //tgl lahir pasien
                                $tglPasien= $kp->tgl_lahir;
                                $waktuPasien = explode('-',$tglPasien);
                                //hitung umur
                                $getHari = $waktuSekarang[2] - $waktuPasien[2];
                                $getBulan = $waktuSekarang[1] - $waktuPasien [1];
                                $getTahun = $waktuSekarang[0] - $waktuPasien [0];
                                //hasil umur
                                $umurPasien=abs($getTahun)." Tahun ".abs($getBulan)." Bulan ".abs($getHari)." Hari"; 
                                
                              ?>
                              <input type="text" name="umur" value="<?php echo $umurPasien;?>"  class="form-control" placeholder="Umur" readonly required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Nama Suami</label>
                              <input type="text" name="namaPj" value="<?php echo $kp->nama_pj?>"class="form-control" placeholder="Nama Suami" readonly required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>No. KK</label>
                                <input type="text" name="noKk" value="<?php echo $kp->no_kk;?>" class="form-control" placeholder="No. KK" readonly>  
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Alamat</label>
                              <textarea name="alamat" class="form-control" placeholder="Alamat" readonly><?php echo $kp->alamat_ktp_pasien;?>  </textarea>
                            </div>
                          </div>
                          <?php } ?>

                          <!-- diagnosa pemeriksaan kehamilan-->
                          
                            <?php foreach ($getPk->result() as $gpk) { ?>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>KIA</label>
                                <select name="bukuKia" class="form-control">
                                  <option><?php echo $gpk->buku_kia;?></option>
                                  <option value="Lama">Lama</option>
                                  <option value="Laru">Baru</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>HPHT</label>
                                <input type="date" name="hpht" value="<?php echo $gpk->hpht;?>" class="form-control" placeholder="HPHT" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>TP</label>
                                <input type="date" name="tp" class="form-control" value="<?php echo $gpk->tp;?>" placeholder="TP" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>BB</label>
                                <input type="number" name="bb" class="form-control" value="<?php echo $gpk->bb;?>" placeholder="Berat Badan" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>TB</label>
                                <input type="number" name="tb" class="form-control"value="<?php echo $gpk->tb;?>" placeholder="Tinggi Badan" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Usia Kehamilan (minggu)</label>
                                <input type="text" name="usiaKehamilan" class="form-control" value="<?php echo $gpk->usia_kehamilan;?>"placeholder="Usia Kehamilan">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>GPA</label>
                                <input type="text" name="gpa" value="<?php echo $gpk->gpa;?>" class="form-control" placeholder="GPA" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>K1</label>
                                <select name="k1" class="form-control">
                                  <option value="<?php echo $gpk->k1;?>">
                                    <?php if($gpk->k1 == 1){
                                        echo "Ya";
                                      } else {
                                        echo "Tidak";
                                      }
                                    ?>
                                  </option>
                                  <option value="1">Ya</option>
                                  <option value="0">Tidak</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>K4</label>
                                <select name="k4" class="form-control">
                                  <option value="<?php echo $gpk->k4;?>">
                                    <?php if($gpk->k4 == 1){
                                        echo "Ya";
                                      } else {
                                        echo "Tidak";
                                      }
                                    ?>
                                  </option>
                                  <option value="1">Ya</option>
                                  <option value="0">Tidak</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>TT</label>
                                <input type="text" name="tt" value="<?php echo $gpk->tt; ?>" class="form-control" placeholder="TT">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>LILA (cm)</label>
                                <input type="number" name="lila" value="<?php echo $gpk->lila; ?>"class="form-control" placeholder="LILA (cm)" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Hb (g/dl)</label>
                                <input type="number" name="hb" class="form-control" value="<?php echo $gpk->hb; ?>"placeholder="Hb (g/dl)">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Resiko</label>
                                <textarea name="resiko" class="form-control"><?php echo $gpk->resiko; ?></textarea>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Keterangan (10 T, Jumlah Fe)</label>
                                <textarea name="keterangan" class="form-control"><?php echo $gpk->keterangan; ?></textarea>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Keterangan Hamil</label>
                                <select name="baruLama" class="form-control">
                                  <option value="<?php echo $gpk->baru_lama; ?>"><?php echo $gpk->baru_lama; ?></option>
                                  <option value="BARU">Baru</option>
                                  <option value="LAMA">Lama</option>
                                </select>
                              </div>
                            </div>  
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control"><?php echo $gpk->catatan?></textarea>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                          <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
                            <a href="<?php echo base_url('antrian');?>" class="btn btn-sm btn-danger">Kembali</a>
                            <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
                          </div>
                     
                    </div>
                  </div>
                  </form>
                  <!-- end form pemeriksaan kehamilan -->
                  
                  <!-- start pemeriksaan Umum -->
                        <?php } else if($jenisPelayanan == 'PemeriksaanUmum'){ ?>
                        <form method="post" action="<?php echo base_url('Antrian/updatePemeriksaanUmum');?>">     
                          <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <h3><b>Hasil Pemeriksaan:</b></h3>
                                  <input type="text" name="getIdAntrian" value="<?php echo $idAntrian;?>" hidden>
                                </div>
                                <?php foreach ($getPu->result() as $pu) { ?>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                      <input type="text" name="jenisKelaminUmum" value="<?php echo $pu->jenis_kelamin;?>" class="form-control" readonly >
                                  </div>
                                </div>
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Nama Penyakit</label>
                                    <select name="idPenyakitUmum" id="namPenyakit" style="width:100%;"class="form-control">
                                      <option value="<?php echo $pu->id_penyakit;?>"><?php echo $pu->nama_penyakit;?></option>
                                      <option value="20">Penyakit Lain-Lain </option>
                                      <?php foreach ($getDp->result() as $dp ) { ?>
                                        <option value="<?php echo $dp->id;?>"><?php echo $dp->nama_penyakit;?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Rentang Umur</ label>
                                    <select name="idRentangUmurUmum" id="renUmur" style="width:100%;" class="form-control">
                                      <option value="<?php echo $pu->id_rentang_umur;?>"><?php echo $pu->rentang_umur;?></option>
                                      
                                      <?php foreach ($getRu->result() as $ru ) { ?>
                                        <option value="<?php echo $ru->id;?>"><?php echo $ru->rentang_umur;?></option>
                                      <?php } ?>
                                    </select>
                                    
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Tindakan: </label>
                                    <select name="idTindakanUmum" class="form-control" id="tindakan" style="width:100%;">
                                      <option value="<?php echo $pu->id_macam_tindakan_imunisasi;?>"><?php echo $pu->nama_tindakan;?></option>
                                      
                                      <?php foreach ($getMt->result() as $mt ) { ?>
                                        <option value="<?php echo $mt->id;?>"><?php echo $mt->nama_tindakan;?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatanDokterUmum" class="form-control"><?php echo $pu->catatan;?></textarea>
                                  </div>
                                </div>
                                <?php } ?>
                              </div>
                              <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
                                <a href="<?php echo base_url('antrian');?>" class="btn btn-sm btn-danger">Kembali</a>
                                <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
                              </div>
                          </div>
                        </form>
                        <!-- end pemeriksaan umum -->

                        <!-- start pemeriksaan kb -->
                        <?php } else if($jenisPelayanan == 'KB'){ ?>
                              <form method="post" action="<?php echo base_url('Antrian/updatePemeriksaanKb');?>">
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <input type="text" name="getIdAntrian" value="<?php echo $idAntrian;?>" hidden>                 
                                        <h3><b>Hasil Pemeriksaan:</b></h3>
                                      </div>
                                      <?php foreach ($getKb->result() as $kb ) { ?> 
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Umur</label>
                                          <input type="text" name="umurPasienKb" value="<?php echo $kb->umur;?>" class="form-control" readonly placeholder="Umur" required>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Nama Suami</label>
                                          <input type="text" value="<?php echo $kp->nama_pj;?>"name="namaPjKb" class="form-control" placeholder="Nama Suami" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Alamat</label>
                                          <textarea name="alamatPasienKb" class="form-control" placeholder="Alamat" readonly><?php echo $kb->alamat;?></textarea>
                                        </div>
                                      </div>
                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Jumlah Anak Laki-laki</label>
                                              <input type="number" value="<?php echo $kb->jml_anak_laki;?>" name="jmlAnakLakiKb" id="anakLaki" class="form-control" placeholder="Jumlah Anak Laki-laki" onkeyup="sum();" >
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label>Jumlah Anak Perempuan</label>
                                            <input type="number" value="<?php echo $kb->jml_anak_perempuan;?>" name="jmlAnakPerempuanKb" id="anakPerempuan" class="form-control" placeholder="Jumlah Anak Perempuan" onkeyup="sum();" >
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Jumlah Anak</label>
                                                <input type="number" value="<?php echo $kb->jml_anak;?>" name="jmlAnakKb" id="jumlahAnak" class="form-control" placeholder="Jumlah Anak" readonly >                      
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Usia Anak Terkecil</label>
                                                <input type="number" value="<?php echo $kb->usia_anak_terkecil;?>" name="usiaAnakTerkecilKb" class="form-control" placeholder="Usia Anak Terkecil">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Satuan Usia</label>
                                            <select name="idSatuanUsiaKb" id="satUsia"class="form-control" style="width:100%;">
                                              <option value="<?php echo $kb->id_satuan_usia;?>">
                                                <?php if ($kb->id_satuan_usia == '1') {
                                                  echo "Hari";
                                                } else if ($kb->id_satuan_usia == '2'){
                                                  echo "Bulan";
                                                } else if ($kb->id_satuan_usia == '3'){
                                                  echo "Tahun";
                                                }
                                                ?>
                                              </option>
                                              <option value="1" >Hari</option>
                                              <option value="2" >Bulan</option>
                                              <option value="3" >Tahun</option>
                                            </select>
                                          </div>
                                        </div>
                                      
                                      


                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Pasang Baru</label>
                                          <select name="pasangBaruKb" id="pasBaru" style="width:100%;" class="form-control">
                                            <option value="<?php echo $kb->pasang_baru;?>">
                                              <?php
                                                if ($kb->pasang_baru == '1') {
                                                  echo "Ya";
                                                } else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Pemasangan / Pencabutan</label>
                                          <select name="pasangCabutKb" id="pasCabut" style="width:100%;" class="form-control">
                                            <option value="<?php echo $kb->pasang_cabut;?>"><?php  $kecil = strtolower($kb->pasang_cabut); echo ucwords($kecil);?></option>
                                            <option value="PEMASANGAN">Pemasangan</option>
                                            <option value="PENCABUTAN">Pencabutan</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Alat Kontrasepsi</label>
                                          <select name="idAlatKontraKb" id="alatKontra" style="width:100%;" class="form-control">
                                          <option value="<?php echo $kb->id_alat_kontrasepsi; ?>"><?php echo $kb->nama_alat; ?></option> 
                                            <?php foreach ($alatKontra->result() as $ak) { ?>
                                              <option value="<?php echo $ak->id;?>"><?php echo $ak->nama_alat;?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>AKLI</label>
                                          <input type="text" value="<?php echo $kb->akli;?>"name="akliKb" class="form-control" placeholder="AKLI">
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>4T</label>
                                          <select name="t4Kb" id="fourT" style="width:100%;" class="form-control">
                                            <option value="<?php echo $kb->t_4;?>">
                                              <?php if ($kb->t_4 == '1') {
                                                echo "Ya";
                                              } else {
                                                echo "Tidak";
                                              }?>
                                            </option>
                                            <option value="1" >Ya</option>
                                            <option value="0">Tidak</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Ganti Cara</label>
                                          <input type="textareaxt" value="<?php echo $kb->ganti_cara;?>" name="gantiCaraKb" class="form-control" placeholder="Ganti Cara">
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label>Catatan</label>
                                          <textarea name="catatanKb"class="form-control"><?php echo $kb->catatan;?></textarea>
                                        </div>
                                      </div>
                                    </div>
                                    <?php } ?>
                                    <div class="modal-footer">
                                      <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
                                      <a href="<?php echo base_url('antrian');?>" class="btn btn-sm btn-danger">Kembali</a>
                                      <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
                                    </div>
                                </div>

                              </form>
                              <!-- end pemeriksaan kb -->
                        
                              <!-- start pemeriksaan imunisasi  -->
                        <?php } else if ($jenisPelayanan == 'Imunisasi'){ ?>
                            <form method="post" action="<?php echo base_url('Antrian/updateImunisasi');?>">
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <input type="text" name="getIdAntrian" value="<?php echo $idAntrian;?>" hidden>  
                                        <h3><b>Hasil Pemeriksaan Awal:</b></h3>
                                      </div>
                                      <?php foreach ($getImunisasi->result() as $gi ) { ?>
                                       
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Nama Anak</label>
                                          <input type="text" name="namaAnak" value="<?php echo $gi->nama_anak;?>" class="form-control" placeholder="Nama Anak" readonly required>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <label>Nama Orang Tua</label>
                                        <?php foreach ($query->result() as $kp ) { ?>
                                        <input type="text" value="<?php echo $kp->nama_pj;?>" class="form-control" readonly>
                                        
                                      </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                            <label>No. KK Ortu</label>
                                              <input type="number" name="noKkImunisasi" value="<?php echo $kp->no_kk;?>" class="form-control" placeholder="No. KK Orang Tua" readonly >    
                                          </div>
                                        </div>
                                        <?php } ?>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Alamat</label>
                                          <textarea name="alamat" class="form-control" placeholder="Alamat" readonly><?php echo $gi->alamat;?></textarea>
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Tanggal Lahir</label>
                                          <input type="date" name="tglLahir" value="<?php echo $gi->tgl_lahir;?>"  class="form-control" placeholder="Tanggal Lahir" readonly required>
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>BB Lahir (Gram)</label>
                                            <input type="number" value="<?php echo $gi->bb_lahir;?>" name="bbLahir" class="form-control"  >
                                        </div>
                                      </div>  

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>BB (Gram)</label>
                                          <input type="number" value="<?php echo $gi->bb;?>"name="bbImunisasi"  class="form-control" placeholder="Berat Badan">
                                          
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>PB (cm)</label>
                                          <input type="number" name="pbImunisasi" value="<?php echo $gi->pb;?>"class="form-control" placeholder="Panjang Badan">
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label>Catatan</label>
                                          <textarea name="catatanImunisasi" class="form-control"><?php echo $gi->catatan;?></textarea>
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <h3><b>Macam Imunisasi:</b></h3>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Hb0</label>
                                          <select name="hb0" class="form-control">
                                            <option value="<?php echo $gi->hb0;?>">
                                              <?php
                                                if ($gi->hb0 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0" >Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>BCG</label>
                                          <select name="bcg" class="form-control">
                                            <option value="<?php echo $gi->bcg;?>">
                                              <?php
                                                if ($gi->bcg == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Polio 1</label>
                                          <select name="polio1" class="form-control">
                                            <option value="<?php echo $gi->polio1;?>">
                                              <?php
                                                if ($gi->polio1 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Polio 2</label>
                                          <select name="polio2" class="form-control">
                                            <option value="<?php echo $gi->polio2;?>">
                                              <?php
                                                if ($gi->polio2 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Polio 3</label>
                                          <select name="polio3" class="form-control">
                                            <option value="<?php echo $gi->polio3;?>">
                                              <?php
                                                if ($gi->polio3 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Polio 4</label>
                                          <select name="polio4" class="form-control">
                                            <option value="<?php echo $gi->polio4;?>">
                                              <?php
                                                if ($gi->polio4 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Pentabio 1</label>
                                          <select name="pentabio1" class="form-control">
                                            <option value="<?php echo $gi->pentabio1;?>">
                                              <?php
                                                if ($gi->pentabio1 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Pentabio 2</label>
                                          <select name="pentabio2" class="form-control">
                                            <option value="<?php echo $gi->pentabio2;?>">
                                              <?php
                                                if ($gi->pentabio2 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Pentabio 3</label>
                                          <select name="pentabio3" class="form-control">
                                            <option value="<?php echo $gi->pentabio3;?>">
                                              <?php
                                                if ($gi->pentabio3 == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Campak</label>
                                          <select name="campak" class="form-control">
                                            <option value="<?php echo $gi->campak;?>">
                                              <?php
                                                if ($gi->campak == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0" >Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>TT</label>
                                          <select name="tt" class="form-control">
                                            <option value="<?php echo $gi->tt;?>">
                                              <?php
                                                if ($gi->tt == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Pentabio Ulang</label>
                                          <select name="pentabioUlang" class="form-control">
                                            <option value="<?php echo $gi->pentabio_ulang;?>">
                                              <?php
                                                if ($gi->pentabio_ulang == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                          <label>Campak Ulang</label>
                                          <select name="campakUlang" class="form-control">
                                            <option value="<?php echo $gi->campak_ulang;?>">
                                              <?php
                                                if ($gi->campak_ulang == 1) {
                                                  echo "Ya";
                                                }else {
                                                  echo "Tidak";
                                                }
                                              ?>
                                            </option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                          </select>
                                        </div>
                                      </div>
                                      <?php } ?>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label><b>Tindakan: </b></label>
                                          <select name="idMacamTindakanImunisasi" id="macTindakan" style="width:100%;" class="form-control">
                                            <option value="<?php echo $gi->id_macam_tindakan_imunisasi;?>"><?php echo $gi->nama_tindakan;?></option>
                                            <?php foreach ($getMt->result() as $ti ) { ?>
                                              <option value="<?php echo $ti->id;?>"><?php echo $ti->nama_tindakan;?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
                                      <a href="<?php echo base_url('antrian');?>" class="btn btn-sm btn-danger">Kembali</a>
                                  <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
                                    </div>
                              </div>
                            </form>
                            <!-- end imunisasi -->

                            <!-- start persalinan -->
                        <?php } else if($jenisPelayanan == 'Persalinan'){ ?>
                            <form method="post" action="<?php echo base_url('Antrian/updatePemeriksaanPersalinan');?>">
                              <div class="modal-body">
                                <div class="row">  
                                <input type="text" name="getIdAntrian" value="<?php echo $idAntrian;?>" hidden>                  
                                  <div class="col-md-12">
                                    <h3><b>Hasil Pemeriksaan Awal:</b></h3>
                                  </div>
                                  <?php foreach ($getPersalinan->result() as $gp ) { ?>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Umur</label>
                                      <input type="text" value="<?php echo $gp->umur;?>" name="umur" class="form-control" placeholder="Umur" readonly >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Alamat</label>
                                      <textarea name="alamat" class="form-control" placeholder="Alamat" readonly><?php echo $kp->alamat_ktp_pasien;?></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Anak Ke</label>
                                      <input type="number" value="<?php echo $gp->anak_ke;?>" name="anakKe" class="form-control" placeholder="Anak Ke" >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>BB (kg)</label>
                                      <input type="number" value="<?php echo $gp->bb;?>" name="bb" class="form-control" placeholder="Berat Badan" >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>PB (cm)</label>
                                      <input type="number" name="pb" value="<?php echo $gp->pb;?>" class="form-control" placeholder="Panjang Badan" >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Tanggal Lahir</label>
                                      <input type="date" name="tglLahir" value="<?php echo $gp->tgl_lahir;?>"class="form-control" placeholder="Tanggal Lahir"  >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Jam</label>
                                      <input type="time" name="jamLahir" value="<?php echo $gp->jam_lahir;?>"class="form-control" placeholder="Jam Lahir" >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Jenis Kelamin</label>
                                      <select name="jenisKelamin" class="form-control">
                                        <option value="<?php echo $gp->jenis_kelamin;?>"><?php echo $gp->jenis_kelamin;?></option>
                                        <option value="Laki-Laki" >Laki-laki</option>
                                        <option value="Perempuan" >Perempuan</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>IMD</label>
                                      <select name="imd" class="form-control">
                                        <option value="<?php echo $gp->imd;?>">
                                          <?php
                                            if ($gp->imd == 1) {
                                              echo "Ya";
                                            } else {
                                              echo "Tidak";
                                            }
                                          ?>
                                        </option>
                                        <option value="1" selected>Ya</option>
                                        <option value="0">Tidak</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Lingkar Kepala</label>
                                      <input type="number" value="<?php echo $gp->lingkar_kepala;?>" name="lingkarKepala" class="form-control" placeholder="Lingkar Kepala" >
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Resiko</label>
                                      <textarea name="resikoPersalinan" class="form-control"><?php echo $gp->resiko;?></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Keterangan</label>
                                      <textarea name="keteranganPersalinan" class="form-control"><?php echo $gp->keterangan;?></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Catatan</label>
                                      <textarea name="catatanPersalinan" class="form-control"><?php echo $gp->catatan;?></textarea>
                                    </div>
                                  </div>
                                </div>
                                <?php } ?>
                                <div class="modal-footer">
                                  <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
                                  <a href="<?php echo base_url('antrian');?>" class="btn btn-sm btn-danger">Kembali</a>
                                  <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
                                </div>
                              <!-- </form> -->
                            </div>
                            </div>
                            </form>
                            <!-- end persalinan -->
                        <!-- start ispa -->
                        <?php } else if($jenisPelayanan == 'ProgramISPA'){ ?>
                          <form method="POST" action="<?php echo base_url('Antrian/updatePemeriksaanIspa');?>">
                            <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <input type="text" name="getIdAntrian" value="<?php echo $idAntrian;?>" hidden>  
                                    <h3><b>Hasil Pemeriksaan:</b></h3>
                                  </div>
                                  <?php foreach ($getIspa->result() as $gis ) { ?>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Nama Anak</label>
                                      <input type="text" name="namaAnakIspa" value="<?php echo $gis->nama_anak;?>"class="form-control" placeholder="Nama Anak" value="" readonly required>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Jenis Kelamin</label>
                                      <input type="text" name="jkIspa" class="form-control" value="<?php echo $gis->jenis_kelamin;?>" readonly >
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Umur (tahun)</label>
                                      <input type="number" name="umurTahun" value="<?php echo $gis->umur_tahun;?>" class="form-control" placeholder="Umur (tahun)" readonly>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Umur (bulan)</label>
                                      <input type="number" name="umurBulan" value="<?php echo $gis->umur_bulan;?>" class="form-control" placeholder="Umur (bulan)" readonly>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>TB/PB</label>
                                      <input type="number" name="tbPbIspa" value="<?php echo $gis->tb_pb;?>" class="form-control" placeholder="Tinggi / Panjang Badan">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>BB</label>
                                      <input type="number" name="bbIspa" class="form-control" value="<?php echo $gis->bb;?>" placeholder="Berat Badan">
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Catatan</label>
                                      <textarea name="catatanIspa" class="form-control"><?php echo $gis->catatan;?></textarea>
                                    </div>
                                  </div>
                                </div>
                                <?php } ?>
                                <div class="modal-footer">
                                  <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
                                  <a href="<?php echo base_url('antrian');?>" class="btn btn-sm btn-danger">Kembali</a>
                                  <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
                                </div>
                            </div>
                          </form>
                          <?php } ?>
                        <!-- end ispa -->
                          
            

            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- end content -->
    </div>
  </div>
 

  <!--   Core JS Files   -->
  <script src="<?php echo base_url('assets/js/core/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js'); ?>"></script>
  <!-- Chart JS -->
  <script src="<?php echo base_url('assets/js/plugins/chartjs.min.js'); ?>"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js'); ?>"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url('assets/js/now-ui-dashboard.min.js?v=1.3.0'); ?>" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url('assets/demo/demo.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/admina.antrian.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
  
  <!-- untuk antrian -->
  <script>
        $(document).ready(function() {
            $('#jp').change(function() {
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Pasien/getNoPelayanan') ?>",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $('#noPelayanan').html(response);

                    }
                });
            });
          $('#jp').select2({'theme': 'bootstrap4'});

            
        });
    </script>
  <!-- untuk antrian -->
  
   <!-- js untuk table by angga-->
    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
                $('#tableHarusDilayani').dataTable();
                $('#tableSedangDilayani').dataTable();
            });
    </script>
  <!-- js untuk table by Angga -->

  <!-- js untuk pencarian di inputan select -->
  <script type="text/javascript">
   $(document).ready(function() {
       $('#namPenyakit').select2({'theme': 'bootstrap4'});
       $('#renUmur').select2({'theme': 'bootstrap4'});
       $('#tindakan').select2({'theme': 'bootstrap4'});
       $('#satUsia').select2({'theme': 'bootstrap4'});
       $('#pasBaru').select2({'theme': 'bootstrap4'});
       $('#pasCabut').select2({'theme': 'bootstrap4'});
       $('#alatKontra').select2({'theme': 'bootstrap4'});
       $('#fourT').select2({'theme': 'bootstrap4'});
       $('#macTindakan').select2({'theme': 'bootstrap4'});
       
       $('#pasien').select2({'theme': 'bootstrap4'});
       $('#dokter').select2({'theme': 'bootstrap4'});
   });
  </script>
  <!-- js untuk pencarian di inputan select -->
  
  <!-- js untuk hitung jumlah anak -->
  <script>
  function sum() {
        var nilaia = document.getElementById('anakLaki').value;
        var nilaib  = document.getElementById('anakPerempuan').value;
        var result =  parseInt(nilaia) + parseInt(nilaib);
        if (!isNaN(result)) {
           document.getElementById('jumlahAnak').value = result;
        }
  }
  </script>
  
</body>

</html>