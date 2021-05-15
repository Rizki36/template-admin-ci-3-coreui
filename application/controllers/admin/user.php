<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_User');
        // $Akses = $this->akses->CekWaktu();
        // if (!$Akses) {
        //     redirect('Login');
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
        $nmr = $this->uri->segment(3);
        $a = $this->input->get('a') != '' ? (int)$this->input->get('a') : 1;
        $v = $this->input->get('v') != '' ? $this->input->get('v') : '';

        // where data
        $whereData = $a != -1 ? $whereData = "u.IsAktif = $a" : '';

        $whereData .= $whereData != '' && $v != '' ? ' AND ' : '';
        $whereData .= $v != '' ? "u.NamaUser LIKE '%$v%'" : '';

        $whereData = $whereData !== '' ? $whereData : [];

        // init pagination
        $config = getPaginationConfig();
        $config['base_url'] = site_url('admin/user');
        $config['total_rows'] = $this->M_User->jumlah_data_user($whereData);
        $config['per_page'] = 5;
        $from = $nmr != array() && $nmr != '' && $nmr != null ? $nmr : 0;
        $this->pagination->initialize($config);

        // data
        $x['data'] = $this->M_User->get_data_user($whereData, $from, $config['per_page']);
        $x['a'] = $a;
        $x['v'] = $v;

        // view variable
        $x['menu'] = 'user';
        $x['view'] = 'admin/user/v_user';
        $x['pagination'] = $this->pagination->create_links();
        $x['breadcrumb'][] = array('Name' => "User", 'Url' => '', 'IsAktif' => 1);

        loadview($x);
    }

    public function tambah()
    {
        $x['menu'] = 'user';
        $x['view'] = 'admin/user/v_user_tambah';
        $x['breadcrumb'][] = ['Name' => 'Data User', 'Url' => base_url('admin/user'), 'IsAktif' => 0];
        $x['breadcrumb'][] = ['Name' => "Tambah Data", 'Url' => '', 'IsAktif' => 1];
        loadview($x);
    }

    public function edit()
    {
        $UserName = base64_decode($this->uri->segment(4));

        $x['data'] = $this->M_User->get_one_user("UserName = '$UserName'");
        $x['menu'] = 'user';
        $x['view'] = 'admin/user/v_user_tambah';
        $x['breadcrumb'][] = ['Name' => 'Data User', 'Url' => base_url('admin/user'), 'IsAktif' => 0];
        $x['breadcrumb'][] = ['Name' => "Edit Data", 'Url' => '', 'IsAktif' => 1];
        loadview($x);
    }

    public function simpan()
    {
        $this->load->library('upload');
        $edit = false;
        $UserNameLama = $this->input->post('UserNameLama');
        if ($UserNameLama == '') {
            $edit   = false;
            $result = $this->insert();
        } else {
            $edit   = true;
            $result = $this->update($UserNameLama);
        }

        if ($result) {
            $msg = $edit ? 'Berhasil Update Data' : 'Berhasil Input Data';
            $response = ['icon' => 'success', 'title' => $msg, 'text' => ''];
        } else {
            $msg = $edit ? 'Gagal Update Data' : 'Gagal Input Data';
            $response = ['icon' => 'error', 'title' => $msg, 'text' => ''];
        }

        $this->session->set_flashdata('msg', $response);
        redirect('admin/user');
    }

    private function insert()
    {
        $inserData = $this->input->post([
            "UserName",
            "Password",
            "NamaUser",
            "NIK",
            "Alamat",
            "TempatLahir",
            "TglLahir"
        ]);

        $inserData['IsAktif'] = 1;
        $inserData['Password'] = base64_encode($inserData['Password']);
        $inserData['TglLahir'] = date('Y-m-d', strtotime($inserData['TglLahir']));

        $name = $config['file_name'] = $inserData['UserName'] . '_' . date("YmdHis");
        $inserData['Foto'] = insert_file($_FILES['Foto'], 'assets/admin/img/users', $name);
        return $this->M_User->add_data_user($inserData);
    }

    private function update($UserNameLama)
    {
        $updateData = $this->input->post([
            "Password",
            "NamaUser",
            "Alamat",
            "TempatLahir",
            "TglLahir",
        ]);

        $updateData['Password'] = base64_encode($updateData['Password']);
        $updateData['TglLahir'] = date('Y-m-d', strtotime($updateData['TglLahir']));

        $name = $UserNameLama . '_' . date("YmdHis");
        $old_name = $this->input->post('Foto');
        $updateData['Foto'] = update_file($_FILES['Foto'], 'assets/admin/img/users', $name, $old_name);
        return $this->M_User->update_data_user(['UserName' => $UserNameLama], $updateData);
    }

    public function Hapus()
    {
        $UserName = $this->input->get('id');
        $foto = $this->input->get('img');
        $result = $this->M_User->delete_data_user(['UserName' => $UserName]);
     
        if ($result) {
            delete_file('assets/admin/img/users', $foto);
            $response = ['icon' => 'success', 'title' => 'Berhasil menghapus data', 'text' => ''];
        } else {
            $response = ['icon' => 'error', 'title' => 'Gagal menghapus data', 'text' => ''];
        }
        $this->session->set_flashdata('msg', $response);
     
        redirect('admin/user');
    }

    public function setStatus()
    {
        $UserName   = base64_decode($this->uri->segment(4));
        $setStatus = (int) $this->uri->segment(5);
        $data = $this->M_User->update_data_user(['NIK' => $UserName], ['IsAktif' => $setStatus]);

        if ($data) {
            $msg = $setStatus > 0 ? 'Berhasil Mengaktifkan Data' : 'Berhasil Menonaktifkan Data';
            $response = ['icon' => 'success', 'title' => $msg, 'text' => ''];
        } else {
            $msg = $setStatus > 0 ? 'Gagal Mengaktifkan Data' : 'Gagal Menonaktifkan Data';
            $response = ['icon' => 'error', 'title' => $msg, 'text' => ''];
        }

        $this->session->set_flashdata('msg', $response);
        redirect("admin/user");
    }

    public function detail()
    {
        $UserName = $this->input->get('UserName');
        $data = $this->M_User->get_one_user("UserName = '$UserName'");

        echo $data ? json_encode($data) : json_encode(array());
    }


    public function cekAdaUserName()
    {
        $UserName = $this->input->get('UserName');
        $count = $this->M_User->jumlah_data_user("UserName = '$UserName'");
        $adaUserName = $count > 0;
        echo json_encode($adaUserName);
    }
}
