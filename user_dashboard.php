<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

// Ambil data servis
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
            max-width: 1200px;
            margin: 0 auto;
        }
        .welcome {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .servis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .servis-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .servis-card h3 {
            color: #333;
            margin-top: 0;
        }
        .servis-card a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
        }
        .servis-card a:hover {
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
        <div class="welcome">
            <h2>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h2>
            <p>Pilih jasa yang Anda butuhkan dibawah ini</p>
        </div>
        
        <h3>Layanan Kami</h3>
        <div class="servis-grid">
            <?php foreach($servis_list as $servis): ?>
            <div class="servis-card">
                <h3><?php echo $servis['nama']; ?></h3>
                <p>Temukan penyedia jasa terbaik</p>
                <a href="user_cari_penyedia.php?servis_id=<?php echo $servis['id']; ?>">Lihat Penyedia</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
