<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Klinik Nur Khadijah | Laporan Rekam Medis
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

  <!-- datatable -->
  <link rel="stylesheet" type="text/css" href="Https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="Https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">
    var baseurl = "<?php echo base_url(); ?>";
  </script>
</head>

<body class="">
  <?php error_reporting(0);?>
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
            <a class="navbar-brand" href="">Laporan Rekam Medis</a>
          </div>
          <button class="navbar-toggler d-print-none" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end d-print-none" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown d-print-none">
                <a class="nav-link dropdown-toggle d-print-none" id="menuProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02 d-print-none"></i>
                  <p>
                    <span class="d-lg-none d-md-block d-print-none">Account</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right d-print-none" aria-labelledby="menuProfile">
                  <a class="dropdown-item d-print-none" href="#">
										<i class="now-ui-icons users_single-02 d-print-none"></i>
										<p>Profile</p>
									</a>
									<a class="dropdown-item d-print-none" href="<?php echo base_url('dashboard/logout/'); ?>">
										<i class="now-ui-icons media-1_button-power d-print-none"></i>
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
                	<div class="col-6">
                		<h4 class="card-title"> Tabel Laporan Rekam Medis</h4>
                	</div>
                	<!-- <div class="col-6">
                		<div class="pull-right">
                			<button name="btn_add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</button>
                		</div>
                	</div> -->
                </div>
              </div>

              <?php
                    $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                    $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                    $id = isset($_GET['id']) ? $_GET['id'] : null;
              ?>

              <div class="card-body d-print-none">
                <form id="formData" action="<?php echo site_url('LaporanRm/pencarianRM')?>" method="GET">
                	<div class="row d-print-none">
                    <div class="col-lg-4 d-print-none">
                      <div class="form-group d-print-none">
                        <label>Jenis Laporan</label>
                        <select name="id" class="form-control d-print-none">
                          <option value="#">PILIH JENIS LAPORAN</option>
                          <option value="1">LAPORAN RM KEHAMILAN</option>
                          <option value="34">LAPORAN RM ISPA</option>
                          <option value="8">LAPORAN RM IMUNISASI</option>
                          <option value="3">LAPORAN RM PERSALINAN</option>
                          <option value="9">LAPORAN RM PEMERIKSAAN UMUM</option>
                          <option value="37">LAPORAN RM PEMERIKSAAN KB</option>
                          <!-- <option value="7"></option> -->
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group d-print-none">
                          <label>Dari</label>
                          <input type="date" name="tgl1" class="form-control d-print-none" value="<?php $tgl1 != null ? $_GET['tgl1'] : '' ?>" required />
                            <!-- <select name="tanggal" class="form-control"> </select> -->
                      </div>
                    </div>
                      <div class="col-lg-2 d-print-none">
                        <div class="form-group d-print-none">
                          <label>Sampai</label>
                          <input type="date" name="tgl2" class="form-control d-print-none" value="<?php $tgl2 != null ? $_GET['tgl2'] : '' ?>" required />
                            <!-- <select name="tanggal" class="form-control"> </select> -->
                        </div>
                      </div>
                    <button type="submit" class="btn btn-info" height="100px">Tampilkan</button>
                    </div>

                    <!-- <button type="submit" class="btn btn-success">EXCEL</button> -->
                	</div>
                </form>
                <a href="<?php echo base_url('LaporanRm/cetakRmEx?tgl1='.$tgl1.'&tgl2='.$tgl2.'&id='.$id); ?>">
                  <button type="button" class="btn btn-success d-print-none">EXCEL</button>
                </a>
                <a href="<?php echo base_url('LaporanRm/cetakRm?tgl1='.$tgl1.'&tgl2='.$tgl2.'&id='.$id); ?>">
                  <button type="button" class="btn btn-danger d-print-none">PDF</button>
                </a>
              </div>

             

                  <!-- Laporan RM Persalinan -->
                  <div class="card">
                  <div class="card-body">
                    <?php
                      if ($id=='1') {
                        echo "Laporan RM Pemeriksaan Kehamilan";
                      } else if($id=='3'){
                        echo "Laporan RM Persalinan";
                      } else if($id=='8'){
                        echo "Laporan RM Imunisasi";
                      } else if($id == '9'){
                        echo "Laporan RM Pemeriksaan Umum";
                      } else if($id == '34'){
                        echo "Laporan RM Program Ispa";
                      }else if ($id == '37'){
                        echo "Laporan RM KB";
                      } else {
                        echo "Laporan RM";
                      }
                    ?>
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>No Registrasi</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $no=1;
                          foreach ($pencarianRM->result() as $i ) { 
                            
                          ?>

                          <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $i->tgl_antrian;?></td>
                            <td><?php echo $i->no_registrasi;?></td>
                            <td><?php echo $i->nama_pasien;?></td>
                            <td><?php echo $i->tgl_lahir;?></td>
                            <td><a href="<?php echo base_url('LaporanRm/detailRmPasien/'.$id.'/'.substr($i->tgl_antrian, 0,10).'/');?>"> Detail</a></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                        </div>
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
  <script src="<?php echo base_url('assets/js/admina.laporan.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>

  <!-- DATATABLES -->

  <script>
                  $(document).ready(function(){
                    $('#tabel-data').DataTable();
                  });
                </script>
</body>

</html>