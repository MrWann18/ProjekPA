<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?=base_url('assets/login/')?>/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?=base_url('assets/login/')?>/css/style.css">
</head>
<body>

    <div class="main">

        <!-- Daftar form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Daftar</h2>
                        <h4 class="form-title">Daftar Khusus Mahasiswa PCR</h4>
                        <form method="POST" class="register-form" id="register-form" action="<?= base_url('AuthMahasiswa/register')?>">
                            <div class="form-group">
                                <label for="NIM"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="NIMMahasiswa" id="NIMMahasiswa" placeholder="NIM Anda"/>
                                <?php echo form_error('NIMMahasiswa'); ?>
                            </div>
                            <div class="form-group">
                                <label for="Nama"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="NamaMahasiswa" id="Nama" placeholder="Nama Anda"/>
                                <?php echo form_error('NamaMahasiswa'); ?>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="PasswordMahasiswa" id="pass" placeholder="Password"/>
                                <?php echo form_error('PasswordMahasiswa'); ?>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image"><br><br><br>
                        <figure><img src="<?=base_url('assets/login/')?>images/qrcode.jpg" alt="sing up image"></figure><br>
                        <a href="<?php echo base_url('AuthMahasiswa/LoginAkun');?>" class="signup-image-link">Sudah Mendaftar Sebagai Mahasiswa</a><br>
                        <a href="<?php echo base_url('AuthMahasiswa/masukakundosen');?>" class="signup-image-link">Masuk ke Akun Dosen</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="<?=base_url('assets/login/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/login/')?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>