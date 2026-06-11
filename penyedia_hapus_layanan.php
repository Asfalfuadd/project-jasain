<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM penyedia_servis WHERE id = ?");
    $stmt->execute([$id]);
    
    echo '<script>alert("Layanan berhasil dihapus!"); window.location.href="penyedia_layanan_saya.php";</script>';
} catch(PDOException $e) {
    echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.history.back();</script>';
}
?>
