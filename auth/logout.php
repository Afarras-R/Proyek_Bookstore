<?php

session_start(); // Memulai sesi
session_unset(); // Menghapus semua data sesi
session_destroy(); // Menghancurkan sesi sepenuhnya
header('Location: login.php'); // Arahkan pengguna ke halaman login
exit(); // Menghentikan eksekusi script

?>