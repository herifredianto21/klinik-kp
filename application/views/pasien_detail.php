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
    Klinik Nur Khadijah | Detail Pasien
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
            <a class="navbar-brand" href="">Detail Pasien</a>
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

      <!-- Detail Pasien-->
      <div class="content">
        <div class="row">
          <div id="table" class="col-md-6">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <h4 class="card-title"> Detail Pasien</h4>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- foto -->
                <?php foreach ($gDataPasien->result() as $tdatapasien) {
                      if ($tdatapasien->image == '0') { ?>
                      <div class="col-md-12">
                      <center><img src="<?php echo base_url('assets/img/user.png');?>" style=" width: 150px; height: 150px; border-radius: 50%;"></center>
                      <br>
                <?php } else { ?>
                     <div class="col-md-12">
                      <center><img src="<?php echo base_url('upload/'.$tdatapasien->image.'');?>" style=" width: 150px; height: 150px; border-radius: 50%;"></center>
                      <br>
                    <?php } ?>
                    </div> 
                <?php } ?>
               
                <!-- foto -->
                <div class="table-responsive">
                  <table id="DetailPasien" class="table table-striped table-hover">
                    <?php foreach ($gDataPasien->result() as $tdatapasien) {?>
                      <tr>
                        <th>No. RM</th>
                        <td><?php echo $tdatapasien->no_registrasi ?></td>
                      </tr>
                      <tr>
                        <th>No. Kartu Keluarga</th>
                        <td><?php echo $tdatapasien->no_kk ?></td>
                      </tr>
                      <tr>
                        <th>NIK</th>
                        <td><?php echo $tdatapasien->nik ?></td>
                      </tr>
                      <tr>
                        <th>Nama</th>
                        <td><?php echo $tdatapasien->nama_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Tgl. Lahir</th>
                        <td><?php echo $tdatapasien->tgl_lahir ?></td>
                      </tr>
                      <tr>
                        <th>Pendidikan</th>
                        <td><?php echo $tdatapasien->pendidikan_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Agama</th>
                        <td><?php echo $tdatapasien->agama_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Pekerjaan</th>
                        <td><?php echo $tdatapasien->pekerjaan_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Alamat KTP</th>
                        <td><?php echo $tdatapasien->alamat_ktp_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Domisili</th>
                        <td><?php echo $tdatapasien->alamat_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Ayah Kandung</th>
                        <td><?php echo $tdatapasien->nama_ayah_kandung ?></td>
                      </tr>
                      <tr>
                        <th>Suami</th>
                        <td><?php echo $tdatapasien->nama_pj ?></td>
                      </tr>
                      <tr>
                        <th>Tgl. Lahir Suami</th>
                        <td><?php echo $tdatapasien->tgl_lahir_pj ?></td>
                      </tr>
                      <tr>
                        <th>Pendidikan Suami</th>
                        <td><?php echo $tdatapasien->pendidikan_pj ?></td>
                      </tr>
                      <tr>
                        <th>Agama Suami</th>
                        <td><?php echo $tdatapasien->agama_pj ?></td>
                      </tr>
                      <tr>
                        <th>Pekerjaan Suami</th>
                        <td><?php echo $tdatapasien->pekerjaan_pj ?></td>
                      </tr>
                      <tr>
                        <th>Alamat KTP Suami</th>
                        <td><?php echo $tdatapasien->alamat_ktp_pj ?></td>
                      </tr>
                      <tr>
                        <th>Domisili Suami</th>
                        <td><?php echo $tdatapasien->alamat_pj ?></td>
                      </tr>
                      <tr>
                        <th>Kontak</th>
                        <td><?php echo $tdatapasien->no_telp_pasien ?></td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td><?php echo $tdatapasien->email ?></td>
                      </tr>
                      <tr>
                        <th>Medsos</th>
                        <td><?php echo $tdatapasien->medsos ?></td>
                      </tr>
                      <?php } ?>
                              
                  </table>
                </div>
              </div>
            </div>
          </div>
              <!-- End Detail Pasien-->

      <!-- Histori Kunjungan-->

          <div class="col-md-6 table-histori">
            <div class="card">
                <h4 class="card-title"> <center>Histori Kunjungan </center></h4>
                <div class="card-body">             
                <div class="table-responsive" style="max-height: 940px;">
                  <table id="tableHistori" class="table table-striped table-hover">
                    <div class="scroll" style="hight=100%; overflow=auto;">
                    
                      <th>Waktu Kunjungan</th>
                      <th>Jenis Pelayanan</th>
                    
                      <?php foreach ($gDataHistory->result() as $tdatahistory) {?>
                        <tr>
                           <td><?php echo $tdatahistory->tgl_antrian?></td>
                           <!-- <td><?php echo $tdatahistory->nama_pelayanan?></td> -->
                          <td ><a href="<?php echo base_url('Antrian/getDataAntrian/'.$tdatahistory->id.'/'.str_replace(' ', '', $tdatahistory->nama_pelayanan).'');?>" target="_blank" style="color:black; text-decoration:none;"> <?php echo $tdatahistory->nama_pelayanan?></a></td>
                        </tr>
                      <?php } ?>
                  </table>
                </div>
                </div>
              </div>
            </div>
          </div>

    <!-- End Histori Kunjungan-->
         

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
</html>