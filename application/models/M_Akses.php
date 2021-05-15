<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Akses extends CI_Model{
	
	public function CekWaktu()
	{
		if($this->session->userdata('UserName') != ''){
			$waktu    = time()+25200;
			$expired  = 30000;
			$timeout = $this->session->userdata('timeout');	
			if($waktu < $timeout){
				$this->session->unset_userdata('timeout');
				$this->session->set_userdata('timeout', ($waktu + $expired));
				return true;
			}else{
				$this->session->sess_destroy();
				return false;
			}
		}else{
			return false;
		}		
	}
}