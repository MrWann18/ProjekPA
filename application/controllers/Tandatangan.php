<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tandatangan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Memuat model MTandatangan
        $this->load->model('MTandatangan');
        // Memuat library upload untuk digunakan di seluruh controller
        $this->load->library('upload');
    }

    public function simpan_pdf() {
        // Konfigurasi upload file
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 10000; // Maksimal ukuran file dalam KB
        $config['file_name'] = uniqid() . '-berkas_tandatangan.pdf';

        // Muat library upload dengan konfigurasi yang telah ditentukan
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode(['success' => false, 'message' => $error]);
            return;
        }

        $uploadData = $this->upload->data();
        $filePath = $uploadData['file_name'];

        // Ambil data dari POST
        $NIMMahasiswa = $this->input->post('NIMMahasiswa');
        $NIPDosen = $this->input->post('NIPDosen');
        $idBerkas = $this->input->post('idBerkas');

        // Dapatkan jenis berkas dari tabel berkas berdasarkan idBerkas
        $berkas = $this->MTandatangan->get_berkas_by_id($idBerkas);
        $jenisBerkas = $berkas->jenisberkas;

        // Data untuk tabel tandatangan
        $dataTandatangan = [
            'NIMMahasiswa' => $NIMMahasiswa,
            'NIPDosen' => $NIPDosen,
            'idBerkas' => $idBerkas,
            'tandatangan' => $filePath
        ];

        // Simpan data ke tabel tandatangan
        $this->MTandatangan->insert_signed_pdf($dataTandatangan);

        // Update tabel berkas dengan file PDF baru dan status
        $updateBerkas = $this->MTandatangan->update_berkas_file($idBerkas, $filePath);

        // Update status berdasarkan jenis berkas
        if ($jenisBerkas == 'pengesahan') {
            $this->MTandatangan->increment_status('statuspengesahan', $idBerkas);
        } elseif ($jenisBerkas == 'revisi') {
            $this->MTandatangan->increment_status('statusrevisi', $idBerkas);
        }

        // Kirim respon berdasarkan hasil update
        if ($updateBerkas) {
            echo json_encode(['success' => true, 'message' => 'File berhasil diunggah dan tabel berkas diperbarui.', 'redirect' => site_url('AuthDosen/Dashboard')]);
        } else {
            echo json_encode(['success' => false, 'message' => 'File berhasil diunggah tapi gagal memperbarui tabel berkas.']);
        }

        
        //redirect('AuthDosen/Dashboard');
        
    }
    public function tolak_tandatangan() {
        $idBerkas = $this->input->post('idBerkas');
        $catatan = $this->input->post('catatan');
        $jenisBerkas = $this->input->post('jenisBerkas');
    
        if ($jenisBerkas == 'revisi') {
            $this->db->set('statusrevisi', 'statusrevisi + 10', FALSE);
        } else if ($jenisBerkas == 'pengesahan') {
            $this->db->set('statuspengesahan', 'statuspengesahan + 10', FALSE);
        }
    
        $this->db->set('catatan', $catatan);
        $this->db->where('id', $idBerkas);
        $result = $this->db->update('berkas');
    
        if ($result) {
            $this->session->set_flashdata('message', 'Tanda tangan berhasil ditolak dan data diperbarui!');
        } else {
            $this->session->set_flashdata('message', 'Gagal menolak tanda tangan.');
        }
    
        redirect('AuthDosen/Dashboard');
    }
    
    
}
