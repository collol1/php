-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 24, 2025 lúc 10:37 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlysinhvien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ketqua`
--

CREATE TABLE `ketqua` (
  `MAKQ` varchar(10) NOT NULL,
  `MASV` varchar(10) DEFAULT NULL,
  `MAMH` varchar(10) DEFAULT NULL,
  `DIEM` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ketqua`
--

INSERT INTO `ketqua` (`MAKQ`, `MASV`, `MAMH`, `DIEM`) VALUES
('', '2210900000', NULL, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `MALOP` varchar(10) NOT NULL,
  `TENLOP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`MALOP`, `TENLOP`) VALUES
('001', 'công nghe thông tin'),
('003', 'kinh tế'),
('009', 'ccaaaa'),
('010', 'ccca'),
('011', 'bá');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monhoc`
--

CREATE TABLE `monhoc` (
  `MAMH` varchar(10) NOT NULL,
  `TENMH` varchar(50) NOT NULL,
  `SOTINCHI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `monhoc`
--

INSERT INTO `monhoc` (`MAMH`, `TENMH`, `SOTINCHI`) VALUES
('1', 'toán', 3),
('2', 'vắn', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinhvien`
--

CREATE TABLE `sinhvien` (
  `MASV` varchar(10) NOT NULL,
  `HOTEN` varchar(50) NOT NULL,
  `NGAYSINH` date DEFAULT NULL,
  `GIOITINH` varchar(5) DEFAULT NULL,
  `MALOP` varchar(10) DEFAULT NULL,
  `DIACHI` varchar(10) DEFAULT NULL,
  `ANH` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sinhvien`
--

INSERT INTO `sinhvien` (`MASV`, `HOTEN`, `NGAYSINH`, `GIOITINH`, `MALOP`, `DIACHI`, `ANH`) VALUES
('2210900000', 'bơi cao', '2025-09-23', '1', '010', '111', 'orwell.jpg'),
('2210900001', 'nguyễn văn huỳnh', '2025-09-24', '1', '001', '114', 'tokuda-1.jpg'),
('2210900003', 'bơi cao đá', '2025-09-11', '0', '009', '114', 'nguyen-ngoc-tu.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ketqua`
--
ALTER TABLE `ketqua`
  ADD PRIMARY KEY (`MAKQ`),
  ADD KEY `MASV` (`MASV`),
  ADD KEY `MAMH` (`MAMH`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`MALOP`);

--
-- Chỉ mục cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD PRIMARY KEY (`MAMH`);

--
-- Chỉ mục cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`MASV`),
  ADD KEY `MALOP` (`MALOP`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `ketqua`
--
ALTER TABLE `ketqua`
  ADD CONSTRAINT `ketqua_ibfk_1` FOREIGN KEY (`MASV`) REFERENCES `sinhvien` (`MASV`),
  ADD CONSTRAINT `ketqua_ibfk_2` FOREIGN KEY (`MAMH`) REFERENCES `monhoc` (`MAMH`);

--
-- Các ràng buộc cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD CONSTRAINT `sinhvien_ibfk_1` FOREIGN KEY (`MALOP`) REFERENCES `lop` (`MALOP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
