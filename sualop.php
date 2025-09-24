<?php
require_once 'connect.php';

// Lấy thông tin lớp cần sửa
$malop = $_GET['malop'] ?? null;

if (!$malop) {
    header("Location: dslop.php");
    exit;
}

// Lấy thông tin lớp
$sql = "SELECT * FROM lop WHERE MALOP = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$malop]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$class) {
    header("Location: dslop.php");
    exit;
}

// Xử lý cập nhật lớp
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenlop = $_POST['tenlop'];
    
    $sql = "UPDATE lop SET TENLOP = ? WHERE MALOP = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$tenlop, $malop])) {
        header("Location: dslop.php?success=1");
        exit;
    } else {
        $error = "Lỗi khi cập nhật lớp!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Lớp</title>
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
                        <a class="nav-link" href="dssinhvien.php">
                            <i class="fas fa-users"></i>Quản lý Sinh viên
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dslop.php">
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
                <h2 class="mb-4">Sửa Lớp</h2>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        Thông tin lớp
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="malop" class="form-label">Mã lớp</label>
                                    <input type="text" class="form-control" id="malop" value="<?php echo $class['MALOP']; ?>" disabled>
                                    <small class="text-muted">Mã lớp không thể thay đổi</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tenlop" class="form-label">Tên lớp</label>
                                    <input type="text" class="form-control" id="tenlop" name="tenlop" value="<?php echo $class['TENLOP']; ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="dslop.php" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>