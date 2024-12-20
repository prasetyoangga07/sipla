<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "select id_status from handphone where id_hp ='$id'");
if($row = mysqli_fetch_array($query)==1){
    header("location: uploadBukti.php");
} else {
    header("location: handphone_pelanggan.php");
    ?> <script>alert("Handphone masih ")</script>
}