<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_toko");
if (isset($_POST['login'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];    
    $password = $_POST['password'];
    $hp = $_POST['hp'];

    if ($nama && $email && $username && $password) {
        $simpan = mysqli_query($koneksi, "INSERT INTO tb_user (nama, email, username, password, hp, role)
        VALUES('$nama', '$email', '$username', '$password', '$hp', 'customer')");
        if ($simpan) {
            header("Location: login1.php"); // Ganti dengan URL login Anda
            exit();
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="register.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        <img src="img/regisft.jfif" class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
        <rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></img>
        <div class="filter"></div>
        <div class="container">
            <h1>Enter</h1>
            <form method="POST" enctype="multipart/form-data">
                <div>
                    <label>Name</label><br>
                    <input type="text" name="nama" placeholder="Add Name" required /><br>
                </div>
                <div>
                    <label>Email</label><br>
                    <input type="text" name="email" placeholder="Add Email" required /><br>
                </div>
                <div>
                    <label>Username</label><br>
                    <input type="text" name="username" placeholder="Add Username" required /><br>
                </div>
                <div>
                    <label>Password</label><br>
                    <input type="password" name="password" placeholder="Add Password" required /><br>
                </div>
                <div>
                    <label>Phone Number</label><br>
                    <input type="text" name="hp" placeholder="Add phone number" required /><br>
                </div>
                <div>
                    <button class="btn-hover color-9" type="submit" name="login">Sign in</button>
                </div>
            </form>
        </div>
    </body>
</html>