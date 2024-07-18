
                    <br>
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Edit Profil</h4>
                                    <p class="card-subtitle card-subtitle-dash">Halaman Edit Profile Mahasiswa</p>
                                  </div>
                                </div>
                                <div class="col-lg-12 grid-margin stretch-card">
                                  <div class="card">
                                    <div class="card-body">
                                        <!-- partial -->
                                          <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">  
                                                <div class="card-body">
                                                  <h4 class="card-title">Edit Profil Mahasiswa</h4>
                                                  <form method="POST" class="register-form" id="login-form" action="<?= base_url('AuthMahasiswa/EditMahasiswa')?>">
                                                    <div class="form-group">
                                                      <label for="NIMMahasiswa">NIM Mahasiswa </label>
                                                      <input type="text" class="form-control" id="NIMMahasiswa" placeholder="NIP Anda" name="NIMMahasiswa" value="<?=$mahasiswa ['NIMMahasiswa'];?>" readonly>
                                                      <?= form_error('NIMMahasiswa','<small class="text-danger pl-3">', '</small>'); ?>

                                                    </div>
                                                    <div class="form-group">
                                                      <label for="JenisBerkas">Nama Mahasiswa</label>
                                                      <input type="text" class="form-control" id="NamaMahasiswa" placeholder="Nama Anda" name="NamaMahasiswa" value="<?=$mahasiswa ['NamaMahasiswa'];?>">
                                                      <?= form_error('NamaMahasiswa','<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="PasswordMahasiswa">Password Mahasiswa</label>
                                                      <input type="text" class="form-control" id="PasswordMahasiswa" placeholder="Password Anda" name="PasswordMahasiswa" value="<?=$mahasiswa ['PasswordMahasiswa'];?>">
                                                      <?= form_error('PasswordMahasiswa','<small class="text-danger pl-3">', '</small>'); ?>
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
        