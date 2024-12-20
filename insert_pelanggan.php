<?php
include 'koneksi.php';

if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $sql = "insert into pengguna(username, email, password, alamat, no_hp) values ('$username', '$email', '$password', '$alamat', '$no_hp')";
    $query = mysqli_query($conn, $sql);
    if ($query){
        header('location: view_pelanggan.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        form{
            display: table;
        }
        label{
            display: table-cell;
        }
        input{
            display: table-cell;
        }
    </style>
</head>
<body>
<div>
    <form action="" method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat">
        </div>
        <div>
            <label for="no_hp">No Telepon</label>
            <input type="number" name="no_hp" id="no_hp">
        </div>
        <div>
            <input type="submit" value="Tambah" name="tambah">
            <input type="button" value="Batal" name="batal" onclick="history.back()">
        </div>
    </form>
</div>
</body>
</html>
