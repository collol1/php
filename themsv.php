<?php

require_once("connect.php");

// Lấy danh sách lớp
$dsLop = $conn->query("SELECT MALOP, TENLOP FROM LOP");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $masv = $_POST['MASV'];
    $tensv = $_POST['HOTENSV'];
    $ngaysinh = $_POST['NGAYSINH'];
    $diachi = $_POST['DIACHI'];
    $malop = $_POST['MALOP'];

    // Xử lý upload ảnh
    $anh = null;
    if (isset($_FILES['ANH']) && $_FILES['ANH']['error'] == 0) {
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $anh = basename($_FILES["ANH"]["name"]);
        $target_file = $target_dir . $anh;
        move_uploaded_file($_FILES["ANH"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("INSERT INTO SINHVIEN (MASV, HOTENSV, NGAYSINH, DIACHI, ANH, MALOP) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$masv, $tensv, $ngaysinh, $diachi, $anh, $malop]);
    header("Location: dssinhvien.php");
    exit;
}
?>
<h2>Thêm sinh viên</h2>
<table border='1' cellpassing=0 cellpadding='10'>
<form method="post" enctype="multipart/form-data">
    <tr><td>Mã sinh viên: </td><td> <input type="text" name="MASV" required></td></tr>
    <tr><td>Tên sinh viên: </td><td><input type="text" name="HOTENSV" required></td></tr>
    <tr><td>Ngày sinh: </td><td><input type="date" name="NGAYSINH" required></td></tr>
    <tr><td>Địa chỉ: </td><td> <input type="text" name="DIACHI" required></td></tr>
    <tr><td>Ảnh: </td><td> <input type="file" name="ANH" required></td></tr>
    <tr><td>Lớp: </td><td>
    <select name="MALOP" required>
        <option value="">--Chọn lớp--</option>
        <?php while ($row = $dsLop->fetch()) { ?>
            <option value="<?php echo $row['MALOP']; ?>"><?php echo $row['TENLOP']; ?></option>
        <?php } ?>
    </select></td></tr>
    <button type="submit">Thêm</button>
    <button><a href="dssinhvien.php">Quay lại</a></button>
</form>
</table>