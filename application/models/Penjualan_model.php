<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_pasien`, c.`kode_antrian` FROM `penjualans` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `antrians` c ON a.`id_antrian` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`no_faktur` LIKE '%". $s ."%' OR a.`tgl_penjualan` LIKE '%". $s ."%' OR b.`nama_pasien` LIKE '%". $s ."%' OR a.`status_penjualan` LIKE '%". $s ."%' OR a.`total_penjualan` LIKE '%". $s ."%' OR a.`cash` LIKE '%". $s ."%' OR c.`kode_antrian` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_pasien') {
                    $q .= "ORDER BY b.`nama_pasien` ". $dir ." ";
                } elseif ($col == 'kode_antrian') {
                    $q .= "ORDER BY c.`kode_antrian` ". $dir ." ";
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
            'msg'       => 'Data penjualan tidak ditemukan.'  
        );

        $q =    "SELECT 
                    a.*,
                    b.`nama_pasien`,
                    c.`kode_antrian`
                FROM 
                    `penjualans` a 
                LEFT JOIN
                    `pasiens` b
                        ON
                    a.`id_pasien` = b.`id`
                LEFT JOIN
                    `antrians` c
                        ON
                    a.`id_antrian` = c.`id`
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
                        `penjualans` 
                        (
                            `no_faktur`,
                            `tgl_penjualan`,
                            `id_pasien`,
                            `id_antrian`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['no_faktur']) ."',
                            '". $this->db->escape_str($f['tgl_penjualan']) ."',
                            '". $this->db->escape_str($f['id_pasien']) ."',
                            '". $this->db->escape_str($f['id_antrian']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `penjualans` 
                    SET 
                        `no_faktur` = '". $this->db->escape_str($f['no_faktur']) ."', 
                        `tgl_penjualan` = '". $this->db->escape_str($f['tgl_penjualan']) ."', 
                        `id_pasien` = '". $this->db->escape_str($f['id_pasien']) ."',
                        `id_antrian` = '". $this->db->escape_str($f['id_antrian']) ."'
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
		$q = "UPDATE `penjualans` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_pasien($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `pasiens` WHERE `deleted_at` IS NULL ORDER BY `nama_pasien` ASC;";
        } else{
            $q = "SELECT * FROM `pasiens` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function input_no_faktur()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $d = date('Ym');
        $q = "SELECT COUNT(*) AS `total` FROM `penjualans` WHERE `no_faktur` LIKE 'F-". $d ."%';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $total = $r[0]['total'] + 1;
            $result['value'] = 'F-' . $d . str_pad($total, 3, '0', STR_PAD_LEFT);
        }

        return $result;
    }

    function select_kode_antrian($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `antrians` WHERE `kode_antrian` IS NOT NULL AND `deleted_at` IS NULL ORDER BY `kode_antrian` DESC;";
        } else{
            $q = "SELECT * FROM `antrians` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}