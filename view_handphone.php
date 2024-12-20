<?php
include 'koneksi.php';

//delete
$id = $_GET['id'];
if(isset($id)){
    $row = mysqli_fetch_array(mysqli_query($conn, "select * from handphone where id_hp = '$id'"));
    $delete = "DELETE from handphone where id_hp = '$id'";
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
            <th>Merek</th>
            <th>Tipe</th>
            <th>ID Pelanggan</th>
            <th>Pemilik</th>
            <th>Aksi</th>
        </tr>
        <?php
        //view join
        $sql = "select handphone.id_hp as id, handphone.merek, handphone.tipe, handphone.id_pengguna, pengguna.username as 'pemilik' from handphone inner join pengguna on handphone.id_pengguna = pengguna.id_pengguna";
        $query = mysqli_query($conn, $sql);

        $no = 1;
        while($row = mysqli_fetch_array($query)){
            echo "
            <tr>
                <td>$no</td>
                <td>$row[merek]</td>
                <td>$row[tipe]</td>
                <td>$row[id_pengguna]</td>
                <td>$row[pemilik]</td>
                <td>
                    <a href='update_handphone.php?id=$row[id]'>Edit</a>
                    <a href='?id=$row[id]'>Hapus</a>
                </td>
            </tr>
            ";
            $no++;
        }
        ?>
    </table>
    <input type="button" value="Tambah Data" onclick="document.location='insert_handphone.php'">
</body>
</html>
