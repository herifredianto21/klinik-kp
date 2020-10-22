<html>
<head>
    <title>Klinik Utama Nur Khadijah | Cetak Kartu Pasien</title>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.png');?>">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>
    <script>
        $(document).ready(function(){
            $("#myModal").modal('show');
        });
    </script>

    <style>
        * {
            font-size: 3mm;
        }
        p {
            margin: 2mm 0mm;
        }
        p.judul {
            font-size: 5mm;
        }
        .kertas {
            width: 15cm;
            padding: 20px;
        }
        td {
            vertical-align: top;
            text-align: start;
        }
        .jarak-vertikal-bawah {
            margin-bottom: 3mm;
        }
        .last-td-align-end td:last-child {
            text-align: end;
        }
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
<body onload="cetak();">
<!-- modal notif -->
<?php 
$par=$this->uri->segment(4);
if (is_null($par)) {
    echo " ";
} else { ?>
<div class="pesan d-print-none" ><center>Data Berhasil Disimpan</center></div>
<?php } ?>
<!-- end modal notif -->

<center>
<br>
<div class="col-sm-6">
    <div class="kertas text-center p-0" style="border:solid 5px; border-radius:10px; padding:10px;">
        <img class="logo float-left" src="<?php echo base_url();?>assets/img/logo-tag.png">
        <img src="<?php echo base_url('assets/img/icd.png');?>" style="width:110px;float:right;">

        <table border="0" class="col-sm-12 jarak-vertikal-bawah" style="margin-left:20px;">
            <?php foreach ($cetakKP->result() as $ckp ) { ?>
            <tr>
                <th style="width:70px;font-size:15px;">No.RM</th>
                <td style="font-size:17px">: <?php echo $ckp->no_registrasi;?></td>  
            </tr>
            <tr>
                <th style="width:70px;font-size:15px;">Nama</th>
                 <td style="font-size:17px">: <?php echo $ckp->nama_pasien;?></td>
            </tr>
            <tr>
                <th style="width:70px;font-size:15px;">Umur</th>
                 <td style="font-size:17px">
                    <?php
                        //waktu sekarang
                        $tglSekarang = date('yy-m-d');
                        $waktuSekarang = explode('-', $tglSekarang);
                        //tgl lahir pasien
                        $tglPasien= $ckp->tgl_lahir;
                        $waktuPasien = explode('-',$tglPasien);
                        //hitung umur
                        $getHari = $waktuSekarang[2] - $waktuPasien[2];
                        $getBulan = $waktuSekarang[1] - $waktuPasien [1];
                        $getTahun = $waktuSekarang[0] - $waktuPasien [0];
                        //hasil umur
                        $umurPasien=abs($getTahun)." Tahun ";
                        echo ": ".$umurPasien; 
                    ?>
                 </td>
            </tr>
            <tr>
                <th style="width:70px;font-size:15px; ">Alamat</th>
                <td style="font-size:17px">: <?php echo $ckp->alamat_ktp_pasien;?></td>
            </tr>
            <?php } ?>

        </table>
        
    </div>
</div>
<br>
<a href="<?php echo base_url('index.php/Pasien');?>"><button class="btn btn-primary d-print-none">Kembali</button></a>
<button onClick="cetak()" class="btn btn-primary d-print-none" >Print</button>
</center>

<script>
    function cetak() {
        return window.print();
    }
    //untuk pesan
      // angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
      $(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 500);});
      // angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".pesan").fadeOut('slow');}, 3000);
</script>

</body>
</html>