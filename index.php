<?php 
session_start();
include 'config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripKampus - Jelajahi Serunya Dunia Kampus!</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Hero Background dengan Overlay Gradient yang lebih cerah */
        .hero-bg {
            background: linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%), url('https://images.unsplash.com/photo-1682687982501-1e58ab814714?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover; background-position: center;
        }
        /* Smooth Scroll */
        html { scroll-behavior: smooth; }
        /* Custom Shadow yang lembut */
        .soft-shadow { box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2 text-2xl font-extrabold text-blue-600 tracking-tight">
                <i class="fa-solid fa-paper-plane"></i> TripKampus
            </a>

            <div class="hidden md:flex items-center space-x-8 font-medium text-gray-600">
                <a href="#" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#trips" class="hover:text-blue-600 transition">Paket Trip</a>
                <a href="#kenapa-kami" class="hover:text-blue-600 transition">Keunggulan</a>
            </div>

            <div class="hidden md:flex items-center space-x-3">
                <?php if(isset($_SESSION['user_login'])): ?>
                    <div class="flex items-center gap-3 pl-4 border-l">
                        <div class="text-right">
                            <p class="text-xs text-gray-400">Halo,</p>
                            <p class="text-sm font-bold text-blue-600 max-w-[100px] truncate"><?= $_SESSION['user_nama']; ?></p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            <?= substr($_SESSION['user_nama'], 0, 1); ?>
                        </div>
                        <a href="logout.php" class="text-gray-400 hover:text-red-500 transition ml-1" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="px-5 py-2.5 text-sm font-bold text-blue-600 hover:bg-blue-50 rounded-full transition">Masuk</a>
                    <a href="register.php" class="px-5 py-2.5 text-sm font-bold bg-blue-600 text-white rounded-full hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition">Daftar Gratis</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="hero-bg h-[650px] flex items-center relative">
        <div class="absolute bottom-0 left-0 right-0 z-0">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f9fafb" fill-opacity="1" d="M0,128L48,138.7C96,149,192,171,288,165.3C384,160,480,128,576,117.3C672,107,768,117,864,138.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full mt-10">
            <div class="max-w-3xl">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-600/20 text-blue-300 text-sm font-bold mb-4 border border-blue-500/30">🚀 Spesial Untuk Mahasiswa</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                    Liburan Impian,<br> Dompet Aman.
                </h1>
                <p class="text-lg text-gray-200 mb-10 leading-relaxed max-w-xl">
                    Temukan ratusan open trip terkurasi dengan harga pelajar. Healing jalan terus, tugas nanti dulu!
                </p>

                <form action="index.php" method="GET" class="bg-white p-2 rounded-full soft-shadow flex flex-col md:flex-row gap-2 max-w-2xl pl-6">
                    <div class="flex-1 flex items-center md:border-r border-gray-200 pr-4">
                        <i class="fa-solid fa-location-dot text-gray-400 mr-3"></i>
                        <input type="text" name="q" class="w-full py-3 font-medium focus:outline-none text-gray-700" placeholder="Mau kemana? (cth: Bromo)" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                    </div>
                    <div class="md:w-1/3 flex items-center px-4">
                         <i class="fa-solid fa-list text-gray-400 mr-3"></i>
                        <select name="kategori" class="w-full py-3 font-medium focus:outline-none text-gray-700 bg-transparent cursor-pointer">
                            <option value="">Semua Kategori</option>
                            <option value="Gunung" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'Gunung') ? 'selected' : '' ?>>⛰️ Gunung</option>
                            <option value="Pantai" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'Pantai') ? 'selected' : '' ?>>🏖️ Pantai</option>
                            <option value="City Tour" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'City Tour') ? 'selected' : '' ?>>🏙️ City Tour</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition flex items-center justify-center gap-2 shrink-0">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-20" id="kenapa-kami">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl soft-shadow border border-gray-100 hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 text-2xl mb-6">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Mahasiswa</h3>
                <p class="text-gray-500 leading-relaxed">Kami kurasi trip dengan budget yang pas di kantong pelajar. Gak perlu makan mie instan sebulan demi liburan.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl soft-shadow border border-gray-100 hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 text-2xl mb-6">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Mitra Terverifikasi</h3>
                <p class="text-gray-500 leading-relaxed">Semua travel agent partner sudah kami cek legalitas & rekam jejaknya. Liburan aman dan nyaman.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl soft-shadow border border-gray-100 hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 text-2xl mb-6">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Teman Baru</h3>
                <p class="text-gray-500 leading-relaxed">Konsep open trip memungkinkan kamu ketemu teman baru dari berbagai kampus lain. Perluas relasimu!</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-100/50 py-20" id="trips">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Destinasi Populer 🔥</h2>
                    <p class="text-lg text-gray-500 max-w-2xl">Pilihan trip paling banyak dibooking oleh mahasiswa bulan ini. Jangan sampai kehabisan slot!</p>
                </div>
            </div>

            <div class="space-y-8">
                <?php
                // LOGIKA PENCARIAN PHP
                $where = "WHERE 1=1";
                if(isset($_GET['q']) && $_GET['q'] != '') {
                    $q = mysqli_real_escape_string($conn, $_GET['q']);
                    $where .= " AND (nama_trip LIKE '%$q%' OR deskripsi LIKE '%$q%' OR lokasi_map LIKE '%$q%')";
                }
                if(isset($_GET['kategori']) && $_GET['kategori'] != '') {
                    $kat = mysqli_real_escape_string($conn, $_GET['kategori']);
                    $where .= " AND kategori = '$kat'";
                }

                $query = "SELECT * FROM trips $where ORDER BY id DESC";
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        // Warna kategori
                        $katBg = 'bg-blue-100 text-blue-700';
                        $katIcon = 'fa-mountain';
                        if($row['kategori'] == 'Pantai') { $katBg = 'bg-teal-100 text-teal-700'; $katIcon = 'fa-umbrella-beach'; }
                        if($row['kategori'] == 'City Tour') { $katBg = 'bg-purple-100 text-purple-700'; $katIcon = 'fa-city'; }
                ?>
                
                <div class="bg-white rounded-3xl overflow-hidden soft-shadow border border-gray-100 flex flex-col md:flex-row group hover:border-blue-200 transition-all duration-300">
                    
                    <div class="md:w-2/5 h-64 md:h-auto relative overflow-hidden">
                        <img src="assets/img/<?= $row['gambar']; ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="<?= $row['nama_trip']; ?>">
                        <div class="absolute top-4 left-4 <?= $katBg; ?> text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-2 z-10">
                           <i class="fa-solid <?= $katIcon; ?>"></i> <?= $row['kategori']; ?>
                        </div>
                         <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-60"></div>
                        <div class="absolute bottom-4 left-4 text-white flex items-center gap-2">
                             <i class="fa-solid fa-location-dot text-yellow-400"></i>
                             <span class="font-medium text-sm">Indonesia</span>
                        </div>
                    </div>

                    <div class="md:w-3/5 p-8 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition">
                                    <?= $row['nama_trip']; ?>
                                </h3>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 font-medium">
                                     <span class="flex items-center gap-1"><i class="fa-solid fa-star text-yellow-400"></i> 4.8 (Review)</span>
                                     <span>•</span>
                                     <span class="flex items-center gap-1"><i class="fa-regular fa-clock"></i> 3 Hari 2 Malam</span>
                                </div>
                            </div>
                            <div class="hidden md:flex h-10 w-10 bg-green-50 rounded-full items-center justify-center text-green-600" title="Mitra Terverifikasi">
                                <i class="fa-solid fa-shield-check text-xl"></i>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 line-clamp-2 mb-6 leading-relaxed">
                            <?= substr(strip_tags($row['deskripsi']), 0, 150); ?>...
                        </p>

                        <div class="flex flex-wrap gap-2 mb-6">
                            <?php 
                            $fasilitas = explode("\n", $row['fasilitas']);
                            $count = 0;
                            foreach($fasilitas as $fas): 
                                if(trim($fas) != "" && $count < 3): // Ambil 3 fasilitas pertama aja
                            ?>
                             <span class="text-xs font-medium bg-gray-100 text-gray-600 px-3 py-1 rounded-full flex items-center gap-1">
                                 <i class="fa-solid fa-check text-blue-500"></i> <?= trim($fas); ?>
                             </span>
                            <?php $count++; endif; endforeach; ?>
                             <?php if(count($fasilitas) > 3): ?>
                                <span class="text-xs font-medium text-gray-500 px-2 py-1">+<?= count($fasilitas)-3 ?> lainnya</span>
                             <?php endif; ?>
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Mulai dari</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm font-bold text-blue-600">Rp</span>
                                    <span class="text-3xl font-extrabold text-blue-600"><?= number_format($row['harga'], 0, ',', '.'); ?></span>
                                    <span class="text-gray-400 text-sm font-medium">/pax</span>
                                </div>
                            </div>
                            <a href="detail.php?id=<?= $row['id']; ?>" class="px-8 py-3.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition flex items-center gap-2">
                                Lihat Detail <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; else: ?>
                    <div class="text-center py-16 bg-white rounded-3xl soft-shadow">
                        <i class="fa-solid fa-map-location-dot text-6xl text-gray-200 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700">Yah, trip tidak ditemukan</h3>
                        <p class="text-gray-500">Coba gunakan kata kunci lain atau reset pencarian.</p>
                        <a href="index.php" class="inline-block mt-6 px-6 py-2 bg-gray-100 text-gray-600 rounded-full font-bold hover:bg-gray-200 transition">Reset Filter</a>
                    </div>
                <?php endif; ?>
            </div>
            
             <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="text-center mt-12">
                <a href="index.php" class="inline-block px-8 py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-full hover:border-blue-600 hover:text-blue-600 hover:shadow-lg transition duration-300">
    Lihat Semua Trip <i class="fa-solid fa-rotate-right ml-2"></i>
