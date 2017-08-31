-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 31, 2017 lúc 09:19 PM
-- Phiên bản máy phục vụ: 10.1.25-MariaDB
-- Phiên bản PHP: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `retailmenot`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'root', '$2a$06$QvJTUkVxg6.QYTKKPyOtfeoRxPoFcvy4lRbxyxirlYtlHDSlMPDu6', 'Jt7aq7duyGTy9wl85tVJ4uxKlozCkykhrwBuJlawFJ9uZL5KWtLVvcn8ViFH', NULL, '2017-08-19 08:47:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Category 1', NULL, '2017-08-19 03:23:22', '2017-08-19 23:41:34'),
(9, 'Departments', NULL, '2017-08-19 08:29:03', '2017-08-19 08:29:03'),
(10, 'Auto', 9, '2017-08-19 08:29:10', '2017-08-19 08:29:10'),
(11, 'Accessories', 9, '2017-08-19 15:19:55', '2017-08-19 15:19:55'),
(12, 'Beauty', 9, '2017-08-19 15:20:18', '2017-08-19 15:20:18'),
(13, 'Clothing', 9, '2017-08-19 15:20:27', '2017-08-19 15:20:27'),
(14, 'Electronics', 9, '2017-08-19 15:20:36', '2017-08-19 15:20:57'),
(15, 'Food', 9, '2017-08-19 15:20:44', '2017-08-19 15:20:50'),
(16, 'Furniture', 9, '2017-08-19 15:21:28', '2017-08-19 15:21:28'),
(17, 'Gifts', 9, '2017-08-19 15:21:40', '2017-08-19 15:21:40'),
(19, 'Category 3', NULL, '2017-08-19 23:40:28', '2017-08-19 23:40:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon`
--

CREATE TABLE `coupon` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exp_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon`
--

INSERT INTO `coupon` (`id`, `store_id`, `type`, `link`, `code`, `value`, `description`, `exp_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'BOGO', 'aaaa', '123456', '0', 'Please only submit publicly available coupon codes and not private or internal company codes.', '0000-00-00', '2017-08-24 02:42:14', '2017-08-17 05:07:14'),
(2, 1, 'Off $', 'abc.com', '1111', '0', 'mt', '2017-08-01', '2017-08-27 11:23:00', '2017-08-18 04:14:06'),
(3, 5, 'Off %', 'http://toiyeubug.info', '111111', '0', 'this is a description', '2017-08-31', '2017-08-27 11:23:07', '2017-08-19 16:00:54'),
(4, 1, 'Freeship', 'http://toiyeubug.info', '111111', '0', 'this is a description', '2017-08-03', '2017-08-27 11:23:16', '2017-08-21 04:19:12'),
(5, 2, 'Off $', 'http://toiyeubug.info', '123456', '0', 'this is a description', '2017-09-01', '2017-08-28 10:50:58', '2017-08-28 03:50:58'),
(6, 1, 'Off %', 'http://tresdeals.com', '111111', '0', 'this is a description', '2017-08-30', '2017-08-23 19:41:07', '2017-08-23 19:41:07'),
(7, 1, 'Freeship', 'http://tresdeals.com', '111111', '1', 'this is a description', '2017-08-31', '2017-08-27 04:16:52', '2017-08-27 04:16:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `header`
--

CREATE TABLE `header` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `header`
--

INSERT INTO `header` (`id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(2, 2, '2017-08-19 23:55:53', '2017-08-19 23:55:53'),
(3, 3, '2017-08-19 23:55:57', '2017-08-19 23:55:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_08_17_052435_create_store_table', 2),
(4, '2017_08_17_052501_create_coupon_table', 2),
(5, '2017_08_19_033909_create_admins_table', 3),
(6, '2017_08_19_083915_create_category_table', 4),
(7, '2017_08_19_230520_create_header_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `store`
--

CREATE TABLE `store` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `store`
--

INSERT INTO `store` (`id`, `user_id`, `category_id`, `name`, `img`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 'Amazon', '20632429_1916930968546067_983058788_n.jpg', '2017-08-19 22:44:50', '2017-08-17 04:48:20'),
(2, 1, 11, 'Alibaba', '20170816_215400.jpg', '2017-08-19 22:44:53', '2017-08-17 04:49:56'),
(3, 1, 11, 'Apple', '20170816_215400.jpg', '2017-08-19 22:44:56', '2017-08-17 04:55:07'),
(4, 2, 11, 'aaa', 'tải xuống.jpg', '2017-08-19 22:45:01', '2017-08-18 08:50:22'),
(5, 0, 11, 'Toi Yeu Bug', 'ICT.jpg', '2017-08-19 15:42:20', '2017-08-19 15:42:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'vuquocthang63@gmail.com', '$2y$10$Rf2SNBrwMk8ELF44vSNUJ.Hf9sHpAd.CvmopJ2k3qhfgRLoDiYE0O', 'TGRV5QNheH2rsjDvZrYyZpm4Gzz5GHR573LWUhtqIF7mQbwslMrPpzRk7gTn', '2017-08-16 20:58:55', '2017-08-18 08:41:05'),
(2, 'vuquocthang64@gmail.com', '$2y$10$WFiGiTFDFZIg8czbHskh4O2CsHR39Qn8Ggk6FpArDb1Ofgg/KGuf2', NULL, '2017-08-18 08:41:29', '2017-08-18 08:41:29');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Chỉ mục cho bảng `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Chỉ mục cho bảng `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT cho bảng `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT cho bảng `header`
--
ALTER TABLE `header`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT cho bảng `store`
--
ALTER TABLE `store`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `coupon`
--
ALTER TABLE `coupon`
  ADD CONSTRAINT `coupon_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
