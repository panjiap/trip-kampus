<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include '../config/koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM trips WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Trip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow col-md-8 mx-auto">
            <div class="card-header bg-white"><h4>Edit Data Trip</h4></div>
            <div class="card-body">
                <form action="proses.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $data['gambar']; ?>">

                    <div class="mb-3">
                        <label>Nama Trip</label>
                        <input type="text" name="nama" class="form-control" value="<?= $data['nama_trip']; ?>" required>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label>Kategori</label>
                            <select name="kategori" class="form-select">
                                <option <?= ($data['kategori'] == 'Gunung') ? 'selected' : ''; ?>>Gunung</option>
                                <option <?= ($data['kategori'] == 'Pantai') ? 'selected' : ''; ?>>Pantai</option>
                                <option <?= ($data['kategori'] == 'City Tour') ? 'selected' : ''; ?>>City Tour</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
                        </div>
                        <div class="col mb-3">
                            <label>Kuota</label>
                            <input type="number" name="kuota" class="form-control" value="<?= $data['kuota']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label>Foto Saat Ini</label><br>
                        <img src="../assets/img/<?= $data['gambar']; ?>" width="100" class="mb-2 rounded">
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">*Kosongkan jika tidak ingin mengganti foto</small>
                    </div>

                    <div class="mb-3">
                        <label>Link Maps (Embed)</label>
                        <input type="text" name="map" class="form-control" value='<?= $data['lokasi_map']; ?>' required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Fasilitas</label>
                        <textarea name="fasilitas" class="form-control" rows="2"><?= $data['fasilitas']; ?></textarea>
                    </div>

                    <button type="submit" name="edit_trip" class="btn btn-warning w-100 text-white fw-bold">Update Data</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>