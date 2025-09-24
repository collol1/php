<?php
require_once 'connect.php';

$makq = $_GET['makq'] ?? null;

if ($makq) {
    $sql = "DELETE FROM ketqua WHERE MAKQ = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$makq])) {
        header("Location: dsketqua.php?success=Xóa kết quả thành công!");
    } else {
        header("Location: dsketqua.php?error=Lỗi khi xóa kết quả!");
    }
} else {
    header("Location: dsketqua.php");
}
?>