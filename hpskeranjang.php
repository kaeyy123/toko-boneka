<?php
session_start();
$id = $_GET["id"];

// Hapus item dari keranjang berdasarkan ID
unset($_SESSION['keranjang'][$id]);

// Tampilkan pesan alert
echo "<script>alert('Produk berhasil dihapus dari keranjang');</script>";

// Redirect ke halaman keranjang
echo "<script>window.location='keranjang.php';</script>";



?>