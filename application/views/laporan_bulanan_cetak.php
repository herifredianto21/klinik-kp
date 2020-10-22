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
    <title>Laporan Bulanan Rumah Bersalin</title>
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
	<tr align="center">
		<td>
			<table align="center" width="100%" border="0" cellpadding="5">
				<tr>
					<td width="15%" style="border-right: 1px solid #000">
						<img src="<?php echo base_url('assets/img/Logo.jpg'); ?>" alt="" style="width: 100%; height: 10%;">
					</td>
					<td width="85%" align="left">
						<p style="font-size: 0.8em;">NPWP: 31.298.383.6-421.000<br>
						Jalan Cihanjuang No. 293 Tutugan, Cihanjuang Rahayu,<br>
						Parongpong, Kab. Bandung Barat, Bandung 40559, Indonesia<br>
						Telp: +62 22 61139884 | Faks: +62 22 6640597</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center"><td colspan="4"><b>LAPORAN BULANAN RUMAH BERSALIN</b></td></tr>
	<tr>
		<td colspan="4">
			<table align="center" width="100%" border="0" cellpadding="5">
				<tbody>
					<tr>
						<td>
							<b>BULAN</b> : <?php echo blnChanger($data['bulan_laporan']) . " " . $data['tahun_laporan']; ?>
						</td>
					</tr>
				</tbody>
			</table>

			<table id="tableLaporanBulanan" align="center" width="100%" border="1" cellpadding="3">
        <thead align="center">
          <tr>
            <th rowspan="4">DESA</th>
            <th colspan="2">KIA</th>
            <th colspan="12">KB</th>
            <th colspan="13">IMUNISASI</th>
            <th rowspan="4">PARTUS</th>
            <th rowspan="4">JUMLAH</th>
          </tr>
          <tr>
            <td colspan="2">HAMIL</td>
            <td colspan="6">BARU</td>
            <td colspan="6">LAMA</td>
            <td rowspan="3">HB0</td>
            <td rowspan="3">BCG</td>
            <td colspan="4" rowspan="2">PENTABIO</td>
            <td colspan="4" rowspan="2">POLIO</td>
            <td rowspan="3">TT</td>
            <td colspan="2" rowspan="2">CAMPAK</td>
          </tr>
          <tr>
            <td rowspan="2">B</td>
            <td rowspan="2">L</td>
            <td colspan="2">SUN</td>
            <td rowspan="2">PIL</td>
            <td colspan="2">IUD</td>
            <td rowspan="2">KON</td>
            <td colspan="2">SUN</td>
            <td rowspan="2">PIL</td>
            <td colspan="2">IUD</td>
            <td rowspan="2">KON</td>
          </tr>
          <tr>
            <td>1 BLN</td>
            <td>3 BLN</td>
            <td>BKKBN</td>
            <td>NON</td>
            <td>1 BLN</td>
            <td>3 BLN</td>
            <td>BKKBN</td>
            <td>NON</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>ULG</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>1</td>
            <td>ULG</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>CIHANJUANG RAHAYU</td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang_rahayu']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>CIHANJUANG</td>
            <td align="center"><?php echo $detail['cihanjuang']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['cihanjuang']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>SARIWANGI</td>
            <td align="center"><?php echo $detail['sariwangi']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['sariwangi']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>KARYAWANGI</td>
            <td align="center"><?php echo $detail['karyawangi']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['karyawangi']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>CIHIDEUNG</td>
            <td align="center"><?php echo $detail['cihideung']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['cihideung']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>CIGUGUR</td>
            <td align="center"><?php echo $detail['cigugur']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['cigugur']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>CIPANAS</td>
            <td align="center"><?php echo $detail['cipanas']['kia']['baru']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kia']['lama']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['baru']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['baru']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['baru']['pil']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['baru']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['baru']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['baru']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['lama']['suntik_1_bulan']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['lama']['suntik_3_bulan']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['lama']['pil']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['lama']['iud_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['lama']['iud_non_bkkbn']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['kb']['lama']['kondom']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['hb0']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['bcg']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['pentabio_1']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['pentabio_2']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['pentabio_3']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['pentabio_ulang']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['polio_1']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['polio_2']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['polio_3']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['polio_4']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['tt']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['campak']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['imunisasi']['campak_ulang']; ?></td>
            <td align="center"><?php echo $detail['cipanas']['partus']; ?></td>
            <td align="center">0</td>
          </tr>
          <tr>
            <td>JUMLAH</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
          </tr>
        </tbody>
      </table>

		</td>
	</tr>
</table>
<script src="http://localhost/admina/assets/js/core/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tableLaporanBulanan tbody tr td').each(function(){
			var val = $(this).text();
			if (val == '0') {
				$(this).text('-');
			}
		});

		var jml = Array();
    jml.length = $('#tableLaporanBulanan tbody tr:last td').length - 2;
		$('#tableLaporanBulanan tbody tr').each(function(i){
        var sum = 0;
        $(this).find('td').each(function(j){
        	if (jml[j] === undefined) {
                  jml[j] = 0;
              }
            var val = $(this).text();
            if (!isNaN(val) && val.length !== 0) {
                sum += parseFloat(val);
                jml[j] += parseFloat(val)
            }
        });
        $(this).find('td:last').html('<strong>'+sum+'</strong>');
    });

    var total = 0;
    $('#tableLaporanBulanan tbody tr:last td').each(function(i){
        if (i != 0) {
            $(this).html('<strong>'+jml[i]+'</strong>');
            if (!isNaN(jml[i-1]) && jml[i-1].length !== 0) {
                total += parseFloat(jml[i-1]);
            }
        }
    });
    $('#tableLaporanBulanan tbody tr:last td:last').html('<strong>'+total+'</strong>');
	});
</script>
</body>
</html>