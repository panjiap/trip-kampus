<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama gambar dulu
    $query = mysqli_query($conn, "SELECT gambar FROM trips WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    $gambar_lama = $data['gambar'];

    // 2. Hapus file gambar dari folder assets/img
    if (file_exists("../assets/img/" . $gambar_lama)) {
        unlink("../assets/img/" . $gambar_lama);
    }

    // 3. Hapus data dari database
    mysqli_query($conn, "DELETE FROM trips WHERE id = '$id'");

    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
}
?>