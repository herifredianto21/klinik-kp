<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {

    public function tampilDataPasien(){
        $tPasien = $this->db->query("SELECT * FROM pasiens WHERE deleted_at IS NULL");
        return $tPasien;
    }
    public function getDataKunjungan($id){
        $query = $this->db->query("SELECT * FROM pasiens WHERE id='$id'");
        return $query;
    }
    public function getDokter(){
        $tDokter = $this->db->get('dokters');
        return $tDokter;
    }

    public function getJmlAnak($idPasien){
        $jmlAnak = $this->db->query("SELECT * FROM detail_pemeriksaan_kb where id_pasien='$idPasien'  ORDER BY id DESC limit 1");
        return $jmlAnak;
    }

    public function getJenisPelayanan(){
        return $this->db->get('jenis_pelayanans')->result_array();
    }

    public function getAlatKontrasepsi(){
        $alatKontra= $this->db->get('alat_kontrasepsi');
        return $alatKontra;
    }

    public function getNoPelayanan($idpelayanan)
    {
        $dateNow=date('yy-m-d');
        return $this->db->query("SELECT * FROM antrians WHERE id_jenis_pelayanan LIKE '$idpelayanan' and tgl_antrian LIKE '$dateNow%' ORDER BY no_antrian DESC LIMIT 1")->result();
    }

    public function getKodeAntrian(){
        $kdAntrian = $this->db->query("SELECT kode_antrian,id FROM antrians order by id DESC LIMIT 1 ");
        return $kdAntrian;
    }
    public function getNoRegis(){
        $tNoRegis=$this->db->query("SELECT * FROM pasiens ORDER BY id DESC LIMIT 1");
        return $tNoRegis;
    }
    public function getPekerjaan(){
        $tPekerjaan=$this->db->get('pekerjaans');
        return $tPekerjaan;
    }
    public function getKota(){
        $tKota=$this->db->get('kotas');
        return $tKota;
    }
    public function getDesa(){
        $tDesa = $this->db->get('desas');
        return $tDesa;
    }
    public function getBbLahir($idPasien){
        $gBb = $this->db->query("SELECT * FROM detail_imunisasi where id_pasien='$idPasien' group by id_pasien");
        return $gBb;
    }
    public function getTindakanImunisasi(){
        $gTi = $this->db->get('macam_tindakan_imunisasi');
        return $gTi;
    }
    public function getDaftarPenyakit(){
        $gDp = $this->db->get('jenis_penyakit');
        return $gDp;
    }
    public function getRentangUmur(){
        $gRu = $this->db->get('rentang_umur');
        return $gRu;
    }
     public function updateNoKk($id,$kk){
        $this->db->update('pasiens',$kk,array('id'=>$id));
    }
    public function simpanAntrian($data){
       $this->db->insert('antrians',$data);
    }
    public function simpanPemeriksaanKehamilan($data){
        $this->db->insert('detail_pemeriksaan_kehamilan',$data);
    }
    public function simpanDataImunisasi($data){
        $this->db->insert('detail_imunisasi',$data);
    }
    public function simpanDataPersalinan($data){
        $this->db->insert('detail_persalinan',$data);
    }
    public function simpanPemeriksaanUmum($data){
        $this->db->insert('detail_pemeriksaan_umum',$data);
    }
    public function simpanDataProgramIspa($data){
        $this->db->insert('detail_program_ispa',$data);
    }
    public function simpanPemeriksaanKb($data){
        $this->db->insert('detail_pemeriksaan_kb',$data);
    }
    public function simpanDataPasien($data){
        $sPasien=$this->db->insert('pasiens',$data);
    }
    public function getDataPasien($id){
        $gDataPasien = $this->db->query("SELECT * FROM pasiens WHERE id='$id'");
        return $gDataPasien;
    }

    public function hapusDataPasien($id,$data)
    {
        $this->db->update('pasiens',$data, array('id' => $id));
    }
     public function editDataPasien($id,$data)
    {
        $this->db->update('pasiens',$data, array('id' => $id));
    }


    public function getDataHistory($id){
        $gDataHistory = $this->db->query("SELECT a.id, a.tgl_antrian, jp.nama_pelayanan, a.id_jenis_pelayanan FROM antrians as a INNER JOIN jenis_pelayanans as jp ON a.id_jenis_pelayanan =jp.id where a.id_pasien ='$id'");
        return $gDataHistory;
    }
}
