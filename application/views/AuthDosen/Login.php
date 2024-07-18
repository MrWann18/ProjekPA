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
                        <a href="<?php echo base_url('AuthMahasiswa/logout');?>" class="signup-image-link">Masuk ke Akun Mahasiswa</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Masuk</h2>
                        <h4 class="form-title">Masuk ke Akun Dosen</h4>
                        <h5 class="form-title"></h5>
                        <form method="POST" class="register-form" id="login-form" action="<?= base_url('AuthDosen/login')?>">
                        
                        <h5><?php echo $this->session->flashdata('message'); ?></h5>
                            <div class="form-group">  
                                <label for="nip"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="NIPDosen" id="nip" placeholder="NIP Anda" value="<?= set_value('NIPDosen')?>"/>     
                            <?= form_error('NIPDosen','<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="PasswordDosen"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="PasswordDosen" id="PasswordDosen" placeholder="Password"/>
                                <?= form_error('PasswordDosen','<small class="text-danger">', '</small>'); ?>
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