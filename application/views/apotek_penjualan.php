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
    Admina | Apotek
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
            <a class="navbar-brand" href="">Apotek</a>
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
              <form id="formData">
                <div class="col-md-12 rincian-pembayaran">
                  <h4>1. Biaya Obat</h4>
                  <div class="wrap">
                    <div class="row">
                      <table class="table table-borderless tableObat">
                        <thead>
                          <tr>
                            <th>
                              Nama Obat
                            </th>
                            <th width="100">
                              Qty
                            </th>
                            <th width="200">
                              Nominal
                            </th>
                            <th width="125px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <select name="biaya_obat[]" class="form-control">
                              </select>
                            </td>
                            <td width="100">
                              <input type="number" name="qty_obat[]" class="form-control" value="1">
                            </td>
                            <td width="200">
                              <input type="number" name="biaya_obat_nominal[]" class="form-control" placeholder="Rp. " required>
                            </td>
                            <td width="125px">
                              <button type="button" class="btn btn-success btn-sm btn-block"><i class="fa fa-plus"></i> Tambah</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <h4>2. Diskon</h4>
                  <div class="wrap">
                    <div class="row">
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>
                              <select name="jenis_diskon" class="form-control">
                                <option value="0" selected>- Tidak Ada -</option>
                                <option value="1">BPJS Kesehatan</option>
                                <option value="2">Kerabat/Warga</option>
                              </select>
                            </td>
                            <td width="325">
                              <input type="number" name="biaya_diskon" class="form-control" placeholder="Rp. " required>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <h4>3. Grand Total</h4>
                  <div class="wrap">
                    <div class="row">
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-group">
                                <label>Grand Total:</label>
                                <input type="text" name="total" class="form-control" placeholder="Rp. " readonly>
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <label>Bayar:</label>
                                <input type="number" name="bayar" class="form-control" placeholder="Rp. " required>
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <label>Kembali:</label>
                                <input type="text" name="kembali" class="form-control" placeholder="Rp. " readonly>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="pull-right mb-5">
                    <button name="btn_back" type="button" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button id="0" name="btn_save" type="button" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Selesai</button>
                  </div>
                </div>
              </form>

              <template id="biayaObat">
                <tr>
                  <td>
                    <select name="biaya_obat[]" class="form-control">
                      <option value="0">- Pilih Obat -</option>
                      <?php
                        for ($i=0; $i < count($obat); $i++) { ?>
                          <option value="<?php echo $obat[$i]['id'] ;?>"><?php echo $obat[$i]['nama_obat'] ;?></option>
                        <?php }
                      ?>
                    </select>
                  </td>
                  <td width="100">
                    <input type="number" name="qty_obat[]" class="form-control" value="1">
                  </td>
                  <td width="200">
                    <input type="number" name="biaya_obat_nominal[]" class="form-control" placeholder="Rp. " required>
                  </td>
                  <td width="125px">
                    <button type="button" class="btn btn-danger btn-sm btn-block"><i class="fa fa-trash"></i> Hapus</button>
                  </td>
                </tr>
              </template>

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
  <script src="<?php echo base_url('assets/js/admina.apotek.penjualan.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

</html>