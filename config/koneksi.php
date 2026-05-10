<?php
// Ubah "db_tripkampus" menjadi "tripkampus"
$conn = mysqli_connect("localhost", "root", "", "tripkampus");

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>