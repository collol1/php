<?php
require 'connect.php';

// Xử lý xóa sinh viên
if (isset($_GET['delete'])) {
    $masv = $_GET['delete'];
    
    // Kiểm tra xem sinh viên có kết quả không
    $check_sql = "SELECT COUNT(*) FROM ketqua WHERE MASV = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([$masv]);
    $has_results = $check_stmt->fetchColumn();
    
    if ($has_results > 0) {
        $message = "Không thể xóa sinh viên vì có kết quả liên quan!";
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
            $message = "Xóa sinh viên thành công!";
        } else {
            $message = "Lỗi khi xóa sinh viên!";
        }
    }
}

// Lấy danh sách sinh viên
$sql = "SELECT s.*, l.TENLOP FROM sinhvien s LEFT JOIN lop l ON s.MALOP = l.MALOP ORDER BY s.MASV";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
        .sidebar { background-color: #343a40; min-height: 100vh; padding: 0; }
        .sidebar .nav-link { color: #adb5bd; padding: 15px 20px; border-bottom: 1px solid #495057; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: #495057; }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; text-align: center; }
        .content { padding: 20px; }
        .card { border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 20px; border: none; }
        .card-header { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; border-radius: 10px 10px 0 0 !important; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, #5a0db8 0%, #1c68e8 100%); }
        .table th { background-color: #e9ecef; }
        .action-buttons .btn { margin-right: 5px; }
        .student-image { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><i class="fas fa-graduation-cap me-2"></i>Quản Lý Sinh Viên</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-tachometer-alt"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dssinhvien.php">
                            <i class="fas fa-users"></i>Quản lý Sinh viên
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dslop.php">
                            <i class="fas fa-building"></i>Quản lý Lớp
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dsmonhoc.php">
                            <i class="fas fa-book"></i>Quản lý Môn học
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dsketqua.php">
                            <i class="fas fa-chart-bar"></i>Quản lý Kết quả
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Quản lý Sinh viên</h2>
                    <a href="themsv.php" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Thêm sinh viên
                    </a>
                </div>
                
                <?php if (isset($message)): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        Danh sách sinh viên
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Ảnh</th>
                                        <th>Mã SV</th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Lớp</th>
                                        <th>Địa chỉ</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($student['ANH']) && file_exists('uploads/' . $student['ANH'])): ?>
                                                <img src="uploads/<?php echo $student['ANH']; ?>" alt="Ảnh sinh viên" class="student-image">
                                            <?php else: ?>
                                                <div class="text-center">
                                                    <i class="fas fa-user-circle fa-2x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $student['MASV']; ?></td>
                                        <td><?php echo $student['HOTEN']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($student['NGAYSINH'])); ?></td>
                                        <td><?php echo $student['GIOITINH'] == '1' ? 'Nam' : 'Nữ'; ?></td>
                                        <td><?php echo $student['TENLOP']; ?></td>
                                        <td><?php echo $student['DIACHI']; ?></td>
                                        <td class="action-buttons">
                                            <a href="suasv.php?masv=<?php echo $student['MASV']; ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="dssinhvien.php?delete=<?php echo $student['MASV']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>