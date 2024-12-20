<?php
include 'koneksi.php';
$id = $_GET['id']; //id_hp
//checkout
if(isset($_POST['submit'])){
    mysqli_query($conn, "insert into transaksi(id_hp, kode_pembayaran, bukti_pembayaran) values ('$id', '', '')");
    header("location: uploadBukti.php?id=$id");
}

$row = mysqli_fetch_array(mysqli_query($conn, "select rincian_perbaikan.*, handphone.* from rincian_perbaikan inner join handphone on rincian_perbaikan.id_hp=handphone.id_hp where handphone.id_hp='$id'"));
echo "
    Nama handphone: $row[merek] $row[tipe] <br>
    Detail kerusakan: $row[detail_perbaikan] <br>
    Total biaya: $row[total_biaya] <br>
    Metode pembayaran <br>
    <select name='paymentMethod'>
        <option value='0'>Cash</option>
        <option value='1'>Opsi2</option>
        <option value='2'>Opsi3</option>
    </select>
    ";
?>
<br>
<form action="" method="post">
    <input type="submit" name="submit" value="Checkout">
</form>
