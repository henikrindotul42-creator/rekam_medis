<?php
/** @var mysqli $conn */ // Menghilangkan error merah di Code Server
include 'koneksi.php';

// PROSES TAMBAH DATA
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];

    $query = "INSERT INTO dokter (nama_dokter, spesialisasi) VALUES ('$nama', '$spesialisasi')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Dokter Berhasil Ditambahkan!'); window.location='dokter.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menambah data dokter!'); window.location='dokter.php';</script>";
    }
}

// PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id = $_POST['id_dokter'];
    $nama = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];

    $query = "UPDATE dokter SET nama_dokter='$nama', spesialisasi='$spesialisasi' WHERE id_dokter='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Dokter Berhasil Diperbarui!'); window.location='dokter.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal memperbarui data dokter!'); window.location='dokter.php';</script>";
    }
}

// PROSES HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM dokter WHERE id_dokter='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Dokter Berhasil Dihapus!'); window.location='dokter.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menghapus data dokter!'); window.location='dokter.php';</script>";
    }
}
?>