<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT * FROM `users` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (`name` LIKE '%". $s ."%' OR `email` LIKE '%". $s ."%' OR `type` LIKE '%". $s ."%' OR `nik` LIKE '%". $s ."%') AND `deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE `deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                $q .= "ORDER BY `". $col ."` ". $dir ." ";
        	} else{
        		$q .= "ORDER BY `id` ". $dir ." ";
        	}
        } else{
        	$q .= "ORDER BY `id` DESC ";
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

    function check_email($data = array())
    {
        $result = false;

        $q = "SELECT * FROM `users` WHERE `email` = '". $data['email'] ."';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result = true;
        }

        return $result;

    }

    function get_cid()
    {
        $q = "SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1;";
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

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		parse_str($d['form'], $f);

        $isRegistered = $this->check_email($f);
        if ($isRegistered) {
            $result['msg'] = 'E-Mail sudah terdaftar.';
            return $result;
        }

        $cid = $this->get_cid();

		$q = '';
		if ($id == 0) {
            $f['password'] = md5($f['password']);
			$q = "INSERT INTO `users` (`created_at`, `name`, `context_id`, `email`, `password`, `type`, `nik`) VALUES (NOW(), '". $this->db->escape_str($f['name']) ."', '". $cid ."', '". $this->db->escape_str($f['email']) ."', '". $this->db->escape_str($f['password']) ."', '". $this->db->escape_str($f['type']) ."', '". $this->db->escape_str($f['nik']) ."');";
		} else{
            if (count($f['password']) > 0) {
                $f['password'] = md5($f['password']);
                $q = "UPDATE `users` SET `updated_at` = NOW(), `name` = '". $this->db->escape_str($f['name']) ."', `email` = '". $this->db->escape_str($f['email']) ."', `password` = '". $this->db->escape_str($f['password']) ."', `type` = '". $this->db->escape_str($f['type']) ."', `nik` = '". $this->db->escape_str($f['nik']) ."' WHERE `id` = '". $this->db->escape_str($id) ."';";
            } else{
                $q = "UPDATE `users` SET `updated_at` = NOW(), `name` = '". $this->db->escape_str($f['name']) ."', `email` = '". $this->db->escape_str($f['email']) ."', `type` = '". $this->db->escape_str($f['type']) ."', `nik` = '". $this->db->escape_str($f['nik']) ."' WHERE `id` = '". $this->db->escape_str($id) ."';";
            }
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
		$q = "UPDATE `users` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

}