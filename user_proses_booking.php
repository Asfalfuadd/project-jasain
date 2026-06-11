<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $penyedia_servis_id = $_POST['penyedia_servis_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $alamat = $_POST['alamat'];
    $catatan = $_POST['catatan'];
    $total_harga = $_POST['total_harga'];
    
    try {
        // Insert booking
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, penyedia_servis_id, booking_date, booking_time, alamat, catatan, total_harga, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $penyedia_servis_id, $booking_date, $booking_time, $alamat, $catatan, $total_harga]);
        
        $booking_id = $conn->lastInsertId();
        
        // Ambil info untuk notifikasi
        $stmt = $conn->prepare("SELECT ps.judul, ps.penyedia_id, u.nama as nama_user 
                                FROM penyedia_servis ps 
                                JOIN penyedia p ON ps.penyedia_id = p.id 
                                JOIN users u ON u.id = ? 
                                WHERE ps.id = ?");
        $stmt->execute([$user_id, $penyedia_servis_id]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Ambil user_id penyedia
        $stmt = $conn->prepare("SELECT user_id FROM penyedia WHERE id = ?");
        $stmt->execute([$info['penyedia_id']]);
        $penyedia_user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Kirim notifikasi ke penyedia
        $judul_notif = "Booking Baru Masuk! 📋";
        $pesan_notif = "Anda mendapat booking baru dari " . $info['nama_user'] . " untuk '" . $info['judul'] . "' pada " . date('d M Y', strtotime($booking_date)) . " pukul " . date('H:i', strtotime($booking_time)) . ". Silakan cek dashboard untuk menyetujui atau menolak.";
        
        $stmt = $conn->prepare("INSERT INTO notfikasi (user_id, judul, pesan) VALUES (?, ?, ?)");
        $stmt->execute([$penyedia_user['user_id'], $judul_notif, $pesan_notif]);
        
        echo '<script>alert("Booking berhasil! Menunggu konfirmasi penyedia."); window.location.href="user_booking_saya.php";</script>';
    } catch(PDOException $e) {
        echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.history.back();</script>';
    }
}
?>
