<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Akses', 'akses');
        $Akses = $this->akses->CekWaktu();
        if (!$Akses) {
            redirect('login');
        }
    }

    function _remap($method, $params = array())
    {
        $method_exists = method_exists($this, $method);
        $methodToCall = $method_exists ? $method : 'index';
        $this->$methodToCall($method_exists ? $params : $method);
    }

    public function index()
    {
        $x['menu'] = 'Dashboard';
        $x['view'] = 'admin/v_dashboard';

        loadview($x);
    }
}
