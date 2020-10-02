<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`no_faktur` FROM `pembayarans` a LEFT JOIN `penjualans` b ON a.`id_penjualan` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`no_faktur` LIKE '%". $s ."%' OR a.`jenis_diskon` LIKE '%". $s ."%' OR a.`total_diskon` LIKE '%". $s ."%' OR a.`status_pembayaran` LIKE '%". $s ."%' OR a.`total_bayar` LIKE '%". $s ."%' OR a.`cash` LIKE '%". $s ."%' OR a.`tgl_bayar` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'no_faktur') {
                    $q .= "ORDER BY b.`no_faktur` ". $dir ." ";
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
            'msg'       => 'Data detail pembayaran tidak ditemukan.'  
        );

        $q =    "SELECT 
                    a.*,
                    b.`no_faktur`
                FROM 
                    `pembayarans` a 
                LEFT JOIN
                    `penjualans` b
                        ON
                    a.`id_penjualan` = b.`id`
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
        $statusPembayaran = $f['status_pembayaran'];

		$q = '';
		if ($id == 0) {
			$q =    "INSERT INTO 
                        `pembayarans` 
                        (
                            `id_penjualan`,
                            `jenis_diskon`,
                            `total_diskon`,
                            `total_bayar`,
                            `status_pembayaran`,
                            `cash`,
                            `tgl_bayar`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['id_penjualan']) ."',
                            '". $this->db->escape_str($f['jenis_diskon']) ."',
                            '". $this->db->escape_str($f['total_diskon']) ."',
                            '". $this->db->escape_str($f['total_bayar']) ."',
                            '". $this->db->escape_str($f['status_pembayaran']) ."',
                            '". $this->db->escape_str($f['cash']) ."',
                            '". $this->db->escape_str($f['tgl_bayar']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `pembayarans` 
                    SET 
                        `id_penjualan` = '". $this->db->escape_str($f['id_penjualan']) ."', 
                        `jenis_diskon` = '". $this->db->escape_str($f['jenis_diskon']) ."', 
                        `total_bayar` = '". $this->db->escape_str($f['total_diskon']) ."',
                        `total_bayar` = '". $this->db->escape_str($f['total_bayar']) ."',
                        `status_pembayaran` = '". $this->db->escape_str($f['status_pembayaran']) ."',
                        `cash` = '". $this->db->escape_str($f['cash']) ."',
                        `tgl_bayar` = '". $this->db->escape_str($f['tgl_bayar']) ."'
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
		}

		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil disimpan.';

            if ($statusPembayaran == 'Selesai') {
                $q = "UPDATE `penjualans` SET `cash` = '". $this->db->escape_str($f['cash']) ."', `status_penjualan` = 'Selesai' WHERE `id` = '". $this->db->escape_str($idPenjualan) ."';";
                $this->db->simple_query($q);
            } elseif ($statusPembayaran == 'Selesai') {
                $q = "UPDATE `penjualans` SET `cash` = '". $this->db->escape_str($f['cash']) ."', `status_penjualan` = 'Proses' WHERE `id` = '". $this->db->escape_str($idPenjualan) ."';";
                $this->db->simple_query($q);
            } else{
                // nothing to do.
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
		$q = "UPDATE `pembayarans` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';

            $q = "SELECT * FROM `pembayarans` WHERE `id` = '". $this->db->escape_str($id) ."';";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $q = "UPDATE `penjualans` SET `cash` = '0.00', `status_penjualan` = 'Proses' WHERE `id` = '". $r[0]['id_penjualan'] ."';";
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
            $q = "SELECT * FROM `penjualans` WHERE `status_penjualan` = 'Proses' AND `deleted_at` IS NULL ORDER BY `no_faktur` DESC;";
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

}