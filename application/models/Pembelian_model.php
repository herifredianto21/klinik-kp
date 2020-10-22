<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_supplier`, c.`name` FROM `pembelians` a LEFT JOIN `suppliers` b ON a.`id_supplier` = b.`id` LEFT JOIN `users` c ON a.`id_users` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`no_faktur` LIKE '%". $s ."%' OR a.`jenis_pembelian` LIKE '%". $s ."%' OR a.`tgl_beli` LIKE '%". $s ."%' OR b.`nama_supplier` LIKE '%". $s ."%' OR c.`name` LIKE '%". $s ."%' OR a.`total_harga_beli` LIKE '%". $s ."%' OR a.`diskon_pembelian` LIKE '%". $s ."%' OR a.`status_pembelian` LIKE '%". $s ."%' OR a.`tgl_bayar` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_supplier') {
                    $q .= "ORDER BY b.`nama_supplier` ". $dir ." ";
                } elseif ($col == 'name') {
                    $q .= "ORDER BY c.`name` ". $dir ." ";
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
            'msg'       => 'Data pembelian tidak ditemukan.'  
        );

        $q =    "SELECT 
                    a.*,
                    b.`nama_supplier`,
                    c.`name`
                FROM 
                    `pembelians` a 
                LEFT JOIN
                    `suppliers` b
                        ON
                    a.`id_supplier` = b.`id`
                LEFT JOIN
                    `users` c
                        ON
                    a.`id_users` = c.`id`
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
        $s = $u['session'];
		$d = $data['postData'];
		$id = $d['id'];
		parse_str($d['form'], $f);

		$q = '';
		if ($id == 0) {
			$q =    "INSERT INTO 
                        `pembelians` 
                        (
                            `no_faktur`,
                            `jenis_pembelian`,
                            `tgl_beli`,
                            `id_supplier`,
                            `id_users`,
                            `status_pembelian`,
                            `tgl_bayar`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['no_faktur']) ."',
                            '". $this->db->escape_str($f['jenis_pembelian']) ."',
                            '". $this->db->escape_str($f['tgl_beli']) ."',
                            '". $this->db->escape_str($f['id_supplier']) ."',
                            '". $this->db->escape_str($s['id']) ."',
                            '". $this->db->escape_str($f['status_pembelian']) ."',
                            '". $this->db->escape_str($f['tgl_bayar']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `pembelians` 
                    SET 
                        `no_faktur` = '". $this->db->escape_str($f['no_faktur']) ."', 
                        `jenis_pembelian` = '". $this->db->escape_str($f['jenis_pembelian']) ."', 
                        `tgl_beli` = '". $this->db->escape_str($f['tgl_beli']) ."',
                        `id_supplier` = '". $this->db->escape_str($f['id_supplier']) ."',
                        `status_pembelian` = '". $this->db->escape_str($f['status_pembelian']) ."',
                        `tgl_bayar` = '". $this->db->escape_str($f['tgl_bayar']) ."'
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
		$q = "UPDATE `pembelians` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_supplier($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `suppliers` WHERE `deleted_at` IS NULL ORDER BY `nama_supplier` ASC;";
        } else{
            $q = "SELECT * FROM `suppliers` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}