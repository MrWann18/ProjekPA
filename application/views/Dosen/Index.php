<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link ps-0" href="<?= base_url('/AuthDosen/Dashboard')?>">Permohonan Tanda Tangan</a>
    </li>
    <!-- Tambahkan if dosen biasa atau dosen kaprodi -->
</ul>
</div><br>
<div class="row flex-grow" id='overview'>
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">Permohonan Tanda Tangan</h4>
                        <p class="card-subtitle card-subtitle-dash">Halaman Tanda Tangan Dosen</p>
                        <div class="col-lg-12">
                            <div id="flash-message" class="alert alert-danger" role="alert" style="display: none;">
                                <?= $this->session->flashdata('message');?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Judul PA</th>
                                            <th>Jenis Berkas</th>
                                            <th>Tanggal Pengajuan</th>
                                            <!-- <th>Update Terakhir</th> -->
                                            <th>Mahasiswa Pemohon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($pengajuan)) { ?>
                                            <?php foreach($pengajuan as $row): ?>
                                                <tr>
                                                    <td><?= $row->judulberkas ?></td>
                                                    <td><?= $row->jenisberkas ?></td>
                                                    <td><?= $row->tanggalpengajuan ?></td>
                                                    <!-- <td><?= $row->updateterakhir ?></td> -->
                                                    <td><?= $row->NamaMahasiswa ?></td>
                                                    <td>
                                                        <?php 
                                                            if ($row->jenisberkas == 'revisi'){
                                                                switch ($row->statusrevisi) {
                                                                    case 1:
                                                                        echo 'Diproses (Menunggu TTD Penguji)';
                                                                        break;
                                                                    case 2:
                                                                        echo 'Diproses (Menunggu TTD Pembimbing)';
                                                                        break;
                                                                    case 3:
                                                                        echo 'Diproses (Menunggu TTD KoorPA)';
                                                                        break;
                                                                    case 4:
                                                                        echo 'Selesai';
                                                                        break;
                                                                    case 11:
                                                                        echo 'Ditolak Dosen Penguji';
                                                                        break;
                                                                    case 12:
                                                                        echo 'Ditolak Dosen Pembimbing';
                                                                        break;
                                                                    case 13:
                                                                        echo 'Ditolak Koor PA';
                                                                        break;

                                                                }
                                                            } else {
                                                                switch ($row->statuspengesahan) {
                                                                    case 1:
                                                                        echo 'Diproses (Menunggu TTD Pembimbing)';
                                                                        break;
                                                                    case 2:
                                                                        echo 'Diproses (Menunggu TTD Penguji 1)';
                                                                        break;
                                                                    case 3:
                                                                        echo 'Diproses (Menunggu TTD Penguji 2)';
                                                                        break;
                                                                    case 4:
                                                                        echo 'Diproses (Menunggu TTD Kaprodi)';
                                                                        break;
                                                                    case 5:
                                                                        echo 'Selesai';
                                                                        break;
                                                                    case 11:
                                                                        echo 'Ditolak Dosen Pembimbing';
                                                                        break;
                                                                    case 12:
                                                                        echo 'Ditolak Dosen Penguji 1';
                                                                        break;
                                                                    case 13:
                                                                        echo 'Ditolak Dosen Penguji 2';
                                                                        break;
                                                                    case 14:
                                                                        echo 'Ditolak Oleh Kaprodi';
                                                                        break;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $class = 'd-none'; // Default: sembunyikan tombol

                                                        if ($row->jenisberkas == 'revisi') {
                                                            if (($row->statusrevisi == 1 && $row->dosenpenguji1 == $dosen['NIPDosen']) ||
                                                                ($row->statusrevisi == 2 && $row->dosenpembimbing == $dosen['NIPDosen']) ||
                                                                ($row->statusrevisi == 3 && $row->koorpa == $dosen['NIPDosen'])) {
                                                                $class = ''; // Menampilkan tombol jika NIP cocok
                                                            }
                                                        } else {
                                                            if (($row->statuspengesahan == 1 && $row->dosenpembimbing == $dosen['NIPDosen']) ||
                                                                ($row->statuspengesahan == 2 && $row->dosenpenguji1 == $dosen['NIPDosen']) ||
                                                                ($row->statuspengesahan == 3 && $row->dosenpenguji2 == $dosen['NIPDosen']) ||
                                                                ($row->statuspengesahan == 4 && $row->dosenkaprodi == $dosen['NIPDosen'])) {
                                                                // ||($row->statuspengesahan == 5 && $row->koorpa == $dosen['NIPDosen'])) {
                                                                $class = ''; // Menampilkan tombol jika NIP cocok
                                                            }
                                                        }

                                                        // Sembunyikan tombol jika status sudah selesai
                                                        if ($row->statusrevisi == 4 || $row->statuspengesahan == 5) {
                                                            $class = 'd-none';
                                                        }
                                                        ?>
                                                        <button class="btn btn-primary <?php echo $class; ?>" style="color: #007bff; background-color: white; border-color: #007bff;"
                                                            onmouseover="this.style.backgroundColor='#0056b3'; this.style.color='white'"
                                                            onmouseout="this.style.backgroundColor='white'; this.style.color='#007bff'"
                                                            onclick="location.href='<?php echo base_url('Dosen/LihatPengajuan/'.$row->id); ?>'">Tanda tangani</button>
                                                        </td>
                                                            </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="7">Tidak ada data yang ditemukan.</td>
                                            </tr>
                                        <?php } ?>
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
<!-- content-wrapper ends -->

<script>
    window.onload = function() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage.innerText.trim() !== '') {
            flashMessage.style.display = 'block';
            setTimeout(() => {
                flashMessage.classList.add('fade-out');
                setTimeout(() => {
                    flashMessage.style.display = 'none';
                }, 1000); // Waktu animasi fade out
            }, 5000); // 5 detik sebelum mulai menghilang
        }
    }
</script>

<style>
    .alert {
        width: 100%;
        transition: height 0.5s, opacity 0.5s ease-in-out;
    }

    .fade-out {
        height: 0;
        opacity: 0;
    }

    @keyframes fadeOut {
        from { opacity: 0.5; height: auto; }
        to { opacity: 0; height: 0; }
    }
</style>
