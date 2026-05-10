<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM members WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        if (password_verify($password, $data['password'])) {
            // Set Session Member
            $_SESSION['user_login'] = true;
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['user_nama'] = $data['nama_lengkap'];
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Masuk - TripKampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter] flex h-screen items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-600 font-[Poppins]">TripKampus</h1>
            <h2 class="text-xl font-semibold text-gray-800 mt-2">Selamat Datang Kembali!</h2>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required placeholder="nama@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg mt-6 hover:bg-blue-700 transition shadow-md">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Belum punya akun? <a href="register.php" class="text-blue-600 font-semibold hover:underline">Daftar sekarang</a>
        </p>
        
        <div class="text-center mt-4 pt-4 border-t border-gray-100">
            <a href="admin/login.php" class="text-xs text-gray-400 hover:text-gray-600">Login sebagai Admin</a>
        </div>
    </div>

</body>
</html>