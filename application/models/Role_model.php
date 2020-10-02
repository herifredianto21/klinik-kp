<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`name` AS `department_name`, c.`name` AS `parent_name` FROM `roles` a LEFT JOIN `departments` b ON a.`dept` = b.`id` LEFT JOIN `roles` c ON a.`parent` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
            $s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (c.`name` LIKE '%". $s ."%' OR b.`name` LIKE '%". $s ."%' OR a.`name` LIKE '%". $s ."%' OR a.`display_name` LIKE '%". $s ."%' OR a.`description` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
            $q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
            $dir = $this->db->escape_str($data['order'][0]['dir']);
            $col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
            if ($data['order'][0]['column'] != 0) {
                if ($col == 'parent_name') {
                    $q .= "ORDER BY c.`name` ". $dir ." ";
                } elseif ($col == 'department_name') {
                    $q .= "ORDER BY b.`name` ". $dir ." ";
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
			$q = "INSERT INTO `roles` (`created_at`, `name`, `display_name`, `description`, `parent`, `dept`) VALUES (NOW(), '". $this->db->escape_str($f['name']) ."', '". $this->db->escape_str($f['display_name']) ."', '". $this->db->escape_str($f['description']) ."', '". $this->db->escape_str($f['id_parent']) ."', '". $this->db->escape_str($f['id_dept']) ."');";
		} else{
            $q = "UPDATE `roles` SET `updated_at` = NOW(), `name` = '". $this->db->escape_str($f['name']) ."', `display_name` = '". $this->db->escape_str($f['display_name']) ."', `description` = '". $this->db->escape_str($f['description']) ."', `parent` = '". $this->db->escape_str($f['id_parent']) ."', `dept` = '". $this->db->escape_str($f['id_dept']) ."' WHERE `id` = '". $this->db->escape_str($id) ."';";
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
		$q = "UPDATE `roles` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_parent()
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

}