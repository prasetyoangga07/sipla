<?php
include 'koneksi.php';
session_start();

if(!isset($_SESSION['login'])){
    header('location: login.php');
}

$id = $_GET['id']; //id_hp

//checkout
if(isset($_POST['submit'])){
    mysqli_query($conn, "INSERT INTO transaksi(id_hp, kode_pembayaran, bukti_pembayaran) VALUES ('$id', '', '')");
    header("location: uploadBukti.php?id=$id");
}

$query = "SELECT * FROM pengguna WHERE email = '$_SESSION[email]' AND password = '$_SESSION[password]'";
$row = mysqli_fetch_array(mysqli_query($GLOBALS['conn'], $query));

// Cek apakah query berhasil
$result = mysqli_query($conn, "SELECT rincian_perbaikan.*, handphone.* FROM rincian_perbaikan INNER JOIN handphone ON rincian_perbaikan.id_hp=handphone.id_hp WHERE handphone.id_hp='$id'");

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

$row2 = mysqli_fetch_array($result);

// Cek apakah $row2 memiliki data
if (!$row2) {
    die('Data tidak ditemukan untuk ID HP: ' . htmlspecialchars($id));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Dashboard</title>

    <link rel="stylesheet" href="assets/assets/css/main/app.css">
    <link rel="stylesheet" href="./assets/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="assets/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="assets/assets/css/shared/iconly.css">
</head>

<body>
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex p-2 border-bottom mb-2">
                            <img src="./images/user/user.png" alt="user" class="img-user me-2">
                            <div>
                                <p style="font-size:18px ;"><?php echo htmlspecialchars($row['username']); ?></p>
                                <p style="font-size: 14px;"> ID : <?php echo htmlspecialchars($row['id_pengguna']); ?> </p>
                            </div>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <!-- Theme toggle code -->
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li
                                class="sidebar-item active ">
                            <a href="user.php" class='sidebar-link'>
                                <i class="fa fa-home fa-lg box-icon"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li
                                class="sidebar-item  ">
                            <a href="profileuser.php" class='sidebar-link'>
                                <i class="fa fa-user fa-lg box-icon"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li
                                class="sidebar-item  ">
                            <a href="settingsuser.php" class='sidebar-link'>
                                <i class="fa fa-cog fa-lg box-icon"></i>
                                <span>Settings</span>
                            </a>

                        </li>

                        <li
                                class="sidebar-item  ">
                            <a href="logoutuser.php" class='sidebar-link'>
                                <i class="fa fa-sign-out fa-lg box-icon"></i>
                                <span>LogOut</span>
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>Data Handphone</h3>
            </div>
            <div class="page-content">
                <section id="multiple-column-form" >
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Masukan data Handphone</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" action="" method="POST">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="last-name-column">Nama Hp</label>
                                                        <input type="text"  class="form-control" value="<?php echo "$row2[merek] $row2[tipe]" ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Detail Perbaikan</label>
                                                        <input type="text"  class="form-control" value="<?php echo "$row2[detail_perbaikan]" ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Detail Perbaikan</label>
                                                        <input type="text"  class="form-control" value="<?php echo "$row2[total_biaya]" ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Metode</label>
                                                        <select name='paymentMethod'>
                                                            <option value='0'>Cash</option>
                                                            <option value='1'>Opsi2</option>
                                                            <option value='2'>Opsi3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <form action="" method="post">
                                                        <input class="btn btn-primary  me-1 mb-1" type="submit" name="submit" value="Checkout">
                                                    </form>
                                                    <!-- <button type="submit"  me-1 mb-1" name="tambah">Submit</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; Admin</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"></span> by <a
                                    href="https://saugi.me">Violet Cell</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/assets/js/bootstrap.js"></script>
    <script src="assets/assets/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/assets/js/pages/dashboard.js"></script>

</body>
</html>

