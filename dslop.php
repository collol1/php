<?php
    require_once("connect.php");
    $dslop=$conn->query("select*from LOP");
    echo"
    <table border='1' cellspacing=0 cellpadding='10px'>
        <td><a href='index.php'>Trang chủ</a></td>
        <td><a href='themlop.php'>Thêm lớp</a></td>
    </table>";
    echo"
    <table border='1' cellspacing=0 cellpadding='30px'>
        <tr>
            <td>mã lớp</td>
            <td>tên lớp</td>
            <td colspan='2'>chức năng</td>
        </tr>
    ";
    while ($row=$dslop->fetch())
    {
        $malop=$row['MALOP'];
        $tenlop=$row['TENLOP'];
        echo"
        <tr>
            <td>$malop</td>
            <td>$tenlop</td>
            <td><a href='sualop.php?malop=$malop'>Sửa</a></td>
            <td><a href='xoalop.php?malop=$malop' onclick='return confirm(\"bạn có chắc chắn muốn xóa không?\")'>Xóa</a></td>
        </tr>
        ";
    }
    echo"</table>";
?>