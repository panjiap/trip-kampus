<?php 
session_start();      // Mulai/Lanjutkan sesi yang ada
session_destroy();    // Hancurkan sesi (data login hilang)
header("Location: login.php"); // Tendang user kembali ke halaman login
exit;                 // Pastikan script berhenti di sini
?>