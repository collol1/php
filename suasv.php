<?php
require 'connect.php';

// Lấy thông tin sinh viên cần sửa
$masv = $_GET['masv'] ?? null;

if (!$masv) {
    header("Location: dssinhvien.php");
    exit;
}

// Lấy thông tin sinh viên
$sql = "SELECT * FROM sinhvien WHERE MASV = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$masv]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header("Location: dssinhvien.php");
    exit;
}

// Lấy danh sách lớp
$sql = "SELECT * FROM lop ORDER BY TENLOP";
$stmt = $conn->prepare($sql);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý cập nhật sinh viên
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'];
    $ngaysinh = $_POST['ngaysinh'];
    $gioitinh = $_POST['gioitinh'];
    $malop = $_POST['malop'];
    $diachi = $_POST['diachi'];
    
    // Xử lý upload ảnh nếu có
    $anh = $student['ANH']; // Giữ ảnh cũ nếu không có ảnh mới
    
    if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $file_type = $_FILES['anh']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES['anh']['name'], PATHINFO_EXTENSION);
            $new_filename = $masv . '_' . time() . '.' . $file_extension;
            $upload_path = 'uploads/' . $new_filename;
            
            // Tạo thư mục uploads nếu chưa tồn tại
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['anh']['tmp_name'], $upload_path)) {
                // Xóa ảnh cũ nếu có
                if (!empty($student['ANH']) && file_exists('uploads/' . $student['ANH'])) {
                    unlink('uploads/' . $student['ANH']);
                }
                $anh = $new_filename;
            } else {
                $error = "Lỗi khi upload ảnh!";
            }
        } else {
            $error = "Chỉ chấp nhận file ảnh (JPEG, PNG, GIF, JPG)!";
        }
    }
    
    $sql = "UPDATE sinhvien SET HOTEN = ?, NGAYSINH = ?, GIOITINH = ?, MALOP = ?, DIACHI = ?, ANH = ? WHERE MASV = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$hoten, $ngaysinh, $gioitinh, $malop, $diachi, $anh, $masv])) {
        header("Location: dssinhvien.php?success=1");
        exit;
    } else {
        $error = "Lỗi khi cập nhật sinh viên!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh viên</title>
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
        .current-image { max-width: 200px; max-height: 200px; margin-bottom: 10px; }
        .image-preview { max-width: 200px; max-height: 200px; margin-top: 10px; }
        .image-container { margin-bottom: 15px; }
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
                <h2 class="mb-4">Sửa Sinh viên</h2>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        Thông tin sinh viên
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="masv" class="form-label">Mã sinh viên</label>
                                    <input type="text" class="form-control" id="masv" value="<?php echo $student['MASV']; ?>" disabled>
                                    <small class="text-muted">Mã sinh viên không thể thay đổi</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hoten" class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" id="hoten" name="hoten" value="<?php echo $student['HOTEN']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ngaysinh" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?php echo $student['NGAYSINH']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gioitinh" class="form-label">Giới tính</label>
                                    <select class="form-select" id="gioitinh" name="gioitinh" required>
                                        <option value="1" <?php echo $student['GIOITINH'] == '1' ? 'selected' : ''; ?>>Nam</option>
                                        <option value="0" <?php echo $student['GIOITINH'] == '0' ? 'selected' : ''; ?>>Nữ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="malop" class="form-label">Lớp</label>
                                    <select class="form-select" id="malop" name="malop" required>
                                        <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class['MALOP']; ?>" <?php echo $class['MALOP'] == $student['MALOP'] ? 'selected' : ''; ?>>
                                            <?php echo $class['TENLOP']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="diachi" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" id="diachi" name="diachi" value="<?php echo $student['DIACHI']; ?>">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="anh" class="form-label">Ảnh đại diện</label>
                                    
                                    <div class="image-container">
                                        <?php if (!empty($student['ANH']) && file_exists('uploads/' . $student['ANH'])): ?>
                                            <div id="currentImageContainer">
                                                <p>Ảnh hiện tại:</p>
                                                <img src="uploads/<?php echo $student['ANH']; ?>" alt="Ảnh hiện tại" class="current-image">
                                            </div>
                                        <?php else: ?>
                                            <div id="currentImageContainer">
                                                <p>Chưa có ảnh đại diện</p>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div id="newImageContainer" style="display: none;">
                                            <p>Ảnh mới:</p>
                                            <img id="imagePreview" class="image-preview" src="#" alt="Preview">
                                        </div>
                                    </div>
                                    
                                    <input type="file" class="form-control" id="anh" name="anh" accept="image/*" onchange="previewImage(this)">
                                    <small class="text-muted">Chọn ảnh mới để thay thế ảnh hiện tại</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="dssinhvien.php" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const currentImageContainer = document.getElementById('currentImageContainer');
            const newImageContainer = document.getElementById('newImageContainer');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    newImageContainer.style.display = 'block';
                    preview.style.display = 'block'; // Đảm bảo ảnh mới hiển thị
                    
                    // Ẩn ảnh cũ khi có ảnh mới
                    if (currentImageContainer) {
                        currentImageContainer.style.display = 'none';
                    }
                }
                
                reader.readAsDataURL(file);
            } else {
                newImageContainer.style.display = 'none';
                preview.style.display = 'none'; // Ẩn ảnh preview
                
                // Hiện lại ảnh cũ nếu không có ảnh mới
                if (currentImageContainer) {
                    currentImageContainer.style.display = 'block';
                }
            }
        }
    </script>
</body>
</html>