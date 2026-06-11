<?php
require_once 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'penyedia') {
    header('Location: login.php');
    exit();
}

$booking_id = $_GET['id'];
$action = $_GET['action'];

if($action == 'approve') {
    $status = 'approved';
    $judul_notif = "Booking Disetujui! ✅";
    $pesan_template = "Booking Anda untuk '%s' pada %s pukul %s telah disetujui oleh penyedia. Silakan hubungi penyedia untuk informasi lebih lanjut.";
} else {
    $status = 'rejected';
    $judul_notif = "Booking Ditolak ❌";
    $pesan_template = "Maaf, booking Anda untuk '%s' pada %s pukul %s ditolak oleh penyedia. Silakan coba penyedia lain atau hubungi kami untuk bantuan.";
}

try {
    // Update status booking
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $booking_id]);
    
    // Ambil info booking untuk notifikasi
    $stmt = $conn->prepare("SELECT b.user_id, b.booking_date, b.booking_time, ps.judul 
                            FROM bookings b 
                            JOIN penyedia_servis ps ON b.penyedia_servis_id = ps.id 
                            WHERE b.id = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Kirim notifikasi ke user
    $pesan_notif = sprintf($pesan_template, 
                          $booking['judul'], 
                          date('d M Y', strtotime($booking['booking_date'])), 
                          date('H:i', strtotime($booking['booking_time'])));
    
    $stmt = $conn->prepare("INSERT INTO notfikasi (user_id, judul, pesan) VALUES (?, ?, ?)");
    $stmt->execute([$booking['user_id'], $judul_notif, $pesan_notif]);
    
    echo '<script>alert("Booking berhasil di' . ($action == 'approve' ? 'setujui' : 'tolak') . '!"); window.location.href="penyedia_booking_masuk.php";</script>';
} catch(PDOException $e) {
    echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '"); window.history.back();</script>';
}
?>
