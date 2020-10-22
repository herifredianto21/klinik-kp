<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
    
	function auth($data = array())
	{
		$result = false;

		$s = $data['session'];
		$q = "SELECT * FROM `session_log` WHERE `id_users` = '". $s['id'] ."' AND `token` = '". $s['token'] ."';";
		$r = $this->db->query($q, false)->result_array();
		if(count($r) > 0){
			$result = true;
		}

		return $result;
	}

	function login($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''  
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$q = "SELECT * FROM `users` a LEFT JOIN `employees` b ON a.`id` = b.`id` LEFT JOIN `roles` c ON b.`role` = c.`id` WHERE a.`email` = '". $this->db->escape_str($d['email']) ."' AND a.`password` = '". md5($d['password']) ."';";
		$r = $this->db->query($q, false)->result_array();
		if(count($r) > 0){
			$result['result'] = true;
			$result['target'] = base_url('dashboard/');

			$token = md5($r[0]['id'] . '_' . time());
			$userSession = array(
				'id'	=> $r[0]['id'],
				'name'	=> $r[0]['name'],
				'email'	=> $r[0]['email'],
				'role'	=> $r[0]['role'],
				'token'	=> $token
			);
			$this->session->set_userdata('userSession', $userSession);

			$q = "INSERT INTO `session_log` (`id_users`, `token`, `created_at`, `host`, `referer`, `agent`, `ipaddr`) VALUES ('". $userSession['id'] ."', '". $token ."', NOW(), '". $u['host'] ."', '". $u['referer'] ."', '". $u['agent'] ."', '". $u['ipaddr'] ."');";
			if(!$this->db->simple_query($q)){
				$result['result'] = false;
				$result['msg'] = 'Gagal menyimpan data session';
			}
		} else{
			$result['msg'] = 'Username atau password salah.';
		}

		return $result;
	}

}
