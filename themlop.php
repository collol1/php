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
<table border='1' cellspacing=0 cellpadding='10px'>
<form method="post">
    <tr><td>Mã lớp: </td><td> <input type="text" name="malop" required></td></tr>
    <tr><td>Tên lớp: </td><td> <input type="text" name="tenlop" required></td></tr>
    <button type="submit">Thêm</button>
    <button><a href="dslop.php">Quay lại</a> </button>
</form>
</table>