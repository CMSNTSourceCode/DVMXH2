-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th8 17, 2022 lúc 03:55 PM
-- Phiên bản máy phục vụ: 5.7.38-cll-lve
-- Phiên bản PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `maihuyba_dvmxh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `image` text,
  `accountName` text,
  `accountNumber` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bank_auto`
--

CREATE TABLE `bank_auto` (
  `id` int(11) NOT NULL,
  `tid` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_vietnamese_ci,
  `amount` int(11) DEFAULT '0',
  `received` int(11) DEFAULT '0',
  `create_gettime` datetime DEFAULT NULL,
  `create_time` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `bank_auto`
--

INSERT INTO `bank_auto` (`id`, `tid`, `description`, `amount`, `received`, `create_gettime`, `create_time`, `user_id`) VALUES
(5, 'FT22143090098586\\\\BNK', 'NAP8 - Ma giao dich/ Tr ace 957618', 10000, 10000, '2022-05-23 13:44:08', 1653313448, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `trans_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telco` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `serial` text COLLATE utf8mb4_unicode_ci,
  `pin` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `trans_id`, `telco`, `amount`, `price`, `serial`, `pin`, `status`, `create_date`, `update_date`, `reason`) VALUES
(2, 1, 'HUMEDL1645788423', 'VIETTEL', 20000, 0, '10005652489834', '3434323434234', 2, '2022-02-25 12:27:05', '2022-02-25 12:37:04', 'CARD_INVALID');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `id_api` int(11) NOT NULL DEFAULT '0',
  `stt` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `display` int(11) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `id_api`, `stt`, `icon`, `name`, `slug`, `content`, `display`, `create_date`) VALUES
(1, 0, 0, 'assets/storage/images/iconG9NM.png', 'Facebook', 'facebook', '', 1, '2022-05-02 12:21:14'),
(3, 0, 0, 'assets/storage/images/iconKRZX.png', 'Youtube', 'youtube', '', 1, '2022-05-06 23:03:11'),
(4, 0, 0, 'assets/storage/images/category0UA7.png', 'TikTok', 'tiktok', '', 1, '2022-05-11 19:36:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dongtien`
--

CREATE TABLE `dongtien` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `sotientruoc` int(11) NOT NULL DEFAULT '0',
  `sotienthaydoi` int(11) NOT NULL DEFAULT '0',
  `sotiensau` int(11) NOT NULL DEFAULT '0',
  `thoigian` datetime NOT NULL,
  `noidung` text COLLATE utf8mb4_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `createdate` datetime NOT NULL,
  `action` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `ip`, `device`, `createdate`, `action`) VALUES
