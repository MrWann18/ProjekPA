<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MTandatangan extends CI_Model {

    // Fungsi untuk menyisipkan data PDF yang telah ditandatangani ke tabel 'tandatangan'
    public function insert_signed_pdf($data) {
        return $this->db->insert('tandatangan', $data);
    }

    // Fungsi untuk mengupdate kolom 'fileberkas' di tabel 'berkas' dengan path file baru
    public function update_berkas_file($idBerkas, $file_path) {
        $this->db->set('fileberkas', $file_path);
        $this->db->where('id', $idBerkas); // Pastikan 'id' adalah primary key di tabel berkas
        return $this->db->update('berkas');
    }

    // Fungsi untuk mendapatkan berkas berdasarkan idBerkas
    public function get_berkas_by_id($idBerkas) {
        $this->db->where('id', $idBerkas);
        $query = $this->db->get('berkas');
        return $query->row();
    }

    // Fungsi untuk mengupdate status di tabel 'berkas'
    public function increment_status($status_column, $idBerkas) {
        $this->db->set($status_column, $status_column . '+1', FALSE);
        $this->db->where('id', $idBerkas);
        return $this->db->update('berkas');
    }

    public function getLastId(){
        $this->db->select_max('id');
        $query = $this->db->get('tandatangan');
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id; // Mengembalikan id terakhir + 1
        } else {
            return 1; // Jika tabel kosong, mulai dari 1
        }
    }
}
