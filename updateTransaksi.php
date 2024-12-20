<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
    $id_hp = $_POST['id_hp']; // Get the handphone ID from the form
    $total_biaya = $_POST['total_biaya']; // Get the total biaya from the form
    $id_pengguna = $_POST['id_pengguna']; // Get the pengguna ID from the form

    // Generate a unique kode_pembayaran
    $kode_pembayaran = uniqid('PAY-', true);

    // Insert the kode_pembayaran, total_biaya, and id_pengguna into the transaksi table
    $sql_insert_transaksi = "INSERT INTO transaksi (id_hp, kode_pembayaran, total_biaya, id_pengguna) VALUES (?, ?, ?, ?)";
    $stmt_insert_transaksi = $conn->prepare($sql_insert_transaksi);

    if ($stmt_insert_transaksi === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt_insert_transaksi->bind_param("isdi", $id_hp, $kode_pembayaran, $total_biaya, $id_pengguna);

    if ($stmt_insert_transaksi->execute()) {
        // Update id_status to '2' in handphone table
        $sql_update_status = "UPDATE handphone SET id_status = 2 WHERE id_hp = ?";
        $stmt_update_status = $conn->prepare($sql_update_status);

        if ($stmt_update_status === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt_update_status->bind_param("i", $id_hp);
        if ($stmt_update_status->execute()) {
            echo "Transaksi updated successfully. Kode pembayaran generated and status updated.";
            header("location: transaksi.php");
            exit();
        } else {
            echo "Error updating status: " . $stmt_update_status->error;
        }

        $stmt_update_status->close();
    } else {
        echo "Error inserting transaksi: " . $stmt_insert_transaksi->error;
    }

    $stmt_insert_transaksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaksi</title>
    <link rel="stylesheet" href="assets/assets/css/main/app.css">
    <link rel="stylesheet" href="./assets/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="assets/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/assets/images/logo/favicon.png" type="image/png">
</head>
<body>
    <div id="app">
        <div id="main">
            <div class="page-heading">
                <h3>Update Transaksi</h3>
            </div>
            <div class="page-content">
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="id_hp">ID Handphone</label>
                                    <input type="text" id="id_hp" name="id_hp" class="form-control" value="<?php echo $_GET['id']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="merek">Merek</label>
                                    <input type="text" id="merek" name="merek" class="form-control" value="<?php echo $_GET['merek']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    <input type="text" id="tipe" name="tipe" class="form-control" value="<?php echo $_GET['tipe']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pemilik">Pemilik</label>
                                    <input type="text" id="pemilik" name="pemilik" class="form-control" value="<?php echo $_GET['pemilik']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total_biaya">Total Biaya</label>
                                    <input type="text" id="total_biaya" name="total_biaya" class="form-control" value="<?php echo $_GET['total_biaya']; ?>" required>
                                </div>
                                <input type="hidden" name="id_pengguna" value="<?php echo $_GET['id_pengguna']; ?>">
                                <div class="col-12 d-flex justify-content-end">
                                    <input class="btn btn-primary me-1 mb-1" type="submit" name="submit" value="Update Transaksi">
                                </div>
                            </form>
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
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="https://saugi.me">Violet Cell</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/assets/js/bootstrap.js"></script>
    <script src="assets/assets/js/app.js"></<?php