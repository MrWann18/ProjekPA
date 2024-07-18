
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="col-lg-12 grid-margin stretch-card">
                                  <div class="card">
                                    <div class="card-body">
                                        <!-- partial -->
                                          <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">  
                                                <div class="card-body">
                                                                                                
                                            
                                            <div class="row">
                                              <div class="col-lg-6">
                                                <?= $this->session->flashdata('message');?>
                                              </div>
                                            </div>
                                            <h4 class="card-title">Profile saya</h4>
<div class="table-responsive">
  <table class="table table-striped">
    <tbody>
      <tr>
        <td>NIP</td>
        <td><?= $dosen['NIPDosen']; ?></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td><?= $dosen['NamaDosen']; ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?= $dosen['email']; ?></td>
      </tr>
      <tr>
        <td>Password Anda</td>
        <td><?= str_repeat('*', strlen($dosen['PasswordDosen'])); ?></td>
      </tr>
      <tr>
        <td>Status</td>
        <td>
          <?php 
            if ($dosen['is_active'] == 1) {
                echo "<span class='badge badge-success'>Dosen Aktif</span>";
            } else {
                echo "<span class='badge badge-danger'>Dosen Tidak Aktif</span>";
            }
          ?>
        </td>
      </tr>
    </tbody>
  </table>
  <br>  
<button type="button" class="btn btn-primary me-2" onclick="window.location.href='<?php echo base_url(); ?>AuthDosen/EditDosen'">Edit Profil</button>

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
        