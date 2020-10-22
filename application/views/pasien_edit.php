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
    Klinik Nur Khadijah | Kunjungan
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
  <!-- webcame -->
   <script src="<?php echo base_url('assets/js/plugins/webcam.min.js'); ?>"></script>

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
            <a class="navbar-brand" href="">Kunjungan</a>
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
      <div class="content">
        <div class="row">
          <div id="table" class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-12">
                    <h4 class="card-title"><center>Edit Data Pasien</center></h4>
                  </div>
                </div>
              </div>
              <div class="card-body">
	              <div class="modal-body">
	                <!-- <form id="formDataTambahPasien"> -->
	                <form action="<?php echo base_url('Pasien/editDataPasien');?>" method="POST">
	  	                <div class="row">
		                    <div class="col-md-12">
		                      <h1>Data Umum</h1>
		                    </div>
		                    
 
							<!-- Modal -->
							<div id="myModal" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<!-- konten modal-->
									<div class="modal-content">
										<div class="modal-body">
											<div class="col-md-12">
						                    	<center><h3><u>Ambil Foto</u></h3></center>
						                    	<div id="my_camera"></div>
						                    	<br>
						                    	<center><input type="button" value="Ambil Gambar" class="btn btn-sm btn-success" onClick="take_snapshot()"></center>
				                				<input type="hidden" name="image" class="image-tag">
						                    </div>
						                    <div class="col-md-12">
						                    	<center><h3><u>Hasil Foto</u></h3></center>
								                <div id="results"></div>
								            </div>
										</div>
										
									</div>
								</div>
							</div>
		                    <!-- foto -->
					        <?php foreach ($gDataPasien->result() as $tdatapasien) {
					              if ($tdatapasien->image == '0') { ?>
					              <div class="col-md-12">
					              <center><img src="<?php echo base_url('assets/img/user.png');?>" style=" width: 150px; height: 150px; border-radius: 50%;"></center>
					              <br>
					              <center><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Edit Foto</button></center>
					        	  </div>
					        <?php } else { ?>
					             <div class="col-md-12">
					              <center><img src="<?php echo base_url('upload/'.$tdatapasien->image.'');?>" style=" width: 150px; height: 150px; border-radius: 50%;"></center>
					              <br>
					              <center><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Edit Foto</button></center>
					            <?php } ?>
					            </div> 
					        <?php } ?>
					        <!-- foto -->
		                    
					        <?php foreach ($gDataPasien->result() as $tdatapasien) {?>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>No. Rekam Medis (RM)</label>
		                        	<input type="text" name="id" value="<?php echo $this->uri->segment(3);?>" hidden>
		                        	<input type="text" name="no_registrasi" value="<?php echo $tdatapasien->no_registrasi;?>" class="form-control" placeholder="No. Buku / No. Reg" readonly>
		                      </div>
		                    </div>
		                    <hr>
		                    <div class="col-md-12">
		                      <h1>Data Pasien</h1>
		                    </div>
		                     <div class="col-md-12">
		                      <div class="form-group">
		                        <label>NO. Kartu Keluarga</label>
		                        <input type="number" name="noKk" value="<?php echo $tdatapasien->no_kk;?>" class="form-control" placeholder="Masukan Nomor KK">
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>NIK</label>
		                        <input type="number" name="nik" value="<?php echo $tdatapasien->nik;?>" class="form-control" placeholder="NIK" required>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Nama Pasien</label>
		                        <input type="text" name="nama_pasien" value="<?php echo $tdatapasien->nama_pasien;?>" class="form-control" placeholder="Nama Pasien" required>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Tanggal Lahir</label>
		                        <input type="date" name="tgl_lahir" value="<?php echo $tdatapasien->tgl_lahir;?>" class="form-control" placeholder="Tanggal Lahir" required>
		                      </div>
		                    </div>
		                     <div class="col-md-12">
		                      <label>Jenis Kelamin : </label>
		                      <select name="jk_pasien" class="form-control" id="jenisKelamin">
		                      	<option><?php echo $tdatapasien->jk_pasien;?></option>
		                      	<option value="Laki-Laki">Laki-Laki</option>
		                      	<option value="Perempuan">Perempuan</option>
		                      </select>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Pendidikan Pasien</label>
		                        <select name="pendidikan_pasien" id="pendidikanPasien" class="form-control" required>
		                          <option valeu="<?php echo $tdatapasien->pendidikan_pasien;?>"><?php echo $tdatapasien->pendidikan_pasien;?></option>
		                          <option value="SD" >SD</option>
		                          <option value="SMP">SMP</option>
		                          <option value="SLTA" selected="selected">SLTA</option>
		                          <option value="D1">D1</option>
		                          <option value="D3">D3</option>
		                          <option value="D4">D4</option>
		                          <option value="S1">S1</option>
		                          <option value="S2">S2</option>
		                          <option value="S3">S3</option>
		                          <option value="Belum Sekolah"> Belum Sekolah </option>
		                          <option value="Tidak Tamat" >Tidak Tamat</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Agama Pasien</label>
		                        <select name="agama_pasien" id="agama" class="form-control">
		                          <option value="<?php echo $tdatapasien->agama_pasien;?>"><?php echo $tdatapasien->agama_pasien;?></option>
		                          <option value="Islam">Islam</option>
		                          <option value="Kristen">Kristen</option>
		                          <option value="Hindu">Hindu</option>
		                          <option value="Budha">Budha</option>
		                          <option value="Protestan">Protestan</option>
		                          <option value="Kong Hu Chu">Kong Hu Chu</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Pekerjaan Pasien</label>
		                        <select name="pekerjaan_pasien" id="pekerjaanPasien" class="form-control" required>
		                        	<option value="<?php echo $tdatapasien->pekerjaan_pasien;?>"><?php echo $tdatapasien->pekerjaan_pasien;?></option>
		                        	<?php
		                        		foreach ($tPekerjaan->result() as $tp ) {
		                        	?>
		                        		<option value="<?php echo $tp->nama_pekerjaan; ?>"><?php echo $tp->nama_pekerjaan;?></option>
		                        	<?php	
		                        		}
		                        	?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Alamat KTP</label>
		                        <input type="text" name="alamat_ktp_pasien" value="<?php echo $tdatapasien->alamat_ktp_pasien;?>" class="form-control" placeholder="Alamat KTP" onkeyup="copytextbox();" id="ktpPasien" required>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Alamat Domisili</label>
		                        <input type="text" name="alamat_pasien" value="<?php echo $tdatapasien->alamat_pasien;?>" class="form-control" placeholder="Alamat Domisili"  id="domisiliPasien" required>
		                      </div>
		                    </div>
		                    <hr>

		                    <div class="col-md-12">
		                      <h1>Data Penanggung Jawab (Suami/Istri/Ibu)</h1>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Nama Ayah Kandung</label>
		                        <input type="text" value="<?php echo $tdatapasien->nama_ayah_kandung;?>"name="nama_ayah_kandung" class="form-control" placeholder="Nama Ayah Kandung">
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Penanggung Jawab</label>
		                        <input type="text" name="nama_pj" value="<?php echo $tdatapasien->nama_pj;?>" class="form-control" placeholder="Penanggung Jawab" required>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Tanggal Lahir</label>
		                        <input type="date" name="tgl_lahir_pj" value="<?php echo $tdatapasien->tgl_lahir_pj;?>"class="form-control" placeholder="Tanggal Lahir Penanggung Jawab" required>
		                      </div>
		                    </div>

		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Pendidikan</label>
		                        <select name="pendidikan_pj" id="pendidikanPj" class="form-control">
		                          <option value="<?php echo $tdatapasien->pendidikan_pj;?>"><?php echo $tdatapasien->pendidikan_pj;?></option>
		                          <option value="Tidak Tamat">Tidak Tamat</option>
		                          <option value="SD">SD</option>
		                          <option value="SMP">SMP</option>
		                          <option value="SLTA">SLTA</option>
		                          <option value="D1">D1</option>
		                          <option value="D3">D3</option>
		                          <option value="D4">D4</option>
		                          <option value="S1">S1</option>
		                          <option value="S2">S2</option>
		                          <option value="S3">S3</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Agama</label>
		                        <select name="agama_pj" id="agamaPj" class="form-control">
		                          <option value="<?php echo $tdatapasien->agama_pj;?>"><?php echo $tdatapasien->agama_pj;?></option>
		                          <option value="Islam" selected="selected">Islam</option>
		                          <option value="Kristen">Kristen</option>
		                          <option value="Hindu">Hindu</option>
		                          <option value="Budha">Budha</option>
		                          <option value="Protestan">Protestan</option>
		                          <option value="Kong Hu Chu">Kong Hu Chu</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Pekerjaan</label>
		                         <select name="pekerjaan_pj" id="pekerjaanPj" class="form-control" required>
		                        	<option value="<?php echo $tdatapasien->pekerjaan_pj;?>"><?php echo $tdatapasien->pekerjaan_pj;?></option>
		                        	<?php
		                        		foreach ($tPekerjaan->result() as $tp ) {
		                        	?>
		                        		<option value="<?php echo $tp->nama_pekerjaan; ?>"><?php echo $tp->nama_pekerjaan;?></option>
		                        	<?php	
		                        		}
		                        	?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Alamat KTP</label>
		                        <input type="text" name="alamat_ktp_pj" value="<?php echo $tdatapasien->alamat_ktp_pj;?>" class="form-control" placeholder="Alamat KTP" onkeyup="copytextbox();" id="ktpPj">
		                      </div>
		                    </div>
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <label>Alamat Domisili</label>
		                        <input type="text" name="alamat_pj" value="<?php echo $tdatapasien->alamat_pj;?>"class="form-control" placeholder="Alamat Domisili" id="domisiliPj">
		                      </div>
		                    </div>
		                    <hr>

		                    <div class="col-md-12 formTambahan">
		                      <h1>Data Tambahan</h1>
		                      <!-- <div class="alert alert-danger" role="alert">
		                        Catatan: Khusus untuk <b>Kabupaten Bandung Barat</b> silahkan pilih nama desa, selain itu nama desa biarkan "<b>Tidak Ada</b>".
		                      </div> -->
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>Kota</label>
		                        <select name="kota" id="kota" class="form-control">
		                        	<option value="<?php echo $tdatapasien->kota;?>"><?php echo $tdatapasien->kota;?></option>
		                        	<?php
		                        		foreach ($tKota->result() as $tk ) { ?>
		                        		<option value="<?php echo $tk->nama_kota;?>"><?php echo $tk->nama_kota;?></option>		
		                        	<?php } ?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>Desa</label>
		                        <select name="desa" id="desa" class="form-control">
		                        	<option value="<?php echo $tdatapasien->desa;?>"><?php echo $tdatapasien->desa;?></option>
		                        	<?php
		                        		foreach ($tDesa->result() as $td ) {
		                        	?>
		                        		<option value="<?php echo $td->nama_desa;?>"><?php echo $td->nama_desa;?></option>
		                        	<?php } ?>
		                        	<option></option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>Golongan Darah</label>
		                        <select name="gol_darah" id="golDarah" class="form-control">
		                          <option value="<?php echo $tdatapasien->gol_darah;?>"><?php echo $tdatapasien->gol_darah;?></option>
		                          <option value="A">A</option>
		                          <option value="B">B</option>
		                          <option value="AB">AB</option>
		                          <option value="O">O</option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>No Telp / WA</label>
		                        <input type="text" name="no_telp_pasien" value="<?php echo $tdatapasien->no_telp_pasien;?>" class="form-control" placeholder="No Telepon">
		                      </div>
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>Alamat Email</label>
		                        <input type="email" name="email" value="<?php echo $tdatapasien->email;?>"class="form-control" placeholder="Alamat Email">
		                      </div>
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>Medsos</label>
		                        <input type="text" name="medsos" class="form-control" value="<?php echo $tdatapasien->medsos;?>"placeholder="Medsos">
		                      </div>
		                    </div>
		                    <div class="col-md-12 formTambahan">
		                      <div class="form-group">
		                        <label>Catatan Bidan</label>
		                        <textarea class="form-control" name="catatan_bidan"><?php echo $tdatapasien->catatan_bidan;?></textarea>
		                      </div>
		                    </div>
		                    <?php } ?>
		                </div>
		                  <div class="modal-footer">
		                  <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button> -->
		                  <a href="<?php echo base_url('Pasien');?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Cancel</a>
		                  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>

		                </div>
		                </form>

		              </div>
             
              </div>
            </div>
          </div>
        </div>
      </div>


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
  <script src="<?php echo base_url('assets/js/admina.pasien.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

  <script type="text/javascript">
  // js untuk pencarian inputan select
   $(document).ready(function() {
       $('#pendidikanPasien').select2({'theme': 'bootstrap4'});
       $('#agama').select2({'theme': 'bootstrap4'});
       $('#pekerjaanPasien').select2({'theme': 'bootstrap4'});
       $('#agamaPj').select2({'theme': 'bootstrap4'});
       $('#pekerjaanPj').select2({'theme': 'bootstrap4'});
       $('#kota').select2({'theme': 'bootstrap4'});
       $('#desa').select2({'theme': 'bootstrap4'});
       $('#pendidikanPj').select2({'theme': 'bootstrap4'});
       $('#golDarah').select2({'theme': 'bootstrap4'});
       $('#jenisKelamin').select2({'theme': 'bootstrap4'});
   });
   // js untuk pencarian inputan select

   // js untuk copy text 
	function copytextbox() {
	    document.getElementById('domisiliPasien').value = document.getElementById('ktpPasien').value;
	    document.getElementById('domisiliPj').value = document.getElementById('ktpPj').value;    
	}
    // js untuk copy text 

    //untuk foto
    // Configure a few settings and attach camera 
     Webcam.set({
        width: 436,
        height: 347,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }

  </script>
</html>