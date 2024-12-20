<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: ID Handphone tidak ditemukan.");
}

// Ambil data pengguna dari session
$id_pengguna = $_SESSION['id_pengguna'] ?? null;

if (!$id_pengguna) {
    die("Error: ID Pengguna tidak ditemukan. Pastikan Anda sudah login.");
}

// Checkout
if (isset($_POST['submit'])) {
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
    $metode = $_POST['paymentMethod'];

    // Upload bukti pembayaran
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($bukti_pembayaran);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (!move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file)) {
        die("Error: Gagal mengunggah bukti pembayaran.");
    }

    // Update transaksi
    $query_transaksi = "UPDATE transaksi SET bukti_pembayaran = ?, metode_pembayaran = ? WHERE id_hp = ? AND id_pengguna = ?";
    $stmt_transaksi = $conn->prepare($query_transaksi);

    if (!$stmt_transaksi) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt_transaksi->bind_param("ssii", $bukti_pembayaran, $metode, $id, $id_pengguna);

    if ($stmt_transaksi->execute()) {
        // Update id_status pada tabel handphone
        $query_update_status = "UPDATE handphone SET id_status = 3 WHERE id_hp = ?";
        $stmt_update_status = $conn->prepare($query_update_status);

        if (!$stmt_update_status) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt_update_status->bind_param("i", $id);

        if ($stmt_update_status->execute()) {
            header("location: handphone_pelanggan.php");
            exit();
        } else {
            die("Error updating handphone status: " . $stmt_update_status->error);
        }
    } else {
        die("Error updating transaksi: " . $stmt_transaksi->error);
    }
}

// Query untuk mendapatkan data pengguna
$query_pengguna = "SELECT * FROM pengguna WHERE id_pengguna = ?";
$stmt_pengguna = $conn->prepare($query_pengguna);

if (!$stmt_pengguna) {
    die("Error preparing statement: " . $conn->error);
}

$stmt_pengguna->bind_param("i", $id_pengguna);
$stmt_pengguna->execute();
$result_pengguna = $stmt_pengguna->get_result();

if ($result_pengguna->num_rows === 0) {
    die("Error: Pengguna tidak ditemukan.");
}

$row = $result_pengguna->fetch_assoc();

// Query untuk mendapatkan data handphone
$query_handphone = "SELECT handphone.*, transaksi.total_biaya FROM handphone LEFT JOIN transaksi ON handphone.id_hp = transaksi.id_hp WHERE handphone.id_hp = ?";
$stmt_handphone = $conn->prepare($query_handphone);

if (!$stmt_handphone) {
    die("Error preparing statement: " . $conn->error);
}

$stmt_handphone->bind_param("i", $id);
$stmt_handphone->execute();
$result_handphone = $stmt_handphone->get_result();

if ($result_handphone->num_rows === 0) {
    die("Error: Data handphone tidak ditemukan.");
}

$row2 = $result_handphone->fetch_assoc();
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
                                        <form class="form" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="last-name-column">Nama Hp</label>
                                                        <input type="text"  class="form-control" value="<?php echo "$row2[merek] $row2[tipe]" ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Detail Kerusakan</label>
                                                        <input type="text"  class="form-control" value="<?php echo "$row2[detail_kerusakan]" ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Total Biaya</label>
                                                        <input type="text"  class="form-control" value="<?php echo "$row2[total_biaya]" ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Metode Pembayaran</label>
                                                        <select name='paymentMethod' class="form-control">
                                                            <option value='Cash'>Cash</option>
                                                            <option value='Transfer'>Transfer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                                                        <input type="file" name="bukti_pembayaran" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-primary me-1 mb-1" type="submit" name="submit">Checkout</button>
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
