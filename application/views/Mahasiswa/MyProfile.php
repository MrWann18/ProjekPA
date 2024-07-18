
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
        <td>NIM</td>
        <td><?= $mahasiswa['NIMMahasiswa']; ?></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td><?= $mahasiswa['NamaMahasiswa']; ?></td>
      </tr>
      <tr>
        <td>Password Anda</td>
        <td><?= str_repeat('*', strlen($mahasiswa['PasswordMahasiswa'])); ?></td>
      </tr>
    </tbody>
  </table>
</div>
<br>   
<button type="button" class="btn btn-primary me-2" onclick="window.location.href='<?php echo base_url(); ?>AuthMahasiswa/EditMahasiswa'">Edit Profil</button>

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
        