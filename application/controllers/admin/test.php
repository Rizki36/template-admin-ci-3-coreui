<?php
defined('BASEPATH') or exit('No direct script access allowed');

class test extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
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
        $x['view'] = 'admin/v_test';

        loadview($x);
    }
}
