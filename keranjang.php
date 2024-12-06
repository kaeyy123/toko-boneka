<?php 
session_start();

// Initialize cart if not set
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

$koneksi = mysqli_connect("localhost", "root", "", "db_toko");

// Add item to cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $jumlah = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 1;

    // Get product details
    $query = "SELECT * FROM produk WHERE id='$id'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $produk = mysqli_fetch_assoc($result);

        // Add to cart
        $_SESSION['keranjang'][$id] = array(
            'nama' => $produk['nama'],
            'foto' => $produk['foto'],
            'harga' => $produk['harga'],
            'jumlah' => $jumlah
        );
    }
}

// Handle item deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Remove item from cart
    if (isset($_SESSION['keranjang'][$id])) {
        unset($_SESSION['keranjang'][$id]);
    }
}

// Display cart items
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #000; /* Hitam untuk teks */
        }
        .container {
            margin-top: 20px;
            background-color: #f8d7da; /* Light pink background for the container */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            margin-bottom: 20px;
            width: 100%;
            border-collapse: collapse; /* Ensures borders are combined */
        }
        thead {
            background-color: #f5c6cb; /* Slightly darker pink for table headers */
            color: #721c24; /* Darker text color for contrast */
        }
        tbody tr:nth-child(even) {
            background-color: #fce4e4; /* Very light pink for even rows */
        }
        tbody tr:nth-child(odd) {
            background-color: #f8d7da; /* Light pink for odd rows */
        }
        th, td {
            text-align: center;
            vertical-align: middle;
            padding: 1rem;
            border: 1px solid #dee2e6; /* Light border color for table cells */
        }
        th {
            font-weight: bold;
        }
        .btn {
            border-radius: 4px;
            color: #000; /* Hitam untuk teks di dalam tombol */
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff; /* Putih untuk teks di dalam tombol primari */
        }
        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
        .table img {
            max-width: 100px;
            height: auto;
        }
        .text-end {
            text-align: end;
        }
        .navbar, .navbar-brand, .nav-link {
            color: #000; /* Hitam untuk teks di dalam navbar */
        }
        .navbar-brand img {
            filter: invert(0%) sepia(100%) saturate(1000%) hue-rotate(0deg) brightness(100%) contrast(100%);
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
                    <?php if (isset($_SESSION['admin']) || isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login1.php">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="mb-4">Your Cart</h1>

        <?php if (empty($_SESSION['keranjang'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <form method="post" action="co.php">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['keranjang'] as $id => $item):
                            $subtotal = $item['harga'] * $item['jumlah'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><img src="img/<?= htmlspecialchars($item['foto']) ?>" alt="<?= htmlspecialchars($item['nama']) ?>"></td>
                                <td><?= htmlspecialchars($item['nama']) ?></td>
                                <td>Rp. <?= number_format($item['harga']) ?></td>
                                <td><?= $item['jumlah'] ?></td>
                                <td>Rp. <?= number_format($subtotal) ?></td>
                                <td>
                                    <a href="keranjang.php?action=delete&id=<?= $id ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total</strong></td>
                            <td><strong>Rp. <?= number_format($total) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <input type="hidden" name="total" value="<?= $total ?>">
                <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                    <input type="hidden" name="keranjang[<?= $id ?>][nama]" value="<?= htmlspecialchars($item['nama']) ?>">
                    <input type="hidden" name="keranjang[<?= $id ?>][foto]" value="<?= htmlspecialchars($item['foto']) ?>">
                    <input type="hidden" name="keranjang[<?= $id ?>][harga]" value="<?= htmlspecialchars($item['harga']) ?>">
                    <input type="hidden" name="keranjang[<?= $id ?>][jumlah]" value="<?= htmlspecialchars($item['jumlah']) ?>">
                <?php endforeach; ?>
                <div class="d-flex justify-content-between mt-4">
                    <a href="web.php" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Continue Shopping
                    </a>
                    <a href="co.php" class="btn btn-primary">
                        Checkout <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
