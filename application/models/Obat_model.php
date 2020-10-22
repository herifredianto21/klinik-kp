<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat_model extends CI_Model {

	function _get($data = array())
    {
    	$q =    "SELECT 
                    a.*, 
                    b.`nama_satuan`, 
                    c.`nama_kategori`,
                    (
                        (
                            SELECT IFNULL(SUM(`qty_beli`), 0) FROM `pembelian_details` WHERE `id_obat` = a.`id` AND `deleted_at` IS NULL
                        ) -
                        (
                            SELECT IFNULL(SUM(`qty`), 0) FROM `apotek_detail_obat` WHERE `id_obat` = a.`id` AND `deleted_at` IS NULL
                        )
                    ) AS `stok`
                FROM 
                    `obats` a 
                LEFT JOIN 
                    `satuans` b 
                        ON 
                    a.`id_satuan` = b.`id` 
                LEFT JOIN 
                    `kategoris` c 
                        ON 
                    a.`id_kategori` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (c.`nama_kategori` LIKE '%". $s ."%' OR b.`nama_satuan` LIKE '%". $s ."%' OR a.`kode_obat` LIKE '%". $s ."%' OR a.`nama_obat` LIKE '%". $s ."%' OR a.`stok_minimal` LIKE '%". $s ."%' OR a.`harga_jual_obat` LIKE '%". $s ."%' OR a.`harga_pokok_obat` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        $q .= "GROUP BY a.`id` ";

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_satuan') {
                    $q .= "ORDER BY b.`". $col ."` ". $dir ." ";
                } elseif ($col == 'nama_kategori') {
                    $q .= "ORDER BY c.`". $col ."` ". $dir ." ";
                } elseif ($col == 'stok') {
                    $q .= "ORDER BY `stok` ". $dir ." ";
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
			$q = "INSERT INTO `obats` (`created_at`, `kode_obat`, `nama_obat`, `stok_minimal`, `id_satuan`, `id_kategori`, `harga_jual_obat`, `harga_pokok_obat`) VALUES (NOW(), '". $this->db->escape_str($f['kode_obat']) ."', '". $this->db->escape_str($f['nama_obat']) ."', '". $this->db->escape_str($f['stok_minimal']) ."', '". $this->db->escape_str($f['id_satuan']) ."', '". $this->db->escape_str($f['id_kategori']) ."', '". $this->db->escape_str($f['harga_jual_obat']) ."', '". $this->db->escape_str($f['harga_pokok_obat']) ."');";
		} else{
			$q = "UPDATE `obats` SET `updated_at` = NOW(), `kode_obat` = '". $this->db->escape_str($f['kode_obat']) ."', `nama_obat` = '". $this->db->escape_str($f['nama_obat']) ."', `stok_minimal` = '". $this->db->escape_str($f['stok_minimal']) ."', `id_satuan` = '". $this->db->escape_str($f['id_satuan']) ."', `id_kategori` = '". $this->db->escape_str($f['id_kategori']) ."', `harga_jual_obat` = '". $this->db->escape_str($f['harga_jual_obat']) ."', `harga_pokok_obat` = '". $this->db->escape_str($f['harga_pokok_obat']) ."' WHERE `id` = '". $this->db->escape_str($id) ."';";
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
		$q = "UPDATE `obats` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_satuan()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `satuans` WHERE `deleted_at` IS NULL ORDER BY `nama_satuan` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function select_kategori()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "SELECT * FROM `kategoris` WHERE `deleted_at` IS NULL ORDER BY `nama_kategori` ASC;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function select($id = 0)
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

    function cetak()
    {
        $q =    "SELECT 
                    a.*, 
                    b.`nama_satuan`, 
                    c.`nama_kategori`,
                    (
                        (
                            SELECT IFNULL(SUM(`qty_beli`), 0) FROM `pembelian_details` WHERE `id_obat` = a.`id` AND `deleted_at` IS NULL
                        ) -
                        (
                            SELECT IFNULL(SUM(`qty`), 0) FROM `apotek_detail_obat` WHERE `id_obat` = a.`id` AND `deleted_at` IS NULL
                        )
                    ) AS `stok`
                FROM 
                    `obats` a 
                LEFT JOIN 
                    `satuans` b 
                        ON 
                    a.`id_satuan` = b.`id` 
                LEFT JOIN 
                    `kategoris` c 
                        ON 
                    a.`id_kategori` = c.`id`
                WHERE
                    a.`deleted_at` IS NULL
                GROUP BY
                    a.`id`
                ORDER BY
                    a.`kode_obat` ASC
                ";
        $r = $this->db->query($q, false)->result_array();

        $result = array(
            'result'    => true,
            'msg'       => '',
            'data'      => $r
        );

        return $result;
    }

}