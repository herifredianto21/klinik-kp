<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_asuransi_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.`id`, a.`nama_kelas`, a.`limit_biaya`, b.`nama_asuransi` FROM `kelas` a LEFT JOIN `asuransies` b ON a.`id_asuransi` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_asuransi` LIKE '%". $s ."%' OR a.`nama_kelas` LIKE '%". $s ."%' OR a.`limit_biaya` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_asuransi') {
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

	function save($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		parse_str($d['form'], $f);
		$q = '';
		if ($id == 0) {
			$q = "INSERT INTO `kelas` (`created_at`, `nama_kelas`, `limit_biaya`, `id_asuransi`) VALUES (NOW(), '". $this->db->escape_str($f['nama_kelas']) ."', '". $this->db->escape_str($f['limit_biaya']) ."', '". $this->db->escape_str($f['id_asuransi']) ."');";
		} else{
			$q = "UPDATE `kelas` SET `updated_at` = NOW(), `nama_kelas` = '". $this->db->escape_str($f['nama_kelas']) ."', `limit_biaya` = '". $this->db->escape_str($f['limit_biaya']) ."', `id_asuransi` = '". $this->db->escape_str($f['id_asuransi']) ."' WHERE `id` = '". $this->db->escape_str($id) ."';";
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
		$q = "UPDATE `kelas` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_asuransi()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `asuransies` WHERE `deleted_at` IS NULL ORDER BY `nama_asuransi` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}