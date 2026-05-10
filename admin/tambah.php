<?php 
session_start(); 
if(!isset($_SESSION['login'])) header("Location: login.php"); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Trip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow col-md-8 mx-auto">
            <div class="card-header bg-white"><h4>Tambah Trip Baru</h4></div>
            <div class="card-body">
                <form action="proses.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Trip</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option>Gunung</option>
                                <option>Pantai</option>
                                <option>City Tour</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Kuota</label>
                            <input type="number" name="kuota" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Foto Trip</label>
                        <img class="img-preview img-fluid mb-3 col-sm-5 d-block" style="max-height: 200px; border-radius: 10px; display: none;">
                        
                        <input type="file" id="gambar" name="gambar" class="form-control" onchange="previewImage()" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Maps (Embed)</label>
                        <input type="text" name="map" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>
                        <textarea name="fasilitas" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <button type="submit" name="tambah_trip" class="btn btn-primary w-100">Simpan</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');

            // Munculkan elemen gambar (karena defaultnya display:none)
            imgPreview.style.display = 'block';

            // Membaca file
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                // Mengganti src gambar dengan file yang baru diupload
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
</body>
</html>