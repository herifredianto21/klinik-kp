<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekam_medis_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_pasien`, b.`no_registrasi`, c.`nama_pelayanan` FROM `antrians` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `jenis_pelayanans` c ON a.`id_jenis_pelayanan` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`tgl_antrian` LIKE '%". $s ."%' OR b.`nama_pasien` LIKE '%". $s ."%' OR c.`nama_pelayanan` LIKE '%". $s ."%' OR b.`no_registrasi` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'no_registrasi') {
                    $q .= "ORDER BY b.`no_registrasi` ". $dir ." ";
                } elseif ($col == 'nama_pasien') {
                    $q .= "ORDER BY b.`nama_pasien` ". $dir ." ";
                } elseif ($col == 'nama_pelayanan') {
                    $q .= "ORDER BY c.`nama_pelayanan` ". $dir ." ";
                } else {
                    $q .= "ORDER BY a.`". $col ."` ". $dir ." ";
                }
        	} else{
        		$q .= "ORDER BY a.`tgl_antrian` DESC ";
        	}
        } else{
        	$q .= "ORDER BY a.`tgl_antrian` DESC ";
        }

        return $q;
    }

    function _list($data = array())
    {
        $q = $this->_get($data);
        $q .= "LIMIT ". $this->db->escape_str($data['start']) .", ". $this->db->escape_str($data['length']);
        $r = $this->db->query($q, false)->result_array();
        
        return $r;
    }

    function _filtered($data = array())
    {
        $q = $this->_get($data);
        $r = $this->db->query($q, false)->result_array();
        
        return count($r);
    }

    function _all($data = array())
    {
        $data['all'] = true;
        $q = $this->_get($data);
        $r = $this->db->query($q)->result_array();
        
        return count($r);
    }
    
	function datatable($data = array())
	{
		$result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all($data),
                'recordsFiltered'   => $this->_filtered($data),
                'data'              => $list,
                'result'            => true,
                'msg'               => 'Loaded.',
                'start'             => (int) $data['start'] + 1
            );
        } else{
            $result['msg'] = 'No data left.';
        }

        return $result;
	}

	function detail($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		$q = "SELECT * FROM `antrians` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `jenis_pelayanans` c ON a.`id_jenis_pelayanan` = c.`id` LEFT JOIN `detail_pemeriksaan_umum` d ON a.`id` = d.`id_antrian` WHERE a.`id` = '". $this->db->escape_str($id) ."';";
        $r = $this->db->query($q, false)->result_array();
		if (count($r) > 0) {
			$result['result'] = true;
			$result['detail'] = $r[0];

            $q = "SELECT b.`nama_obat`, a.`qty` AS `qty_jual`, c.`nama_satuan` FROM `apotek_detail_obat` a LEFT JOIN `obats` b ON b.`id` = a.`id_obat` LEFT JOIN `satuans` c ON c.`id` = b.`id_satuan` WHERE a.`id_antrian` = '". $this->db->escape_str($id) ."' ";
            $r = $this->db->query($q, false)->result_array();
            $result['obat'] = $r;
		} else{
			$result['msg'] = 'Data detail tidak tersedia.';
		}

		return $result;
	}

}