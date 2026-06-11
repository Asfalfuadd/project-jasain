<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil semua penyedia
$stmt = $conn->query("SELECT u.*, p.alamat, p.no_hp, p.deskripsi 
                      FROM users u 
                      LEFT JOIN penyedia p ON u.id = p.user_id 
                      WHERE u.role = 'penyedia' 
                      ORDER BY u.created_at DESC");
$penyedia_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .btn-delete {
            color: #f44336;
            text-decoration: none;
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
            <h2>Kelola Penyedia</h2>
            
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach($penyedia_list as $penyedia): ?>
                <tr>
                    <td><?php echo $penyedia['id']; ?></td>
                    <td><?php echo $penyedia['nama']; ?></td>
                    <td><?php echo $penyedia['email']; ?></td>
                    <td><?php echo $penyedia['no_hp'] ? $penyedia['no_hp'] : '-'; ?></td>
                    <td><?php echo $penyedia['alamat'] ? substr($penyedia['alamat'], 0, 30) . '...' : '-'; ?></td>
                    <td><?php echo date('d M Y', strtotime($penyedia['created_at'])); ?></td>
                    <td>
                        <a href="admin_hapus_user.php?id=<?php echo $penyedia['id']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus penyedia ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
