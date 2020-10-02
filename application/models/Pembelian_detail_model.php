<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_detail_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`no_faktur`, c.`nama_obat` FROM `pembelian_details` a LEFT JOIN `pembelians` b ON a.`id_pembelian` = b.`id` LEFT JOIN `obats` c ON a.`id_obat` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`qty_beli` LIKE '%". $s ."%' OR a.`harga_beli_obat` LIKE '%". $s ."%' OR a.`harga_jual_obat` LIKE '%". $s ."%' OR a.`nama_obat` LIKE '%". $s ."%' OR b.`no_faktur` LIKE '%". $s ."%' OR c.`nama_obat` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        $idPembelian = $this->session->userdata('idPembelian');
        if ($idPembelian != 0) {
            $q .= "AND a.`id_pembelian` = '". $idPembelian ."' ";
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
            'msg'       => 'Data detail pembelian tidak ditemukan.'  
        );

        $q =    "SELECT 
                    a.*,
                    b.`no_faktur`,
                    c.`nama_obat`
                FROM 
                    `pembelian_details` a 
                LEFT JOIN
                    `pembelians` b
                        ON
                    a.`id_pembelian` = b.`id`
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
        $idPembelian = $f['id_pembelian'];

		$q = '';
		if ($id == 0) {
			$q =    "INSERT INTO 
                        `pembelian_details` 
                        (
                            `id_pembelian`,
                            `id_obat`,
                            `qty_beli`,
                            `harga_beli_obat`,
                            `harga_jual_obat`,
                            `nama_obat`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['id_pembelian']) ."',
                            '". $this->db->escape_str($f['id_obat']) ."',
                            '". $this->db->escape_str($f['qty_beli']) ."',
                            '". $this->db->escape_str($f['harga_beli_obat']) ."',
                            '". $this->db->escape_str($f['harga_jual_obat']) ."',
                            '". $this->db->escape_str($f['nama_obat']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `pembelian_details` 
                    SET 
                        `id_pembelian` = '". $this->db->escape_str($f['id_pembelian']) ."', 
                        `id_obat` = '". $this->db->escape_str($f['id_obat']) ."', 
                        `qty_beli` = '". $this->db->escape_str($f['qty_beli']) ."',
                        `harga_beli_obat` = '". $this->db->escape_str($f['harga_beli_obat']) ."',
                        `harga_jual_obat` = '". $this->db->escape_str($f['harga_jual_obat']) ."',
                        `nama_obat` = '". $this->db->escape_str($f['nama_obat']) ."'
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
		}

		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil disimpan.';

            $q = "SELECT * FROM `pembelian_details` WHERE `id_pembelian` = '". $this->db->escape_str($idPembelian) ."' AND `deleted_at` IS NULL;";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $total = 0;
                for ($i=0; $i < count($r); $i++) { 
                    $total += $r[$i]['qty_beli'] * $r[$i]['harga_beli_obat'];
                }

                $q = "UPDATE `pembelians` SET `total_harga_beli` = '". $total ."' WHERE `id` = '". $this->db->escape_str($idPembelian) ."';";
                $this->db->simple_query($q);
            }

            // $q = "SELECT * FROM `obats` WHERE `id` = '". $this->db->escape_str($f['id_obat']) ."' AND `deleted_at` = IS NULL;";
            // $r = $this->db->query($q, false)->result_array();
            // if (count($r > 0)) {
            //     $q = "UPDATE `obats` SET `stok` = '". intval($f['qty_beli']) + intval($r[0]['stok']) ."' WHERE `id` = '". $this->db->escape_str($f['id_obat']) ."';";
            //     $this->db->simple_query($q);
            // }
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
		$q = "UPDATE `pembelian_details` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';

            $q = "SELECT * FROM `pembelian_details` WHERE `id` = '". $this->db->escape_str($id) ."';";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $idPembelian = $r[0]['id_pembelian'];
                $q = "SELECT * FROM `pembelian_details` WHERE `id_pembelian` = '". $idPembelian ."' AND `deleted_at` IS NULL;";
                $r = $this->db->query($q)->result_array();
                $total = 0.00;
                if (count($r) > 0) {
                    for ($i=0; $i < count($r); $i++) { 
                        $total += $r[$i]['qty_beli'] * $r[$i]['harga_beli_obat'];
                    }
                }
                $q = "UPDATE `pembelians` SET `total_harga_beli` = '". $total ."' WHERE `id` = '". $this->db->escape_str($idPembelian) ."';";
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
            $q = "SELECT * FROM `pembelians` WHERE `deleted_at` IS NULL ORDER BY `no_faktur` DESC;";
        } else{
            $q = "SELECT * FROM `pembelians` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
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