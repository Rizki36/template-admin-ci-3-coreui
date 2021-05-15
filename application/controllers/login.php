<?php
class login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Akses', 'akses');
        $this->load->model('M_User', 'login');
    }

    function index()
    {
        $Akses = $this->akses->CekWaktu();
        if ($Akses) {
            redirect('admin/dashboard');
        }
        $this->load->view('admin/v_login');
    }

    function auth()
    {
        $username = strip_tags(str_replace("'", "", $this->input->post('UserName')));
        $password = strip_tags(str_replace("'", "", $this->input->post('Password')));
        $u = $username;
        $p = base64_encode($password);
        $cadmin = $this->login->get_login_person(['UserName' => $u, 'Password' => $p, 'u.IsAktif' => 1]);
        if ($cadmin) {
            $row = $cadmin;
            $waktu = time() + 25200;
            $expired = 30000;
            $row['timeout']  = ($waktu + $expired);
            $this->session->set_userdata($row);
            redirect('admin/dashboard');
        } else {
            $response = ['icon' => 'error', 'title' => 'Gagal Login!', 'text' => 'Data user tidak ditemukan.'];
            $this->session->set_flashdata('msg', $response);
            redirect('login');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
