<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Konten extends CI_Model
{

    public function jumlah_data_konten($whereData)
    {
        $stmt = $this->db->select('COUNT(*) AS Jumlah')
            ->from('kontenweb k')
            ->where($whereData)
            ->get();

        $data = $stmt->row();
        if ($data) {
            return $data->Jumlah;
        } else {
            return 0;
        }
    }

    public function get_data_konten($whereData, $limit = 0, $offset = 0)
    {
        $this->db->select('k.KodeKonten, k.JudulKonten, k.JenisKonten, k.IsiKonten, k.Keterangan, k.TanggalKonten, k.Gambar1, k.Gambar2, k.Gambar3, k.Author, k.IsAktif,k.Slug')
            ->from('kontenweb k')
            ->where($whereData)
            ->order_by("k.KodeKonten", "desc");
        if ($offset > 0) {
            $this->db->limit($offset, $limit);
        }
        return $this->db->get()->result();
    }

    public function get_one_konten($whereData)
    {
        return $this->db->select('k.KodeKonten, k.JudulKonten, k.JenisKonten, k.IsiKonten, k.Keterangan, k.TanggalKonten, k.Gambar1, k.Gambar2, k.Gambar3, k.Author, k.IsAktif,k.Slug')
            ->from('kontenweb k')
            ->where($whereData)
            ->get()
            ->row();
    }


    public function add_data_konten($data)
    {
        $this->db->insert('kontenweb', $data);
        return $this->db->affected_rows();
    }

    public function update_data_konten($whereData, $data)
    {
        $this->db->where($whereData);
        $this->db->update('kontenweb', $data);
        return $this->db->affected_rows();
    }

    public function delete_data_konten($wheredata)
    {
        return $this->db->delete('kontenweb', $wheredata);
    }

    public function get_data_konten_list($whereData)
    {
        return $this->db->select('k.KodeKonten, k.JudulKonten, k.JenisKonten, k.IsiKonten, k.Keterangan, k.TanggalKonten, k.Gambar1, k.Gambar2, k.Gambar3, k.Author, k.IsAktif')
            ->from('kontenweb k')
            ->where($whereData)
            ->order_by("k.KodeKonten", "desc")
            ->get()
            ->result();
    }

    public function get_kode_konten()
    {
        $Tahun = date('Y');
        $sql = "SELECT RIGHT(KodeKonten,7) AS kode FROM kontenweb WHERE KodeKonten LIKE '%$Tahun%' ORDER BY KodeKonten DESC LIMIT 1";
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
        $kode_jadi = "KTN-" . $Tahun . "-" . $bikin_kode;
        return $kode_jadi;
    }
}
