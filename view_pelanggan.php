<?php
include 'koneksi.php';

//delete
$id = $_GET['id'];
if(isset($id)){
    $row = mysqli_fetch_array(mysqli_query($conn, "select * from pengguna where id_pengguna = '$id'"));
    $delete = "delete from pengguna where id_pengguna = '$id'";
    mysqli_query($conn,  $delete);
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
</head>
<body>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "select * from pengguna";
        $query = mysqli_query($conn, $sql);
        $no = 1;
        while($row = mysqli_fetch_array($query)){
            echo "
            <tr>
                <td>$no</td>
                <td>$row[username]</td>
                <td>$row[email]</td>
                <td>$row[password]</td>
                <td>$row[alamat]</td>
                <td>$row[no_hp]</td>
                <td>
                    <a href='update_pelanggan.php?id=$row[id_pengguna]'>Edit</a>
                    <a href='?id=$row[id_pengguna]'>Hapus</a>
                </td>
            </tr>
            ";
            $no++;
        }
        ?>
    </table>
    <input type="button" value="Tambah Data" onclick="document.location='create.php'">
</body>
</html>
