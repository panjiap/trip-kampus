<?php 
session_start();
// PERBAIKAN DI SINI: Hapus titik dua (../)
include 'config/koneksi.php';

// 1. Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM trips WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

// 2. Logika Booking
$pesan_status = "";
if(isset($_POST['booking'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $hp = htmlspecialchars($_POST['hp']);
    $tgl_sekarang = date('Y-m-d H:i:s');

    if($row['kuota'] > 0) {
        $insert = mysqli_query($conn, "INSERT INTO bookings (trip_id, nama_pemesan, email, no_hp, tgl_booking, status) VALUES ('$id', '$nama', '$email', '$hp', '$tgl_sekarang', 'Pending')");
        
        if($insert) {
            mysqli_query($conn, "UPDATE trips SET kuota = kuota - 1 WHERE id='$id'");
            $pesan_status = "success";
        } else {
            $pesan_status = "error";
        }
    } else {
        $pesan_status = "full";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Trip - <?= $row['nama_trip']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-brand { font-family: 'Poppins', sans-serif; }
        .tab-active { border-bottom: 2px solid #2563EB; color: #2563EB; font-weight: 600; }
        .tab-inactive { color: #6B7280; font-weight: 500; }
    </style>
</head>
<body class="bg-gray-50 pt-20">

    <?php include 'layout/navbar.php'; ?>

    <div class="relative h-[50vh] w-full overflow-hidden">
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <img src="assets/img/<?= $row['gambar']; ?>" alt="<?= $row['nama_trip']; ?>" class="w-full h-full object-cover">
        <div class="absolute bottom-0 left-0 w-full z-20 p-8 bg-gradient-to-t from-black/80 to-transparent">
            <div class="max-w-7xl mx-auto px-4">
                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block"><?= $row['kategori']; ?></span>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2"><?= $row['nama_trip']; ?></h1>
                <div class="flex items-center text-white/90 space-x-4 text-sm font-medium">
                    <span>★ 4.8 (24 Ulasan)</span><span>•</span><span>3 Hari 2 Malam</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="lg:col-span-2">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex space-x-8">
                        <button onclick="openTab(event, 'deskripsi')" class="tab-btn tab-active py-4 px-1 border-b-2 font-medium text-sm">Deskripsi</button>
                        <button onclick="openTab(event, 'fasilitas')" class="tab-btn tab-inactive py-4 px-1 border-b-2 border-transparent font-medium text-sm">Fasilitas</button>
                        <button onclick="openTab(event, 'lokasi')" class="tab-btn tab-inactive py-4 px-1 border-b-2 border-transparent font-medium text-sm">Lokasi</button>
                    </nav>
                </div>

                <div id="deskripsi" class="tab-content block text-gray-600 leading-relaxed space-y-4 text-lg">
                    <?= nl2br($row['deskripsi']); ?>
                </div>

                <div id="fasilitas" class="tab-content hidden">
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php 
                            $fasilitas = explode("\n", $row['fasilitas']);
                            foreach($fasilitas as $fas): if(trim($fas) != ""):
                            ?>
                            <li class="flex items-center bg-white p-3 rounded-lg shadow-sm">
                                <span class="text-green-500 mr-2">✓</span> <span class="text-gray-700 font-medium"><?= $fas; ?></span>
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div id="lokasi" class="tab-content hidden">
                    <div class="w-full h-[400px] rounded-xl overflow-hidden shadow-md border border-gray-200">
                        <iframe src="<?= $row['lokasi_map']; ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-28">
                    <div class="flex justify-between items-center mb-6">
                        <div><p class="text-sm text-gray-500">Harga per orang</p><p class="text-3xl font-bold text-blue-600">Rp <?= number_format($row['harga']); ?></p></div>
                        <div class="text-right"><?= ($row['kuota'] > 0) ? '<span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Tersedia</span>' : '<span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Habis</span>'; ?></div>
                    </div>

                    <?php if($row['kuota'] > 0): ?>
                        <form method="POST" class="space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label><input type="text" name="nama" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label><input type="number" name="hp" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required placeholder="08..."></div>
                            <button type="submit" name="booking" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg transform active:scale-95">Booking Sekarang</button>
                        </form>
                    <?php else: ?>
                        <div class="text-center py-4 bg-gray-100 rounded-xl"><p class="text-gray-500 font-medium">Maaf, kuota penuh.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layout/footer.php'; ?>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" tab-active", " tab-inactive");
                tablinks[i].className = tablinks[i].className.replace(" border-blue-600", " border-transparent");
                tablinks[i].className = tablinks[i].className.replace(" text-blue-600", " text-gray-500");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className = "tab-btn py-4 px-1 border-b-2 font-medium text-sm tab-active border-blue-600 text-blue-600";
        }
        <?php if($pesan_status == 'success'): ?>
            Swal.fire({title: 'Berhasil!', text: 'Booking kamu sudah masuk. Admin akan segera menghubungi via WhatsApp!', icon: 'success', confirmButtonColor: '#2563EB'}).then((result) => { if (result.isConfirmed) { window.location = 'index.php'; } });
        <?php elseif($pesan_status == 'full'): ?>
            Swal.fire({title: 'Penuh!', text: 'Maaf, kuota trip habis.', icon: 'error'});
        <?php endif; ?>
    </script>
</body>
</html>