<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanRm_model extends CI_Model {


    // Pemeriksaan Persalinan
    function _lapRekamMedis_model($tgl1, $tgl2, $id)
	{
		$q = "SELECT a.id,a.created_at, p.no_registrasi, p.nama_pasien, a.umur, a.bb, a.pb, a.tgl_lahir, a.jam_lahir, a.jenis_kelamin, a.resiko, a.catatan, o.nama_obat, n.nama_biaya_medis
        FROM detail_persalinan as a
        JOIN apotek_detail_obat as c ON a.id_antrian=c.id_antrian
        JOIN apotek_detail_medis as d ON a.id_antrian=d.id_antrian

        JOIN biaya_medis AS n ON d.id_tindakan_medis=n.id
        JOIN pasiens as p ON a.id_pasien=p.id
        JOIN obats as o ON c.id_obat=o.id

        WHERE SUBSTRING(a.created_at, 1, 10)
        BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id";

        $s = $this->db->query($q)->result();

        return $s;
    }

    //  Pemeriksaan Ispaa
    function _lapRekamMedisIspaa($tgl1, $tgl2, $id)
	{
		$q = "SELECT a.id,a.created_at, a.id_antrian, p.no_registrasi, a.nama_anak, a.jenis_kelamin, a.umur_tahun, a.umur_bulan, a.bb, a.tb_pb, a.catatan, o.nama_obat
        FROM detail_program_ispa as a
        JOIN apotek_detail_obat as c ON a.id_antrian=c.id_antrian

        JOIN antrians AS b

        JOIN pasiens AS p ON b.id_pasien=p.id
        JOIN obats AS o ON c.id_obat=o.id
        WHERE SUBSTRING(a.created_at, 1, 10)
                 BETWEEN '$tgl1' AND '$tgl2'
                 GROUP BY a.id";

        $s = $this->db->query($q)->result();

        return $s;
    }

    //  Pemeriksaan Umum
    function _lapRekamMedisUmum($tgl1, $tgl2, $id){
        $q = "SELECT a.created_at, p.nama_pasien, a.jenis_kelamin, c.nama_penyakit, d.rentang_umur, a.catatan, a.id_macam_tindakan_imunisasi, f.nama_obat, n.nama_biaya_medis
        FROM
        detail_pemeriksaan_umum AS a
        JOIN apotek_detail_obat AS b ON a.id_antrian=b.id_antrian
        JOIN apotek_detail_medis AS m ON a.id_antrian=m.id_antrian
        JOIN biaya_medis AS n ON m.id_tindakan_medis=n.id
        JOIN antrians AS h ON a.id_antrian=h.id
		JOIN pasiens AS p ON h.id_pasien=p.id
        JOIN jenis_penyakit AS c ON a.id_penyakit=c.id
        JOIN rentang_umur AS d ON a.id_rentang_umur=d.id
        JOIN obats AS f ON b.id_obat=f.id

        WHERE SUBSTRING(a.created_at, 1, 10)
        BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id";

        $s = $this->db->query($q)->result();

        return $s;
    }

    function _lapRekamMedisKb($tgl1, $tgl2, $id){
        $q="SELECT a.created_at, a.nama_pasien, a.umur, a.nama_suami, a.alamat, a.jml_anak_laki, a.jml_anak_perempuan, a.jml_anak, a.usia_anak_terkecil, a.id_satuan_usia, a.pasang_baru, a.pasang_cabut, a.id_alat_kontrasepsi, a.akli, a.t_4, a.ganti_cara, a.catatan, o.nama_obat, n.nama_biaya_medis
        FROM
        detail_pemeriksaan_kb AS a
        JOIN apotek_detail_obat AS b ON a.id_antrian=b.id_antrian
        JOIN apotek_detail_medis AS m ON a.id_antrian=m.id_antrian
        JOIN biaya_medis AS n ON m.id_tindakan_medis=n.id
        JOIN obats AS o ON b.id_obat=o.id

        WHERE SUBSTRING(a.created_at, 1, 10)
        BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id";

        $s = $this->db->query($q)->result();
        return $s;
    }

    function _lapRekamMedisKehamilan($tgl1, $tgl2, $id){
        $q="SELECT a.created_at, a.id_antrian, p.no_registrasi, p.nama_pasien, a.tgl_lahir, a.hpht, a.tp, a.bb, a.tb, a.usia_kehamilan, a.gpa, a.k1, a.k4, a.tt, a.lila, a.hb, a.resiko, a.keterangan, a.catatan, n.nama_biaya_medis, f.nama_obat
        FROM
        detail_pemeriksaan_kehamilan AS a
        JOIN apotek_detail_obat AS b ON a.id_antrian=b.id_antrian
        JOIN apotek_detail_medis AS c ON a.id_antrian=c.id_antrian

		JOIN biaya_medis AS n ON c.id_tindakan_medis=n.id
        JOIN pasiens AS p ON a.id_pasien=p.id
        JOIN obats AS f ON b.id_obat=f.id

        WHERE SUBSTRING(a.created_at, 1, 10)
        BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id";

        $s = $this->db->query($q)->result();
        return $s;
    }

    function _lapRekamMedisImunisasi($tgl1, $tgl2, $id){
        $q="SELECT a.created_at, a.nama_anak, a.tgl_lahir, a.bb_lahir, a.bb, a.pb, a.id_macam_imunisasi, a.hb0, a.bcg,a.pentabio1,a.pentabio2,a.pentabio3, a.tt, a.pentabio_ulang,a.campak_ulang,a.catatan, i.nama_tindakan, k.nama_biaya_medis, b.id_antrian AS 'id_antrian'
        FROM
        detail_imunisasi AS a
        JOIN apotek_detail_obat AS b ON a.id_antrian=b.id_antrian
        JOIN antrians AS t ON a.id_antrian=b.id_antrian
        JOIN macam_tindakan_imunisasi AS m ON a.id_antrian=b.id_antrian
        JOIN apotek_detail_medis AS d ON a.id_antrian=d.id_antrian

        JOIN biaya_medis AS k ON d.id_tindakan_medis=k.id
        JOIN macam_tindakan_imunisasi AS i ON a.id_macam_tindakan_imunisasi=i.id

        WHERE SUBSTRING(a.created_at, 1, 10)
        BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id";

        $s = $this->db->query($q)->result();
        return $s;
    }

    //______________________________________________________________________________________________________________________
    //Laporan Rekam Medis Imunisasi Menampilkan data obat perPasien
    function _RmImunisasiObat($id_antrian){
        $q = "SELECT
                a.*,
                b.`nama_obat`,
                b.`harga_jual_obat`
            FROM
                `apotek_detail_obat` a
            LEFT JOIN
                `obats` b
                    ON
                b.`id` = a.`id_obat`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
                    AND
                a.`deleted_at` IS NULL;";


        $s = $this->db->query($q)->result();
        return $s;
    }

    //Laporan Rekam Medis Imunisasi Menampilkan data Tindakan Medis perPasien
    function _TindakanMedisImun($id_antrian){
        $q =   "SELECT
                a.*,
                b.`nama_biaya_medis`,
                b.`biaya_medis`
            FROM
                `apotek_detail_medis` a
            LEFT JOIN
                `biaya_medis` b
            ON
                b.`id` = a.`id_tindakan_medis`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
            AND
                a.`deleted_at` IS NULL;";

        $s = $this->db->query($q)->result();
        return $s;
    }
    //______________________________________________________________________________________________________________________

//______________________________________________________________________________________________________________________
    //Laporan Rekam Medis Kehamilan Menampilkan data obat perPasien
    function _RmKehamilanObat($id_antrian){
        $q = "SELECT
                a.*,
                b.`nama_obat`,
                b.`harga_jual_obat`
            FROM
                `apotek_detail_obat` a
            LEFT JOIN
                `obats` b
                    ON
                b.`id` = a.`id_obat`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
                    AND
                a.`deleted_at` IS NULL;";


        $s = $this->db->query($q)->result();
        return $s;
    }

    //Laporan Rekam Medis Kehamilan Menampilkan data Tindakan Medis perPasien
    function _TindakanMedisKehamilan($id_antrian){
        $q =   "SELECT
                a.*,
                b.`nama_biaya_medis`,
                b.`biaya_medis`
            FROM
                `apotek_detail_medis` a
            LEFT JOIN
                `biaya_medis` b
            ON
                b.`id` = a.`id_tindakan_medis`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
            AND
                a.`deleted_at` IS NULL;";

        $s = $this->db->query($q)->result();
        return $s;
    }
    //______________________________________________________________________________________________________________________

    //______________________________________________________________________________________________________________________
    //Laporan Rekam Medis Ispa Menampilkan data obat perPasien
    function _RmIspaObat($id_antrian){
        $q = "SELECT
                a.*,
                b.`nama_obat`,
                b.`harga_jual_obat`
            FROM
                `apotek_detail_obat` a
            LEFT JOIN
                `obats` b
                    ON
                b.`id` = a.`id_obat`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
                    AND
                a.`deleted_at` IS NULL;";


        $s = $this->db->query($q)->result();
        return $s;
    }

    //Laporan Rekam Medis Ispa Menampilkan data Tindakan Medis perPasien
    function _RmTindakanMedisIspa($id_antrian){
        $q =   "SELECT
                a.*,
                b.`nama_biaya_medis`,
                b.`biaya_medis`
            FROM
                `apotek_detail_medis` a
            LEFT JOIN
                `biaya_medis` b
            ON
                b.`id` = a.`id_tindakan_medis`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
            AND
                a.`deleted_at` IS NULL;";

        $s = $this->db->query($q)->result();
        return $s;
    }
    //______________________________________________________________________________________________________________________

    //______________________________________________________________________________________________________________________
    //Laporan Rekam Medis Persalinan Menampilkan data obat perPasien
    function _RmPersalinanObat($id_antrian){
        $q = "SELECT
                a.*,
                b.`nama_obat`,
                b.`harga_jual_obat`
            FROM
                `apotek_detail_obat` a
            LEFT JOIN
                `obats` b
                    ON
                b.`id` = a.`id_obat`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
                    AND
                a.`deleted_at` IS NULL;";


        $s = $this->db->query($q)->result();
        return $s;
    }

    //Laporan Rekam Medis Persalinan Menampilkan data Tindakan Medis perPasien
    function _RmTindakanMedisPersalinan($id_antrian){
        $q =   "SELECT
                a.*,
                b.`nama_biaya_medis`,
                b.`biaya_medis`
            FROM
                `apotek_detail_medis` a
            LEFT JOIN
                `biaya_medis` b
            ON
                b.`id` = a.`id_tindakan_medis`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
            AND
                a.`deleted_at` IS NULL;";

        $s = $this->db->query($q)->result();
        return $s;
    }
    //______________________________________________________________________________________________________________________

    //______________________________________________________________________________________________________________________
    //Laporan Rekam Medis Pemeriksaan Umum Menampilkan data obat perPasien
    function _RmUmumObat($id_antrian){
        $q = "SELECT
                a.*,
                b.`nama_obat`,
                b.`harga_jual_obat`
            FROM
                `apotek_detail_obat` a
            LEFT JOIN
                `obats` b
                    ON
                b.`id` = a.`id_obat`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
                    AND
                a.`deleted_at` IS NULL;";


        $s = $this->db->query($q)->result();
        return $s;
    }

    //Laporan Rekam Medis Pemeriksaan Umum Menampilkan data Tindakan Medis perPasien
    function _RmTindakanMedisUmum($id_antrian){
        $q =   "SELECT
                a.*,
                b.`nama_biaya_medis`,
                b.`biaya_medis`
            FROM
                `apotek_detail_medis` a
            LEFT JOIN
                `biaya_medis` b
            ON
                b.`id` = a.`id_tindakan_medis`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
            AND
                a.`deleted_at` IS NULL;";

        $s = $this->db->query($q)->result();
        return $s;
    }
    //______________________________________________________________________________________________________________________

    //______________________________________________________________________________________________________________________
    //Laporan Rekam Medis Pemeriksaan KB Menampilkan data obat perPasien
    function _RmKbObat($id_antrian){
        $q = "SELECT
                a.*,
                b.`nama_obat`,
                b.`harga_jual_obat`
            FROM
                `apotek_detail_obat` a
            LEFT JOIN
                `obats` b
                    ON
                b.`id` = a.`id_obat`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
                    AND
                a.`deleted_at` IS NULL;";


        $s = $this->db->query($q)->result();
        return $s;
    }

    //Laporan Rekam Medis Pemeriksaan KB Menampilkan data Tindakan Medis perPasien
    function _RmTindakanMedisKb($id_antrian){
        $q =   "SELECT
                a.*,
                b.`nama_biaya_medis`,
                b.`biaya_medis`
            FROM
                `apotek_detail_medis` a
            LEFT JOIN
                `biaya_medis` b
            ON
                b.`id` = a.`id_tindakan_medis`
            WHERE
                a.`id_antrian` = '". $this->db->escape_str($id_antrian) ."'
            AND
                a.`deleted_at` IS NULL;";

        $s = $this->db->query($q)->result();
        return $s;
    }
    //______________________________________________________________________________________________________________________




}