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
    Klinik Nur Khadijah | Tindakan Medis
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
            <a class="navbar-brand" href="">Tindakan Medis</a>
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

          <?php
            $langkah = isset($_GET['langkah']) ? $_GET['langkah'] : 'daftar_pasien';
            $id_antrian = isset($_GET['id_antrian']) ? $_GET['id_antrian'] : null;

            $tabel_pasien_visibility = $langkah == 'daftar_pasien' ? 'block' : 'none';
            $langkah_diagnosa_visibility = $langkah == 'diagnosa' ? 'block' : 'none';
            $langkah_resep_visibility = $langkah == "resep" ? 'block' : 'none';
            $langkah_tindakan_visibility = $langkah == 'tindakan' ? 'block' : 'none';
            $langkah_tindak_lanjut_visibility = $langkah == 'tindak_lanjut' ? 'block' : 'none';
            
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $nama_dokter = isset($_GET['nama_dokter']) ? $_GET['nama_dokter'] : null;
            
            $diagnosa = isset($_GET['diagnosa']) ? $_GET['diagnosa'] : null;
            $tindak_lanjut = isset($_GET['tindak_lanjut']) ? $_GET['tindak_lanjut'] : null;
            $keterangan_tindak_lanjut = isset($_GET['keterangan_tindak_lanjut']) ? $_GET['keterangan_tindak_lanjut'] : null;
          ?>

          <div id="table" class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                	<div class="col-12">
                    <div class="d-flex justify-content-between align-items-start">
                      <h4 class="card-title"> Tindakan Medis</h4>
                      <?php
                        if ($langkah != null && $langkah != 'daftar_pasien') { ?>
                          <a id="aSimpanTindakanMedis" href="#"><button class="btn btn-warning btn-sm"><i class="fas fa-check"></i> Simpan</button></a>
                          <?php
                        }
                      ?>
                    </div>

                    <?php
                      if ($langkah != null && $langkah != 'daftar_pasien') { ?>
                        <div class="row mt-5 mb-3">
                          <div class="col-sm-6 my-0 h5">
                            Nama Pasien :
                          </div>
                          <div class="col-sm-6 my-0 h5">
                            <?= $nama_pasien ?>
                          </div>
                        </div>

                        <div class="row mb-5">
                          <div class="col-sm-6 my-0 h5">
                            Nama Dokter :
                          </div>
                          <div class="col-sm-6 my-0 h5">
                            <?= $nama_dokter ?>
                          </div>
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                	
                </div>
              </div>

              <div class="card-body">
                <!-- Tabel Daftar Pasien -->
                <div style="display: <?= $tabel_pasien_visibility ?>;">
                  <p class="h4">Daftar Pasien</p>

                  <table id="daftarPasien" class="table table-striped table-hover">
                    <thead class="text-primary">
                      <tr>
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Pelayanan</th>
                        <th>Dokter</th>
                        <!-- <th>Status</th> -->
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php
                        foreach($tampil_pasien as $tp) { ?>
                          <tr>
                            <td><?= $tp->no_antrian ?></td>
                            <td><?= $tp->nama_pasien ?></td>
                            <td><?= $tp->nama_pelayanan ?></td>
                            <td><?= $tp->nama_dokter ?></td>
                            <!-- <td><?= $tp->status_antrian ?></td> -->
                            <td><?= $tp->tgl_antrian ?></td>
                            <td>
                              <a href="<?= base_url('tindakan-medis?langkah=diagnosa&id_antrian=' . $tp->id . '&id_dokter=' . $tp->id_dokter . '&nama_pasien=' . $tp->nama_pasien . '&nama_dokter=' . $tp->nama_dokter) ?>">
                                <button class="btn btn-primary btn-sm"><i class="fas fa-notes-medical"></i> Tindak</button>
                              </a>
                            </td>
                          </tr>
                          <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                

                <?php
                  $show = "in active show";

                  if ($langkah != null && $langkah != 'daftar_pasien') { ?>
                      
                    <!-- Navigasi -->
                    <ul class="nav nav-tabs">
                      <?php
                        $btn_active = "btn-primary";
                        $btn_inactive = "btn-light";
                      ?>  

                      <li>
                        <a data-toggle="tab" href="#langkahDiagnosa">
                          <button id="btnDiagnosa" class="btn btn-sm <?= $langkah == 'diagnosa' ? $btn_active : $btn_inactive ?>">
                            Diagnosa
                          </button>
                        </a>
                      </li>
                      <li>
                        <a data-toggle="tab" href="#langkahTindakan">
                          <button id="btnTindakan" class="btn btn-sm <?= $langkah == 'tindakan' ? $btn_active : $btn_inactive ?>">
                            Tindakan
                          </button>
                        </a>
                      </li>
                      <li>
                        <a data-toggle="tab" href="#langkahResep">
                          <button id="btnResep" class="btn btn-sm <?= $langkah == 'resep' ? $btn_active : $btn_inactive ?>">
                            Resep
                          </button>
                        </a>
                      </li>
                      <li>
                        <a data-toggle="tab" href="#langkahTindakLanjut">
                          <button id="btnTindakLanjut" class="btn btn-sm <?= $langkah == 'tindak_lanjut' ? $btn_active : $btn_inactive ?>">
                            Tindak Lanjut
                          </button>
                        </a>
                      </li>
                    </ul>

                    <!-- Konten -->
                    <div class="tab-content">

                      <!-- Langkah Diagnosa -->
                      <div id="langkahDiagnosa" class="tab-pane fade <?= $langkah == 'diagnosa' ? $show : null ?>">
                        
                        <!-- Tampil Data -->
                        <div id="table">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Diagnosa</p>
                          </div>

                          <form action="#" class="col-sm-6">
                            <div class="row">
                              <!-- <label for="textareaDiagnosa">Isi Diagnosa</label> -->
                              <textarea name="" id="textareaDiagnosa" rows="3" class="form-control" placeholder="Isi diagnosa" style="resize: vertical;"><?= $diagnosa ?></textarea>
                            </div>
                          </form>
                        </div>
                          
                      </div>

                      
                      <!-- Langkah Tindakan -->
                      <div id="langkahTindakan" class="tab-pane fade <?= $langkah == 'tindakan' ? $show : null ?>">
                        
                        <!-- Tampil Data -->
                        <div id="table">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Tindakan</p>
                            <button class="btn btn-primary btn-sm" id="btnShowForm"><i class="fas fa-plus"></i> Tambah Tindakan</button>
                          </div>

                          <table class="table table-striped table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>No</th>
                                <th>Tindakan</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            
                            <tbody>
                              <?php
                                $totalBiayaTindakan = 0;
                                $no = 1;
                                foreach($_getAddedTindakan as $gat) { 
                                  $totalBiayaTindakan += $gat->biaya_medis + $gat->jasa_medis; ?>

                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $gat->nama_biaya_medis ?></td>
                                    <td><?= $gat->keterangan_tindakan_pasien ?></td>
                                    <td>Rp. <?= number_format(intval($gat->biaya_medis), 2, ',', '.') ?></td>
                                    <td>
                                      <button type="button" onclick="selectDataToEditTindakan('<?= $gat->id_tindakan_pasien_detail ?>', '<?= $gat->nama_biaya_medis ?>', '<?= $this->db->escape_str($gat->keterangan_tindakan_pasien) ?>')" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                      </button>
                                      <button type="button" onclick="doInBackground('<?= base_url('tindakan-medis/deleteAddedTindakan?id_tindakan_pasien_detail=' . $gat->id_tindakan_pasien_detail) ?>')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                      </button>
                                    </td>
                                  </tr>
                                  <?php
                                }
                              ?>
                            </tbody>

                            <tfoot>
                              <tr class="font-weight-bold">
                                <td colspan="3">Total</td>
                                <td>Rp. <?= number_format(intval($totalBiayaTindakan), 2, ',', '.') ?></td>
                                <td></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                        

                        <!-- Tambah Data -->
                        <div id="form" style="display: none;">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Tambah Tindakan</p>
                          </div>

                          <form id="formInsertTindakan" action="<?= base_url('tindakan-medis/addTindakan?langkah=tindakan&id_antrian=' . $_GET['id_antrian']) ?>" method="post">
                            <table class="table table-striped table-hover">
                              <thead class="text-primary">
                                <tr>
                                  <th></th>
                                  <th>Tindakan</th>
                                  <th>Keterangan</th>
                                  <th>Harga</th>
                                </tr>
                              </thead>
                              
                              <tbody>
                                <?php
                                  $index = 0;
                                  foreach($_getTindakan as $t) { ?>
                                    <tr>
                                      <td>
                                        <input type="hidden" name="pilih[<?= $index ?>]" value="unchecked" class="form-control">
                                        <input type="checkbox" name="pilih[<?= $index ?>]" value="checked" class="form-control">
                                      </td>
                                      <td>
                                        <?= $t->nama_biaya_medis ?>
                                        <input type="hidden" name="id_biaya_medis[]" value="<?= $t->id ?>">
                                      </td>
                                      <td><textarea name="keterangan_tindakan_pasien[]" class="form-control" rows="1" placeholder="Opsional"></textarea></td>
                                      <td>Rp. <?= number_format(intval($t->biaya_medis), 2, ',', '.') ?></td>
                                    </tr>
                                    <?php
                                    $index++;
                                  }
                                ?>
                              </tbody>
                            </table>

                            <div class="row">
                              <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save</button>
                              </div>
                              <div class="col-md-2">
                                <button type="button" id="btnCancel" class="btn btn-danger btn-block"><i class="fa fa-times"></i> Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        

                        <!-- Ubah Data -->
                        <div id="form">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Ubah Tindakan</p>
                          </div>

                          <form id="formUpdateTindakan" action="<?= base_url('tindakan-medis/addTindakan?langkah=tindakan&id_antrian=' . $_GET['id_antrian']) ?>" method="post">
                            
                          <div class="form-group">
                              <label for="id_tindakan_pasien_detail">id_tindakan_pasien_detail</label>
                              <input type="text" name="id_tindakan_pasien_detail" id="id_tindakan_pasien_detail" class="form-control" readonly required>
                            </div>
                            <div class="form-group">
                              <label for="nama_biaya_medis">Tindakan</label>
                              <input type="text" name="nama_biaya_medis" id="nama_biaya_medis" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                              <label for="keterangan_tindakan_pasien">Keterangan</label>
                              <textarea name="keterangan_tindakan_pasien" id="keterangan_tindakan_pasien" class="form-control"></textarea>
                            </div>

                            <div class="row">
                              <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save</button>
                              </div>
                              <div class="col-md-2">
                                <button type="button" id="btnCancel" class="btn btn-danger btn-block"><i class="fa fa-times"></i> Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>

                      </div>


                      <!-- Langkah Resep -->
                      <div id="langkahResep" class="tab-pane fade <?= $langkah == 'resep' ? $show : null ?>">
                        
                        <!-- Tampil Data -->
                        <div id="table">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Resep</p>
                            <button class="btn btn-primary btn-sm" id="btnShowForm"><i class="fas fa-plus"></i> Tambah Resep</button>
                          </div>

                          <table class="table table-striped table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>No</th>
                                <th>Kode Obat</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Kuantitas</th>
                                <th>Satuan</th>
                                <th>Aturan Pakai</th>
                                <th>Harga Jual Obat</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            
                            <tbody>
                              <?php
                                $totalBiayaResep = 0;
                                $no = 1;
                                foreach($_getAddedResep as $gar) {
                                  $totalBiayaResep += $gar->harga_jual_obat;
                                  ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $gar->kode_obat ?></td>
                                    <td><?= $gar->nama_obat ?></td>
                                    <td><?= $gar->kategori ?></td>
                                    <td><?= $gar->qty ?></td>
                                    <td><?= $gar->nama_satuan ?></td>
                                    <td><?= $gar->aturan_pakai ?></td>
                                    <td>Rp. <?= number_format(intval($gar->harga_jual_obat), 2, ',', '.') ?></td>
                                    <td>
                                      <button type="button" onclick="selectDataToEditResep('<?= $gar->kode_obat ?>')" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                      </button>
                                      <button type="button" onclick="doInBackground('<?= base_url('tindakan-medis/deleteAddedResep?id_resep_detail=' . $gar->id_resep_detail) ?>')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                      </button>
                                    </td>
                                  </tr>
                                  <?php
                                }
                              ?>
                            </tbody>

                            <tfoot>
                              <tr class="font-weight-bold">
                                <td colspan="7">Total</td>
                                <td>Rp. <?= number_format(intval($totalBiayaResep), 2, ',', '.') ?></td>
                                <td></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                        

                        <!-- Tambah Data -->
                        <div id="form" style="display: none;">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Tambah Resep</p>
                          </div>

                          <form id="formInsertResep" action="<?= base_url() ?>tindakan-medis/addResep?langkah=resep&id_antrian=<?= $_GET['id_antrian'] ?>" method="post">
                            <table class="table table-striped table-hover">
                              <thead class="text-primary">
                                <tr>
                                  <th></th>
                                  <th>Kode Obat</th>
                                  <th>Nama</th>
                                  <th>Kategori</th>
                                  <th>Kuantitas</th>
                                  <th>Satuan</th>
                                  <th>Aturan Pakai</th>
                                </tr>
                              </thead>
                              
                              <tbody>
                                <?php
                                  $index = 0;
                                  foreach($_getObat as $go) { ?>
                                    <tr>
                                      <td>
                                        <input type="hidden" name="pilih[<?= $index ?>]" value="unchecked" class="form-control">
                                        <input type="checkbox" name="pilih[<?= $index ?>]" value="checked" class="form-control">
                                      </td>
                                      <td>
                                        <?= $go->kode_obat ?>
                                        <input type="hidden" name="id_obat[]" value="<?= $go->id ?>">
                                      </td>
                                      <td>
                                        <?= $go->nama_obat ?>
                                        <input type="hidden" name="nama_obat[]" value="<?= $go->nama_obat ?>">
                                      </td>
                                      <td>BELUM</td>
                                      <!-- <td><?= $go->harga_jual_obat ?></td> -->
                                      <td><input type="text" name="qty[]" class="form-control"></td>
                                      <td>
                                        <?= $go->nama_satuan ?>
                                        <input type="hidden" name="nama_satuan[]" value="<?= $go->nama_satuan ?>">
                                      </td>
                                      <td><input type="text" name="aturan_pakai[]" class="form-control"></td>
                                    </tr>
                                    <?php
                                    $index++;
                                  }
                                ?>
                              </tbody>
                            </table>

                            <div class="row">
                              <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save</button>
                              </div>
                              <div class="col-md-2">
                                <button type="button" id="btnCancel" class="btn btn-danger btn-block"><i class="fa fa-times"></i> Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>

                      </div>


                      <!-- Langkah Tindak Lanjut -->
                      <div id="langkahTindakLanjut" class="tab-pane fade <?= $langkah == 'tindak_lanjut' ? $show : null ?>">
                        
                        <!-- Tampil Data -->
                        <div id="table">
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="h4">Tindak Lanjut</p>
                          </div>

                          <form action="#" class="col-sm-6">
                            <div class="row mb-4">
                              <label for="selectTindakLanjut">Pilih Tindak Lanjut</label>
                              <select name="tindak_lanjut" id="selectTindakLanjut" class="form-control">
                                <option value="" <?= (empty($tindak_lanjut) ? 'selected' : null) ?>>- Pilih Tindak Lanjut -</option>
                                <option value="Kontrol kembali" <?= ($tindak_lanjut == 'Kontrol kembali' ? 'selected' : null) ?>>Kontrol kembali</option>
                                <option value="Sembuh" <?= ($tindak_lanjut == 'Sembuh' ? 'selected' : null) ?>>Sembuh</option>
                                <option value="Dalam penyembuhan" <?= ($tindak_lanjut == 'Dalam penyembuhan' ? 'selected' : null) ?>>Dalam penyembuhan</option>
                                <option value="Rujuk" <?= ($tindak_lanjut == 'Rujuk' ? 'selected' : null) ?>>Rujuk</option>
                              </select>
                            </div>
                            
                            <div class="row">
                              <label for="textareaKeteranganTindakLanjut">Keterangan</label>
                              <textarea name="keterangan_tindak_lanjut" id="textareaKeteranganTindakLanjut" rows="3" class="form-control" style="resize: vertical;"><?= $keterangan_tindak_lanjut ?></textarea>
                            </div>
                          </form>
                        </div>
                        
                      </div>

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
  <!-- DataTables - fnGetHiddenNodes (plug-in) -->
  <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.21/api/fnGetHiddenNodes.js"></script>
  <script src="<?php echo base_url('assets/js/admina.tindakan.medis.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>
</body>

</html>