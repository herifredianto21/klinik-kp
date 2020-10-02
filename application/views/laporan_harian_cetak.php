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
    <title>Laporan Harian</title>
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
	<tr align="center"><td colspan="4"><b>LAPORAN HARIAN</b></td></tr>
	<tr>
		<td colspan="4">
			<table id="tableLaporanHarian" align="center" width="100%" border="1" cellpadding="3">
        <thead align="center">
          <tr>
            <th rowspan="2"><?php echo strtoupper(blnChanger($data['bulan_laporan'])); ?></th>
            <th colspan="31">Tanggal</th>
            <th rowspan="2">Jumlah</th>
          </tr>
          <tr>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td><?php echo $i+1; ?></td>
            <?php }
            ?>
        </thead>
        <tbody>
          <tr>
            <td>Hamil</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['hamil'][$i]) != 0) echo $detail['hamil'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
          <tr>
            <td>Hamil Baru</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['hamil_baru'][$i]) != 0) echo $detail['hamil_baru'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
            <td>KB</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['kb'][$i]) != 0) echo $detail['kb'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          <tr>
            <td>IUD</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['iud'][$i]) != 0) echo $detail['iud'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
          <tr>
            <td>Sakit</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['sakit'][$i]) != 0) echo $detail['sakit'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
          <tr>
            <td>Imunisasi</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['imunisasi'][$i]) != 0) echo $detail['imunisasi'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
          <tr>
            <td>USG</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['usg'][$i]) != 0) echo $detail['usg'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
          <tr>
            <td>Partus</td>
            <?php
            for ($i=0; $i < 31; $i++) { ?>
              <td align="center"><?php if(intval($detail['partus'][$i]) != 0) echo $detail['partus'][$i]; ?></td>
            <?php }
            ?>
            <td align="center"></td>
          </tr>
          <tr>
            <td>Jumlah</td>
            <?php
            for ($i=0; $i < 32; $i++) { ?>
              <td align="center"></td>
            <?php }
            ?>
          </tr>
        </tbody>
      </table>

		</td>
	</tr>
</table>
<script src="http://localhost/admina/assets/js/core/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var jml = Array();
    jml.length = $('#tableLaporanHarian tbody tr:last td').length - 2;
		$('#tableLaporanHarian tbody tr').each(function(i){
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
    $('#tableLaporanHarian tbody tr:last td').each(function(i){
        if (i != 0) {
            $(this).html('<strong>'+jml[i]+'</strong>');
            if (!isNaN(jml[i-1]) && jml[i-1].length !== 0) {
                total += parseFloat(jml[i-1]);
            }
        }
    });
    $('#tableLaporanHarian tbody tr:last td:last').html('<strong>'+total+'</strong>');
	});
</script>
</body>
</html>