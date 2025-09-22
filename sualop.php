<?php
require_once("connect.php");
if (!isset($_GET['malop'])) {
    header("Location: dslop.php");
    exit;
}
$malop = $_GET['malop'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenlop = $_POST['tenlop'];
    $stmt = $conn->prepare("UPDATE LOP SET TENLOP = ? WHERE MALOP = ?");
    $stmt->execute([$tenlop, $malop]);
    header("Location: dslop.php");
    exit;
}
$stmt = $conn->prepare("SELECT * FROM LOP WHERE MALOP = ?");
$stmt->execute([$malop]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "Không tìm thấy lớp!";
    exit;
}
?>
<h2>Sửa lớp</h2>
<form method="post">
    Mã lớp: <input type="text" name="malop" value="<?php echo htmlspecialchars($row['MALOP']); ?>" readonly><br>
    Tên lớp: <input type="text" name="tenlop" value="<?php echo htmlspecialchars($row['TENLOP']); ?>" required><br>
    <button type="submit">Cập nhật</button>
    <a href="dslop.php">Quay lại</a>
</form>