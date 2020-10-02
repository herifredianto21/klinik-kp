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
                <form id="formData" action="<?php echo site_url('LaporanRm/lapRekamMedis')?>" method="GET">
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

              <?php
                $id = isset($_GET['id']) ? $_GET['id'] : null;
              ?>

              <?php
                if ($id == 3) { ?>

                  <!-- Laporan RM Persalinan -->
                  <div class="card">
                  <div class="card-body">
                    <p>Laporan RM Persalinan</p>
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>No Registrasi</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                            <th>Tanggal Lahir</th>
                            <th>Jam Lahir</th>
                            <th>BB</th>
                            <th>PB</th>
                            <th>Resiko</th>
                            <th>Diagnosa</th>
                            <th>Nama Obat</th>
                            <th>Tindakan Medis</th>
                            <!-- <th>Obatt</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=1;
                            foreach($lapRekamMedis_model as $hpm) { ?>
                              <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $hpm->created_at ?></td>
                                <td><?= $hpm->no_registrasi ?></td>
                                <td><?= $hpm->nama_pasien ?></td>
                                <td><?= $hpm->jenis_kelamin ?></td>
                                <td><?= $hpm->umur ?></td>
                                <td><?= $hpm->tgl_lahir ?></td>
                                <td><?= $hpm->jam_lahir ?></td>
                                <td><?= $hpm->bb ?></td>
                                <td><?= $hpm->pb ?></td>
                                <td><?= $hpm->resiko ?></td>
                                <td><?= $hpm->catatan ?></td>
                                <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmTindakanMedisPersalinan($hpm->id_antrian) as $hpm) {
                                        echo $hpm->nama_biaya_medis . ', ';
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmObatPersalinan($hpm->id_antrian) as $hpm) {
                                        echo $hpm->nama_obat . ', ';
                                      }
                                    ?>
                                  </td>
                              </tr>
                              <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>

                  <?php
                } else if ($id == 34) { ?>

                  <!-- Laporan RM Ispa -->
                  <div class="card">
                    <div class="card-body">
                      <p>Laporan RM Ispa</p>
                      <div class="table-responsive">
                        <table id="tabel-data" class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Waktu</th>
                              <th>No Registrasi</th>
                              <th>Nama Anak</th>
                              <th>Jenis Kelamin</th>
                              <th>Umur Tahun</th>
                              <th>Umur Bulan</th>
                              <th>TB-PB</th>
                              <th>BB</th>
                              <th>Catatan</th>
                              <th>Nama Obat</th>
                              <th>Tindakan Medis</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach($lapRekamMedisIspaa as $i) { ?>
                                <tr>
                                  <td><?= $no++ ?></td>
                                  <td><?= $i->created_at ?></td>
                                  <td><?= $i->no_registrasi ?></td>
                                  <td><?= $i->nama_anak ?></td>
                                  <td><?= $i->jenis_kelamin ?></td>
                                  <td><?= $i->umur_tahun ?></td>
                                  <td><?= $i->umur_bulan ?></td>
                                  <td><?= $i->tb_pb ?></td>
                                  <td><?= $i->bb ?></td>
                                  <td><?= $i->catatan ?></td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmTindakanMedisIspa($i->id_antrian) as $o) {
                                        echo $o->nama_biaya_medis . ', ';
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmObatIspa($i->id_antrian) as $o) {
                                        echo $o->nama_obat . ', ';
                                      }
                                    ?>
                                  </td>
                                </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <?php
                } else if ($id == 8) { ?>

                  <!-- Laporan RM Imunisasi -->
                  <div class="card">
                    <div class="card-body">
                      <p>Laporan RM Imunisasi</p>
                      <div class="table-responsive">
                        <table id="tabel-data" class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Waktu</th>
                              <th>Nama Anak</th>
                              <th>Tanggal Lahir</th>
                              <th>BB Lahir</th>
                              <th>BB</th>
                              <th>PB</th>
                              <th>ID Macam Imunisasi</th>
                              <th>HB0</th>
                              <th>BCG</th>
                              <th>Pentabio1</th>
                              <th>Pentabio2</th>
                              <th>Pentabio3</th>
                              <th>tt</th>
                              <th>Pentabio Ulang</th>
                              <th>Campak Ulang</th>
                              <th>Id Macam Tindakan Imunisasi</th>
                              <th>Catatan</th>
                              <th>Tindakan Medis</th>
                              <th>Nama Obat</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach($lapRekamMedisImunisasi as $i) { ?>
                                <tr>
                                  <td><?= $no++ ?></td>
                                  <td><?= $i->created_at ?></td>
                                  <td><?= $i->nama_anak ?></td>
                                  <td><?= $i->tgl_lahir ?></td>
                                  <td><?= $i->bb_lahir ?></td>
                                  <td><?= $i->bb ?></td>
                                  <td><?= $i->pb ?></td>
                                  <td><?= $i->id_macam_imunisasi ?></td>
                                  <td><?= $i->hb0 ?></td>
                                  <td><?= $i->bcg ?></td>
                                  <td><?= $i->pentabio1 ?></td>
                                  <td><?= $i->pentabio2 ?></td>
                                  <td><?= $i->pentabio3 ?></td>
                                  <td><?= $i->tt ?></td>
                                  <td><?= $i->pentabio_ulang ?></td>
                                  <td><?= $i->campak_ulang ?></td>
                                  <td><?= $i->nama_tindakan ?></td>
                                  <td><?= $i->catatan ?></td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->TindakanMedisImun($i->id_antrian) as $o) {
                                        echo $o->nama_biaya_medis . ', ';
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmObatImunisasi($i->id_antrian) as $o) {
                                        echo $o->nama_obat . ', ';
                                      }
                                    ?>
                                  </td>
                                </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>


                  <?php
                } else if ($id == 9)

                { ?>

                    <!-- Laporan RM Pemeriksaan Umum -->
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                      <p>Laporan RM Pemeriksaan Umum</p>
                        <table id="tabel-data" class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Waktu</th>
                              <th>Nama Pasien</th>
                              <th>Jenis Kelamin</th>
                              <th>Nama Penyakit</th>
                              <th>Rentang Umur</th>
                              <th>Macam Tindakan Imunisasi</th>
                              <th>catatan</th>
                              <th>Tindakan Medis</th>
                              <th>Nama Obat</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach($lapRekamMedisUmum as $u) { ?>
                                <tr>
                                  <td><?= $no++ ?></td>
                                  <td><?= $u->created_at ?></td>
                                  <td><?= $u->nama_pasien ?></td>
                                  <td><?= $u->jenis_kelamin ?></td>
                                  <td><?= $u->nama_penyakit ?></td>
                                  <td><?= $u->rentang_umur ?></td>
                                  <td><?php if($u->id_macam_tindakan_imunisasi == "1"){
                                    echo "Khitan";
                                  } else{
                                    echo "Tindik";
                                  } ?></td>
                                  <td><?= $u->catatan ?></td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmTindakanMedisUmum($u->id_antrian) as $u) {
                                        echo $u->nama_biaya_medis . ', ';
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmObatUmum($u->id_antrian) as $u) {
                                        echo $u->nama_obat . ', ';
                                      }
                                    ?>
                                  </td>
                                </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                <?php } else if ($id==37) { ?>

                    <!-- Laporan RM KB -->
                  <div class="card">
                    <div class="card-body">
                      <p>Laporan RM KB</p>
                      <div class="table-responsive">
                        <table id="tabel-data" class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Waktu</th>
                              <!-- <th>Id Antrian</th> -->
                              <th>Nama Pasien</th>
                              <th>Umur</th>
                              <th>Nama Suami</th>
                              <th>Alamat</th>
                              <th>Jumlah Anak Laki</th>
                              <th>Jumlah Anak Perempuan</th>
                              <th>Jumlah Anak</th>
                              <th>Usia Anak Terkecil</th>
                              <th>Id Satuan Usia</th>
                              <th>Pasang Baru</th>
                              <th>Pasang Cabut</th>
                              <th>Id Kontrasepsi</th>
                              <th>Akli</th>
                              <th>T-4</th>
                              <th>Ganti Cara</th>
                              <th>catatan</th>
                              <th>Tindakan Medis</th>
                              <th>Nama Obat</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach($lapRekamMedisKb as $i) { ?>
                                <tr>
                                  <td><?= $no++ ?></td>
                                  <td><?= $i->created_at ?></td>
                                  <td><?= $i->nama_pasien ?></td>
                                  <td><?= $i->umur ?></td>
                                  <td><?= $i->nama_suami ?></td>
                                  <td><?= $i->alamat ?></td>
                                  <td><?= $i->jml_anak_laki ?></td>
                                  <td><?= $i->jml_anak_perempuan ?></td>
                                  <td><?= $i->jml_anak ?></td>
                                  <td><?= $i->usia_anak_terkecil ?></td>
                                  <td><?= $i->id_satuan_usia ?></td>
                                  <td><?= $i->pasang_baru ?></td>
                                  <td><?= $i->pasang_cabut ?></td>
                                  <td><?= $i->id_alat_kontrasepsi ?></td>
                                  <td><?= $i->akli ?></td>
                                  <td><?= $i->t_4 ?></td>
                                  <td><?= $i->ganti_cara ?></td>
                                  <td><?= $i->catatan ?></td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmTindakanMedisKb($i->id_antrian) as $i) {
                                        echo $i->nama_biaya_medis . ', ';
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmObatKb($i->id_antrian) as $i) {
                                        echo $i->nama_obat . ', ';
                                      }
                                    ?>
                                  </td>
                                </tr>
                                <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                <?php } else if ($id==1) { ?>

                      <!-- Laporan RM Kehamilan -->
                    <div class="card">
                      <div class="card-body">
                        <p>Laporan RM Kehamilan</p>
                        <div class="table-responsive">
                          <table id="tabel-data" class="table table-bordered">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>No Registrasi</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Lahir</th>
                                <!-- <th>HPHT</th>
                                <th>TP</th>
                                <th>BB</th>
                                <th>TB</th>
                                <th>Usia Kehamilan</th>
                                <th>GPA</th>
                                <th>K1</th>
                                <th>K4</th>
                                <th>TT</th>
                                <th>LILA</th>
                                <th>Hb</th>
                                <th>Resiko</th>
                                <th>Keterangan</th>
                                <th>catatan</th>
                                <th>Tindakan Medis</th>
                                <th>Nama Obat</th> -->
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no=1;
                                foreach($lapRekamMedisKehamilan as $i) { ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $i->created_at ?></td>
                                    <td><?= $i->no_registrasi ?></td>
                                    <td><?= $i->nama_pasien ?></td>
                                    <td><?= $i->tgl_lahir ?></td>
                                    <!-- <td><?= $i->hpht ?></td>
                                    <td><?= $i->tp ?></td>
                                    <td><?= $i->bb ?></td>
                                    <td><?= $i->tb ?></td>
                                    <td><?= $i->usia_kehamilan ?></td>
                                    <td><?= $i->gpa ?></td>
                                    <td><?= $i->k1 ?></td>
                                    <td><?= $i->k4 ?></td>
                                    <td><?= $i->tt ?></td>
                                    <td><?= $i->lila ?></td>
                                    <td><?= $i->hb ?></td>
                                    <td><?= $i->resiko ?></td>
                                    <td><?= $i->keterangan ?></td>
                                    <td><?= $i->catatan ?></td> -->
                                    <!-- <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->TindakanMedisKehamilan($i->id_antrian) as $o) {
                                        echo $o->nama_biaya_medis . ', ';
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                                      foreach($this->controller->RmObatKehamilan($i->id_antrian) as $o) {
                                        echo $o->nama_obat . ', ';
                                      }
                                    ?>
                                  </td> -->
                                  <td>
                                    <a href="<?php echo base_url('LaporanRm/detailRm?tgl1='.$tgl1.'&tgl2='.$tgl2.'&id='.$id); ?>">
                                      <button type="button" class="btn btn-danger d-print-none">Detail</button>
                                    </a>
                                  </td>
                                  </tr>
                                  <?php
                                }
                              ?>
                            </tbody>
                            <!-- <tfoot>
                                    <tr>
                                      <p>jumlah anggotaa : <?php echo $no; ?></p>
                                    </tr>
                            </tfoot> -->
                          </table>
                        </div>
                      </div>
                    </div>
                  <?php }  ?>

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