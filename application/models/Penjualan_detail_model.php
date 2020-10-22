<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_detail_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`no_faktur`, c.`nama_obat` FROM `penjualan_details` a LEFT JOIN `penjualans` b ON a.`id_penjualan` = b.`id` LEFT JOIN `obats` c ON a.`id_obat` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`nama_obat_jual` LIKE '%". $s ."%' OR a.`harga_jual_penjualan` LIKE '%". $s ."%' OR a.`harga_beli_penjualan` LIKE '%". $s ."%' OR a.`qty_jual` LIKE '%". $s ."%' OR b.`no_faktur` LIKE '%". $s ."%' OR c.`nama_obat` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        $idPenjualan = $this->session->userdata('idPenjualan');
        if ($idPenjualan != 0) {
            $q .= "AND a.`id_penjualan` = '". $idPenjualan ."' ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'no_faktur') {
                    $q .= "ORDER BY b.`no_faktur` ". $dir ." ";
                } elseif ($col == 'nama_obat') {
                    $q .= "ORDER BY c.`nama_obat` ". $dir ." ";
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
            'msg'       => 'Data detail penjualan tidak ditemukan.'  
        );

        $q =    "SELECT 
                    a.*,
                    b.`no_faktur`,
                    c.`nama_obat`
                FROM 
                    `penjualan_details` a 
                LEFT JOIN
                    `penjualans` b
                        ON
                    a.`id_penjualan` = b.`id`
                LEFT JOIN
                    `obats` c
                        ON
                    a.`id_obat` = c.`id`
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
        $idPenjualan = $f['id_penjualan'];

		$q = '';
		if ($id == 0) {
			$q =    "INSERT INTO 
                        `penjualan_details` 
                        (
                            `id_penjualan`,
                            `nama_obat_jual`,
                            `harga_jual_penjualan`,
                            `harga_beli_penjualan`,
                            `qty_jual`,
                            `id_obat`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['id_penjualan']) ."',
                            '". $this->db->escape_str($f['nama_obat_jual']) ."',
                            '". $this->db->escape_str($f['harga_jual_penjualan']) ."',
                            '". $this->db->escape_str($f['harga_beli_penjualan']) ."',
                            '". $this->db->escape_str($f['qty_jual']) ."',
                            '". $this->db->escape_str($f['id_obat']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `penjualan_details` 
                    SET 
                        `id_penjualan` = '". $this->db->escape_str($f['id_penjualan']) ."', 
                        `nama_obat_jual` = '". $this->db->escape_str($f['nama_obat_jual']) ."', 
                        `harga_jual_penjualan` = '". $this->db->escape_str($f['harga_jual_penjualan']) ."',
                        `harga_beli_penjualan` = '". $this->db->escape_str($f['harga_beli_penjualan']) ."',
                        `qty_jual` = '". $this->db->escape_str($f['qty_jual']) ."',
                        `id_obat` = '". $this->db->escape_str($f['id_obat']) ."'
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
		}

		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil disimpan.';

            $q = "SELECT * FROM `penjualan_details` WHERE `id_penjualan` = '". $this->db->escape_str($idPenjualan) ."' AND `deleted_at` IS NULL;";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $total = 0;
                for ($i=0; $i < count($r); $i++) { 
                    $total += $r[$i]['qty_jual'] * $r[$i]['harga_jual_penjualan'];
                }

                $q = "UPDATE `penjualans` SET `total_penjualan` = '". $total ."' WHERE `id` = '". $this->db->escape_str($idPenjualan) ."';";
                $this->db->simple_query($q);
            }
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
		$q = "UPDATE `penjualan_details` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';

            $q = "SELECT * FROM `penjualan_details` WHERE `id` = '". $this->db->escape_str($id) ."';";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $idPenjualan = $r[0]['id_penjualan'];
                $q = "SELECT * FROM `penjualan_details` WHERE `id_penjualan` = '". $idPenjualan ."' AND `deleted_at` IS NULL;";
                $r = $this->db->query($q)->result_array();
                $total = 0.00;
                if (count($r) > 0) {
                    for ($i=0; $i < count($r); $i++) { 
                        $total += $r[$i]['qty_jual'] * $r[$i]['harga_jual_penjualan'];
                    }
                }
                $q = "UPDATE `penjualans` SET `total_penjualan` = '". $total ."' WHERE `id` = '". $this->db->escape_str($idPenjualan) ."';";
                $this->db->simple_query($q);
            }
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_no_faktur($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `penjualans` WHERE `deleted_at` IS NULL ORDER BY `no_faktur` DESC;";
        } else{
            $q = "SELECT * FROM `penjualans` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function select_obat($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `obats` WHERE `deleted_at` IS NULL ORDER BY `nama_obat` ASC;";
        } else{
            $q = "SELECT * FROM `obats` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function input_detail_obat($data = array())
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $u = $data['userData'];
        $d = $data['postData'];

        $q = "SELECT * FROM `obats` WHERE `id` = '". $this->db->escape_str($d['id_obat']) ."';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];
        }

        return $result;
    }

}