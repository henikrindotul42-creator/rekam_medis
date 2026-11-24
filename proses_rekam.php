<?php
/** @var mysqli $conn */ // Menghilangkan error merah di Code Server

// Menampilkan error agar kita tahu jika ada masalah
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// PROSES TAMBAH DATA
if (isset($_POST['tambah'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $id_obat = $_POST['id_obat'];
    $tgl = $_POST['tanggal_periksa'];
    $keluhan = $_POST['keluhan'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $resep = $_POST['resep'];

    // VALIDASI TANGGAL: Memastikan tahun tidak lebih dari 4 digit
    $tahun = substr($tgl, 0, 4);
    if (strlen($tahun) > 4 || strlen($tgl) != 10) {
        // Menggunakan alert kustom
        echo "<script>sessionStorage.setItem('pesanAlert', 'Format tanggal tidak valid! Pastikan tahun hanya 4 digit (contoh: 2026).'); window.location='rekam_medis.php';</script>";
        exit; 
    }

    $query = "INSERT INTO rekam_medis (id_pasien, id_dokter, id_obat, tanggal_periksa, keluhan, diagnosa, tindakan, resep) 
              VALUES ('$id_pasien', '$id_dokter', '$id_obat', '$tgl', '$keluhan', '$diagnosa', '$tindakan', '$resep')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Rekam Medis Berhasil Disimpan!'); window.location='riwayat.php';</script>";
    } else {
        // Menggunakan alert kustom jika gagal query
        $error_msg = addslashes(mysqli_error($conn));
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menyimpan data: $error_msg'); window.location='rekam_medis.php';</script>";
    }
}

// PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id_rekam = $_POST['id_rekam'];
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $id_obat = $_POST['id_obat'];
    $tgl = $_POST['tanggal_periksa'];
    $keluhan = $_POST['keluhan'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $resep = $_POST['resep'];

    // VALIDASI TANGGAL
    $tahun = substr($tgl, 0, 4);
    if (strlen($tahun) > 4 || strlen($tgl) != 10) {
        // Menggunakan alert kustom
        echo "<script>sessionStorage.setItem('pesanAlert', 'Format tanggal tidak valid! Pastikan tahun hanya 4 digit (contoh: 2026).'); window.location='rekam_medis.php';</script>";
        exit;
    }

    $query = "UPDATE rekam_medis SET 
              id_pasien='$id_pasien', id_dokter='$id_dokter', id_obat='$id_obat', 
              tanggal_periksa='$tgl', keluhan='$keluhan', diagnosa='$diagnosa', tindakan='$tindakan', resep='$resep' 
              WHERE id_rekam='$id_rekam'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Rekam Medis Berhasil Diperbarui!'); window.location='riwayat.php';</script>";
    } else {
        // Menggunakan alert kustom jika gagal query
        $error_msg = addslashes(mysqli_error($conn));
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal update data: $error_msg'); window.location='rekam_medis.php';</script>";
    }
}
?>