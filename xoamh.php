<?php
require_once 'connect.php';

$mamh = $_GET['mamh'] ?? null;

if ($mamh) {
    // Kiểm tra xem môn học có kết quả không
    $check_sql = "SELECT COUNT(*) FROM ketqua WHERE MAMH = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$mamh]);
    $has_results = $check_stmt->fetchColumn();
    
    if ($has_results > 0) {
        header("Location: dsmonhoc.php?error=Không thể xóa môn học vì có kết quả liên quan!");
    } else {
        $sql = "DELETE FROM monhoc WHERE MAMH = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$mamh])) {
            header("Location: dsmonhoc.php?success=Xóa môn học thành công!");
        } else {
            header("Location: dsmonhoc.php?error=Lỗi khi xóa môn học!");
        }
    }
} else {
    header("Location: dsmonhoc.php");
}
?>