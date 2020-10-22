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
    Klinik Nur Khadijah | Histori Tindakan Medis Pertenaga Medis
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
      <nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
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
                		<h4 class="card-title"> Tabel Histori Tindakan Medis - Pertenaga Medis</h4>
                  </div>
                	
                </div>
              </div>

              <div class="card-body">

                <!-- Navigasi -->
                <div class="row mb-5">
                  <a href="<?php echo base_url('histori_tindakan_medis/tenaga_medis'); ?>" class="col-sm-6 bg-warning">
                    <div class="p-3 text-center text-white">
                      Tindakan Pertenaga Medis
                    </div>
                  </a>
                  <a href="<?php echo base_url('histori_tindakan_medis/pasien'); ?>" class="col-sm-6">
                    <div class="p-3 text-center text-dark">
                      Tindakan Perpasien
                    </div>
                  </a>
                </div>

                <?php
                  $filter_dari = isset($_GET['filter_dari']) ? $_GET['filter_dari'] : null;
                  $filter_sampai = isset($_GET['filter_sampai']) ? $_GET['filter_sampai'] : null;
                  $id_dokter = isset($_GET['id_dokter']) ? $_GET['id_dokter'] : null;
                ?>

                <!-- Form filter -->
                <fieldset>
                  <legend>Filter</legend>
                  
                  <div id="form" class="col-md-12">
                    <form action="<?php echo base_url('histori_tindakan_medis/tenaga_medis'); ?>" method="GET">
                      <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                          <label>Dari</label>
                          <input type="date" class="form-control" name="filter_dari" value="<?= $filter_dari != null ? $_GET['filter_dari'] : '' ?>" required />
                        </div>
                      </div>
                        
                      <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                          <label>Sampai</label>
                          <input type="date" class="form-control" name="filter_sampai" value="<?= $filter_sampai != null ? $_GET['filter_sampai'] : '' ?>" required />
                        </div>
                      </div>
                      
                      <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                          <label>Dokter</label>
                          <select class="form-control" name="id_dokter" required>
                            <option value="">- Pilih tenaga medis -</option>
                            <?php
                              foreach($tampil_dokter as $td) { ?>
                                <option value="<?= $td->id ?>" <?= $id_dokter != null && $id_dokter == $td->id ? 'selected' : '' ?>><?= $td->nama_dokter ?></option>

                                <?php
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    
                      <div class="col-xs-12 col-md-6">
                        <button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
                      </div>
                    
                    </form>
                    
                  </div>
                </fieldset>


                <!-- Indentitas tenaga medis -->
                <?php
                  if ($filter_dari != null && $filter_sampai != null && $id_dokter != null) { 
                    foreach($tampil_dokter_by_id as $tdbi) {
                      $nama_dokter = $tdbi->nama_dokter;
                      $spesialisasi = $tdbi->spesialisasi;
                      $alamat_dokter = $tdbi->alamat_dokter;
                      $no_hp_dokter = $tdbi->no_hp_dokter;
                    } ?>

                    <div class="col-12 my-5">
                      <div class="row">
                        <div class="col-6 my-2 h4">
                          Nama Tenaga Medis:
                        </div>
                        <div class="col-6 my-2 h4">
                          <?= $nama_dokter ?>
                        </div>
                      </div>    

                      <div class="row">
                        <div class="col-6 my-2 h4">
                          Spesialis:
                        </div>
                        <div class="col-6 my-2 h4">
                        <?= $spesialisasi ?>
                        </div>
                      </div>    

                      <div class="row">
                        <div class="col-6 my-2 h4">
                          Alamat:
                        </div>
                        <div class="col-6 my-2 h4">
                          <?= $alamat_dokter ?>
                        </div>
                      </div>    

                      <div class="row">
                        <div class="col-6 my-2 h4">
                          No. HP:
                        </div>
                        <div class="col-6 my-2 h4">
                          <?= $no_hp_dokter ?>
                        </div>
                      </div>
                    </div>

                    <?php
                  }
                ?>


                <!-- Tabel histori -->
                <?php
                  if ($filter_dari != null && $filter_sampai != null && $id_dokter != null) { ?>
                    <a href="<?= base_url('histori_tindakan_medis/tenaga_medis_cetak?filter_dari=' . $filter_dari . '&filter_sampai=' . $filter_sampai . '&id_dokter= ' . $id_dokter) ?>">
                      <button class="btn btn-info btn-sm"><i class="fa fa-print"></i> Cetak Laporan</button>
                    </a>
                    
                    <div class="table-responsive">

                      <table id="tableApotek" class="table table-striped table-hover">
                        <thead class="text-primary">
                          <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Tindakan Medis</th>
                            <th>Nama Pasien</th>
                            <th>Biaya Jasa</th>
                            <!-- <th>Total</th> -->
                            <!-- <th width="230">Aksi</th> -->
                          </tr>
                        </thead>
                          <tbody>

                            <?php
                              $total = 0;
                              if (!$histori_pertenaga_medis == null) { 
                                $no = 1;

                                foreach($histori_pertenaga_medis as $hpm) {?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $hpm->waktu ?></td>
                                    <td><?= $hpm->nama_pelayanan ?></td>
                                    <td><?= $hpm->nama_pasien ?></td>
                                    <td>Rp. <?= number_format(intval($total+=23500), 2, ',', '.') ?></td>
                                  </tr>
                                  <?php
                                }
                              } else { ?>
                                <tr>
                                  <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                          <tfoot>
                            <tr class="font-weight-bold">
                              <td colspan="4">Total</td>
                              <td>Rp. <?= number_format(intval($total), 2, ',', '.') ?></td>
                            </tr>
                          </tfoot>
                      </table>

                    </div>

                    <?php
                  }
                ?>

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