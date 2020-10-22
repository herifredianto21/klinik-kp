<?php date_default_timezone_set("Asia/Jakarta"); ?>
<?php

function tglIndo($date)
{
	$bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

	$d = substr($date, 8, 2);
	$m = intval(substr($date, 5, 2)) - 1;
	$y = substr($date, 0, 4);

	return $d . ' ' . $bulan[$m] . ' ' . $y;
}

function blnChanger($bln)
{
	$bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

	return $bulan[intval($bln) - 1];
}

function customTgl($date)
{
	$d = intval(substr($date, 8, 2));
	$m = intval(substr($date, 5, 2));
	$y = substr($date, 2, 2);

	return $d . '/' . $m . ' ' . $y;
}

function terbilang($bilangan)
	{
	    $angka = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
	        '0', '0', '0');
	    $kata = array('nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh',
	        'delapan', 'sembilan');
	    $tingkat = array('', 'ribu', 'juta', 'milyar', 'triliun');

	    $panjang_bilangan = strlen($bilangan);

	    /* pengujian panjang bilangan */
	    if ($panjang_bilangan > 15)
	    {
	        $kalimat = "Diluar Batas";
	        return $kalimat;
	    }

	    /* mengambil angka-angka yang ada dalam bilangan,
	    dimasukkan ke dalam array */
	    for ($i = 1; $i <= $panjang_bilangan; $i++)
	    {
	        $angka[$i] = substr($bilangan, -($i), 1);
	    }

	    $i = 1;
	    $j = 0;
	    $kalimat = "";


	    /* mulai proses iterasi terhadap array angka */
	    while ($i <= $panjang_bilangan)
	    {
	        $subkalimat = "";
	        $kata1 = "";
	        $kata2 = "";
	        $kata3 = "";

	        /* untuk ratusan */
	        if ($angka[$i + 2] != "0")
	        {
	            if ($angka[$i + 2] == "1")
	            {
	                $kata1 = "seratus";
	            }
	            else
	            {
	                $kata1 = $kata[$angka[$i + 2]] . " ratus";
	            }
	        }

	        /* untuk puluhan atau belasan */
	        if ($angka[$i + 1] != "0")
	        {
	            if ($angka[$i + 1] == "1")
	            {
	                if ($angka[$i] == "0")
	                {
	                    $kata2 = "sepuluh";
	                }
	                elseif ($angka[$i] == "1")
	                {
	                    $kata2 = "sebelas";
	                }
	                else
	                {
	                    $kata2 = $kata[$angka[$i]] . " belas";
	                }
	            }
	            else
	            {
	                $kata2 = $kata[$angka[$i + 1]] . " puluh";
	            }
	        }

	        /* untuk satuan */
	        if ($angka[$i] != "0")
	        {
	            if ($angka[$i + 1] != "1")
	            {
	                $kata3 = $kata[$angka[$i]];
	            }
	        }

	        /* pengujian angka apakah tidak nol semua,
	        lalu ditambahkan tingkat */
	        if (($angka[$i] != "0") or ($angka[$i + 1] != "0") or ($angka[$i + 2] != "0"))
	        {
	            $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
	        }

	        /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
	        ke variabel kalimat */
	        $kalimat = $subkalimat . $kalimat;
	        $i = $i + 3;
	        $j = $j + 1;

	    }

	    /* mengganti satu ribu jadi seribu jika diperlukan */
	    if (($angka[5] == "0") and ($angka[6] == "0"))
	    {
	        $kalimat = str_replace("satu ribu", "seribu", $kalimat);
	    }
	    return trim($kalimat);
	}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Biaya</title>
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
	body{font-family: "Calibri Body", Arial, Helvetica, sans-serif; margin: 0;}
	h3{font-size: 1em; font-weight: bold;}
	p{font-size: .95em; font-weight: bold;}
	table {
	  font-family: "Calibri Body", Arial, Helvetica, sans-serif;
	  font-size:0.8em;
	  color:#333333;
	  border-width: 1px;
	  border-color: #000;
	  border-collapse: collapse;  
	}
	
	</style>
</head>
<body onload="print();">

<table align="center" border="0" width="100%">
	<tr align="center">
		<td colspan="2">
			<table align="center" width="100%" border="0" cellpadding="5">
				<tr>
					<td width="25%" style="border-right: 1px solid #000">
						<img src="<?php echo base_url('assets/img/Logo.jpg'); ?>" alt="" style="width: 100%; height: 10%;">
					</td>
					<td width="75%" align="left">
						<p style="font-size: 0.8em;">Jalan Cihanjuang No. 293 <br>
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
	<tr align="center" height="50">
		<td colspan="2"><b><small>BUKTI PEMBAYARAN</small></b></td>
	</tr>
	<tr>
		<td colspan="2" style="border-top: 3px solid #000;"></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>: <?php echo $data['pasien']['nama']; ?></td>
	</tr>
	<tr>
		<td>Usia</td>
		<td>: <?php echo $data['pasien']['usia']; ?> Tahun</td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>: <?php echo $data['pasien']['alamat']; ?></td>
	</tr>
	<tr height="25">
		<td colspan="2"></td>
	</tr>
