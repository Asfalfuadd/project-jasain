<?php
// Koneksi database
$host = '195.88.211.20';
$dbname = 'tiuinmtr_jasain';
$username = 'tiuinmtr_jasain';
$password = 'jasain12345#';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

// Start session
session_start();
?>
