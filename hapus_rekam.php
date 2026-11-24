<?php
/** @var mysqli $conn */ // Menghilangkan error merah di Code Server
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM rekam_medis WHERE id_rekam='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Rekam Medis Berhasil Dihapus!'); window.location='riwayat.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menghapus data rekam medis!'); window.location='riwayat.php';</script>";
    }
} else {
    header("Location: riwayat.php");
}
?>