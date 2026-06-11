<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

$penyedia_servis_id = $_GET['penyedia_servis_id'];

// Ambil detail penyedia servis
$stmt = $conn->prepare("SELECT ps.*, u.nama as nama_penyedia, s.nama as nama_servis 
                        FROM penyedia_servis ps 
                        JOIN penyedia p ON ps.penyedia_id = p.id 
                        JOIN users u ON p.user_id = u.id 
                        JOIN servis s ON ps.servis_id = s.id 
                        WHERE ps.id = ?");
$stmt->execute([$penyedia_servis_id]);
$detail = $stmt->fetch(PDO::FETCH_ASSOC);
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
            max-width: 600px;
            margin: 0 auto;
        }
        .booking-form {
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .info-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box p {
            margin: 5px 0;
        }
        .harga {
            font-size: 24px;
            color: #667eea;
            font-weight: bold;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #5568d3;
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
        <a href="user_cari_penyedia.php?servis_id=<?php echo $detail['servis_id']; ?>" class="back-btn">← Kembali</a>
        
        <div class="booking-form">
            <h2>Form Booking</h2>
            
            <div class="info-box">
                <p><strong>Layanan:</strong> <?php echo $detail['nama_servis']; ?></p>
                <p><strong>Judul:</strong> <?php echo $detail['judul']; ?></p>
                <p><strong>Penyedia:</strong> <?php echo $detail['nama_penyedia']; ?></p>
                <div class="harga">Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?></div>
            </div>
            
            <form method="POST" action="user_proses_booking.php">
                <input type="hidden" name="penyedia_servis_id" value="<?php echo $penyedia_servis_id; ?>">
                <input type="hidden" name="total_harga" value="<?php echo $detail['harga']; ?>">
                
                <div class="form-group">
                    <label>Tanggal Booking</label>
                    <input type="date" name="booking_date" required>
                </div>
                
                <div class="form-group">
                    <label>Jam Booking</label>
                    <input type="time" name="booking_time" required>
                </div>
                
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" placeholder="Masukkan alamat lengkap Anda" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Catatan (Opsional)</label>
                    <textarea name="catatan" placeholder="Tambahkan catatan jika ada"></textarea>
                </div>
                
                <button type="submit">Konfirmasi Booking</button>
            </form>
        </div>
    </div>
</body>
</html>
