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
    <title>Surat Keterangan Hamil</title>
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
<body onload="print();">

<table align="center" border="0" width="100%">
	<tr>
		<td colspan="4">
			<table align="center" width="100%" border="0" cellpadding="5">
				<tr>
					<tr>
					<td width="85%" align="left">
						<img src="<?php echo base_url('assets/img/Logo.jpg'); ?>" alt="" style="width: 15%; height: 5%;">
						<p style="font-size: 8px;">NPWP: 31.298.383.6-421.000<br>
						Jalan Cihanjuang No. 293 Tutugan, Cihanjuang Rahayu,<br>
						Parongpong, Kab. Bandung Barat, Bandung 40559, Indonesia<br>
						Telp: +62 22 61139884 | Faks: +62 22 6640597</p>
					</td>
				</tr>
				</tr>

				<tr>
					<td colspan="2" align="center">
						<h2><u>SURAT KETERANGAN HAMIL</u></h2>
					</td>
				</tr>
			</table>

			<table align="center" width="100%" border="0" cellpadding="5">
				<tbody>
					<tr>
						<td colspan="3">Yang bertanda tangan di bawah ini:</td>
					</tr>
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="15%">Nama</td>
						<td width="80%">: <?php echo $nama_pejabat; ?></td>
					</tr>
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="15%">Jabatan</td>
						<td width="80%">: <?php echo $jabatan; ?></td>
					</tr>
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="15%">Alamat</td>
						<td width="80%">: <?php echo $alamat_pejabat; ?></td>
					</tr>
					<tr>
						<td colspan="3">Menerangkan bahwa:</td>
					</tr>
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="15%">Nama</td>
						<td width="80%">: <?php echo $nama_pasien; ?></td>
					</tr>
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="15%">Umur</td>
						<td width="80%">: <?php echo $umur_pasien; ?></td>
					</tr>
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="15%">Alamat</td>
						<td width="80%">: <?php echo $alamat_pasien; ?></td>
					</tr>
					<tr>
						<td colspan="3">Menurut hasil pemeriksaan pada tanggal <?php echo tglIndo($tgl_periksa);?> bahwa yang bersangkutan <b><?php echo $keterangan; ?></b>.</td>
					</tr>
				</tbody>
			</table>
			

		</td>
	</tr>
	
	<tr>
		<td width="25%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td align="center">
			<p>Cihanjuang, <?php echo tglIndo(date('Y-m-d', time())); ?></p>
		</td>
	</tr>
	<tr>
		<td width="25%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td height="20">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td width="25%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td align="center">
			<p>( <?php echo $nama_dokter; ?> )</p>
		</td>
	</tr>
</table>
<hr>
</body>
</html>