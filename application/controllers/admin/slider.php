<?php
defined('BASEPATH') or exit('No direct script access allowed');

class slider extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Konten', 'konten');
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

        $a = $this->input->get('a') != '' ? (int)$this->input->get('a') : 1;
        $v = $this->input->get('v') != '' ? $this->input->get('v') : '';

        $whereData = "k.JenisKonten = 'slider'";

        $whereData .= $whereData != '' && $a != -1 ? ' AND ' : '';
        $whereData .= $a != -1 ? "k.IsAktif = $a" : '';

        $whereData .= $whereData != '' && $v != '' ? ' AND ' : '';
        $whereData .= $v != '' ? "k.JudulKonten LIKE '%$v%'" : '';

        $whereData = $whereData !== '' ? $whereData : [];

        $config = getPaginationConfig();
        $config['base_url'] = site_url('admin/konten/' . 'slider');
        $config['total_rows'] = $this->konten->jumlah_data_konten($whereData);
        $config['per_page'] = 10;
        $from = $nmr != array() && $nmr != '' && $nmr != null ? $nmr : 0;
        $this->pagination->initialize($config);

        $x['a'] = $a;
        $x['v'] = $v;
        $x['jenisKonten'] = 'slider';
        $x['data'] = $this->konten->get_data_konten($whereData, $from, $config['per_page']);

        $x['menu'] = 'slider';
        $x['view'] = 'admin/slider/v_slider';
        $x['pagination'] = $this->pagination->create_links();
        $x['breadcrumb'][] = array('Name' => 'Slider', 'Url' => '', 'IsAktif' => 1);

        loadview($x);
    }

    public function hapus()
    {
        $KodeBerita  = base64_decode($this->input->get('id'));
        $Gambar1  = $this->input->get('img');

        $data = $this->konten->delete_data_konten(array('KodeKonten' => $KodeBerita));
        if ($data) {
            delete_file('assets/img/slider', $Gambar1);
            delete_file('assets/img/slider', "thum_$Gambar1");
            $response = ['icon' => 'success', 'title' => 'Berhasil hapus data', 'text' => ''];
        } else {
            $response = ['icon' => 'error', 'title' => 'Gagal hapus data', 'text' => ''];
        }
        $this->session->set_flashdata('msg', $response);
        redirect('admin/slider');
    }

    public function simpan()
    {
        $this->load->library('upload');
        $KodeKonten = $this->input->post('KodeKonten');

        if ($KodeKonten == '') {
            $edit = false;
            $result = $this->insert();
        } else {
            $edit = true;
            // tidak usah update
        }

        if ($result) {
            $msg = $edit ? 'Berhasil Update Data' : 'Berhasil Input Data';
            $response = ['icon' => 'success', 'title' => $msg, 'text' => ''];
        } else {
            $msg = $edit ? 'Gagal Update Data' : 'Gagal Input Data';
            $response = ['icon' => 'error', 'title' => $msg, 'text' => ''];
        }

        $this->session->set_flashdata('msg', $response);
        redirect('admin/slider');
    }

    private function insert()
    {
        $KodeKonten = $this->konten->get_kode_konten();

        $name = $KodeKonten . '_' . date("YmdHis");
        $path = "assets/img/slider";
        $Gambar1 = insert_file($_FILES['Gambar1'], $path, $name);
        create_thumbnail($_FILES['Gambar1'], $path, $Gambar1); // membuat thumbnail

        $insert_data = $this->input->post(['JudulKonten']);
        $insert_data['KodeKonten'] = $KodeKonten;
        $insert_data['Gambar1'] = $Gambar1;
        $insert_data['IsAktif'] = 1;
        $insert_data['JenisKonten'] = 'slider';
        $insert_data['TanggalKonten'] = date('Y-m-d', strtotime($this->input->post('TanggalKonten')));

        return $this->konten->add_data_konten($insert_data);
    }
}
