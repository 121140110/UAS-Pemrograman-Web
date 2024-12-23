<?php
session_start();
require 'database.php'; // Memasukkan file database.php

// Inisialisasi status tabel
if (!isset($_SESSION['tabel_status'])) {
    $_SESSION['tabel_status'] = 'hidden';
}

// Memeriksa apakah tombol toggle_tabel ditekan
if (isset($_POST['toogle_tabel'])) {
    $_SESSION['tabel_status'] = ($_SESSION['tabel_status'] == 'hidden') ? 'visible' : 'hidden';
    echo "<script>localStorage.setItem('tabel_status', '{$_SESSION['tabel_status']}');</script>";
}

// Mengambil status tabel dari localStorage jika ada
echo "<script>
    if (localStorage.getItem('tabel_status')) {
        document.cookie = 'tabel_status=' + localStorage.getItem('tabel_status') + '; path=/';
    }
</script>";

// Menangani penambahan data
if (isset($_POST['tambah'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Validasi di sisi server
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        die("Nama hanya boleh berisi huruf!");
    }
    if (!preg_match("/^\d{10,15}$/", $phone)) {
        die("Nomor HP harus terdiri dari 10-15 angka!");
    }

    // Mendapatkan alamat IP dan jenis browser
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];

    // Menggunakan objek Database
    $db = new Database();
    $db->insertData($name, $phone, $ip_address, $browser);

    // Redirect setelah data ditambahkan
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Mengambil data dari database jika sesi tabel status visible
$db = new Database();
$result = ($_SESSION['tabel_status'] == 'visible') ? $db->getData() : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jual Akun Valorant</title>
    <link rel="stylesheet" href="styles.css">
    <script src="form_validation.js"></script> <!-- Memasukkan file form_validation.js -->
</head>
<body>
    <h1>Silahkan isi data diri anda</h1>
    <p align="center">Lengkapi data diri anda pada form berikut ini dengan <strong>benar</strong>!</p>
    <div class ="container">
    <form method="post" action="" onsubmit="validateForm(event)">
        <div class="form">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required oninput="validateName()">
            <span id="nameError" style="color:red;"></span>
        </div>
        <div class="form">
            <label for="phone">Nomor HP Aktif:</label>
            <input type="tel" id="phone" name="phone" required oninput="validatePhone()">
            <span id="phoneError" style="color:red;"></span>
        </div>
        <div class="form">
            <label for="answer">Spesifikasi Akun:</label>
            <textarea id="answer" name="answer" required></textarea>
        </div>
        <div class="form">
            <label for="images">Lampirkan <i>screenshot inventory</i> akun:</label>
            <input type="file" name="images" required>
        </div>
        <div class="form">
            <label for="agree">Saya setuju dengan <a href="terms.php">syarat dan ketentuan</a> yang berlaku
            <input type="checkbox" name="terms" required style="margin-left: 5px;">
            </label>
</div>
        <button type="submit" name="tambah">Submit</button>
    </form><br>
</div>

    <form method="post" action="" style="text-align: center;">
        <button name="toogle_tabel" style="width: auto;">
            <?php echo ($_SESSION['tabel_status'] == 'hidden') ? 'Tampilkan Tabel' : 'Sembunyikan Tabel'; ?>
        </button>
    </form>

    <?php if ($_SESSION['tabel_status'] == 'visible' && isset($result)) { ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nomor HP</th>
            <th>IP Address</th>
            <th>Browser</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['No']; ?></td>
            <td><?php echo $row['Nama']; ?></td>
            <td><?php echo $row['Nomor_HP']; ?></td>
            <td><?php echo $row['IP_Address']; ?></td>
            <td><?php echo $row['Browser']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>
</body>
</html>