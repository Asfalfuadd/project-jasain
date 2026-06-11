<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama, $email, $password, $role]);
        
        header('Location: login.php?msg=register');
        exit();
    } catch(PDOException $e) {
        echo '<script>alert("Email sudah terdaftar!"); window.location.href="register.php";</script>';
    }
}
?>
