<?php 
/** @var mysqli $conn */
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pemeriksaan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-hospital"></i> REKAM MEDIS</h2>
        <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Data Pasien</a>
        <a href="dokter.php"><i class="fa-solid fa-user-doctor"></i> Data Dokter</a>
        <a href="obat.php"><i class="fa-solid fa-pills"></i> Data Obat</a>
        <a href="rekam_medis.php"><i class="fa-solid fa-clipboard-list"></i> Rekam Medis</a>
        <a href="riwayat.php" class="active"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Periksa</a>
    </div>

    <div class="main-content">
        <div class="header-top"><h1>Riwayat Pemeriksaan</h1></div>

        <div class="container">
            <p style="margin-bottom: 15px;">Data di bawah ini ditarik menggunakan <b>SQL JOIN</b> dari 4 tabel.</p>
            
            <!-- Tambahan style overflow-x agar tabel bisa di-scroll ke samping jika kepanjangan -->
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Obat</th>
                            <!-- KOLOM BARU DITAMBAHKAN DI SINI -->
                            <th>Keluhan</th>
                            <th>Diagnosa</th>
                            <th>Tindakan</th>
                            <th>Resep</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT rekam_medis.*, pasien.nama_pasien, dokter.nama_dokter, obat.nama_obat 
                                  FROM rekam_medis 
                                  JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien 
                                  JOIN dokter ON rekam_medis.id_dokter = dokter.id_dokter 
                                  JOIN obat ON rekam_medis.id_obat = obat.id_obat
                                  ORDER BY rekam_medis.tanggal_periksa DESC";
                        $result = mysqli_query($conn, $query);
                        
                        if (mysqli_num_rows($result) == 0) {
                            echo "<tr><td colspan='10' style='text-align:center;'>Belum ada data rekam medis.</td></tr>";
                        }
                        while ($d = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['tanggal_periksa'] ?></td>
                            <td><?= $d['nama_pasien'] ?></td>
                            <td><?= $d['nama_dokter'] ?></td>
                            <td><?= $d['nama_obat'] ?></td>
                            <!-- DATA BARU DITAMPILKAN DI SINI -->
                            <!-- Pastikan nama kolom di database Anda persis: keluhan, tindakan, resep -->
                            <td><?= isset($d['keluhan']) ? $d['keluhan'] : '-' ?></td>
                            <td><?= $d['diagnosa'] ?></td>
                            <td><?= isset($d['tindakan']) ? $d['tindakan'] : '-' ?></td>
                            <td><?= isset($d['resep']) ? $d['resep'] : '-' ?></td>
                            
                            <td>
                                <a href="rekam_medis.php?edit=<?= $d['id_rekam'] ?>" class="btn btn-warning">Edit</a>
                                <a href="hapus_rekam.php?id=<?= $d['id_rekam'] ?>" 
                                   class="btn btn-danger" 
                                   onclick="konfirmasiHapus(event, this.href, '<?= $d['nama_pasien'] ?>')">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

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
    
    <!-- Script Kustom Alert & Konfirmasi Hapus -->
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

        function konfirmasiHapus(event, url, nama_pasien) {
            event.preventDefault(); 
            Swal.fire({
                title: 'Yakin Hapus?',
                text: 'Data rekam medis ' + nama_pasien + ' ini akan dihapus permanen!',
                icon: 'warning',
                iconHtml: '<i class="fa-solid fa-triangle-exclamation"></i>',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#1976d2',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'my-custom-popup',
                    icon: 'my-custom-icon',
                    title: 'my-custom-title',
                    htmlContainer: 'my-custom-text',
                    confirmButton: 'my-custom-confirm',
                    cancelButton: 'my-custom-cancel'
                },
                didOpen: () => {
                    const icon = Swal.getIcon();
                    if (icon) {
                        icon.style.border = 'none'; 
                        icon.style.color = '#e6374f';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url; 
                }
            });
        }
    </script>
</body>
</html>