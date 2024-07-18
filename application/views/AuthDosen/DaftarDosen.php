<br>
<div class="row flex-grow">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
          <div>
            <h4 class="card-title card-title-dash">Tambah Dosen Baru</h4>
            <p class="card-subtitle card-subtitle-dash">Halaman Tambah Dosen Baru</p>
          </div>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <!-- partial -->
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card-body">
                    <h4 class="card-title">Tambah Dosen Baru</h4>

                    <?= $this->session->flashdata('message');?>
                    
                    <form method="POST" class="register-form" id="register-form" action="<?= base_url('AuthDosen/register')?>">
                        <div class="form-group">
                          <label for="NIP Dosen">NIP Dosen</label>
                          <input type="text" class="form-control" id="NIPDosen" name="NIPDosen" placeholder="NIP">
                          <?= form_error('NIPDosen','<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                          <label for="NamaDosen">Nama Dosen</label>
                          <input type="text" class="form-control" id="NamaDosen" name="NamaDosen" placeholder="Nama Dosen">
                          <?= form_error('NamaDosen','<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                          <label for="NamaDosen">Email Dosen</label>
                          <input type="email" class="form-control" id="EmailDosen" name="email" placeholder="Email Dosen">
                          <?= form_error('EmailDosen','<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                          <label for="PasswordDosen">Password Untuk Dosen Baru</label>
                          <input type="text" class="form-control" id="PasswordDosen" name="PasswordDosen" placeholder="Password">
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
</div>
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