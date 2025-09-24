<?php
require 'connect.php';

$masv = $_GET['masv'] ?? null;

if ($masv) {
    // Kiểm tra xem sinh viên có kết quả không
    $check_sql = "SELECT COUNT(*) FROM ketqua WHERE MASV = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$masv]);
    $has_results = $check_stmt->fetchColumn();
    
    if ($has_results > 0) {
        header("Location: dssinhvien.php?error=Không thể xóa sinh viên vì có kết quả liên quan!");
    } else {
        // Xóa ảnh của sinh viên nếu có
        $sql_select = "SELECT ANH FROM sinhvien WHERE MASV = ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->execute([$masv]);
        $student = $stmt_select->fetch(PDO::FETCH_ASSOC);
        
        if ($student && !empty($student['ANH']) && file_exists('uploads/' . $student['ANH'])) {
            unlink('uploads/' . $student['ANH']);
        }
        
        $sql = "DELETE FROM sinhvien WHERE MASV = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$masv])) {
            header("Location: dssinhvien.php?success=Xóa sinh viên thành công!");
        } else {
            header("Location: dssinhvien.php?error=Lỗi khi xóa sinh viên!");
        }
    }
} else {
    header("Location: dssinhvien.php");
}
?>