<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_toko");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    $query = "SELECT * FROM tb_user WHERE username='$username' AND password='$password'";
    $login = mysqli_query($koneksi, $query);
    
    if ($login) {
        $data = mysqli_fetch_assoc($login);
        
        if ($data['role'] == "admin") {
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } elseif ($data['role'] == "customer") {
            $_SESSION['user'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['id'] = $data['id'];
            header("Location: web.php");
            exit();
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Login</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles here */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8d7da;
        }

        .form-signin {
            background-color: #f8d7da; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #d36c6c;
            border: none;
            color: #000000; /* Teks hitam */
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="login.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <!-- SVG symbols here -->
    </svg>
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <!-- Theme toggle button here -->
    </div>
    <main class="form-signin w-100 m-auto">
        <form method="post">
            <h1 class="h3 mb-3 fw-normal">Please come in</h1>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                Incorrect username or password!
                </div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" required>
                <label for="floatingPassword">Password</label>
            </div>
            
            <div class="form-floating">
                <li class="list-inline-item">Don't have an account yet? Please <a href="register.php">Regis</a></li>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit" name="login">Sign in</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; LA THE DOLL</p>
        </form>
    </main>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
