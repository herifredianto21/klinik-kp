<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CetakKartu_model extends CI_Model {
	public function cetakAntrian(){
		$cetak = $this->db->query('SELECT a.id,d.nama_dokter,p.nama_pasien,jp.nama_pelayanan,
								 a.no_antrian,a.tgl_antrian,a.kode_antrian
								 FROM antrians as a JOIN dokters as d ON a.id_dokter = d.id
								 JOIN pasiens as p ON a.id_pasien = p.id
								 JOIN jenis_pelayanans as jp ON jp.id=a.id_jenis_pelayanan ORDER BY a.id DESC LIMIT 1');
		return $cetak;
	}
	public function cetakKartuPasien($id){
		if (!$id == null) {
			$cetakKP = $this->db->query("SELECT * FROM pasiens WHERE id = '$id'");
			return $cetakKP;
		} else{
			$cetakKP = $this->db->query("SELECT * FROM pasiens ORDER by id DESC LIMIT 1");
			return $cetakKP;
		}
		

	}
}
