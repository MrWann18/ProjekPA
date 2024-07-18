<!-- HTML Structure for Modal and Table -->
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
                    <div>
                      <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button" onclick="window.location.href='<?php echo base_url('Mahasiswa/Pengajuan');?>'"><i
                          class="mdi mdi-attachment"></i>Ajukan Tanda Tangan</button>
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
                                <th>Dosen Penandatangan</th>
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
                                    <td>
                                      <?php
                                      $dosen_list = [
                                        $row->dosen1_nama,
                                        $row->dosen2_nama,
                                        $row->dosen3_nama,
                                        $row->dosen4_nama,
                                        $row->dosen5_nama
                                      ];

                                      foreach ($dosen_list as $dosen) {
                                        if (!empty($dosen)) {
                                          echo $dosen . "<br>";
                                        }
                                      }
                                      ?>
                                    </td>
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
                                      } else if ($row->jenisberkas == 'pengesahan'){
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
  <button class="lihat-pdf btn btn-primary" data-url="<?= base_url('uploads/' . $row->fileberkas); ?>" data-revisi="<?= $row->statusrevisi ?>" data-pengesahan="<?= $row->statuspengesahan ?>" data-jenisberkas="<?= $row->jenisberkas ?>" data-catatan="<?= $row->catatan ?>">Lihat</button>
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
      </div>
</div>
<!-- content-wrapper ends -->

<!-- Modal HTML -->
<div id="pdfModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <button id="downloadBtn" class="btn btn-primary" style="display: none;">Download PDF</button>
<br>
    <!-- Progress bar for status revisi -->
    <div id="progress-bar-revisi" class="progress-bar-container">
      <div class="step">
        <div class="bullet">1</div>
        <p>Dosen Penguji</p>
      </div>
      <div class="step">
        <div class="bullet">2</div>
        <p>Dosen Pembimbing</p>
      </div>
      <div class="step">
        <div class="bullet">3</div>
        <p>Koordinator PA</p>
      </div>
    </div>

    <!-- Catatan Revisi -->
    <div id="catatan-revisi" class="catatan-container" style="display: none;">
      <h5>Catatan Penolakan:</h5>
      <p id="catatan-revisi-text"></p>
    </div>

    <!-- Progress bar for status pengesahan -->
    <div id="progress-bar-pengesahan" class="progress-bar-container" style="display: none;">
      <div class="step">
        <div class="bullet">1</div>
        <p>Dosen Pembimbing</p>
      </div>
      <div class="step">
        <div class="bullet">2</div>
        <p>Dosen Penguji 1</p>
      </div>
      <div class="step">
        <div class="bullet">3</div>
        <p>Dosen Penguji 2</p>
      </div>
      <div class="step">
        <div class="bullet">4</div>
        <p>Kaprodi</p>
      </div>
    </div>

    <!-- Catatan Pengesahan -->
    <div id="catatan-pengesahan" class="catatan-container" style="display: none;">
      <h5>Catatan Penolakan:</h5>
      <p id="catatan-pengesahan-text"></p>
    </div>

    <canvas id="pdfCanvas"></canvas>
  </div>
  <br>
</div>

<!-- Link ke PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.worker.min.js"></script>

<style>
  .lihat-pdf {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 5px;
}

.lihat-pdf:hover {
  background-color: #0056b3;
}

/* Style for modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 800px;
  text-align: center;
  border-radius: 10px;
}

.close {
  color: #aaa;
  float: left;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

#pdfCanvas {
  width: 100%;
}

#downloadBtn {
  margin-top: 15px;
  padding: 10px 20px;
  font-size: 16px;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

#downloadBtn:hover {
  background-color: #0056b3;
}

/* Progress bar styles */
.progress-bar-container {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.step {
  text-align: center;
  flex: 1;
  position: relative;
  z-index: 1;
}

.step:not(:last-child)::after {
  content: '';
  position: absolute;
  top: 50%;
  right: -50%;
  height: 2px;
  width: 100%;
  background: #ccc;
  z-index: -1;
}

.step.completed:not(:last-child)::after {
  background: #007bff;
}

.step.rejected ~ .step:not(:last-child)::after {
  background: #ff0000;
}

.bullet {
  width: 30px;
  height: 30px;
  background-color: #ddd;
  border-radius: 50%;
  margin: 0 auto;
  line-height: 30px;
  font-weight: bold;
  color: white; /* Set text color to white */
  transition: background-color 0.3s, color 0.3s;
}

.step.completed .bullet {
  background-color: #007bff;
  color: white;
}

.step.rejected .bullet {
  background-color: #ff0000;
  color: white;
}

.step p {
  margin-top: 10px;
  font-size: 14px;
  font-weight: bold;
  color: #666;
  transition: color 0.3s;
}

.step.completed p {
  color: #007bff;
}

.step.rejected p {
  color: #ff0000;
}

/* Center catatan */
.catatan-container {
  text-align: center;
  margin-top: 20px;
  width: 100%;
}
</style>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById('pdfModal');
  var span = document.getElementsByClassName('close')[0];
  var pdfCanvas = document.getElementById('pdfCanvas');
  var downloadBtn = document.getElementById('downloadBtn');

  document.querySelectorAll('.lihat-pdf').forEach(function(button) {
    button.addEventListener('click', function() {
      event.preventDefault();
      var pdfUrl = this.getAttribute('data-url');
      var statusRevisi = parseInt(this.getAttribute('data-revisi'));
      var statusPengesahan = parseInt(this.getAttribute('data-pengesahan'));
      var jenisBerkas = this.getAttribute('data-jenisberkas');
      var catatan = this.getAttribute('data-catatan');

      console.log('PDF URL:', pdfUrl);
      console.log('Status Revisi:', statusRevisi);
      console.log('Status Pengesahan:', statusPengesahan);
      console.log('Jenis Berkas:', jenisBerkas);
      console.log('Catatan:', catatan);

      if (!pdfUrl) {
        console.error('PDF URL is missing');
        return;
      }

      var progressBarRevisi = document.getElementById('progress-bar-revisi');
      var progressBarPengesahan = document.getElementById('progress-bar-pengesahan');
      var catatanRevisi = document.getElementById('catatan-revisi');
      var catatanRevisiText = document.getElementById('catatan-revisi-text');
      var catatanPengesahan = document.getElementById('catatan-pengesahan');
      var catatanPengesahanText = document.getElementById('catatan-pengesahan-text');

      progressBarRevisi.style.display = 'none';
      progressBarPengesahan.style.display = 'none';
      catatanRevisi.style.display = 'none';
      catatanPengesahan.style.display = 'none';

      downloadBtn.style.display = 'none'; // Hide the download button by default

      if (jenisBerkas === 'revisi' && !isNaN(statusRevisi) && statusRevisi >= 0) {
        updateProgressBar(statusRevisi, progressBarRevisi, 'revisi');
        progressBarRevisi.style.display = 'flex';
        if (statusRevisi === 4) {
          downloadBtn.style.display = 'block'; // Show the download button if revisi is complete
        } else if (statusRevisi >= 11 && statusRevisi <= 13) {
          catatanRevisiText.innerText = catatan;
          catatanRevisi.style.display = 'block'; // Show the rejection note if revisi is rejected
        }
      } else if (jenisBerkas === 'pengesahan' && !isNaN(statusPengesahan) && statusPengesahan >= 0) {
        updateProgressBar(statusPengesahan, progressBarPengesahan, 'pengesahan');
        progressBarPengesahan.style.display = 'flex';
        if (statusPengesahan === 5) {
          downloadBtn.style.display = 'block'; // Show the download button if pengesahan is complete
        } else if (statusPengesahan >= 11 && statusPengesahan <= 14) {
          catatanPengesahanText.innerText = catatan;
          catatanPengesahan.style.display = 'block'; // Show the rejection note if pengesahan is rejected
        }
      }

      loadPDF(pdfUrl);
      modal.style.display = 'block';
      downloadBtn.onclick = function() {
        window.open(pdfUrl, '_blank');
      };
    });
  });

  span.onclick = function() {
    modal.style.display = 'none';
  };

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  };

  function loadPDF(url) {
    var loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function(pdf) {
      return pdf.getPage(1).then(function(page) {
        var viewport = page.getViewport({ scale: 1.5 });
        pdfCanvas.height = viewport.height;
        pdfCanvas.width = viewport.width;

        var renderContext = {
          canvasContext: pdfCanvas.getContext('2d'),
          viewport: viewport
        };
        page.render(renderContext);
      });
    }).catch(function(error) {
      console.error('Error loading PDF:', error);
    });
  }

  function updateProgressBar(status, progressBar, type) {
    var steps = progressBar.querySelectorAll('.step');
    steps.forEach(function(step, index) {
      step.classList.remove('completed', 'rejected');
    });

    if (type === 'revisi') {
      steps.forEach(function(step, index) {
        if (status >= 11 && status <= 13) {
          if (index === status - 11) {
            step.classList.add('rejected');
            if (step.nextElementSibling) {
              step.nextElementSibling.classList.add('rejected');
            }
          }
        } else if (index < status - 1) {
          step.classList.add('completed');
        }
      });
    } else if (type === 'pengesahan') {
      steps.forEach(function(step, index) {
        if (status >= 11 && status <= 14) {
          if (index === status - 11) {
            step.classList.add('rejected');
            if (step.nextElementSibling) {
              step.nextElementSibling.classList.add('rejected');
            }
          }
        } else if (index < status - 1) {
          step.classList.add('completed');
        }
      });
    }
  }
});


</script>
