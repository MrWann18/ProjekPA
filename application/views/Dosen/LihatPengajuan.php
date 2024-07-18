<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Save PDF with QR Code</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        #qr-code {
            position: absolute;
            cursor: move;
            width: 60px;
            height: 60px;
            display: none;
            background: white;
            border: 1px solid black;
            text-align: center;
        }
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
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .pdf-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
            height: 80vh;
            background-color: #f4f4f4;
        }
        .pdf-page {
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
    </style>
</head>
<body>
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
                                                    <div class="row">
                                                        <div class="col-md-12 grid-margin stretch-card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <?= $this->session->flashdata('message');?>
                                                                    </div>
                                                                </div>
                                                                <h4 class="card-title">Tanda Tangan Berkas</h4>
                                                                <form>
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><strong>Judul Berkas</strong></td>
                                                                                <td>:</td>
                                                                                <td><?= $pengajuan->judulberkas ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Jenis Berkas</strong></td>
                                                                                <td>:</td>
                                                                                <td><?= $pengajuan->jenisberkas ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Mahasiswa Pemohon</strong></td>
                                                                                <td>:</td>
                                                                                <td><?= $pengajuan->NamaMahasiswa ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Waktu Pengajuan</strong></td>
                                                                                <td>:</td>
                                                                                <td><?= $pengajuan->tanggalpengajuan ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <button type="button" class="btn btn-primary mb-3" onclick="showModal()">
                                                                        <i class="fas fa-qrcode mr-1"></i> Tambahkan QR Code
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger mb-3" onclick="showRejectModal()">
                                                                        <i class="fas fa-times-circle mr-1"></i> Tolak Tanda Tangan
                                                                    </button>
                                                                    <div id="pdf-container" class="border p-3">
                                                                        <!-- Kontainer untuk menampilkan PDF -->
                                                                    </div>
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
        <!-- Modal untuk menampilkan PDF dan QR Code -->
        <div id="qrModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="qr-code" class="qr-code"></div>
                <button type="button" class="btn btn-success" onclick="savePDF()">Simpan QR Code ke PDF</button>
                <div id="pdf-container-modal" class="pdf-container">
                    <canvas id="pdf-render-modal"></canvas>
                </div>
            </div>
        </div>
        <!-- Modal untuk alasan penolakan -->
        <div id="rejectModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeRejectModal()">&times;</span>
                <h2>Alasan Penolakan</h2>
                <form action="<?= site_url('Tandatangan/tolak_tandatangan') ?>" method="post">
                    <input type="hidden" name="idBerkas" value="<?= $idberkas ?>">
                    <input type="hidden" name="jenisBerkas" value="<?= $pengajuan->jenisberkas ?>">
                    <textarea id="rejectReason" name="catatan" class="form-control" rows="4" placeholder="Masukkan alasan penolakan..."></textarea>
                    <button type="submit" class="btn btn-danger mt-3">Tolak Tanda Tangan</button>
                </form>
            </div>
        </div>

        <script>
            var pdfUrl = '<?= $fileberkas ?>';
            var nextIdTandatangan = <?= $lastIdTandatangan ?>;

            function loadAndRenderPDF(url, containerId) {
                const container = document.getElementById(containerId);

                pdfjsLib.getDocument(url).promise.then(function(pdfDoc) {
                    // Bersihkan kontainer sebelum merender halaman
                    container.innerHTML = '';

                    for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                        pdfDoc.getPage(pageNum).then(function(page) {
                            const canvas = document.createElement('canvas');
                            canvas.className = 'pdf-page';
                            container.appendChild(canvas);

                            const viewport = page.getViewport({ scale: 1.0 });
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            const context = canvas.getContext('2d');
                            const renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };
                            page.render(renderContext);
                        });
                    }
                });
            }

            // Panggil fungsi untuk memuat PDF ketika halaman dimuat
            window.onload = function() {
                loadAndRenderPDF(pdfUrl, 'pdf-container');
            }

            function showModal() {
                const modal = document.getElementById('qrModal');
                modal.style.display = 'block';
                loadAndRenderPDF(pdfUrl, 'pdf-container-modal');
                generateQRCode(nextIdTandatangan);
            }

            function closeModal() {
                const modal = document.getElementById('qrModal');
                modal.style.display = 'none';
            }

            function generateQRCode(idTandatangan) {
                const qrCodeContainer = document.getElementById('qr-code');
                qrCodeContainer.style.display = 'block';  // Show the QR code container
                qrCodeContainer.innerHTML = '';
                const qrCode = new QRCode(qrCodeContainer, {
                    text: `http://localhost/ProyekPA/scan/detail?idTandatangan=${idTandatangan}`,  // Replace with your dynamic text
                    width: 60,
                    height: 60
                });

                let isDragging = false;
                let startX, startY, initialX, initialY;

                qrCodeContainer.addEventListener('mousedown', function(event) {
                    isDragging = true;
                    startX = event.clientX;
                    startY = event.clientY;
                    initialX = qrCodeContainer.offsetLeft;
                    initialY = qrCodeContainer.offsetTop;
                    event.preventDefault();
                });

                document.addEventListener('mousemove', function(event) {
                    if (isDragging) {
                        let deltaX = event.clientX - startX;
                        let deltaY = event.clientY - startY;
                        qrCodeContainer.style.left = (initialX + deltaX) + 'px';
                        qrCodeContainer.style.top = (initialY + deltaY) + 'px';
                    }
                });

                document.addEventListener('mouseup', function() {
                    isDragging = false;
                });

                qrCodeContainer.ondragstart = function() {
                    return false;
                };
            }

            function savePDF() {
                const { jsPDF } = window.jspdf;
                const canvases = document.querySelectorAll('#pdf-container-modal canvas');
                const qrCodeContainer = document.getElementById('qr-code');

                setTimeout(() => {
                    const pdf = new jsPDF({
                        unit: 'pt',
                        format: [canvases[0].width, canvases[0].height]  // Use the same dimensions as the first canvas
                    });

                    canvases.forEach((canvas, index) => {
                        if (index > 0) {
                            pdf.addPage();
                        }
                        pdf.addImage(canvas.toDataURL('image/png', 0.5), 'PNG', 0, 0, canvas.width, canvas.height);

                        if (qrCodeContainer.style.display !== 'none') {
                            const qrCodeImage = qrCodeContainer.querySelector('img');
                            if (qrCodeImage) {
                                const qrRect = qrCodeContainer.getBoundingClientRect();
                                const canvasRect = canvas.getBoundingClientRect();

                                const x = (qrRect.left - canvasRect.left) * (pdf.internal.pageSize.getWidth() / canvasRect.width);
                                const y = (qrRect.top - canvasRect.top) * (pdf.internal.pageSize.getHeight() / canvasRect.height);
                                const width = qrRect.width * (pdf.internal.pageSize.getWidth() / canvasRect.width);
                                const height = qrRect.height * (pdf.internal.pageSize.getHeight() / canvasRect.height);

                                pdf.addImage(qrCodeImage.src, 'PNG', x, y, width, height);
                            }
                        }
                    });

                    const pdfBlob = pdf.output('blob');

                    const formData = new FormData();
                    formData.append('file', pdfBlob, 'berkas_tandatangan.pdf');
                    formData.append('NIMMahasiswa', <?= $pengajuan->NIMMahasiswa ?>);
                    formData.append('NIPDosen', <?= $NIPDosen ?>);
                    formData.append('idBerkas', <?= $idberkas ?>);

                    // Kirimkan PDF ke server
                    fetch('<?= site_url('Tandatangan/simpan_pdf') ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                            alert('PDF berhasil disimpan dan data disimpan ke database!');
                            window.location.href = data.redirect;
                        } else {
                            alert('Gagal menyimpan PDF dan data.');
                        }
                    })
                    .catch(error => console.error('Error:', error));

                    closeModal();
                }, 1000);  // Adjust the delay as needed
            }

            // Close modal when clicking outside of it
            window.onclick = function(event) {
                const modal = document.getElementById('qrModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            function showRejectModal() {
                const modal = document.getElementById('rejectModal');
                modal.style.display = 'block';
            }

            function closeRejectModal() {
                const modal = document.getElementById('rejectModal');
                modal.style.display = 'none';
            }

            // Close modal when clicking outside of it
            window.onclick = function(event) {
                const qrModal = document.getElementById('qrModal');
                const rejectModal = document.getElementById('rejectModal');
                if (event.target == qrModal) {
                    qrModal.style.display = "none";
                }
                if (event.target == rejectModal) {
                    rejectModal.style.display = "none";
                }
            }
        </script>
    </div>
</body>
</html>
