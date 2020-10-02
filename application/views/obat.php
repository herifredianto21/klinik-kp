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
    Klinik Nur Khadijah | Obat
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
            <a class="navbar-brand" href="">Obat</a>
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
                	<div class="col-6">
                		<h4 class="card-title"> Tabel Obat</h4>
                	</div>
                	<div class="col-6">
                		<div class="pull-right">
                      <button name="btn_cetak" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Cetak Laporan</button>
                			<button name="btn_add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</button>
                		</div>
                	</div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tableObat" class="table table-striped table-hover">
                    <thead class="text-primary">
                      <th>No.</th>
                      <th>Kode Obat</th>
                      <th>Nama Obat</th>
                      <th>Harga Pokok</th>
                      <th>Harga Jual</th>
                      <th>Stok</th>
                      <th>Stok Minimal</th>
                      <th>Satuan</th>
                      <th>Kategori</th>
                      <th style="min-width: 100px;">Aksi</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div id="form" class="col-md-12" style="display: none;">
            <div class="card">
              <div class="card-header">
                <h4 id="formTitle" class="card-title"> Tambah Data</h4>
              </div>
              <div class="card-body">
                <form id="formData">
                	<div class="row">
                		<div class="col-md-6">
                			<div class="form-group">
                				<label>Kode Obat</label>
                				<input type="text" name="kode_obat" class="form-control" placeholder="Kode Obat" required>
                			</div>
                		</div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text" name="nama_obat" class="form-control" placeholder="Nama Obat" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Harga Pokok</label>
                        <input type="number" name="harga_pokok_obat" class="form-control" placeholder="Harga Pokok" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Harga Jual</label>
                        <input type="number" name="harga_jual_obat" class="form-control" placeholder="Harga Jual" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Stok Minimal</label>
                        <input type="number" name="stok_minimal" class="form-control" placeholder="Stok Minimal" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Satuan</label>
                        <select name="id_satuan" class="form-control"></select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control"></select>
                      </div>
                    </div>
                	</div>
                </form>
              </div>
              <div class="card-footer row">
              	<div class="col-md-2">
            			<button id="0" name="btn_save" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save</button>
            		</div>
            		<div class="col-md-2">
            			<button name="btn_cancel" class="btn btn-danger btn-block"><i class="fa fa-times"></i> Cancel</button>
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
  <script src="<?php echo base_url('assets/js/admina.obat.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

</html>