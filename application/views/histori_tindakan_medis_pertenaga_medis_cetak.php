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
	<tr align="center"><td colspan="4"><b>LAPORAN TINDAKAN MEDIS PERTENAGA MEDIS</b></td></tr>
	<tr>
		<td colspan="4">
			
			<?php
				foreach($tampil_dokter_by_id as $tdbi) {
					$nama_dokter = $tdbi->nama_dokter;
					$spesialisasi = $tdbi->spesialisasi;
					$alamat_dokter = $tdbi->alamat_dokter;
					$no_hp_dokter = $tdbi->no_hp_dokter;
				}
			?>

			<table>
				<tbody>
					<tr>
						<td>Nama Tenaga Medis</td>
						<td>: <?= $nama_dokter ?></td>
					</tr>
					<tr>
						<td>Spesialis</td>
						<td>: <?= $spesialisasi ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>: <?= $alamat_dokter ?></td>
					</tr>
					<tr>
						<td>No. HP</td>
						<td>: <?= $no_hp_dokter ?></td>
					</tr>
				</tbody>
			</table>

      <p style="font-size: 0.8em;">
        <b>BULAN</b> : <?php echo $_GET['filter_dari'] . " — " . $_GET['filter_sampai']; ?>
      </p>

			<table border="1" align="center" width="100%" cellpadding="3">
				<thead>
					<tr align="center">
						<th>No</th>
						<th>Waktu</th>
						<th>Tindakan Medis</th>
						<th>Nama Pasien</th>
						<th>Biaya Jasa</th>
					</tr>
				</thead>
				<tbody>
          <?php
            $no = 1;

            foreach($histori_pertenaga_medis as $hpm) { ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $hpm->waktu ?></td>
                <td><?= $hpm->nama_pelayanan ?></td>
                <td><?= $hpm->nama_pasien ?></td>
                <td><?= "-- belum --" ?></td>
              </tr>
              <?php
            }
          ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">Total</td>
						<td>Rp 200.000</td>
					</tr>
				</tfoot>
			</table>

		</td>
	</tr>
</table>

</body>