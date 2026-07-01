-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 30, 2026 lúc 03:16 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `restaurantqrmanagement`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `CustomerPhone` varchar(20) NOT NULL,
  `BranchName` varchar(200) NOT NULL,
  `BookingDate` date NOT NULL,
  `BookingTime` time NOT NULL,
  `GuestCount` int(11) NOT NULL,
  `Note` text DEFAULT NULL,
  `Status` enum('Pending','Confirmed','Cancelled','Arrived') DEFAULT 'Pending',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`BookingID`, `CustomerName`, `CustomerPhone`, `BranchName`, `BookingDate`, `BookingTime`, `GuestCount`, `Note`, `Status`, `CreatedAt`) VALUES
(1, 'Hn', '023837253', 'WuYang Giảng Võ', '2026-04-09', '22:46:00', 2, '', 'Arrived', '2026-04-17 15:45:07'),
(2, 'hn', '0393293422', 'WuYang Aeon Mall Long Biên', '2026-05-01', '17:30:00', 2, 'khong', 'Arrived', '2026-04-19 07:30:13'),
(3, 'Vu Huy N', '0393293423', 'WuYang Giảng Võ', '2026-04-20', '18:30:00', 4, 'sinh nhật', 'Cancelled', '2026-04-19 08:27:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `DisplayOrder` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`, `DisplayOrder`) VALUES
(1, 'Lẩu', 1),
(2, 'Heo', 2),
(5, 'Bò', 4),
(6, 'Cừu', 3),
(7, 'Nội tạng', 5),
(8, 'Hải sản', 6),
(9, 'Rau & nấm', 8),
(10, 'Há cảo & sủi ', 7),
(11, 'Mỳ', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedbacks`
--

CREATE TABLE `feedbacks` (
  `FeedbackID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `Comment` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `feedbacks`
--

INSERT INTO `feedbacks` (`FeedbackID`, `OrderID`, `Rating`, `Comment`, `CreatedAt`) VALUES
(1, 70, 5, 'tót', '2026-03-16 07:37:42'),
(2, 73, 5, 'no no', '2026-03-16 07:49:22'),
(3, 77, 5, 'tot', '2026-03-17 08:21:29'),
(4, 81, 5, 'dc', '2026-03-17 08:45:26'),
(5, 91, 5, 'tốt', '2026-03-20 15:45:44'),
(6, 93, 5, '', '2026-03-20 15:47:42'),
(7, 95, 5, '', '2026-03-20 15:48:09'),
(8, 100, 5, '', '2026-03-20 15:54:51'),
(9, 102, 5, '', '2026-03-20 15:57:14'),
(10, 106, 5, 'tốt', '2026-03-20 16:05:57'),
(11, 109, 5, 'dc', '2026-03-23 07:04:35'),
(12, 111, 5, 'fd', '2026-03-23 07:49:45'),
(13, 115, 5, 'verry good\n', '2026-03-23 13:37:41'),
(14, 117, 5, 'dc vcl', '2026-03-23 13:40:37'),
(15, 127, 5, 'dc', '2026-03-23 14:54:11'),
(16, 131, 5, 'ổn', '2026-03-24 07:22:01'),
(17, 133, 5, 'cung on\n', '2026-03-24 07:41:28'),
(18, 135, 5, 'dc', '2026-03-25 04:01:09'),
(19, 137, 5, 'dc', '2026-03-25 14:44:14'),
(20, 139, 3, 'tam duoc', '2026-04-01 08:28:48'),
(21, 141, 4, 'tạm dc', '2026-04-02 03:37:03'),
(22, 144, 5, 'on', '2026-04-17 15:01:49'),
(23, 151, 5, 'dc', '2026-04-19 07:10:48'),
(24, 153, 5, 'tot', '2026-04-19 08:31:26'),
(25, 155, 5, 'Như cứt', '2026-05-05 15:12:39'),
(26, 158, 1, 'như cứt', '2026-05-08 15:41:14'),
(27, 161, 5, '', '2026-05-08 16:18:59'),
(35, 163, 5, 'như cứt', '2026-05-08 16:24:06'),
(39, 165, 5, 'như cứt\n', '2026-05-08 16:25:20'),
(40, 172, 5, '', '2026-05-08 16:42:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `IngredientName` varchar(200) NOT NULL,
  `StockQuantity` decimal(18,2) NOT NULL,
  `Unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `IngredientName`, `StockQuantity`, `Unit`) VALUES
(1, 'Thịt bò', 16.00, 'kg'),
(2, 'Cá', 20.00, 'kg'),
(3, 'Thịt gà', 8.00, 'kg'),
(4, 'Gà', 11.00, 'kg'),
(5, 'Gà', 0.00, 'kg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `NotificationID` int(10) UNSIGNED NOT NULL,
  `TableID` int(10) UNSIGNED NOT NULL,
  `Message` varchar(255) NOT NULL,
  `Type` varchar(50) NOT NULL DEFAULT 'service_request',
  `IsRead` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`NotificationID`, `TableID`, `Message`, `Type`, `IsRead`, `CreatedAt`) VALUES
(1, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-03-14 23:23:10'),
(2, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 1, '2026-03-14 23:27:29'),
(3, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-14 23:38:05'),
(4, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-14 23:39:57'),
(5, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-14 23:40:13'),
(6, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-03-14 23:45:37'),
(7, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:06:59'),
(8, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:09:42'),
(9, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:16:52'),
(10, 2, 'Khách bàn 2 yêu cầu thêm đá.', 'service_request', 1, '2026-03-16 14:20:04'),
(11, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:20:23'),
(12, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:30:35'),
(13, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:31:05'),
(14, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:31:26'),
(15, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:35:18'),
(16, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:35:44'),
(17, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:35:54'),
(18, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:36:07'),
(19, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:36:26'),
(20, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:36:47'),
(21, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:37:30'),
(22, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-03-16 14:49:01'),
(23, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 1, '2026-03-16 14:49:04'),
(24, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-16 14:49:13'),
(25, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-17 15:21:23'),
(26, 1, 'Khách bàn 1 yêu cầu thêm khăn lạnh.', 'service_request', 1, '2026-03-17 15:45:05'),
(27, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-17 15:45:20'),
(28, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 22:45:35'),
(29, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 22:47:39'),
(30, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 22:48:05'),
(31, 6, 'Khách bàn 6 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 22:54:47'),
(32, 7, 'Khách bàn 7 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 22:56:51'),
(33, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 23:00:19'),
(34, 9, 'Khách bàn 9 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-20 23:05:40'),
(35, 9, 'Khách bàn 9 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-20 23:05:45'),
(36, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-03-20 23:29:47'),
(37, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-23 14:04:29'),
(38, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-23 14:04:31'),
(39, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-23 14:49:39'),
(40, 2, 'Khách bàn 2 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-23 14:49:41'),
(41, 2, 'Khách bàn 2 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 1, '2026-03-23 20:36:25'),
(42, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-23 20:37:29'),
(43, 2, 'Khách bàn 2 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-23 20:37:30'),
(44, 5, 'Khách bàn 5 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 1, '2026-03-23 20:39:35'),
(45, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-23 20:40:21'),
(46, 5, 'Khách bàn 5 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-23 20:40:24'),
(47, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-23 21:54:03'),
(48, 2, 'Khách bàn 2 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-23 21:54:05'),
(49, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-03-24 14:21:08'),
(50, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-24 14:21:28'),
(51, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-24 14:21:33'),
(52, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-03-24 14:39:44'),
(53, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-24 14:41:19'),
(54, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-24 14:41:21'),
(55, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 1, '2026-03-25 10:58:27'),
(56, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-25 11:00:42'),
(57, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-25 11:00:45'),
(58, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-03-25 21:44:08'),
(59, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-03-25 21:44:10'),
(60, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-04-01 15:26:01'),
(61, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-04-01 15:27:19'),
(62, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-04-01 15:27:21'),
(63, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-04-02 10:34:30'),
(64, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 1, '2026-04-02 10:34:31'),
(65, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-04-02 10:36:36'),
(66, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-04-02 10:36:42'),
(67, 10, 'Khách bàn 10 yêu cầu thanh toán.', 'checkout_request', 1, '2026-04-17 21:57:30'),
(68, 10, 'Khách bàn 10 yêu cầu thanh toán.', 'checkout_request', 1, '2026-04-17 22:01:31'),
(69, 10, 'Khách bàn 10 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-04-17 22:01:33'),
(70, 5, 'Khách bàn 5 yêu cầu thêm đá.', 'service_request', 1, '2026-04-19 14:08:40'),
(71, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 1, '2026-04-19 14:10:42'),
(72, 5, 'Khách bàn 5 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-04-19 14:10:44'),
(73, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 1, '2026-04-19 15:27:58'),
(74, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 1, '2026-04-19 15:31:20'),
(75, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-04-19 15:31:21'),
(76, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-05 22:10:23'),
(77, 1, 'Khách bàn 1 yêu cầu thêm khăn lạnh.', 'service_request', 0, '2026-05-05 22:10:24'),
(78, 1, 'Khách bàn 1 yêu cầu thêm khăn lạnh.', 'service_request', 0, '2026-05-05 22:10:27'),
(79, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-05 22:12:25'),
(80, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-05 22:12:31'),
(81, 2, 'Khách bàn 2 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 22:38:25'),
(82, 2, 'Khách bàn 2 gửi yêu cầu dịch vụ: Gọi phục vụ.', 'service_request', 0, '2026-05-08 22:38:36'),
(83, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 1, '2026-05-08 22:40:14'),
(84, 2, 'Khách bàn 2 yêu cầu thêm khăn lạnh.', 'service_request', 1, '2026-05-08 22:40:27'),
(85, 2, 'Khách bàn 2 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 22:40:51'),
(86, 2, 'Khách bàn 2 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 1, '2026-05-08 22:40:52'),
(87, 5, 'Khách bàn 5 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 22:55:30'),
(88, 2, 'Khách bàn 2 yêu cầu gặp nhân viên.', 'service_request', 0, '2026-05-08 22:56:24'),
(89, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:18:53'),
(90, 5, 'Khách bàn 5 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-08 23:18:56'),
(91, 5, 'Khách bàn 5 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:19:51'),
(92, 5, 'Khách bàn 5 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-08 23:19:52'),
(93, 7, 'Khách bàn 7 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:22:37'),
(94, 7, 'Khách bàn 7 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:22:48'),
(95, 7, 'Khách bàn 7 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:22:54'),
(96, 7, 'Khách bàn 7 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-08 23:22:56'),
(97, 7, 'Khách bàn 7 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:24:13'),
(98, 7, 'Khách bàn 7 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-08 23:24:13'),
(99, 6, 'Khách bàn 6 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:25:14'),
(100, 6, 'Khách bàn 6 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-08 23:25:14'),
(101, 1, 'Khách bàn 1 yêu cầu thanh toán.', 'checkout_request', 0, '2026-05-08 23:42:03'),
(102, 1, 'Khách bàn 1 gửi yêu cầu dịch vụ: Yêu cầu thanh toán.', 'service_request', 0, '2026-05-08 23:42:03'),
(103, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 23:47:37'),
(104, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 23:47:42'),
(105, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 23:47:46'),
(106, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 23:47:46'),
(107, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 23:47:46'),
(108, 1, 'Khách bàn 1 yêu cầu thêm đá.', 'service_request', 0, '2026-05-08 23:47:47'),
(109, 1, 'Khách bàn 1 yêu cầu thêm khăn lạnh.', 'service_request', 0, '2026-05-08 23:47:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderitems`
--

CREATE TABLE `orderitems` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `PriceAtTime` decimal(18,2) NOT NULL,
  `ItemStatus` enum('Waiting','Cooking','Served') DEFAULT 'Waiting',
  `Note` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orderitems`
--

INSERT INTO `orderitems` (`OrderItemID`, `OrderID`, `ProductID`, `Quantity`, `PriceAtTime`, `ItemStatus`, `Note`, `CreatedAt`) VALUES
(1, 34, 1, 1, 500000.00, 'Waiting', NULL, '2026-03-14 16:04:46'),
(2, 35, 1, 3, 500000.00, 'Waiting', NULL, '2026-03-14 16:11:06'),
(3, 36, 1, 1, 500000.00, 'Waiting', NULL, '2026-03-14 16:19:16'),
(4, 37, 1, 3, 500000.00, 'Waiting', NULL, '2026-03-14 16:19:22'),
(5, 39, 1, 1, 500000.00, 'Waiting', NULL, '2026-03-14 16:39:49'),
(6, 42, 1, 3, 500000.00, 'Waiting', NULL, '2026-03-14 16:57:07'),
(7, 43, 1, 1, 500000.00, 'Waiting', NULL, '2026-03-14 16:59:29'),
(8, 44, 1, 1, 500000.00, 'Waiting', NULL, '2026-03-14 17:00:37'),
(9, 45, 1, 1, 500000.00, 'Waiting', 'hs', '2026-03-14 17:03:04'),
(10, 49, 1, 1, 500000.00, 'Waiting', 's', '2026-03-14 17:16:20'),
(11, 50, 1, 1, 500000.00, 'Waiting', '', '2026-03-14 17:18:26'),
(12, 52, 1, 1, 500000.00, 'Waiting', '', '2026-03-14 17:18:52'),
(13, 54, 1, 1, 500000.00, 'Waiting', '', '2026-03-14 17:20:43'),
(14, 55, 1, 1, 500000.00, 'Waiting', '', '2026-03-14 17:21:01'),
(15, 57, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:06:53'),
(16, 58, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:16:49'),
(17, 60, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:20:00'),
(18, 62, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:31:00'),
(19, 64, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:35:40'),
(20, 65, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:36:03'),
(21, 66, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:36:23'),
(22, 68, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:37:12'),
(23, 69, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:37:21'),
(24, 70, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:37:27'),
(25, 72, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:48:53'),
(26, 73, 1, 1, 500000.00, 'Waiting', '', '2026-03-16 07:48:58'),
(27, 77, 1, 1, 500000.00, 'Waiting', '', '2026-03-17 08:20:59'),
(28, 79, 1, 1, 500000.00, 'Waiting', '', '2026-03-17 08:22:11'),
(29, 80, 1, 1, 500000.00, 'Waiting', '', '2026-03-17 08:41:26'),
(30, 81, 1, 1, 500000.00, 'Waiting', '', '2026-03-17 08:45:10'),
(31, 85, 1, 1, 500000.00, 'Served', '', '2026-03-17 09:01:11'),
(32, 86, 1, 1, 500000.00, 'Served', '', '2026-03-17 09:01:25'),
(33, 87, 1, 1, 500000.00, 'Served', '', '2026-03-17 09:05:35'),
(34, 91, 1, 8, 500000.00, 'Served', 'cay', '2026-03-20 15:43:56'),
(35, 93, 1, 2, 500000.00, 'Waiting', '', '2026-03-20 15:47:29'),
(36, 95, 1, 1, 500000.00, 'Waiting', '', '2026-03-20 15:48:03'),
(37, 97, 1, 1, 500000.00, 'Waiting', '', '2026-03-20 15:50:14'),
(38, 100, 1, 1, 500000.00, 'Waiting', '', '2026-03-20 15:54:31'),
(39, 102, 1, 1, 500000.00, 'Waiting', '', '2026-03-20 15:56:25'),
(40, 104, 1, 1, 500000.00, 'Waiting', '', '2026-03-20 16:00:11'),
(41, 106, 1, 1, 500000.00, 'Waiting', '', '2026-03-20 16:05:37'),
(42, 109, 1, 1, 500000.00, 'Waiting', '', '2026-03-23 07:04:26'),
(43, 111, 1, 61, 500000.00, 'Waiting', '', '2026-03-23 07:49:36'),
(44, 113, 1, 2, 500000.00, 'Served', 'ít cay', '2026-03-23 13:33:19'),
(45, 115, 1, 2, 500000.00, 'Served', 'ít cay ', '2026-03-23 13:35:59'),
(46, 117, 1, 2, 500000.00, 'Served', 'max cay', '2026-03-23 13:38:58'),
(47, 119, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:25:26'),
(48, 120, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:26:07'),
(49, 121, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:26:42'),
(50, 122, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:30:56'),
(51, 123, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:32:10'),
(52, 124, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:46:45'),
(53, 127, 1, 1, 550000.00, 'Waiting', '', '2026-03-23 14:53:51'),
(54, 131, 4, 1, 160000.00, 'Served', 'cay', '2026-03-24 07:19:54'),
(55, 131, 1, 1, 59000.00, 'Served', '', '2026-03-24 07:19:54'),
(56, 133, 5, 1, 150000.00, 'Served', '', '2026-03-24 07:39:55'),
(57, 133, 1, 1, 59000.00, 'Served', '', '2026-03-24 07:39:55'),
(58, 133, 6, 1, 79000.00, 'Served', '', '2026-03-24 07:39:55'),
(59, 133, 12, 1, 649000.00, 'Served', '', '2026-03-24 07:39:55'),
(60, 133, 13, 1, 79000.00, 'Served', '', '2026-03-24 07:39:55'),
(61, 135, 5, 1, 150000.00, 'Served', 'ist cay', '2026-03-25 03:58:52'),
(62, 135, 4, 1, 160000.00, 'Served', '', '2026-03-25 03:58:52'),
(63, 137, 5, 1, 150000.00, 'Waiting', '', '2026-03-25 14:40:48'),
(64, 137, 6, 1, 79000.00, 'Waiting', '', '2026-03-25 14:40:48'),
(65, 139, 5, 1, 150000.00, 'Served', 'khong', '2026-04-01 08:26:16'),
(66, 139, 8, 1, 49000.00, 'Served', '', '2026-04-01 08:26:16'),
(67, 139, 10, 1, 179000.00, 'Served', '', '2026-04-01 08:26:16'),
(68, 141, 5, 1, 150000.00, 'Served', 'không cay', '2026-04-02 03:34:53'),
(69, 141, 7, 1, 99000.00, 'Served', '', '2026-04-02 03:34:53'),
(70, 144, 5, 1, 150000.00, 'Served', '', '2026-04-17 14:59:48'),
(71, 146, 3, 1, 99000.00, 'Served', '', '2026-04-17 15:21:35'),
(72, 147, 7, 2, 99000.00, 'Served', '', '2026-04-17 15:25:20'),
(73, 151, 5, 1, 150000.00, 'Served', '', '2026-04-19 07:08:57'),
(74, 151, 4, 1, 160000.00, 'Served', '', '2026-04-19 07:08:57'),
(75, 153, 5, 1, 150000.00, 'Served', 'cay', '2026-04-19 08:28:11'),
(76, 153, 4, 1, 160000.00, 'Served', '', '2026-04-19 08:28:11'),
(77, 155, 13, 1, 79000.00, 'Served', 'cho ít thôi', '2026-05-05 15:10:30'),
(78, 155, 14, 1, 39000.00, 'Served', 'ít cay', '2026-05-05 15:10:30'),
(79, 155, 16, 1, 199000.00, 'Served', '', '2026-05-05 15:10:30'),
(80, 158, 4, 1, 160000.00, 'Served', '', '2026-05-08 15:38:41'),
(81, 158, 3, 1, 99000.00, 'Served', 'mixi', '2026-05-08 15:38:41'),
(82, 161, 8, 1, 49000.00, 'Waiting', '', '2026-05-08 16:18:52'),
(83, 161, 9, 1, 249000.00, 'Waiting', '', '2026-05-08 16:18:52'),
(84, 161, 6, 1, 79000.00, 'Waiting', '', '2026-05-08 16:18:52'),
(85, 163, 8, 2, 49000.00, 'Waiting', '', '2026-05-08 16:22:53'),
(86, 163, 3, 3, 99000.00, 'Waiting', '', '2026-05-08 16:22:53'),
(87, 163, 4, 2, 160000.00, 'Waiting', '', '2026-05-08 16:22:53'),
(88, 165, 3, 1, 99000.00, 'Waiting', '', '2026-05-08 16:25:08'),
(89, 165, 8, 3, 49000.00, 'Waiting', '', '2026-05-08 16:25:08'),
(90, 172, 5, 1, 150000.00, 'Waiting', '', '2026-05-08 16:42:02'),
(91, 172, 4, 1, 160000.00, 'Waiting', '', '2026-05-08 16:42:02'),
(92, 172, 3, 1, 99000.00, 'Waiting', '', '2026-05-08 16:42:02'),
(93, 174, 27, 1, 39000.00, 'Waiting', '', '2026-05-09 08:34:44'),
(94, 174, 26, 1, 19000.00, 'Waiting', '', '2026-05-09 08:34:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `TableID` int(11) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `TotalAmount` decimal(18,2) DEFAULT 0.00,
  `Status` enum('Pending','Paid','Cancelled') DEFAULT 'Pending',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `PaidAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`OrderID`, `TableID`, `StaffID`, `TotalAmount`, `Status`, `CreatedAt`, `PaidAt`) VALUES
(13, 1, NULL, 0.00, 'Paid', '2026-03-13 16:40:38', NULL),
(14, 2, NULL, 0.00, 'Paid', '2026-03-13 16:41:28', NULL),
(15, 1, NULL, 0.00, 'Paid', '2026-03-13 16:50:06', NULL),
(16, 2, NULL, 0.00, 'Paid', '2026-03-13 16:54:52', NULL),
(17, 1, NULL, 0.00, 'Paid', '2026-03-13 17:04:07', NULL),
(18, 2, NULL, 0.00, 'Paid', '2026-03-13 17:05:37', NULL),
(19, 2, NULL, 0.00, 'Paid', '2026-03-14 15:02:53', NULL),
(20, 5, NULL, 0.00, 'Paid', '2026-03-14 15:25:54', NULL),
(26, 6, NULL, 0.00, 'Paid', '2026-03-14 15:47:56', NULL),
(31, 1, NULL, 0.00, 'Paid', '2026-03-14 15:58:07', NULL),
(34, 1, NULL, 0.00, 'Paid', '2026-03-14 16:04:46', NULL),
(35, 1, NULL, 0.00, 'Paid', '2026-03-14 16:11:06', NULL),
(36, 1, NULL, 0.00, 'Paid', '2026-03-14 16:19:16', NULL),
(37, 1, NULL, 0.00, 'Paid', '2026-03-14 16:19:22', NULL),
(38, 1, NULL, 0.00, 'Paid', '2026-03-14 16:39:42', NULL),
(39, 1, NULL, 0.00, 'Paid', '2026-03-14 16:39:49', '2026-03-14 23:41:39'),
(40, 1, NULL, 0.00, 'Paid', '2026-03-14 16:45:27', NULL),
(41, 2, NULL, 0.00, 'Paid', '2026-03-14 16:56:07', NULL),
(42, 2, NULL, 0.00, 'Paid', '2026-03-14 16:57:07', NULL),
(43, 1, NULL, 0.00, 'Paid', '2026-03-14 16:59:29', NULL),
(44, 1, NULL, 0.00, 'Paid', '2026-03-14 17:00:37', NULL),
(45, 2, NULL, 0.00, 'Paid', '2026-03-14 17:03:04', NULL),
(46, 2, NULL, 0.00, 'Paid', '2026-03-14 17:12:10', NULL),
(47, 2, NULL, 0.00, 'Paid', '2026-03-14 17:12:44', NULL),
(48, 1, NULL, 0.00, 'Paid', '2026-03-14 17:16:10', NULL),
(49, 1, NULL, 0.00, 'Paid', '2026-03-14 17:16:20', NULL),
(50, 1, NULL, 0.00, 'Paid', '2026-03-14 17:18:26', NULL),
(51, 1, NULL, 0.00, 'Paid', '2026-03-14 17:18:47', NULL),
(52, 1, NULL, 0.00, 'Paid', '2026-03-14 17:18:52', NULL),
(53, 1, NULL, 0.00, 'Paid', '2026-03-14 17:20:36', NULL),
(54, 1, NULL, 0.00, 'Paid', '2026-03-14 17:20:43', NULL),
(55, 1, NULL, 0.00, 'Paid', '2026-03-14 17:21:01', NULL),
(56, 1, NULL, 0.00, 'Paid', '2026-03-16 07:06:33', '2026-03-16 14:09:51'),
(57, 1, NULL, 0.00, 'Paid', '2026-03-16 07:06:53', '2026-03-16 14:07:15'),
(58, 1, NULL, 0.00, 'Paid', '2026-03-16 07:16:49', '2026-03-16 14:16:57'),
(59, 2, NULL, 0.00, 'Paid', '2026-03-16 07:19:54', '2026-03-16 14:30:36'),
(60, 2, NULL, 0.00, 'Paid', '2026-03-16 07:20:00', '2026-03-16 14:20:30'),
(61, 5, NULL, 0.00, 'Paid', '2026-03-16 07:30:55', '2026-03-16 14:31:28'),
(62, 5, NULL, 0.00, 'Paid', '2026-03-16 07:31:00', '2026-03-16 14:31:07'),
(63, 2, NULL, 0.00, 'Paid', '2026-03-16 07:35:35', NULL),
(64, 2, NULL, 0.00, 'Paid', '2026-03-16 07:35:40', '2026-03-16 14:35:46'),
(65, 2, NULL, 0.00, 'Paid', '2026-03-16 07:36:03', NULL),
(66, 2, NULL, 0.00, 'Paid', '2026-03-16 07:36:23', NULL),
(67, 5, NULL, 0.00, 'Paid', '2026-03-16 07:37:07', NULL),
(68, 5, NULL, 0.00, 'Paid', '2026-03-16 07:37:12', NULL),
(69, 5, NULL, 0.00, 'Paid', '2026-03-16 07:37:21', NULL),
(70, 5, NULL, 0.00, 'Paid', '2026-03-16 07:37:27', '2026-03-16 14:37:37'),
(71, 1, NULL, 0.00, 'Paid', '2026-03-16 07:48:46', NULL),
(72, 1, NULL, 0.00, 'Paid', '2026-03-16 07:48:53', NULL),
(73, 1, NULL, 0.00, 'Paid', '2026-03-16 07:48:58', '2026-03-16 14:49:17'),
(74, 1, NULL, 0.00, 'Paid', '2026-03-16 09:38:32', NULL),
(75, 2, NULL, 0.00, 'Paid', '2026-03-17 08:15:04', NULL),
(76, 1, NULL, 0.00, 'Paid', '2026-03-17 08:20:52', NULL),
(77, 1, NULL, 0.00, 'Paid', '2026-03-17 08:20:59', '2026-03-17 15:21:24'),
(78, 1, NULL, 0.00, 'Paid', '2026-03-17 08:21:45', NULL),
(79, 1, NULL, 0.00, 'Paid', '2026-03-17 08:22:11', NULL),
(80, 1, NULL, 0.00, 'Paid', '2026-03-17 08:41:26', NULL),
(81, 1, NULL, 0.00, 'Paid', '2026-03-17 08:45:10', '2026-03-17 15:45:22'),
(82, 1, NULL, 0.00, 'Paid', '2026-03-17 08:58:41', NULL),
(83, 2, NULL, 0.00, 'Paid', '2026-03-17 08:59:21', NULL),
(84, 1, NULL, 0.00, 'Paid', '2026-03-17 09:00:48', NULL),
(85, 1, NULL, 0.00, 'Paid', '2026-03-17 09:01:11', NULL),
(86, 2, NULL, 0.00, 'Paid', '2026-03-17 09:01:25', NULL),
(87, 1, NULL, 0.00, 'Paid', '2026-03-17 09:05:35', NULL),
(88, 2, NULL, 0.00, 'Paid', '2026-03-18 10:00:07', NULL),
(89, 5, NULL, 0.00, 'Paid', '2026-03-18 10:03:32', NULL),
(90, 2, NULL, 0.00, 'Paid', '2026-03-20 15:43:44', NULL),
(91, 2, NULL, 0.00, 'Paid', '2026-03-20 15:43:56', '2026-03-20 22:45:37'),
(92, 2, NULL, 0.00, 'Paid', '2026-03-20 15:47:19', NULL),
(93, 2, NULL, 0.00, 'Paid', '2026-03-20 15:47:29', '2026-03-20 22:47:40'),
(94, 1, NULL, 0.00, 'Paid', '2026-03-20 15:47:57', NULL),
(95, 1, NULL, 0.00, 'Paid', '2026-03-20 15:48:03', '2026-03-20 22:48:07'),
(96, 1, NULL, 0.00, 'Paid', '2026-03-20 15:50:07', NULL),
(97, 1, NULL, 0.00, 'Paid', '2026-03-20 15:50:14', NULL),
(98, 1, NULL, 0.00, 'Paid', '2026-03-20 15:54:22', NULL),
(99, 6, NULL, 0.00, 'Paid', '2026-03-20 15:54:26', NULL),
(100, 6, NULL, 0.00, 'Paid', '2026-03-20 15:54:31', '2026-03-20 22:54:49'),
(101, 7, NULL, 0.00, 'Paid', '2026-03-20 15:56:13', NULL),
(102, 7, NULL, 0.00, 'Paid', '2026-03-20 15:56:25', '2026-03-20 22:57:09'),
(103, 1, NULL, 0.00, 'Paid', '2026-03-20 16:00:04', NULL),
(104, 1, NULL, 0.00, 'Paid', '2026-03-20 16:00:11', '2026-03-20 23:00:25'),
(105, 9, NULL, 0.00, 'Paid', '2026-03-20 16:05:29', NULL),
(106, 9, NULL, 0.00, 'Paid', '2026-03-20 16:05:37', NULL),
(107, 1, NULL, 0.00, 'Paid', '2026-03-20 16:29:43', NULL),
(108, 1, NULL, 0.00, 'Paid', '2026-03-23 07:04:18', NULL),
(109, 1, NULL, 0.00, 'Paid', '2026-03-23 07:04:26', NULL),
(110, 2, NULL, 0.00, 'Paid', '2026-03-23 07:49:17', NULL),
(111, 2, NULL, 0.00, 'Paid', '2026-03-23 07:49:36', NULL),
(112, 1, NULL, 0.00, 'Paid', '2026-03-23 13:32:59', NULL),
(113, 1, NULL, 0.00, 'Paid', '2026-03-23 13:33:19', NULL),
(114, 2, NULL, 0.00, 'Paid', '2026-03-23 13:35:46', NULL),
(115, 2, NULL, 0.00, 'Paid', '2026-03-23 13:35:59', NULL),
(116, 5, NULL, 0.00, 'Paid', '2026-03-23 13:38:42', NULL),
(117, 5, NULL, 0.00, 'Paid', '2026-03-23 13:38:58', NULL),
(118, 2, NULL, 0.00, 'Paid', '2026-03-23 14:25:21', NULL),
(119, 2, NULL, 0.00, 'Paid', '2026-03-23 14:25:26', NULL),
(120, 2, NULL, 0.00, 'Paid', '2026-03-23 14:26:07', NULL),
(121, 2, NULL, 0.00, 'Paid', '2026-03-23 14:26:42', NULL),
(122, 2, NULL, 0.00, 'Paid', '2026-03-23 14:30:56', NULL),
(123, 2, NULL, 0.00, 'Paid', '2026-03-23 14:32:10', NULL),
(124, 2, NULL, 0.00, 'Paid', '2026-03-23 14:46:45', NULL),
(125, 5, NULL, 0.00, 'Paid', '2026-03-23 14:47:13', NULL),
(126, 6, NULL, 0.00, 'Paid', '2026-03-23 14:48:01', NULL),
(127, 2, NULL, 0.00, 'Paid', '2026-03-23 14:53:51', NULL),
(128, 2, NULL, 0.00, 'Paid', '2026-03-23 14:55:56', NULL),
(129, 1, NULL, 0.00, 'Paid', '2026-03-24 07:16:36', NULL),
(130, 1, NULL, 0.00, 'Paid', '2026-03-24 07:16:56', NULL),
(131, 1, NULL, 0.00, 'Paid', '2026-03-24 07:19:54', NULL),
(132, 1, NULL, 0.00, 'Paid', '2026-03-24 07:39:08', NULL),
(133, 1, NULL, 0.00, 'Paid', '2026-03-24 07:39:55', NULL),
(134, 1, NULL, 0.00, 'Paid', '2026-03-25 03:57:56', NULL),
(135, 1, NULL, 0.00, 'Paid', '2026-03-25 03:58:52', NULL),
(136, 1, NULL, 0.00, 'Paid', '2026-03-25 14:39:45', NULL),
(137, 1, NULL, 0.00, 'Paid', '2026-03-25 14:40:48', NULL),
(138, 1, NULL, 0.00, 'Paid', '2026-04-01 08:25:17', NULL),
(139, 1, NULL, 0.00, 'Paid', '2026-04-01 08:26:16', NULL),
(140, 1, NULL, 0.00, 'Paid', '2026-04-02 03:33:56', NULL),
(141, 1, NULL, 0.00, 'Paid', '2026-04-02 03:34:53', NULL),
(142, 1, NULL, 0.00, 'Paid', '2026-04-06 16:11:28', NULL),
(143, 10, NULL, 0.00, 'Paid', '2026-04-17 14:42:32', NULL),
(144, 10, NULL, 0.00, 'Paid', '2026-04-17 14:59:48', NULL),
(145, 11, NULL, 0.00, 'Paid', '2026-04-17 15:21:22', NULL),
(146, 11, NULL, 0.00, 'Paid', '2026-04-17 15:21:35', NULL),
(147, 11, NULL, 0.00, 'Paid', '2026-04-17 15:25:20', NULL),
(148, 8, NULL, 0.00, 'Paid', '2026-04-19 07:05:27', NULL),
(149, 9, NULL, 0.00, 'Paid', '2026-04-19 07:05:47', NULL),
(150, 5, NULL, 0.00, 'Paid', '2026-04-19 07:08:17', NULL),
(151, 5, NULL, 0.00, 'Paid', '2026-04-19 07:08:57', NULL),
(152, 1, NULL, 0.00, 'Paid', '2026-04-19 08:27:43', NULL),
(153, 1, NULL, 0.00, 'Paid', '2026-04-19 08:28:11', NULL),
(154, 1, NULL, 0.00, 'Paid', '2026-05-05 15:09:26', NULL),
(155, 1, NULL, 0.00, 'Paid', '2026-05-05 15:10:30', NULL),
(156, 1, NULL, 0.00, 'Paid', '2026-05-05 15:29:05', NULL),
(157, 2, NULL, 0.00, 'Paid', '2026-05-08 15:37:43', NULL),
(158, 2, NULL, 0.00, 'Paid', '2026-05-08 15:38:41', NULL),
(159, 2, NULL, 0.00, 'Paid', '2026-05-08 15:52:21', NULL),
(160, 5, NULL, 0.00, 'Paid', '2026-05-08 16:18:12', NULL),
(161, 5, NULL, 0.00, 'Paid', '2026-05-08 16:18:52', NULL),
(162, 7, NULL, 0.00, 'Paid', '2026-05-08 16:20:35', NULL),
(163, 7, NULL, 0.00, 'Paid', '2026-05-08 16:22:53', NULL),
(164, 6, NULL, 0.00, 'Paid', '2026-05-08 16:25:02', NULL),
(165, 6, NULL, 0.00, 'Paid', '2026-05-08 16:25:08', NULL),
(166, 8, NULL, 0.00, 'Paid', '2026-05-08 16:25:40', NULL),
(167, 8, NULL, 0.00, 'Paid', '2026-05-08 16:33:51', NULL),
(168, 1, NULL, 0.00, 'Paid', '2026-05-08 16:39:15', NULL),
(169, 5, NULL, 0.00, 'Paid', '2026-05-08 16:39:21', NULL),
(170, 2, NULL, 0.00, 'Paid', '2026-05-08 16:39:28', NULL),
(171, 1, NULL, 0.00, 'Paid', '2026-05-08 16:41:57', NULL),
(172, 1, NULL, 0.00, 'Paid', '2026-05-08 16:42:02', NULL),
(173, 1, NULL, 0.00, 'Paid', '2026-05-09 07:45:16', NULL),
(174, 1, NULL, 0.00, 'Paid', '2026-05-09 08:34:44', NULL),
(175, 2, NULL, 0.00, 'Paid', '2026-05-09 12:21:06', NULL),
(176, 5, NULL, 0.00, 'Paid', '2026-05-09 14:34:02', NULL),
(177, 5, NULL, 0.00, 'Paid', '2026-05-09 14:35:11', NULL),
(178, 5, NULL, 0.00, 'Paid', '2026-05-09 14:36:41', NULL),
(179, 5, NULL, 0.00, 'Paid', '2026-05-09 14:38:07', NULL),
(180, 5, NULL, 0.00, 'Paid', '2026-05-09 14:40:22', NULL),
(181, 6, NULL, 0.00, 'Paid', '2026-05-09 16:05:20', NULL),
(182, 6, NULL, 0.00, 'Paid', '2026-05-09 16:06:37', NULL),
(183, 2, NULL, 0.00, 'Pending', '2026-05-09 16:33:44', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ProductName` varchar(200) NOT NULL,
  `Price` decimal(18,2) NOT NULL,
  `ImageURL` varchar(500) DEFAULT NULL,
  `IsAvailable` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`ProductID`, `CategoryID`, `ProductName`, `Price`, `ImageURL`, `IsAvailable`) VALUES
(1, 2, 'Bắp heo Mỹ cuộn', 59000.00, 'http://192.168.2.18/public/uploads/products/69c236c1eb8f8.jpg', 1),
(3, 1, 'Lẩu Mộc Thanh Trà', 99000.00, 'http://192.168.2.18/public/uploads/products/69c235bd397a2.jpg', 1),
(4, 1, 'Lẩu Mala Hồng Ngọc', 160000.00, 'http://192.168.2.18/public/uploads/products/69c235e165e91.jpg', 1),
(5, 1, 'Lẩu Đài Bắc Ngọc Thạch ', 150000.00, 'http://192.168.2.18/public/uploads/products/69c236153c575.jpg', 1),
(6, 6, 'Ba chỉ cừu', 79000.00, 'http://192.168.2.18/public/uploads/products/69c23654a0928.jpg', 1),
(7, 2, 'Má heo', 99000.00, 'http://192.168.2.18/public/uploads/products/69c236a18441c.png', 1),
(8, 2, 'Ba chỉ heo Iberico', 49000.00, 'http://192.168.2.18/public/uploads/products/69c237406ca13.jpg', 1),
(9, 5, 'Dạ Thiên Ý', 249000.00, 'http://192.168.2.18/public/uploads/products/69c2376bef79f.png', 1),
(10, 5, 'Thịt Bò Như Ý', 179000.00, 'http://192.168.2.18/public/uploads/products/69c2378bda41b.png', 1),
(11, 5, 'Thịt Bò Tuyết Liên Hoa', 299000.00, 'http://192.168.2.18/public/uploads/products/69c237af33e5f.jpg', 1),
(12, 5, 'Sườn Wagyu Thượng Hạng', 649000.00, 'http://192.168.2.18/public/uploads/products/69c237d4a9add.jpeg', 1),
(13, 7, 'Sách Bò Nâu', 79000.00, 'http://192.168.2.18/public/uploads/products/69c23810c2c65.jpg', 1),
(14, 7, 'Bao Tử Cá Basa', 39000.00, 'http://192.168.2.18/public/uploads/products/69c2383b07397.jpg', 1),
(15, 8, 'Sò Điệp', 239000.00, 'http://192.168.2.18/public/uploads/products/69c23859a3f75.png', 1),
(16, 8, 'Bào Ngư Đen', 199000.00, 'http://192.168.2.18/public/uploads/products/69c238974379d.jpg', 1),
(17, 8, 'Tôm Sú Tươi', 249000.00, 'http://192.168.2.18/public/uploads/products/69c238c4631c0.jpg', 1),
(18, 8, 'Bạch Tuộc Baby', 109000.00, 'http://192.168.2.18/public/uploads/products/69c238e8e84ed.jpg', 1),
(19, 10, 'Sủi Cảo Ngẫu Tượng', 19000.00, 'http://192.168.2.18/public/uploads/products/69c2391cd8f38.jpg', 1),
(20, 10, 'Há Cảo Bò', 29000.00, 'http://192.168.2.18/public/uploads/products/69c2393d15f52.jpg', 1),
(21, 9, 'Rau Nấm Tổng Hợp', 99000.00, 'http://192.168.2.18/public/uploads/products/69c2396310d1e.jpg', 1),
(22, 9, 'Rau Tổng Hợp', 35000.00, 'http://192.168.2.18/public/uploads/products/69c2397b9ab4a.jpg', 1),
(23, 9, 'Nấm Tổng Hợp', 29000.00, 'http://192.168.2.18/public/uploads/products/69c2399a7b718.jpg', 1),
(24, 9, 'Nấm Đông Trùng Hạ Thảo', 89000.00, 'http://192.168.2.18/public/uploads/products/69c239bd818cb.jpg', 1),
(25, 9, 'Nấm Nhung Hươu', 79000.00, 'http://192.168.2.18/public/uploads/products/69c239da9fa48.jpg', 1),
(26, 11, 'Mỳ Tươi', 19000.00, 'http://192.168.2.18/public/uploads/products/69c239f5bd12d.jpg', 1),
(27, 11, 'Mỳ Trùng Khánh', 39000.00, 'http://192.168.2.18/public/uploads/products/69c23a118c34d.jpg', 1),
(28, 11, 'Bánh Đa Hong Kong', 19000.00, 'http://192.168.2.18/public/uploads/products/69c23a33b532a.jpg', 1),
(31, 1, 'Test', 34243.00, 'http://192.168.2.18/public/uploads/products/69ff4737c87f8.png', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recipes`
--

CREATE TABLE `recipes` (
  `ProductID` int(11) NOT NULL,
  `IngredientID` int(11) NOT NULL,
  `AmountRequired` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `recipes`
--

INSERT INTO `recipes` (`ProductID`, `IngredientID`, `AmountRequired`) VALUES
(1, 2, 1.00),
(3, 3, 1.00),
(7, 1, 2.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` enum('ADMIN','CASHIER','KITCHEN','STAFF','CUSTOMER') NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tables`
--

CREATE TABLE `tables` (
  `TableID` int(11) NOT NULL,
  `TableNumber` varchar(50) NOT NULL,
  `Status` int(11) DEFAULT 0,
  `Token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tables`
--

INSERT INTO `tables` (`TableID`, `TableNumber`, `Status`, `Token`) VALUES
(1, '1', 0, NULL),
(2, '2', 1, 'b0d112525db890de92e595dbaf9d3258'),
(5, '3', 0, NULL),
(6, '4', 0, NULL),
(7, '5', 0, NULL),
(8, '6', 0, NULL),
(9, '7', 0, NULL),
(10, '8', 0, NULL),
(11, '9', 0, NULL),
(12, '10', 0, NULL),
(13, '11', 0, NULL),
(15, '12', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `PasswordHash` text NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `UserRole` enum('Admin','Kitchen','Cashier','Staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`UserID`, `Username`, `PasswordHash`, `FullName`, `UserRole`) VALUES
(1, 'cashier', '$2y$10$J5ITnWkNlwo1/SXRG2ncUOz7pFDCr7CIjf/pQ0wyLW06IU5FpKXBm', 'Vu Huy Nguyen ', 'Cashier'),
(2, 'vuhuy2005', '$2y$10$wHd4NvGNolgFU7Zuz5YxZuoaFgsz7e889EHH5Dlu1ha.tlVDh/heG', 'Vũ Huy Nguyễn', 'Admin'),
(3, 'vhn', '$2y$10$9Q.EkL0y3dCCunOX3YAOqOvbSQN3dEHbx1mep.Zx6qtvFTv6S1rW.', 'Vũ Huy Nguyên', 'Cashier'),
(4, 'kitchen', '$2y$10$6TNVJqjiYksJqpoeLZagseZoBCBxpExfPnOI4BJBrvCowUfGJEBem', 'Vũ Huy Nguyên', 'Kitchen'),
(5, 'hn', '$2y$10$frkky.55xTmnCLo4/h3QpeowcdTZdTTBZIp3aYfPVWnjFg7r5ebSO', 'Huy Nguyen', 'Kitchen'),
(6, 'admin', '123', 'VHN', 'Admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD UNIQUE KEY `OrderID` (`OrderID`);

--
-- Chỉ mục cho bảng `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`IngredientID`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationID`);

--
-- Chỉ mục cho bảng `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `FK_ItemOrder` (`OrderID`),
  ADD KEY `FK_ItemProduct` (`ProductID`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `FK_OrderTable` (`TableID`),
  ADD KEY `FK_OrderStaff` (`StaffID`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `FK_Category` (`CategoryID`);

--
-- Chỉ mục cho bảng `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`ProductID`,`IngredientID`),
  ADD KEY `FK_RecipeIngredient` (`IngredientID`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`TableID`),
  ADD UNIQUE KEY `TableNumber` (`TableNumber`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT cho bảng `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tables`
--
ALTER TABLE `tables`
  MODIFY `TableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `FK_FeedbackOrder` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Các ràng buộc cho bảng `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `FK_ItemOrder` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ItemProduct` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_OrderStaff` FOREIGN KEY (`StaffID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `FK_OrderTable` FOREIGN KEY (`TableID`) REFERENCES `tables` (`TableID`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_Category` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `FK_RecipeIngredient` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`IngredientID`),
  ADD CONSTRAINT `FK_RecipeProduct` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
