<?php
$host = "localhost";
$user = "henik";
$pass = "smkn3tbn";
$db   = "db_rekam_medis";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>