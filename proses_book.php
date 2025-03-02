<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// Memulai sesi PHP
session_start();

// Mendapatkan ID pengguna dari sesi
$userID = $_SESSION["user_id"];

// Menangani form untuk menambahkan postingan baru
if (isset($_POST['simpan'])) {
    // Mendapatkan data dari form
    $postTitle = $_POST["post_title"]; // Judul postingan
    $content = $_POST["content"]; // Konten postingan
    $categoryId = $_POST["category_id"]; // ID kategori

    // Mengatur direktori penyimpanan file gambar
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"]; // Nama file gambar
    $imagePath = $imageDir . basename($imageName); // Path lengkap gambar

    // Memindahkan file gambar yang diunggah ke direktori tujuan
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        // Jika unggahan berhasil, masukkan data postingan ke dalam database
        $query = "INSERT INTO posts (post_title, content, created_at, category_id, user_id, image_path) VALUES
        ('$postTitle', '$content' NOW(), $categoryId, $userID, '$imagePath')";

        if ($conn->query($query) === TRUE) {
            // Notifikasi berhasil jika postingan berhasil ditambahkan
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Post succesfully added.'
            ];
        } else {
            // Notifikasi error jika gagal menambahkan postingan
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error adding post: ' . $conn->error
            ];
        }
    } else {
        // Notifikasi error jika unggahan gambar gagal
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }

    // Arahkan ke halaman dashboard setelah selesai
    header('Location: dashboard.php');
    exit();
} 

// Proses penghapusan postingan
if (isset($_POST['delete'])) {
    // Mendapatkan ID post dari parameter URL
    $postID = $_POST['postID'];

    // Query untuk menghapus post berdasarkan ID
    $exec = mysqli_query($conn, "DELETE FROM posts WHERE id_post='$postID'");

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Post succesfully deleted.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Error deleting post: ' . mysqli_error($conn)
        ];
    }
    // Redirect kembali ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}

// Menangani pembaruan data postingan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Mendapatkan data dari form
    $postId = $_POST['post_id'];
    $postTitle = $_POST['post_title'];
    $content = $_POST['content'];
    $categoryId = $_POST['category_id'];
    $imageDir = "assets/img/uploads/"; // Direktori penyimpanan gambar

    
}

?>