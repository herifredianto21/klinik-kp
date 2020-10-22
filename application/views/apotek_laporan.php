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
    Admina | Laporan Apotek
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
          Admina
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
            <a class="navbar-brand" href="">Laporan Apotek</a>
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
                		<h4 class="card-title"> Laporan Apotek</h4>
                	</div>
                	<div class="col-6">
                		<div class="pull-right">
                      <button name="btn_kembali" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Kembali</button>
                		</div>
                	</div>
                </div>
              </div>
              <div class="card-body">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <h6>Buat Laporan Harian</h6>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tahun: </label>
                        <select name="harian_tahun" class="form-control">
                          <option value="2019" <?php if(date('Y') == 2019) echo "selected"; ?>>2019</option>
                          <option value="2020" <?php if(date('Y') == 2020) echo "selected"; ?>>2020</option>
                          <option value="2021" <?php if(date('Y') == 2021) echo "selected"; ?>>2021</option>
                          <option value="2022" <?php if(date('Y') == 2022) echo "selected"; ?>>2022</option>
                          <option value="2023" <?php if(date('Y') == 2023) echo "selected"; ?>>2023</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Bulan: </label>
                        <select name="harian_bulan" class="form-control">
                          <option value="01" <?php if(date('m') == '01') echo "selected"; ?>>Januari</option>
                          <option value="02" <?php if(date('m') == '02') echo "selected"; ?>>Februari</option>
                          <option value="03" <?php if(date('m') == '03') echo "selected"; ?>>Maret</option>
                          <option value="04" <?php if(date('m') == '04') echo "selected"; ?>>April</option>
                          <option value="05" <?php if(date('m') == '05') echo "selected"; ?>>Mei</option>
                          <option value="06" <?php if(date('m') == '06') echo "selected"; ?>>Juni</option>
                          <option value="07" <?php if(date('m') == '07') echo "selected"; ?>>Juli</option>
                          <option value="08" <?php if(date('m') == '08') echo "selected"; ?>>Agustus</option>
                          <option value="09" <?php if(date('m') == '09') echo "selected"; ?>>September</option>
                          <option value="10" <?php if(date('m') == '10') echo "selected"; ?>>Oktober</option>
                          <option value="11" <?php if(date('m') == '11') echo "selected"; ?>>November</option>
                          <option value="12" <?php if(date('m') == '12') echo "selected"; ?>>Desember</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tanggal: </label>
                        <select name="harian_tanggal" class="form-control">
                          <?php
                            for ($i=1; $i < 32; $i++) { ?>
                              <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>" <?php if(date('d') == str_pad($i, 2, '0', STR_PAD_LEFT)) echo "selected"; ?>><?php echo $i; ?></option>
                            <?php }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <button name="btn_cetak_harian" class="btn btn-primary">
                          <i class="fa fa-print"></i> Cetak Laporan Harian
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="margin-top:50px;">
                    <div class="col-md-12">
                      <h6>Buat Laporan Bulanan</h6>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tahun: </label>
                        <select name="harian_tahun" class="form-control">
                          <option value="2019" <?php if(date('Y') == 2019) echo "selected"; ?>>2019</option>
                          <option value="2020" <?php if(date('Y') == 2020) echo "selected"; ?>>2020</option>
                          <option value="2021" <?php if(date('Y') == 2021) echo "selected"; ?>>2021</option>
                          <option value="2022" <?php if(date('Y') == 2022) echo "selected"; ?>>2022</option>
                          <option value="2023" <?php if(date('Y') == 2023) echo "selected"; ?>>2023</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Bulan: </label>
                        <select name="harian_bulan" class="form-control">
                          <option value="01" <?php if(date('m') == '01') echo "selected"; ?>>Januari</option>
                          <option value="02" <?php if(date('m') == '02') echo "selected"; ?>>Februari</option>
                          <option value="03" <?php if(date('m') == '03') echo "selected"; ?>>Maret</option>
                          <option value="04" <?php if(date('m') == '04') echo "selected"; ?>>April</option>
                          <option value="05" <?php if(date('m') == '05') echo "selected"; ?>>Mei</option>
                          <option value="06" <?php if(date('m') == '06') echo "selected"; ?>>Juni</option>
                          <option value="07" <?php if(date('m') == '07') echo "selected"; ?>>Juli</option>
                          <option value="08" <?php if(date('m') == '08') echo "selected"; ?>>Agustus</option>
                          <option value="09" <?php if(date('m') == '09') echo "selected"; ?>>September</option>
                          <option value="10" <?php if(date('m') == '10') echo "selected"; ?>>Oktober</option>
                          <option value="11" <?php if(date('m') == '11') echo "selected"; ?>>November</option>
                          <option value="12" <?php if(date('m') == '12') echo "selected"; ?>>Desember</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <button name="btn_cetak_bulanan" class="btn btn-primary">
                          <i class="fa fa-print"></i> Cetak Laporan Bulanan
                        </button>
                      </div>
                    </div>
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
  <script src="<?php echo base_url('assets/js/admina.apotek.laporan.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

</html>