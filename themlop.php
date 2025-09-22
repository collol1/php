<?php

require_once("connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $malop = $_POST['malop'];
    $tenlop = $_POST['tenlop'];
    $stmt = $conn->prepare("INSERT INTO LOP (MALOP, TENLOP) VALUES (?, ?)");
    $stmt->execute([$malop, $tenlop]);
    header("Location: dslop.php");
    exit;
}
?>
<h2>Thêm lớp</h2>
<form method="post">
    Mã lớp: <input type="text" name="malop" required><br>
    Tên lớp: <input type="text" name="tenlop" required><br>
    <button type="submit">Thêm</button>
    <a href="dslop.php">Quay lại</a>
</form>