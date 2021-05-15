<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->model('M_Setting', 'setting');
        $this->load->model('M_Konten', 'konten');
    }

    function _remap($method, $params = array())
    {
        $method_exists = method_exists($this, $method);
        $methodToCall = $method_exists ? $method : 'index';
        $this->$methodToCall($method_exists ? $params : $method);
    }

    public function index($nmr)
    {
        $v = $this->input->post('v') ? $this->input->post('v') : '';

        if ($v != '') {
            $wheredata = "JenisKonten = 'Berita'  And JudulKonten like '%$v%'";
        } else {
            $wheredata = "JenisKonten = 'Berita'";
        }

        $jumlah_data = $this->konten->jumlah_data_konten($wheredata);
        $config = getPaginationConfig();
        $config['base_url'] = site_url('Blog');
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 3;
        $from = $nmr != array() && $nmr != '' && $nmr != null ? $nmr : 0;
        $this->pagination->initialize($config);
        $x['pagination'] = $this->pagination->create_links();
        $x['data'] = $this->konten->get_data_konten($from, $config['per_page'], $wheredata);
        $x['view'] = 'client/blog/c_blog';
        loadview_client($x);
    }

    public function detail()
    {
        $Slug = $this->uri->segment('3');
        $x['data'] = $this->konten->get_one_konten(['k.Slug' => $Slug]);
        $x['view'] = 'client/blog/c_blog_detail';
        loadview_client($x);
    }
}
