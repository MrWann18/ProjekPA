<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('MScan');
    }

    public function index() {
        echo "masuk";
    }

    // Method untuk menampilkan detail tanda tangan berdasarkan ID
    public function detail() {
        // echo "masuk";
        $idTandatangan = $this->input->get('idTandatangan');
        
        // echo $idTandatangan ;
        
        if (!$idTandatangan || !is_numeric($idTandatangan)) {
            echo"is numeric";
        }
        
        $data['tandatangan'] = $this->MScan->getTandatanganById($idTandatangan);
        
         
        
        // var_dump($data);
        $this->load->view('ScanQr/ScanQr', $data);
    }
    
}
?>
