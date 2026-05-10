<?php
include '../config/koneksi.php';

// --- LOGIKA TAMBAH TRIP ---
if (isset($_POST['tambah_trip'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $kuota = $_POST['kuota'];
    $map = $_POST['map'];
    $desk = $_POST['deskripsi'];
    $fas = $_POST['fasilitas'];

    // Upload Gambar
    $gambar = uniqid() . '_' . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/img/" . $gambar);

    $query = "INSERT INTO trips VALUES (NULL, '$nama', '$kategori', '$desk', '$fas', '$harga', '$kuota', '$gambar', '$map')";
    
    if(mysqli_query($conn, $query)){
        header("Location: index.php");
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}

// --- LOGIKA EDIT TRIP (BARU) ---
if (isset($_POST['edit_trip'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $kuota = $_POST['kuota'];
    $map = $_POST['map'];
    $desk = $_POST['deskripsi'];
    $fas = $_POST['fasilitas'];
    $gambar_lama = $_POST['gambar_lama'];

    // Cek apakah user upload gambar baru?
    if ($_FILES['gambar']['error'] === 4) {
        // Jika tidak upload, pakai gambar lama
        $gambar = $gambar_lama;
    } else {
        // Jika upload baru, upload file baru & hapus file lama
        $gambar = uniqid() . '_' . $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/img/" . $gambar);
        
        // Hapus foto lama biar server gak penuh
        if (file_exists("../assets/img/" . $gambar_lama)) {
            unlink("../assets/img/" . $gambar_lama);
        }
    }

    $query = "UPDATE trips SET 
              nama_trip = '$nama',
              kategori = '$kategori',
              deskripsi = '$desk',
              fasilitas = '$fas',
              harga = '$harga',
              kuota = '$kuota',
              lokasi_map = '$map',
              gambar = '$gambar'
              WHERE id = '$id'";

    mysqli_query($conn, $query);
    header("Location: index.php");
}

// --- LOGIKA KONFIRMASI BOOKING ---
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['aksi'] == 'konfirmasi') ? 'Confirmed' : 'Cancelled';
    mysqli_query($conn, "UPDATE bookings SET status='$status' WHERE id='$id'");
    header("Location: index.php");
}
?>