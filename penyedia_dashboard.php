<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Cek apakah sudah ada profil penyedia
$stmt = $conn->prepare("SELECT * FROM penyedia WHERE user_id = ?");
$stmt->execute([$user_id]);
$penyedia = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$penyedia) {
    header('Location: penyedia_setup_profil.php');
    exit();
}

// Hitung statistik
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM bookings b 
                        JOIN penyedia_servis ps ON b.penyedia_servis_id = ps.id 
                        WHERE ps.penyedia_id = ?");
$stmt->execute([$penyedia['id']]);
$total_booking = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM bookings b 
                        JOIN penyedia_servis ps ON b.penyedia_servis_id = ps.id 
                        WHERE ps.penyedia_id = ? AND b.status = 'pending'");
$stmt->execute([$penyedia['id']]);
$pending_booking = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil layanan yang ditawarkan
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
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-bottom: 15px;
        }
        .btn:hover {
            background-color: #0b7dda;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f5f5f5;
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
        <h2>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h2>
        
        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $total_booking; ?></h3>
                <p>Total Booking</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $pending_booking; ?></h3>
                <p>Menunggu Konfirmasi</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count($layanan); ?></h3>
                <p>Layanan Aktif</p>
            </div>
        </div>
        
        <div class="section">
            <h3>Layanan Saya</h3>
            <a href="penyedia_tambah_layanan.php" class="btn">+ Tambah Layanan Baru</a>
            
            <?php if(count($layanan) > 0): ?>
            <table>
                <tr>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach($layanan as $item): ?>
                <tr>
                    <td><?php echo $item['nama_servis']; ?></td>
                    <td><?php echo $item['judul']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="penyedia_edit_layanan.php?id=<?php echo $item['id']; ?>" style="color: #667eea;">Edit</a> |
                        <a href="penyedia_hapus_layanan.php?id=<?php echo $item['id']; ?>" style="color: #f44336;" onclick="return confirm('Yakin hapus layanan ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            <p>Belum ada layanan. Tambahkan layanan pertama Anda!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