</table>
<table align="center" border="0" width="100%" <?php if($detail || $pemeriksaan){ echo 'style="display:none;"'; } ?> style="font-size:smaller;">
	<tr height="25">
		<td width="50%">1. Material Kesehatan dan Obat-obatan</td>
		<td align="right">
			<?php echo 'Rp. ' . number_format($data['biaya']['obat'],0,',','.'); ?>
		</td>
	</tr>
  <?php
    $medis = $data['medis'];
    for ($i=0; $i < count($medis); $i++) { ?>
      <tr height="25">
        <td width="50%"><?php echo $i+2 . '. ' . $medis[$i]['nama_biaya_medis']; ?></td>
        <td align="right">
          <?php echo 'Rp. ' . number_format($medis[$i]['biaya_medis'],0,',','.'); ?>
        </td>
      </tr>
    <?php }
  ?>
	<tr height="25">
		<td width="50%"><?php echo $i+2; ?>. Biaya Administrasi</td>
		<td align="right">
			<?php echo 'Rp. ' . number_format($data['biaya']['admin'],0,',','.'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-top: 1px solid #000;"></td>
	</tr>
</table>
<table align="center" border="0" width="100%" <?php if($detail || $pemeriksaan){ echo 'style="display:none;"'; } ?>>
	<tr height="25">
		<td width="50%"><b>Diskon</b></td>
		<td align="right">
			<b><?php echo 'Rp. ' . number_format($data['bayar']['diskon'],0,',','.'); ?></b>
		</td>
	</tr>
	<tr height="25">
		<td width="50%"><b>Total Biaya</b></td>
		<td align="right">
			<b><?php echo 'Rp. ' . number_format($data['bayar']['total'],0,',','.'); ?></b>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom: 1px solid #000;"></td>
	</tr>
</table>
<table align="center" border="0" width="100%" <?php if($detail || $pemeriksaan){ echo 'style="display:none;"'; } ?>>
	<tr height="25">
		<td width="50%"><b>Bayar</b></td>
		<td align="right">
			<b><?php echo 'Rp. ' . number_format($data['bayar']['bayar'],0,',','.'); ?></b>
		</td>
	</tr>
	<tr height="25">
		<td width="50%"><b>Kembali</b></td>
		<td align="right">
			<b><?php echo 'Rp. ' . number_format($data['bayar']['kembali'],0,',','.'); ?></b>
		</td>
	</tr>
</table>
<table align="center" border="0" width="100%" <?php if($detail || $pemeriksaan){ echo 'style="display:none;"'; } ?>>
	<tr height="100">
		<td align="center">
			<b><i>Terbilang: <?php echo ucwords(terbilang($data['bayar']['total'])) . ' Rupiah'; ?></i></b>
		</td>
	</tr>
	<tr heiht="100">
		<td align="right">
			<?php echo 'Cihanjuang, ' . date('d-m-Y'); ?>
		</td>
	</tr>
</table>
<table border="1" width="100%" <?php if(!$detail){ echo 'style="display:none;"'; } ?>>
	<thead>
		<th>No.</th>
		<th>Alat & Obat</th>
		<th>Jml</th>
		<th>Harga Satuan</th>
		<th>Sub Total</th>
	</thead>
	<tbody>
		<?php
			for ($i=0; $i < count($data['obat']); $i++) { ?>
				<tr>
					<td align="center"><?php echo $i+1; ?></td>
					<td><?php echo $data['obat'][$i]['nama_obat']; ?></td>
					<td align="center"><?php echo $data['obat'][$i]['qty']; ?></td>
					<td><?php echo 'Rp. ' . number_format(intval($data['obat'][$i]['harga_jual_obat']),0,',','.'); ?></td>
					<td><?php echo 'Rp. ' . number_format($data['obat'][$i]['biaya'],0,',','.'); ?></td>
				</tr>
			<?php }
		?>
		<tr>
			<td colspan="4" align="center"><b>TOTAL</b></td>
			<td><b>Rp. <?php echo number_format($data['totalObat'],0,',','.'); ?></b></td>
		</tr>
	</tbody>
</table>

<table border="1" width="100%" <?php if(!$pemeriksaan){ echo 'style="display:none;"'; } ?>>
	<thead>
		<th>No.</th>
		<th>Nama Tindakan</th>
		<th>Sub Total</th>
	</thead>
	<tbody>
		<?php
			for ($i=0; $i < count($data['medis']); $i++) { ?>
				<tr>
					<td align="center"><?php echo $i+1; ?></td>
					<td><?php echo $data['medis'][$i]['nama_biaya_medis']; ?></td>
					<td><?php echo 'Rp. ' . number_format($data['medis'][$i]['biaya'],0,',','.'); ?></td>
				</tr>
			<?php }
		?>
		<tr>
			<td colspan="2" align="center"><b>TOTAL</b></td>
			<td><b>Rp. <?php echo number_format($data['totalMedis'],0,',','.'); ?></b></td>
		</tr>
	</tbody>
</table>

</body>
</html>