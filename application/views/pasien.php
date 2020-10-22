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
    Klinik Nur Khadijah | Pasien
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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
  <script type="text/javascript">
    var baseurl = "<?php echo base_url(); ?>";
  </script>
  <style>
    .pesan{
      display: none;
      border: 1px solid #18ce0f;
      width: 200px;
      margin: auto;
      background-color: #18ce0f;
      color: white;
      text-align: center;
    }
  </style>

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
            <a class="navbar-brand" href="">Pasien</a>
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
                <?php
                  //menampilkan pesan jika ada pesan
                    if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                        echo '<div class="pesan"><center>'.$_SESSION['pesan'].'</center></div>';
                       }
                  //mengatur session pesan menjadi kosong
                    $_SESSION['pesan'] = '';
                ?>
                <div class="row">
                  <div class="col-6">
                    <h4 class="card-title"> Tabel Pasien</h4>
                  </div>
                  <div class="col-6">
                    <div class="pull-right">
                      <a href="<?php echo base_url('Pasien/pendaftaranBaru');?>"class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="dataTables-example" class="table table-striped table-hover">
                    <thead class="text-primary">
                      <th>No.</th>
                      <th>No. Rekam Medis</th>
                      <th>Nama Pasien</th>
                      <th style="min-width: 200px;">Aksi</th>
                    </thead>
                    <tbody>
                      <?php
                          $no=1;
                          foreach ($tPasien->result() as $tp) {
                      ?>
                      <tr>
                        <td><?php echo $no++;?></td>
                        <td><?php echo $tp->no_registrasi;?></td>
                        <td><?php echo $tp->nama_pasien;?></td>
                        <td>
                          <?php  echo anchor('Pasien/getDataKunjungan/'.$tp->id,'<button class="btn btn-success btn-sm" title="Layani"><i class="fa fa-check"></i></button>'); ?>
                          <a href="<?php echo base_url('Pasien/detailPasien/'.$tp->id.'');?>"><button class="btn btn-default btn-sm" title="Lihat Detail"><i class="fa fa-search"></i></button> 
                          <a href="<?php echo base_url('CetakKartu/CetakKartuPasien/'.$tp->id.'');?>"target="_blank"><button class="btn btn-warning btn-sm" title="Cetak Karu Pasien"><i class="fa fa-print"></i></button></a>
                          <a href="<?php echo base_url('Pasien/detailPasien/'.$tp->id.'/Edit');?>"><button class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button>  
                          <?php echo anchor('Pasien/hapusDataPasien/'.$tp->id,
                           '<button onclick="return confirm(`Apakah anda yakin akan menghapus data pasien ?`)" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i>
                            </button>'); 
                          ?>
                          
                           <?php
                            // echo '<a href="'.site_url('Pasien/hapusDataPasien/'.$tp->id).'" data-confirm="Anda yakin akan menghapus pasien atas nama '.$tp->nama_pasien.' ?" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></a>'
                           ?>
                           <!-- <button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button></td> -->
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
  <script src="<?php echo base_url('assets/js/admina.pasien.js'); ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js'); ?>"></script>

   <script>
    //untuk pesan
      // angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
      $(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 500);});
      // angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".pesan").fadeOut('slow');}, 3000);
    
    // untuk table
    $(document).ready(function () {
      $('#dataTables-example').dataTable({"ordering": false});
    });
    // untuk form comfirmation
    // $(document).ready(function() {
    //   $('a[data-confirm]').click(function(ev) {
    //       var href = $(this).attr('href');

    //       if(!$('#dataConfirmModal').length) {
    //        $('body').append('<div id="dataConfirmModal" class="modal fade bs-modal-sm" tableindex="-1" role="dialog" aria-labelledby="dataConfirmLabel" aria-hiden="true"><div class="modal-dialog modal-sm-6"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="dataConfrimLabel">Konfirmasi</h4><button type="button" class="close" data-dismiss="modal" aria-hiden="ture">&times;</button></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-default btn-sx" data-dismiss="modal" aria-hiden=""true"> Tidak </button><a class="btn btn-danger btn-sx" aria-hiden="true" id="dataConfirmOK"> Ya </a></div></div></div></div>');
    //        }

    //       $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));

    //       $('#dataConfirmOK').attr('href',href);

    //       $('#dataConfirmModal').modal({show:true});
    //       return false;
    //      });
        
    //   });
  </script>
  
  
</body>

</html>