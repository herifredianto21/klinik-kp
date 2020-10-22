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
                    <h4 class="card-title"> Tambah kunjungan </h4>
                    <hr>
                  </div>
                </div>
              </div>
              <!-- start = body form tambah kunjungan -->
              <div class="card-body">
    	       		<form method="post" action="<?php echo base_url('Pasien/simpanKunjungan');?>">
        			    <div class="row">
		                    <div class="col-md-6">
		                      	<div class="form-group">
			                        <label>Jenis Pelayanan</label>
			                        <br>
			                        <select class="form-control" id="jp" name="jenisPelayanan" class="form-control" style="width:100%;" >
			                            <option> </option>
			                            <?php foreach ($pelayanan as $pel) : ?>
		                                    <option value="<?= $pel['id']; ?>"><?= $pel['nama_pelayanan']; ?></option>
		                                <?php endforeach; ?>
			                        </select>
		                      	</div>
		                    </div>
		                    <div class="col-md-6">
		                      	<div class="form-group">
			                        <label>Pasien</label>
			                        <?php foreach ($query->result() as $tp) { ?>
			                        	<input type="text" class="form-control" name="namaPasien" value="<?php echo $tp->id;?>" hidden>               
			                        	<input type="text" name="namaP" class="form-control" value="<?php echo $tp->nama_pasien;?>" readonly>
		                      		<?php } ?>
		                      	</div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Dokter</label>
		                        <select name="namaDokter" id="dokter" class="form-control" style="width:100%;">
		                         <?php
		                         	foreach ($tDokter->result() as $td ) { ?>
		                         	<option value="<?php echo $td->id;?>"><?php echo $td->nama_dokter;?></option>		
		                         <?php } ?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>No. Antrian</label>
		                        <textarea id="noPelayanan" name="noAntrian" class="form-control" style="height:30px; padding-top: 5px; padding-left: 20px;" readonly> </textarea>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Tanggal Kunjungan</label>
		                        <input type="text" name="tgl_antrian" class="form-control" placeholder="Tanggal Antrian" value="<?php echo gmdate("Y-m-d H:i:s", time()+60*60*7);?>"  readonly>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Kode Antrian</label>
		                        <?php
		                          foreach ($kdAntrian->result() as $kd ) {
		                            $getId = $kd->id;
		                            $angka = $getId+1;
		                            $date=str_replace('-','', gmdate("Y-m-d ", time()+60*60*7)) ;
		                            $kode = "A-".$date.$angka;

		                        ?>
		                        <input type="text" name="idAntrian" value="<?php echo $kd->id;?>" hidden>
		                        <input type="text" name="kode_antrian" class="form-control" placeholder="Kode Antrian" value="<?php echo $kode;?>"readonly>
		                        <?php } ?>
		                        
		                      </div>
		                    </div>
		                   
		                  </div>
		                  <div class="modal-footer">
		                   <!--  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
		                   
		                    <button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</button> -->
		                  </div>    
		            

              </div>
              <!-- end = body form tambah kunjungan -->

              	<!-- start form KB -->
             	<div id="37" class="myDiv" style="display:none">
              		<div class="modal-body">
		                  <div class="row">
		                    <div class="col-md-12">
		                      <h3><b>Hasil Pemeriksaan:</b></h3>
		                    </div>
		                    <?php foreach ($query->result() as $tp ) { ?>
		                    
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Umur</label>
		                        <?php
		                        //waktu sekarang
		                        $tglSekarang = date('yy-m-d');
		                        $waktuSekarang = explode('-', $tglSekarang);
		                        //tgl lahir pasien
		                        $tglPasien= $tp->tgl_lahir;
		                        $waktuPasien = explode('-',$tglPasien);
		                        //hitung umur
		                        $getHari = $waktuSekarang[2] - $waktuPasien[2];
		                        $getBulan = $waktuSekarang[1] - $waktuPasien [1];
		                        $getTahun = $waktuSekarang[0] - $waktuPasien [0];
		                        //hasil umur
		                        $umurPasien=abs($getTahun)." Tahun ".abs($getBulan)." Bulan ".abs($getHari)." Hari"; 
		                        ?>
		                        <input type="text" name="umurPasienKb" value="<?php echo $umurPasien;?>" class="form-control" readonly placeholder="Umur" required>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Nama Suami</label>
		                        <input type="text" value="<?php echo $tp->nama_pj;?>"name="namaPjKb" class="form-control" placeholder="Nama Suami" readonly>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Alamat</label>
		                        <textarea name="alamatPasienKb" class="form-control" placeholder="Alamat" readonly><?php echo $tp->alamat_ktp_pasien;?></textarea>
		                      </div>
		                    </div>
		                    <?php } ?>



		                    <?php 
		                    if (count($jmlAnak->result()) == 1) { ?>
		                    <?php foreach ($jmlAnak->result() as $ja ) { ?>
			                    <div class="col-md-6">
			                      	<div class="form-group">
				                        <label>Jumlah Anak Laki-laki</label>
				                        <input type="number" value="<?php echo $ja->jml_anak_laki ; ?>" name="jmlAnakLakiKb" id="anakLaki" class="form-control" placeholder="Jumlah Anak Laki-laki" onkeyup="sum();" >
			                    	</div>
			                    </div>
			                    <div class="col-md-6">
			                      	<div class="form-group">
			                        <label>Jumlah Anak Perempuan</label>
			                        <input type="number" value="<?php echo $ja->jml_anak_perempuan ; ?>" name="jmlAnakPerempuanKb" id="anakPerempuan" class="form-control" placeholder="Jumlah Anak Perempuan" onkeyup="sum();" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      	<div class="form-group">
			                        	<label>Jumlah Anak</label>
			                            <input type="number" value="<?php echo $ja->jml_anak ; ?>" name="jmlAnak" id="jumlahAnakKb" class="form-control" placeholder="Jumlah Anak" readonly >                      
			                      	</div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Usia Anak Terkecil</label>
			                            <input type="number" value="<?php echo $ja->usia_anak_terkecil; ?>" name="usiaAnakTerkecilKb" class="form-control" placeholder="Usia Anak Terkecil">
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Satuan Usia</label>
			                        <select name="idSatuanUsiaKb" id="satUsia"class="form-control" style="width:100%;">
			                          <option value="<?php echo $ja->id_satuan_usia;?>"s>
			                          	<?php 
			                              $id = $ja->id_satuan_usia;
			                              if ($id=='1') {
			                                echo "Hari";
			                              } else if ($id=='2'){
			                                echo "Bulan";
			                              } else if ($id=='3'){
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
		                    <?php } ?>

		                    <?php } else { ?>
		                    	<div class="col-md-6">
			                      	<div class="form-group">
				                        <label>Jumlah Anak Laki-laki</label>
				                        <input type="number" value="" name="jmlAnakLakiKb" id="anakLaki" class="form-control" placeholder="Jumlah Anak Laki-laki" onkeyup="sum();" >
			                    	</div>
			                    </div>
			                    <div class="col-md-6">
			                      	<div class="form-group">
			                        <label>Jumlah Anak Perempuan</label>
			                        <input type="number" value="" name="jmlAnakPerempuanKb" id="anakPerempuan" class="form-control" placeholder="Jumlah Anak Perempuan" onkeyup="sum();" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      	<div class="form-group">
			                        	<label>Jumlah Anak</label>
			                            <input type="number" value="" name="jmlAnakKb" id="jumlahAnak" class="form-control" placeholder="Jumlah Anak" readonly >                      
			                      	</div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Usia Anak Terkecil</label>
			                            <input type="number" value=" " name="usiaAnakTerkecilKb" class="form-control" placeholder="Usia Anak Terkecil">
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Satuan Usia</label>
			                        <select name="idSatuanUsiaKb" id="satUsia"class="form-control" style="width:100%;">
			                          <option value="1" >Hari</option>
			                          <option value="2" >Bulan</option>
			                          <option value="3" >Tahun</option>
			                        </select>
			                      </div>
			                    </div>
		                    <?php } ?>
		                    


		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Pasang Baru</label>
		                        <select name="pasangBaruKb" id="pasBaru" style="width:100%;" class="form-control">
		                          <option value="1" selected>Ya</option>
		                          <option value="0">Tidak</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Pemasangan / Pencabutan</label>
		                        <select name="pasangCabutKb" id="pasCabut" style="width:100%;" class="form-control">
		                          <option value="PEMASANGAN" selected>Pemasangan</option>
		                          <option value="PENCABUTAN">Pencabutan</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Alat Kontrasepsi</label>
		                        <select name="idAlatKontraKb" id="alatKontra" style="width:100%;" class="form-control"> 
		                          <?php foreach ($alatKontra->result() as $ak) { ?>
		                          	<option value="<?php echo $ak->id;?>"><?php echo $ak->nama_alat;?></option>
		                          <?php } ?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>AKLI</label>
		                        <input type="text" name="akliKb" class="form-control" placeholder="AKLI">
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>4T</label>
		                        <select name="t4Kb" id="fourT" style="width:100%;" class="form-control">
		                          <option value="1" selected>Ya</option>
		                          <option value="0">Tidak</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Ganti Cara</label>
		                        <input type="textareaxt" name="gantiCaraKb" class="form-control" placeholder="Ganti Cara">
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Catatan</label>
		                        <textarea name="catatanKb" class="form-control"></textarea>
		                      </div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
		                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Selesai</button>
		                  </div>
		              </div>
                </div>
              <!-- end form kb -->

              <!-- start form pemeriksaan ispa -->
              <div id="34" class="myDiv" style="display:none">
              		<div class="modal-body">
		                  <div class="row">
		                    <div class="col-md-12">
		                      <h3><b>Hasil Pemeriksaan:</b></h3>
		                    </div>
		                    <?php foreach ($query->result() as $tp ) { ?>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Nama Anak</label>
		                        <input type="text" name="namaAnakIspa" value="<?php echo $tp->nama_pasien;?>"class="form-control" placeholder="Nama Anak" value="" readonly required>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Jenis Kelamin</label>
		                        <input type="text" name="jkIspa" class="form-control" value="<?php echo $tp->jk_pasien;?>" readonly >
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Umur (tahun)</label>
		                        <?php
		                        //waktu sekarang
		                        $tglSekarang = date('yy-m-d');
		                        $waktuSekarang = explode('-', $tglSekarang);
		                        //tgl lahir pasien
		                        $tglPasien= $tp->tgl_lahir;
		                        $waktuPasien = explode('-',$tglPasien);
		                        //hitung umur
		                        $getHari = $waktuSekarang[2] - $waktuPasien[2];
		                        $getBulan = $waktuSekarang[1] - $waktuPasien [1];
		                        $getTahun = $waktuSekarang[0] - $waktuPasien [0];
		                        //hasil umur
		                        $umurPasienTahun=abs($getTahun); 
		                        $umurPasienBulan=abs($getBulan);
		                        ?>

		                        <input type="number" name="umurTahun" value="<?php echo $umurPasienTahun; ?>" class="form-control" placeholder="Umur (tahun)" readonly>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Umur (bulan)</label>
	                        	<input type="number" name="umurBulan" value="<?php echo $umurPasienBulan; ?>" class="form-control" placeholder="Umur (bulan)" readonly>
		                      </div>
		                    </div>
		                    <?php } ?>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>TB/PB</label>
		                        <input type="number" name="tbPbIspa" class="form-control" placeholder="Tinggi / Panjang Badan">
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>BB</label>
		                        <input type="number" name="bbIspa" class="form-control" placeholder="Berat Badan">
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Catatan</label>
		                        <textarea name="catatanIspa" class="form-control"></textarea>
		                      </div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
		                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Selesai</button>
		                  </div>
		              </div>
              </div>
              <!-- end form pemeriksaan ispa -->

              <!-- start form pemeriksaan umum -->
              <div id="9" class="myDiv" style="display:none">
              		<div class="modal-body">
		                  <div class="row">
		                    <div class="col-md-12">
		                      <h3><b>Hasil Pemeriksaan:</b></h3>
		                    </div>
		                    <?php foreach ($query->result() as $tp) { ?>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Jenis Kelamin</label>
		                          <input type="text" name="jenisKelaminUmum" value="<?php echo $tp->jk_pasien;?>" class="form-control" readonly >
		                      </div>
		                    </div>
		                    <?php } ?>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Nama Penyakit</label>
		                        <select name="idPenyakitUmum" id="namPenyakit" style="width:100%;"class="form-control">
		                          <option value="20" Selected>Penyakit Lain-Lain </option>
		                          <?php foreach ($gDp->result() as $dp ) { ?>
		                          	<option value="<?php echo $dp->id;?>"><?php echo $dp->nama_penyakit;?></option>
		                          <?php } ?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Rentang Umur</ label>
		                        <select name="idRentangUmurUmum" id="renUmur" style="width:100%;" class="form-control">
		                          <?php foreach ($gRu->result() as $ru ) { ?>
		                          	<option value="<?php echo $ru->id;?>"><?php echo $ru->rentang_umur;?></option>	
		                          <?php } ?>
		                          
		                        </select>
		                        
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Tindakan: </label>
		                        <select name="idTindakanUmum" class="form-control" id="tindakan" style="width:100%;">
		                        	<option value="0">Tidak Ada</option>
		                         <?php foreach ($gTi->result() as $ti ) { ?>
		                         	<option value="<?php echo $ti->id;?>"><?php echo $ti->nama_tindakan;?></option>
		                         <?php } ?>
		                          
		                         
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Catatan</label>
		                        <textarea name="catatanDokterUmum" class="form-control"></textarea>
		                      </div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
		                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Selesai</button>
		                  </div>
		              </div>
              </div>
              <!-- end form pemeriksaan umum -->

              <!-- start form imunisasi -->
              <div id="8" class="myDiv" style="display:none">
              		<div class="modal-body">
		                  <div class="row">
		                    <div class="col-md-12">
		                      <h3><b>Hasil Pemeriksaan Awal:</b></h3>
		                    </div>
		                    <?php foreach ($query->result() as $tp) { ?>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Nama Anak</label>
		                        <input type="text" name="namaAnak" value="<?php echo $tp->nama_pasien;?>" class="form-control" placeholder="Nama Anak" readonly required>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                    	<label>Nama Orang Tua</label>
		                    	<input type="text" value="<?php echo $tp->nama_pj;?>" class="form-control" readonly>
		                    </div>
		                     <div class="col-md-6">
		                      <div class="form-group">
		                        <label>No. KK Ortu</label>
		                        <?php
		                          if ($tp->no_kk == null) {
		                        ?>
			                        <input type="number" name="noKkImunisasi" value="<?php echo $tp->no_kk;?>" class="form-control" placeholder="No. KK Orang Tua">    
			                        <?php } else { ?>
			                        <input type="number" name="noKkImunisasi" value="<?php echo $tp->no_kk;?>" class="form-control" placeholder="No. KK Orang Tua" readonly>    
		                        <?php
		                        }
		                        ?>
		                      </div>
		                    </div>

		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Alamat</label>
		                        <textarea name="alamat" class="form-control" placeholder="Alamat" readonly><?php echo $tp->alamat_ktp_pasien; ?></textarea>
		                      </div>
		                    </div>

		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Tanggal Lahir</label>
		                        <input type="date" name="tglLahir" value="<?php echo $tp->tgl_lahir;?>"  class="form-control" placeholder="Tanggal Lahir" readonly required>
		                      </div>
		                    </div>
		                    <?php } ?>

		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>BB Lahir (Gram)</label>
		                        <?php
		                        	if (count($gBb->result()) == 1) {
		                        	foreach ($gBb->result() as $bbl) {
		                        ?>	
		                        	<input type="text" name="bbLahir" value="<?php echo $bbl->bb_lahir;?>" class="form-control" readonly >
		                        <?php
		                        	}
		                        	} else {
		                        ?>
		                        	<input type="number" name="bbLahir" class="form-control"  >
		                        <?php	
		                        	}
		                        ?>
			                          

		                      </div>
		                    </div>	

		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>BB (Gram)</label>
		                        <input type="number" name="bbImunisasi"  class="form-control" placeholder="Berat Badan">
		                        
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>PB (cm)</label>
		                        <input type="number" name="pbImunisasi" class="form-control" placeholder="Panjang Badan">
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Catatan</label>
		                        <textarea name="catatanImunisasi" class="form-control"></textarea>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <h3><b>Macam Imunisasi:</b></h3>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>Hb0</label>
		                        <select name="hb0" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>BCG</label>
		                        <select name="bcg" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Polio 1</label>
		                        <select name="polio1" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Polio 2</label>
		                        <select name="polio2" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Polio 3</label>
		                        <select name="polio3" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Polio 4</label>
		                        <select name="polio4" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Pentabio 1</label>
		                        <select name="pentabio1" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Pentabio 2</label>
		                        <select name="pentabio2" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Pentabio 3</label>
		                        <select name="pentabio3" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Campak</label>
		                        <select name="campak" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label>TT</label>
		                        <select name="tt" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Pentabio Ulang</label>
		                        <select name="pentabioUlang" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-3">
		                      <div class="form-group">
		                        <label>Campak Ulang</label>
		                        <select name="campakUlang" class="form-control">
		                          <option value="0" selected>Tidak</option>
		                          <option value="1">Ya</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
		                        <label><b>Tindakan: </b></label>
		                        <select name="idMacamTindakanImunisasi" id="macTindakan" style="width:100%;" class="form-control">
		                          <?php foreach ($gTi->result() as $ti ) { ?>
		                          	<option value="<?php echo $ti->id;?>"><?php echo $ti->nama_tindakan;?></option>
		                          <?php } ?>
		                        </select>
		                      </div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
		                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Selesai</button>
		                  </div>
		            </div>
              </div>
              <!-- end form imunisasi -->
              
              <!-- start form persalinan -->
              	<div id="3" class="myDiv"style="display:none;">
              		<div class="modal-body">
	                <!-- <form action="<?php //echo base_url('Dashboard/simpanDataPersalinan');?>" method="post"> -->
	                  <div class="row">                  
	                    <div class="col-md-12">
	                      <h3><b>Hasil Pemeriksaan Awal:</b></h3>
	                    </div>
	                    <?php foreach ($query->result() as $tp) { ?>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Umur</label>
	                        <?php
	                        // waktu sekarang
	                        $tglSekarang = date('yy-m-d');
	                        $waktuSekarang = explode('-', $tglSekarang);
	                        //tgl lahir pasien
	                        $tglPasien= $tp->tgl_lahir;
	                        $waktuPasien = explode('-',$tglPasien);
	                        //hitung umur
	                        $getHari = $waktuSekarang[2] - $waktuPasien[2];
	                        $getBulan = $waktuSekarang[1] - $waktuPasien [1];
	                        $getTahun = $waktuSekarang[0] - $waktuPasien [0];
	                        //hasil umur
	                        $umurPasien=abs($getTahun)." Tahun ".abs($getBulan)." Bulan ".abs("$getHari")." Hari"; 
	                        ?>
	                        <input type="text" value="<?php echo $umurPasien; ?>" name="umur" class="form-control" placeholder="Umur" readonly >
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Alamat</label>
	                        <textarea name="alamat" class="form-control" placeholder="Alamat" readonly><?php echo $tp->alamat_ktp_pasien;?></textarea>
	                      </div>
	                    </div>
	                     <?php } ?>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Anak Ke</label>
	                        <input type="number" name="anakKe" class="form-control" placeholder="Anak Ke" >
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>BB (kg)</label>
	                        <input type="number" name="bbPersalinan" class="form-control" placeholder="Berat Badan" >
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>PB (cm)</label>
	                        <input type="number" name="pb" class="form-control" placeholder="Panjang Badan" >
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Tanggal Lahir</label>
	                        <input type="date" name="tglLahir" class="form-control" placeholder="Tanggal Lahir"  >
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Jam</label>
	                        <input type="time" name="jamLahir" class="form-control" placeholder="Jam Lahir" >
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Jenis Kelamin</label>
	                        <select name="jenisKelamin" class="form-control">
	                          <option value="Laki-Laki" selected>Laki-laki</option>
	                          <option value="Perempuan" >Perempuan</option>
	                        </select>
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>IMD</label>
	                        <select name="imd" class="form-control">
	                          <option value="1" selected>Ya</option>
	                          <option value="0">Tidak</option>
	                        </select>
	                      </div>
	                    </div>
	                    <div class="col-md-6">
	                      <div class="form-group">
	                        <label>Lingkar Kepala</label>
	                        <input type="number" name="lingkarKepala" class="form-control" placeholder="Lingkar Kepala" >
	                      </div>
	                    </div>
	                    <div class="col-md-12">
	                      <div class="form-group">
	                        <label>Resiko</label>
	                        <textarea name="resikoPersalinan" class="form-control"></textarea>
	                      </div>
	                    </div>
	                    <div class="col-md-12">
	                      <div class="form-group">
	                        <label>Keterangan</label>
	                        <textarea name="keteranganPersalinan" class="form-control"></textarea>
	                      </div>
	                    </div>
	                    <div class="col-md-12">
	                      <div class="form-group">
	                        <label>Catatan</label>
	                        <textarea name="catatanPersalinan" class="form-control"></textarea>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="modal-footer">
	                    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
	                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Selesai</button>
	                  </div>
	                <!-- </form> -->
	              </div>
              	</div>
              	<!-- end form persalinan -->


              	<!-- start form pemeriksaan kehamilan -->
		       	<div id="1" class="myDiv"style="display:none;">
		       		
		       			  <div class="modal-body">
			                  <div class="row">			                    
			                    <div class="col-md-12">
			                      <h3><b>Hasil Pemeriksaan Awal:</b></h3>
			                    </div>
			                    <?php foreach ($query->result() as $tp) { ?>  
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Tanggal Lahir</label>
			                        <input type="date" name="tglLahir" value="<?php echo $tp->tgl_lahir;?>" class="form-control" placeholder="Tanggal Lahir" readonly>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>NIK</label>
			                        <input type="text" name="nik" class="form-control" value="<?php echo $tp->nik;?>" placeholder="NIK" readonly>
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
				                        $tglPasien= $tp->tgl_lahir;
				                        $waktuPasien = explode('-',$tglPasien);
				                        //hitung umur
				                        $getHari = $waktuSekarang[2] - $waktuPasien[2];
				                        $getBulan = $waktuSekarang[1] - $waktuPasien [1];
				                        $getTahun = $waktuSekarang[0] - $waktuPasien [0];
				                        //hasil umur
				                        $umurPasien=abs($getTahun)." Tahun ".abs($getBulan)." Bulan ".abs($getHari)." Hari"; 
				                        
			                        ?>
			                        <input type="text" name="umur" value="<?php echo $umurPasien;?>"  class="form-control" placeholder="Umur" readonly >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Nama Suami</label>
			                        <input type="text" name="namaPj" value="<?php echo $tp->nama_pj;?>"class="form-control" placeholder="Nama Suami" readonly >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>No. KK</label>
			                            <input type="number" name="noKk" value="<?php echo $tp->no_kk;?>" class="form-control" placeholder="No. KK" readonly>  
			                      </div>
			                    </div>
			                    <?php } ?>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>KIA</label>
			                        <!-- <input type="text" name="buku_kia" class="form-control" placeholder="Buku KIA"> -->
			                        <select name="bukuKia" class="form-control">
			                          <option value="lama">Lama</option>
			                          <option value="baru">Baru</option>
			                        </select>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Alamat</label>
			                        <textarea name="alamat" class="form-control" placeholder="Alamat" readonly><?php echo $tp->alamat_ktp_pasien;?>  </textarea>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>HPHT</label>
			                        <input type="date" name="hpht" class="form-control" placeholder="HPHT" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>TP</label>
			                        <input type="date" name="tp" class="form-control" placeholder="TP" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>BB</label>
			                        <input type="number" name="bb" class="form-control" placeholder="Berat Badan" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>TB</label>
			                        <input type="number" name="tb" class="form-control" placeholder="Tinggi Badan" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Usia Kehamilan (minggu)</label>
			                        <input type="text" name="usiaKehamilan" class="form-control" placeholder="Usia Kehamilan">
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>GPA</label>
			                        <input type="text" name="gpa" class="form-control" placeholder="GPA" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>K1</label>
			                        <select name="k1" class="form-control">
			                          <option value="1" selected>Ya</option>
			                          <option value="0">Tidak</option>
			                        </select>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>K4</label>
			                        <select name="k4" class="form-control">
			                          <option value="1" selected>Ya</option>
			                          <option value="0">Tidak</option>
			                        </select>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>TT</label>
			                        <input type="text" name="tt" class="form-control" placeholder="TT">
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>LILA (cm)</label>
			                        <input type="number" name="lila" class="form-control" placeholder="LILA (cm)" >
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Hb (g/dl)</label>
			                        <input type="number" name="hb" class="form-control" placeholder="Hb (g/dl)">
			                      </div>
			                    </div>
			                    <div class="col-md-12">
			                      <div class="form-group">
			                        <label>Resiko</label>
			                        <textarea name="resiko" class="form-control"></textarea>
			                      </div>
			                    </div>
			                    <div class="col-md-12">
			                      <div class="form-group">
			                        <label>Keterangan (10 T, Jumlah Fe)</label>
			                        <textarea name="keterangan" class="form-control"></textarea>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="form-group">
			                        <label>Keterangan Hamil</label>
			                        <select name="baruLama" class="form-control">
			                          <option value="BARU" selected>Baru</option>
			                          <option value="LAMA">Lama</option>
			                        </select>
			                      </div>
			                    </div>  
			                    <div class="col-md-12">
			                      <div class="form-group">
			                        <label>Catatan</label>
			                        <textarea name="catatan" class="form-control"></textarea>
			                      </div>
			                    </div>
			                  </div>
			                  <div class="modal-footer">
			                    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
			                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Selesai</button>
			                  </div>
			                </form>
			              </div>
			             
			         
			          
			        
		        </div>
        	  <!-- end form pemeriksaan kehamilan -->

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
  <!-- menampilkan form sesuai poli -->
  <script>
	$(document).ready(function(){
	    $('#jp').on('change', function(){
	        var demovalue = $(this).val(); 
	        $("div.myDiv").hide();
	        $("#"+demovalue).show();
	    });
	});
	</script>
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
  
  <!-- js untuk hitung jumlah anak -->
</body>

</html>