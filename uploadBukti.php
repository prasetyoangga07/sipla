<?php
include 'koneksi.php';
$id=$_GET['id'];
$row = mysqli_fetch_array(mysqli_query($conn, "select * from transaksi where id_hp='$id'"));
if ($row['kode_pembayaran']==""){
    ?>
    <script>alert("Menunggu kode pembayaran dari admin. Silahkan refresh halaman")</script> <?php
}
if (isset($_POST['submit'])){
    $bukti = $_FILES['buktiPembayaran']['name'];
    $path = 'images/'.$bukti;
    move_uploaded_file($_FILES['buktiPembayaran']['tmp_name'], $path);
    if(mysqli_query($conn, "update transaksi set bukti_pembayaran='$path' where id_hp='$id'")){
        mysqli_query($conn, "update handphone set id_status='5' where id_hp='$id'");
        header("location: handphone_pelanggan.php");
        ?> <script>alert("Upload bukti berhasil. Menunggu konfirmasi admin.")</script> <?php
    }
}
?>
<p>Kode pembayaran: <?php echo "$row[kode_pembayaran]" ?></p>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="buktiPembayaran" required>
    <input type="submit" value="Upload" name="submit">
</form>
