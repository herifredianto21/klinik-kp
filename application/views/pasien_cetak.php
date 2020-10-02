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
    <title>Cetak Identitas Pasien</title>
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

<table align="center" border="0" width="100%" cellpadding="3">
	<tr align="center">
		<td>
			<table align="center" width="100%" border="0" cellpadding="5">
				<tr>
					<td width="15%">
						<img src="<?php echo base_url('assets/img/Logo.jpg'); ?>" alt="" style="width: 100%; height: 10%;">
					</td>
					<td width="20%"></td>
					<td width="65%">
						<b><u>IDENTITAS PASIEN AWAL</u></b>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr align="center">
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="20%"><b>No. RM</b></td>
					<td width="90%">
						<table border="3">
							<tr>
								<?php 
								$rm = str_split($detail['no_registrasi']);
								for ($i=0; $i < count($rm); $i++) { ?>
									<td style="min-width: 10px;" align="center"><?php echo $rm[$i]; ?></td>
								<?php }
								?>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td align="right"><b><u>Mohon diisi sesuai KTP</u></b></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">NIK</td>
					<td width="20%">: <?php echo $detail['nik']; ?></td>
					<td width="20%"></td>
					<td width="30%"></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Nama Pasien</td>
					<td width="20%">: <?php echo $detail['nama_pasien']; ?></td>
					<td width="20%"><b><u>Nama Ayah Kandung</u></b></td>
					<td width="30%">: <?php echo $detail['nama_ayah_kandung']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%"></td>
					<td width="20%"></td>
					<td width="20%">Nama Suami / PJ</td>
					<td width="30%">: <?php echo $detail['nama_suami']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Tgl Lahir</td>
					<td width="20%">: <?php echo tglIndo($detail['tgl_lahir']); ?></td>
					<td width="20%">Tgl Lahir</td>
					<td width="30%">: <?php echo tglIndo($detail['tgl_lahir_suami']); ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Pendidikan</td>
					<td width="20%">: <?php echo $detail['pendidikan_istri']; ?></td>
					<td width="20%">Pendidikan</td>
					<td width="30%">: <?php echo $detail['pendidikan_suami']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Agama</td>
					<td width="20%">: <?php echo $detail['agama_istri']; ?></td>
					<td width="20%">Agama</td>
					<td width="30%">: <?php echo $detail['agama_suami']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Pekerjaan</td>
					<td width="20%">: <?php echo $detail['nama_pekerjaan_istri']; ?></td>
					<td width="20%">Pekerjaan</td>
					<td width="30%">: <?php echo $detail['nama_pekerjaan_suami']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Alamat KTP</td>
					<td width="20%">: <?php echo $detail['alamat_ktp_istri']; ?></td>
					<td width="20%">Alamat KTP</td>
					<td width="30%">: <?php echo $detail['alamat_ktp_suami']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Alamat Domisili</td>
					<td width="20%">: <?php echo $detail['alamat_istri']; ?></td>
					<td width="20%">Alamat Domisili</td>
					<td width="30%">: <?php echo $detail['alamat_suami']; ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">No. Telp / WA</td>
					<td width="20%">: <?php echo $detail['no_telp_pasien']; ?></td>
					<td width="20%"></td>
					<td width="30%"></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Alamat email</td>
					<td width="20%">: <?php echo $detail['email']; ?></td>
					<td width="20%"></td>
					<td width="30%"></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td width="15%">Media Sosial</td>
					<td width="20%">: <?php echo $detail['medsos']; ?></td>
					<td width="20%"></td>
					<td width="30%"></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table width="100%" border="0">
				<tr>
					<td align="center"><b><u>KLINIK UTAMA NUR KHADIJAH</u></b></td>
				</tr>
				<tr>
					<td align="center"><b><u>Islami, Aman, dan Edukatif</u></b></td>
				</tr>
			</table>
		</td>
	</tr>

</table>
</body>
</html>