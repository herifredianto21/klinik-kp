<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Macam_tindakan_imunisasi_model extends CI_Model {

    function select( $id = 0 )
    {
        $result = array(
            'result'    => false,
            'msg'       => ''  
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `macam_tindakan_imunisasi` WHERE `deleted_at` IS NULL ORDER BY `nama_tindakan` ASC;";
        } else{
            $q = "SELECT * FROM `macam_tindakan_imunisasi` WHERE `deleted_at` IS AND `id` = '". $this->db->escape_str( $id ) ."' NULL ORDER BY `nama_tindakan` ASC;";
        }

        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

        return $result;
    }

}