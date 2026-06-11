<?php
require_once 'config.php';

// Cek sudah login atau belum
if(isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    if($role == 'admin') {
        header('Location: admin_dashboard.php');
    } elseif($role == 'penyedia') {
        header('Location: penyedia_dashboard.php');
    } else {
        header('Location: user_dashboard.php');
    }
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
            background-color: white;
        }
        
        .navbar {
            background-color: #667eea;
            padding: 25px 30px;
            color: white;
        }
        
        .navbar h1 {
            margin: 0;
            font-size: 28px;
        }
        
        .navbar-menu {
            float: right;
            margin-top: -30px;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 10px 18px;
            border: 1px solid white;
            border-radius: 3px;
            font-size: 15px;
        }
        
        .header {
            background-color: #667eea;
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        
        .header h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .header a {
            background-color: white;
            color: #667eea;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 0 10px;
            display: inline-block;
            min-width: 150px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        .section-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            margin-top: 0;
            color: #333;
        }
        
        .layanan-container {
            text-align: center;
            font-size: 0;
        }
        
        .layanan-box {
            display: inline-block;
            width: 24%;
            margin: 0 0.5%;
            padding: 20px 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            vertical-align: top;
            box-sizing: border-box;
            font-size: 14px;
            height: 200px;
        }
        
        .layanan-box h3 {
            color: #667eea;
            margin-top: 10px;
        }
        
        .icon {
            font-size: 40px;
        }
        
        .cara-kerja {
            background-color: #f9f9f9;
            padding: 30px 0;
            margin-top: 0;
        }
        
        
        .step-container {
            text-align: center;
            font-size: 0;
        }
        
        .step-box {
            display: inline-block;
            width: 24%;
            margin: 0 0.5%;
            padding: 20px 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            vertical-align: top;
            box-sizing: border-box;
            font-size: 14px;
            height: 200px;
        }
        
        .step-number {
            background-color: #667eea;
            color: white;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            margin: 0 auto 15px;
            font-size: 20px;
            font-weight: bold;
        }
        
        .cta-section {
            background-color: #667eea;
            color: white;
            padding: 50px 20px;
            text-align: center;
            margin-top: 40px;
        }
        
        .cta-section h2 {
            margin-bottom: 20px;
        }
        
        .cta-section a {
            background-color: white;
            color: #667eea;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 0 10px;
            display: inline-block;
            min-width: 150px;
        }
        
        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>JasaIn</h1>
        <div class="navbar-menu">
            <a href="login.php">Login</a>
            <a href="register.php">Daftar</a>
        </div>
        <div style="clear: both;"></div>
    </div>
    
    <div class="header">
        <h2>Selamat Datang di JasaIn</h2>
        <p>Platform jasa offline untuk berbagai kebutuhan Anda</p>
        <a href="register.php">Daftar Sekarang</a>
        <a href="login.php" style="background-color: transparent; border: 2px solid white; color: white;">Login</a>
    </div>
    
    <div class="container">
        <h2 class="section-title">Layanan Kami</h2>
        
        <div class="layanan-container">
            <div class="layanan-box">
                <div class="icon">🚗</div>
                <h3>Rental Kendaraan</h3>
                <p>Sewa motor atau mobil untuk kebutuhan Anda</p>
            </div>
            
            <div class="layanan-box">
                <div class="icon">🔧</div>
                <h3>Servis Elektronik</h3>
                <p>Perbaikan alat elektronik rumah tangga</p>
            </div>
            
            <div class="layanan-box">
                <div class="icon">👕</div>
                <h3>Laundry</h3>
                <p>Cuci pakaian dan sepatu bersih         </p>
            </div>
            
            <div class="layanan-box">
                <div class="icon">📦</div>
                <h3>Angkut Barang</h3>
                <p>Jasa angkut barang pindahan            </p>
            </div>
        </div>
    </div>
</body>
</html>
