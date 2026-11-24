<?php 
/** @var mysqli $conn */ // Menghilangkan error merah di Code Server
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekam Medis</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-hospital"></i> REKAM MEDIS</h2>
        <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Data Pasien</a>
        <a href="dokter.php"><i class="fa-solid fa-user-doctor"></i> Data Dokter</a>
        <a href="obat.php"><i class="fa-solid fa-pills"></i> Data Obat</a>
        <a href="rekam_medis.php" class="active"><i class="fa-solid fa-clipboard-list"></i> Rekam Medis</a>
        <a href="riwayat.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Periksa</a>
    </div>

    <div class="main-content">
        <div class="header-top"><h1>Input Rekam Medis</h1></div>

        <?php
        $edit = false;
        $data_edit = ['id_rekam' => '', 'id_pasien' => '', 'id_dokter' => '', 'id_obat' => '', 'tanggal_periksa' => '', 'keluhan' => '', 'diagnosa' => '', 'tindakan' => '', 'resep' => ''];
        if (isset($_GET['edit'])) {
            $edit = true;
            $id = $_GET['edit'];
            $query_edit = mysqli_query($conn, "SELECT * FROM rekam_medis WHERE id_rekam='$id'");
            $data_edit = mysqli_fetch_assoc($query_edit);
        }
        ?>

        <div class="container">
            <form action="proses_rekam.php" method="POST">
                <h3><?= $edit ? 'Edit Rekam Medis' : 'Tambah Rekam Medis Baru' ?></h3>
                <?php if($edit): ?><input type="hidden" name="id_rekam" value="<?= $data_edit['id_rekam'] ?>"><?php endif; ?>

                <label>Pilih Pasien</label>
                <select name="id_pasien" required>
                    <option value="">-- Pilih Pasien --</option>
                    <?php
                    $q_pasien = mysqli_query($conn, "SELECT * FROM pasien");
                    while ($p = mysqli_fetch_array($q_pasien)) {
                        $selected = ($data_edit['id_pasien'] == $p['id_pasien']) ? 'selected' : '';
                        echo "<option value='".$p['id_pasien']."' $selected>".$p['no_rm']." - ".$p['nama_pasien']."</option>";
                    }
                    ?>
                </select>

                <label>Pilih Dokter</label>
                <select name="id_dokter" required>
                    <option value="">-- Pilih Dokter --</option>
                    <?php
                    $q_dokter = mysqli_query($conn, "SELECT * FROM dokter");
                    while ($d = mysqli_fetch_array($q_dokter)) {
                        $selected = ($data_edit['id_dokter'] == $d['id_dokter']) ? 'selected' : '';
                        echo "<option value='".$d['id_dokter']."' $selected>".$d['nama_dokter']."</option>";
                    }
                    ?>
                </select>

                <label>Pilih Obat</label>
                <select name="id_obat" required>
                    <option value="">-- Pilih Obat --</option>
                    <?php
                    $q_obat = mysqli_query($conn, "SELECT * FROM obat");
                    while ($o = mysqli_fetch_array($q_obat)) {
                        $selected = ($data_edit['id_obat'] == $o['id_obat']) ? 'selected' : '';
                        echo "<option value='".$o['id_obat']."' $selected>".$o['nama_obat']."</option>";
                    }
                    ?>
                </select>

                <label>Tanggal Periksa</label><input type="date" name="tanggal_periksa" value="<?= $data_edit['tanggal_periksa'] ?>" required>
                <label>Keluhan</label><textarea name="keluhan" required><?= $data_edit['keluhan'] ?></textarea>
                <label>Diagnosa</label><textarea name="diagnosa" required><?= $data_edit['diagnosa'] ?></textarea>
                <label>Tindakan</label><textarea name="tindakan" required><?= $data_edit['tindakan'] ?></textarea>
                <label>Resep</label><input type="text" name="resep" value="<?= $data_edit['resep'] ?>" required>

                <?php if($edit): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Rekam Medis</button>
                    <a href="rekam_medis.php" class="btn btn-danger">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn">Simpan Rekam Medis</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Kustom Alert HTML -->
    <div id="customAlert" class="alert-overlay">
        <div class="alert-box">
            <i class="fa-solid fa-circle-check"></i>
            <h3>Berhasil!</h3>
            <p id="alertMessage">Pesan...</p>
            <button class="btn-ok" onclick="tutupAlert()">OK</button>
        </div>
    </div>
    <!-- Script Kustom Alert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let pesan = sessionStorage.getItem('pesanAlert');
            if (pesan) {
                document.getElementById('alertMessage').innerText = pesan;
                document.getElementById('customAlert').style.display = 'flex';
                sessionStorage.removeItem('pesanAlert'); 
            }
        });
        function tutupAlert() { document.getElementById('customAlert').style.display = 'none'; }
    </script>
</body>
</html>