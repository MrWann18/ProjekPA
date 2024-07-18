<?php
class MScan extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Method untuk mendapatkan data tanda tangan berdasarkan ID
    // public function getTandatanganById($idTandatangan) {
    //     $this->db->where('id', $idTandatangan);
    //     $query = $this->db->get('tandatangan');
    //     return $query->row();
    // }
    public function getTandatanganById($idTandatangan) {
        $this->db->select('t.*, m.NamaMahasiswa AS nama_mahasiswa, m.NIMMahasiswa AS nim_mahasiswa, d.NamaDosen AS NamaDosen, b.JudulBerkas AS judulberkas, b.jenisberkas AS jenisberkas');
        $this->db->from('tandatangan AS t');
        $this->db->join('mahasiswa AS m', 't.NIMMahasiswa = m.NIMMahasiswa');
        $this->db->join('dosen AS d', 't.NIPDosen = d.NIPDosen');
        $this->db->join('berkas AS b', 't.idberkas = b.id');
        $this->db->where('t.id', $idTandatangan);
        $query = $this->db->get();
        return $query->row();
    }
    
    
}
?>
