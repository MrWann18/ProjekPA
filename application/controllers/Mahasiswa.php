<?php
class Mahasiswa extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MMahasiswa');
        $this->load->model('MDosen');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');

        $this->mahasiswa=$this->db->get_where('mahasiswa', ['NIMMahasiswa' => $this->session->userdata('NIMMahasiswa')])->row_array();
    }

    public function Pengajuan()
    {
        // Get list of dosen
        $data['dosen_list'] = $this->MDosen->get_all_dosen();
        $this->load->view('Mahasiswa/Header',['mahasiswa' => $this->mahasiswa]);
        $this->load->view('Mahasiswa/PengajuanMahasiswa', $data);
        $this->load->view('Mahasiswa/Footer');
    }
    
    public function Dashboard()
    {
        // Ambil NIMMahasiswa dari session
        $NIMMahasiswa = $this->session->userdata('NIMMahasiswa');

        // Ambil data pengajuan berdasarkan NIMMahasiswa
        $this->load->model('MMahasiswa');
        $this->load->model('MDosen'); // Pastikan model dosen juga dimuat
        $pengajuan = $this->MMahasiswa->getPengajuanByNIM($NIMMahasiswa);

        // Tambahkan nama dosen ke data pengajuan
        foreach ($pengajuan as &$row) {
            $row->dosen1_nama = $this->MDosen->get_dosen_by_nip($row->dosenpembimbing)->NamaDosen ?? null;
            $row->dosen2_nama = $this->MDosen->get_dosen_by_nip($row->dosenpenguji1)->NamaDosen ?? null;
            $row->dosen3_nama = $this->MDosen->get_dosen_by_nip($row->dosenpenguji2)->NamaDosen ?? null;
            $row->dosen4_nama = $this->MDosen->get_dosen_by_nip($row->dosenkaprodi)->NamaDosen ?? null;
            $row->dosen5_nama = $this->MDosen->get_dosen_by_nip($row->koorpa)->NamaDosen ?? null;
        }

        // Kirim data ke view
        $data['pengajuan'] = $pengajuan;
        $this->session->set_userdata('pengajuan', $data['pengajuan']);

        $this->load->view('Mahasiswa/Header', ['mahasiswa' => $this->mahasiswa]);
        $data['pengajuan'] = $this->session->userdata('pengajuan');
        $this->load->view('Mahasiswa/Index', $data);
        $this->load->view('Mahasiswa/Footer');
    }


    public function UploadPengajuan() {
        // Set validation rules
        // Ambil nama dan id mahasiswa dari session
        $NamaMahasiswa = $this->session->userdata('NamaMahasiswa');
        $NIMMahasiswa = $this->session->userdata('NIMMahasiswa');
        // Get the value of 'jenisberkas'
        $jenisberkas = $this->input->post('jenisberkas');

        // Set common validation rules
        $this->form_validation->set_rules('judulberkas', 'Judul Berkas PA', 'required');
        $this->form_validation->set_rules('jenisberkas', 'Jenis Berkas', 'required');

        // Conditional validation rules
        if ($jenisberkas == 'revisi') {
            $this->form_validation->set_rules('dosenpembimbing', 'Dosen Penandatangan 1', 'required');
            $this->form_validation->set_rules('dosenpenguji1', 'Dosen Penandatangan 2', 'required');
            $this->form_validation->set_rules('koorpa', 'Dosen Penandatangan 3', 'required');
        } else if ($jenisberkas == 'pengesahan') {
            $this->form_validation->set_rules('dosenpembimbing', 'Dosen Penandatangan 1', 'required');
            $this->form_validation->set_rules('dosenpenguji1', 'Dosen Penandatangan 2', 'required');
            $this->form_validation->set_rules('dosenpenguji2', 'Dosen Penandatangan 3', 'required');
            $this->form_validation->set_rules('dosenkaprodi', 'Dosen Penandatangan 4', 'required');
            $this->form_validation->set_rules('koorpa', 'Dosen Penandatangan 4', 'required');
        }
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('Mahasiswa/Pengajuan');
        } else {
            // Configuration for file upload
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = time() . '_' . $_FILES['BerkasPA']['name'];
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('BerkasPA')) {
                // File upload failed
                $this->session->set_flashdata('upload_error', $this->upload->display_errors());
                redirect('Mahasiswa/Pengajuan');
            } else {
                // File upload successful
                $file_data = $this->upload->data();
                
                // Prepare data for insertion into the database

                $jenisberkas = $this->input->post('jenisberkas');

                if ($jenisberkas === 'revisi'){
                    $statuspengesahan = 0;
                    $statusrevisi = 1;
                }else{
                    $statuspengesahan = 1;
                    $statusrevisi = 0;
                }

                $data = array(
                    'judulberkas' => $this->input->post('judulberkas'),
                    'jenisberkas' => $jenisberkas,
                    'dosenpembimbing' => $this->input->post('dosenpembimbing'),
                    'dosenpenguji1' => $this->input->post('dosenpenguji1'),
                    'dosenpenguji2' => $this->input->post('dosenpenguji2'),
                    'dosenkaprodi' => $this->input->post('dosenkaprodi'),
                    'koorpa' => $this->input->post('koorpa'),
                    'fileberkas' => $file_data['file_name'],
                    'tanggalpengajuan' => date('Y-m-d H-i-s'),
                    'updateterakhir' => date('Y-m-d'), // Add the current date and time
                    'NamaMahasiswa' => $NamaMahasiswa, // Add nama mahasiswa
                    'NIMMahasiswa' => $NIMMahasiswa, // Add id mahasiswa
                    'statuspengesahan' => $statuspengesahan,
                    'statusrevisi' => $statusrevisi
                );
    
                // Insert data into the database
                $this->MMahasiswa->InsertDataPengajuan($data);
                // Redirect or load success view
                redirect('Mahasiswa/Dashboard');
            }
        }
    }
    
    // public function TabelPermohonan() {
    //     // Ambil NIMMahasiswa dari session
    //     $NIMMahasiswa = $this->session->userdata('NIMMahasiswa');

    //     // Ambil data pengajuan berdasarkan NIMMahasiswa
    //     $this->load->model('MMahasiswa');
    //     $data['pengajuan'] = $this->MMahasiswa->getPengajuanByNIM($NIMMahasiswa);
    //     // Kirim data ke view
    //     $this->session->set_userdata('pengajuan', $data['pengajuan']);

    //     // Redirect ke Mahasiswa/Dashboard
    //     redirect('Mahasiswa/Dashboard');
        
    // }
}