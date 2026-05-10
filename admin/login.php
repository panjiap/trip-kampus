<?php
session_start();
include '../config/koneksi.php';
if(isset($_POST['login'])) {
    $user = $_POST['user']; $pass = $_POST['pass'];
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    if(mysqli_num_rows($cek) > 0){
        $data = mysqli_fetch_assoc($cek);
        if($pass == 'admin123'){
            $_SESSION['login'] = true;
            $_SESSION['nama'] = $data['nama_lengkap'];
            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f0f2f5; height:100vh; display:flex; align-items:center; justify-content:center;}</style>
</head>
<body>
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center mb-4">Admin Login</h3>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>Username/Password salah!</div>"; ?>
        <form method="POST">
            <div class="mb-3"><label>Username</label><input type="text" name="user" class="form-control" required></div>
            <div class="mb-3"><label>Password</label><input type="password" name="pass" class="form-control" required></div>
            <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
        </form>
        <div class="text-center mt-3"><a href="../index.php">Kembali ke Web</a></div>
    </div>
</body>
</html>