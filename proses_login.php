<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        
        if($user['role'] == 'admin') {
            header('Location: admin_dashboard.php');
        } elseif($user['role'] == 'penyedia') {
            header('Location: penyedia_dashboard.php');
        } else {
            header('Location: user_dashboard.php');
        }
        exit();
    } else {
        echo '<script>alert("Email atau password salah!"); window.location.href="login.php";</script>';
    }
}
?>
