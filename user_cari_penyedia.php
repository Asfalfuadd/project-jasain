<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

$servis_id = $_GET['servis_id'];

// Ambil nama servis
$stmt = $conn->prepare("SELECT nama FROM servis WHERE id = ?");
$stmt->execute([$servis_id]);
$servis = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil penyedia servis
$stmt = $conn->prepare("SELECT ps.*, u.nama as nama_penyedia, p.alamat, p.no_hp 
                        FROM penyedia_servis ps 
                        JOIN penyedia p ON ps.penyedia_id = p.id 
                        JOIN users u ON p.user_id = u.id 
                        WHERE ps.servis_id = ?");
$stmt->execute([$servis_id]);
$penyedia_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ddd;
            color: #333;
            text-decoration: none;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        .penyedia-list {
            display: grid;
            gap: 15px;
        }
        .penyedia-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .penyedia-card h3 {
            margin-top: 0;
            color: #333;
        }
        .penyedia-card p {
            margin: 5px 0;
            color: #666;
        }
        .harga {
            font-size: 20px;
            color: #667eea;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn-booking {
            display: inline-block;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
        }
        .btn-booking:hover {
            background-color: #5568d3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>JasaIn</h2>
        <div>
            <a href="user_dashboard.php">Home</a>
            <a href="user_booking_saya.php">Booking Saya</a>
            <a href="user_notifikasi.php">Notifikasi</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <a href="user_dashboard.php" class="back-btn">← Kembali</a>
        
        <h2>Penyedia <?php echo $servis['nama']; ?></h2>
        
        <div class="penyedia-list">
            <?php if(count($penyedia_list) > 0): ?>
                <?php foreach($penyedia_list as $penyedia): ?>
                <div class="penyedia-card">
                    <h3><?php echo $penyedia['judul']; ?></h3>
                    <p><strong>Penyedia:</strong> <?php echo $penyedia['nama_penyedia']; ?></p>
                    <p><strong>Deskripsi:</strong> <?php echo $penyedia['deskripsi']; ?></p>
                    <p><strong>Alamat:</strong> <?php echo $penyedia['alamat']; ?></p>
                    <p><strong>No HP:</strong> <?php echo $penyedia['no_hp']; ?></p>
                    <div class="harga">Rp <?php echo number_format($penyedia['harga'], 0, ',', '.'); ?></div>
                    <a href="user_booking.php?penyedia_servis_id=<?php echo $penyedia['id']; ?>" class="btn-booking">Booking Sekarang</a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="penyedia-card">
                    <p>Belum ada penyedia untuk layanan ini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
