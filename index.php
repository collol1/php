<?php
require_once 'connect.php';
if (!isset($conn)) {
    die("Kết nối database thất bại: " . $e->getMessage());
}
// Lấy số lượng từ database
$totalStudents = $conn->query("SELECT COUNT(*) FROM sinhvien")->fetchColumn();
$totalClasses = $conn->query("SELECT COUNT(*) FROM lop")->fetchColumn();
$totalSubjects = $conn->query("SELECT COUNT(*) FROM monhoc")->fetchColumn();
$totalResults = $conn->query("SELECT COUNT(*) FROM ketqua")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            padding: 0;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 15px 20px;
            border-bottom: 1px solid #495057;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }
        .card-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a0db8 0%, #1c68e8 100%);
        }
        .table th {
            background-color: #e9ecef;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        }
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .stats-card h3 {
            font-size: 2rem;
            margin: 10px 0;
        }
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
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-tachometer-alt"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dssinhvien.php">
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
                <h2 class="mb-4">Dashboard</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-card" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                            <i class="fas fa-users"></i>
                            <h3><?php echo $totalStudents; ?></h3>
                            <p>Tổng số sinh viên</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);">
                            <i class="fas fa-building"></i>
                            <h3><?php echo $totalClasses; ?></h3>
                            <p>Tổng số lớp</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card" style="background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);">
                            <i class="fas fa-book"></i>
                            <h3><?php echo $totalSubjects; ?></h3>
                            <p>Tổng số môn học</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card" style="background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);">
                            <i class="fas fa-chart-bar"></i>
                            <h3><?php echo $totalResults; ?></h3>
                            <p>Tổng số kết quả</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>