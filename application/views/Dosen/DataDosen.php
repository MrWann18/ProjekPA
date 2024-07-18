<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link ps-0" href="<?= base_url('/AuthDosen/DataDosen')?>">Data Dosen</a>
    </li>
</ul>
</div><br>
<div class="row flex-grow" id='datadosen'>
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
          <div>
            <h4 class="card-title card-title-dash">Data Dosen</h4>
            <p class="card-subtitle card-subtitle-dash">Halaman Data Dosen</p>
          </div>
          <div>
            <button class="btn btn-primary btn-lg text-white mb-0 me-0"  type="button" onclick="window.location.href='<?php echo base_url('AuthDosen/DaftarDosen');?>'"><i class="mdi mdi-account-plus"></i>Tambah Dosen Baru</button>
          </div>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>NIP Dosen</th>
                      <th>Nama Dosen</th>
                      <th>Kedudukan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($dosen as $row): ?>
                    <?php if($row->is_active == 1):?>
                    <tr>
                      <td><?php echo $row->NIPDosen; ?></td>
                      <td><?php echo $row->NamaDosen; ?></td>
                      <td>
                      <?php 
                          // Mengubah hak akses menjadi deskripsi yang sesuai
                          if($row->hak_akses == 'A') {
                              echo 'Admin';
                          } elseif($row->hak_akses == 'D') {
                              echo 'Dosen Biasa';
                          }
                      ?>
                      </td>
                      <td>
                        <?php if($row->hak_akses == 'D'): ?>
                        <form method="post" action="<?= site_url('AuthDosen/ubah_kedudukan/'.$row->NIPDosen) ?>">
                            <button type="submit" class="btn btn-outline-info btn-fw">Jadikan Admin</button>
                        </form>
                        <?php endif; ?>
                        <form onsubmit="event.preventDefault(); confirmDelete('<?= $row->NIPDosen ?>')">
                            <button type="submit" class="btn btn-outline-danger btn-fw">Hapus Dosen</button>
                        </form>


                      </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
    function confirmDelete(NIPDosen) {
        if (confirm('Apakah Anda yakin ingin menghapus dosen ini?')) {
            // Jika pengguna mengonfirmasi, kirim permintaan hapus ke server
            fetch(`<?= site_url('AuthDosen/hapus_dosen/') ?>${NIPDosen}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Dosen berhasil dihapus!');
                    window.location.reload(); // Refresh halaman setelah penghapusan
                } else {
                    alert('Gagal menghapus dosen.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
