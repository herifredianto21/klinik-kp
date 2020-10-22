<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_kota` FROM `dokters` a LEFT JOIN `kotas` b ON a.`id_kota` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_kota` LIKE '%". $s ."%' OR a.`nama_dokter` LIKE '%". $s ."%' OR a.`spesialisasi` LIKE '%". $s ."%' OR a.`nik` LIKE '%". $s ."%' OR a.`alamat_dokter` LIKE '%". $s ."%' OR a.`no_hp_dokter` LIKE '%". $s ."%' OR a.`email_dokter` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_kota') {
                    $q .= "ORDER BY b.`". $col ."` ". $dir ." ";
                } else{
                    $q .= "ORDER BY a.`". $col ."` ". $dir ." ";
                }
        	} else{
        		$q .= "ORDER BY a.`id` ". $dir ." ";
        	}
        } else{
        	$q .= "ORDER BY a.`id` DESC ";
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

    function get_cid()
    {
        $q = "SELECT * FROM `dokters` ORDER BY `id` DESC LIMIT 1;";
        $r = $this->db->query($q, false)->result_array();

        $cid = 1;
        if (count($r) > 0) {
            $cid = $r[0]['id'] + 1;
        }

        return $cid;
    }

	function save($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

        $cid = $this->get_cid();

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		parse_str($d['form'], $f);
		$q = '';
		if ($id == 0) {
			$q = "INSERT INTO `dokters` (`created_at`, `nama_dokter`, `spesialisasi`, `nik`, `alamat_dokter`, `no_hp_dokter`, `email_dokter`, `id_kota`, `context_id`) VALUES (NOW(), '". $this->db->escape_str($f['nama_dokter']) ."', '". $this->db->escape_str($f['spesialisasi']) ."', '". $this->db->escape_str($f['nik']) ."', '". $this->db->escape_str($f['alamat_dokter']) ."', '". $this->db->escape_str($f['no_hp_dokter']) ."', '". $this->db->escape_str($f['email_dokter']) ."', '". $this->db->escape_str($f['id_kota']) ."', '". $cid ."');";
		} else{
			$q = "UPDATE `dokters` SET `updated_at` = NOW(), `nama_dokter` = '". $this->db->escape_str($f['nama_dokter']) ."', `spesialisasi` = '". $this->db->escape_str($f['spesialisasi']) ."', `nik` = '". $this->db->escape_str($f['nik']) ."', `alamat_dokter` = '". $this->db->escape_str($f['alamat_dokter']) ."', `no_hp_dokter` = '". $this->db->escape_str($f['no_hp_dokter']) ."', `email_dokter` = '". $this->db->escape_str($f['email_dokter']) ."', `id_kota` = '". $this->db->escape_str($f['id_kota']) ."' WHERE `id` = '". $this->db->escape_str($id) ."';";
		}
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil disimpan.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menyimpan data.';
		}

		return $result;
	}

	function delete($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		$q = "UPDATE `dokters` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_kota()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `kotas` WHERE `deleted_at` IS NULL ORDER BY `nama_kota` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}