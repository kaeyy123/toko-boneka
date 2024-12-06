<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db_toko");

// Cek koneksi
if ($koneksi === false) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data pengguna dari sesi
$id_user = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;
$nama = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : '';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
$hp = isset($_SESSION['hp']) ? htmlspecialchars($_SESSION['hp']) : '';
$password = ''; // Default empty password

// Ambil data dari database jika ID pengguna ada
if ($id_user) {
    $query = "SELECT nama, password, email, hp FROM tb_user WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($db_nama, $db_password, $db_email, $db_hp);
    $stmt->fetch();
    $stmt->close();

    // Update session data
    $nama = $db_nama;
    $password = $db_password;
    $email = $db_email;
    $hp = $db_hp;
}

// Update data pengguna jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_nama = htmlspecialchars($_POST['nama']);
    $new_email = htmlspecialchars($_POST['email']);
    $new_hp = htmlspecialchars($_POST['hp']);
    $new_password = htmlspecialchars($_POST['password']); // Update password

    // Validasi input
    if (empty($new_nama) || empty($new_email) || empty($new_hp)) {
        $error = "All fields are required!";
    } else {
        // Update data di database
        $query = "UPDATE tb_user SET nama = ?, email = ?, hp = ?, password = ? WHERE id = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ssssi", $new_nama, $new_email, $new_hp, $new_password, $id_user);

        if ($stmt->execute()) {
            // Update data di sesi
            $_SESSION['nama'] = $new_nama;
            $_SESSION['email'] = $new_email;
            $_SESSION['hp'] = $new_hp;
            header("Location: profil.php?success=1");
            exit();
        }
         else {
            $error = "Failed to update profile!";
        }
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

        .h2 {
            background-color: #dee2e6;
        }
        .form-container {
            margin-top: 40px;
            border-radius: 15px;
            overflow: hidden;
            background: #f8d7da;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container .card-header {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .form-container .card-body {
            padding: 30px;
        }
        .form-container .form-control {
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
        .btn-outline-dark {
            border-color: #343a40;
            color: #343a40;
        }
        .btn-outline-dark:hover {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand text-white" href="#!">LA THE DOLL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active text-white" aria-current="page" href="web.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="keranjang.php">Cart</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="form-container mx-auto" style="max-width: 600px;">
        <div class="card-header">
            <h2>Edit Profile</h2>
        </div>
        <div class="card-body">
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($password); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number:</label>
                    <input type="text" class="form-control" name="hp" value="<?php echo htmlspecialchars($hp); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="profil.php" class="btn btn-primary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
