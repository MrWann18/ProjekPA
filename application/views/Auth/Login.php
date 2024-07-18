<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masuk</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?=base_url('assets/login/')?>/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?=base_url('assets/login/')?>/css/style.css">
</head>
<body>

    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image"><br><br>
                        <figure><img src="<?=base_url('assets/login/')?>images/qrcode.jpg" alt="sing up image"></figure><br>
                        <a href="<?php echo base_url('AuthMahasiswa/index');?>" class="signup-image-link">Buat Akun Khusus Mahasiswa</a><br>
                        <a href="<?php echo base_url('AuthMahasiswa/masukakundosen');?>" class="signup-image-link">Masuk ke Akun Dosen</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Masuk</h2>
                        <h4 class="form-title">Masuk ke Akun Mahasiswa</h4>
                        <?php if ($this->session->flashdata('message')): ?>
                        <h5 class="form-title"><?php echo $this->session->flashdata('message'); ?></h5>
                        <?php endif; ?>
                        <form method="POST" class="register-form" id="login-form" action="<?= base_url('AuthMahasiswa/login')?>"> 
                        <?php echo form_error('NIMMahasiswa'); ?>
                            <div class="form-group">  
                                <label for="nim"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="NIMMahasiswa" id="nim" placeholder="NIM Anda"/>
                            </div>
                        <?php echo form_error('PasswordMahasiswa'); ?>
                            <div class="form-group">
                                <label for="PasswordMahasiswa"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="PasswordMahasiswa" id="PasswordMahasiswa" placeholder="Password"/>
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                           
                        </form>
                        </div>
                </div>
            </div>
        </section>

        <!-- JS -->
    <script src="<?=base_url('assets/login/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/login/')?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>