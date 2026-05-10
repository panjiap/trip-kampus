<?php
session_start();
// Cek Session Login
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// PENTING: Gunakan ../ untuk keluar dari folder admin ke folder config
include '../config/koneksi.php';

// --- LOGIKA STATISTIK ---
// 1. Hitung Total Trip
$q_trip = mysqli_query($conn, "SELECT * FROM trips");
$jum_trip = mysqli_num_rows($q_trip);

// 2. Hitung Total Pendaftar
$q_book = mysqli_query($conn, "SELECT * FROM bookings");
$jum_book = mysqli_num_rows($q_book);

// 3. Hitung Menunggu Konfirmasi
$q_pending = mysqli_query($conn, "SELECT * FROM bookings WHERE status='Pending'");
$jum_pending = mysqli_num_rows($q_pending);

// --- LOGIKA FILTER OTOMATIS ---
// Jika diklik dari kartu "Menunggu Konfirmasi", otomatis buka tab booking
$filter_status = isset($_GET['filter']) ? $_GET['filter'] : '';
$active_tab = ($filter_status == 'pending') ? 'bookings' : 'trips'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TripKampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">
        
        <div class="w-64 bg-slate-900 text-white flex flex-col shadow-2xl z-20">
            <div class="p-6 border-b border-slate-800 flex items-center">
                 <svg class="w-8 h-8 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                <div>
                    <h1 class="text-xl font-bold text-white">TripKampus</h1>
                    <p class="text-xs text-slate-500">Admin Panel v1.0</p>
                </div>
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="index.php" class="flex items-center px-4 py-3 rounded-lg bg-blue-600 text-white shadow-lg shadow-blue-900/50 transition-transform hover:scale-105">
                    <span class="mr-3">📊</span> Dashboard
                </a>
                <a href="../index.php" target="_blank" class="flex items-center px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <span class="mr-3">🌍</span> Lihat Website
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <a href="logout.php" class="flex items-center w-full px-4 py-2 text-red-400 hover:bg-red-900/20 rounded-lg transition">
                    <span class="mr-2">🚪</span> Logout
                </a>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center z-10">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-gray-700"><?= $_SESSION['nama'] ?? 'Admin Ganteng'; ?></p>
                        <p class="text-xs text-green-600 font-medium">Super Admin</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md">
                        A
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4 text-2xl">📦</div>
                        <div>
                            <p class="text-slate-500 text-sm">Total Trip</p>
                            <h3 class="text-2xl font-bold text-slate-800"><?= $jum_trip; ?></h3>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4 text-2xl">👥</div>
                        <div>
                            <p class="text-slate-500 text-sm">Total Pendaftar</p>
                            <h3 class="text-2xl font-bold text-slate-800"><?= $jum_book; ?></h3>
                        </div>
                    </div>

                    <a href="index.php?filter=pending" class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center hover:shadow-md transition cursor-pointer ring-2 ring-transparent hover:ring-yellow-400 group">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4 text-2xl group-hover:scale-110 transition">⏳</div>
                        <div>
                            <p class="text-slate-500 text-sm">Menunggu Konfirmasi</p>
                            <h3 class="text-2xl font-bold text-slate-800"><?= $jum_pending; ?></h3>
                        </div>
                    </a>
                </div>

                <div class="mb-0 border-b border-gray-200 bg-white px-6 rounded-t-xl shadow-sm">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="switchTab('trips')" id="tab-trips" class="<?= ($active_tab=='trips') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Daftar Paket Wisata
                        </button>
                        <button onclick="switchTab('bookings')" id="tab-bookings" class="<?= ($active_tab=='bookings') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Data Booking
                            <?php if($jum_pending > 0): ?>
                                <span class="ml-2 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs animate-pulse"><?= $jum_pending; ?></span>
                            <?php endif; ?>
                        </button>
                    </nav>
                </div>

                <div id="content-trips" class="<?= ($active_tab=='trips') ? 'block' : 'hidden'; ?> bg-white rounded-b-xl shadow-sm border border-t-0 border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-bold text-slate-800">Semua Trip</h3>
                        <a href="tambah.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow flex items-center">
                            <span>+</span>&nbsp; Tambah Trip
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="uppercase tracking-wider border-b-2 border-gray-200 bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Trip</th>
                                    <th class="px-6 py-4 font-semibold">Kategori</th>
                                    <th class="px-6 py-4 font-semibold">Harga</th>
                                    <th class="px-6 py-4 font-semibold">Kuota</th>
                                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $trips = mysqli_query($conn, "SELECT * FROM trips ORDER BY id DESC");
                                if(mysqli_num_rows($trips) > 0):
                                    while($t = mysqli_fetch_assoc($trips)):
                                ?>
                                <tr class="hover:bg-blue-50 transition border-b border-gray-100 last:border-0">
                                    <td class="px-6 py-4 flex items-center">
                                        <img class="w-10 h-10 rounded object-cover mr-3 border border-gray-200" src="../assets/img/<?= $t['gambar']; ?>" alt="Img"> 
                                        <span class="font-medium text-gray-900"><?= $t['nama_trip']; ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium border border-slate-200"><?= $t['kategori']; ?></span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-blue-600">Rp <?= number_format($t['harga']); ?></td>
                                    <td class="px-6 py-4 text-gray-500"><?= $t['kuota']; ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="edit.php?id=<?= $t['id']; ?>" class="text-yellow-500 hover:text-yellow-600 mr-3 p-1 hover:bg-yellow-50 rounded" title="Edit">✏️</a>
                                        <a href="hapus.php?id=<?= $t['id']; ?>" onclick="return confirm('Yakin hapus trip ini?')" class="text-red-500 hover:text-red-600 p-1 hover:bg-red-50 rounded" title="Hapus">🗑️</a>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data trip. Silakan tambah trip baru.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="content-bookings" class="<?= ($active_tab=='bookings') ? 'block' : 'hidden'; ?> bg-white rounded-b-xl shadow-sm border border-t-0 border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Data Booking Masuk</h3>
                        <?php if($filter_status == 'pending'): ?>
                            <a href="index.php" class="text-sm text-blue-600 hover:underline font-medium">← Tampilkan Semua</a>
                        <?php endif; ?>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="uppercase tracking-wider border-b-2 border-gray-200 bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold">Pemesan</th>
                                    <th class="px-6 py-4 font-semibold">Trip</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT bookings.*, trips.nama_trip FROM bookings JOIN trips ON bookings.trip_id = trips.id";
                                if($filter_status == 'pending') {
                                    $sql .= " WHERE bookings.status = 'Pending'";
                                }
                                $sql .= " ORDER BY bookings.id DESC";
                                
                                $books = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($books) > 0):
                                    while($b = mysqli_fetch_assoc($books)):
                                ?>
                                <tr class="hover:bg-blue-50 transition border-b border-gray-100 last:border-0">
                                    <td class="px-6 py-4 text-gray-500"><?= date('d/m/y H:i', strtotime($b['tgl_booking'])); ?></td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-800"><?= $b['nama_pemesan']; ?></p>
                                        <p class="text-xs text-gray-500 mt-0.5">📞 <?= $b['no_hp']; ?></p>
                                    </td>
                                    <td class="px-6 py-4 text-blue-600 font-medium"><?= $b['nama_trip']; ?></td>
                                    <td class="px-6 py-4">
                                        <?php 
                                            $badgeColor = 'bg-gray-100 text-gray-600';
                                            if($b['status'] == 'Confirmed') $badgeColor = 'bg-green-100 text-green-700 border border-green-200';
                                            if($b['status'] == 'Pending') $badgeColor = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                            if($b['status'] == 'Cancelled') $badgeColor = 'bg-red-100 text-red-700 border border-red-200';
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $badgeColor; ?>">
                                            <?= $b['status']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($b['status'] == 'Pending'): ?>
                                            <div class="flex space-x-2">
                                                <a href="proses.php?aksi=konfirmasi&id=<?= $b['id']; ?>" onclick="return confirm('Terima booking ini?')" class="text-green-600 hover:text-white border border-green-600 hover:bg-green-600 font-medium rounded px-2 py-1 text-xs transition">TERIMA</a>
                                                <a href="proses.php?aksi=tolak&id=<?= $b['id']; ?>" onclick="return confirm('Tolak booking ini?')" class="text-red-600 hover:text-white border border-red-600 hover:bg-red-600 font-medium rounded px-2 py-1 text-xs transition">TOLAK</a>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs italic flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                                Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Tidak ada data booking saat ini.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Sembunyikan semua konten tab
            document.getElementById('content-trips').classList.add('hidden');
            document.getElementById('content-bookings').classList.add('hidden');
            
            // Reset style tombol tab (jadi abu-abu)
            document.getElementById('tab-trips').className = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors";
            document.getElementById('tab-bookings').className = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors";

            // Tampilkan konten yang dipilih & aktifkan tombolnya (jadi biru)
            document.getElementById('content-' + tabName).classList.remove('hidden');
            document.getElementById('tab-' + tabName).className = "border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors";
        }
    </script>
</body>
</html>