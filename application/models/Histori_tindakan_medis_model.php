<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Histori_tindakan_medis_model extends CI_Model {

	function _histori_pertenaga_medis($filter_dari, $filter_sampai, $id_dokter)
	{
		$q = "SELECT
				antrians.id AS id_antrian, dokters.id AS id_dokter, antrians.tgl_antrian AS 'waktu', 
				pasiens.nama_pasien, jenis_pelayanans.nama_pelayanan
			FROM
				antrians
			JOIN
				pasiens ON pasiens.id = antrians.id_pasien
			JOIN
				dokters ON dokters.id = antrians.id_dokter
			JOIN
				jenis_pelayanans ON jenis_pelayanans.id = antrians.id_jenis_pelayanan
			WHERE
				SUBSTRING(antrians.tgl_antrian, 1, 10) BETWEEN '$filter_dari' AND '$filter_sampai' AND
				dokters.id = $id_dokter";

		// TODO: tambah field jasa medis

        $s = $this->db->query($q)->result();

        return $s;
	}

	function _get_dokter()
	{
		$q = "SELECT
				id, nama_dokter
			FROM 
				dokters";

		$s = $this->db->query($q)->result();

		return $s;
	}

	function _get_dokter_by_id($id_dokter)
	{
		$q = "SELECT
				nama_dokter, spesialisasi, alamat_dokter, no_hp_dokter
			FROM 
				dokters
			WHERE
				id = $id_dokter";

		$s = $this->db->query($q)->result();

		return $s;
	}

}