<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db_toko");

// Cek koneksi
if ($koneksi === false) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil ID pengguna dari sesi
$id_user = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

// Ambil data pengguna dari database
if ($id_user) {
    $query = "SELECT nama, password, email, hp FROM tb_user WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($nama, $password, $email, $hp);
    $stmt->fetch();
    $stmt->close();
} else {
    $nama = 'Customer not available';
    $password = 'Password not available';
    $email = 'Email not available';
    $hp = 'Phone not available';
}
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Profil berhasil diubah!');</script>";
}
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #white;
            font-family: Arial, sans-serif;
        }
        .navbar {
            border-bottom: 2px solid #eaeaea;
        }
        .profile-card {
            margin-top: 40px;
            border-radius: 15px;
            overflow: hidden;
            background: #f8d7da;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-card .card-header {
            background-color: #b3e5fc;
            color: #black;
            text-align: center;
            padding: 20px;
        }
        .profile-card .card-body {
            padding: 30px;
        }
        .profile-card .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid #343a40;
        }
        .profile-card .form-control-plaintext {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 10px;
        }
        .btn-primary {
            background-color: #C6A4C6;
            border: none;
            color: #000000; /* Teks hitam */
        }
        .btn-primary:hover {
            background-color: #C6A4C6;
        }
        .btn-danger {
            background-color: #f8d7da;
            border: none;
            color: #000000; /* Teks hitam */
        }
        .btn-danger:hover {
            background-color: #d36c6c;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-pink bg-pink">
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
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="profile-card mx-auto" style="max-width: 600px;">
        <div class="card-header">
            <h2>User Profile</h2>
        </div>
        <div class="card-body text-center">
            <img src="img/logoo.jpg" alt="User Avatar" class="avatar">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" class="form-control-plaintext" readonly value="<?php echo htmlspecialchars($nama); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="text" class="form-control-plaintext" readonly value="<?php echo htmlspecialchars($password); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="text" class="form-control-plaintext" readonly value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number:</label>
                <input type="text" class="form-control-plaintext" readonly value="<?php echo htmlspecialchars($hp); ?>">
            </div>
            <a href="edit.php" class="btn btn-primary">Edit Profile</a>
            <a href="login1.php" class="btn btn-danger" onclick="return confirm('are you sure you want to logout?');">Logout</a>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
