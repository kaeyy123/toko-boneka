<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #f8bbd0; /* Pastel pink */
        }
        .navbar-brand, .nav-link {
            color: #d81b60; /* Darker pink for text */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #c2185b; /* Slightly darker pink for hover effect */
        }
        .btn-custom {
            background-color: #d81b60; /* Darker pink for buttons */
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #c2185b; /* Slightly darker pink for hover */
            color: #fff;
        }
        .container {
            background-color: #fce4ec; /* Pastel pink background for the container */
            border-radius: 8px;
            padding: 20px;
        }
        .product-description {
            font-size: 1.1rem;
            color: #333;
        }
        .card {
            border: 1px solid #f8bbd0; /* Border color matching the navbar */
            border-radius: 8px;
        }
        .card-body {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
<header data-bs-theme="dark">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LA THE DOLL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="web.php">Home</a>
                    </li>
                </ul>
            </div>
            <div class="actions">
                <a href="keranjang.php"><img src="img/cart-solid-24.png" width="40" height="32" class="me-2" role="img" aria-label="Cart icon"></a>
                <a href="profil.php"><img src="img/pro.png" width="40" height="32" class="me-2" role="img" aria-label="Profile icon"></a>
            </div>
        </div>
    </nav>
</header>

<div class="container py-5 mt-5">
    <div class="row">
        <?php
        session_start();
        $koneksi = mysqli_connect("localhost", "root", "", "db_toko");

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = mysqli_real_escape_string($koneksi, $_GET['id']);
            $query = "SELECT * FROM produk WHERE id='$id'";
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($produk = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-5 mb-4">
                        <img class="product-image img-fluid" src="img/<?= htmlspecialchars($produk['foto']) ?>" alt="<?= htmlspecialchars($produk['nama']) ?>">
                    </div>
                    <div class="col-md-7">
                        <h1 class="mb-3"><?= htmlspecialchars($produk['nama']) ?></h1>
                        <p class="product-description"><?= htmlspecialchars($produk['deskripsi']) ?></p>
                        <h2 class="text-primary mt-3 mb-4">Rp. <?= number_format($produk['harga']) ?></h2>
                        <form method="post" action="keranjang.php?action=add">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($produk['id']) ?>">
                            <div class="input-group mb-3" style="max-width: 200px;">
                                <input type="number" min="1" value="1" class="form-control" name="jumlah">
                            </div>
                            <button type="submit" class="btn btn-custom">ADD TO CART</button>
                        </form>
                    </div>
                    <?php
                }
            }
        }
        mysqli_close($koneksi);
        ?>
    </div>
</div>

<div class="container-fluid py-5 bg-light text-center mb-5">
    <div class="container">
        <h2 class="text-center text-black mb-5">Related products</h2>
    </div>
</div>

<div class="container px-4 px-lg-5 mt-5 related-products">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php
        $koneksi = mysqli_connect("localhost", "root", "", "db_toko");
        $query = "SELECT * FROM produk";
        $result = mysqli_query($koneksi, $query);
        while ($produk = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <img class="card-img-top" src="img/<?= htmlspecialchars($produk['foto']) ?>" />
                    <div class="card-body p-4">
                        <p class="text-center"><b><?= htmlspecialchars($produk['nama']) ?></b></p>
                        <p><?= htmlspecialchars($produk['deskripsi']) ?></p>
                        <p><b>Rp. <?= number_format($produk['harga']) ?></b></p>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="detail.php?id=<?= $produk['id'] ?>">DETAILS</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        mysqli_close($koneksi);
        ?>
    </div>
</div>
</body>
</html>
