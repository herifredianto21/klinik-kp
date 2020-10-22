<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class apotek_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.`id`, a.`status_antrian`, b.`nama_pasien`, c.`nama_pelayanan`, DATE_FORMAT(a.`tgl_antrian`, '%d/%m/%Y') AS `tanggal`, TIME_FORMAT(a.`tgl_antrian`, '%H:%i') AS `jam` FROM `antrians` a LEFT JOIN `pasiens` b ON a.`id_pasien` = b.`id` LEFT JOIN `jenis_pelayanans` c ON a.`id_jenis_pelayanan` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (a.`status_antrian` LIKE '%". $s ."%' OR b.`nama_pasien` LIKE '%". $s ."%' OR c.`nama_pelayanan` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_pasien') {
                    $q .= "ORDER BY b.`". $col ."` ". $dir ." ";
                } elseif ($col == 'nama_pelayanan') {
                    $q .= "ORDER BY c.`". $col ."` ". $dir ." ";
                } elseif ($col == 'waktu') {
                    $q .= "ORDER BY a.`tgl_antrian` ". $dir ." ";
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

    function _get_penjualan($data = array())
    {
    	$q = "SELECT a.`id`, GROUP_CONCAT(c.`nama_obat`) AS `list_obat`, DATE_FORMAT(a.`created_at`, '%d/%m/%Y') AS `tanggal`, TIME_FORMAT(a.`created_at`, '%H:%i') AS `jam` FROM `apotek_detail` a LEFT JOIN `apotek_detail_obat` b ON a.`id` = b.`id_penjualan` LEFT JOIN `obats` c ON b.`id_obat` = c.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE c.`nama_obat` LIKE '%". $s ."%' AND a.`id_antrian` = 0 AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`id_antrian` = 0 AND a.`deleted_at` IS NULL ";
        }

        $q .= "GROUP BY a.`id` ";

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'waktu') {
                    $q .= "ORDER BY a.`created_at` ". $dir ." ";
                } elseif ($col == 'list_obat') {
                    $q .= "ORDER BY `list_obat` ". $dir ." ";
                } elseif ($col == 'waktu') {
                    $q .= "ORDER BY a.`created_at` ". $dir ." ";
                } else{
                    $q .= "ORDER BY a.`". $col ."` ". $dir ." ";
                }
        	} else{
        		$q .= "ORDER BY a.`id` DESC ";
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

    function _list_penjualan($data = array())
    {
        $q = $this->_get_penjualan($data);
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

    function _filtered_penjualan($data = array())
    {
        $q = $this->_get_penjualan($data);
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

    function _all_penjualan($data = array())
    {
        $data['all'] = true;
        $q = $this->_get_penjualan($data);
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
    
    function datatable_penjualan($data = array())
	{
		$result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list_penjualan($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all_penjualan($data),
                'recordsFiltered'   => $this->_filtered_penjualan($data),
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
        $q = "UPDATE `antrians` SET `status_antrian` = 'Bayar' WHERE `id` = '". $this->db->escape_str($id) ."';";
        if($this->db->simple_query($q)){
            $result['result'] = true;
            $result['msg'] = 'Pembayaran berhasil.';

            $q =    "INSERT INTO 
                        `apotek_detail` 
                        (
                            `created_at`,
                            `id_antrian`,
                            `biaya_admin`,
                            `id_diskon`,
                            `biaya_diskon`,
                            `total`,
                            `bayar`,
                            `kembali`
                        ) 
                    VALUES 
                        (
                            NOW(),
                            '". $this->db->escape_str($id) ."',
                            3000,
                            '". $this->db->escape_str($f['jenis_diskon']) ."',
                            '". $this->db->escape_str($f['biaya_diskon']) ."',
                            '". $this->db->escape_str(str_replace('Rp. ', '', $f['total'])) ."',
                            '". $this->db->escape_str($f['bayar']) ."',
                            '". $this->db->escape_str(str_replace('Rp. ', '', $f['kembali'])) ."'
                        )
                    ;";
            if (!$this->db->simple_query($q)) {
                $result['result'] = false;
                $result['msg'] = 'Gagal menyimpan data detail pembayaran.';
            }

            for ($i=0; $i < count($f['biaya_pelayanan']); $i++) { 
                if ($f['biaya_pelayanan'][$i] != 0) {
                    $q =    "INSERT INTO 
                                `apotek_detail_medis` 
                                (
                                    `created_at`,
                                    `id_antrian`,
                                    `id_tindakan_medis`,
                                    `keterangan_tindakan_medis`,
                                    `biaya`
                                ) 
                            VALUES 
                                (
                                    NOW(),
                                    '". $this->db->escape_str($id) ."',
                                    '". $this->db->escape_str($f['biaya_pelayanan'][$i]) ."',
                                    '". $this->db->escape_str($f['keterangan_pelayanan'][$i]) ."',
                                    '". $this->db->escape_str(intval($f['biaya_pelayanan_nominal'][$i])) ."'
                                );
                            ";
                    if (!$this->db->simple_query($q)) {
                        $result['result'] = false;
                        $result['msg'] = 'Gagal menyimpan data detail pembayaran (tindakan).';
                    }
                }
            }

            for ($i=0; $i < count($f['biaya_obat']); $i++) { 
                if ($f['biaya_obat'][$i] != 0) {
                    $q =    "INSERT INTO 
                                `apotek_detail_obat` 
                                (
                                    `created_at`,
                                    `id_antrian`,
                                    `id_obat`,
                                    `qty`,
                                    `biaya`,
                                    `id_penjualan`
                                ) 
                            VALUES 
                                (
                                    NOW(),
                                    '". $this->db->escape_str($id) ."',
                                    '". $this->db->escape_str($f['biaya_obat'][$i]) ."',
                                    '". $this->db->escape_str($f['qty_obat'][$i]) ."',
                                    '". $this->db->escape_str(intval($f['biaya_obat_nominal'][$i])) ."',
                                    0
                                );
                            ";
                    if (!$this->db->simple_query($q)) {
                        $result['result'] = false;
                        $result['msg'] = 'Gagal menyimpan data detail pembayaran (obat).';
                    }
                }
            }
        } else{
            $result['msg'] = 'Terjadi kesalahan saat menyimpan data.';
        }

		return $result;
    }
    
    function save_penjualan($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
        parse_str($d['form'], $f);
        
        $q =    "INSERT INTO 
                    `apotek_detail` 
                    (
                        `created_at`,
                        `id_antrian`,
                        `biaya_admin`,
                        `id_diskon`,
                        `biaya_diskon`,
                        `total`,
                        `bayar`,
                        `kembali`
                    ) 
                VALUES 
                    (
                        NOW(),
                        '". $this->db->escape_str($id) ."',
                        0,
                        '". $this->db->escape_str($f['jenis_diskon']) ."',
                        '". $this->db->escape_str($f['biaya_diskon']) ."',
                        '". $this->db->escape_str(str_replace('Rp. ', '', $f['total'])) ."',
                        '". $this->db->escape_str($f['bayar']) ."',
                        '". $this->db->escape_str(str_replace('Rp. ', '', $f['kembali'])) ."'
                    )
                ;";
        if ($this->db->simple_query($q)) {
            $result['result'] = true;
            $result['msg'] = 'Pembayaran berhasil.';

            $q = "SELECT * FROM `apotek_detail` ORDER BY `id` DESC LIMIT 1;";
            $r = $this->db->query($q, false)->result_array();
            $id_penjualan = $r[0]['id'];
            $result['id_penjualan'] = $id_penjualan;

            for ($i=0; $i < count($f['biaya_obat']); $i++) { 
                $q =    "INSERT INTO 
                            `apotek_detail_obat` 
                            (
                                `created_at`,
                                `id_antrian`,
                                `id_obat`,
                                `qty`,
                                `biaya`,
                                `id_penjualan`
                            ) 
                        VALUES 
                            (
                                NOW(),
                                '". $this->db->escape_str($id) ."',
                                '". $this->db->escape_str($f['biaya_obat'][$i]) ."',
                                '". $this->db->escape_str($f['qty_obat'][$i]) ."',
                                '". $this->db->escape_str(intval($f['biaya_obat_nominal'][$i])) ."',
                                '". $id_penjualan ."'
                            );
                        ";
                if (!$this->db->simple_query($q)) {
                    $result['result'] = false;
                    $result['msg'] = 'Gagal menyimpan data detail pembayaran (obat).';
                }
            }
        } else{
            $result['msg'] = 'Gagal menyimpan data detail pembayaran.';
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
		$q = "UPDATE `desas` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
    }
    
    function get_jasa()
    {
        $q = "SELECT * FROM `biaya_medis` WHERE `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return $r;
    }

    function get_obat()
    {
        $q = "SELECT * FROM `obats` WHERE `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return $r;
    }

    function cetak($id = 0, $detail = false, $pemeriksaan = false)
    {
        $result = array(
			'result'        => false,
            'msg'		    => '',
            'detail'        => $detail,
            'pemeriksaan'   => $pemeriksaan
        );

        $q =    "SELECT 
                    c.`nama_pasien`,
                    c.`tgl_lahir`,
                    c.`alamat_pasien`,
                    a.`biaya_admin`,
                    a.`id_diskon`,
                    a.`biaya_diskon`,
                    a.`total`,
                    a.`bayar`,
                    a.`kembali`
                FROM 
                    `apotek_detail` a
                LEFT JOIN
                    `antrians` b
                        ON
                    b.`id` = a.`id_antrian`
                LEFT JOIN 
                    `pasiens` c
                        ON
                    c.`id` = b.`id_pasien`
                WHERE 
                    a.`id_antrian` = '". $this->db->escape_str($id) ."' 
                        AND 
                    a.`deleted_at` IS NULL
                ;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;

            $q0 =   "SELECT 
                        a.*,
                        b.`nama_biaya_medis`,
                        b.`biaya_medis`
                    FROM 
                        `apotek_detail_medis` a
                    LEFT JOIN
                        `biaya_medis` b
                            ON
                        b.`id` = a.`id_tindakan_medis`
                    WHERE 
                        a.`id_antrian` = '". $this->db->escape_str($id) ."' 
                            AND 
                        a.`deleted_at` IS NULL;";
            $r0 = $this->db->query($q0, false)->result_array();
            $q1 =   "SELECT 
                        a.*,
                        b.`nama_obat`,
                        b.`harga_jual_obat`
                    FROM 
                        `apotek_detail_obat` a 
                    LEFT JOIN
                        `obats` b
                            ON
                        b.`id` = a.`id_obat`
                    WHERE 
                        a.`id_antrian` = '". $this->db->escape_str($id) ."' 
                            AND 
                        a.`deleted_at` IS NULL;";
            $r1 = $this->db->query($q1, false)->result_array();
            
            $totalMedis = 0;
            if (count($r0) > 0) {
                for ($i=0; $i < count($r0); $i++) { 
                    $totalMedis = $totalMedis + intval($r0[$i]['biaya']);
                }
            }

            $totalObat = 0;
            if (count($r1) > 0) {
                for ($i=0; $i < count($r1); $i++) { 
                    $totalObat = $totalObat + intval($r1[$i]['biaya']);
                }
            }

            $result['data'] = array(
                'pasien' => array(
                    'nama'      => $r[0]['nama_pasien'],
                    'usia'      => ceil(intval(date('Y')) - intval(substr($r[0]['tgl_lahir'],0,4))),
                    'alamat'    => $r[0]['alamat_pasien']
                ),
                'biaya' => array(
                    'medis' => $totalMedis,
                    'obat'  => $totalObat,
                    'admin' => $r[0]['biaya_admin']
                ),
                'bayar' => array(
                    'diskon'    => $r[0]['biaya_diskon'],
                    'total'     => $totalMedis + $totalObat + $r[0]['biaya_admin'] - $r[0]['biaya_diskon'],
                    'bayar'     => $r[0]['bayar'],
                    'kembali'   => $r[0]['kembali']
                )
            );

            $result['data']['medis'] = $r0;
            $result['data']['totalMedis'] = $totalMedis;
            $result['data']['obat'] = $r1;
            $result['data']['totalObat'] = $totalObat;
        }
        
        return $result;
    }

    function cetak_langsung($id = 0)
    {
        $result = array(
			'result'    => false,
            'msg'		=> ''
        );

        $q =    "SELECT 
                    *
                FROM 
                    `apotek_detail`
                WHERE 
                    `id` = '". $this->db->escape_str($id) ."' 
                        AND 
                    `deleted_at` IS NULL
                ;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;

            $q1 =   "SELECT 
                        a.*,
                        b.`nama_obat`,
                        b.`harga_jual_obat`
                    FROM 
                        `apotek_detail_obat` a 
                    LEFT JOIN
                        `obats` b
                            ON
                        b.`id` = a.`id_obat`
                    WHERE 
                        a.`id_penjualan` = '". $this->db->escape_str($id) ."' 
                            AND 
                        a.`deleted_at` IS NULL;";
            $r1 = $this->db->query($q1, false)->result_array();

            $totalObat = 0;
            if (count($r1) > 0) {
                for ($i=0; $i < count($r1); $i++) { 
                    $totalObat = $totalObat + intval($r1[$i]['biaya']);
                }
            }

            $result['data'] = array(
                'obat'      => $r1,
                'totalObat' => $totalObat
            );
        }
        
        return $result;
    }

    function cetak_laporan_harian($tanggal = '0000-00-00')
    {
        $result = array(
			'result'    => false,
            'msg'		=> '',
            'data'      => array()
        );

        $q =    "SELECT 
                    a.`id_obat`,
                    SUM(a.`qty`) AS `qty`,
                    SUM(a.`biaya`) AS `biaya`,
                    b.`kode_obat`,
                    b.`nama_obat`,
                    b.`harga_pokok_obat`,
                    b.`harga_jual_obat`
                FROM 
                    `apotek_detail_obat` a 
                LEFT JOIN
                    `obats` b
                        ON
                    a.`id_obat` = b.`id`
                WHERE 
                    a.`created_at` like '". $tanggal ."%' 
                        AND 
                    a.`deleted_at` IS NULL
                GROUP BY
                    a.`id_obat`
                ORDER BY
                    b.`nama_obat` ASC
                ;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function cetak_laporan_bulanan($bulan = '0000-00')
    {
        $result = array(
			'result'    => false,
            'msg'		=> '',
            'data'      => array()
        );

        $q =    "SELECT 
                    a.`id_obat`,
                    SUM(a.`qty`) AS `qty`,
                    SUM(a.`biaya`) AS `biaya`,
                    b.`kode_obat`,
                    b.`nama_obat`,
                    b.`harga_pokok_obat`,
                    b.`harga_jual_obat`
                FROM 
                    `apotek_detail_obat` a 
                LEFT JOIN
                    `obats` b
                        ON
                    a.`id_obat` = b.`id`
                WHERE 
                    a.`created_at` like '". $bulan ."%' 
                        AND 
                    a.`deleted_at` IS NULL
                GROUP BY
                    a.`id_obat`
                ORDER BY
                    b.`nama_obat` ASC
                ;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}