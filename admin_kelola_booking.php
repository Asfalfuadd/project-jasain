<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil semua booking
$stmt = $conn->query("SELECT b.*, u.nama as nama_user, ps.judul, s.nama as nama_servis 
                      FROM bookings b 
                      JOIN users u ON b.user_id = u.id 
                      JOIN penyedia_servis ps ON b.penyedia_servis_id = ps.id 
                      JOIN servis s ON ps.servis_id = s.id 
                      ORDER BY b.created_at DESC");
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
        .section {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
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
        <div class="section">
            <h2>Kelola Booking</h2>
            
            <table>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Layanan</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
                <?php foreach($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['nama_user']; ?></td>
                    <td><?php echo $booking['judul']; ?></td>
                    <td><?php echo $booking['nama_servis']; ?></td>
                    <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                    <td>Rp <?php echo number_format($booking['total_harga'], 0, ',', '.'); ?></td>
                    <td>
                        <span class="status <?php echo $booking['status']; ?>">
                            <?php 
                            if($booking['status'] == 'pending') echo 'Pending';
                            elseif($booking['status'] == 'approved') echo 'Disetujui';
                            else echo 'Ditolak';
                            ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
