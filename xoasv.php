<?php
require_once("connect.php");
if (isset($_GET['MASV'])) {
    $masv = $_GET['MASV'];
    $stmt = $conn->prepare("DELETE FROM SINHVIEN WHERE MASV = ?");
    $stmt->execute([$masv]);
}
header("Location: dssinhvien.php");
exit;
?>