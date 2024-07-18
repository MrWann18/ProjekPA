<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Memastikan jalur benar
require_once(APPPATH . 'libraries/tcpdf-main/tcpdf.php');
require_once(APPPATH . 'libraries/FPDI-2.6.0/src/autoload.php');


use setasign\Fpdi\Tcpdf\Fpdi;  // Menggunakan namespace untuk TCPDF
use setasign\Fpdi\PdfParser\StreamReader;

class Pdf extends Fpdi {
    
    public function __construct() {
        parent::__construct();
    }

    public function loadTemplate($filePath) {
        $this->setSourceFile(StreamReader::createByFile($filePath));
        return $this->importPage(1);
    }
}
