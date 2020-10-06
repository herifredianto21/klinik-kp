<html>
<head>
	<title></title>
</head>
<body>
	<?php
	$idPelayanan	= $this->uri->segment(3);
		if ($idPelayanan == '9') 
		{
	?>
	<table border='1'>
		<tr>
			<th>No</th>
			<th>Create_at</th>
			<th>Nama Pasien</th>
			<th>Jenis kelamin</th>
			<th>Nama Penyakit</th>
			<th>Rentang Umur</th>
			<th>Macam Tindakan Imunisasi</th>
			<th>Catatan</th>
			<th>Tindakan Medis</th>
			<th>Nama Obat</th>
			
		</tr>
		<?php 
		$no=1;
		foreach ($detailKehamilan->result() as $dk ) { ?>
		<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $dk->created_at;?></td>
			<td><?php echo $dk->nama_pasien;?></td>
			<td><?php echo $dk->jk_pasien;?></td>
			<td><?php echo $dk->nama_penyakit;?></td>
			<td><?php echo $dk->rentang_umur;?></td>
			<td><?php echo $dk->nama_tindakan;?></td>
			<td><?php echo $dk->catatan;?></td>
			<td><?php echo $dk->keterangan_tindakan_pasien;?></td>
			<td><?php echo $dk->nama_obat;?></td>

		</tr>
		<?php }?>
	</table>
	<?php
		} else {
			echo "string";
		}
	?>

</body>
</html>