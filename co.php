<?php
session_start();

// Cek apakah $_SESSION['keranjang'] sudah didefinisikan
if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array(); // Inisialisasi dengan array kosong jika belum ada
}

$koneksi = new mysqli("localhost", "root", "", "db_toko");

// Check for connection errors
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Keranjang Belanja</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .container {
            background-color: #f5c6cb; /* Pastel pink */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: #343a40;
            color: #ffffff;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .table td, .table th {
            vertical-align: middle;
            padding: 12px;
        }

        .table img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #ffffff;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
        }

        .badge {
            border-radius: 50%;
        }

        .konten {
            padding-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">LA THE DOLL</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="web.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">Cart</a>
                    </li>
                    <?php if (isset($_SESSION['admin']) || isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login1.php">Logout</a>
                    </li>
                    <?php else: ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="konten py-5">
        <div class="container">
            <h1 class="mb-4">Checkout</h1>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1; 
                    $totalBelanja = 0; 

                    if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])): 
                        foreach ($_SESSION['keranjang'] as $id => $produk) {
                            $jumlah = isset($produk['jumlah']) && is_numeric($produk['jumlah']) ? (int)$produk['jumlah'] : 0;
                            $harga = isset($produk['harga']) && is_numeric($produk['harga']) ? (float)$produk['harga'] : 0;
                            $nama = isset($produk['nama']) ? $produk['nama'] : '';
                            $foto = isset($produk['foto']) ? $produk['foto'] : '';

                            $subHarga = $harga * $jumlah;
                            $totalBelanja += $subHarga;
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="img/<?php echo htmlspecialchars($foto); ?>" alt="">
                                    <span><?php echo htmlspecialchars($nama); ?></span>
                                </div>
                            </td>
                            <td>Rp. <?php echo number_format($harga, 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($jumlah); ?></td>
                            <td>Rp. <?php echo number_format($subHarga, 0, ',', '.'); ?></td>
                        </tr>
                        <?php 
                        }
                    else: 
                    ?>
                    <tr>
                        <td colspan="5">Empty basket</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4">Total Spending</th>
                        <th>Rp. <?php echo number_format($totalBelanja, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="web.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left"></i> Continue Shopping
                </a>
                <a href="cetak.php" class="btn btn-primary">
                    BUY <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
