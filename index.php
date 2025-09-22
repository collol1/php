<?php
require_once("connect.php");

    // Lấy danh sách sinh viên kèm tên lớp
    $dslop = $conn->query("SELECT SV.*, L.TENLOP FROM SINHVIEN SV LEFT JOIN LOP L ON SV.MALOP = L.MALOP");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav ul { list-style-type: none; padding: 0; }
        nav ul li { display: inline; margin-right: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 100px; height: auto; }
    </style>
</head>
<body>
    <h1>Quản Lý Sinh Viên</h1>
    <nav>
        <ul>
            <li><a href="dssinhvien.php">Danh sách sinh viên</a></li>
            <li><a href="dslop.php">Danh sách lớp</a></li>
            <li><a href="themsv.php">Thêm sinh viên</a></li>
        </ul>
    </nav>
    <p>Chào mừng bạn đến với hệ thống quản lý sinh viên.</p>
    <div>
        <h2> Sinh viên</h2>
        <table>
            <tr>
                <th>Mã sinh viên</th>
                <th>Tên sinh viên</th>
                <th>Lớp</th>
            </tr>
            <?php while ($row = $dslop->fetch()) { ?>
                <tr>
                    <td><?php echo $row['MASV']; ?></td>
                    <td><?php echo $row['HOTENSV']; ?></td>
                    <td><?php echo $row['TENLOP']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>