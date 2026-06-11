<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Ambil penyedia_id
    $stmt = $conn->prepare("SELECT id FROM penyedia WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $penyedia = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $penyedia_id = $penyedia['id'];
    $servis_id = $_POST['servis_id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO penyedia_servis (penyedia_id, servis_id, judul, deskripsi, harga) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$penyedia_id, $servis_id, $judul, $deskripsi, $harga]);
        
        echo '<script>alert("Layanan berhasil ditambahkan!"); window.location.href="penyedia_dashboard.php";</script>';
    } catch(PDOException $e) {
        echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.history.back();</script>';
    }
}
?>
