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
      <div class="content">
        <div class="row">
          <div id="table" class="col-md-12">
            <div class="card" id="pasienharusdilayani">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <h4 class="card-title"> Pasien yang harus dilayani: </h4>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <?php
                  error_reporting(0);
                  $panggilAntrian = $_GET['panggil'];
                  $pecah = explode('-', $panggilAntrian);
                  $number = $pecah[0];
                  $poli = $pecah[1];
                ?>
                <?php
                  // $angka=$_GET['angka'];
                  $angka = $number;
                if ($poli == "KB") {
                      
                  if (strlen($angka) == 1) {
                ?>
                  <!-- jika var angka jumlah digitnya 1 -->
                  <audio id="myAudio">
                    <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                  </audio>
                  <audio id="myAudio3">
                    <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                  </audio>
                  <audio id="myAudio4">
                      <source src="<?php echo base_url('assets/rekaman/'.$angka.'.wav');?>" type="audio/wav">
                  </audio>
                  <audio id="myAudio5">
                      <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                  </audio>


                  <!-- jika var angka jumlah digitnya 1 -->

                <?php } else if(strlen($angka) == 2){ ?>
                  <!-- jika var angka jumlah digitnya 2 -->
                    <?php
                      if ($angka == 10) { ?>
                      <!-- jika $angka isinya 10 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 10 -->

                    <?php   } else if ($angka == 11){ ?>
                      <!-- jika $angka isinya 11   -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 11   -->

                    <?php } else if ($angka >=12 && $angka <=19){ ?>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 20 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong = substr($angka, 1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 19 -->
                    
                      <!-- jika $angka isinya 20 - 99 -->
                    <?php } else if ($angka >=20 && $angka <=99){ ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka,1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong1.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio6">
                            <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya 20 - 99 -->
                  <?php } ?>
                  <!-- jika var angka jumlah digitnya 2 -->

                  <!-- jika var angka jumlah digitnya 3 -->
                <?php } else if(strlen($angka) == 3){ ?>
                      <!-- jika $angka isinya =100 -->
                      <?php if ($angka == 100) { ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya =100 -->

                        <!-- jika $angka isinya 101 sampai 109 -->
                      <?php } else if ($angka >=101 && $angka <=109) { ?>
                          <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 101 sampai 109 -->

                          <!-- jika $angka isinya = 110 -->
                      <?php } else if ($angka == 110) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya = 110 -->

                          <!-- jika $angka isinya =111 -->
                      <?php } else if ($angka == 111 ) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika angka isinya =111 -->

                          <!-- jika $angka isinya 112 sampai 119 -->
                      <?php } else if ($angka >=112 && $angka <= 119) { ?>
                          <?php
                            // $potong1 = substr($angka, 0,1);
                            // $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 112 sampai 119 -->

                          <!-- jika $angka isinya 120 sampai 199 -->
                      <?php } else if ($angka >=120 && $angka <=199){ ?> 
                            <?php
                            // $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                            ?>
                            <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                            </audio>
                            <audio id="myAudio3">
                              <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                            </audio>
                            <audio id="myAudio4">
                                <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio2">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio5">
                                <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio6">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio7">
                                <source src="<?php echo base_url('assets/rekaman/poliKb.wav');?>" type="audio/wav">
                            </audio>
                      <?php } ?>     
                <?php } ?> 

                <!-- untuk poli pemeriksaan umum -->
                <?php } else if ($poli == "PemeriksaanUmum"){ ?>
                <?php  if (strlen($angka) == 1) {
                ?>
                  <!-- jika var angka jumlah digitnya 1 -->
                  <audio id="myAudio">
                    <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                  </audio>
                  <audio id="myAudio3">
                    <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                  </audio>
                  <audio id="myAudio4">
                      <source src="<?php echo base_url('assets/rekaman/'.$angka.'.wav');?>" type="audio/wav">
                  </audio>
                  <audio id="myAudio5">
                      <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                  </audio>


                  <!-- jika var angka jumlah digitnya 1 -->

                <?php } else if(strlen($angka) == 2){ ?>
                  <!-- jika var angka jumlah digitnya 2 -->
                    <?php
                      if ($angka == 10) { ?>
                      <!-- jika $angka isinya 10 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 10 -->

                    <?php   } else if ($angka == 11){ ?>
                      <!-- jika $angka isinya 11   -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 11   -->

                    <?php } else if ($angka >=12 && $angka <=19){ ?>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 20 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong = substr($angka, 1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 19 -->
                    
                      <!-- jika $angka isinya 20 - 99 -->
                    <?php } else if ($angka >=20 && $angka <=99){ ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka,1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong1.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio6">
                            <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya 20 - 99 -->
                  <?php } ?>
                  <!-- jika var angka jumlah digitnya 2 -->

                  <!-- jika var angka jumlah digitnya 3 -->
                <?php } else if(strlen($angka) == 3){ ?>
                      <!-- jika $angka isinya =100 -->
                      <?php if ($angka == 100) { ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya =100 -->

                        <!-- jika $angka isinya 101 sampai 109 -->
                      <?php } else if ($angka >=101 && $angka <=109) { ?>
                          <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 101 sampai 109 -->

                          <!-- jika $angka isinya = 110 -->
                      <?php } else if ($angka == 110) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya = 110 -->

                          <!-- jika $angka isinya =111 -->
                      <?php } else if ($angka == 111 ) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika angka isinya =111 -->

                          <!-- jika $angka isinya 112 sampai 119 -->
                      <?php } else if ($angka >=112 && $angka <= 119) { ?>
                          <?php
                            // $potong1 = substr($angka, 0,1);
                            // $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 112 sampai 119 -->

                          <!-- jika $angka isinya 120 sampai 199 -->
                      <?php } else if ($angka >=120 && $angka <=199){ ?> 
                            <?php
                            // $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                            ?>
                            <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                            </audio>
                            <audio id="myAudio3">
                              <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                            </audio>
                            <audio id="myAudio4">
                                <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio2">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio5">
                                <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio6">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio7">
                                <source src="<?php echo base_url('assets/rekaman/poliUmum.wav');?>" type="audio/wav">
                            </audio>
                      <?php } ?>     
                <?php } ?>


                <!-- untuk pemeriksaan imunisasi -->
                <?php } else if ($poli == "Imunisasi"){ ?>
                <?php  if (strlen($angka) == 1) {
                ?>
                  <!-- jika var angka jumlah digitnya 1 -->
                  <audio id="myAudio">
                    <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                  </audio>
                  <audio id="myAudio3">
                    <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                  </audio>
                  <audio id="myAudio4">
                      <source src="<?php echo base_url('assets/rekaman/'.$angka.'.wav');?>" type="audio/wav">
                  </audio>
                  <audio id="myAudio5">
                      <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                  </audio>


                  <!-- jika var angka jumlah digitnya 1 -->

                <?php } else if(strlen($angka) == 2){ ?>
                  <!-- jika var angka jumlah digitnya 2 -->
                    <?php
                      if ($angka == 10) { ?>
                      <!-- jika $angka isinya 10 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 10 -->

                    <?php   } else if ($angka == 11){ ?>
                      <!-- jika $angka isinya 11   -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 11   -->

                    <?php } else if ($angka >=12 && $angka <=19){ ?>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 20 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong = substr($angka, 1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 19 -->
                    
                      <!-- jika $angka isinya 20 - 99 -->
                    <?php } else if ($angka >=20 && $angka <=99){ ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka,1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong1.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio6">
                            <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya 20 - 99 -->
                  <?php } ?>
                  <!-- jika var angka jumlah digitnya 2 -->

                  <!-- jika var angka jumlah digitnya 3 -->
                <?php } else if(strlen($angka) == 3){ ?>
                      <!-- jika $angka isinya =100 -->
                      <?php if ($angka == 100) { ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya =100 -->

                        <!-- jika $angka isinya 101 sampai 109 -->
                      <?php } else if ($angka >=101 && $angka <=109) { ?>
                          <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 101 sampai 109 -->

                          <!-- jika $angka isinya = 110 -->
                      <?php } else if ($angka == 110) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya = 110 -->

                          <!-- jika $angka isinya =111 -->
                      <?php } else if ($angka == 111 ) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika angka isinya =111 -->

                          <!-- jika $angka isinya 112 sampai 119 -->
                      <?php } else if ($angka >=112 && $angka <= 119) { ?>
                          <?php
                            // $potong1 = substr($angka, 0,1);
                            // $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 112 sampai 119 -->

                          <!-- jika $angka isinya 120 sampai 199 -->
                      <?php } else if ($angka >=120 && $angka <=199){ ?> 
                            <?php
                            // $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                            ?>
                            <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                            </audio>
                            <audio id="myAudio3">
                              <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                            </audio>
                            <audio id="myAudio4">
                                <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio2">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio5">
                                <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio6">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio7">
                                <source src="<?php echo base_url('assets/rekaman/poliImunisasi.wav');?>" type="audio/wav">
                            </audio>
                      <?php } ?>     
                <?php } ?>


                <!-- untuk pemeriksaan kehamilan -->
                <?php } else if ($poli == "PemeriksaanKehamilan"){ ?>
                <?php  if (strlen($angka) == 1) {
                ?>
                  <!-- jika var angka jumlah digitnya 1 -->
                  <audio id="myAudio">
                    <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                  </audio>
                  <audio id="myAudio3">
                    <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                  </audio>
                  <audio id="myAudio4">
                      <source src="<?php echo base_url('assets/rekaman/'.$angka.'.wav');?>" type="audio/wav">
                  </audio>
                  <audio id="myAudio5">
                      <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                  </audio>


                  <!-- jika var angka jumlah digitnya 1 -->

                <?php } else if(strlen($angka) == 2){ ?>
                  <!-- jika var angka jumlah digitnya 2 -->
                    <?php
                      if ($angka == 10) { ?>
                      <!-- jika $angka isinya 10 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 10 -->

                    <?php   } else if ($angka == 11){ ?>
                      <!-- jika $angka isinya 11   -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 11   -->

                    <?php } else if ($angka >=12 && $angka <=19){ ?>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 20 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong = substr($angka, 1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 19 -->
                    
                      <!-- jika $angka isinya 20 - 99 -->
                    <?php } else if ($angka >=20 && $angka <=99){ ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka,1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong1.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio6">
                            <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya 20 - 99 -->
                  <?php } ?>
                  <!-- jika var angka jumlah digitnya 2 -->

                  <!-- jika var angka jumlah digitnya 3 -->
                <?php } else if(strlen($angka) == 3){ ?>
                      <!-- jika $angka isinya =100 -->
                      <?php if ($angka == 100) { ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya =100 -->

                        <!-- jika $angka isinya 101 sampai 109 -->
                      <?php } else if ($angka >=101 && $angka <=109) { ?>
                          <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 101 sampai 109 -->

                          <!-- jika $angka isinya = 110 -->
                      <?php } else if ($angka == 110) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya = 110 -->

                          <!-- jika $angka isinya =111 -->
                      <?php } else if ($angka == 111 ) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika angka isinya =111 -->

                          <!-- jika $angka isinya 112 sampai 119 -->
                      <?php } else if ($angka >=112 && $angka <= 119) { ?>
                          <?php
                            // $potong1 = substr($angka, 0,1);
                            // $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 112 sampai 119 -->

                          <!-- jika $angka isinya 120 sampai 199 -->
                      <?php } else if ($angka >=120 && $angka <=199){ ?> 
                            <?php
                            // $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                            ?>
                            <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                            </audio>
                            <audio id="myAudio3">
                              <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                            </audio>
                            <audio id="myAudio4">
                                <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio2">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio5">
                                <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio6">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio7">
                                <source src="<?php echo base_url('assets/rekaman/poliKehamilan.wav');?>" type="audio/wav">
                            </audio>
                      <?php } ?>     
                <?php } ?>


                <!-- untuk pemeriksaan persalinan -->
                <?php } else if ($poli == "Persalinan"){ ?>
                <?php  if (strlen($angka) == 1) {
                ?>
                  <!-- jika var angka jumlah digitnya 1 -->
                  <audio id="myAudio">
                    <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                  </audio>
                  <audio id="myAudio3">
                    <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                  </audio>
                  <audio id="myAudio4">
                      <source src="<?php echo base_url('assets/rekaman/'.$angka.'.wav');?>" type="audio/wav">
                  </audio>
                  <audio id="myAudio5">
                      <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                  </audio>


                  <!-- jika var angka jumlah digitnya 1 -->

                <?php } else if(strlen($angka) == 2){ ?>
                  <!-- jika var angka jumlah digitnya 2 -->
                    <?php
                      if ($angka == 10) { ?>
                      <!-- jika $angka isinya 10 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 10 -->

                    <?php   } else if ($angka == 11){ ?>
                      <!-- jika $angka isinya 11   -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 11   -->

                    <?php } else if ($angka >=12 && $angka <=19){ ?>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 20 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong = substr($angka, 1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 19 -->
                    
                      <!-- jika $angka isinya 20 - 99 -->
                    <?php } else if ($angka >=20 && $angka <=99){ ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka,1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong1.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio6">
                            <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya 20 - 99 -->
                  <?php } ?>
                  <!-- jika var angka jumlah digitnya 2 -->

                  <!-- jika var angka jumlah digitnya 3 -->
                <?php } else if(strlen($angka) == 3){ ?>
                      <!-- jika $angka isinya =100 -->
                      <?php if ($angka == 100) { ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya =100 -->

                        <!-- jika $angka isinya 101 sampai 109 -->
                      <?php } else if ($angka >=101 && $angka <=109) { ?>
                          <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 101 sampai 109 -->

                          <!-- jika $angka isinya = 110 -->
                      <?php } else if ($angka == 110) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya = 110 -->

                          <!-- jika $angka isinya =111 -->
                      <?php } else if ($angka == 111 ) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika angka isinya =111 -->

                          <!-- jika $angka isinya 112 sampai 119 -->
                      <?php } else if ($angka >=112 && $angka <= 119) { ?>
                          <?php
                            // $potong1 = substr($angka, 0,1);
                            // $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 112 sampai 119 -->

                          <!-- jika $angka isinya 120 sampai 199 -->
                      <?php } else if ($angka >=120 && $angka <=199){ ?> 
                            <?php
                            // $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                            ?>
                            <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                            </audio>
                            <audio id="myAudio3">
                              <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                            </audio>
                            <audio id="myAudio4">
                                <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio2">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio5">
                                <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio6">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio7">
                                <source src="<?php echo base_url('assets/rekaman/poliPersalinan.wav');?>" type="audio/wav">
                            </audio>
                      <?php } ?>     
                <?php } ?>


                <!-- untuk pemeriksaan ispa -->
                <?php } else if ($poli == "ProgramISPA"){ ?>
                  <?php  if (strlen($angka) == 1) {
                ?>
                  <!-- jika var angka jumlah digitnya 1 -->
                  <audio id="myAudio">
                    <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                  </audio>
                  <audio id="myAudio3">
                    <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                  </audio>
                  <audio id="myAudio4">
                      <source src="<?php echo base_url('assets/rekaman/'.$angka.'.wav');?>" type="audio/wav">
                  </audio>
                  <audio id="myAudio5">
                      <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                  </audio>


                  <!-- jika var angka jumlah digitnya 1 -->

                <?php } else if(strlen($angka) == 2){ ?>
                  <!-- jika var angka jumlah digitnya 2 -->
                    <?php
                      if ($angka == 10) { ?>
                      <!-- jika $angka isinya 10 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 10 -->

                    <?php   } else if ($angka == 11){ ?>
                      <!-- jika $angka isinya 11   -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya 11   -->

                    <?php } else if ($angka >=12 && $angka <=19){ ?>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 20 -->
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong = substr($angka, 1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                        </audio>
                      <!-- jika $angka isinya lebih dari 11 kurang dari 19 -->
                    
                      <!-- jika $angka isinya 20 - 99 -->
                    <?php } else if ($angka >=20 && $angka <=99){ ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka,1);
                            ?>
                            <source src="<?php echo base_url('assets/rekaman/'.$potong1.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio2">
                            <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio6">
                            <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya 20 - 99 -->
                  <?php } ?>
                  <!-- jika var angka jumlah digitnya 2 -->

                  <!-- jika var angka jumlah digitnya 3 -->
                <?php } else if(strlen($angka) == 3){ ?>
                      <!-- jika $angka isinya =100 -->
                      <?php if ($angka == 100) { ?>
                        <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                        </audio>
                        <audio id="myAudio3">
                          <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                        </audio>
                        <audio id="myAudio4">
                            <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                        </audio>
                        <audio id="myAudio5">
                            <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                        </audio>
                        <!-- jika $angka isinya =100 -->

                        <!-- jika $angka isinya 101 sampai 109 -->
                      <?php } else if ($angka >=101 && $angka <=109) { ?>
                          <?php
                            $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 101 sampai 109 -->

                          <!-- jika $angka isinya = 110 -->
                      <?php } else if ($angka == 110) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sepuluh.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya = 110 -->

                          <!-- jika $angka isinya =111 -->
                      <?php } else if ($angka == 111 ) { ?>
                          <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/sebelas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika angka isinya =111 -->

                          <!-- jika $angka isinya 112 sampai 119 -->
                      <?php } else if ($angka >=112 && $angka <= 119) { ?>
                          <?php
                            // $potong1 = substr($angka, 0,1);
                            // $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                          ?>
                          <audio id="myAudio">
                            <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                          </audio>
                          <audio id="myAudio3">
                            <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                          </audio>
                          <audio id="myAudio4">
                              <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio2">
                              <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio5">
                              <source src="<?php echo base_url('assets/rekaman/belas.wav');?>" type="audio/wav">
                          </audio>
                          <audio id="myAudio6">
                              <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                          </audio>
                          <!-- jika $angka isinya 112 sampai 119 -->

                          <!-- jika $angka isinya 120 sampai 199 -->
                      <?php } else if ($angka >=120 && $angka <=199){ ?> 
                            <?php
                            // $potong1 = substr($angka, 0,1);
                            $potong2 = substr($angka, 1,1);
                            $potong3 = substr($angka,2);
                            ?>
                            <audio id="myAudio">
                              <source src="<?php echo base_url('assets/rekaman/bell.mp3');?>" >
                            </audio>
                            <audio id="myAudio3">
                              <source src="<?php echo base_url('assets/rekaman/nomor-urut.wav');?>" type="audio/wav" >
                            </audio>
                            <audio id="myAudio4">
                                <source src="<?php echo base_url('assets/rekaman/seratus.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio2">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong2.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio5">
                                <source src="<?php echo base_url('assets/rekaman/puluh.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio6">
                                <source src="<?php echo base_url('assets/rekaman/'.$potong3.'.wav');?>" type="audio/wav">
                            </audio>
                            <audio id="myAudio7">
                                <source src="<?php echo base_url('assets/rekaman/poliIspa.wav');?>" type="audio/wav">
                            </audio>
                      <?php } ?>     
                <?php } ?>
                <?php } ?>
                  <!-- jika var angka jumlah digitnya 3 -->

                  <button onclick="playAudio()" class="btn btn-default" style="float:right;" type="button">Panggil Antrian</button>

                <div class="table-responsive">
                  <table id="tableHarusDilayani" class="table table-striped table-hover">
                    <thead class="table-danger">
                      <th>No. Antrian</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pelayanan</th>
                      <th>Dokter</th>
                      <th>Status</th>
                      <th>Waktu</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php 
                         foreach ($harusDilayani->result() as $hd ) {
                      ?>
                      <tr>
                        <td><input type="text" name="id" value="<?php echo $hd->id;?>" hidden><?php echo $hd->no_antrian;?></td>
                        <td><?php echo $hd->nama_pasien;?></td>
                        <td><?php echo $hd->nama_pelayanan;?></td>
                        <td><?php echo $hd->nama_dokter;?></td>
                        <td><?php echo $hd->status_antrian;?></td>
                        <td><?php echo $hd->tgl_antrian;?></td>
                        <td>
                          <?php echo anchor('Dashboard/updateDataAntrian/'.$hd->id.'/'.$hd->no_antrian.'/'.str_replace(' ', '', $hd->nama_pelayanan),'<button class="btn btn-info btn-sm" title="Layani Pasien" style="width:85px;"><i class="fa fa-check"></i>Layani</button>'); ?> 
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> 
       
        <div class="row">
          <div id="table" class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-6">
                    <h4 class="card-title"> Pasien yang sudah dilayani: </h4>
                  </div>
                  <div class="col-3">
                    
                  </div>
                  <div class="col-3 form-group">
                    <label><b>Filter Hari:</b></label>
                    <input type="date" name="filterDate" class="form-control">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead class="text-primary">
                      <th>No Antrian.</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pelayanan</th>
                      <th>Dokter</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($query->result() as $baris) {
                      ?>
                      <tr>
                        <td><?php echo $baris->no_antrian;?></td>
                        <td><?php echo $baris->nama_pasien;?></td>
                        <td><?php echo $baris->nama_pelayanan;?></td>
                        <td><?php echo $baris->nama_dokter;?></td>
                        <td><?php echo $baris->status_antrian;?></td>
                        <td><?php echo $baris->tgl_antrian;?></td>
                      </tr>  
                      <?php } ?>                   
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pop up tambah kunjungan angga -->
        <div class="modal fade" id="tambahKunjungan" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahKunjunganLabel">Tambah Kunjungan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo base_url('Dashboard/simpanAntrian');?>">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Jenis Pelayanan</label>
                        <br>
                        <select class="form-control" id="jp" name="jenisPelayanan" class="form-control" style="width:100%;" required>
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
                        <select name="namaPasien" id="pasien" class="form-control" style="width:100%;">
                          <?php 
                            foreach ($pasien->result() as $np) {
                          ?>
                          <option value="<?php echo $np->id;?>"> <?php echo $np->no_registrasi." | ".$np->nama_pasien;?> </option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Dokter</label>
                        <select name="namaDokter" id="dokter" class="form-control" style="width:100%;">
                          <?php
                            foreach ($dokter->result() as $nd) {
                          ?>
                          <option value="<?php echo $nd->id;?>"><?php echo $nd->nama_dokter;?></option>
                          <?php
                            }
                          ?>
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
                        <input type="text" name="tgl_antrian" class="form-control" placeholder="Tanggal Antrian" value="<?php echo gmdate("Y-m-d H:i:s", time()+60*60*7);?>" required readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Kode Antrian</label>
                        <?php
                          foreach ($kdAntrian->result() as $kd ) {
                            $getKd = $kd->kode_antrian;
                            $pecahKd = substr($getKd, 2);
                            $angka = $pecahKd+1;
                            $kode = "A-".$angka;
                        ?>
                        <input type="text" name="kode_antrian" class="form-control" placeholder="Kode Antrian" value="<?php echo $kode;?>"readonly>
                        <?php } ?>
                      </div>
                    </div>
                   <!--  <div class="col-md-12">
                      <label>Catatan</label>
                      <textarea class="form-control"></textarea>
                    </div> -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                   
                    <button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</button>
                  </div>
                
                </form>
                 <!-- <button class="btn btn-success d-print-none m-4" onclick="cetak()">Cetak struk</button> -->
              </div>
             
            </div>
          </div>
        </div>
        <!-- end pop up tambah kunjungan -->

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
  <script src="<?php echo base_url('assets/js/admina.dashboard.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
  <!-- untuk perhitungan -->
  
  <!-- untuk antrian -->
  <script>
        $(document).ready(function() {
            $('#jp').change(function() {
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Dashboard/getNoPelayanan') ?>",
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
                $('#dataTables-example').dataTable({"ordering": false});
                $('#tableHarusDilayani').dataTable({"ordering": false});
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
  

  
  <!-- js untuk suara   -->
  <script>
    var a = document.getElementById("myAudio");
    var b = document.getElementById("myAudio3");
    var c = document.getElementById("myAudio4"); 
    var belas = document.getElementById("myAudio2");
    var puluhan = document.getElementById("myAudio5");
    var d = document.getElementById("myAudio6");
    var e = document.getElementById("myAudio7"); 
    

    function playAudio() { 
    a.play();
    setTimeout(()=>{
      b.play();
    },6000);
    setTimeout(()=>{
      c.play();
    },8000);
    setTimeout(()=>{
      belas.play();
    },8699);
    setTimeout(()=>{
      puluhan.play();
    },9489);
    setTimeout(()=>{
      d.play();
    },10000);
    setTimeout(()=>{
      e.play();
    },10100);
    //   x.play(); 
    // setTimeout(()=>{
    // y.play();
    // },1000);
       
    } 

  </script>

</body>

</html>