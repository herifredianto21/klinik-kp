<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama_laporan` FROM `laporan` a LEFT JOIN `jenis_laporan` b ON a.`id_jenis_laporan` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_laporan` LIKE '%". $s ."%' OR a.`tahun_laporan` LIKE '%". $s ."%' OR a.`bulan_laporan` LIKE '%". $s ."%' OR a.`catatan` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_laporan') {
                    $q .= "ORDER BY b.`nama_laporan` ". $dir ." ";
                } elseif ('tahun_laporan') {
                    $q .= "ORDER BY a.`tahun_laporan` ". $dir ." ";
                } else {
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
            'msg'       => 'Data laporan tidak ditemukan.'  
        );

        $q = "SELECT * FROM `laporan` WHERE `id` = '". $this->db->escape_str($id) ."';";
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
            $q =    "SELECT 
                        * 
                    FROM 
                        `laporan` 
                    WHERE 
                        `id_jenis_laporan` = '". $this->db->escape_str($f['id_jenis_laporan']) ."' 
                            AND 
                        `tahun_laporan` = '". $this->db->escape_str($f['tahun_laporan']) ."' 
                            AND 
                        `bulan_laporan` = '". $this->db->escape_str($f['bulan_laporan']) ."' 
                            AND 
                        `deleted_at` IS NULL
                    ;";
            $r = $this->db->query($q)->result_array();
            if (count($r) > 0) {
                $result['msg'] = 'Laporan sudah pernah dibuat sebelumnya.';
                return $result;
            }

			$q =    "INSERT INTO 
                        `laporan` 
                        (
                            `created_at`,
                            `id_jenis_laporan`,
                            `tahun_laporan`,
                            `bulan_laporan`,
                            `catatan`
                        ) 
                    VALUES 
                        (
                            NOW(),
                            '". $this->db->escape_str($f['id_jenis_laporan']) ."',
                            '". $this->db->escape_str($f['tahun_laporan']) ."',
                            '". $this->db->escape_str($f['bulan_laporan']) ."',
                            '". $this->db->escape_str($f['catatan']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE 
                        `laporan` 
                    SET 
                        `modified_at` = NOW(),
                        `id_jenis_laporan` = '". $this->db->escape_str($f['id_jenis_laporan']) ."', 
                        `tahun_laporan` = '". $this->db->escape_str($f['tahun_laporan']) ."', 
                        `bulan_laporan` = '". $this->db->escape_str($f['bulan_laporan']) ."', 
                        `catatan` = '". $this->db->escape_str($f['catatan']) ."'
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
		}

		if ($this->db->simple_query($q)) {
            // if ($f['id_jenis_laporan'] == 1 && $id == 0) {
            //     $q =    "SELECT 
            //                 * 
            //             FROM 
            //                 `laporan` 
            //             WHERE 
            //                 `id_jenis_laporan` = '". $this->db->escape_str($f['id_jenis_laporan']) ."' 
            //                     AND 
            //                 `tahun_laporan` = '". $this->db->escape_str($f['tahun_laporan']) ."' 
            //                     AND 
            //                 `bulan_laporan` = '". $this->db->escape_str($f['bulan_laporan']) ."'
            //             ORDER BY
            //                 `id` DESC
            //             LIMIT 1
            //             ;";
            //     $r = $this->db->query($q, false)->result_array();
            //     $id_laporan_bulanan = $r[0]['id'];
            //     $q =    "INSERT INTO 
            //                 `detail_laporan_bulanan` 
            //                 (
            //                     `id_laporan_bulanan`, 
            //                     `cihanjuang_rahayu_hamil_b`,
            //                     `cihanjuang_rahayu_hamil_l`,
            //                     `cihanjuang_rahayu_kb_baru_iud`,
            //                     `cihanjuang_rahayu_kb_baru_pil`,
            //                     `cihanjuang_rahayu_kb_baru_sun`,
            //                     `cihanjuang_rahayu_kb_lama_iud`,
            //                     `cihanjuang_rahayu_kb_lama_pil`,
            //                     `cihanjuang_rahayu_kb_lama_sun`,
            //                     `cihanjuang_rahayu_imunisasi_bcg`,
            //                     `cihanjuang_rahayu_imunisasi_dpt_1`,
            //                     `cihanjuang_rahayu_imunisasi_dpt_2`,
            //                     `cihanjuang_rahayu_imunisasi_dpt_3`,
            //                     `cihanjuang_rahayu_imunisasi_polio_1`,
            //                     `cihanjuang_rahayu_imunisasi_polio_2`,
            //                     `cihanjuang_rahayu_imunisasi_polio_3`,
            //                     `cihanjuang_rahayu_imunisasi_polio_4`,
            //                     `cihanjuang_rahayu_imunisasi_hb_0`,
            //                     `cihanjuang_rahayu_imunisasi_hb_1`,
            //                     `cihanjuang_rahayu_imunisasi_hb_2`,
            //                     `cihanjuang_rahayu_imunisasi_hb_3`,
            //                     `cihanjuang_rahayu_imunisasi_campak`,
            //                     `cihanjuang_rahayu_imunisasi_tt_1`,
            //                     `cihanjuang_rahayu_imunisasi_tt_2`,
            //                     `cihanjuang_rahayu_imunisasi_tt_wus_1`,
            //                     `cihanjuang_rahayu_imunisasi_tt_wus_2`,
            //                     `cihanjuang_rahayu_partus`,
            //                     `cihanjuang_hamil_b`,
            //                     `cihanjuang_hamil_l`,
            //                     `cihanjuang_kb_baru_iud`,
            //                     `cihanjuang_kb_baru_pil`,
            //                     `cihanjuang_kb_baru_sun`,
            //                     `cihanjuang_kb_lama_iud`,
            //                     `cihanjuang_kb_lama_pil`,
            //                     `cihanjuang_kb_lama_sun`,
            //                     `cihanjuang_imunisasi_bcg`,
            //                     `cihanjuang_imunisasi_dpt_1`,
            //                     `cihanjuang_imunisasi_dpt_2`,
            //                     `cihanjuang_imunisasi_dpt_3`,
            //                     `cihanjuang_imunisasi_polio_1`,
            //                     `cihanjuang_imunisasi_polio_2`,
            //                     `cihanjuang_imunisasi_polio_3`,
            //                     `cihanjuang_imunisasi_polio_4`,
            //                     `cihanjuang_imunisasi_hb_0`,
            //                     `cihanjuang_imunisasi_hb_1`,
            //                     `cihanjuang_imunisasi_hb_2`,
            //                     `cihanjuang_imunisasi_hb_3`,
            //                     `cihanjuang_imunisasi_campak`,
            //                     `cihanjuang_imunisasi_tt_1`,
            //                     `cihanjuang_imunisasi_tt_2`,
            //                     `cihanjuang_imunisasi_tt_wus_1`,
            //                     `cihanjuang_imunisasi_tt_wus_2`,
            //                     `cihanjuang_partus`,
            //                     `sariwangi_hamil_b`,
            //                     `sariwangi_hamil_l`,
            //                     `sariwangi_kb_baru_iud`,
            //                     `sariwangi_kb_baru_pil`,
            //                     `sariwangi_kb_baru_sun`,
            //                     `sariwangi_kb_lama_iud`,
            //                     `sariwangi_kb_lama_pil`,
            //                     `sariwangi_kb_lama_sun`,
            //                     `sariwangi_imunisasi_bcg`,
            //                     `sariwangi_imunisasi_dpt_1`,
            //                     `sariwangi_imunisasi_dpt_2`,
            //                     `sariwangi_imunisasi_dpt_3`,
            //                     `sariwangi_imunisasi_polio_1`,
            //                     `sariwangi_imunisasi_polio_2`,
            //                     `sariwangi_imunisasi_polio_3`,
            //                     `sariwangi_imunisasi_polio_4`,
            //                     `sariwangi_imunisasi_hb_0`,
            //                     `sariwangi_imunisasi_hb_1`,
            //                     `sariwangi_imunisasi_hb_2`,
            //                     `sariwangi_imunisasi_hb_3`,
            //                     `sariwangi_imunisasi_campak`,
            //                     `sariwangi_imunisasi_tt_1`,
            //                     `sariwangi_imunisasi_tt_2`,
            //                     `sariwangi_imunisasi_tt_wus_1`,
            //                     `sariwangi_imunisasi_tt_wus_2`,
            //                     `sariwangi_partus`,
            //                     `karyawangi_hamil_b`,
            //                     `karyawangi_hamil_l`,
            //                     `karyawangi_kb_baru_iud`,
            //                     `karyawangi_kb_baru_pil`,
            //                     `karyawangi_kb_baru_sun`,
            //                     `karyawangi_kb_lama_iud`,
            //                     `karyawangi_kb_lama_pil`,
            //                     `karyawangi_kb_lama_sun`,
            //                     `karyawangi_imunisasi_bcg`,
            //                     `karyawangi_imunisasi_dpt_1`,
            //                     `karyawangi_imunisasi_dpt_2`,
            //                     `karyawangi_imunisasi_dpt_3`,
            //                     `karyawangi_imunisasi_polio_1`,
            //                     `karyawangi_imunisasi_polio_2`,
            //                     `karyawangi_imunisasi_polio_3`,
            //                     `karyawangi_imunisasi_polio_4`,
            //                     `karyawangi_imunisasi_hb_0`,
            //                     `karyawangi_imunisasi_hb_1`,
            //                     `karyawangi_imunisasi_hb_2`,
            //                     `karyawangi_imunisasi_hb_3`,
            //                     `karyawangi_imunisasi_campak`,
            //                     `karyawangi_imunisasi_tt_1`,
            //                     `karyawangi_imunisasi_tt_2`,
            //                     `karyawangi_imunisasi_tt_wus_1`,
            //                     `karyawangi_imunisasi_tt_wus_2`,
            //                     `karyawangi_partus`,
            //                     `cihideung_hamil_b`,
            //                     `cihideung_hamil_l`,
            //                     `cihideung_kb_baru_iud`,
            //                     `cihideung_kb_baru_pil`,
            //                     `cihideung_kb_baru_sun`,
            //                     `cihideung_kb_lama_iud`,
            //                     `cihideung_kb_lama_pil`,
            //                     `cihideung_kb_lama_sun`,
            //                     `cihideung_imunisasi_bcg`,
            //                     `cihideung_imunisasi_dpt_1`,
            //                     `cihideung_imunisasi_dpt_2`,
            //                     `cihideung_imunisasi_dpt_3`,
            //                     `cihideung_imunisasi_polio_1`,
            //                     `cihideung_imunisasi_polio_2`,
            //                     `cihideung_imunisasi_polio_3`,
            //                     `cihideung_imunisasi_polio_4`,
            //                     `cihideung_imunisasi_hb_0`,
            //                     `cihideung_imunisasi_hb_1`,
            //                     `cihideung_imunisasi_hb_2`,
            //                     `cihideung_imunisasi_hb_3`,
            //                     `cihideung_imunisasi_campak`,
            //                     `cihideung_imunisasi_tt_1`,
            //                     `cihideung_imunisasi_tt_2`,
            //                     `cihideung_imunisasi_tt_wus_1`,
            //                     `cihideung_imunisasi_tt_wus_2`,
            //                     `cihideung_partus`,
            //                     `cigugur_hamil_b`,
            //                     `cigugur_hamil_l`,
            //                     `cigugur_kb_baru_iud`,
            //                     `cigugur_kb_baru_pil`,
            //                     `cigugur_kb_baru_sun`,
            //                     `cigugur_kb_lama_iud`,
            //                     `cigugur_kb_lama_pil`,
            //                     `cigugur_kb_lama_sun`,
            //                     `cigugur_imunisasi_bcg`,
            //                     `cigugur_imunisasi_dpt_1`,
            //                     `cigugur_imunisasi_dpt_2`,
            //                     `cigugur_imunisasi_dpt_3`,
            //                     `cigugur_imunisasi_polio_1`,
            //                     `cigugur_imunisasi_polio_2`,
            //                     `cigugur_imunisasi_polio_3`,
            //                     `cigugur_imunisasi_polio_4`,
            //                     `cigugur_imunisasi_hb_0`,
            //                     `cigugur_imunisasi_hb_1`,
            //                     `cigugur_imunisasi_hb_2`,
            //                     `cigugur_imunisasi_hb_3`,
            //                     `cigugur_imunisasi_campak`,
            //                     `cigugur_imunisasi_tt_1`,
            //                     `cigugur_imunisasi_tt_2`,
            //                     `cigugur_imunisasi_tt_wus_1`,
            //                     `cigugur_imunisasi_tt_wus_2`,
            //                     `cigugur_partus`,
            //                     `cipanas_hamil_b`,
            //                     `cipanas_hamil_l`,
            //                     `cipanas_kb_baru_iud`,
            //                     `cipanas_kb_baru_pil`,
            //                     `cipanas_kb_baru_sun`,
            //                     `cipanas_kb_lama_iud`,
            //                     `cipanas_kb_lama_pil`,
            //                     `cipanas_kb_lama_sun`,
            //                     `cipanas_imunisasi_bcg`,
            //                     `cipanas_imunisasi_dpt_1`,
            //                     `cipanas_imunisasi_dpt_2`,
            //                     `cipanas_imunisasi_dpt_3`,
            //                     `cipanas_imunisasi_polio_1`,
            //                     `cipanas_imunisasi_polio_2`,
            //                     `cipanas_imunisasi_polio_3`,
            //                     `cipanas_imunisasi_polio_4`,
            //                     `cipanas_imunisasi_hb_0`,
            //                     `cipanas_imunisasi_hb_1`,
            //                     `cipanas_imunisasi_hb_2`,
            //                     `cipanas_imunisasi_hb_3`,
            //                     `cipanas_imunisasi_campak`,
            //                     `cipanas_imunisasi_tt_1`,
            //                     `cipanas_imunisasi_tt_2`,
            //                     `cipanas_imunisasi_tt_wus_1`,
            //                     `cipanas_imunisasi_tt_wus_2`,
            //                     `cipanas_partus`,
            //                     `created_at`
            //                 ) 
            //             VALUES 
            //                 (
            //                     '". $this->db->escape_str($id_laporan_bulanan) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_rahayu_partus']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['cihanjuang_partus']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['sariwangi_partus']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['karyawangi_partus']) ."',
            //                     '". $this->db->escape_str($f['cihideung_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['cihideung_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['cihideung_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['cihideung_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['cihideung_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['cihideung_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['cihideung_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['cihideung_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['cihideung_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['cihideung_partus']) ."',
            //                     '". $this->db->escape_str($f['cigugur_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['cigugur_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['cigugur_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['cigugur_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['cigugur_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['cigugur_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['cigugur_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['cigugur_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['cigugur_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['cigugur_partus']) ."',
            //                     '". $this->db->escape_str($f['cipanas_hamil_b']) ."',
            //                     '". $this->db->escape_str($f['cipanas_hamil_l']) ."',
            //                     '". $this->db->escape_str($f['cipanas_kb_baru_iud']) ."',
            //                     '". $this->db->escape_str($f['cipanas_kb_baru_pil']) ."',
            //                     '". $this->db->escape_str($f['cipanas_kb_baru_sun']) ."',
            //                     '". $this->db->escape_str($f['cipanas_kb_lama_iud']) ."',
            //                     '". $this->db->escape_str($f['cipanas_kb_lama_pil']) ."',
            //                     '". $this->db->escape_str($f['cipanas_kb_lama_sun']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_bcg']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_dpt_1']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_dpt_2']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_dpt_3']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_polio_1']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_polio_2']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_polio_3']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_polio_4']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_hb_0']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_hb_1']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_hb_2']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_hb_3']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_campak']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_tt_1']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_tt_2']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_tt_wus_1']) ."',
            //                     '". $this->db->escape_str($f['cipanas_imunisasi_tt_wus_2']) ."',
            //                     '". $this->db->escape_str($f['cipanas_partus']) ."',
            //                     NOW()
            //                 );
            //             ";
            //     $this->db->simple_query($q);
            // }

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
		$q = "UPDATE `laporan` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select_jenis_laporan($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `jenis_laporan` WHERE `deleted_at` IS NULL ORDER BY `nama_laporan` ASC;";
        } else{
            $q = "SELECT * FROM `jenis_laporan` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

    function cetak($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => 'Data laporan tidak ditemukan.'  
        );

        $q = "SELECT * FROM `laporan` WHERE `id` = '". $this->db->escape_str($id) ."';";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];

            $idJenisLaporan = $r[0]['id_jenis_laporan'];
            $periode = $r[0]['tahun_laporan'] . '-' . $r[0]['bulan_laporan'];
            $periode_tahun = $r[0]['tahun_laporan'];
            $periode_bulan = $r[0]['bulan_laporan'];
            $q = '';
            switch ($idJenisLaporan) {
                case '1':
                    // $q = "SELECT * FROM `detail_laporan_bulanan` WHERE `id_laporan_bulanan` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
                    // $r = $this->db->query($q)->result_array();
                    $r = array(
                        'cihanjuang_rahayu' => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 1),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 1)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 1),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 1),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 1),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 1),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 1),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 1)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 1),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 1),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 1),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 1),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 1),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 1)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1)
                        ),
                        'cihanjuang'        => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 2),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 2)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 2),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 2),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 2),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 2),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 2),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 2)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 2),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 2),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 2),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 2),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 2),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 2)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 2)
                        ),
                        'sariwangi'         => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 3),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 3)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 3),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 3),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 3),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 3),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 3),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 3)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 3),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 3),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 3),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 3),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 3),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 3)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 3)
                        ),
                        'karyawangi'        => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 4),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 4)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 4),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 4),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 4),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 4),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 4),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 4)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 4),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 4),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 4),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 4),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 4),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 4)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 4)
                        ),
                        'cihideung'         => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 5),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 5)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 5),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 5),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 5),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 5),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 5),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 5)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 5),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 5),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 5),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 5),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 5),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 5)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 6)
                        ),
                        'cigugur'           => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 7),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 7)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 7),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 7),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 7),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 7),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 7),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 7)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 7),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 7),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 7),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 7),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 7),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 7)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 7)
                        ),
                        'cipanas'           => array(
                            'kia'       => array(
                                'baru'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'baru', 8),
                                'lama'  => $this->count_kia($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 'lama', 8)
                            ),
                            'kb'        => array(
                                'baru'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 1, 8),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 2, 8),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 3, 8),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 4, 8),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 5, 8),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 1, 6, 8)
                                ),
                                'lama'  => array(
                                    'suntik_1_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 1, 8),
                                    'suntik_3_bulan'    => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 2, 8),
                                    'pil'               => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 3, 8),
                                    'iud_bkkbn'         => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 4, 8),
                                    'iud_non_bkkbn'     => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 5, 8),
                                    'kondom'            => $this->count_kb($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 0, 6, 8)
                                )
                            ),
                            'imunisasi' => array(
                                'hb0'               => $this->count_imunisasi_hb0($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'bcg'               => $this->count_imunisasi_bcg($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'pentabio_1'        => $this->count_imunisasi_pentabio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'pentabio_2'        => $this->count_imunisasi_pentabio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'pentabio_3'        => $this->count_imunisasi_pentabio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'pentabio_ulang'    => $this->count_imunisasi_pentabio_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'polio_1'           => $this->count_imunisasi_polio1($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'polio_2'           => $this->count_imunisasi_polio2($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'polio_3'           => $this->count_imunisasi_polio3($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'polio_4'           => $this->count_imunisasi_polio4($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'tt'                => $this->count_imunisasi_tt($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'campak'            => $this->count_imunisasi_campak($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8),
                                'campak_ulang'      => $this->count_imunisasi_campak_ulang($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8)
                            ),
                            'partus'    => $this->count_partus($r[0]['tahun_laporan'], $r[0]['bulan_laporan'], 8)
                        )
                    );
                    break;
                case '2':
                    $q = "SELECT * FROM `jenis_penyakit` WHERE `deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    $q = "SELECT * FROM `rentang_umur` WHERE `deleted_at` IS NULL;";
                    $u = $this->db->query($q)->result_array();
                    if (count($r) > 0) {
                        for ($i=0; $i < count($r); $i++) { 
                            if (count($u) > 0) {
                                for ($j=0; $j < count($u); $j++) { 
                                    $q = "SELECT COUNT(*) AS `total` FROM `detail_pemeriksaan_umum` WHERE `jenis_kelamin` = 'L' AND `id_penyakit` = '". $r[$i]['id'] ."' AND `id_rentang_umur` = '". $u[$j]['id'] ."' AND `deleted_at` IS NULL AND `created_at` IS NOT NULL;";
                                    $sum = $this->db->query($q)->result_array();
                                    $sumL = $sum[0]['total'];
                                    $q = "SELECT COUNT(*) AS `total` FROM `detail_pemeriksaan_umum` WHERE `jenis_kelamin` = 'P' AND `id_penyakit` = '". $r[$i]['id'] ."' AND `id_rentang_umur` = '". $u[$j]['id'] ."' AND `deleted_at` IS NULL AND `created_at` IS NOT NULL;";
                                    $sum = $this->db->query($q)->result_array();
                                    $sumP = $sum[0]['total'];
                                    $u[$j]['L'] = $sumL;
                                    $u[$j]['P'] = $sumP;
                                }
                                $r[$i]['rekap'] = $u;
                            }
                        }
                    }

                    $result['rentangUmur'] = $u;
                    break;
                case '3':
                    $q = "SELECT * FROM `detail_program_ispa` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '4':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_satuan`,
                                c.`nama_alat`
                            FROM 
                                `detail_pemeriksaan_kb` a 
                            LEFT JOIN
                                `satuan_usia` b
                                    ON
                                a.`id_satuan_usia` = b.`id`
                            LEFT JOIN
                                `alat_kontrasepsi` c
                                    ON
                                a.`id_alat_kontrasepsi` = c.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                            AND 
                                a.`deleted_at` IS NULL
                            ;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '5':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_tindakan` 
                            FROM 
                                `detail_imunisasi` a
                            LEFT JOIN
                                `macam_tindakan_imunisasi` b
                                    ON
                                a.`id_macam_tindakan_imunisasi` = b.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                                    AND 
                                a.`deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '6':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_pasien`
                            FROM 
                                `detail_persalinan` a 
                            LEFT JOIN
                                `pasiens` b
                                    ON
                                a.`id_pasien` = b.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                                    AND 
                                a.`deleted_at` IS NULL
                            ;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '7':
                    $q =    "SELECT 
                                a.*,
                                b.`nama_pasien`
                            FROM 
                                `detail_pemeriksaan_kehamilan` a 
                            LEFT JOIN
                                `pasiens` b
                                    ON
                                a.`id_pasien` = b.`id`
                            WHERE 
                                a.`created_at` LIKE '". $periode ."%' 
                                    AND 
                                a.`deleted_at` IS NULL;";
                    $r = $this->db->query($q)->result_array();
                    break;
                case '8':
                    $hamil = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_hamil($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($hamil, $jml);
                    }

                    $hamil_baru = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_hamil_baru($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($hamil_baru, $jml);
                    }

                    $kb = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_kb($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($kb, $jml);
                    }

                    $iud = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_iud($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($iud, $jml);
                    }

                    $sakit = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_sakit($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($sakit, $jml);
                    }

                    $imunisasi = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_imunisasi($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($imunisasi, $jml);
                    }

                    $usg = array();
                    for ($i=0; $i < 31; $i++) { 
                        array_push($usg, 0);
                    }

                    $partus = array();
                    for ($i=0; $i < 31; $i++) { 
                        $jml = $this->count_harian_partus($periode.'-'.str_pad($i+1, 2, '0', STR_PAD_LEFT));
                        array_push($partus, $jml);
                    }

                    $r = array(
                        'hamil' => $hamil,
                        'hamil_baru' => $hamil_baru,
                        'kb' => $kb,
                        'iud' => $iud,
                        'sakit' => $sakit,
                        'imunisasi' => $imunisasi,
                        'usg' => $usg,
                        'partus' => $partus
                    );
                    break;
                default:
                    # code...
                    break;
            }

            $result['detail'] = $r;
        }

        return $result;
    }

    function count_kia($thn = 2019, $bln = 01, $kia = 'baru', $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_pemeriksaan_kehamilan` a
                LEFT JOIN
                    `pasiens` b
                        ON
                    a.`id_pasien` = b.`id`
                WHERE 
                    b.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`buku_kia` = '". $kia ."' 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_kb($thn = 2019, $bln = 01, $baru = 1, $alat = 1, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_pemeriksaan_kb` a 
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`pasang_baru` = '". $baru ."' 
                        AND 
                    a.`id_alat_kontrasepsi` = '". $alat ."' 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_hb0($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`hb0` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_bcg($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`bcg` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_polio1($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`polio1` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_polio2($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`polio2` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_polio3($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`polio3` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_polio4($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`polio4` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_pentabio1($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`pentabio1` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_pentabio2($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`pentabio2` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_pentabio3($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`pentabio3` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_pentabio_ulang($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`pentabio_ulang` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_campak($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`campak` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_campak_ulang($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`campak_ulang` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_tt($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`tt` = 1 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_imunisasi_tindakan($thn = 2019, $bln = 01, $tindakan = 1, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_imunisasi` a
                LEFT JOIN
                    `antrians` b
                        ON
                    a.`id_antrian` = b.`id`
                LEFT JOIN
                    `pasiens` c
                        ON
                    b.`id_pasien` = c.`id`
                WHERE 
                    c.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`id_macam_tindakan_imunisasi` = '". $tindakan ."'
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_partus($thn = 2019, $bln = 01, $desa = 1)
    {
        $q = "  SELECT 
                    a.* 
                FROM 
                    `detail_persalinan` a
                LEFT JOIN
                    `pasiens` b 
                        ON
                    a.`id_pasien` = b.`id`
                WHERE 
                    b.`id_desa` = '". $desa ."'
                        AND
                    a.`created_at` LIKE '". $thn ."-". $bln ."-%' 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function count_harian_hamil($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_pemeriksaan_kehamilan` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

    function count_harian_hamil_baru($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_pemeriksaan_kehamilan` WHERE `baru_lama` = 'BARU' AND `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

    function count_harian_kb($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_pemeriksaan_kb` WHERE `id_alat_kontrasepsi` IN ('1','2','3') AND `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

    function count_harian_iud($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_pemeriksaan_kb` WHERE `id_alat_kontrasepsi` IN ('4','5') AND `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

    function count_harian_sakit($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_pemeriksaan_umum` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

    function count_harian_imunisasi($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_imunisasi` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

    function count_harian_partus($periode = '0000-00-00')
    {
        $q = "SELECT * FROM `detail_persalinan` WHERE `created_at` LIKE '". $periode ."%' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        return count($r);
    }

}