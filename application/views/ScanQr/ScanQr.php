<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Tanda Tangan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #2c3e50;
        }

        .content p {
            margin: 12px 0;
            font-size: 16px;
            color: #555;
        }

        .content p strong {
            display: inline-block;
            width: 200px;
            color: #333;
            font-weight: 500;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tanda Tangan Ini Asli Milik PSTI PCR</h1>
        </div>
        <div class="content">
            <!-- <p><strong>ID Tanda Tangan:</strong> <?= $tandatangan->id ?></p> -->
            <p><strong>Judul Berkas :</strong> <?= $tandatangan->judulberkas ?></p>
            <p><strong>Jenis Berkas :</strong> <?= $tandatangan->jenisberkas ?></p>
            <p><strong>Nama Mahasiswa Pengaju :</strong> <?= $tandatangan->nama_mahasiswa ?></p>
            <p><strong>NIM Mahasiswa :</strong> <?= $tandatangan->NIMMahasiswa ?></p>    
            <p><strong>Dosen Penandatangan :</strong> <?= $tandatangan->NamaDosen ?></p>
            <p><strong>NIP Dosen Penandatangan :</strong> <?= $tandatangan->NIPDosen ?></p>
            <p><strong>Tanggal Ditandatangani :</strong> <?= $tandatangan->created_at ?></p>
            
            <!-- Tambahkan informasi lain yang relevan -->
        </div>
        <div class="footer">
            &copy; 2024 <a href="#">PSTI PCR</a>. All rights reserved.
        </div>
    </div>
</body>
</html>
