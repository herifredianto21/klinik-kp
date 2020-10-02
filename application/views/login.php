<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Klinik Nur Khadijah | Login
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?php echo base_url('assets/css/gf.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/fa/css/all.min.css'); ?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/css/now-ui-kit.css?v=1.3.0'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/css/now-ui-dashboard.css?v=1.3.0'); ?>" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />
  <script type="text/javascript">
    var baseurl = "<?php echo base_url(); ?>";
  </script>
</head>

<body class="login-page">
  <div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" style="background-image:url(assets/img/hospital.jpg)"></div>
    <div class="content">
      <div class="container">
        <div class="col-md-4 ml-auto mr-auto">
          <div class="card card-login card-plain">
            <form id="formLogin" class="form">
              <div class="card-header text-center">
                <div class="logo-container">
                  <img src="assets/img/favicon.png" alt="">
                </div>
              </div>
              <div class="card-body">
                <div class="input-group no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input name="email" type="text" class="form-control" placeholder="Email / Username" required autofocus>
                </div>
                <div class="input-group no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-lock"></i>
                    </span>
                  </div>
                  <input name="password" type="password" class="form-control" placeholder="Password" required>
                </div>
              </div>
              <div class="card-footer text-center">
                <a href="#login" class="btn btn-primary btn-round btn-lg btn-block">Login</a>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?php echo base_url('assets/js/core/jquery.min.js'); ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>" type="text/javascript"></script>
  <!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url('assets/js/now-ui-kit.js?v=1.3.0'); ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/admina.login.js'); ?>" type="text/javascript"></script>
</body>

</html>
