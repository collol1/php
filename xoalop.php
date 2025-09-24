<?php
require_once 'connect.php';

$malop = $_GET['malop'] ?? null;

if ($malop) {
    // Kiểm tra xem lớp có sinh viên không
    $check_sql = "SELECT COUNT(*) FROM sinhvien WHERE MALOP = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$malop]);
    $has_students = $check_stmt->fetchColumn();
    
    if ($has_students > 0) {
        header("Location: dslop.php?error=Không thể xóa lớp vì có sinh viên đang học!");
    } else {
        $sql = "DELETE FROM lop WHERE MALOP = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$malop])) {
            header("Location: dslop.php?success=Xóa lớp thành công!");
        } else {
            header("Location: dslop.php?error=Lỗi khi xóa lớp!");
        }
    }
} else {
    header("Location: dslop.php");
}
?>