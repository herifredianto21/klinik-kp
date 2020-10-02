<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_lahir_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_pasien`, c.`nama_dokter` FROM `surat_lahirs` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `dokters` c ON a.`id_dokter` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`no_surat` LIKE '%". $s ."%' OR b.`nama_pasien` LIKE '%". $s ."%' OR a.`umur_istri` LIKE '%". $s ."%' OR a.`pekerjaan_istri` LIKE '%". $s ."%' OR a.`alamat_istri` LIKE '%". $s ."%' OR a.`nama_suami` LIKE '%". $s ."%' OR a.`umur_suami` LIKE '%". $s ."%' OR a.`pekerjaan_suami` LIKE '%". $s ."%' OR a.`alamat_suami` LIKE '%". $s ."%' OR a.`anak_ke` LIKE '%". $s ."%' OR a.`anak_dari` LIKE '%". $s ."%' OR a.`hari_lahir` LIKE '%". $s ."%' OR a.`tanggal_lahir` LIKE '%". $s ."%' OR a.`jam_lahir` LIKE '%". $s ."%' OR a.`jenis_kelamin_bayi` LIKE '%". $s ."%' OR a.`berat_bayi` LIKE '%". $s ."%' OR a.`panjang_bayi` LIKE '%". $s ."%' OR a.`nama_bayi` LIKE '%". $s ."%' OR c.`nama_dokter` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
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
                    `surat_lahirs` a 
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
                        `surat_lahirs` 
                        (
                            `no_surat`,
                            `id_pasien`,
                            `umur_istri`,
                            `pekerjaan_istri`,
                            `alamat_istri`,
                            `nama_suami`,
                            `umur_suami`,
                            `pekerjaan_suami`,
                            `alamat_suami`,
                            `anak_ke`,
                            `anak_dari`,
                            `hari_lahir`,
                            `tanggal_lahir`,
                            `jam_lahir`,
                            `jenis_kelamin_bayi`,
                            `berat_bayi`,
                            `panjang_bayi`,
                            `nama_bayi`,
                            `id_dokter`
                        ) 
                    VALUES 
                        (
                            '". $this->db->escape_str($f['no_surat']) ."',
                            '". $this->db->escape_str($f['id_pasien']) ."',
                            '". $this->db->escape_str($f['umur_istri']) ."',
                            '". $this->db->escape_str($f['pekerjaan_istri']) ."',
                            '". $this->db->escape_str($f['alamat_istri']) ."',
                            '". $this->db->escape_str($f['nama_suami']) ."',
                            '". $this->db->escape_str($f['umur_suami']) ."',
                            '". $this->db->escape_str($f['pekerjaan_suami']) ."',
                            '". $this->db->escape_str($f['alamat_istri']) ."',
                            '". $this->db->escape_str($f['anak_ke']) ."',
                            '". $this->db->escape_str($f['anak_dari']) ."',
                            '". $this->db->escape_str($f['hari_lahir']) ."',
                            '". $this->db->escape_str($f['tanggal_lahir']) ."',
                            '". $this->db->escape_str($f['jam_lahir']) ."',
                            '". $this->db->escape_str($f['jenis_kelamin_bayi']) ."',
                            '". $this->db->escape_str($f['berat_bayi']) ."',
                            '". $this->db->escape_str($f['panjang_bayi']) ."',
                            '". $this->db->escape_str($f['nama_bayi']) ."',
                            '". $this->db->escape_str($f['id_dokter']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `surat_lahirs` 
                    SET 
                        `no_surat` = '". $this->db->escape_str($f['no_surat']) ."', 
                        `id_pasien` = '". $this->db->escape_str($f['id_pasien']) ."', 
                        `umur_istri` = '". $this->db->escape_str($f['umur_istri']) ."', 
                        `pekerjaan_istri` = '". $this->db->escape_str($f['pekerjaan_istri']) ."', 
                        `alamat_istri` = '". $this->db->escape_str($f['alamat_istri']) ."', 
                        `nama_suami` = '". $this->db->escape_str($f['nama_suami']) ."', 
                        `umur_suami` = '". $this->db->escape_str($f['umur_suami']) ."',
                        `pekerjaan_suami` = '". $this->db->escape_str($f['pekerjaan_suami']) ."',
                        `alamat_suami` = '". $this->db->escape_str($f['alamat_istri']) ."',
                        `anak_ke` = '". $this->db->escape_str($f['anak_ke']) ."',
                        `anak_dari` = '". $this->db->escape_str($f['anak_dari']) ."',
                        `hari_lahir` = '". $this->db->escape_str($f['hari_lahir']) ."',
                        `tanggal_lahir` = '". $this->db->escape_str($f['tanggal_lahir']) ."',
                        `jam_lahir` = '". $this->db->escape_str($f['jam_lahir']) ."',
                        `jenis_kelamin_bayi` = '". $this->db->escape_str($f['jenis_kelamin_bayi']) ."',
                        `berat_bayi` = '". $this->db->escape_str($f['berat_bayi']) ."',
                        `panjang_bayi` = '". $this->db->escape_str($f['panjang_bayi']) ."',
                        `nama_bayi` = '". $this->db->escape_str($f['nama_bayi']) ."',
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
		$q = "UPDATE `surat_lahirs` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
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

    function input_no_surat()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $d = date('Ymd');
        $q = "SELECT COUNT(*) AS `total` FROM `surat_lahirs` WHERE `no_surat` LIKE 'SKL-". $d ."%';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $total = $r[0]['total'] + 1;
            $result['value'] = 'SKL-' . $d . str_pad($total, 3, '0', STR_PAD_LEFT);
        }

        return $result;
    }

}