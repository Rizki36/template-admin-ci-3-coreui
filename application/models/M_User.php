<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_User extends CI_Model
{

    public function jumlah_data_user($whereData)
    {
        $stmt = $this->db->select('COUNT(*) AS Jumlah')
            ->from('mstuser u')
            ->where($whereData)
            ->get();

        $data = $stmt->row();
        if ($data) {
            return $data->Jumlah;
        } else {
            return 0;
        }
    }

    public function get_data_user($whereData, $Limit = 0, $Offset = 0)
    {
        $user_fields = ["u.UserName", "u.NamaUser", "u.NIK", "u.Alamat", "u.TempatLahir", "u.TglLahir", " u.Foto", "u.Password", "u.IsAktif", "u.JenisUser", "u.KodeKlub", "u.KodeCabor"];
        $fields = array_merge($user_fields);

        $this->db->select($fields)
            ->from('mstuser u')
            ->where($whereData)
            ->order_by("u.UserName", "desc");
        if ($Offset > 0) {
            $this->db->limit($Offset, $Limit);
        }
        return $this->db->get()->result();
    }

    public function get_one_user($whereData)
    {
        $user_fields = ["u.UserName", "u.NamaUser", "u.NIK", "u.Alamat", "u.TempatLahir", "u.TglLahir", " u.Foto", "u.Password", "u.IsAktif", "u.JenisUser", "u.KodeKlub", "u.KodeCabor"];
        $fields = array_merge($user_fields);

        return $this->db->select($fields)
            ->from('mstuser u')
            ->where($whereData)
            ->get()
            ->row();
    }


    public function add_data_user($data)
    {
        $this->db->insert('mstuser', $data);
        return $this->db->affected_rows();
    }

    public function update_data_user($whereData, $data)
    {
        $this->db->where($whereData);
        $this->db->update('mstuser', $data);
        return $this->db->affected_rows();
    }

    public function delete_data_user($wheredata)
    {
        return $this->db->delete('mstuser', $wheredata);
    }

    public function get_kode_user()
    {
        $Tahun = date('Y');
        $sql = "SELECT RIGHT(UserName,7) AS kode FROM mstuser WHERE UserName LIKE '%$Tahun%' ORDER BY UserName DESC LIMIT 1";
        $res = $this->db->query($sql);
        if ($res) {
            $num = $res->num_rows();
            if ($num != 0) {
                $data = $res->row();
                $kode = $data->kode + 1;
            } else {
                $kode = 1;
            }
        } else {
            $kode = 1;
        }
        $bikin_kode = str_pad($kode, 7, "0", STR_PAD_LEFT);
        $kode_jadi = "USER-" . $Tahun . "-" . $bikin_kode;
        return $kode_jadi;
    }

    public function get_login_person($wheredata)
    {
        return $this->db->select('u.UserName, u.NamaUser, u.NIK, u.Alamat, u.TempatLahir, u.TglLahir, u.Foto, u.Password, u.IsAktif, u.JenisUser, u.KodeKlub, u.KodeCabor, cb.IsNPC,cb.IsKhusus')
            ->from('mstuser u')
            ->join('mstcabor cb', 'cb.KodeCabor = u.KodeCabor', 'left')
            ->where($wheredata)
            ->get()
            ->row_array();
    }
}
