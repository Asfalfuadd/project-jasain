<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Cek apakah sudah ada profil
$stmt = $conn->prepare("SELECT * FROM penyedia WHERE user_id = ?");
$stmt->execute([$user_id]);
$penyedia = $stmt->fetch(PDO::FETCH_ASSOC);

if($penyedia) {
    header('Location: penyedia_dashboard.php');
    exit();
}
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
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Setup Profil Penyedia</h2>
        <p style="text-align: center; color: #666;">Lengkapi profil Anda untuk mulai menawarkan jasa</p>
        
        <form method="POST" action="penyedia_proses_setup_profil.php">
            <div class="form-group">
                <label>Deskripsi Usaha</label>
                <textarea name="deskripsi" placeholder="Ceritakan tentang usaha Anda" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" placeholder="Alamat usaha Anda" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Nomor HP/WhatsApp</label>
                <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" required>
            </div>
            
            <button type="submit">Simpan Profil</button>
        </form>
    </div>
</body>
</html>
