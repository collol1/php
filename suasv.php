<?php

require_once("connect.php");
if (!isset($_GET['MASV'])) {
    header("Location: dssinhvien.php");
    exit;
}
$masv = $_GET['MASV'];
$dsLop = $conn->query("SELECT MALOP, TENLOP FROM LOP");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tensv = $_POST['HOTENSV'];
    $ngaysinh = $_POST['NGAYSINH'];
    $diachi = $_POST['DIACHI'];
    $malop = $_POST['MALOP'];
    $anh = $_POST['ANH_OLD'];
    if (isset($_FILES['ANH']) && $_FILES['ANH']['error'] == 0) {
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $anh = basename($_FILES["ANH"]["name"]);
        $target_file = $target_dir . $anh;
        move_uploaded_file($_FILES["ANH"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("UPDATE SINHVIEN SET HOTENSV = ?, NGAYSINH = ?, DIACHI = ?, ANH = ?, MALOP = ? WHERE MASV = ?");
    $stmt->execute([$tensv, $ngaysinh, $diachi, $anh, $malop, $masv]);
    header("Location: dssinhvien.php");
    exit;
}
$stmt = $conn->prepare("SELECT * FROM SINHVIEN WHERE MASV = ?");
$stmt->execute([$masv]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "Không tìm thấy sinh viên!";
    exit;
}
?>
<h2>Sửa sinh viên</h2>
<form method="post" enctype="multipart/form-data">
    Mã sinh viên: <input type="text" name="MASV" value="<?php echo htmlspecialchars($row['MASV']); ?>" readonly><br>
    Tên sinh viên: <input type="text" name="HOTENSV" value="<?php echo htmlspecialchars($row['HOTENSV']); ?>" required><br>
    Ngày sinh: <input type="date" name="NGAYSINH" value="<?php echo htmlspecialchars($row['NGAYSINH']); ?>" required><br>
    Địa chỉ: <input type="text" name="DIACHI" value="<?php echo htmlspecialchars($row['DIACHI']); ?>" required><br>
    Ảnh hiện tại: 
    <?php if ($row['ANH']) { ?>
        <img src="images/<?php echo htmlspecialchars($row['ANH']); ?>" width="100px" id="currentImage"><br>
    <?php } else { echo "Không có ảnh<br>"; } ?>
    Ảnh mới: <input type="file" name="ANH" id="ANH" accept="image/*"><br>
    <div id="newImagePreview" style="display:none;">
        <p>Ảnh mới:</p>
        <img id="preview" src="#" alt="Ảnh mới" width="100px">
    </div>
    <input type="hidden" name="ANH_OLD" value="<?php echo htmlspecialchars($row['ANH']); ?>">
    Lớp: 
    <select name="MALOP" required>
        <option value="">--Chọn lớp--</option>
        <?php
        $dsLop = $conn->query("SELECT MALOP, TENLOP FROM LOP");
        while ($lop = $dsLop->fetch()) { ?>
            <option value="<?php echo $lop['MALOP']; ?>" <?php if ($row['MALOP'] == $lop['MALOP']) echo 'selected'; ?>>
                <?php echo $lop['TENLOP']; ?>
            </option>
        <?php } ?>
    </select><br>
    <button type="submit">Cập nhật</button>
    <a href="dssinhvien.php">Quay lại</a>
</form>

<script>
document.getElementById('ANH').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('newImagePreview');
    const preview = document.getElementById('preview');
    const currentImage = document.getElementById('currentImage');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
            
            // Ẩn ảnh cũ đi khi có ảnh mới
            if (currentImage) {
                currentImage.style.display = 'none';
            }
        }
        
        reader.readAsDataURL(this.files[0]);
    } else {
        previewContainer.style.display = 'none';
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    }
});
</script>