<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class MDosen extends CI_Model
{
    public $table = 'dosen';
    // public $NIPmahasiswa = 'NIPmahasiswa';
    // public $Namamahasiswa = 'Namamahasiswa';
    // public $Passwordmahasiswa = 'Passwordmahasiswa';

    function __construct()
    {
        parent::__construct();
    }

    public function register($data) {
        $this->db->insert('dosen', $data);
    }

    public function ambillogin($NIPDosen, $PasswordDosen) {

        $this->db->where('NIPDosen', $NIPDosen);
        $this->db->where('PasswordDosen', $PasswordDosen);
        $query = $this->db->get('dosen');
        if ($query->num_rows()>0){
            foreach ($query->result() as $row){
                $sess = array ('NIPDosen' => $row->NIPDosen,
                                'PasswordDosen' => $row->PasswordDosen);
            }
        $this->session->get_userdata($sess);
        
        redirect('AuthDosen/berhasillogin');
        }
        else{
            $this->session->set_flashdata('info', 'Maaf, NIP atau Password anda salah!, mohon ulangi lagi');
            
        redirect('AuthDosen/berhasillogout');
        }
    }

    public function keamanan(){
        $NIPDosen = $this->session->userdata('username');
        if(empty($NIPDosen)){
            $this->session->session_destroy();
            
            redirect('AuthDosen/berhasillogout');
            
        }
    }

    function get_by_username($UsernameMahasiswa)
    {
        $this->db->where('NIP$NIPDosen', $UsernameMahasiswa);
    }

    public function get_all_dosen() {
        $query = $this->db->get('dosen'); // Mengambil semua data dari tabel 'dosen'
        return $query->result();
    } 

    public function update_dosen($nip, $nama, $email, $password,)
    {
        $this->db->set('NamaDosen', $nama);
        $this->db->set('PasswordDosen', $password); // Password tidak di-hash
        $this->db->set('email', $email); 

        $this->db->where('NIPDosen', $nip);
        $this->db->update('dosen');
    }

    // Fungsi untuk mengubah hak akses dosen menjadi admin
    public function ubahHakAkses($NIPDosen, $hakAkses) {
        // Reset hak akses admin yang ada saat ini menjadi dosen biasa
        $this->db->set('hak_akses', 'D');
        $this->db->where('hak_akses', 'A');
        $this->db->update('dosen');

        // Ubah hak akses dosen yang di-klik menjadi admin
        $this->db->set('hak_akses', $hakAkses);
        $this->db->where('NIPDosen', $NIPDosen);
        $this->db->update('dosen');
    }

    // Fungsi untuk mereset hak akses dosen yang sebelumnya admin menjadi dosen biasa
    // public function resetHakAksesAdmin() {
    //     $this->db->set('hak_akses', 'D');
    //     $this->db->where('hak_akses', 'A');
    //     $this->db->update('dosen');
    // }

    public function nip_exists($nip)
    {
        $query = $this->db->get_where('dosen', ['NIPDosen' => $nip]);
        return $query->num_rows() > 0;
    }

    public function get_dosen_by_nip($nip)
    {
        $this->db->select('NamaDosen');
        $this->db->from('dosen');
        $this->db->where('NIPDosen', $nip);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_berkas_by_dosen($NIPDosen)
    {
        $this->db->select('*');
        $this->db->from('berkas');
        $this->db->where('dosenpembimbing', $NIPDosen);
        $this->db->or_where('dosenpenguji1', $NIPDosen);
        $this->db->or_where('dosenpenguji2', $NIPDosen);
        $this->db->or_where('dosenkaprodi', $NIPDosen);
        $this->db->or_where('koorpa', $NIPDosen);
        $this->db->order_by('tanggalpengajuan', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_dosen_name_by_nip($NIPDosen)
    {
        $this->db->select('NamaDosen');
        $this->db->from('dosen');
        $this->db->where('NIPDosen', $NIPDosen);
        $query = $this->db->get();
        return $query->row()->NamaDosen;
    }

    public function get_berkas_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('berkas'); // Sesuaikan nama tabel jika berbeda
        return $query->row();

        // public function get_berkas_by_id($id, $order_by = 'tanggalpengajuan', $sort_order = 'DESC') {
        //     $this->db->where('id', $id);
        //     $this->db->order_by($order_by, $sort_order); // Tambahkan pengurutan di sini
        //     $query = $this->db->get('berkas'); // Sesuaikan nama tabel jika berbeda
        //     return $query->result(); // Mengembalikan data yang terurut
        // }
    }
    
}