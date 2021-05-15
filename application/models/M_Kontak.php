<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Kontak extends CI_Model
{
    public function jumlah_data_kontak($whereData)
    {
        $stmt = $this->db->select('COUNT(*) AS Jumlah')
            ->from('kontak k')
            ->where($whereData)
            ->get();

        $data = $stmt->row();
        if ($data) {
            return $data->Jumlah;
        } else {
            return 0;
        }
    }

    public function get_data_kontak($whereData, $Limit = 0, $Offset = 0)
    {
        $this->db->select('k.KodeKontak, k.NamaPengirim, k.Subjek, k.Email, k.Tanggal, k.IsiPesan, k.NoTelepone, k.IsDibaca')
            ->from('kontak k')
            ->where($whereData)
            ->order_by("k.IsDibaca", "asc")
            ->order_by("k.Tanggal", "desc");
        if ($Offset > 0) {
            $this->db->limit($Offset, $Limit);
        }

        return $this->db->get()->result();
    }

    public function get_one_kontak($whereData)
    {
        return $this->db->select('k.KodeKontak, k.NamaPengirim, k.Subjek, k.Email, k.Tanggal, k.IsiPesan, k.NoTelepone, k.IsDibaca')
            ->from('kontak k')
            ->where($whereData)
            ->get()
            ->row();
    }

    public function add_data_kontak($data)
    {
        $this->db->insert('kontak', $data);
        return $this->db->affected_rows();
    }

    public function update_data_kontak($whereData, $data)
    {
        $this->db->where($whereData);
        $this->db->update('kontak', $data);
        return $this->db->affected_rows();
    }

    public function delete_data_kontak($wheredata)
    {
        return $this->db->delete('kontak', $wheredata);
    }

    public function get_kode_kontak()
    {
        $Tahun = date('Y');
        $sql = "SELECT RIGHT(KodeKontak,7) AS kode FROM kontak WHERE KodeKontak LIKE '%$Tahun%' ORDER BY KodeKontak DESC LIMIT 1";
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
        $kode_jadi = "MSG-" . $Tahun . "-" . $bikin_kode;
        return $kode_jadi;
    }
}
