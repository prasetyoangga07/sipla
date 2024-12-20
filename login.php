<?php
include ('koneksi.php');
session_start();
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM pengguna WHERE email = '$email' and password = '$password' ";
    $result = mysqli_query($GLOBALS['conn'], $query);
    if(mysqli_num_rows($result) != 0){
        $row = mysqli_fetch_array($result);
        if($row['email'] == $email && $row['password'] == $password){
            $_SESSION['login'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['id_pengguna'] = $row['id_pengguna']; // Store id_pengguna in session
            header("Location: user.php");
        }
    } else {
        echo "
        <script>
        alert('Akun Tidak Ditemukan');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
 
    <link rel="shortcut icon" href="assets/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/assets/images/logo/favicon.png" type="image/png">
    <link rel="stylesheet" href="assets/assets/css/main/app-dark.css">
    <link rel="stylesheet" href="assets/assets/css/shared/iconly.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <h1 class="card-title text-center">L O G I N</h1>
            </div>
            <div class="card-text">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-light" name="login">L O G I N</button>
                    </div>
                </form>
                <br>
                <a  href="register.php"><p align="center">Belum memiliki akun?</p></a>
            </div>
        </div>
    </div>
</body>
</html>