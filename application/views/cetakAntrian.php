<html>
<head>
	<title></title>
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
            width: 7cm;
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
<div class="kertas text-center p-0">
   <center><p class="judul">Klinik Utama Nur Khadijah </p>
    <p>Jl. Cihanjuang No.293, Cihanjuang Rahayu, Kec. Parongpong, Kabupaten Bandung Barat, Jawa Barat 40559</p></center>
    <hr />

    <table border="1" class="col-sm-12 jarak-vertikal-bawah" style="width:265px;">
        <?php foreach ($cetak->result() as $c) { ?>
            
        
        <tr>
            <td ><center>No Antrian</center></td>
            
        </tr>
        <tr>
        	<td><center style="font-size:50px;"><?php echo $c->no_antrian;?></center></td>
        </tr>
        <tr>
            <td><center style="font-size:15px;" ><?php echo $c->nama_pelayanan;?></center></td>
            
        </tr>
        <tr>
            <td><center style="font-size:15px;" ><?php echo $c->tgl_antrian;?></center></td>
            
        </tr>
        <?php } ?>
        
    </table>
    <a href="<?php echo base_url('index.php/dashboard');?>"><button class="btn btn-primary d-print-none">Kembali</button></a>
	<button onClick="cetak()" class="btn btn-primary d-print-none" >Print</button>
</div>
</center>

<script>
    function cetak() {
        return window.print();
    }
</script>

</body>
</html>