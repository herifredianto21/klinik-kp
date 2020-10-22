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

function customTglIndo($date)
{
	$d = intval(substr($date, 8, 2));
	$m = intval(substr($date, 5, 2));
	$y = substr($date, 0, 4);

	return $d . '-' . $m . '-' . $y;
}

function customUmur($data)
{
	$result = '';

	$thn = intval($data['umur_tahun']);
	$bln = intval($data['umur_bulan']);

	if ($thn > 0) {
		$result .= $thn . ' th ';
	}

	if ($bln > 0) {
		$result .= $bln . ' bln';
	}

	return $result;
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
    <title>Laporan Rekap Penyakit</title>
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
	<tr align="center"><td colspan="4"><b>LAPORAN REKAP PENYAKITL</b></td></tr>
	<tr align="center"><td colspan="4"><b>PUSKESMAS PARONGPONG</b></td></tr>
	<tr>
		<td colspan="4">
			<table align="center" width="100%" border="0" cellpadding="5">
				<tbody>
					<tr>
						<td>
							DESA/PUSTU/BP SWASTA/BIDAN SWASTA/PUSKEL/PRAKTEK SWASTA : Klinik Utama Nur Khadijah
						</td>
					</tr>
					<tr>
						<td>
							BULAN : <?php echo blnChanger($data['bulan_laporan']); ?>
						</td>
					</tr>
					<tr>
						<td>
							TAHUN : <?php echo $data['tahun_laporan']; ?>
						</td>
					</tr>
				</tbody>
			</table>

			<table align="center" width="100%" border="1" cellpadding="3">
			  <thead align="center">
			  	<tr>
				    <th rowspan="2">KODE</th>
				    <th rowspan="2">PENYAKIT</th>
				    <?php
				    for ($i=0; $i < count($rentangUmur); $i++) { ?>
				    	<th colspan="2"><?php echo $rentangUmur[$i]['rentang_umur']; ?></th>
				    <?php }
				    ?>
				  </tr>
				  <tr>
				    <?php
				    $lp = count($rentangUmur) * 2;
				    $jk = "L";
				    for ($i=0; $i < $lp; $i++) { 
				    	if ($i % 2 == 0) {
				    		$jk = "L";
				    	} else{
				    		$jk = "P";
				    	}
				    	?>
				    	<td><?php echo $jk; ?></td>
				    <?php }
				    ?>
				  </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	for ($i=0; $i < count($detail); $i++) { ?>
			  		<tr>
			  			<td><?php echo $detail[$i]['kode_penyakit']; ?></td>
				  		<td><?php echo $detail[$i]['nama_penyakit']; ?></td>
				  		<?php
				  		for ($j=0; $j < count($detail[$i]['rekap']); $j++) { ?>
				  			<td align="center"><?php if($detail[$i]['rekap'][$j]['L'] > 0) { echo $detail[$i]['rekap'][$j]['L']; } ?></td>
				  			<td align="center"><?php if($detail[$i]['rekap'][$j]['P'] > 0) { echo $detail[$i]['rekap'][$j]['P']; } ?></td>
				  		<?php }
				  		?>
			  		</tr>
			  	<?php }
			  	?>
			  </tbody>
			</table>

		</td>
	</tr>
</table>
</body>
</html>