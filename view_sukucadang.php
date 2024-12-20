<?php
include 'koneksi.php';

//delete

if(isset($id)){
    $id = $_GET['id'];
    $row = mysqli_fetch_array(mysqli_query($conn, "select * from suku_cadang where id_sukucadang = '$id'"));
    $delete = "delete from suku_cadang where id_sukucadang = '$id'";
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
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php
        //view
        $sql = "select * from suku_cadang";
        $query = mysqli_query($conn, $sql);

        $no = 1;
        while($row = mysqli_fetch_array($query)){
            echo "
            <tr>
                <td>$no</td>
                <td>$row[nama]</td>
                <td>$row[harga]</td>
                <td>$row[stok]</td>
                <td>
                    <a href='update_sukucadang.php?id=$row[id_sukucadang]'>Edit</a>
                    <a href='?id=$row[id_sukucadang]'>Hapus</a>
                </td>
            </tr>
            ";
            $no++;
        }
        ?>
    </table>
    <input type="button" value="Tambah Data" onclick="document.location='insert_sukucadang.php'">
</body>
</html>
