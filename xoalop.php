<?php
require_once("connect.php");
if (isset($_GET['malop'])) {
    $malop = $_GET['malop'];
    $stmt = $conn->prepare("DELETE FROM LOP WHERE MALOP = ?");
    $stmt->execute([$malop]);
}
header("Location: dslop.php");
exit;
?>