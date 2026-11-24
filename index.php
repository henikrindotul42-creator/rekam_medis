<?php 
/** @var mysqli $conn */ // Ini untuk menghilangkan error merah di Code Server
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Rekam Medis</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .info-bar { display: flex; justify-content: space-between; background: #ffffff; padding: 15px 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(25, 118, 210, 0.08); border-left: 5px solid #64b5f6; font-weight: 500; color: #555; font-size: 0.95rem; }
        .info-bar span { display: flex; align-items: center; gap: 10px; }
        .info-bar i { color: #1976d2; font-size: 1.2rem; }
        .card-pasien { background: linear-gradient(135deg, #bbdefb, #90caf9) !important; border-bottom: 4px solid #1976d2 !important; color: #0d47a1; }
        .card-dokter { background: linear-gradient(135deg, #b3e5fc, #81d4fa) !important; border-bottom: 4px solid #0288d1 !important; color: #01579b; }
        .card-obat { background: linear-gradient(135deg, #e1f5fe, #b3e5fc) !important; border-bottom: 4px solid #039be5 !important; color: #0277bd; }
        .card-rekam { background: linear-gradient(135deg, #d1c4e9, #b39ddb) !important; border-bottom: 4px solid #5e35b1 !important; color: #311b92; }
        .card-pasien h3, .card-dokter h3, .card-obat h3, .card-rekam h3 { color: inherit !important; opacity: 0.8; }
        .card-pasien p, .card-dokter p, .card-obat p, .card-rekam p { color: inherit !important; }
        .motivation-box { background: #e3f2fd; color: #0d47a1; padding: 25px; border-radius: 15px; text-align: center; box-shadow: 0 5px 15px rgba(25, 118, 210, 0.08); margin-top: 20px; position: relative; overflow: hidden; border: 1px solid #bbdefb; }
        .motivation-box::before { content: "\201C"; font-family: serif; font-size: 100px; position: absolute; top: -20px; left: 20px; opacity: 0.1; color: #1976d2; }
        .motivation-box h4 { font-size: 1.3rem; margin-bottom: 10px; font-weight: 700; letter-spacing: 0.5px; z-index: 1; position: relative; color: #1565c0; }
        .motivation-box p { font-size: 1rem; font-style: italic; z-index: 1; position: relative; color: #1976d2; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-hospital"></i> REKAM MEDIS</h2>
        <a href="index.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Data Pasien</a>
        <a href="dokter.php"><i class="fa-solid fa-user-doctor"></i> Data Dokter</a>
        <a href="obat.php"><i class="fa-solid fa-pills"></i> Data Obat</a>
        <a href="rekam_medis.php"><i class="fa-solid fa-clipboard-list"></i> Rekam Medis</a>
        <a href="riwayat.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Periksa</a>
    </div>

    <div class="main-content">
        <div class="header-top"><h1>Dashboard Rekam Medis</h1></div>
        <div class="info-bar">
            <span id="tanggal-hari"><i class="fa-regular fa-calendar-days"></i> Memuat tanggal...</span>
            <span id="jam-digital"><i class="fa-regular fa-clock"></i> Memuat jam...</span>
        </div>

        <?php
        $q_pasien = mysqli_query($conn, "SELECT COUNT(*) as total FROM pasien");
        $q_dokter = mysqli_query($conn, "SELECT COUNT(*) as total FROM dokter");
        $q_obat   = mysqli_query($conn, "SELECT COUNT(*) as total FROM obat");
        $q_rekam  = mysqli_query($conn, "SELECT COUNT(*) as total FROM rekam_medis");
        $total_pasien = mysqli_fetch_assoc($q_pasien)['total'];
        $total_dokter = mysqli_fetch_assoc($q_dokter)['total'];
        $total_obat   = mysqli_fetch_assoc($q_obat)['total'];
        $total_rekam  = mysqli_fetch_assoc($q_rekam)['total'];

        $motivasi = [
            "Kesehatan bukanlah segalanya, tetapi tanpa kesehatan, segalanya menjadi tidak mungkin.",
            "Investasi terbaik adalah menjaga kesehatan tubuh dan pikiran Anda.",
            "Jangan lupa makan teratur, minum air putih yang cukup, dan istirahat yang cukup.",
            "Tubuh yang sehat adalah tempat bersemayamnya jiwa yang kuat.",
            "Langkah kecil untuk hidup sehat hari ini akan berdampak besar di masa depan."
        ];
        $pesan_hari_ini = $motivasi[array_rand($motivasi)];
        ?>

        <div class="dashboard-cards">
            <div class="card card-pasien"><h3>Total Pasien</h3><p><?= $total_pasien ?></p></div>
            <div class="card card-dokter"><h3>Total Dokter</h3><p><?= $total_dokter ?></p></div>
            <div class="card card-obat"><h3>Total Obat</h3><p><?= $total_obat ?></p></div>
            <div class="card card-rekam"><h3>Total Rekam Medis</h3><p><?= $total_rekam ?></p></div>
        </div>

        <div class="motivation-box">
            <h4><i class="fa-solid fa-heart-pulse"></i> Pesan Sehat Hari Ini</h4>
            <p>"<?= $pesan_hari_ini ?>"</p>
        </div>
    </div>

    <script>
        function updateWaktu() {
            const hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            let sekarang = new Date();
            let namaHari = hariIndo[sekarang.getDay()];
            let tanggal = sekarang.getDate();
            let namaBulan = bulanIndo[sekarang.getMonth()];
            let tahun = sekarang.getFullYear();
            document.getElementById('tanggal-hari').innerHTML = `<i class="fa-regular fa-calendar-days"></i> ${namaHari}, ${tanggal} ${namaBulan} ${tahun}`;
            let jam = String(sekarang.getHours()).padStart(2, '0');
            let menit = String(sekarang.getMinutes()).padStart(2, '0');
            let detik = String(sekarang.getSeconds()).padStart(2, '0');
            document.getElementById('jam-digital').innerHTML = `<i class="fa-regular fa-clock"></i> ${jam}:${menit}:${detik} WIB`;
        }
        updateWaktu();
        setInterval(updateWaktu, 1000);
    </script>
</body>
</html>