<?php
class AuthDosen extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MDosen');
        $this->load->library('form_validation');
        $this->dosen=$this->db->get_where('dosen', ['NIPDosen' => $this->session->userdata('NIPDosen')])->row_array();
    }

    //Nanti ketika udah ada akun superadmin
    // public function index()
    // {
    //     $this->load->view('AuthDosen/Login');
    // }

    public function login(){
        $NIPDosen = $this->input->post('NIPDosen');
        $PasswordDosen = $this->input->post('PasswordDosen');
        
        $user = $this->db->get_where('dosen', ['NIPDosen' => $NIPDosen])->row_array();
        if($user) {
            if($user['is_active'] == 1){
                if($PasswordDosen == $user['PasswordDosen']){
                    $data = array(
                        'NIPDosen' => $user['NIPDosen'],
                        'NamaDosen' => $user['NamaDosen'],
                        'hak_akses' => $user['hak_akses']
                    );
                    $this->session->set_userdata($data);
                    
                    redirect('AuthDosen/Dashboard');
                    
                } else{ 
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda salah</div>');
                    $this->load->view('AuthDosen/Login');
                }
            } else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun ini sudah tidak aktif lagi</div>');
            $this->load->view('AuthDosen/Login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIP Anda belum terdaftar</div>');
            $this->load->view('AuthDosen/Login');
        }
    }

    public function register() {

    $hak_akses = $this->session->userdata('hak_akses');
    if ($hak_akses !== 'A') {
        // Jika bukan admin, tampilkan error atau redirect ke halaman lain
        show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
    }

    $this->form_validation->set_rules('NIPDosen', 'NIP Dosen', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('NamaDosen', 'Nama Dosen', 'required|trim');
    $this->form_validation->set_rules('email', 'Email Dosen', 'required|trim|valid_email');
    $this->form_validation->set_rules('PasswordDosen', 'Password', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
        redirect('AuthDosen/DaftarDosen');
    } else {
        $NIPDosen = htmlspecialchars($this->input->post('NIPDosen'));
        $NamaDosen = htmlspecialchars($this->input->post('NamaDosen'));
        $email = htmlspecialchars($this->input->post('email'));
        $PasswordDosen = $this->input->post('PasswordDosen');

        // Cek apakah NIPDosen sudah ada
        if ($this->MDosen->nip_exists($NIPDosen)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIP Dosen sudah ada!</div>');
            redirect('AuthDosen/DaftarDosen');
        }

        // Cek apakah email sudah ada
        // if ($this->MDosen->email_exists($email)) {
        //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email Dosen sudah ada!</div>');
        //     redirect('AuthDosen/DaftarDosen');
        // }

        $data = array(
            'NIPDosen' => $NIPDosen,
            'NamaDosen' => $NamaDosen,
            'PasswordDosen' => $PasswordDosen, // Hash password sebelum menyimpan
            'is_active' => 1,
            'email' => $email // Sesuaikan nama kolom email di tabel
        );

        $this->MDosen->register($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Registration successful.</div>');
        redirect('AuthDosen/DaftarDosen');
    }
}


    public function Dashboard()
    {
        // Ambil NIPDosen dari session
        $NIPDosen = $this->session->userdata('NIPDosen');

        // Ambil data berkas berdasarkan NIPDosen
        $this->load->model('MDosen');
        $data['berkas'] = $this->MDosen->get_berkas_by_dosen($NIPDosen);

        // Ambil nama dosen
        $data['dosen_nama'] = [];
        foreach ($data['berkas'] as $berkas) {
        if (!empty($berkas->dosenpenandatangan1)) {
            $data['dosen_nama'][$berkas->dosenpenandatangan1] = $this->MDosen->get_dosen_name_by_nip($berkas->dosenpenandatangan1);
        }
        if (!empty($berkas->dosenpenandatangan2)) {
            $data['dosen_nama'][$berkas->dosenpenandatangan2] = $this->MDosen->get_dosen_name_by_nip($berkas->dosenpenandatangan2);
        }
        if (!empty($berkas->dosenpenandatangan3)) {
            $data['dosen_nama'][$berkas->dosenpenandatangan3] = $this->MDosen->get_dosen_name_by_nip($berkas->dosenpenandatangan3);
        }
    }
        
        // Contoh: Ambil data pengajuan (pastikan metode ini benar)
        $data['pengajuan'] = $this->MDosen->get_berkas_by_dosen($NIPDosen);

        // Kirim data ke view
        $this->load->view('Dosen/Header',['dosen' => $this->dosen]);
        $this->load->view('Dosen/Index', $data);
        $this->load->view('Dosen/Footer');
    }

    public function DaftarDosen()
    {
        $this->load->view('Dosen/Header',['dosen' => $this->dosen]);
        $this->load->view('AuthDosen/DaftarDosen');
        $this->load->view('Dosen/Footer');
    }

    public function DataDosen()
    {     
        $data['dosen'] = $this->MDosen->get_all_dosen();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses !== 'A') {
            // Jika bukan admin, tampilkan error atau redirect ke halaman lain
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->view('Dosen/Header',['dosen' => $this->dosen]);
        $this->load->view('Dosen/DataDosen',$data);
        $this->load->view('Dosen/Footer');
    }

    public function PermohonanTTDDosen()
    {
        $this->load->view('Dosen/Header',['dosen' => $this->dosen]);
        $this->load->view('Dosen/DataDosen');
        $this->load->view('Dosen/Footer');
    }

    public function logout() {
        $this->session->unset_userdata('NIPDosen');
        $this->session->unset_userdata('NamaDosen');
        $this->session->unset_userdata('hak_akses');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda telah keluar</div>');
        
        $this->load->view('AuthDosen/Login');
    }

    public function masukakundosen()
    {
        $this->load->view('AuthDosen/Login');
    }

    public function MyProfile()
    {
        $this->load->view('Dosen/Header',['dosen' => $this->dosen]);
        $this->load->view('Dosen/MyProfile');
        $this->load->view('Dosen/Footer');
    }

    public function FormEditDosen()
    {
        $this->load->view('Dosen/Header',['dosen' => $this->dosen]);
        $this->load->view('Dosen/EditDosen');
        $this->load->view('Dosen/Footer');
    }

    public function EditDosen()
    {
        $data['dosen']=$this->db->get_where('dosen', ['NIPDosen' =>
        $this->session->userdata('NIPDosen')])->row_array();

        $this->form_validation->set_rules('NamaDosen', 'Nama Dosen', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Dosen', 'required|trim|valid_email');
        $this->form_validation->set_rules('PasswordDosen', 'Password ', 'required|trim');

        if ($this->form_validation->run() == false) {
            redirect('AuthDosen/FormEditDosen');
        } else {
            $NIPDosen = $this->input->post('NIPDosen');
            $NamaDosen = $this->input->post('NamaDosen');
            $email = $this->input->post('email');
            $PasswordDosen = $this->input->post('PasswordDosen');

            $this->MDosen->update_dosen($NIPDosen, $NamaDosen, $email, $PasswordDosen);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit data berhasil!</div>');
            redirect('AuthDosen/MyProfile');
        }
    }
    
    public function ubah_kedudukan($NIPDosen) {
        // Ubah hak akses dosen yang dituju menjadi admin
        $this->MDosen->ubahHakAkses($NIPDosen, 'A');
    
        // // Periksa apakah NIPDosen yang diubah sama dengan NIPDosen di sesi
        // if ($this->session->userdata('NIPDosen') == $NIPDosen) {
        //     // Perbarui hak akses di sesi
        $this->session->set_userdata('hak_akses', 'D');
        // $this->MDosen->ubahHakAkses($this->session->userdata('NIPDosen'), 'D');
            
        // }
    
        // Set flash data untuk memberi tahu user bahwa hak akses telah diubah
        $this->session->set_flashdata('success', 'Hak akses berhasil diubah.');
    
        // Redirect kembali ke halaman Data Dosen
        redirect('AuthDosen/Dashboard');
    }

    public function hapus_dosen($NIPDosen)
{
    // Perbarui kolom is_active menjadi 0 di database
    $this->db->where('NIPDosen', $NIPDosen);
    $this->db->update('dosen', ['is_active' => 0]);

    // Kirimkan respons JSON ke client
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}
}