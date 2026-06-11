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

// Ambil semua booking
$stmt = $conn->prepare("SELECT b.*, ps.judul, s.nama as nama_servis, u.nama as nama_user, u.email 
                        FROM bookings b 
                        JOIN penyedia_servis ps ON b.penyedia_servis_id = ps.id 
                        JOIN servis s ON ps.servis_id = s.id 
                        JOIN users u ON b.user_id = u.id 
                        WHERE ps.penyedia_id = ? 
                        ORDER BY b.created_at DESC");
$stmt->execute([$penyedia['id']]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .booking-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .booking-card h3 {
            margin-top: 0;
            color: #333;
        }
        .booking-card p {
            margin: 5px 0;
            color: #666;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 3px;
            font-weight: bold;
            margin-top: 10px;
        }
        .status.pending {
            background-color: #FFA500;
            color: white;
        }
        .status.approved {
            background-color: #667eea;
            color: white;
        }
        .status.rejected {
            background-color: #f44336;
            color: white;
        }
        .btn-action {
            display: inline-block;
            padding: 8px 15px;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 10px;
            margin-top: 10px;
        }
        .btn-approve {
            background-color: #667eea;
        }
        .btn-reject {
            background-color: #f44336;
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
        <h2>Booking Masuk</h2>
        
        <?php if(count($bookings) > 0): ?>
            <?php foreach($bookings as $booking): ?>
            <div class="booking-card">
                <h3><?php echo $booking['judul']; ?></h3>
                <p><strong>Kategori:</strong> <?php echo $booking['nama_servis']; ?></p>
                <p><strong>Pelanggan:</strong> <?php echo $booking['nama_user']; ?> (<?php echo $booking['email']; ?>)</p>
                <p><strong>Tanggal:</strong> <?php echo date('d M Y', strtotime($booking['booking_date'])); ?></p>
                <p><strong>Jam:</strong> <?php echo date('H:i', strtotime($booking['booking_time'])); ?></p>
                <p><strong>Alamat:</strong> <?php echo $booking['alamat']; ?></p>
                <?php if($booking['catatan']): ?>
                <p><strong>Catatan:</strong> <?php echo $booking['catatan']; ?></p>
                <?php endif; ?>
                <p><strong>Total Harga:</strong> Rp <?php echo number_format($booking['total_harga'], 0, ',', '.'); ?></p>
                
                <span class="status <?php echo $booking['status']; ?>">
                    <?php 
                    if($booking['status'] == 'pending') echo 'Menunggu Konfirmasi';
                    elseif($booking['status'] == 'approved') echo 'Disetujui';
                    else echo 'Ditolak';
                    ?>
                </span>
                
                <?php if($booking['status'] == 'pending'): ?>
                <div>
                    <a href="penyedia_proses_booking.php?id=<?php echo $booking['id']; ?>&action=approve" class="btn-action btn-approve" onclick="return confirm('Setujui booking ini?')">Setujui</a>
                    <a href="penyedia_proses_booking.php?id=<?php echo $booking['id']; ?>&action=reject" class="btn-action btn-reject" onclick="return confirm('Tolak booking ini?')">Tolak</a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="booking-card">
                <p>Belum ada booking masuk</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
