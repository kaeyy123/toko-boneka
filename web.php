<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LA Kuliner - Menyajikan kuliner terbaik dari berbagai daerah.">
    <meta name="author" content="LA Kuliner Team">
    <title>LaTheDoll.com</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="carousel.css" rel="stylesheet">
    <style>
        /* Custom styles here */
        .navbar {
            background-color: #f8c6d9; /* Pastel pink color */
        }

        .carousel-item img {
            max-height: 500px; /* Adjust this value as needed */
            object-fit: cover; /* Ensure images cover the area without distortion */
            width: 100%; /* Ensure the image takes up the full width of the container */
        }

        .card-img-top {
            max-height: 200px; /* Adjust this value as needed */
            object-fit: cover; /* Ensure images cover the area without distortion */
            width: 100%; /* Ensure the image takes up the full width of the container */
        }

        .featurette-image {
            max-height: 400px; /* Adjust this value as needed */
            object-fit: cover; /* Ensure images cover the area without distortion */
            width: 100%; /* Ensure the image takes up the full width of the container */
        }

        .product-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem; /* Adjust gap between cards as needed */
        }

        .product-col {
            flex: 1 1 calc(25% - 1rem); /* 4 products per row */
            max-width: calc(25% - 1rem); /* 4 products per row */
        }

        /* Adjust for smaller screens if necessary */
        @media (max-width: 768px) {
            .product-col {
                flex: 1 1 calc(50% - 1rem); /* 2 products per row on smaller screens */
                max-width: calc(50% - 1rem); /* 2 products per row on smaller screens */
            }
        }

        @media (max-width: 576px) {
            .product-col {
                flex: 1 1 100%; /* 1 product per row on extra small screens */
                max-width: 100%; /* 1 product per row on extra small screens */
            }
        }
    </style>
</head>
<body>
    <!-- Dropdown for theme toggle -->
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <!-- Ensure you have defined these SVG symbols or use alternatives -->
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
        </ul>
    </div>

    <!-- Header -->
    <header data-bs-theme="dark">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">LA THE DOLL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0"></ul>
                    <div class="actions">
                        <a href="keranjang.php"><img src="img/cart-solid-24.png" width="40" height="32" class="me-2" role="img" aria-label="Cart icon"></a>
                        <a href="profil.php"><img src="img/pro.png" width="40" height="32" class="me-2" role="img" aria-label="Profile icon"></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main content -->
    <main>
        <!-- Carousel -->
        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/toko.jfif" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="img/toko2.jfif" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="img/toko3.jfif" class="d-block w-100" alt="Slide 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Product cards -->
        <div class="container marketing">
            <div class="product-row">
                <?php
                $koneksi = mysqli_connect("localhost", "root", "", "db_toko");
                if (!$koneksi) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $tambah = mysqli_query($koneksi, "SELECT * from produk");
                while ($produk = mysqli_fetch_array($tambah)) {
                ?>
                    <div class="product-col">
                        <div class="card h-100">
                            <img class="card-img-top" src="img/<?= htmlspecialchars($produk['foto']) ?>" alt="<?= htmlspecialchars($produk['nama']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($produk['nama']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produk['deskripsi']) ?></p>
                                <p class="card-text"><strong>Price: <?= htmlspecialchars($produk['harga']) ?></strong></p>
                                <a href="detail.php?id=<?= htmlspecialchars($produk['id']) ?>" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                mysqli_close($koneksi);
                ?>
            </div>
        </div>
    </main>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@docsearch/js@3"></script>
    <script>
        (function () {
            'use strict'

            document.querySelector('#bd-theme').addEventListener('change', function (event) {
                document.body.setAttribute('data-bs-theme', event.target.value);
            })
        })()
    </script>
</body>
</html>
