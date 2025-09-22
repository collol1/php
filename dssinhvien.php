<?php
    require_once("connect.php");

    // Lấy danh sách sinh viên kèm tên lớp
    $dslop = $conn->query("SELECT SV.*, L.TENLOP FROM SINHVIEN SV LEFT JOIN LOP L ON SV.MALOP = L.MALOP");

    echo "
    <table border='1' cellspacing=0 cellpadding='10px'>
        <td><a href='themsv.php'>Thêm sinh viên</a></td>
        <td><a href='index.php'>Trang chủ</a></td>
    </table>";
    echo "
    <table border='1' cellspacing=0 cellpadding='10px'>
        <tr>
            <td>Mã sinh viên</td>
            <td>Tên sinh viên</td>
            <td>Ngày sinh</td>
            <td>Địa chỉ</td>
            <td>Ảnh</td>
            <td>Lớp</td>
            <td colspan='2'>Chức năng</td>
        </tr>
    ";
    while ($row = $dslop->fetch()) {
        $masv = $row['MASV'];
        $tensv = $row['HOTENSV'];
        $diachi = $row['DIACHI'];
        $ngaysinh = $row['NGAYSINH'];
        $anh = $row['ANH'];
        $malop = $row['MALOP'];
        $tenlop = $row['TENLOP'];

        echo "
        <tr>
            <td>$masv</td>
            <td>$tensv</td>
            <td>$ngaysinh</td>
            <td>$diachi</td>
            <td>";
        if ($anh) {
            echo "<img src='images/$anh' width='100px'/>";
        } else {
            echo "Không có ảnh";
        }
        echo "</td>
            <td><a href='dslop.php?lop=$malop'>$tenlop</a></td>
            <td><a href='suasv.php?MASV=$masv'>Sửa</a></td>
            <td><a href='xoasv.php?MASV=$masv' onclick='return confirm(\"bạn có chắc chắn muốn xóa không?\")'>Xóa</a></td>
        </tr>
        ";
    }
    echo "</table>";
?>