<?php
include 'koneksi.php';

$id = $_GET['id'];
if(isset($_POST['edit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $sql = "update pengguna set username='$username', email='$email', password='$password', alamat='$alamat', no_hp='$no_hp' where id_pengguna='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query){
        header('location: pelanggan.php');
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
    <?php
    $row = mysqli_fetch_array(mysqli_query($conn, "select * from pengguna where id_pengguna='$id'"));
    if(isset($row['id_pengguna'])){
    ?>
    <form action="" method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $row['username'] ?>">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $row['email'] ?>">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php echo $row['password'] ?>">
        </div>
        <div>
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="<?php echo $row['alamat'] ?>">
        </div>
        <div>
            <label for="no_hp">No Telepon</label>
            <input type="number" name="no_hp" id="no_hp" value="<?php echo $row['no_hp'] ?>">
        </div>
        <div>
            <input type="submit" value="Edit" name="edit">
            <input type="button" value="Batal" name="batal" onclick="history.back()">
        </div>
    </form>
    <?php
    }
    ?>
</div>
</body>
</html>
