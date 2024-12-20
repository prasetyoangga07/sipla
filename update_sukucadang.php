<?php
include 'koneksi.php';

$id = $_GET['id'];
if(isset($_POST['edit'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "update suku_cadang set nama='$nama', harga='$harga', stok='$stok' where id_sukucadang='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query){
        header('location: sukucadang.php');
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
    $row = mysqli_fetch_array(mysqli_query($conn, "select * from suku_cadang where id_sukucadang='$id'"));
    if(isset($row['id_sukucadang'])){
        ?>
        <form action="" method="post">
        <div>
            <label for="nama">nama</label>
            <input type="text" name="nama" id="nama" value="<?php echo $row['nama'] ?>">
        </div>
        <div>
            <label for="harga">harga</label>
            <input type="number" name="harga" id="harga" value="<?php echo $row['harga'] ?>">
        </div>
        <div>
            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" value="<?php echo $row['stok'] ?>">
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
