<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pesan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Kontak', 'kontak');
        // $this->load->model('M_Akses', 'akses');
        // $Akses = $this->akses->CekWaktu();
        // if ($Akses) {
        //     redirect('Admin/Beranda');
        // }        
    }

    function _remap($method, $params = array())
    {
        $method_exists = method_exists($this, $method);
        $methodToCall = $method_exists ? $method : 'index';
        $this->$methodToCall($method_exists ? $params : $method);
    }

    public function index()
    {
        $nmr = $this->uri->segment('3');
        $a = $this->input->get('a') != '' ? (int)$this->input->get('a') : 0;
        $v = $this->input->get('v') != '' ? $this->input->get('v') : '';

        $date = date('Y-m-d', strtotime($v));

        // where data
        // $whereData = $a != -1 ? $whereData = "k.IsDibaca = $a" : '';
        $whereData = '';

        $whereData .= $whereData != '' && $v != '' ? ' AND ' : '';
        $whereData .= $v != '' ? "DATE_FORMAT(k.Tanggal, '%Y-%m-%d') = '$date'" : '';

        $whereData = $whereData !== '' ? $whereData : [];

        $config = getPaginationConfig();
        $config['base_url'] = site_url('admin/pesan');
        $config['total_rows'] = $this->kontak->jumlah_data_kontak($whereData);
        $config['per_page'] = 10;
        $from = $nmr != array() && $nmr != '' && $nmr != null ? $nmr : 0;

        $this->pagination->initialize($config);
        $x['a']  = $a;
        $x['v']  = $v;
        $x['data'] = $this->kontak->get_data_kontak($whereData, $from, $config['per_page']);

        // view variable
        $x['view'] = 'admin/pesan/v_pesan';
        $x['menu'] = 'pesan';
        $x['pagination'] = $this->pagination->create_links();
        $x['breadcrumb'][] = array('Name' => 'Pesan', 'Url' => '', 'IsAktif' => 1);

        loadview($x);
    }

    public function detail()
    {
        $KodeKontak  = base64_decode($this->input->get('id'));
        $result = $this->kontak->update_data_kontak(['KodeKontak' => $KodeKontak], ['IsDibaca' => 1]);
        echo json_encode($result);
        // $data = $this->kontak->get_one_kontak(['k.KodeKontak' => $KodeKontak]);
        // echo $data ? json_encode($data) : json_encode(array());

    }

    public function hapus()
    {
        $KodeKontak  = $this->input->post('KodeKontak');
        $result      = $this->kontak->delete_data_kontak(array('KodeKontak' => $KodeKontak));

        if ($result) {
            $response = ['icon' => 'success', 'title' => 'Berhasil Hapus Data', 'text' => ''];
        } else {
            $response = ['icon' => 'error', 'title' => 'Gagal Hapus Data', 'text' => ''];
        }

        $this->session->set_flashdata('msg', $response);
        redirect('Admin/Pesan');
    }
}