(1, 1, '171.234.13.73', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36', '2022-07-12 14:18:39', 'Thực hiện tạo tài khoản'),
(2, 2, '27.65.188.250', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', '2022-08-17 15:53:53', 'Thực hiện tạo tài khoản'),
(3, 2, '27.65.188.250', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', '2022-08-17 15:54:32', '[Warning] Đăng nhập thành công vào hệ thống Admin'),
(4, 2, '27.65.188.250', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', '2022-08-17 15:54:54', 'Xoá menu (Liên Hệ ID 6)');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT '0',
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `href` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `momo`
--

CREATE TABLE `momo` (
  `id` int(11) NOT NULL,
  `request_id` varchar(64) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `tranId` varchar(255) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `partnerId` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `partnerName` text CHARACTER SET utf16 COLLATE utf16_vietnamese_ci,
  `amount` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `received` int(11) NOT NULL DEFAULT '0',
  `comment` text CHARACTER SET utf8 COLLATE utf8_vietnamese_ci,
  `time` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT 'xuly'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `momo`
--

INSERT INTO `momo` (`id`, `request_id`, `tranId`, `partnerId`, `partnerName`, `amount`, `received`, `comment`, `time`, `user_id`, `status`) VALUES
(7, NULL, '24345645056', '01698925204', ' BUI VAN TO', '100', 100, 'NAP8', '2022-05-23 13:48:28', 8, 'xuly');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer` int(11) NOT NULL DEFAULT '0',
  `seller` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  `service_pack_id` int(11) NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `note` longtext,
  `trans_id` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_gettime` datetime NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `update_gettime` datetime NOT NULL,
  `seller_note` longtext,
  `task_note` longtext,
  `status` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `camxuc` varchar(255) DEFAULT NULL,
  `start` int(11) NOT NULL DEFAULT '0',
  `success` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `title` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `display` int(11) NOT NULL DEFAULT '0',
  `view` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `content` longtext,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `id_api` int(11) NOT NULL DEFAULT '0',
  `stt` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `content` longtext,
  `text_input` varchar(255) DEFAULT NULL,
  `text_placeholder` varchar(255) DEFAULT NULL,
  `display` int(11) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `id_api`, `stt`, `category_id`, `name`, `slug`, `icon`, `content`, `text_input`, `text_placeholder`, `display`, `create_date`) VALUES
(3, 0, 1, 1, 'Tăng Like Bài Viết', 'tang-like-bai-viet', 'assets/storage/images/service9L8K.png', 'PHVsPg0KCTxsaT4NCgk8aDQ+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZToxNHB4Ij5OZ2hpJmVjaXJjO20gY+G6pW0gYnVmZiBjJmFhY3V0ZTtjIMSRxqFuIGMmb2FjdXRlOyBu4buZaSBkdW5nIHZpIHBo4bqhbSBwaCZhYWN1dGU7cCBsdeG6rXQsIGNoJmlhY3V0ZTtuaCB0cuG7iywgxJHhu5MgdHLhu6V5Li4uIE7hur91IGPhu5EgdCZpZ3JhdmU7bmggYnVmZiBi4bqhbiBz4bq9IGLhu4sgdHLhu6sgaOG6v3QgdGnhu4FuIHYmYWdyYXZlOyBiYW4ga2jhu49pIGjhu4cgdGjhu5FuZyB2xKluaCB2aeG7hW4sIHYmYWdyYXZlOyBwaOG6o2kgY2jhu4t1IGhvJmFncmF2ZTtuIHRvJmFncmF2ZTtuIHRyJmFhY3V0ZTtjaCBuaGnhu4dtIHRyxrDhu5tjIHBoJmFhY3V0ZTtwIGx14bqtdC48L3NwYW4+PC9oND4NCgk8L2xpPg0KCTxsaT4NCgk8aDQ+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZToxNHB4Ij5O4bq/dSDEkcahbiDEkWFuZyBjaOG6oXkgdHImZWNpcmM7biBo4buHIHRo4buRbmcgbSZhZ3JhdmU7IGLhuqFuIHbhuqtuIG11YSDhu58gYyZhYWN1dGU7YyBo4buHIHRo4buRbmcgYiZlY2lyYztuIGtoJmFhY3V0ZTtjLCBu4bq/dSBjJm9hY3V0ZTsgdCZpZ3JhdmU7bmggdHLhuqFuZyBo4buldCwgdGhp4bq/dSBz4buRIGzGsOG7o25nIGdp4buvYSAyIGImZWNpcmM7biB0aCZpZ3JhdmU7IHPhur0ga2gmb2NpcmM7bmcgxJHGsOG7o2MgeOG7rSBsJmlhY3V0ZTsuPC9zcGFuPjwvaDQ+DQoJPC9saT4NCgk8bGk+DQoJPGg0PjxzcGFuIHN0eWxlPSJmb250LXNpemU6MTRweCI+xJDGoW4gYyZhZ3JhdmU7aSBzYWkgdGgmb2NpcmM7bmcgdGluIGhv4bq3YyBs4buXaSB0cm9uZyBxdSZhYWN1dGU7IHRyJmlncmF2ZTtuaCB0xINuZyBo4buHIHRo4buRbmcgc+G6vSBraCZvY2lyYztuZyBobyZhZ3JhdmU7biBs4bqhaSB0aeG7gW4uPC9zcGFuPjwvaDQ+DQoJPC9saT4NCgk8bGk+DQoJPGg0PjxzcGFuIHN0eWxlPSJmb250LXNpemU6MTRweCI+TuG6v3UgZ+G6t3AgbOG7l2kgaCZhdGlsZGU7eSBuaOG6r24gdGluIGjhu5cgdHLhu6MgcGgmaWFjdXRlO2EgYiZlY2lyYztuIHBo4bqjaSBnJm9hY3V0ZTtjIG0mYWdyYXZlO24gaCZpZ3JhdmU7bmggaG/hurdjIHYmYWdyYXZlO28gbeG7pWMgbGkmZWNpcmM7biBo4buHIGjhu5cgdHLhu6MgxJHhu4MgxJHGsOG7o2MgaOG7lyB0cuG7oyB04buRdCBuaOG6pXQuPC9zcGFuPjwvaDQ+DQoJPC9saT4NCjwvdWw+DQo=', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-05 14:12:41'),
(4, 0, 3, 1, 'Tăng Theo Dõi Cá Nhân', 'tang-theo-doi-ca-nhan', 'assets/storage/images/serviceS28M.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-06 22:59:55'),
(5, 0, 0, 3, 'Tăng Sub Youtube', 'tang-sub-youtube', 'assets/storage/images/iconC3PR.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-06 23:04:49'),
(6, 0, 0, 4, 'Tăng Tym TikTok', 'tang-tym-tiktok', 'assets/storage/images/serviceLXI7.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-11 19:38:14'),
(7, 0, 2, 3, 'Tăng Lượt Xem', 'tang-luot-xem', 'assets/storage/images/iconA2IR.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-11 19:45:47'),
(8, 0, 1, 3, 'Tăng Thích Video', 'tang-thich-video', 'assets/storage/images/icon1N5G.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-11 19:47:30'),
(9, 0, 2, 1, 'Tăng Like Fanpage', 'tang-like-fanpage', 'assets/storage/images/iconGA74.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-11 19:51:45'),
(10, 0, 0, 4, 'Tăng Follow', 'tang-follow', 'assets/storage/images/icon1VZ8.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-11 19:59:51'),
(11, 0, 0, 4, 'Tăng Lượt Xem Video', 'tang-luot-xem-video', 'assets/storage/images/iconU537.png', '', 'Nhập Link hoặc ID cần tăng', 'Vui lòng nhập Link hoặc ID cần tăng', 1, '2022-05-11 20:16:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_packs`
--

CREATE TABLE `service_packs` (
  `id` int(11) NOT NULL,
  `id_api` int(11) NOT NULL DEFAULT '0',
  `stt` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `cost` float NOT NULL DEFAULT '0',
  `min_order` int(11) NOT NULL DEFAULT '1',
  `max_order` int(11) NOT NULL DEFAULT '100000000',
  `create_gettime` datetime NOT NULL,
  `content` longtext,
  `display` int(11) NOT NULL DEFAULT '1',
  `note_admin` longtext,
  `show_comment` int(11) NOT NULL DEFAULT '0',
  `show_camxuc` int(11) NOT NULL DEFAULT '0',
  `server` varchar(255) DEFAULT 'me'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `service_packs`
--

INSERT INTO `service_packs` (`id`, `id_api`, `stt`, `service_id`, `name`, `price`, `cost`, `min_order`, `max_order`, `create_gettime`, `content`, `display`, `note_admin`, `show_comment`, `show_camxuc`, `server`) VALUES
(1, 0, 0, 3, 'Tăng like tốc độ nhanh', 3.5, 0, 1, 100000000, '2022-05-06 22:53:44', 'Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.', 1, NULL, 0, 0, 'me'),
(2, 0, 0, 4, 'Server 1: Tốc độ nhanh', 10, 0, 100, 100000000, '2022-05-06 23:00:29', 'Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.', 1, NULL, 0, 0, 'me'),
(3, 0, 0, 4, 'Server 2: Tốc độ chậm', 5, 0, 100, 100000000, '2022-05-06 23:02:05', 'Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.', 1, NULL, 0, 0, 'me'),
(4, 0, 0, 3, 'Like thật tốc độ chậm', 20, 0, 10, 100000000, '2022-05-06 23:02:25', 'Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.', 1, NULL, 0, 0, 'me'),
(5, 0, 0, 4, 'Server 3: Người thật click', 20, 0, 10, 100000000, '2022-05-06 23:05:44', 'Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.', 1, NULL, 0, 0, 'me'),
(6, 0, 0, 5, 'Server 1: Tốc độ nhanh', 100, 0, 100, 100000000, '2022-05-09 23:16:28', 'Tốc độ 10k sub 1 ngày.', 1, NULL, 0, 0, 'me'),
(7, 0, 0, 6, 'SV1 (Like Việt, Lên cực chậm, không BH)', 18, 0, 100, 100000000, '2022-05-11 19:42:31', 'Lưu ý: Buff không bảo hành nên buff thừa 30 - 50% để đủ số lượng', 1, NULL, 0, 0, 'me'),
(8, 0, 0, 6, 'SV2 (Like Global, lên nhanh , có thể thể lên thiếu, không BH)', 22, 0, 100, 100000000, '2022-05-11 19:42:53', 'Lưu ý: Buff không bảo hành nên buff thừa 30 - 50% để đủ số lượng', 1, NULL, 0, 0, 'me'),
(9, 0, 0, 7, 'SV1 (View MXH, Global)', 40, 0, 100, 100000000, '2022-05-11 19:46:08', '', 1, NULL, 0, 0, 'me'),
(10, 0, 0, 8, 'Like SV2 (Like Global)', 24, 0, 10, 100000000, '2022-05-11 19:48:25', '', 1, NULL, 0, 0, 'me'),
(11, 0, 0, 11, 'SV2 (Giá rẻ)', 0.8, 0, 100, 100000000, '2022-05-11 20:17:10', '', 1, NULL, 0, 0, 'me');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'status_demo', '0'),
(2, 'type_password', 'bcrypt'),
(3, 'title', 'CMSNT.CO'),
(4, 'description', ''),
(5, 'keywords', ''),
(6, 'author', 'CMSNT.CO'),
(7, 'theme_color', '#00266D'),
(8, 'theme_color2', '#10101F'),
(9, 'status', '1'),
(10, 'status_update', '1'),
(11, 'status_captcha', '0'),
(12, 'session_login', '10000000'),
(13, 'javascript_header', '<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n<link href=\"https://fonts.googleapis.com/css2?family=Oswald:wght@300;500&family=Roboto+Condensed&display=swap\" rel=\"stylesheet\">'),
(14, 'javascript_footer', ''),
(15, 'currency', 'VND'),
(16, 'logo_light', 'assets/storage/images/logo_light_OU8.png'),
(17, 'logo_dark', 'assets/storage/images/logo_dark_0T5.png'),
(18, 'favicon', 'assets/storage/images/favicon_ETL.png'),
(19, 'image', 'assets/storage/images/image_RSV.png'),
(20, 'bg_login', 'assets/storage/images/bg_loginRJW.png'),
(21, 'bg_register', 'assets/storage/images/bg_register9QT.png'),
(22, 'sign_view_product', '0'),
(23, 'partner_id_card', ''),
(24, 'partner_key_card', ''),
(25, 'ck_napthe', '30'),
(26, 'status_napthe', '0'),
(27, 'notice_napthe', '<ul>\r\n	<li>Vui l&ograve;ng nhập đầy đủ th&ocirc;ng tin <strong>Serial</strong> - <strong>Pin</strong> - <strong>Mệnh Gi&aacute;</strong> của thẻ.</li>\r\n	<li>Thẻ được xử l&yacute; tự động trong v&agrave;i gi&acirc;y.</li>\r\n	<li>Nạp sai mệnh gi&aacute; mất <strong>50%</strong> gi&aacute; trị thực của thẻ.</li>\r\n</ul>\r\n'),
(28, 'status_momo', '1'),
(29, 'token_momo', 'ff8ea3f4681154ad4ae16e94f8645a545356ae9e61808ea7ca6682ec4aeda9dd'),
(30, 'prefix_autobank', 'NAP'),
(31, 'mk_bank', '123321123'),
(32, 'stk_bank', '0988211125'),
(33, 'token_bank', 'concu'),
(34, 'type_bank', 'MBBank'),
(35, 'status_bank', '1'),
(36, 'recharge_notice', '<ul>\r\n	<li>Nhập đ&uacute;ng nội dung chuyển tiền.</li>\r\n	<li>Cộng tiền trong v&agrave;i gi&acirc;y.</li>\r\n	<li>Li&ecirc;n hệ BQT nếu nhập sai nội dung chuyển.</li>\r\n</ul>\r\n'),
(37, 'check_time_cron_momo', '1653313708'),
(38, 'check_time_cron_bank', '1653313447'),
(39, 'token_telegram', '5343530732:AAFpurxSKW9vGGPE_cZ1AU_kDP-__kXqOVc'),
(40, 'chat_id_telegram', '-788322500'),
(41, 'type_notification', 'telegram'),
(42, 'text_notification', '[{domain}] Có đơn hàng {service_name} - {service_pack_name} số lượng {amount} đang chờ xử lý'),
(43, 'notice_home', '<p>Mở th&ecirc;m server like page SV7,8 việt bảo h&agrave;nh d&agrave;i gi&aacute; cực rẻ Thay đổi gi&aacute; buff view tiktok sv2, v&agrave; vip vip view tiktok do tiktok thay đổi thuật to&aacute;n Mở th&ecirc;m SV cmt youtube người việt, like cmt youtube tốc độ cực nhanh</p>\r\n'),
(44, 'font_family', 'font-family: \'Oswald\', sans-serif;');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `ctv` int(11) NOT NULL DEFAULT '0',
  `banned` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `time_session` int(11) DEFAULT '0',
  `time_request` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `total_money` int(11) NOT NULL DEFAULT '0',
  `rankings` int(11) NOT NULL DEFAULT '0',
  `icon_ranking` text,
  `gender` varchar(255) NOT NULL DEFAULT 'Male',
  `device` text,
  `avatar` text,
  `status_2fa` int(11) NOT NULL DEFAULT '0',
  `SecretKey_2fa` varchar(255) DEFAULT NULL,
  `chietkhau` float NOT NULL DEFAULT '0',
  `spin` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `phone`, `admin`, `ctv`, `banned`, `create_date`, `update_date`, `time_session`, `time_request`, `ip`, `token`, `money`, `total_money`, `rankings`, `icon_ranking`, `gender`, `device`, `avatar`, `status_2fa`, `SecretKey_2fa`, `chietkhau`, `spin`) VALUES
(2, 'maihuybao', '$2y$10$XBpYwUNgWKL9wN1ul9pQKe/PGryZajr5cDR9tXyLQ/MTN7ar6AvoS', 'maihuybao.contact@gmail.com', NULL, NULL, 1, 0, 0, '2022-08-17 15:53:53', '2022-08-17 15:53:53', 1660726507, 1660726472, '27.65.188.250', 'e89ad6363b2022659805409e1374e8c5', 0, 0, 0, NULL, 'Male', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', NULL, 0, 'GFWPEXQ624W7H5UZ', 0, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bank_auto`
--
ALTER TABLE `bank_auto`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `tid` (`tid`);

--
-- Chỉ mục cho bảng `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `dongtien`
--
ALTER TABLE `dongtien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `momo`
--
ALTER TABLE `momo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `tranId` (`tranId`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `service_packs`
--
ALTER TABLE `service_packs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `bank_auto`
--
ALTER TABLE `bank_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `dongtien`
--
ALTER TABLE `dongtien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `momo`
--
ALTER TABLE `momo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `service_packs`
--
ALTER TABLE `service_packs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
