<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_keterangan_hamil_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_pasien`, c.`nama_dokter` FROM `surat_ket_hamils` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `dokters` c ON a.`id_dokter` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`nama_pejabat` LIKE '%". $s ."%' OR a.`jabatan` LIKE '%". $s ."%' OR a.`alamat_pejabat` LIKE '%". $s ."%' OR b.`nama_pasien` LIKE '%". $s ."%' OR a.`umur_pasien` LIKE '%". $s ."%' OR a.`alamat_pasien` LIKE '%". $s ."%' OR a.`tgl_periksa` LIKE '%". $s ."%' OR a.`keterangan` LIKE '%". $s ."%' OR c.`nama_dokter` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
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
                    `surat_ket_hamils` a 
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
                        `surat_ket_hamils` 
                        (
                            `nama_pejabat`,
                            `jabatan`,
                            `alamat_pejabat`,
                            `id_pasien`,
                            `umur_pasien`,
                            `alamat_pasien`,
                            `tgl_periksa`,
                            `keterangan`,
                            `id_dokter`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['nama_pejabat']) ."',
                            '". $this->db->escape_str($f['jabatan']) ."',
                            '". $this->db->escape_str($f['alamat_pejabat']) ."',
                            '". $this->db->escape_str($f['id_pasien']) ."',
                            '". $this->db->escape_str($f['umur_pasien']) ."',
                            '". $this->db->escape_str($f['alamat_pasien']) ."',
                            '". $this->db->escape_str($f['tgl_periksa']) ."',
                            '". $this->db->escape_str($f['keterangan']) ."',
                            '". $this->db->escape_str($f['id_dokter']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `surat_ket_hamils` 
                    SET 
                        `nama_pejabat` = '". $this->db->escape_str($f['nama_pejabat']) ."', 
                        `jabatan` = '". $this->db->escape_str($f['jabatan']) ."', 
                        `alamat_pejabat` = '". $this->db->escape_str($f['alamat_pejabat']) ."', 
                        `id_pasien` = '". $this->db->escape_str($f['id_pasien']) ."', 
                        `umur_pasien` = '". $this->db->escape_str($f['umur_pasien']) ."', 
                        `alamat_pasien` = '". $this->db->escape_str($f['alamat_pasien']) ."', 
                        `tgl_periksa` = '". $this->db->escape_str($f['tgl_periksa']) ."', 
                        `keterangan` = '". $this->db->escape_str($f['keterangan']) ."', 
                        `id_dokter` = '". $this->db->escape_str($f['id_dokter']) ."'
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
		$q = "UPDATE `surat_ket_hamils` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
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