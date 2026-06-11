<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO penyedia (user_id, deskripsi, alamat, no_hp) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $deskripsi, $alamat, $no_hp]);
        
        header('Location: penyedia_dashboard.php');
        exit();
    } catch(PDOException $e) {
        echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.history.back();</script>';
    }
}
?>
