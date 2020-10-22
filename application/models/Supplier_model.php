<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_kota` FROM `suppliers` a LEFT JOIN `kotas` b ON a.`id_kota` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`nama_supplier` LIKE '%". $s ."%' OR a.`alamat_supplier` LIKE '%". $s ."%' OR a.`no_telepon` LIKE '%". $s ."%' OR a.`no_handphone` LIKE '%". $s ."%' OR a.`kontak_person` LIKE '%". $s ."%' OR a.`nama_bank` LIKE '%". $s ."%' OR a.`no_rekening` LIKE '%". $s ."%' OR a.`email` LIKE '%". $s ."%' OR a.`website` LIKE '%". $s ."%' OR b.`nama_kota` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_kota') {
                    $q .= "ORDER BY b.`nama_kota` ". $dir ." ";
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

    function edit($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => 'Data pasien tidak ditemukan.'  
        );

        $q =    "SELECT 
                    a.*,
                    b.`nama_kota`
                FROM 
                    `suppliers` a 
                LEFT JOIN
                    `kotas` b
                        ON
                    a.`id_kota` = b.`id`
                WHERE 
                    a.`id` = '". $this->db->escape_str($id) ."'
                ;";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];
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
			$q =    "INSERT INTO 
                        `suppliers` 
                        (
                            `nama_supplier`,
                            `alamat_supplier`,
                            `no_telepon`,
                            `no_handphone`,
                            `kontak_person`,
                            `nama_bank`,
                            `no_rekening`,
                            `email`,
                            `website`,
                            `id_kota`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['nama_supplier']) ."',
                            '". $this->db->escape_str($f['alamat_supplier']) ."',
                            '". $this->db->escape_str($f['no_telepon']) ."',
                            '". $this->db->escape_str($f['no_handphone']) ."',
                            '". $this->db->escape_str($f['kontak_person']) ."',
                            '". $this->db->escape_str($f['nama_bank']) ."',
                            '". $this->db->escape_str($f['no_rekening']) ."',
                            '". $this->db->escape_str($f['email']) ."',
                            '". $this->db->escape_str($f['website']) ."',
                            '". $this->db->escape_str($f['id_kota']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `suppliers` 
                    SET 
                        `nama_supplier` = '". $this->db->escape_str($f['nama_supplier']) ."', 
                        `alamat_supplier` = '". $this->db->escape_str($f['alamat_supplier']) ."', 
                        `no_telepon` = '". $this->db->escape_str($f['no_telepon']) ."', 
                        `no_handphone` = '". $this->db->escape_str($f['no_handphone']) ."', 
                        `kontak_person` = '". $this->db->escape_str($f['kontak_person']) ."', 
                        `nama_bank` = '". $this->db->escape_str($f['nama_bank']) ."', 
                        `no_rekening` = '". $this->db->escape_str($f['no_rekening']) ."',
                        `email` = '". $this->db->escape_str($f['email']) ."',
                        `website` = '". $this->db->escape_str($f['website']) ."',
                        `id_kota` = '". $this->db->escape_str($f['id_kota']) ."'
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
		$q = "UPDATE `suppliers` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_kota($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `kotas` WHERE `deleted_at` IS NULL ORDER BY `nama_kota` ASC;";
        } else{
            $q = "SELECT * FROM `kotas` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}