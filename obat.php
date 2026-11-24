<?php
/** @var mysqli $conn */
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2><i class="fa-solid fa-hospital"></i> REKAM MEDIS</h2>

        <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Data Pasien</a>
        <a href="dokter.php"><i class="fa-solid fa-user-doctor"></i> Data Dokter</a>
        <a href="obat.php" class="active"><i class="fa-solid fa-pills"></i> Data Obat</a>
        <a href="rekam_medis.php"><i class="fa-solid fa-clipboard-list"></i> Rekam Medis</a>
        <a href="riwayat.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Periksa</a>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="main-content">

        <div class="header-top">
            <h1>Data Obat</h1>
        </div>

        <?php
        $edit = false;

        $data_edit = [
            'id_obat' => '',
            'nama_obat' => '',
            'satuan' => '',
            'stok' => ''
        ];

        if (isset($_GET['edit'])) {
            $edit = true;
            $id = (int) $_GET['edit'];

            $query_edit = mysqli_query(
                $conn,
                "SELECT * FROM obat WHERE id_obat='$id'"
            );

            if ($query_edit && mysqli_num_rows($query_edit) > 0) {
                $data_edit = mysqli_fetch_assoc($query_edit);
            } else {
                $edit = false;
            }
        }
        ?>

        <div class="container">

            <!-- FORM TAMBAH DAN EDIT -->
            <form action="proses_obat.php" method="POST">

                <h3>
                    <?= $edit ? 'Edit Data Obat' : 'Tambah Data Obat' ?>
                </h3>

                <?php if ($edit): ?>
                    <input type="hidden" name="id_obat"
                        value="<?= htmlspecialchars($data_edit['id_obat']) ?>">
                <?php endif; ?>

                <label>Nama Obat</label>
                <input type="text" name="nama_obat"
                    value="<?= htmlspecialchars($data_edit['nama_obat']) ?>" required>

                <label>Satuan</label>
                <input type="text" name="satuan"
                    value="<?= htmlspecialchars($data_edit['satuan']) ?>" required>

                <label>Stok</label>
                <input type="number" name="stok"
                    value="<?= htmlspecialchars($data_edit['stok']) ?>" required>

                <?php if ($edit): ?>

                    <button type="submit" name="update" class="btn btn-warning">
                        Update Data
                    </button>

                    <a href="obat.php" class="btn btn-danger">Batal</a>

                <?php else: ?>

                    <button type="submit" name="tambah" class="btn">
                        Simpan Data
                    </button>

                <?php endif; ?>

            </form>

            <!-- TABEL DATA OBAT -->
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    $query = mysqli_query(
                        $conn,
                        "SELECT * FROM obat ORDER BY id_obat DESC"
                    );

                    while ($d = mysqli_fetch_assoc($query)):
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>

                        <td>
                            <?= htmlspecialchars($d['nama_obat']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($d['satuan']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($d['stok']) ?>
                        </td>

                        <td>

                            <a href="obat.php?edit=<?= (int)$d['id_obat'] ?>"
                               class="btn btn-warning">
                                Edit
                            </a>

                            <!-- TOMBOL HAPUS -->
                            <a href="proses_obat.php?hapus=<?= (int)$d['id_obat'] ?>"
                               class="btn btn-danger"
                               onclick="konfirmasiHapus(
                                   event,
                                   this.href,
                                   <?= htmlspecialchars(
                                       json_encode($d['nama_obat'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP),
                                       ENT_QUOTES,
                                       'UTF-8'
                                   ) ?>
                               )">
                                Hapus
                            </a>

                        </td>
                    </tr>

                    <?php endwhile; ?>

                </tbody>
            </table>

        </div>
    </div>

    <!-- ALERT BERHASIL -->
    <div id="customAlert" class="alert-overlay">
        <div class="alert-box">

            <i class="fa-solid fa-circle-check"></i>

            <h3>Berhasil!</h3>

            <p id="alertMessage">Pesan...</p>

            <button class="btn-ok" onclick="tutupAlert()">
                OK
            </button>

        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>

        // NOTIFIKASI BERHASIL
        document.addEventListener('DOMContentLoaded', function() {

            let pesan = sessionStorage.getItem('pesanAlert');

            if (pesan) {

                document.getElementById('alertMessage').innerText = pesan;

                document.getElementById('customAlert').style.display = 'flex';

                sessionStorage.removeItem('pesanAlert');
            }

        });

        function tutupAlert() {
            document.getElementById('customAlert').style.display = 'none';
        }

        // KONFIRMASI HAPUS (SWEETALERT)
        function konfirmasiHapus(event, url, nama_obat) {

            event.preventDefault();

            Swal.fire({
                title: 'Yakin Hapus?',

                text: 'Data obat ' + nama_obat + ' ini akan dihapus permanen!',

                icon: 'warning',

                // Menyisipkan ikon FontAwesome sebagai ganti ikon bawaan
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
                
                // TAMBAHAN BARU: Memastikan animasi pop-up berjalan sempurna
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