<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_toko");


// Memeriksa koneksi database
if ($koneksi->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Menyiapkan query untuk menghapus data
    $stmt = $koneksi->prepare("DELETE FROM produk WHERE id = ?");
    
    if ($stmt) {
        // Mengikat parameter dan mengeksekusi query
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Redirect ke halaman dashboard atau halaman lain setelah penghapusan berhasil
            header("Location: dashboard.php?message=Data berhasil dihapus");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Menutup pernyataan
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

// Menutup koneksi
$conn->close();
?>