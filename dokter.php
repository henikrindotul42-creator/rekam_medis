<?php 
/** @var mysqli $conn */
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Dokter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-hospital"></i> REKAM MEDIS</h2>
        <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Data Pasien</a>
        <a href="dokter.php" class="active"><i class="fa-solid fa-user-doctor"></i> Data Dokter</a>
        <a href="obat.php"><i class="fa-solid fa-pills"></i> Data Obat</a>
        <a href="rekam_medis.php"><i class="fa-solid fa-clipboard-list"></i> Rekam Medis</a>
        <a href="riwayat.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Periksa</a>
    </div>

    <div class="main-content">
        <div class="header-top"><h1>Data Dokter</h1></div>

        <?php
        $edit = false;
        $data_edit = ['id_dokter' => '', 'nama_dokter' => '', 'spesialisasi' => ''];
        if (isset($_GET['edit'])) {
            $edit = true;
            $id = $_GET['edit'];
            $query_edit = mysqli_query($conn, "SELECT * FROM dokter WHERE id_dokter='$id'");
            $data_edit = mysqli_fetch_assoc($query_edit);
        }
        ?>

        <div class="container">
            <form action="proses_dokter.php" method="POST">
                <h3><?= $edit ? 'Edit Data Dokter' : 'Tambah Data Dokter' ?></h3>
                <?php if($edit): ?><input type="hidden" name="id_dokter" value="<?= $data_edit['id_dokter'] ?>"><?php endif; ?>
                <label>Nama Dokter</label><input type="text" name="nama_dokter" value="<?= $data_edit['nama_dokter'] ?>" required>
                <label>Spesialisasi</label><input type="text" name="spesialisasi" value="<?= $data_edit['spesialisasi'] ?>" required>
                <?php if($edit): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                    <a href="dokter.php" class="btn btn-danger">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn">Simpan Data</button>
                <?php endif; ?>
            </form>

            <table>
                <thead><tr><th>No</th><th>Nama Dokter</th><th>Spesialisasi</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Variabel $conn di bawah ini sekarang tidak akan digaris merah lagi oleh VS Code
                    $query = mysqli_query($conn, "SELECT * FROM dokter ORDER BY id_dokter DESC");
                    while ($d = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td><td><?= $d['nama_dokter'] ?></td><td><?= $d['spesialisasi'] ?></td>
                        <td>
                            <a href="dokter.php?edit=<?= $d['id_dokter'] ?>" class="btn btn-warning">Edit</a>
                            <!-- Tombol Hapus Kustom -->
                            <button type="button" class="btn btn-danger" onclick="konfirmasiHapus(<?= $d['id_dokter'] ?>)">Hapus</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kustom Alert HTML (Notifikasi Sukses) -->
    <div id="customAlert" class="alert-overlay" style="display: none;">
        <div class="alert-box">
            <i class="fa-solid fa-circle-check"></i>
            <h3>Berhasil!</h3>
            <p id="alertMessage">Pesan...</p>
            <button class="btn-ok" onclick="tutupAlert()">OK</button>
        </div>
    </div>

    <!-- Kustom Alert HTML (Konfirmasi Hapus) -->
    <div id="confirmAlert" class="alert-overlay" style="display: none;">
        <div class="alert-box">
            <i class="fa-solid fa-triangle-exclamation" style="color: #dc3545;"></i>
            <h3>Yakin Hapus?</h3>
            <p>Data dokter ini akan dihapus permanen!</p>
            <div style="margin-top: 20px;">
                <button class="btn-ok" onclick="lanjutkanHapus()">Ya, Hapus!</button>
                <button class="btn-ok" style="background-color: #6c757d; margin-left: 10px;" onclick="tutupConfirm()">Batal</button>
            </div>
        </div>
    </div>

    <!-- Script Kustom Alert -->
    <script>
        // Menampilkan notifikasi sukses (Data berhasil ditambah/dihapus)
        document.addEventListener('DOMContentLoaded', function() {
            let pesan = sessionStorage.getItem('pesanAlert');
            if (pesan) {
                document.getElementById('alertMessage').innerText = pesan;
                document.getElementById('customAlert').style.display = 'flex';
                sessionStorage.removeItem('pesanAlert'); 
            }
        });

        function tutupAlert() { document.getElementById('customAlert').style.display = 'none'; }

        // Logika untuk Konfirmasi Hapus
        let idHapus = null;

        function konfirmasiHapus(id) {
            idHapus = id; // Simpan ID yang mau dihapus
            document.getElementById('confirmAlert').style.display = 'flex';
        }

        function tutupConfirm() {
            idHapus = null;
            document.getElementById('confirmAlert').style.display = 'none';
        }

        function lanjutkanHapus() {
            if (idHapus) {
                // Arahkan ke proses hapus jika user klik "Ya"
                window.location.href = 'proses_dokter.php?hapus=' + idHapus;
            }
        }
    </script>
</body>
</html>