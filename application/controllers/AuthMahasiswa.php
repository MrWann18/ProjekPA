<?php
class AuthMahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MMahasiswa');
        $this->load->library('form_validation');
        $this->mahasiswa=$this->db->get_where('Mahasiswa', ['NIMMahasiswa' => $this->session->userdata('NIMMahasiswa')])->row_array();
    }

    public function index()
    {
        $this->load->view('Auth/Daftar');
    }

    public function MyProfile()
    {
        $this->load->view('Mahasiswa/Header',['mahasiswa' => $this->mahasiswa]);
        $this->load->view('Mahasiswa/MyProfile');
        $this->load->view('Mahasiswa/Footer');
    }
    
    public function FormEditMahasiswa()
    {
        $this->load->view('Mahasiswa/Header',['mahasiswa' => $this->mahasiswa]);
        $this->load->view('Mahasiswa/EditMahasiswa');
        $this->load->view('Mahasiswa/Footer');
    }

    public function login()
    {
        $NIMMahasiswa = $this->input->post('NIMMahasiswa');
        $PasswordMahasiswa = $this->input->post('PasswordMahasiswa');
        
        $user = $this->db->get_where('mahasiswa', ['NIMMahasiswa' => $NIMMahasiswa])->row_array();
        if ($user) {
            // Verifikasi password
            if($PasswordMahasiswa == $user['PasswordMahasiswa']){
                $data = [
                    'NIMMahasiswa' => $user['NIMMahasiswa'],
                    'NamaMahasiswa' => $user['NamaMahasiswa']
                ];
                $this->session->set_userdata($data);
                
                // Ambil data pengajuan berdasarkan NIMMahasiswa
            $pengajuan = $this->MMahasiswa->getPengajuanByNIM($NIMMahasiswa);

            // Set data pengajuan ke sesi
            $this->session->set_userdata('pengajuan', $pengajuan);
                redirect('Mahasiswa/Dashboard');
            } else { 
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda salah</div>');
                redirect('AuthMahasiswa/LoginAkun');
                
            }
        } else {
            // NIM tidak ditemukan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIM tidak ditemukan</div>');
            redirect('AuthMahasiswa/LoginAkun');
            
        }
        
    }

    public function register()
    {
        $this->form_validation->set_rules('NIMMahasiswa', 'NIMMahasiswa', 'required|trim|min_length[10]');
        $this->form_validation->set_rules('NamaMahasiswa', 'NamaMahasiswa', 'required');
        $this->form_validation->set_rules('PasswordMahasiswa', 'PasswordMahasiswa', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Auth/Daftar');
        } else {
            $data = array(
                'NIMMahasiswa' => htmlspecialchars($this->input->post('NIMMahasiswa')),
                'NamaMahasiswa' => htmlspecialchars($this->input->post('NamaMahasiswa')),
                'PasswordMahasiswa' => $this->input->post('PasswordMahasiswa')
            );

            $this->MMahasiswa->register($data);
            $this->session->set_flashdata('message', 'Registration successful.');
            redirect('AuthMahasiswa/LoginAkun');
        }
    }

    // public function Dashboard()
    // {
    //     $this->load->view('Mahasiswa/Header',['mahasiswa' => $this->mahasiswa]);
    //     $this->load->view('Mahasiswa/Index');
    //     $this->load->view('Mahasiswa/Footer');
    // }

    public function LoginAkun()
    {
        $this->load->view('Auth/Login');
    }

    public function logout()
    {
        $this->session->set_userdata('NIMMahasiswa', FALSE);
        $this->session->sess_destroy();
        $this->load->view('Auth/Login');
    }

    public function masukakundosen()
    {
        $this->load->view('AuthDosen/Login');
    }

    public function EditMahasiswa()
    {
        $data['Mahasiswa']=$this->db->get_where('Mahasiswa', ['NIMMahasiswa' =>
        $this->session->userdata('NIMMahasiswa')])->row_array();

        $this->form_validation->set_rules('NamaMahasiswa', 'Nama Mahasiswa', 'required|trim');
        $this->form_validation->set_rules('PasswordMahasiswa', 'Password ', 'required|trim');

        if ($this->form_validation->run() == false) {
            redirect('AuthMahasiswa/FormEditMahasiswa');
        } else {
            $NIMMahasiswa = $this->input->post('NIMMahasiswa');
            $NamaMahasiswa = $this->input->post('NamaMahasiswa');
            $PasswordMahasiswa = $this->input->post('PasswordMahasiswa');

            $this->MMahasiswa->update_Mahasiswa($NIMMahasiswa, $NamaMahasiswa, $PasswordMahasiswa);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit data berhasil!</div>');
            redirect('AuthMahasiswa/MyProfile');
        }
    }   
}