</a>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <footer class="bg-slate-900 text-white pt-20 pb-10 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 opacity-10">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,64L48,85.3C96,107,192,149,288,149.3C384,149,480,107,576,96C672,85,768,107,864,133.3C960,160,1056,192,1152,192C1248,192,1344,160,1392,144L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <a href="#" class="flex items-center gap-2 text-3xl font-extrabold text-white tracking-tight mb-6">
                        <i class="fa-solid fa-paper-plane text-blue-400"></i> TripKampus
                    </a>
                    <p class="text-slate-400 text-lg leading-relaxed mb-8 max-w-md">
                        Platform aggregator open trip nomor #1 yang didesain khusus untuk kebutuhan dan budget mahasiswa Indonesia.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Navigasi</h4>
                    <ul class="space-y-4 text-slate-400 font-medium">
                        <li><a href="#" class="hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="#trips" class="hover:text-blue-400 transition">Semua Trip</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Dukungan</h4>
                    <ul class="space-y-4 text-slate-400 font-medium">
                        <li><a href="#" class="hover:text-blue-400 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="admin/login.php" class="hover:text-blue-400 transition">Login Mitra/Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-slate-500 text-sm mb-4 md:mb-0">© 2025 TripKampus. Dibuat dengan ❤️ di Indonesia.</p>
                <div class="flex gap-6 text-sm font-medium text-slate-500">
                    <a href="#" class="hover:text-blue-400">Privacy</a>
                    <a href="#" class="hover:text-blue-400">Terms</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>