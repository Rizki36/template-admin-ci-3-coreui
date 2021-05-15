<?php
defined('BASEPATH') or exit('No direct script access allowed');

class konten extends CI_Controller
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
        $jenisKonten = $this->uri->segment('3');
        $nmr = $this->uri->segment('4');

        $a = $this->input->get('a') != '' ? (int)$this->input->get('a') : 1;
        $v = $this->input->get('v') != '' ? $this->input->get('v') : '';

        $whereData = "k.JenisKonten = '$jenisKonten'";

        $whereData .= $whereData != '' && $a != -1 ? ' AND ' : '';
        $whereData .= $a != -1 ? "k.IsAktif = $a" : '';

        $whereData .= $whereData != '' && $v != '' ? ' AND ' : '';
        $whereData .= $v != '' ? "k.JudulKonten LIKE '%$v%'" : '';

        $whereData = $whereData !== '' ? $whereData : [];

        $config = getPaginationConfig();
        $config['base_url'] = site_url('admin/konten/' . $jenisKonten);
        $config['total_rows'] = $this->konten->jumlah_data_konten($whereData);
        $config['per_page'] = 10;
        $from = $nmr != array() && $nmr != '' && $nmr != null ? $nmr : 0;
        $this->pagination->initialize($config);

        $x['a'] = $a;
        $x['v'] = $v;
        $x['jenisKonten'] = $jenisKonten;
        $x['data'] = $this->konten->get_data_konten($whereData, $from, $config['per_page']);

        $x['menu'] = $jenisKonten;
        $x['view'] = 'admin/konten/v_konten';
        $x['pagination'] = $this->pagination->create_links();
        $x['breadcrumb'][] = array('Name' => $jenisKonten, 'Url' => '', 'IsAktif' => 0);

        loadview($x);
    }

    public function tambah()
    {
        $jenisKonten = $this->uri->segment(4);
        $data['jenisKonten'] = $jenisKonten;
        $data['menu'] = $jenisKonten;
        $data['view'] = 'admin/konten/v_konten_tambah';
        $data['breadcrumb'][] = array('Name' => $jenisKonten, 'Url' => '', 'IsAktif' => 1);
        loadview($data);
    }

    public function setStatus()
    {
        $jenisKonten = $this->uri->segment(4);
        $KodeKonten = base64_decode($this->uri->segment(5));
        $setStatus = (int)$this->uri->segment(6);
        $whereData = ['KodeKonten' => $KodeKonten, 'JenisKonten' => $jenisKonten];
        $data = $this->konten->update_data_konten($whereData, ['IsAktif' => $setStatus]);

        if ($data) {
            $msg = $setStatus > 0 ? 'Berhasil Mengaktifkan Data' : 'Berhasil Menonaktifkan Data';
            $response = ['icon' => 'success', 'title' => $msg, 'text' => ''];
        } else {
            $msg = $setStatus > 0 ? 'Gagal Mengaktifkan Data' : 'Gagal Menonaktifkan Data';
            $response = ['icon' => 'error', 'title' => $msg, 'text' => ''];
        }

        $this->session->set_flashdata('msg', $response);
        redirect('admin/konten/' . $jenisKonten);
    }

    public function hapus()
    {
        $jenisKonten = $this->uri->segment(4);
        $id  = base64_decode($this->input->get('id'));
        $img  = $this->input->get('img');
        $result = $this->konten->delete_data_konten(['KodeKonten' => $id]);
        
        if ($result) {
            delete_file("assets/img/$jenisKonten", $img);
            delete_file("assets/img/$jenisKonten", "thum_$img");
            $response = ['icon' => 'success', 'title' => 'Berhasil menghapus data', 'text' => ''];
        } else {
            $response = ['icon' => 'error', 'title' => 'Gagal menghapus data', 'text' => ''];
        }
        $this->session->set_flashdata('msg', $response);
        
        redirect("admin/konten/$jenisKonten");
    }

    public function edit()
    {
        $jenisKonten = $this->uri->segment(4);
        $KodeKonten = base64_decode($this->uri->segment(5));

        $x['jenisKonten'] = $jenisKonten;
        $x['data'] = $this->konten->get_one_konten(array('KodeKonten' => $KodeKonten));

        $x['menu'] = $jenisKonten;
        $x['view'] = 'admin/konten/v_konten_tambah';
        $x['breadcrumb'][] = array('Name' => $jenisKonten, 'Url' => '', 'IsAktif' => 1);
        $x['breadcrumb'][] = array('Name' => 'Edit Data ' . $jenisKonten, 'Url' => '', 'IsAktif' => 0);
        loadview($x);
    }

    public function simpan()
    {
        $this->load->library('upload');

        $jenisKonten = $this->uri->segment(4);
        $KodeKonten = $this->input->post('KodeKonten');

        if ($KodeKonten == '') {
            $edit = false;
            $result = $this->insert($jenisKonten);
        } else {
            $edit = true;
            $result = $this->update($KodeKonten, $jenisKonten);
        }

        if ($result) {
            $msg = $edit ? 'Berhasil Update Data' : 'Berhasil Input Data';
            $response = ['icon' => 'success', 'title' => $msg, 'text' => ''];
        } else {
            $msg = $edit ? 'Gagal Update Data' : 'Gagal Input Data';
            $response = ['icon' => 'error', 'title' => $msg, 'text' => ''];
        }

        $this->session->set_flashdata('msg', $response);
        redirect('admin/konten/' . $jenisKonten);
    }

    private function insert($jenisKonten)
    {
        $KodeKonten = $this->konten->get_kode_konten();

        $name = $KodeKonten . '_' . date("YmdHis");
        $path = "assets/img/$jenisKonten";
        $Gambar1 = insert_file($_FILES['Gambar1'], $path, $name);
        create_thumbnail($_FILES['Gambar1'], $path, $Gambar1); // membuat thumbnail

        $insert_data = $this->input->post(['JudulKonten', 'Keterangan', 'IsiKonten', 'UserName']);
        $insert_data['Slug'] = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($insert_data['JudulKonten'])));
        $insert_data['KodeKonten'] = $KodeKonten;
        $insert_data['Gambar1'] = $Gambar1;
        $insert_data['IsAktif'] = 1;
        $insert_data['JenisKonten'] = $jenisKonten;
        $insert_data['TanggalKonten'] = date('Y-m-d', strtotime($this->input->post('TanggalKonten')));

        return $this->konten->add_data_konten($insert_data);
    }

    private function update($KodeKonten, $jenisKonten)
    {
        $path = "assets/img/$jenisKonten";
        $name = $KodeKonten . '_' . date("YmdHis");
        $old_name = $this->input->post('Gambar1');
        $Gambar1 = update_file($_FILES['Gambar1'], $path, $name, $old_name);
        update_thumbnail($_FILES['Gambar1'], $path, $Gambar1, $old_name);

        $update_data = $this->input->post(['JudulKonten', 'Keterangan', 'IsiKonten', 'UserName']);
        $update_data['Slug'] = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($update_data['JudulKonten'])));
        $update_data['Gambar1'] = $Gambar1;
        $update_data['IsAktif'] = 1;
        $update_data['JenisKonten'] = $jenisKonten;
        $update_data['TanggalKonten'] = date('Y-m-d', strtotime($this->input->post('TanggalKonten')));

        return $this->konten->update_data_konten(['KodeKonten' => $KodeKonten], $update_data);
    }
}
