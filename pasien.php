<?php 
/** @var mysqli $conn */
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-hospital"></i> REKAM MEDIS</h2>
        <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="pasien.php" class="active"><i class="fa-solid fa-user-injured"></i> Data Pasien</a>
        <a href="dokter.php"><i class="fa-solid fa-user-doctor"></i> Data Dokter</a>
        <a href="obat.php"><i class="fa-solid fa-pills"></i> Data Obat</a>
        <a href="rekam_medis.php"><i class="fa-solid fa-clipboard-list"></i> Rekam Medis</a>
        <a href="riwayat.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Periksa</a>
    </div>

    <div class="main-content">
        <div class="header-top"><h1>Data Pasien</h1></div>

        <?php
        $edit = false;
        $data_edit = ['id_pasien' => '', 'no_rm' => '', 'nama_pasien' => '', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '', 'alamat' => ''];
        
        if (isset($_GET['edit'])) {
            $edit = true;
            $id = $_GET['edit'];
            $query_edit = mysqli_query($conn, "SELECT * FROM pasien WHERE id_pasien='$id'");
            $data_edit = mysqli_fetch_assoc($query_edit);
        }
        ?>

        <div class="container">
            <form action="proses_pasien.php" method="POST">
                <h3><?= $edit ? 'Edit Data Pasien' : 'Tambah Data Pasien' ?></h3>
                <?php if($edit): ?><input type="hidden" name="id_pasien" value="<?= $data_edit['id_pasien'] ?>"><?php endif; ?>
                
                <label>No. RM</label>
                <input type="text" name="no_rm" value="<?= $data_edit['no_rm'] ?>" required>
                
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien" value="<?= $data_edit['nama_pasien'] ?>" required>
                
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="L" <?= $data_edit['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $data_edit['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
                
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= $data_edit['tanggal_lahir'] ?>" required>
                
                <label>Alamat</label>
                <textarea name="alamat" rows="3" required><?= $data_edit['alamat'] ?></textarea>
                
                <?php if($edit): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                    <a href="pasien.php" class="btn btn-danger">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn">Simpan Data</button>
                <?php endif; ?>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>JK</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM pasien ORDER BY id_pasien DESC");
                    while ($p = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['no_rm'] ?></td>
                        <td><?= $p['nama_pasien'] ?></td>
                        <td><?= $p['jenis_kelamin'] ?></td>
                        <td><?= $p['tanggal_lahir'] ?></td>
                        <td><?= $p['alamat'] ?></td>
                        <td>
                            <a href="pasien.php?edit=<?= $p['id_pasien'] ?>" class="btn btn-warning">Edit</a>
                            <!-- PERUBAHAN ADA DI SINI: Tombol Hapus sudah memanggil fungsi konfirmasiHapus -->
                            <button type="button" class="btn btn-danger" onclick="konfirmasiHapus(<?= $p['id_pasien'] ?>)">Hapus</button>
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
            <p>Data pasien ini akan dihapus permanen!</p>
            <div style="margin-top: 20px;">
                <button class="btn-ok" onclick="lanjutkanHapus()">Ya, Hapus!</button>
                <button class="btn-ok" style="background-color: #6c757d; margin-left: 10px;" onclick="tutupConfirm()">Batal</button>
            </div>
        </div>
    </div>

    <!-- Script Kustom Alert -->
    <script>
        // Menampilkan notifikasi sukses
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
                // Arahkan ke proses hapus pasien
                window.location.href = 'proses_pasien.php?hapus=' + idHapus;
            }
        }
    </script>
</body>
</html>