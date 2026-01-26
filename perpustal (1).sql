-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 25, 2026 at 12:34 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `activity_type` enum('user_borrow','user_return_request','user_cancel_borrow','user_review','user_delete_review','staff_approve_borrow','staff_reject_borrow','staff_process_return','staff_add_book','staff_update_book','staff_add_book_to_library','staff_update_stock','staff_remove_book_from_library','admin_ban_user','admin_unban_user','admin_delete_category','admin_create_category','admin_manage_staff') COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_type` enum('Book','Borrowing','Review','User','Category','Library') COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity_type`, `resource_type`, `resource_id`, `description`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 3, 'staff_update_book', 'Book', 3, 'Staff updated book: ArmorMayhem', '{\"author\": \"loussie\", \"category_id\": \"2\"}', '2026-01-23 23:55:02', '2026-01-23 23:55:02'),
(2, 1, 'user_review', 'Review', 5, 'User created review for book: ArmorMayhem', '{\"rating\": \"5\"}', '2026-01-23 23:56:52', '2026-01-23 23:56:52'),
(3, 1, 'user_borrow', 'Borrowing', 15, 'User requested to borrow: ArmorMayhem', '{\"library_id\": \"1\"}', '2026-01-23 23:57:02', '2026-01-23 23:57:02'),
(4, 1, 'user_cancel_borrow', 'Borrowing', 15, 'User canceled borrow request for: ArmorMayhem', '{\"original_status\": \"pending\"}', '2026-01-23 23:57:14', '2026-01-23 23:57:14'),
(5, 1, 'user_cancel_borrow', 'Borrowing', 15, 'User canceled borrow request for: ArmorMayhem', '{\"original_status\": \"pending\"}', '2026-01-23 23:57:36', '2026-01-23 23:57:36'),
(6, 3, 'staff_reject_borrow', 'Borrowing', 15, 'Staff rejected borrow request for: ArmorMayhem (User: nero)', '{\"book_id\": 3, \"user_id\": 1}', '2026-01-23 23:59:51', '2026-01-23 23:59:51'),
(7, 1, 'user_review', 'Review', 6, 'User created review for book: the moon i rot behind', '{\"rating\": \"5\"}', '2026-01-24 00:05:49', '2026-01-24 00:05:49'),
(8, 1, 'user_borrow', 'Borrowing', 16, 'User requested to borrow: the moon i rot behind', '{\"library_id\": \"3\"}', '2026-01-24 00:05:56', '2026-01-24 00:05:56'),
(9, 1, 'user_cancel_borrow', 'Borrowing', 16, 'User canceled borrow request for: the moon i rot behind', '{\"original_status\": \"pending\"}', '2026-01-24 00:06:02', '2026-01-24 00:06:02'),
(10, 3, 'staff_update_stock', 'Book', 1, 'Staff updated stock for \"the moon i rot behind\" in fuu education from 12 to 10', '{\"reason\": \"minus - because pengembalian dirusak ama member\", \"new_stock\": \"10\", \"old_stock\": 12, \"library_id\": 1}', '2026-01-24 00:23:58', '2026-01-24 00:23:58'),
(11, 8, 'user_review', 'Review', 7, 'User created review for book: CENTAURA', '{\"rating\": \"5\"}', '2026-01-24 21:16:39', '2026-01-24 21:16:39'),
(12, 3, 'staff_add_book_to_library', 'Book', 7, 'Staff added book \"CENTAURA\" to library: edupark surabaya pahlawan', '{\"stock\": \"1\", \"library_id\": 3}', '2026-01-24 23:45:09', '2026-01-24 23:45:09'),
(13, 3, 'staff_process_return', 'Borrowing', 7, 'Staff processed return for: CENTAURA (User: dummy)', '{\"book_id\": 7, \"user_id\": 5}', '2026-01-24 23:45:23', '2026-01-24 23:45:23'),
(14, 3, 'staff_remove_book_from_library', 'Book', 7, 'Staff removed book \"CENTAURA\" from library: edupark surabaya pahlawan', '{\"library_id\": 3}', '2026-01-24 23:45:39', '2026-01-24 23:45:39'),
(15, 9, 'user_borrow', 'Borrowing', 17, 'User requested to borrow: ArmorMayhem', '{\"library_id\": \"20\"}', '2026-01-25 05:27:10', '2026-01-25 05:27:10'),
(16, 9, 'user_review', 'Review', 8, 'User created review for book: CENTAURA', '{\"rating\": \"4\"}', '2026-01-25 05:27:32', '2026-01-25 05:27:32'),
(17, 9, 'user_borrow', 'Borrowing', 18, 'User requested to borrow: CENTAURA', '{\"library_id\": \"20\"}', '2026-01-25 05:27:42', '2026-01-25 05:27:42'),
(18, 8, 'user_borrow', 'Borrowing', 19, 'User requested to borrow: the moon i rot behind', '{\"library_id\": \"6\"}', '2026-01-25 05:28:39', '2026-01-25 05:28:39'),
(19, 8, 'user_review', 'Review', 9, 'User created review for book: ArmorMayhem', '{\"rating\": \"5\"}', '2026-01-25 05:28:51', '2026-01-25 05:28:51'),
(20, 8, 'user_borrow', 'Borrowing', 20, 'User requested to borrow: ArmorMayhem', '{\"library_id\": \"6\"}', '2026-01-25 05:28:55', '2026-01-25 05:28:55'),
(21, 8, 'user_review', 'Review', 10, 'User created review for book: BadThings', '{\"rating\": \"5\"}', '2026-01-25 05:29:09', '2026-01-25 05:29:09'),
(22, 8, 'user_borrow', 'Borrowing', 21, 'User requested to borrow: BadThings', '{\"library_id\": \"4\"}', '2026-01-25 05:29:14', '2026-01-25 05:29:14'),
(23, 3, 'staff_approve_borrow', 'Borrowing', 21, 'Staff approved borrow request for: BadThings (User: jakarta)', '{\"book_id\": 2, \"user_id\": 8}', '2026-01-25 05:30:15', '2026-01-25 05:30:15'),
(24, 3, 'staff_approve_borrow', 'Borrowing', 17, 'Staff approved borrow request for: ArmorMayhem (User: surabaya)', '{\"book_id\": 3, \"user_id\": 9}', '2026-01-25 05:30:18', '2026-01-25 05:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `category_id`, `title`, `author`, `publisher`, `year`, `isbn`, `description`, `cover_path`, `preview_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 'the moon i rot behind', 'terrorban', 'RBLX', '2025', NULL, 'depresi, skizofrenia', 'covers/yNhFSJDVgX85vPoLErULFgwLf2jSRILPf5oDkV9t.png', 'previews/1768914018_696f7c62afe63.png', '2026-01-16 05:01:18', '2026-01-20 06:00:18', NULL),
(2, 4, 'BadThings', 'ThatCactusMan', 'RBLX', '2024', NULL, 'sebuah pertemanan yang dimana salah satunya memiliki egotisme yang dapat membunuh secara metafor', 'covers/1768722603_696c90ab812b7.jpg', 'previews/1768913130_696f78ea90d47.txt', '2026-01-16 23:22:02', '2026-01-20 05:45:33', NULL),
(3, 2, 'ArmorMayhem', 'loussie', 'AM', '2015', NULL, 'bumi sudah hancur, 8 korporat berperang mati matian demi sebuah planet misterius yang memiliki energi keabadian. dan sekarang perang mati matian', 'covers/1768722763_696c914bca815.jpg', NULL, '2026-01-16 23:56:23', '2026-01-23 23:55:02', NULL),
(4, 1, 'test', 'test', 'test', '1914', NULL, NULL, 'covers/1768722848_696c91a0ce970.jpg', NULL, '2026-01-17 00:07:46', '2026-01-18 00:54:13', '2026-01-18 00:54:13'),
(5, 1, 'test', 'test', 'test', '1914', NULL, NULL, NULL, NULL, '2026-01-17 00:07:47', '2026-01-17 00:07:47', NULL),
(6, 1, 'how to sleep like a baby', 'bahlil', 'pertamina pentol', '2020', NULL, 'tukang pentol naik haji pake lambo yatch', 'covers/NSsvGWQa7zHXJnvvDb98G9t3MDRtWNwbeedg1so6.png', NULL, '2026-01-18 00:38:25', '2026-01-18 00:38:25', NULL),
(7, 2, 'CENTAURA', 'NoobManCharacter', 'RBLX', '2023', NULL, 'perang benua selama 450 tahun dari kediktaktoran antares sehingga melawan 1 benua CENTAURA', 'covers/1768723396_696c93c440ae7.jpg', 'previews/1768875904_696ee780570b4.pdf', '2026-01-18 01:03:16', '2026-01-23 23:49:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_library`
--

CREATE TABLE `book_library` (
  `id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `library_id` bigint UNSIGNED NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_library`
--

INSERT INTO `book_library` (`id`, `book_id`, `library_id`, `stock`, `created_at`, `updated_at`) VALUES
(10, 2, 21, 23, '2026-01-24 21:12:18', '2026-01-24 21:12:18'),
(11, 6, 21, 7, '2026-01-24 21:12:27', '2026-01-24 21:12:27'),
(12, 1, 21, 64, '2026-01-24 21:12:48', '2026-01-24 21:12:48'),
(13, 7, 20, 112, '2026-01-24 21:13:44', '2026-01-24 21:13:44'),
(14, 3, 20, 23, '2026-01-24 21:14:10', '2026-01-25 05:30:18'),
(15, 2, 20, 56, '2026-01-24 21:14:33', '2026-01-24 21:14:57'),
(16, 1, 20, 42, '2026-01-24 21:15:14', '2026-01-24 21:15:14'),
(17, 7, 4, 5, '2026-01-24 21:24:43', '2026-01-24 21:24:43'),
(18, 2, 4, 6, '2026-01-24 21:25:11', '2026-01-25 05:30:13'),
(19, 1, 6, 7, '2026-01-24 21:25:41', '2026-01-24 21:25:41'),
(20, 3, 6, 21, '2026-01-24 21:25:59', '2026-01-24 21:25:59'),
(22, 3, 7, 3, '2026-01-24 23:48:21', '2026-01-24 23:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `library_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `canceled_at` timestamp NULL DEFAULT NULL COMMENT 'When borrow was canceled by user',
  `cancel_reason` text COLLATE utf8mb4_unicode_ci COMMENT 'Reason for cancellation',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `library_id`, `status`, `staff_id`, `borrow_date`, `return_date`, `canceled_at`, `cancel_reason`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 'returned', NULL, '2026-01-16', '2026-01-16', NULL, NULL, NULL, '2026-01-16 06:07:18', '2026-01-16 07:34:58'),
(2, 1, 1, 3, 'rejected', 3, NULL, NULL, NULL, NULL, NULL, '2026-01-16 06:12:01', '2026-01-16 06:14:32'),
(3, 1, 1, 3, 'returned', NULL, '2026-01-16', '2026-01-16', NULL, NULL, NULL, '2026-01-16 07:04:15', '2026-01-16 07:34:16'),
(4, 1, 1, 3, 'rejected', 3, NULL, NULL, NULL, NULL, NULL, '2026-01-16 22:35:51', '2026-01-16 22:36:30'),
(5, 1, 2, 3, 'rejected', 3, NULL, NULL, NULL, NULL, NULL, '2026-01-16 23:24:16', '2026-01-18 01:57:17'),
(6, 1, 1, 1, 'rejected', 3, NULL, NULL, NULL, NULL, NULL, '2026-01-16 23:24:29', '2026-01-18 01:57:11'),
(7, 5, 7, 3, 'returned', 3, '2026-01-18', '2026-01-25', NULL, NULL, NULL, '2026-01-18 01:55:28', '2026-01-24 23:45:23'),
(8, 5, 3, 1, 'returned', 3, '2026-01-18', '2026-01-18', NULL, NULL, NULL, '2026-01-18 01:55:42', '2026-01-18 01:57:43'),
(9, 1, 3, 3, 'returned', 3, '2026-01-18', '2026-01-18', NULL, NULL, NULL, '2026-01-18 01:56:43', '2026-01-18 01:57:48'),
(10, 1, 3, 1, 'rejected', 3, NULL, NULL, NULL, NULL, NULL, '2026-01-18 01:58:16', '2026-01-18 01:59:51'),
(11, 5, 3, 1, 'returned', 3, '2026-01-18', '2026-01-24', NULL, NULL, NULL, '2026-01-18 01:59:17', '2026-01-23 23:48:50'),
(12, 5, 6, 1, 'returned', 3, '2026-01-22', '2026-01-24', NULL, NULL, NULL, '2026-01-19 19:38:50', '2026-01-23 23:48:47'),
(13, 1, 7, 3, 'returned', 3, '2026-01-22', '2026-01-22', NULL, NULL, NULL, '2026-01-20 19:33:22', '2026-01-21 22:35:50'),
(14, 1, 6, 1, 'returned', 3, '2026-01-24', '2026-01-24', NULL, NULL, NULL, '2026-01-23 23:39:04', '2026-01-23 23:48:43'),
(15, 1, 3, 1, 'rejected', 3, NULL, NULL, '2026-01-23 23:57:36', NULL, NULL, '2026-01-23 23:57:02', '2026-01-23 23:59:49'),
(16, 1, 1, 3, 'pending', NULL, NULL, NULL, '2026-01-24 00:06:01', NULL, NULL, '2026-01-24 00:05:56', '2026-01-24 00:06:01'),
(17, 9, 3, 20, 'approved', 3, '2026-01-25', NULL, NULL, NULL, NULL, '2026-01-25 05:27:09', '2026-01-25 05:30:18'),
(18, 9, 7, 20, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-25 05:27:42', '2026-01-25 05:27:42'),
(19, 8, 1, 6, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-25 05:28:39', '2026-01-25 05:28:39'),
(20, 8, 3, 6, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-25 05:28:55', '2026-01-25 05:28:55'),
(21, 8, 2, 4, 'approved', 3, '2026-01-25', NULL, NULL, NULL, NULL, '2026-01-25 05:29:14', '2026-01-25 05:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Horor Komedi fuu', 'horror-commedy', '2026-01-13 17:57:37', '2026-01-13 17:58:06', NULL),
(2, 'aksi', 'aksi-1', '2026-01-13 17:58:20', '2026-01-13 17:58:20', NULL),
(3, 'fuu kiss kiss', 'kiss fu kiss', '2026-01-14 20:09:20', '2026-01-14 20:09:38', '2026-01-14 20:09:38'),
(4, 'psychological', 'psikolog-1', '2026-01-16 05:01:47', '2026-01-16 05:01:47', NULL),
(5, 'komedi', 'komedi-1', '2026-01-19 18:42:37', '2026-01-19 18:42:37', NULL),
(6, 'romantis', 'romanatis-1', '2026-01-19 18:42:58', '2026-01-19 18:42:58', NULL),
(7, 'education', 'edu-1', '2026-01-19 18:43:11', '2026-01-19 18:43:11', NULL),
(8, 'mystery', 'edu-2', '2026-01-19 18:43:32', '2026-01-19 18:43:32', NULL),
(9, 'psychological', 'edu-3', '2026-01-19 18:44:52', '2026-01-19 18:44:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Surabaya', -7.25750000, 112.75210000, '2026-01-20 06:55:09', '2026-01-20 06:55:09'),
(2, 'Sidoarjo', -7.44240000, 112.71030000, '2026-01-20 06:55:09', '2026-01-20 06:55:09'),
(3, 'Gresik', -7.16200000, 112.66700000, '2026-01-20 06:55:10', '2026-01-20 06:55:10'),
(4, 'Mojokerto', -7.47940000, 112.43090000, '2026-01-20 06:55:10', '2026-01-20 06:55:10'),
(5, 'Lamongan', -6.88390000, 112.22160000, '2026-01-20 06:55:10', '2026-01-20 06:55:10'),
(6, 'Bangkalan', -7.04520000, 112.74570000, '2026-01-20 06:55:10', '2026-01-20 06:55:10'),
(7, 'Pamekasan', -7.19040000, 113.48270000, '2026-01-20 06:55:10', '2026-01-20 06:55:10'),
(8, 'Sumenep', -7.02220000, 113.85890000, '2026-01-20 06:55:10', '2026-01-20 06:55:10'),
(10, 'Jakarta', -6.18000000, 106.83000000, '2026-01-24 03:51:15', '2026-01-24 03:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `libraries`
--

CREATE TABLE `libraries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `libraries`
--

INSERT INTO `libraries` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`, `deleted_at`, `city_id`) VALUES
(1, 'fuu education', 'fuu park', -6.2088000, 106.8456000, '2026-01-14 21:34:02', '2026-01-24 23:47:17', '2026-01-24 23:47:17', NULL),
(2, 'edupark surabaya', 'jl. mohammed ishamel', -81.0000000, 23.0000000, '2026-01-16 04:59:16', '2026-01-16 04:59:30', '2026-01-16 04:59:30', NULL),
(3, 'edupark surabaya pahlawan', 'jl. mohammed ishamel', -81.0000000, 23.0000000, '2026-01-16 04:59:18', '2026-01-24 23:47:13', '2026-01-24 23:47:13', NULL),
(4, 'Perpustakaan Umum Kota Surabaya', 'Surabaya, Jawa Timur', -7.2636290, 112.7448630, '2026-01-20 06:40:52', '2026-01-24 23:38:19', NULL, 1),
(5, 'Arisza Library & Learning', 'Surabaya, Jawa Timur', -7.3374010, 112.7183560, '2026-01-20 06:40:53', '2026-01-24 23:35:42', NULL, 1),
(6, 'Perpustakaan Taman Flora', 'Surabaya, Jawa Timur', -7.2955370, 112.7615430, '2026-01-20 06:40:53', '2026-01-24 23:36:53', NULL, 1),
(7, 'Perpustakaan Kota Surabaya', 'Surabaya, Jawa Timur', -7.3275970, 112.7756470, '2026-01-20 06:40:54', '2026-01-24 23:32:51', NULL, 1),
(8, 'Perpustakaan Medayu Agung', 'Surabaya, Jawa Timur', -7.3319370, 112.7983970, '2026-01-20 06:40:54', '2026-01-24 23:33:56', NULL, 1),
(9, 'Read Coffee & Library', 'Surabaya, Jawa Timur', -7.3234740, 112.7917800, '2026-01-20 06:40:54', '2026-01-24 23:35:04', NULL, 1),
(10, 'Libreria Eatery', 'Surabaya, Jawa Timur', -7.2927160, 112.7555270, '2026-01-20 06:40:55', '2026-01-24 23:24:04', NULL, 1),
(11, 'Perpustakaan Museum Pendidikan', 'Surabaya, Jawa Timur', -7.2561080, 112.7428480, '2026-01-20 06:40:55', '2026-01-24 23:25:48', NULL, 1),
(12, 'Dinas Perpustakaan dan Kearsipan Provinsi Jawa Timur', 'Surabaya, Jawa Timur', -7.2893600, 112.7682440, '2026-01-20 06:40:55', '2026-01-24 23:27:34', NULL, 1),
(13, 'Perpustakaan Umum Pahlawan', 'Surabaya, Jawa Timur', -7.2490960, 112.7381650, '2026-01-20 06:40:55', '2026-01-24 23:31:49', NULL, 1),
(14, 'The Library', 'Surabaya, Jawa Timur', -7.2927730, 112.6723810, '2026-01-20 06:40:56', '2026-01-24 23:18:17', NULL, 1),
(15, 'Kamush Library Depot', 'Surabaya, Jawa Timur', -7.2788160, 112.7877180, '2026-01-20 06:40:56', '2026-01-24 23:18:35', NULL, 1),
(16, 'Perpustakaan Unair Kampus B', 'Surabaya, Jawa Timur', -7.2726067, 112.7583743, '2026-01-20 06:40:56', '2026-01-24 23:18:46', NULL, 1),
(17, 'Perpustakaan Unair Kampus C', 'Surabaya, Jawa Timur', -7.2681520, 112.7852050, '2026-01-20 06:40:56', '2026-01-24 23:18:54', NULL, 1),
(18, 'Perpustakaan Unesa', 'Surabaya, Jawa Timur', -7.3011280, 112.6730390, '2026-01-20 06:40:56', '2026-01-24 23:19:54', NULL, 1),
(19, 'Perpustakaan ITS', 'Surabaya, Jawa Timur', -7.2816370, 112.7956520, '2026-01-20 06:40:57', '2026-01-24 23:18:05', NULL, 1),
(20, 'Perpustakaan Nasional Republik Indonesia (Perpusnas RI)', 'Jl. Medan Merdeka Selatan No.11, Jakarta Pusat', -6.1896330, 106.8486140, '2026-01-24 04:19:50', '2026-01-24 23:17:56', NULL, 10),
(21, 'Perpustakaan Provinsi DKI', 'Jl. Cikini Raya No.73, Jakarta Pusat', -6.1890530, 106.8400190, '2026-01-24 04:21:42', '2026-01-24 23:17:47', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_28_121708_create_categories_table', 1),
(5, '2025_12_28_121719_create_libraries_table', 1),
(6, '2025_12_28_121740_create_books_table', 1),
(7, '2025_12_28_121749_create_book_library_table', 1),
(8, '2025_12_28_121802_create_borrowings_table', 1),
(9, '2025_12_29_045420_add_role_to_users_table', 2),
(10, '2026_01_07_141059_add_staff_id_to_borrowings', 3),
(11, '2026_01_08_002340_create_notifications_table', 4),
(12, '2026_01_18_083836_add_ban_fields_to_users_table', 5),
(13, '2026_01_18_083843_add_ban_fields_to_users_table', 5),
(14, '2026_01_20_120000_add_location_to_users_table', 6),
(15, '2026_01_20_120001_create_cities_table', 6),
(16, '2026_01_21_150000_create_reviews_table', 7),
(17, '2026_01_22_000000_add_city_id_to_users_table', 8),
(20, '2026_01_24_000000_create_activity_logs_table', 9),
(21, '2026_01_24_000001_add_canceled_fields_to_borrowings_table', 9),
(22, '2026_01_25_000000_add_city_id_to_libraries_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0c4a513d-074e-4687-8264-d21bdd3ab562', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"returned\",\"book_title\":\"how to sleep like a baby\"}', NULL, '2026-01-23 23:48:47', '2026-01-23 23:48:47'),
('0e630d69-fccd-4b27-b982-42e2a7962eac', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"approved\",\"book_title\":\"how to sleep like a baby\"}', NULL, '2026-01-21 22:35:41', '2026-01-21 22:35:41'),
('152e0342-ccd3-43a7-9461-d2041d5251d7', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"returned\",\"book_title\":\"CENTAURA\"}', NULL, '2026-01-24 23:45:23', '2026-01-24 23:45:23'),
('1ffd41b1-c1a8-4a05-bf57-72d73b4d3a3f', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"returned\",\"book_title\":\"how to sleep like a baby\"}', '2026-01-24 00:05:04', '2026-01-23 23:48:43', '2026-01-24 00:05:04'),
('2067695b-ac53-4dd6-836a-122faba02de7', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"rejected\",\"book_title\":\"the moon i rot behind\"}', '2026-01-18 01:58:08', '2026-01-18 01:57:13', '2026-01-18 01:58:08'),
('351b38d1-4c68-4e0c-b562-9305a94fa171', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"returned\",\"book_title\":\"ArmorMayhem\"}', NULL, '2026-01-23 23:48:50', '2026-01-23 23:48:50'),
('3746dd31-b2af-4ea0-8490-df81b6905b99', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"approved\",\"book_title\":\"ArmorMayhem\"}', '2026-01-18 01:58:08', '2026-01-18 01:57:27', '2026-01-18 01:58:08'),
('3afe19d2-e331-4e2e-a373-bb26f31a8441', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"returned\",\"book_title\":\"ArmorMayhem\"}', '2026-01-18 01:59:09', '2026-01-18 01:57:43', '2026-01-18 01:59:09'),
('46122a96-7fd1-4199-a802-34e0cd1d5e47', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"returned\",\"book_title\":\"the moon i rot behind\"}', '2026-01-16 07:42:56', '2026-01-16 07:34:17', '2026-01-16 07:42:56'),
('56364508-c20b-4317-95ef-dd9c5c136c48', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"returned\",\"book_title\":\"ArmorMayhem\"}', '2026-01-18 01:58:08', '2026-01-18 01:57:48', '2026-01-18 01:58:08'),
('6108cfd2-bee8-436b-b9c9-2fe641526bc6', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"approved\",\"book_title\":\"the moon i rot behind\"}', '2026-01-16 07:25:41', '2026-01-16 07:05:23', '2026-01-16 07:25:41'),
('674d05ab-6fcd-4966-8ebd-4be98e64ad58', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 9, '{\"status\":\"approved\",\"book_title\":\"ArmorMayhem\"}', NULL, '2026-01-25 05:30:18', '2026-01-25 05:30:18'),
('70289dd6-a3fe-484f-964b-d6f49d39d69c', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"rejected\",\"book_title\":\"the moon i rot behind\"}', '2026-01-16 22:38:43', '2026-01-16 22:36:35', '2026-01-16 22:38:43'),
('75562b1d-87b2-4542-85b1-aec4a53f5af5', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"approved\",\"book_title\":\"ArmorMayhem\"}', '2026-01-18 02:00:36', '2026-01-18 01:59:46', '2026-01-18 02:00:36'),
('7e9dbe76-9935-4860-8d47-726cda100021', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"approved\",\"book_title\":\"CENTAURA\"}', '2026-01-18 01:59:09', '2026-01-18 01:57:20', '2026-01-18 01:59:09'),
('82b90f11-c1c9-4b5f-8b11-2f24a9dd1127', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"rejected\",\"book_title\":\"BadThings\"}', '2026-01-18 01:58:08', '2026-01-18 01:57:18', '2026-01-18 01:58:08'),
('9050bb60-b00a-4a52-8558-62ae0454697b', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"rejected\",\"book_title\":\"ArmorMayhem\"}', '2026-01-18 02:00:56', '2026-01-18 01:59:51', '2026-01-18 02:00:56'),
('9a5524ca-979c-4ae3-b43b-094c0b345d14', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"returned\",\"book_title\":\"CENTAURA\"}', '2026-01-23 23:30:06', '2026-01-21 22:35:50', '2026-01-23 23:30:06'),
('bbdc9a6d-948b-45f4-affa-de4219cb5fbc', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"returned\",\"book_title\":\"the moon i rot behind\"}', '2026-01-16 07:42:56', '2026-01-16 07:34:58', '2026-01-16 07:42:56'),
('c751d3e1-8221-43fb-8730-2c451fe0db93', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"approved\",\"book_title\":\"CENTAURA\"}', '2026-01-23 23:30:09', '2026-01-21 22:35:38', '2026-01-23 23:30:09'),
('c8636e39-bd06-4040-9640-9b7a9d189426', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 8, '{\"status\":\"approved\",\"book_title\":\"BadThings\"}', NULL, '2026-01-25 05:30:14', '2026-01-25 05:30:14'),
('cb4b29b2-3d05-4f76-b90f-ebb96471599b', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"rejected\",\"book_title\":\"ArmorMayhem\"}', '2026-01-24 00:05:04', '2026-01-23 23:59:50', '2026-01-24 00:05:04'),
('d31f4085-98c1-4c3e-bb6f-096129f98758', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"approved\",\"book_title\":\"how to sleep like a baby\"}', '2026-01-24 00:05:05', '2026-01-23 23:48:33', '2026-01-24 00:05:05'),
('ee05c15e-cf62-409f-85ca-8392081f555d', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 1, '{\"status\":\"approved\",\"book_title\":\"the moon i rot behind\"}', '2026-01-16 06:46:54', '2026-01-16 06:44:20', '2026-01-16 06:46:54'),
('fd7e5077-06a7-4837-a461-94515bedef7a', 'App\\Notifications\\BorrowingStatusNotification', 'App\\Models\\User', 5, '{\"status\":\"approved\",\"book_title\":\"ArmorMayhem\"}', '2026-01-18 01:59:09', '2026-01-18 01:57:23', '2026-01-18 01:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 5, 'memiliki unsur ideaklisme dan diktator yang menarik, tapi gk ada cakwul', '2026-01-20 21:02:13', '2026-01-23 23:31:35'),
(3, 7, 5, 3, 'wish they add more', '2026-01-21 17:24:47', '2026-01-21 17:24:47'),
(5, 3, 1, 5, 'legend who know this should be got veteran', '2026-01-23 23:56:52', '2026-01-23 23:56:52'),
(6, 1, 1, 5, 'short story but good', '2026-01-24 00:05:49', '2026-01-24 00:05:49'),
(7, 7, 8, 5, 'wow', '2026-01-24 21:16:39', '2026-01-24 21:16:39'),
(8, 7, 9, 4, NULL, '2026-01-25 05:27:32', '2026-01-25 05:27:32'),
(9, 3, 8, 5, NULL, '2026-01-25 05:28:51', '2026-01-25 05:28:51'),
(10, 2, 8, 5, NULL, '2026-01-25 05:29:09', '2026-01-25 05:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dP22moLSAAAGgyoDaLEhxAsjdUPEFMUvDhV2Gqc5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 OPR/126.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2lNYlU1cjQyYTQ5SmZ5alV1YUhjWnN2VzZlbW5HQmh5R1JqUktOQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1769344280);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ban_until` timestamp NULL DEFAULT NULL COMMENT 'Ban expiry date, null = permanen',
  `banned_reason` text COLLATE utf8mb4_unicode_ci COMMENT 'Reason for ban',
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'User latitude for location-based services',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'User longitude for location-based services',
  `city_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `ban_until`, `banned_reason`, `latitude`, `longitude`, `city_id`) VALUES
(1, 'nero', 'dfnerocros@gmail.com', 'user', NULL, '$2y$12$imZUTZPeRD2Btr9PMxplOehBRPbZuLD0Ac8wd5dP6oMwsbbfGi0Bi', NULL, '2025-12-28 05:41:16', '2026-01-19 18:37:15', NULL, NULL, -7.25750000, 112.75210000, NULL),
(2, 'admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$FtVVbhDkGASrN4fVahU6euTN6gXZ8c/ykGdZAQWeELcxph8MqtSRS', NULL, '2025-12-28 21:14:55', '2025-12-28 22:53:56', NULL, NULL, NULL, NULL, NULL),
(3, 'staff', 'staff@gmail.com', 'staff', NULL, '$2y$12$iVaL6VDi.m.ly.wFVJoxeO1d2W2qjxqJmDLzTBtpEGWBNvY88Q//u', NULL, '2025-12-28 23:15:38', '2025-12-28 23:15:38', NULL, NULL, NULL, NULL, NULL),
(4, 'iqbahlil', 'pentol@gmail.com', 'staff', NULL, '$2y$12$PD/SpvVdiwyBPKzgbSbVRei.viAbqmQdcVwAwQEStnL2ZAzvIWcdm', NULL, '2026-01-18 01:53:27', '2026-01-18 01:53:27', NULL, NULL, NULL, NULL, NULL),
(5, 'dummy', 'test@gmail.com', 'user', NULL, '$2y$12$J8agmE1pW1zQIt1Q5FNxNO4eGCypNN5W.Hw3KmMMpPDGYSX02AnD.', NULL, '2026-01-18 01:55:14', '2026-01-21 17:56:16', NULL, NULL, -7.25750000, 112.75210000, 2),
(6, 'nero', 'nero@gmail.com', 'user', NULL, '$2y$12$PAmPVBKSIn2FPncpG.28J.kJ6Hj/7wk.KX8s5oJGXPoi.SjFOBzqu', NULL, '2026-01-20 06:56:11', '2026-01-20 06:56:11', NULL, NULL, -7.25750000, 112.75210000, NULL),
(7, 'iqbahlil', 'bals@gmail.com', 'user', NULL, '$2y$12$45BSpyZR9KcEtMydxW00wu5vSXrhtDlWXn7tfWoTOUPun0XFt5KJ.', NULL, '2026-01-20 19:29:32', '2026-01-20 19:29:32', NULL, NULL, -7.44240000, 112.71030000, NULL),
(8, 'jakarta', 'jak@gmail.com', 'user', NULL, '$2y$12$0Nf81Oqqj9wkKJp/CmPQvewm9riV09WHWQYbalgA4L.lIBNaJki1m', NULL, '2026-01-24 21:15:57', '2026-01-25 05:28:29', NULL, NULL, -6.18000000, 106.83000000, 1),
(9, 'surabaya', 'surba@gmail.com', 'user', NULL, '$2y$12$NjRpC83V9VP1ZJYNuq8NROd117dYgnXvSYzizmYgM/ZITU2d.5U0y', NULL, '2026-01-24 21:22:07', '2026-01-25 00:16:03', NULL, NULL, -7.25750000, 112.75210000, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_index` (`user_id`),
  ADD KEY `activity_logs_activity_type_index` (`activity_type`),
  ADD KEY `activity_logs_resource_type_index` (`resource_type`),
  ADD KEY `activity_logs_created_at_index` (`created_at`),
  ADD KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_category_id_foreign` (`category_id`);

--
-- Indexes for table `book_library`
--
ALTER TABLE `book_library`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_library_book_id_foreign` (`book_id`),
  ADD KEY `book_library_library_id_foreign` (`library_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowings_user_id_foreign` (`user_id`),
  ADD KEY `borrowings_book_id_foreign` (`book_id`),
  ADD KEY `borrowings_library_id_foreign` (`library_id`),
  ADD KEY `borrowings_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `libraries`
--
ALTER TABLE `libraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `libraries_city_id_foreign` (`city_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_book_id_user_id_unique` (`book_id`,`user_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_foreign` (`city_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `book_library`
--
ALTER TABLE `book_library`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `libraries`
--
ALTER TABLE `libraries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `book_library`
--
ALTER TABLE `book_library`
  ADD CONSTRAINT `book_library_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_library_library_id_foreign` FOREIGN KEY (`library_id`) REFERENCES `libraries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `borrowings_library_id_foreign` FOREIGN KEY (`library_id`) REFERENCES `libraries` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `borrowings_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `libraries`
--
ALTER TABLE `libraries`
  ADD CONSTRAINT `libraries_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
