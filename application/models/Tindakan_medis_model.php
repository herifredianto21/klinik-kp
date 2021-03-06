<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_medis_model extends CI_Model {

	function _get_pasien()
	{
		$q = "SELECT
                antrians.id, antrians.id_dokter, antrians.id_pasien, antrians.no_antrian, pasiens.nama_pasien, jenis_pelayanans.nama_pelayanan, 
                dokters.nama_dokter, antrians.status_antrian, antrians.tgl_antrian
            FROM
                antrians
            JOIN
                pasiens ON pasiens.id = antrians.id_pasien
            JOIN
                dokters ON dokters.id = antrians.id_dokter
            JOIN
                jenis_pelayanans ON jenis_pelayanans.id = antrians.id_jenis_pelayanan
            WHERE
                antrians.status_antrian = 'Selesai' AND
                antrians.id NOT IN (
                    SELECT 
                        id_antrian
                    FROM 
                        tindakan_pasien
                    WHERE 
                        tindakan_pasien.deleted_at IS NULL AND
                        tindakan_pasien.status_tindakan_pasien = 'Selesai'
                )
            ORDER BY 
                antrians.tgl_antrian ASC";

        $s = $this->db->query($q)->result();

        return $s;
    }

    
    /* TINDAKAN */
    
    function _getTindakan($id_antrian = null)
    {
        $q = "SELECT 
                id, nama_biaya_medis, biaya_medis, ket_biaya_medis
            FROM 
                biaya_medis
            WHERE 
                deleted_at IS NULL";
        
        if ($id_antrian != null) {
            $q .= " AND id NOT IN (
                        SELECT 
                            tindakan_pasien_detail.id_biaya_medis
                        FROM 
                            tindakan_pasien_detail
                        JOIN
                            tindakan_pasien ON tindakan_pasien.id = tindakan_pasien_detail.id_tindakan_pasien
                        JOIN
                            biaya_medis ON biaya_medis.id = tindakan_pasien_detail.id_biaya_medis
                        WHERE 
                            tindakan_pasien_detail.deleted_at IS NULL AND
                            tindakan_pasien.id_antrian = '$id_antrian'
                    )";
        }

        $s = $this->db->query($q)->result();

        return $s;
    }

    function _getAddedTindakan($id_antrian = null) 
    {
        $q = "SELECT 
                tindakan_pasien.id, biaya_medis.nama_biaya_medis, tindakan_pasien_detail.biaya_medis, 
                tindakan_pasien_detail.id AS id_tindakan_pasien_detail, tindakan_pasien_detail.jasa_medis, 
                tindakan_pasien_detail.keterangan_tindakan_pasien
            FROM 
                tindakan_pasien_detail
            JOIN
                tindakan_pasien ON tindakan_pasien.id = tindakan_pasien_detail.id_tindakan_pasien
            JOIN
                biaya_medis ON biaya_medis.id = tindakan_pasien_detail.id_biaya_medis
            WHERE 
                tindakan_pasien_detail.deleted_at IS NULL AND
                tindakan_pasien.id_antrian = '$id_antrian'";

        $s = $this->db->query($q)->result();

        return $s;
    }

    /*mengambil data berdasarkan id dari tabel biaya_medis */
    function _getBiayaMedisById($id)
    {
        $q = "SELECT *
            FROM 
                biaya_medis
            WHERE 
               id = '$id'";

        $s = $this->db->query($q)->result();
        if(empty($s)) return [];
        return $s;
    }

    function _addTindakan($id_tindakan_pasien, $id_biaya_medis, $keterangan_tindakan_pasien)
    {
        $tmpBiayaMedis = $this->_getBiayaMedisById($id_biaya_medis);
        if(empty($tmpBiayaMedis)) {
            echo "Error di _addTindakan()";
            exit;
        }else{
            $tmpBiayaMedis = $tmpBiayaMedis[0];
        }
        
        $q =    "INSERT INTO
                    tindakan_pasien_detail
                    (
                        created_at,
                        id_tindakan_pasien,
                        id_biaya_medis,
                        biaya_medis,
                        keterangan_tindakan_pasien
                    )
                VALUES
                    (
                        NOW(),
                        '". $this->db->escape_str($id_tindakan_pasien) ."',
                        '". $this->db->escape_str($id_biaya_medis) ."',
                        '". $tmpBiayaMedis->biaya_medis ."',
                        '". $this->db->escape_str($keterangan_tindakan_pasien) ."'
                    )
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _addTindakan()";
            exit;
        }

        /* 
        NOTE:
        - kurang input untuk field jasa_medis
        */
    }

    function _editAddedTindakan($id_tindakan_pasien_detail, $keterangan_tindakan_pasien)
    {
        $q =    "UPDATE
                    tindakan_pasien_detail
                SET
                    updated_at = NOW(),
                    keterangan_tindakan_pasien = '". $this->db->escape_str($keterangan_tindakan_pasien) ."'
                WHERE
                    id = '$id_tindakan_pasien_detail'
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _editAddedTindakan()";
            exit;
        }
    }

    function _deleteAddedTindakan($id)
    {
        $q = "DELETE FROM tindakan_pasien_detail WHERE id = '$id'";
        
        if ($this->db->simple_query($q)) {
            echo '{ "text": "Berhasil menghapus." }';
        } else {
            echo '{ "text": "Gagal menghapus." }';
        }
    }

    function _cekTindakanPasien($id_antrian)
    {
        $q = $this->db->query("SELECT * FROM tindakan_pasien WHERE id_antrian = '$id_antrian'");
        return empty($q->row_array()) ? false : true;
    }

    function _addTindakanBaru($id_antrian, $id_dokter)
    {
        $q =    "INSERT INTO
                    tindakan_pasien
                    (
                        created_at,
                        id_antrian,
                        id_dokter
                    )
                VALUES
                    (
                        NOW(),
                        '". $this->db->escape_str($id_antrian) ."',
                        '". $this->db->escape_str($id_dokter) ."'
                    )
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _addTindakanBaru()";
            exit;
        }
    }
    function _getIdTindakanPasien($id_antrian)
    {
        $q = $this->db->query("SELECT id FROM tindakan_pasien WHERE id_antrian = '$id_antrian' ORDER BY id DESC");
        return $q->row()->id;
    }

    
    /* RESEP */
    
    function _getObat($id_antrian = null) 
    {
        $q = "SELECT
                obats.id, obats.kode_obat, obats.nama_obat, satuans.nama_satuan, obats.harga_jual_obat
            FROM 
                obats
            JOIN
                satuans ON satuans.id = obats.id_satuan
            WHERE 
                obats.deleted_at IS NULL AND 
                satuans.deleted_at IS NULL";

        if ($id_antrian != null) {
            $q .= " AND obats.id NOT IN (
                        SELECT 
                            resep_details.id_obat
                        FROM 
                            resep_details
                        JOIN
                            reseps ON reseps.id = resep_details.id_resep
                        JOIN
                            obats ON obats.id = resep_details.id_obat
                        JOIN
                            satuans ON satuans.id = obats.id_satuan
                        WHERE 
                            resep_details.deleted_at IS NULL AND
                            reseps.id_antrian = '$id_antrian'
                    )";
        }

        $s = $this->db->query($q)->result();

        return $s;
    }

    function _getAddedResep($id_antrian = null) 
    {
        $q = "SELECT 
                reseps.id, obats.kode_obat, obats.nama_obat, obats.harga_jual_obat, 'kategori (belum)' AS kategori, 
                resep_details.id AS id_resep_detail, resep_details.qty, resep_details.total_harga, satuans.nama_satuan, resep_details.aturan_pakai
            FROM 
                resep_details
            JOIN
                reseps ON reseps.id = resep_details.id_resep
            JOIN
                obats ON obats.id = resep_details.id_obat
            JOIN
                satuans ON satuans.id = obats.id_satuan
            WHERE 
                resep_details.deleted_at IS NULL AND
                reseps.id_antrian = '$id_antrian'";
        
        $s = $this->db->query($q)->result();

        return $s;
    }
    /*mengambil data berdasarkan id dari tabel obats */
    function _getObatById($id)
    {
        $q = "SELECT *
            FROM
                obats
            WHERE
                id = '$id'";
        $s = $this->db->query($q)->result();
        if(empty($s)) return [];
        return $s;
    }

    function _addResep($id_resep, $id_obat, $qty, $aturan_pakai)
    {
        $tmpHargaObat = $this->_getObatById($id_obat);
        if(empty($tmpHargaObat)) {
            echo "Error di _addResep()";
            exit;
        }else{
            $tmpHargaObat = $tmpHargaObat[0];
        }
        echo "total_harga:" . $qty * $tmpHargaObat->harga_jual_obat . "<br>";
        // echo "tmpHargaObat:" . $tmpHargaObat[0]->harga_jual_obat;
        // print_r($tmpHargaObat[0]);
        // exit;

        $q =    "INSERT INTO
                    resep_details
                    (
                        created_at,
                        id_resep,
                        id_obat,
                        qty,
                        total_harga,
                        aturan_pakai
                    )
                VALUES
                    (
                        NOW(),
                        '". $this->db->escape_str($id_resep) ."',
                        '". $this->db->escape_str($id_obat) ."',
                        '". $this->db->escape_str($qty) ."',
                        '". $qty * $tmpHargaObat->harga_jual_obat ."',
                        '". $this->db->escape_str($aturan_pakai) ."'
                    )
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _addResep()";
            exit;
        }
    }

    function _editAddedResep($id, $qty, $harga_jual_obat, $aturan_pakai)
    {
        $q =    "UPDATE
                    resep_details
                SET
                    updated_at = NOW(),
                    qty = '". $this->db->escape_str($qty) ."',
                    total_harga = '". $this->db->escape_str($harga_jual_obat) * $this->db->escape_str($qty) ."',
                    aturan_pakai = '". $this->db->escape_str($aturan_pakai) ."'
                WHERE
                    id = '$id'
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _editAddedTindakan()";
            exit;
        }
    }

    function _deleteAddedResep($id)
    {
        $q = "DELETE FROM resep_details WHERE id = '$id'";
        
        if ($this->db->simple_query($q)) {
            echo '{ "text": "Berhasil menghapus." }';
        } else {
            echo '{ "text": "Gagal menghapus." }';
        }
    }

    function _cekResep($id_antrian)
    {
        $q = $this->db->query("SELECT * FROM reseps WHERE id_antrian = '$id_antrian'");
        return empty($q->row_array()) ? false : true;
    }

    function _addResepBaru($id_antrian, $id_dokter)
    {
        $q =    "INSERT INTO
                    reseps
                    (
                        created_at,
                        id_antrian,
                        id_dokter
                    )
                VALUES
                    (
                        NOW(),
                        '". $this->db->escape_str($id_antrian) ."',
                        '". $this->db->escape_str($id_dokter) ."'
                    )
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _addTindakanBaru()";
            exit;
        }
    }
    function _getIdResep($id_antrian)
    {
        echo "masuk _getIdTindakanPasien<br>";
        $q = $this->db->query("SELECT id FROM reseps WHERE id_antrian = '$id_antrian' ORDER BY id DESC");
        return $q->row()->id;
    }

    
    /* SIMPAN TINDAKAN MEDIS */

    function _simpanTindakanMedis($id_tindakan_pasien, $diagnosa, $tindak_lanjut, $keterangan_tindak_lanjut)
    {
        $q =    "UPDATE
                    tindakan_pasien
                SET
                    diagnosa = '". $this->db->escape_str($diagnosa) ."',
                    tindak_lanjut = '". $this->db->escape_str($tindak_lanjut) ."',
                    keterangan_tindak_lanjut = '". $this->db->escape_str($keterangan_tindak_lanjut) ."',
                    status_tindakan_pasien = 'Selesai'
                WHERE
                    id = '". $this->db->escape_str($id_tindakan_pasien) ."'
                ;";
        if (!$this->db->simple_query($q)) {
            echo "Error di _simpanTindakanMedis()";
            exit;
        }
    }
}