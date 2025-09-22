<?php
$servername = "localhost";
$username = "root";
$pass = "";
$db = "quanlysinhvien";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $pass); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
} 
?>