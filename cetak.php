<?php
session_start();

// Retrieve the name from the session if available, or default to 'Suwendo'
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Suwendo';

// Current purchase date
$tanggal = date('Y-m-d');

// Automatic invoice number
$id_transaksi = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

// Database connection
$koneksi = new mysqli("localhost", "root", "", "db_toko");

// Check connection
if ($koneksi->connect_error) {
    die("Database connection failed: " . $koneksi->connect_error);
}

// Check if cart exists and is not empty
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    die("Cart is empty or session does not exist.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Receipt</title>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
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
            margin-top: 20px;
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
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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
                    <?php if (isset($_SESSION['admin']) || isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login1.php">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Purchase Receipt</h1>
        <div class="mb-4">
            <p><strong>Invoice Number:</strong> <?php echo htmlspecialchars($id_transaksi, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Buyer's Name:</strong> <?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Purchase Date:</strong> <?php echo htmlspecialchars($tanggal, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $totalBelanja = 0;

                    foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                        $jumlah = (int) $jumlah;

                        if ($jumlah <= 0) {
                            continue; // Skip item if quantity is not valid
                        }

                        // Fetch product data based on ID
                        $stmt = $koneksi->prepare("SELECT nama, harga FROM produk WHERE id = ?");
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $pecah = $result->fetch_assoc();

                        if ($pecah) {
                            $harga = $pecah['harga'];
                            $subHarga = $harga * $jumlah;
                            $totalBelanja += $subHarga;
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($pecah['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>Rp. <?php echo number_format($pecah['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($jumlah); ?></td>
                        <td>Rp. <?php echo number_format($subHarga, 0, ',', '.'); ?></td>
                    </tr>
                    <?php 
                        }
                        $stmt->close();
                    }
                    ?>
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
            <button onclick="window.print();" class="btn btn-primary btn-print">Print</button>
            <a href="web.php" class="btn btn-secondary btn-print">Return to Homepage</a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
