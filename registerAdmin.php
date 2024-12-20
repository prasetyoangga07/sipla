<?php
include ('koneksi.php');
session_start();
if(isset($_POST['registerAdmin'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $confirm = $_POST['confirm'];
    // $alamat = $_POST['$alamat'];
    // $no_hp = $_POST['no_hp'];
    if($password != $confirm){
        echo"
        <script>
            alert('password tidak sesuai');
        </script>";
    }else{
        $query = "INSERT INTO admin(username, email, password, alamat, no_hp) VALUES ('$username', '$email', '$password', '$alamat', '$no_hp')";
        mysqli_query($GLOBALS['conn'], $query);
        echo "
        <script>
        alert('akun berhasil dibuat');
        </script>";
        header("Location: loginAdmin.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="global-container">
        <div class="card register-form">
            <div class="card-body">
                <h1 class="card-title text-center">R E G I S T E R</h1>
            </div>
            <div class="card-text">
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm" name="confirm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telephone</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-light" name="register">R E G I S T E R</button>
                    </div>
                </form>
                <br>
                <a href="loginAdmin.php"><p align="center">Sudah memiliki akun?</p></a>
            </div>
        </div>
    </div>
</body>
</html>