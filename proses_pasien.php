<?php
/** @var mysqli $conn */ // Menghilangkan error merah di Code Server
include 'koneksi.php';

// PROSES TAMBAH DATA
if (isset($_POST['tambah'])) {
    $no_rm = $_POST['no_rm'];
    $nama = $_POST['nama_pasien'];
    $jk = $_POST['jenis_kelamin'];
    $tgl = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO pasien (no_rm, nama_pasien, jenis_kelamin, tanggal_lahir, alamat) VALUES ('$no_rm', '$nama', '$jk', '$tgl', '$alamat')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Pasien Berhasil Ditambahkan!'); window.location='pasien.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menambah data pasien!'); window.location='pasien.php';</script>";
    }
}

// PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id = $_POST['id_pasien'];
    $no_rm = $_POST['no_rm'];
    $nama = $_POST['nama_pasien'];
    $jk = $_POST['jenis_kelamin'];
    $tgl = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE pasien SET no_rm='$no_rm', nama_pasien='$nama', jenis_kelamin='$jk', tanggal_lahir='$tgl', alamat='$alamat' WHERE id_pasien='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Pasien Berhasil Diperbarui!'); window.location='pasien.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal memperbarui data pasien!'); window.location='pasien.php';</script>";
    }
}

// PROSES HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM pasien WHERE id_pasien='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Pasien Berhasil Dihapus!'); window.location='pasien.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menghapus data pasien!'); window.location='pasien.php';</script>";
    }
}
?>