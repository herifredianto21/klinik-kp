<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekam Medis</title>

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

	<style type="text/css">
	body {
	  counter-reset: section;           /* Set the section counter to 0 */
	}
	@media screen{
		div.tutup{display: none;}
	}
	@media print {
	    thead {display: table-header-group; border-top: 2px #000 solid; }
	    div.tutup{display:block; background-color: #fff; color: #fff; width: 98.5%; height: 34px; margin-top: -15px; position: absolute; border-bottom: #000 2px solid; }
	    table.gridtable{margin-top: -15px;}
	}
	@page {
	  margin: 4%;
	}
	@page {
	    counter-increment: page;
	    counter-reset: page 1;
	    @top-right {
	        content: "Page " counter(page) " of " counter(pages);
	    }
	}
	body{ font-family: "Calibri Body", Arial, Helvetica, sans-serif, margin: 0;}
	h3{font-size: 1em; font-weight: bold;}
	p{font-size: .95em; font-weight: bold;}
	table {
	  font-family: "Calibri Body", Arial, Helvetica, sans-serif;;
	  font-size:0.8em;
	  color:#333333;
	  border-width: 1px;
	  border-color: #000;
	  border-collapse: collapse;
	}

	</style>
</head>
<body>

<?php

$tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
$tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

if($id==9){ ?>


    <table align="center" border="0" width="100%">
      <tr align="center">
        <td colspan="2">
          <table align="center" width="100%" border="0" cellpadding="5">
            <tr>
              <td width="25%" style="border-right: 1px solid #000">
                <img src="<?php echo base_url('assets/img/Logo.jpg'); ?>" alt="" style="width: 100%; height: 20%;">
              </td>
              <td width="75%" align="left">
                <p style="font-size: 0.9em;">Jalan Cihanjuang No. 293 <br>
                Tutugan, Cihanjuang Rahayu,<br>
                Parongpong, Kab. Bandung Barat,<br>
                Bandung 40559<br>
                Telp: +62 22 61139884 | Faks: <br>
                +62 22 6640597</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr align="center"><td colspan="2"><b>LAPORAN PROGRAM REKAM MEDIS - PEMERIKSAAN UMUM</b></td></tr>
      <tr>
        <td colspan="2" style="border-top: 3px solid #000;"></td>
      </tr>

      <tr>
        <td colspan="4">
          <table align="center" width="100%" border="1" cellpadding="3" style="font-size:smaller;">
          <tr><p>Tanggal : <?php echo $tgl1; ?>, Sampai : <?php echo $tgl2; ?></p></tr>
            <thead align="center">
              <tr>
                <th>NO</th>
                <th>CREATE_AT</th>
                <th>NAMA PASIEN</th>
                <th>Jenis Kelamin</th>
                <th>Nama Penyakit</th>
                <th>Rentang Umur</th>
                <th>Macam Tindakan Imunisasi</th>
                <th>Catatan</th>
                <th>Tindakan Medis</th>
                <th>Nama Obat</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no=1;
                foreach($lapRekamMedisUmum as $i) { ?>
                <tr>
                  <td align="center"><?php echo $no++;?></td>
                  <td><?php echo $i->created_at ?></td>
                  <td><?php echo $i->nama_pasien ?></td>
                  <td><?php echo $i->jenis_kelamin ?></td>
                  <td><?php echo $i->nama_penyakit ?></td>
                  <td><?php echo $i->rentang_umur ?></td>
                  <td><?php if($i->id_macam_tindakan_imunisasi == "1"){
                    echo "Khitan";
                  } else{
                    echo "Tindik";
                  } ?></td>
                  <td><?php echo $i->catatan ?></td>
                  <td width="200px;">
                    <?php
                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                      foreach($this->controller->RmTindakanMedisUmum($i->id_antrian) as $i) {
                        echo $i->nama_biaya_medis . ', ';
                      }
                    ?>
                  </td>
                  <td width="200px;">
                    <?php
                    $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                    $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                    $id = isset($_GET['id']) ? $_GET['id'] : null;

                    foreach($this->controller->RmObatUmum($i->id_antrian) as $i) {
                      echo $i->nama_obat . ', ';
                    }
                    ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <th collspan="4">Jumlah Pasien : <?php echo $no-1; ?></th>
            </tfoot>
          </table>
        </td>
      </tr>
    </table>

<?php } else if($id==34){ ?>

  <img src="<?php echo base_url(); ?>assets/img/klinik2.jpg" width="280px;">
  <table align="center" border="0" width="100%">
      <tr align="center"><td colspan="4"><b>LAPORAN PROGRAM REKAM MEDIS - ISPA</b></td></tr>
      <tr align="center"><td colspan="4"><b>KLINIK UTAMA NUR KHADIJAH</b></td></tr>
      <tr>
        <td colspan="4">
          <table align="center" width="100%" border="1" cellpadding="3">
          <tr><p>Tanggal : <?php echo $tgl1; ?>, Sampai : <?php echo $tgl2; ?></p></tr>
            <thead align="center">
              <tr>
                <th>NO</th>
                <th>CREATE_AT</th>
                <th>NAMA ANAK</th>
                <th>Jenis Kelamin</th>
                <th>Umur Tahun</th>
                <th>Umur Bulan</th>
                <th>BB</th>
                <th>TB-PB</th>
                <th>Catatan</th>
                <th>Tindakan Medis</th>
                <th>Nama Obat</th>
              </tr>
            </thead>
            <tbody>
                <?php

                $no=1;
                foreach($lapRekamMedisIspaa as $a) { ?>
                <tr>
                  <td align="center"><?php echo $no++;?></td>
                  <td><?php echo $a->created_at ?></td>
                  <td><?php echo $a->nama_anak ?></td>
                  <td><?php echo $a->jenis_kelamin ?></td>
                  <td><?php echo $a->umur_tahun ?></td>
                  <td><?php echo $a->umur_bulan ?></td>
                  <td><?php echo $a->bb ?></td>
                  <td><?php echo $a->tb_pb ?></td>
                  <td><?php echo $a->catatan ?></td>
                  <td>
                    <?php
                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                      foreach($this->controller->RmTindakanMedisIspa($a->id_antrian) as $a) {
                        echo $a->nama_biaya_medis . ', ';
                      }
                    ?>
                </td>
                <td>
                  <?php
                    $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                    $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                    $id = isset($_GET['id']) ? $_GET['id'] : null;

                    foreach($this->controller->RmObatIspa($a->id_antrian) as $a) {
                      echo $a->nama_obat . ', ';
                    }
                  ?>
                </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <th collspan="4">Jumlah Pasien : <?php echo $no-1; ?></th>
            </tfoot>
          </table>
        </td>
      </tr>
    </table>

<?php } else if($id==3){ ?>
  <img src="<?php echo base_url(); ?>assets/img/klinik2.jpg" width="280px;">
    <table align="center" border="0" width="100%">
      <tr align="center"><td colspan="4"><b>LAPORAN PROGRAM REKAM MEDIS - PERSALINAN</b></td></tr>
      <tr align="center"><td colspan="4"><b>KLINIK UTAMA NUR KHADIJAH</b></td></tr>
      <tr>
        <td colspan="4">
          <table align="center" width="100%" border="1" cellpadding="3">
            <tr><p>Tanggal : <?php echo $tgl1; ?>, Sampai : <?php echo $tgl2; ?></p></tr>
            <thead align="center">
              <tr>
                <th>NO</th>
                <th>CREATE_AT</th>
                <th>NAMA PASIEN</th>
                <th>JENIS KELAMIN</th>
                <th>UMUR</th>
                <th>BB</th>
                <th>PB</th>
                <th>TANGGAL LAHIR</th>
                <th>JAM LAHIR</th>
                <th>RESIKO</th>
                <th>Catatan</th>
                <th>Nama Biaya Medis</th>
                <th>Nama Obat</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no=1;
                foreach($lapRekamMedis_model as $p) { ?>
                <tr>
                  <td align="center"><?php echo $no++;?></td>
                  <td><?php echo $p->created_at ?></td>
                  <td><?php echo $p->nama_pasien ?></td>
                  <td><?php echo $p->jenis_kelamin ?></td>
                  <td><?php echo $p->umur ?></td>
                  <td><?php echo $p->bb ?></td>
                  <td><?php echo $p->pb ?></td>
                  <td><?php echo $p->tgl_lahir ?></td>
                  <td><?php echo $p->jam_lahir ?></td>
                  <td><?php echo $p->resiko ?></td>
                  <td><?php echo $p->catatan ?></td>
                  <td>
                    <?php
                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                      foreach($this->controller->RmTindakanMedisPersalinan($p->id_antrian) as $p) {
                        echo $p->nama_biaya_medis . ', ';
                      }
                    ?>
                </td>
                <td>
                  <?php
                    $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                    $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                    $id = isset($_GET['id']) ? $_GET['id'] : null;

                    foreach($this->controller->RmObatPersalinan($p->id_antrian) as $p) {
                      echo $p->nama_obat . ', ';
                    }
                  ?>
                </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
          <tfoot>
              <th collspan="4">Jumlah Pasien : <?php echo $no-1; ?></th>
            </tfoot>
        </td>
      </tr>
    </table>

<?php } else if($id==37){ ?>
  <img src="<?php echo base_url(); ?>assets/img/klinik2.jpg" width="280px;">
    <table align="center" border="0" width="100%">
      <tr align="center"><td colspan="4"><b>LAPORAN PROGRAM REKAM MEDIS - KB</b></td></tr>
      <tr align="center"><td colspan="4"><b>KLINIK UTAMA NUR KHADIJAH</b></td></tr>
      <tr>
        <td colspan="4">
          <table align="center" width="100%" border="1" cellpadding="3">
          <tr><p>Tanggal : <?php echo $tgl1; ?>, Sampai : <?php echo $tgl2; ?></p></tr>
            <thead align="center">
              <tr>
                <th>NO</th>
                <th>CREATE_AT</th>
                <!-- <th>ID ANTRIAN</th> -->
                <th>NAMA PASIEN</th>
                <th>UMUR</th>
                <th>NAMA SUAMI</th>
                <th>ALAMAT</th>
                <th>JUMLAH ANAK LAKI</th>
                <th>JUMLAH ANAK PEREMPUAN</th>
                <th>JUMLAH ANAK</th>
                <th>USIA ANAK TERKECIL</th>
                <th>ID SATUAN USIA</th>
                <th>PASANG BARU</th>
                <th>PASANG CABUT</th>
                <th>ID KONTRASEPSI</th>
                <th>AKLI</th>
                <th>T-4</th>
                <th>GANTI CARA</th>
                <th>CATATAN</th>
                <th>Tindakan Medis</th>
                <th>NAMA OBAT</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                <?php

                $no=1;
                foreach($lapRekamMedisKb as $i) { ?>
                  <td align="center"><?php echo $no++;?></td>
                  <td><?= $no++ ?></td>
                  <td><?= $i->created_at ?></td>
                  <!-- <td><?= $i->id_antrian ?></td> -->
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
              <?php } ?>
            </tbody>
          </table>
          <tfoot>
              <th>Jumlah Pasien : <?php echo $no-1; ?></th>
            </tfoot>
          </table>
        </td>
      </tr>
    </table>

<?php } else if($id==1){ ?>
  <img src="<?php echo base_url(); ?>assets/img/klinik2.jpg" width="280px;">
    <table align="center" border="0" width="100%">
      <tr align="center"><td colspan="4"><b>LAPORAN PROGRAM REKAM MEDIS - KEHAMILAN</b></td></tr>
      <tr align="center"><td colspan="4"><b>KLINIK UTAMA NUR KHADIJAH</b></td></tr>
      <tr>
        <td colspan="4">
          <table align="center" width="100%" border="1" cellpadding="3">
          <tr><p>Tanggal : <?php echo $tgl1; ?>, Sampai : <?php echo $tgl2; ?></p></tr>
            <thead align="center">
              <tr>
              <th>No</th>
              <th>Waktu</th>
              <!-- <th>Id Antrian</th> -->
              <th>Nama Pasien</th>
              <th>Tanggal Lahir</th>
              <th>HPHT</th>
              <th>TP</th>
              <th>BB</th>
              <th>BB</th>
              <th>TB</th>
              <th>Usia Kehamilan</th>
              <th>GPA</th>
              <th>K1</th>
              <th>K4</th>
              <th>TT</th>
              <th>LILA</th>
              <th>Resiko</th>
              <th>Keterangan</th>
              <th>catatan</th>
              <th>Tindakan Medis</th>
              <th>Nama Obat</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $no=1;
                foreach($lapRekamMedisKehamilan as $i) { ?>
                <tr>
                  <td align="center"  width="30px;"><?php echo $no++;?></td>
                  <td><?= $i->created_at ?></td>
                  <!-- <td><?= $i->id_antrian ?></td> -->
                  <td width="120px;"><?= $i->nama_pasien ?></td>
                  <td><?= $i->tgl_lahir ?></td>
                  <td><?= $i->hpht ?></td>
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
                  <td><?= $i->catatan ?></td>
                  <td>
                    <?php
                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                      foreach($this->controller->TindakanMedisKehamilan($i->id_antrian) as $i) {
                        echo $i->nama_biaya_medis . ', ';
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
                </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <tfoot>
              <th>Jumlah Pasien : <?php echo $no-1; ?></th>
            </tfoot>
        </td>
      </tr>
    </table>

<?php } else if($id==8){ ?>

  <img src="<?php echo base_url(); ?>assets/img/klinik2.jpg" width="280px;">
  <table align="center" border="0" width="100%">
    <tr align="center"><td colspan="4"><b>LAPORAN PROGRAM REKAM MEDIS - IMUNISASI</b></td></tr>
    <tr align="center"><td colspan="4"><b>KLINIK UTAMA NUR KHADIJAH</b></td></tr>
    <tr>
      <td colspan="4">
        <table align="center" width="100%" border="1" cellpadding="3">
        <tr><p>Tanggal : <?php echo $tgl1; ?>, Sampai : <?php echo $tgl2; ?></p></tr>
          <thead align="center">
            <tr>
            <th>No</th>
            <th>Waktu</th>
            <!-- <th>Id Antrian</th> -->
            <th>Nama Anak</th>
            <th>Tanggal Lahir</th>
            <th>BB Lahir</th>
            <th>BB</th>
            <th>PB</th>
            <th>Id Macam Imunisasi</th>
            <th>HB0</th>
            <th>BCG</th>
            <th>PENTABIO1</th>
            <th>PENTABIO2</th>
            <th>PENTABIO3</th>
            <th>TT</th>
            <th>PENTABIO ULANG</th>
            <th>CAMPAK ULANG</th>
            <th>catatan</th>
            <th>Tindakan Medis</th>
            <th>Nama Obat</th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no=1;
              foreach($lapRekamMedisImunisasi as $i) { ?>
              <tr>
                <td align="center"><?php echo $no++;?></td>
                <td><?= $i->created_at ?></td>
                <!-- <td><?= $i->id_antrian ?></td> -->
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
                <td><?= $i->catatan ?></td>
                <td>
                    <?php
                      $tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : null;
                      $tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : null;
                      $id = isset($_GET['id']) ? $_GET['id'] : null;

                      foreach($this->controller->TindakanMedisImun($i->id_antrian) as $i) {
                        echo $i->nama_biaya_medis . ', ';
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
            <?php } ?>
          </tbody>
        </table>
        <tfoot>
          <th collspan="4">Jumlah Pasien : <?php echo $no-1; ?></th>
        </tfoot>
      </td>
    </tr>
  </table>

<?php } ?>



  <!--   Core JS Files   -->
  <!-- <script src="<?php echo base_url('assets/js/core/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js'); ?>"></script> -->
  <!-- Chart JS -->
  <!-- <script src="<?php echo base_url('assets/js/plugins/chartjs.min.js'); ?>"></script> -->
  <!--  Notifications Plugin    -->
  <!-- <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js'); ?>"></script> -->
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <!-- <script src="<?php echo base_url('assets/js/now-ui-dashboard.min.js?v=1.3.0'); ?>" type="text/javascript"></script> -->
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->

</body>
</html>