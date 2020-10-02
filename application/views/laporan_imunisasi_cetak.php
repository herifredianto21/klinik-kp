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
    <title>Laporan Imunisasi</title>
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
	<tr align="center"><td colspan="4"><b>LAPORAN IMUNISASI</b></td></tr>
	<tr align="center"><td colspan="4"><b>KLINIK UTAMA NUR KHADIJAH</b></td></tr>
	<tr>
		<td colspan="4">
			<table align="center" width="100%" border="0" cellpadding="5">
				<tbody>
					<tr>
						<td>
							<b>BULAN</b> : <?php echo blnChanger($data['bulan_laporan']) . " " . $data['tahun_laporan']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cihanjuang
						</td>
					</tr>
				</tbody>
			</table>

			<table align="center" width="100%" border="1" cellpadding="3">
			  <thead align="center">
			  	<tr>
			  		<th rowspan="3">TANGGAL</th>
				    <th rowspan="3">NO</th>
				    <th rowspan="3">NAMA ANAK</th>
				    <th rowspan="3">NO. KK ORTU</th>
				    <th rowspan="3">ALAMAT</th>
				    <th rowspan="3">TANGGAL LAHIR</th>
				    <th rowspan="3">BB LAHIR (GRAM)</th>
				    <th rowspan="3">BB (GRAM)</th>
				    <th rowspan="3">PB (CM)</th>
				    <th colspan="13">MACAM IMUNISASI</th>
				    <th rowspan="3">TINDAKAN</th>
				  </tr>
				  <tr>
				    <td rowspan="2">HB0</td>
				    <td rowspan="2">BCG</td>
				    <td colspan="4">PENTABIO</td>
				    <td colspan="4">POLIO</td>
				    <td rowspan="2">TT</td>
				    <td colspan="2">CAMPAK</td>
				  </tr>
				  <tr>
				  	<td style="min-width: 20px;">1</td>
				  	<td style="min-width: 20px;">2</td>
				  	<td style="min-width: 20px;">3</td>
				  	<td style="min-width: 20px;">Ulang</td>
				  	<td style="min-width: 20px;">1</td>
				  	<td style="min-width: 20px;">2</td>
				  	<td style="min-width: 20px;">3</td>
				  	<td style="min-width: 20px;">4</td>
				  	<td style="min-width: 20px;">1</td>
				  	<td style="min-width: 20px;">Ulang</td>
				  </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$no = 1;
			  	for ($i=0; $i < count($detail); $i++) { ?>
			  		<tr>
			  			<td><?php echo customTgl($detail[$i]['created_at']);?></td>
			  			<td align="center"><?php echo $no;?></td>
				  		<td><?php echo $detail[$i]['nama_anak'];?></td>
				  		<td><?php echo $detail[$i]['no_kk'];?></td>
				  		<td><?php echo $detail[$i]['alamat'];?></td>
				  		<td><?php echo customTgl($detail[$i]['tgl_lahir']);?></td>
				  		<td align="center"><?php if($detail[$i]['bb_lahir'] > 0) { echo $detail[$i]['bb_lahir']; }?></td>
				  		<td align="center"><?php if($detail[$i]['bb'] > 0) { echo $detail[$i]['bb']; }?></td>
				  		<td align="center"><?php if($detail[$i]['pb'] > 0) { echo $detail[$i]['pb']; }?></td>
				  		<td align="center"><?php if($detail[$i]['hb0'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['bcg'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['pentabio1'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['pentabio2'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['pentabio3'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['pentabio_ulang'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['polio1'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['polio2'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['polio3'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['polio4'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['tt'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['campak'] == 1) { echo "&#10004;"; } ?></td>
				  		<td align="center"><?php if($detail[$i]['campak_ulang'] == 1) { echo "&#10004;"; } ?></td>
				  		<td><?php echo $detail[$i]['nama_tindakan'];?></td>
			  		</tr>
			  		<?php $no++;
			  	}
			  	?>
			  </tbody>
			</table>

		</td>
	</tr>
</table>
</body>
</html>