
                    <br>
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Edit Profil</h4>
                                    <p class="card-subtitle card-subtitle-dash">Halaman Edit Profile Dosen</p>
                                  </div>
                                </div>
                                <div class="col-lg-12 grid-margin stretch-card">
                                  <div class="card">
                                    <div class="card-body">
                                        <!-- partial -->
                                          <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">  
                                                <div class="card-body">
                                                  <h4 class="card-title">Edit Profil Dosen</h4>
                                                  <form method="POST" class="register-form" id="login-form" action="<?= base_url('AuthDosen/EditDosen')?>">
                                                    <div class="form-group">
                                                      <label for="NamaDosen">NIP Dosen </label>
                                                      <input type="text" class="form-control" id="NIPDosen" placeholder="NIP Anda" name="NIPDosen" value="<?=$dosen ['NIPDosen'];?>" readonly>
                                                      <?= form_error('NIPDosen','<small class="text-danger pl-3">', '</small>'); ?>

                                                    </div>
                                                    <div class="form-group">
                                                      <label for="JenisBerkas">Nama Dosen</label>
                                                      <input type="text" class="form-control" id="NamaDosen" placeholder="Nama Anda" name="NamaDosen" value="<?=$dosen ['NamaDosen'];?>">
                                                      <?= form_error('NamaDosen','<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="JenisBerkas">Email Dosen</label>
                                                      <input type="email" class="form-control" id="email" placeholder="Email Anda" name="email" value="<?=$dosen ['email'];?>">
                                                      <?= form_error('email','<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group">
                          <label for="PasswordDosen">Password Untuk Dosen Baru</label>
                          <div class="input-group">
                            <input type="password" class="form-control" id="PasswordDosen" name="PasswordDosen" placeholder="Password" value="<?=$dosen ['PasswordDosen'];?>">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                              </button>
                            </div>
                          </div>
                          <?= form_error('PasswordDosen','<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                                                    
                                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                                    <button class="btn btn-light">Cancel</button>
                                                  </form>
                                                </div>
                                              
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                    
        <!-- content-wrapper ends -->
        <script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#PasswordDosen');
  const eyeIcon = document.querySelector('#eyeIcon');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // toggle the eye icon
    if(type === 'password') {
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    } else {
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    }
  });
</script>