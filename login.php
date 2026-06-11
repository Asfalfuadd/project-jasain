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
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
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
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #667eea;
            text-decoration: none;
        }
        .error {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
        .success {
            color: green;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>JasaIn</h1>
        <h3 style="text-align: center; color: #666;">Login</h3>
        
        <p style="text-align: center; margin-bottom: 20px;">
            <a href="index.php" style="color: #667eea; text-decoration: none;">← Kembali ke Beranda</a>
        </p>
        
        <?php
        if(isset($_GET['msg'])) {
            if($_GET['msg'] == 'logout') {
                echo '<p class="success">Berhasil logout</p>';
            } elseif($_GET['msg'] == 'register') {
                echo '<p class="success">Registrasi berhasil! Silakan login</p>';
            }
        }
        ?>
        
        <form method="POST" action="proses_login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="link">
            <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
        </div>
    </div>
</body>
</html>
