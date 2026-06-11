<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$layanan_id = $_GET['id'];

// Ambil penyedia_id
$stmt = $conn->prepare("SELECT id FROM penyedia WHERE user_id = ?");
$stmt->execute([$user_id]);
$penyedia = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil data layanan
$stmt = $conn->prepare("SELECT * FROM penyedia_servis WHERE id = ? AND penyedia_id = ?");
$stmt->execute([$layanan_id, $penyedia['id']]);
$layanan = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$layanan) {
    echo '<script>alert("Layanan tidak ditemukan!"); window.location.href="penyedia_dashboard.php";</script>';
    exit();
}

// Ambil daftar servis
$stmt = $conn->query("SELECT * FROM servis");
$servis_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .form-box {
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
        .form-group input, .form-group textarea, .form-group select {
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
        <a href="penyedia_dashboard.php" class="back-btn">← Kembali</a>
        
        <div class="form-box">
            <h2>Edit Layanan</h2>
            
            <form method="POST" action="penyedia_proses_edit_layanan.php">
                <input type="hidden" name="layanan_id" value="<?php echo $layanan['id']; ?>">
                
                <div class="form-group">
                    <label>Kategori Layanan</label>
                    <select name="servis_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach($servis_list as $servis): ?>
                        <option value="<?php echo $servis['id']; ?>" <?php echo ($servis['id'] == $layanan['servis_id']) ? 'selected' : ''; ?>>
                            <?php echo $servis['nama']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Judul Layanan</label>
                    <input type="text" name="judul" value="<?php echo htmlspecialchars($layanan['judul']); ?>" placeholder="Contoh: Rental Motor Harian" required>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" placeholder="Jelaskan layanan Anda" required><?php echo htmlspecialchars($layanan['deskripsi']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="<?php echo $layanan['harga']; ?>" placeholder="50000" required>
                </div>
                
                <button type="submit">Update Layanan</button>
            </form>
        </div>
    </div>
</body>
</html>
