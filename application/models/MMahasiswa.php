<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class MMahasiswa extends CI_Model
{
    public $table = 'mahasiswa';
    // public $NIPmahasiswa = 'NIPmahasiswa';
    // public $Namamahasiswa = 'Namamahasiswa';
    // public $Passwordmahasiswa = 'Passwordmahasiswa';

    function __construct()
    {
        parent::__construct();
    }
    public function register($data) {
        $this->db->insert('mahasiswa', $data);
    }

    public function ambillogin($NIMMahasiswa, $PasswordMahasiswa, $remember_me = FALSE) {

        $this->db->where('NIMMahasiswa', $NIMMahasiswa);
        $this->db->where('PasswordMahasiswa', $PasswordMahasiswa);
        $query = $this->db->get('mahasiswa');
        if ($query->num_rows()>0){
            foreach ($query->result() as $row){
                $sess = array ('NIMMahasiswa' => $row->NIMMahasiswa,
                                'PasswordMahasiswa' => $row->PasswordMahasiswa);
            }
        $this->session->get_userdata($sess);
        
        redirect('AuthMahasiswa/berhasillogin');
        }
        else{
            $this->session->set_flashdata('info', 'Maaf, NIM dan Password anda salah!, mohon ulangi lagi');
            
        redirect('AuthMahasiswa/berhasillogout');
        }
    }

    public function keamanan(){
        $NIMMahasiswa = $this->session->userdata('username');
        if(empty($NIMMahasiswa)){
            $this->session->session_destroy();
            
            redirect('AuthMahasiswa/berhasillogout');
            
        }
    }

    function get_by_username($UsernameMahasiswa)
    {
        $this->db->where('NIMMahasiswa', $UsernameMahasiswa);
    }

    public function InsertRecord($data) {
        // Menyimpan data yang dikirim dari form ke database
        $this->db->insert('Berkas', $data);
        return $this->db->insert_id(); // Mengembalikan ID dari data yang baru disisipkan
    }

    public function InsertDataPengajuan($data) {
        $this->db->insert('berkas', $data);
    }

    public function getBerkas() {
        $query = $this->db->get('berkas');
        return $query->result();
    }

    public function getPengajuanByNIM($NIMMahasiswa) {
        $this->db->where('NIMMahasiswa', $NIMMahasiswa);
        $this->db->order_by('tanggalpengajuan', 'DESC');
        $query = $this->db->get('berkas'); // 'pengajuan' adalah nama tabel di database Anda
        return $query->result(); // Mengembalikan hasil query sebagai array objek
    }

    public function getPengajuanByID($idberkas) {
        $this->db->where('id', $idberkas);
        $query = $this->db->get('berkas'); // 'pengajuan' adalah nama tabel di database Anda
        return $query->result(); // Mengembalikan hasil query sebagai array objek
    }

    public function update_mahasiswa($nim, $nama, $password)
    {
        $this->db->set('NamaMahasiswa', $nama);
        $this->db->set('PasswordMahasiswa', $password); // Password tidak di-hash

        $this->db->where('NIMMahasiswa', $nim);
        $this->db->update('mahasiswa');
    }
}