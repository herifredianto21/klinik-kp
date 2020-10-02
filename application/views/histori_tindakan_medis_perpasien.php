<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Klinik Nur Khadijah | Histori Tindakan Medis Perpasien
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
            <a class="navbar-brand" href="">Histori Tindakan Medis</a>
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
                		<h4 class="card-title"> Tabel Histori Tindakan Medis - Perpasien</h4>
                  </div>
                	
                </div>
              </div>

              <div class="card-body">

                <!-- Navigasi -->
                <div class="row mb-5">
                  <a href="<?php echo base_url('histori_tindakan_medis/tenaga_medis'); ?>" class="col-sm-6">
                    <div class="p-3 text-center text-dark">
                      Tindakan Pertenaga Medis
                    </div>
                  </a>
                  <a href="<?php echo base_url('histori_tindakan_medis/pasien'); ?>" class="col-sm-6 bg-warning">
                    <div class="p-3 text-center text-white">
                      Tindakan Perpasien
                    </div>
                  </a>
                </div>


                <!-- Form filter -->
                <fieldset>
                  <legend>Filter</legend>
                  
                  <div id="form" class="col-md-12">
                    <form action="tenaga_medis" method="get">
                      <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                          <label>Dari</label>
                          <input type="date" class="form-control" name="" id="">
                        </div>
                      </div>
                        
                      <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                          <label>Sampai</label>
                          <select name="id_jenis_laporan" class="form-control"></select>
                        </div>
                      </div>
                      
                      <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                          <label>Pasien</label>
                          <select name="id_jenis_laporan" class="form-control">
                              <option value="">Pilih</option>
                              <option value="1">1</option>
                          </select>
                        </div>
                      </div>
                    
                      <div class="col-xs-12 col-md-6">
                        <button type="submit" id="0" name="btn_save" class="btn btn-primary btn-block">Tampilkan</button>
                      </div>
                    
                    </form>
                    
                  </div>
                </fieldset>

                <!-- Indentitas tenaga medis -->
                <div class="col-12 my-5">
                  <div class="row">
                    <div class="col-6 my-2 h4">
                      Nama Tenaga Medis:
                    </div>
                    <div class="col-6 my-2 h4">
                      Dr. Hary Suryanto
                    </div>
                  </div>    

                  <div class="row">
                    <div class="col-6 my-2 h4">
                      Spesialis:
                    </div>
                    <div class="col-6 my-2 h4">
                      Bidan
                    </div>
                  </div>    

                  <div class="row">
                    <div class="col-6 my-2 h4">
                      Alamat:
                    </div>
                    <div class="col-6 my-2 h4">
                      Jl. Gunung Batu No. 9999, Kel. Sukaraja, Kec. Cicendo, Bandung.
                    </div>
                  </div>    

                  <div class="row">
                    <div class="col-6 my-2 h4">
                      No. HP:
                    </div>
                    <div class="col-6 my-2 h4">
                      081012345678
                    </div>
                  </div>
                </div>
                

                <!-- Tabel histori -->
                <div class="table-responsive">

                  <table id="tableApotek" class="table table-striped table-hover">
                    <thead class="text-primary">
                      <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Nama Pasien</th>
                        <th>Tindakan</th>
                        <th>Keterangan</th>
                        <th>Total</th>
                        <!-- <th width="230">Aksi</th> -->
                      </tr>
                    </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>01/02/2003</td>
                          <td>Rival</td>
                          <td>Pemerikasaan Umum</td>
                          <td>-</td>
                          <td>Rp200.000,00</td>
                        </tr>
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
  <script src="<?php echo base_url('assets/js/admina.histori.tindakan.medis.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

</html>