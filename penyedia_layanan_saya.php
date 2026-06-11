<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil penyedia_id
$stmt = $conn->prepare("SELECT id FROM penyedia WHERE user_id = ?");
$stmt->execute([$user_id]);
$penyedia = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil layanan
$stmt = $conn->prepare("SELECT ps.*, s.nama as nama_servis 
                        FROM penyedia_servis ps 
                        JOIN servis s ON ps.servis_id = s.id 
                        WHERE ps.penyedia_id = ?");
$stmt->execute([$penyedia['id']]);
$layanan = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .layanan-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .layanan-card h3 {
            margin-top: 0;
            color: #333;
        }
        .layanan-card p {
            margin: 5px 0;
            color: #666;
        }
        .harga {
            font-size: 20px;
            color: #667eea;
            font-weight: bold;
            margin: 10px 0;
        }
        .actions {
            margin-top: 15px;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
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
        <h2>Layanan Saya</h2>
        <a href="penyedia_tambah_layanan.php" class="btn">+ Tambah Layanan Baru</a>
        
        <div class="layanan-grid">
            <?php if(count($layanan) > 0): ?>
                <?php foreach($layanan as $item): ?>
                <div class="layanan-card">
                    <h3><?php echo $item['judul']; ?></h3>
                    <p><strong>Kategori:</strong> <?php echo $item['nama_servis']; ?></p>
                    <p><strong>Deskripsi:</strong> <?php echo $item['deskripsi']; ?></p>
                    <div class="harga">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></div>
                    <div class="actions">
                        <a href="penyedia_edit_layanan.php?id=<?php echo $item['id']; ?>" style="color: #667eea; margin-right: 15px;">Edit</a>
                        <a href="penyedia_hapus_layanan.php?id=<?php echo $item['id']; ?>" style="color: #f44336;" onclick="return confirm('Yakin hapus layanan ini?')">Hapus</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="layanan-card">
                    <p>Belum ada layanan. Tambahkan layanan pertama Anda!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
