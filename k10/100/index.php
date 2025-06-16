<?php
            include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Booking Servis Kendaraan</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistem Booking Servis Kendaraan</h1>
            <p>Kelola jadwal servis kendaraan Anda dengan mudah</p>
        </div>
        
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('booking')">Booking Baru</button>
            <button class="nav-tab" onclick="showTab('daftar')">Daftar Booking</button>
            <button class="nav-tab" onclick="showTab('pelanggan')">Data Pelanggan</button>
            <button class="nav-tab" onclick="showTab('layanan')">Layanan Servis</button>
        </div>
        
       <?php include 'booking_baru.php' ?>
       <?php include 'daftar_booking.php' ?>
        <?php include 'data_pelanggan.php' ?>
        <?php include 'layanan_servis.php' ?>
        
        

    </div>
    

<script src="script.js"></script>
</body>
</html>

<?php
$conn->close();
?>