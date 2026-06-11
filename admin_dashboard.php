<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Hitung statistik
$stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$total_user = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'penyedia'");
$total_penyedia = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM bookings");
$total_booking = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM penyedia_servis");
$total_layanan = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>JasaIn.co</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #667eea;
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 {
            margin: 0;
            font-size: 26px;
        }
        .header a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 15px;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin: 0;
            font-size: 36px;
            color: #667eea;
        }
        .stat-card p {
            margin: 10px 0 0 0;
            color: #666;
        }
        .section {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .section h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>JasaIn - Admin</h2>
        <div>
            <a href="admin_dashboard.php">Home</a>
            <a href="admin_kelola_user.php">Kelola User</a>
            <a href="admin_kelola_penyedia.php">Kelola Penyedia</a>
            <a href="admin_kelola_booking.php">Kelola Booking</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <h2>Dashboard Admin</h2>
        <p>Selamat datang, <?php echo $_SESSION['nama']; ?>!</p>
        
        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $total_user; ?></h3>
                <p>Total User</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_penyedia; ?></h3>
                <p>Total Penyedia</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_booking; ?></h3>
                <p>Total Booking</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_layanan; ?></h3>
                <p>Total Layanan</p>
            </div>
        </div>
        
        <div class="section">
            <h3>Informasi Sistem</h3>
            <p>Sistem JasaIn berjalan dengan baik. Gunakan menu di atas untuk mengelola data.</p>
        </div>
    </div>
</body>
</html>
