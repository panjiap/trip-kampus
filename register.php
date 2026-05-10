<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['daftar'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi Password

    // Cek email duplikat
    $cek = mysqli_query($conn, "SELECT * FROM members WHERE email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $query = "INSERT INTO members (nama_lengkap, email, password, no_hp) VALUES ('$nama', '$email', '$pass', '$hp')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            $error = "Gagal mendaftar.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun - TripKampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter] flex h-screen items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-600 font-[Poppins]">TripKampus</h1>
            <h2 class="text-xl font-semibold text-gray-800 mt-2">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500">Bergabunglah dan mulai petualanganmu!</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required placeholder="Contoh: Krisna Saputra">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required placeholder="nama@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                    <input type="number" name="hp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required placeholder="0812...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" name="daftar" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg mt-6 hover:bg-blue-700 transition shadow-md">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun? <a href="login.php" class="text-blue-600 font-semibold hover:underline">Masuk disini</a>
        </p>
    </div>

</body>
</html>