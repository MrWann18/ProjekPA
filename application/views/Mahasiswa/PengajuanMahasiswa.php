
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                        aria-controls="overview" aria-selected="true">Permohonan Tanda Tangan</a>
                    </li>
                  </ul>
                  
                </div>
                    <br>
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Permohonan Tanda Tangan</h4>
                                    <p class="card-subtitle card-subtitle-dash">Halaman Tanda Tangan Mahasiswa</p>
                                  </div>
                                </div>
                                <div class="col-lg-12 grid-margin stretch-card">
                                  <div class="card">
                                    <div class="card-body">
                                        <!-- partial -->
                                          <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">  
                                                <div class="card-body">
                                                  <h4 class="card-title">Tambah Permohonan Tanda Tangan Berkas PA</h4>
                                                  <?php
                                                    // Tampilkan pesan kesalahan validasi
                                                    if ($this->session->flashdata('validation_errors')) {
                                                        echo '<div style="color:red;">' . $this->session->flashdata('validation_errors') . '</div>';
                                                    }

                                                    // Tampilkan pesan kesalahan upload
                                                    if ($this->session->flashdata('upload_error')) {
                                                        echo '<div style="color:red;">' . $this->session->flashdata('upload_error') . '</div>';
                                                    }
                                                    ?>
                                                  <?php echo validation_errors(); ?>
                                                  <?php echo form_open_multipart('Mahasiswa/UploadPengajuan'); ?>
                                                    <div class="form-group">
                                                        <label for="JudulBerkas">Judul Berkas PA </label>
                                                        <input type="text" class="form-control" id="JudulBerkas" placeholder="Judul PA" name="judulberkas" value="<?php echo set_value('judulberkas'); ?>">
                                                        <?php echo form_error('judulberkas', '<div class="text-danger">', '</div>'); ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="JenisBerkas">Jenis Berkas</label>
                                                        <select class="form-control" id="JenisBerkas" name="jenisberkas" onchange="toggleDosen()" placeholder="Masukkan Jenis Berkas" value="<?php echo set_value('judulberkas'); ?>">
                                                            <option value="">--Isi Jenis Berkas--</option>
                                                            <option value="revisi" <?php echo set_select('jenisberkas', 'revisi'); ?>>Form Revisi</option>
                                                            <option value="pengesahan" <?php echo set_select('jenisberkas', 'pengesahan'); ?>>Form Pengesahan</option>
                                                        </select>
                                                        <?php echo form_error('jenisberkas', '<div class="text-danger">', '</div>'); ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="DosenPembimbing">Dosen Pembimbing</label>
                                                        <select class="form-control" id="DosenPembimbing" name="dosenpembimbing">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen_list as $dosen): ?>
                                                              <?php if ($dosen->is_active == 1): ?>
                                                                <option value="<?php echo $dosen->NIPDosen; ?>" <?php echo set_select('dosenpembimbing', $dosen->NIPDosen); ?>>
                                                                    <?php echo $dosen->NamaDosen; ?>
                                                                </option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php echo form_error('dosenpembimbing', '<div class="text-danger">', '</div>'); ?>
                                                    </div>

                                                    <div class="form-group" id="dosenpenguji1" style="display: none;">
                                                        <label for="dosenpenguji1Select">Dosen Penguji </label>
                                                        <select class="form-control" id="dosenpenguji1Select" name="dosenpenguji1">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen_list as $dosen): ?>
                                                              <?php if ($dosen->is_active == 1): ?>
                                                                <option value="<?php echo $dosen->NIPDosen; ?>" <?php echo set_select('dosenpenguji1', $dosen->NIPDosen); ?>><?php echo $dosen->NamaDosen; ?></option>
                                                                <?php endif; ?>
                                                                <?php endforeach; ?>
                                                        </select>
                                                        <?php echo form_error('dosenpenguji1', '<div class="text-danger">', '</div>'); ?>
                                                    </div>

                                                    <div class="form-group" id="dosenpenguji2" style="display: none;">
                                                        <label for="dosenpenguji2Select">Dosen Penguji 2</label>
                                                        <select class="form-control" id="dosenpenguji2Select" name="dosenpenguji2">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen_list as $dosen): ?>
                                                              <?php if ($dosen->is_active == 1): ?>
                                                                <option value="<?php echo $dosen->NIPDosen; ?>" <?php echo set_select('dosenpenguji2', $dosen->NIPDosen); ?>><?php echo $dosen->NamaDosen; ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php echo form_error('dosenpenguji2', '<div class="text-danger">', '</div>'); ?>
                                                    </div>
                                                    <div class="form-group" id="dosenkaprodi" style="display: none;">
                                                        <label for="dosenkaprodiSelect">Kaprodi</label>
                                                        <select class="form-control" id="dosenkaprodiSelect" name="dosenkaprodi">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen_list as $dosen): ?>
                                                              <?php if ($dosen->is_active == 1): ?>
                                                                <option value="<?php echo $dosen->NIPDosen; ?>" <?php echo set_select('dosenkaprodi', $dosen->NIPDosen); ?>><?php echo $dosen->NamaDosen; ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php echo form_error('dosenkaprodi', '<div class="text-danger">', '</div>'); ?>
                                                    </div>
                                                    <div class="form-group" id="koorpa" style="display: none;">
                                                        <label for="koorpaSelect">Koordinator PA</label>
                                                        <select class="form-control" id="koorpaSelect" name="koorpa">
                                                            <option value="">--Pilih Dosen--</option>
                                                            <?php foreach ($dosen_list as $dosen): ?>
                                                              <?php if ($dosen->is_active == 1): ?>
                                                                <option value="<?php echo $dosen->NIPDosen; ?>" <?php echo set_select('koorpa', $dosen->NIPDosen); ?>><?php echo $dosen->NamaDosen; ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php echo form_error('koorpa', '<div class="text-danger">', '</div>'); ?>
                                                    </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="BerkasPA">Upload Berkas</label>
                                                            <input type="file" class="form-control" id="BerkasPA" name="BerkasPA">
                                                            <?php echo form_error('BerkasPA', '<div class="text-danger">', '</div>'); ?>
                                                        </div>

                                                        <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
                                                        
                                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                                        <button class="btn btn-light">Cancel</button>
                                                        
                                                        <?php echo form_close(); ?>

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
        
        <script>
    function toggleDosen() {
        var jenisBerkas = document.getElementById('JenisBerkas').value;
        var dosen2 = document.getElementById('dosenpenguji1');
        var dosen3 = document.getElementById('dosenpenguji2');
        var dosen4 = document.getElementById('dosenkaprodi');
        var dosen5 = document.getElementById('koorpa');

        // Inisialisasi semua div dosen ke display none
        dosen2.style.display = 'none';
        dosen3.style.display = 'none';
        dosen4.style.display = 'none';
        dosen5.style.display = 'none';

        // Menyesuaikan display berdasarkan jenis berkas yang dipilih
        if (jenisBerkas === 'revisi') {
            dosen2.style.display = 'block';
            dosen5.style.display = 'block';
        } else if (jenisBerkas === 'pengesahan') {
            dosen2.style.display = 'block';
            dosen3.style.display = 'block';
            dosen4.style.display = 'block';
            dosen5.style.display = 'block';
        }
    }
</script>
