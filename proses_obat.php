<?php
/** @var mysqli $conn */ // Menghilangkan error merah di Code Server
include 'koneksi.php';

// PROSES TAMBAH DATA
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_obat'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO obat (nama_obat, satuan, stok) VALUES ('$nama', '$satuan', '$stok')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Obat Berhasil Ditambahkan!'); window.location='obat.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menambah data obat!'); window.location='obat.php';</script>";
    }
}

// PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id = $_POST['id_obat'];
    $nama = $_POST['nama_obat'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];

    $query = "UPDATE obat SET nama_obat='$nama', satuan='$satuan', stok='$stok' WHERE id_obat='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Obat Berhasil Diperbarui!'); window.location='obat.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal memperbarui data obat!'); window.location='obat.php';</script>";
    }
}

// PROSES HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM obat WHERE id_obat='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>sessionStorage.setItem('pesanAlert', 'Data Obat Berhasil Dihapus!'); window.location='obat.php';</script>";
    } else {
        // Diperbaiki: Menggunakan alert kustom agar seragam
        echo "<script>sessionStorage.setItem('pesanAlert', 'Gagal menghapus data obat!'); window.location='obat.php';</script>";
    }
}
?>