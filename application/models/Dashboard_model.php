<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function simpanDataPasien($data){
        $this->db->insert('pasiens',$data);
    }
    public function simpanPemeriksaanUmum($data){
         $this->db->insert('detail_pemeriksaan_umum',$data);
    }
    public function simpanPemeriksaanKb($data){
        $this->db->insert('detail_pemeriksaan_kb',$data);
    }
    public function simpanDataProgramIspa($data){
        $this->db->insert('detail_program_ispa',$data);
    }
    public function simpanDataImunisasi($data){
        $this->db->insert('detail_imunisasi',$data);
    }
    public function simpanDataPemeriksaanKehamilan($data){
        $this->db->insert('detail_pemeriksaan_kehamilan',$data);
    }
    public function simpanDataPersalinan($data){
        $this->db->insert('detail_persalinan',$data);
    }
    public function simpanAntrian($data){
        $this->db->insert('antrians',$data);
    }
    
    public function tampilPasienDilayani(){
        $tanggalSekarang = date('Y-m-d');

         $query = $this->db->query("SELECT SUBSTRING(a.tgl_antrian,1,10) ,a.*, b.`nama_dokter`, c.`nama_pasien`, d.`nama_pelayanan` 
            FROM `antrians` a LEFT JOIN `dokters` b ON a.`id_dokter` = b.`id` 
            LEFT JOIN `pasiens` c ON a.`id_pasien` = c.`id` 
            LEFT JOIN `jenis_pelayanans` d ON a.`id_jenis_pelayanan` = d.`id` 
            where status_antrian='selesai' && SUBSTRING(a.tgl_antrian,1,10)='$tanggalSekarang'  ");
          // $query = $this->db->query("SELECT a.*, b.`nama_dokter`, c.`nama_pasien`, d.`nama_pelayanan` FROM `antrians` a LEFT JOIN `dokters` b ON a.`id_dokter` = b.`id` LEFT JOIN `pasiens` c ON a.`id_pasien` = c.`id` LEFT JOIN `jenis_pelayanans` d ON a.`id_jenis_pelayanan` = d.`id` where status_antrian='selesai' ");
        return $query;
    }
    public function tampilPasienHarusDilayani(){
        //codingan dibawah digunakan untuk menampilkan semua data yang berstatus proses serta tanggal nya hari ini
        $tanggalSekarang = date('Y-m-d');
        $harusDilayani = $this->db->query("SELECT a.id,a.id_pasien,a.no_antrian,a.status_antrian,a.tgl_antrian,d.nama_dokter, p.nama_pasien, j.nama_pelayanan 
                                            FROM antrians AS a JOIN dokters AS d ON a.id_dokter = d.id 
                                            JOIN pasiens AS p ON a.id_pasien = p.id 
                                            JOIN jenis_pelayanans AS j ON a.id_jenis_pelayanan = j.id 
                                            where a.status_antrian ='proses' && SUBSTRING(a.tgl_antrian,1,10)='$tanggalSekarang'
                                            order by a.id ASC ");

        //codingan dibawah digunakan untuk menampilkan semua data yang berstatus proses
        // $harusDilayani = $this->db->query("SELECT a.id,a.id_pasien,a.no_antrian,a.status_antrian,a.tgl_antrian,d.nama_dokter, p.nama_pasien, j.nama_pelayanan 
        //                                     FROM antrians AS a JOIN dokters AS d ON a.id_dokter = d.id 
        //                                     JOIN pasiens AS p ON a.id_pasien = p.id 
        //                                     JOIN jenis_pelayanans AS j ON a.id_jenis_pelayanan = j.id 
        //                                     where a.status_antrian ='proses' 
        //                                     order by a.no_antrian ASC ");
        return $harusDilayani;
    }
    public function tampilPasienSedangDilayani(){
        //codingan dibawah digunakan untuk menampilkan semua data yang berstatus Sedang Dilayani serta tanggal nya hari ini
        $tanggalSekarang = date('Y-m-d');
        $sedangDilayani = $this->db->query("SELECT p.id as id_pasien,p.no_kk,p.nama_pj,p.alamat_pasien,p.tgl_lahir,p.jk_pasien,a.id,a.no_antrian,a.status_antrian,a.tgl_antrian,d.nama_dokter,p.nik, p.nama_pasien, j.nama_pelayanan 
                                            FROM antrians AS a JOIN dokters AS d ON a.id_dokter = d.id 
                                            JOIN pasiens AS p ON a.id_pasien = p.id 
                                            JOIN jenis_pelayanans AS j ON a.id_jenis_pelayanan = j.id 
                                            where a.status_antrian ='Sedang Dilayani' && SUBSTRING(a.tgl_antrian,1,10)='$tanggalSekarang' 
                                            order by a.no_antrian ASC ");
        //codingan dibawah digunakan untuk menampilkan semua data yang berstatus Sedang Dilayani
        //codingan yang belum di kasih filter by tanggal sekarang
        // $sedangDilayani = $this->db->query("SELECT p.id as id_pasien,p.no_kk,p.nama_suami,p.alamat_istri,p.tgl_lahir,p.jk_pasien,a.id,a.no_antrian,a.status_antrian,a.tgl_antrian,d.nama_dokter,p.nik, p.nama_pasien, j.nama_pelayanan 
        //                                     FROM antrians AS a JOIN dokters AS d ON a.id_dokter = d.id 
        //                                     JOIN pasiens AS p ON a.id_pasien = p.id 
        //                                     JOIN jenis_pelayanans AS j ON a.id_jenis_pelayanan = j.id 
        //                                     where a.status_antrian ='Sedang Dilayani' 
        //                                     order by a.no_antrian ASC ");
        return $sedangDilayani;
    }
    
    public function updateAntrian($id,$data){
        $this->db->update('antrians',$data,array('id'=>$id));
    }
    public function updateNoKk($id,$kk){
        $this->db->update('pasiens',$kk,array('id'=>$id));
    }
    public function counterKunjungan(){
        $tanggalSekarang = date('yy-m-d');
        $hitungPengunjung = $this->db->query("SELECT COUNT( SUBSTRING(tgl_antrian,1,10) ) as kunjungan FROM antrians 
                            where SUBSTRING(tgl_antrian,1,10)='$tanggalSekarang'");
        return $hitungPengunjung;
    }
    public function getJenisPenyakit(){
        $penyakit= $this->db->get('jenis_penyakit');
        return $penyakit;
    }
    
    public function getJenisPelayanan(){
        return $this->db->get('jenis_pelayanans')->result_array();
    }
    public function getNoPelayanan($idpelayanan)
    {
        $dateNow=date('yy-m-d');
        return $this->db->query("SELECT * FROM antrians WHERE id_jenis_pelayanan LIKE '$idpelayanan' and tgl_antrian LIKE '$dateNow%' ORDER BY no_antrian DESC LIMIT 1")->result();
    }


    public function getPasien(){
        $pasien = $this->db->get('pasiens');
        return $pasien;
    }
    public function getDokter(){
        $dokter = $this->db->get('dokters');
        return $dokter;
    }
  
    public function getRentangUmur(){
        $rUmur = $this->db->get('rentang_umur');
        return $rUmur;
    }
    public function getTindakan(){
        $tindakan = $this->db->get('macam_tindakan_imunisasi');
        return $tindakan;
    }
    public function getSatuanUsia(){
        $satuanUsia = $this->db->get('satuan_usia');
        return $satuanUsia;
    }
    public function getAlatKontrasepsi(){
        $alatKontra= $this->db->get('alat_kontrasepsi');
        return $alatKontra;
    }
    public function getBbLahir($kirimIdPasien){
         //echo $kirimIdPasien;
        $id=$kirimIdPasien;
         $bbLahir=$this->db->query("SELECT * FROM detail_imunisasi where id_pasien='$id' group by id_pasien")->result();
         // var_dump($bbLahir);
         return $bbLahir;
    }
    public function getJmlAnak($idPasienKb){
        // echo $idPasienKb;
        $jmlAnak = $this->db->query("SELECT * FROM detail_pemeriksaan_kb where id_pasien='$idPasienKb'  ORDER BY id DESC limit 1")->result();
        // $jmlAnak = $this->db->query("SELECT * FROM detail_pemeriksaan_kb where id_pasien='$idPasienKb' group by id_pasien")->result();
        // var_dump($JmlAnak);
        return $jmlAnak;
    }
    public function getKodeAntrian(){
        $kdAntrian = $this->db->query("SELECT kode_antrian FROM antrians order by id DESC LIMIT 1 ");
        return $kdAntrian;
    }

    
}