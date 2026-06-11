<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil notifikasi
$stmt = $conn->prepare("SELECT * FROM notfikasi WHERE user_id = ? ORDER BY crceated_at DESC");
$stmt->execute([$user_id]);
$notifikasi = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update notifikasi jadi sudah dibaca
$stmt = $conn->prepare("UPDATE notfikasi SET is_read = 1 WHERE user_id = ?");
$stmt->execute([$user_id]);
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
            max-width: 800px;
            margin: 0 auto;
        }
        .notif-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .notif-card h3 {
            margin-top: 0;
            color: #333;
        }
        .notif-card p {
            margin: 10px 0;
            color: #666;
        }
        .notif-time {
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>JasaIn - Penyedia</h2>
        <div>
            <a href="penyedia_dashboard.php">Home</a>
            <a href="penyedia_layanan_saya.php">Layanan Saya</a>
            <a href="penyedia_booking_masuk.php">Booking Masuk</a>
            <a href="penyedia_notifikasi.php">Notifikasi</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <h2>Notifikasi</h2>
        
        <?php if(count($notifikasi) > 0): ?>
            <?php foreach($notifikasi as $notif): ?>
            <div class="notif-card">
                <h3><?php echo $notif['judul']; ?></h3>
                <p><?php echo $notif['pesan']; ?></p>
                <div class="notif-time"><?php echo date('d M Y H:i', strtotime($notif['crceated_at'])); ?></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="notif-card">
                <p>Belum ada notifikasi</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
