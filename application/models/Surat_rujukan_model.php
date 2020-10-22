<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_rujukan_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_pasien`, c.`nama_dokter` FROM `surat_rujukans` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `dokters` c ON a.`id_dokter` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_pasien` LIKE '%". $s ."%' OR a.`umur_pasien` LIKE '%". $s ."%' OR a.`alamat_pasien` LIKE '%". $s ."%' OR a.`gravida` LIKE '%". $s ."%' OR a.`partus` LIKE '%". $s ."%' OR a.`aborsi` LIKE '%". $s ."%' OR a.`tindakan` LIKE '%". $s ."%' OR a.`diagnosa_pasien` LIKE '%". $s ."%' OR a.`pemeriksaan_pasien` LIKE '%". $s ."%' OR a.`keluhan_pasien` LIKE '%". $s ."%' OR c.`nama_dokter` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_pasien') {
                    $q .= "ORDER BY b.`nama_pasien` ". $dir ." ";
                } elseif ($col == 'nama_dokter') {
                    $q .= "ORDER BY c.`nama_dokter` ". $dir ." ";
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
                    b.`nama_pasien`,
                    c.`nama_dokter`
                FROM 
                    `surat_rujukans` a 
                LEFT JOIN
                    `pasiens` b
                        ON
                    a.`id_pasien` = b.`id`
                LEFT JOIN
                    `dokters` c
                        ON
                    a.`id_dokter` = c.`id`
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
                        `surat_rujukans` 
                        (
                            `umur_pasien`,
                            `alamat_pasien`,
                            `gravida`,
                            `partus`,
                            `aborsi`,
                            `keluhan_pasien`,
                            `pemeriksaan_pasien`,
                            `diagnosa_pasien`,
                            `tindakan`,
                            `id_pasien`,
                            `id_dokter`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['umur_pasien']) ."',
                            '". $this->db->escape_str($f['alamat_pasien']) ."',
                            '". $this->db->escape_str($f['gravida']) ."',
                            '". $this->db->escape_str($f['partus']) ."',
                            '". $this->db->escape_str($f['aborsi']) ."',
                            '". $this->db->escape_str($f['keluhan_pasien']) ."',
                            '". $this->db->escape_str($f['pemeriksaan_pasien']) ."',
                            '". $this->db->escape_str($f['diagnosa_pasien']) ."',
                            '". $this->db->escape_str($f['tindakan']) ."',
                            '". $this->db->escape_str($f['id_pasien']) ."',
                            '". $this->db->escape_str($f['id_dokter']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `surat_rujukans` 
                    SET 
                        `umur_pasien` = '". $this->db->escape_str($f['umur_pasien']) ."', 
                        `alamat_pasien` = '". $this->db->escape_str($f['alamat_pasien']) ."', 
                        `gravida` = '". $this->db->escape_str($f['gravida']) ."', 
                        `partus` = '". $this->db->escape_str($f['partus']) ."', 
                        `aborsi` = '". $this->db->escape_str($f['aborsi']) ."', 
                        `keluhan_pasien` = '". $this->db->escape_str($f['keluhan_pasien']) ."', 
                        `pemeriksaan_pasien` = '". $this->db->escape_str($f['pemeriksaan_pasien']) ."', 
                        `diagnosa_pasien` = '". $this->db->escape_str($f['diagnosa_pasien']) ."', 
                        `tindakan` = '". $this->db->escape_str($f['tindakan']) ."', 
                        `id_dokter` = '". $this->db->escape_str($f['id_dokter']) ."', 
                        `id_pasien` = '". $this->db->escape_str($f['id_pasien']) ."'
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
		$q = "UPDATE `surat_rujukans` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
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

    function select_dokter()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `dokters` WHERE `deleted_at` IS NULL ORDER BY `nama_dokter` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}