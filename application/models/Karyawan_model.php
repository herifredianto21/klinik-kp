<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`name` AS `department_name`, c.`name` AS `role_name`, d.`nama_kota` FROM `employees` a LEFT JOIN `departments` b ON a.`dept` = b.`id` LEFT JOIN `roles` c ON a.`role` = c.`id` LEFT JOIN `kotas` d ON a.`city` = d.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`name` LIKE '%". $s ."%' OR a.`gender` LIKE '%". $s ."%' OR a.`mobile` LIKE '%". $s ."%' OR a.`email` LIKE '%". $s ."%' OR b.`name` LIKE '%". $s ."%' OR d.`nama_kota` LIKE '%". $s ."%' OR a.`address` LIKE '%". $s ."%' OR a.`date_birth` LIKE '%". $s ."%' OR a.`spesialisasi` LIKE '%". $s ."%' OR a.`jenis_karyawan` LIKE '%". $s ."%' OR a.`nik` LIKE '%". $s ."%' OR c.`name` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'department_name') {
                    $q .= "ORDER BY b.`name` ". $dir ." ";
                } elseif ($col == 'role_name') {
                    $q .= "ORDER BY c.`name` ". $dir ." ";
                } elseif ($col == 'nama_kota') {
                    $q .= "ORDER BY d.`nama_kota` ". $dir ." ";
                } else {
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

		$q = '';
		if ($id == 0) {
			$q =    "INSERT INTO 
                        `employees` 
                        (
                            `name`,
                            `gender`,
                            `mobile`,
                            `email`,
                            `dept`,
                            `city`,
                            `address`,
                            `date_birth`,
                            `spesialisasi`,
                            `jenis_karyawan`,
                            `nik`,
                            `role`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['name']) ."',
                            '". $this->db->escape_str($f['jenis_kelamin']) ."',
                            '". $this->db->escape_str($f['mobile']) ."',
                            '". $this->db->escape_str($f['email']) ."',
                            '". $this->db->escape_str($f['dept']) ."',
                            '". $this->db->escape_str($f['city']) ."',
                            '". $this->db->escape_str($f['address']) ."',
                            '". $this->db->escape_str($f['date_birth']) ."',
                            '". $this->db->escape_str($f['spesialisasi']) ."',
                            '". $this->db->escape_str($f['jenis_karyawan']) ."',
                            '". $this->db->escape_str($f['nik']) ."',
                            '". $this->db->escape_str($f['role']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `employees` 
                    SET 
                        `name` = '". $this->db->escape_str($f['name']) ."', 
                        `gender` = '". $this->db->escape_str($f['jenis_kelamin']) ."', 
                        `mobile` = '". $this->db->escape_str($f['mobile']) ."', 
                        `email` = '". $this->db->escape_str($f['email']) ."', 
                        `dept` = '". $this->db->escape_str($f['dept']) ."', 
                        `city` = '". $this->db->escape_str($f['city']) ."', 
                        `address` = '". $this->db->escape_str($f['address']) ."', 
                        `date_birth` = '". $this->db->escape_str($f['date_birth']) ."', 
                        `spesialisasi` = '". $this->db->escape_str($f['spesialisasi']) ."', 
                        `jenis_karyawan` = '". $this->db->escape_str($f['jenis_karyawan']) ."', 
                        `nik` = '". $this->db->escape_str($f['nik']) ."', 
                        `role` = '". $this->db->escape_str($f['role']) ."'
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
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
		$q = "UPDATE `employees` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_department()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `departments` WHERE `deleted_at` IS NULL ORDER BY `name` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
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

    function select_role()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `roles` WHERE `deleted_at` IS NULL ORDER BY `name` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function input_nik()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $d = date('Ymd');
        $q = "SELECT COUNT(*) AS `total` FROM `employees` WHERE `nik` LIKE '". $d ."%';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $total = $r[0]['total'] + 1;
            $result['value'] = $d . str_pad($total, 4, '0', STR_PAD_LEFT);
        }

        return $result;
    }

}