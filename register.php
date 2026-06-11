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
        input, select {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>JasaIn</h1>
        <h3 style="text-align: center; color: #666;">Daftar Akun</h3>
        
        <p style="text-align: center; margin-bottom: 20px;">
            <a href="index.php" style="color: #667eea; text-decoration: none;">← Kembali ke Beranda</a>
        </p>
        
        <form method="POST" action="proses_register.php">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <select name="role" required>
                <option value="">Pilih Tipe Akun</option>
                <option value="user">User (Pelanggan)</option>
                <option value="penyedia">Penyedia Jasa</option>
            </select>
            
            <button type="submit">Daftar</button>
        </form>
        
        <div class="link">
            <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
        </div>
    </div>
</body>
</html>
