<?php
class Dosen extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MDosen');
        $this->load->model('MTandatangan');
        $this->load->library('form_validation');
        $this->dosen = $this->db->get_where('dosen', ['NIPDosen' => $this->session->userdata('NIPDosen')])->row_array();
    }

    // Method untuk menampilkan pengajuan
    public function LihatPengajuan($id) {
        // Ambil data pengajuan berdasarkan ID
        $data['pengajuan'] = $this->MDosen->get_berkas_by_id($id);

        $data["idberkas"] = $id;

        // Cek apakah data pengajuan ditemukan
        if (!$data['pengajuan']) {
            show_404();
        }

        // Ambil data dosen dari session
        $data['NIPDosen'] = $this->session->userdata('NIPDosen');

        // Ambil nama file dari data pengajuan
        $fileberkas = base_url('uploads/' . $data['pengajuan']->fileberkas);

        // Sertakan URL file PDF dalam data yang akan dikirim ke view
        $data['fileberkas'] = $fileberkas;

        // Generate ID tandatangan baru
        $data['lastIdTandatangan'] = $this->generate_id_tandatangan();

        // Load view dan kirim data
        $this->load->view('Dosen/Header', ['dosen' => $this->dosen]);
        $this->load->view('Dosen/LihatPengajuan', $data);
        $this->load->view('Dosen/Footer');
    }

    // Method untuk generate ID tandatangan baru
    private function generate_id_tandatangan() {
        // Panggil model untuk mendapatkan ID terakhir
        $lastId = $this->MTandatangan->getLastId();

        // Jika ada ID terakhir, tambahkan 1 ke ID tersebut
        return $lastId ? $lastId + 1 : 1;
    }
}
?>
