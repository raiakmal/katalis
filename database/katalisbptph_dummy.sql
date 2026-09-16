-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2026 at 12:34 AM
-- Server version: 8.4.3
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `katalisbptph_dummy`
--

-- --------------------------------------------------------

--
-- Table structure for table `analyst_tasks`
--

CREATE TABLE `analyst_tasks` (
  `id` int NOT NULL,
  `request_id` int NOT NULL,
  `id_cms_analyst` int NOT NULL,
  `id_cms_staff` int DEFAULT NULL,
  `parameter` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `metode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int NOT NULL,
  `noik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Analis telah didaftarkan serta menunggu tindakan Analis',
  `ready_test_at` timestamp NULL DEFAULT NULL,
  `finish_test_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `analyst_tasks_bak`
--

CREATE TABLE `analyst_tasks_bak` (
  `id` int NOT NULL,
  `request_id` int NOT NULL,
  `id_cms_analyst` int NOT NULL,
  `id_cms_staff` int DEFAULT NULL,
  `parameter` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `metode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Analis telah didaftarkan serta menunggu tindakan Analis',
  `ready_test_at` timestamp NULL DEFAULT NULL,
  `finish_test_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_apicustom`
--

CREATE TABLE `cms_apicustom` (
  `id` int UNSIGNED NOT NULL,
  `permalink` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kolom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_query_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sql_where` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `method_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `responses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_apikey`
--

CREATE TABLE `cms_apikey` (
  `id` int UNSIGNED NOT NULL,
  `screetkey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hit` int DEFAULT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_dashboard`
--

CREATE TABLE `cms_dashboard` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_email_queues`
--

CREATE TABLE `cms_email_queues` (
  `id` int UNSIGNED NOT NULL,
  `send_at` datetime DEFAULT NULL,
  `email_recipient` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_cc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_sent` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_email_templates`
--

CREATE TABLE `cms_email_templates` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_email_templates`
--

INSERT INTO `cms_email_templates` (`id`, `name`, `slug`, `subject`, `content`, `description`, `from_name`, `from_email`, `cc_email`, `created_at`, `updated_at`) VALUES
(1, 'Lupa Kata Sandi', 'forgot_password', 'Lupa Kata Sandi', '<p>Hai, [name]</p><p>Ini merupakan kata sandi terbaru kamu : <b>[password]</b></p><p><b><font color=\"#ff0000\">Mohon setelah melakukan login, segera masuk ke halaman profil di menu pojok kanan atas, lalu lakukan ubah kata sandi.</font></b></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>', 'Lupa Kata Sandi', 'KATALIS - Satuan Pelayanan Laboratorium Kimia Agro', 'katalis@jabarprov.go.id', NULL, '2020-01-23 11:26:00', '2022-12-19 05:08:01'),
(2, 'Pendaftaran Baru', 'register_account', 'Pendaftaran Baru', '<p>Hai, [name]</p><p>Ini merupakan alamat email &amp; kata sandi Anda untuk dapat login kedalam sistem: </p><p>Email:<b> [email]</b></p><p>Password:<b> [password]</b></p><p><b><font color=\"#ff0000\">Mohon setelah melakukan login, segera masuk ke halaman profil di menu pojok kanan atas, lalu lakukan ubah kata sandi.</font></b></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>', 'Pendaftaran Baru', 'KATALIS - Satuan Pelayanan Laboratorium Kimia Agro', 'katalis@jabarprov.go.id', NULL, '2020-01-23 11:26:00', '2022-12-19 05:07:56'),
(3, 'Informasi Terbaru Dari Permohonan', 'new_updates', 'Informasi Terbaru Dari Permohonan', '<p>Hai, [name]</p><p>Ini merupakan informasi terbaru dari Permohonan dengan informasi sbb:</p><p> </p><p>No. Dokumen:<b> [document_no]</b></p><p>Status Terbaru:<b> [status]</b></p><p><b><br></b></p><p>[notes]</p><p><br></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>', 'Pendaftaran Baru', 'KATALIS - Satuan Pelayanan Laboratorium Kimia Agro', 'katalis@jabarprov.go.id', NULL, '2020-01-23 11:26:00', '2022-12-19 05:07:50'),
(4, 'Informasi Terbaru', 'new_updates_2', 'Informasi Terbaru Dari Permohonan', '<p>Hai, [name]</p><p>Ini merupakan informasi terbaru dari Permohonan dengan informasi sbb:</p><p><br></p><p> </p><p>No. Dokumen:<b> [document_no]</b></p><p>Asal Sampel:<span style=\"font-weight: 700;\">&nbsp;[asal_sampel]</span></p><p>Alamat:<span style=\"font-weight: 700;\">&nbsp;[alamat]</span></p><p>Nama Sampel:<span style=\"font-weight: 700;\">&nbsp;[nama_sampel]</span></p><p>Jumlah Sampel:<span style=\"font-weight: 700;\">&nbsp;[jumlah_sampel]</span></p>Jenis Pengujian:<span style=\"font-weight: 700;\">&nbsp;[jenis_pengujian]</span><p></p><p></p><p>Status Terakhir:<b> [status]</b></p><p><b><br></b></p><p>[notes]</p><p><br></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>', 'Pendaftaran Baru', 'KATALIS - Satuan Pelayanan Laboratorium Kimia Agro', 'katalis@jabarprov.go.id', NULL, '2020-01-23 11:26:00', '2022-12-19 05:07:46'),
(5, 'Informasi Perkiraan Waktu Penyelesaian', 'new_updates_3', 'Informasi Perkiraan Waktu Penyelesaian Dari Permohonan', '<p>Hai, [name]</p><p>Ini merupakan informasi terbaru terkait perkiraan waktu penyelesaian dari Permohonan dengan informasi sbb:</p><p><br></p><p> </p><p>No. Dokumen:<b> [document_no]</b></p><p>Asal Sampel:<span style=\"font-weight: 700;\">&nbsp;[asal_sampel]</span></p><p>Alamat:<span style=\"font-weight: 700;\">&nbsp;[alamat]</span></p><p>Nama Sampel:<span style=\"font-weight: 700;\">&nbsp;[nama_sampel]</span></p><p>Jumlah Sampel:<span style=\"font-weight: 700;\">&nbsp;[jumlah_sampel]</span></p>Jenis Pengujian:<span style=\"font-weight: 700;\">&nbsp;[jenis_pengujian]</span><p></p><p></p><p>Perkiraan Waktu Selesai Pengujian:<span style=\"font-weight: 700;\">&nbsp;[perkiraan]</span></p><p>Status Terakhir:<b> [status]</b></p><p><b><br></b></p><p>[notes]</p><p><br></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro</p>', 'Informasi Perkiraan Waktu', 'KATALIS - Satuan Pelayanan Laboratorium Kimia Agro', 'katalis@jabarprov.go.id', NULL, '2020-01-23 11:26:00', '2022-12-19 05:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `cms_informations`
--

CREATE TABLE `cms_informations` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `id_cms_information_categories` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_information_categories`
--

CREATE TABLE `cms_information_categories` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_kabupatens`
--

CREATE TABLE `cms_kabupatens` (
  `id` int NOT NULL,
  `id_cms_provinsis` int NOT NULL,
  `kd_prov` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `kd_kab` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_logs`
--

CREATE TABLE `cms_logs` (
  `id` int UNSIGNED NOT NULL,
  `ipaddress` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useragent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_cms_users` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_logs`
--

INSERT INTO `cms_logs` (`id`, `ipaddress`, `useragent`, `url`, `description`, `details`, `id_cms_users`, `created_at`, `updated_at`) VALUES
(29636, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/login', 'pelanggan@dummy.com login dengan IP Address 127.0.0.1', '', 5, '2026-07-07 08:40:18', NULL),
(29637, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/new-requests/add', 'Mencoba menambah data Permohonan Baru', '', 5, '2026-07-07 08:40:20', NULL),
(29638, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/requests', 'Mencoba melihat data :name pada Daftar Permohonan', '', 5, '2026-07-07 08:40:25', NULL),
(29639, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/new-requests/add', 'Mencoba menambah data Permohonan Baru', '', 5, '2026-07-07 08:40:28', NULL),
(29640, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/logout', 'pelanggan@dummy.com keluar', '', 5, '2026-07-07 08:40:36', NULL),
(29641, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/login', 'pemantau@dummy.com login dengan IP Address 127.0.0.1', '', 6, '2026-07-07 08:40:46', NULL),
(29642, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/requests', 'Mencoba melihat data :name pada Daftar Permohonan', '', 6, '2026-07-07 08:40:48', NULL),
(29643, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/analyst-tasks', 'Mencoba melihat data :name pada Daftar Tugas Analis', '', 6, '2026-07-07 08:40:50', NULL),
(29644, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/ratings', 'Mencoba melihat data :name pada Penilaian Pelanggan', '', 6, '2026-07-07 08:40:52', NULL),
(29645, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/customers', 'Mencoba melihat data :name pada Data Pelanggan', '', 6, '2026-07-07 08:40:55', NULL),
(29646, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/login', 'pelanggan@dummy.com login dengan IP Address 127.0.0.1', '', 5, '2026-07-07 09:13:57', NULL),
(29647, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/logout', 'pelanggan@dummy.com keluar', '', 5, '2026-07-07 09:14:27', NULL),
(29648, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/login', 'koord_teknispenyelia@dummy.com login dengan IP Address 127.0.0.1', '', 3, '2026-07-07 09:14:38', NULL),
(29649, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/admin/logout', 'koord_teknispenyelia@dummy.com keluar', '', 3, '2026-07-08 00:31:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus`
--

CREATE TABLE `cms_menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'url',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `id_cms_privileges` int DEFAULT NULL,
  `sorting` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_menus`
--

INSERT INTO `cms_menus` (`id`, `name`, `type`, `path`, `color`, `icon`, `parent_id`, `is_active`, `is_dashboard`, `id_cms_privileges`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 'Manajemen Data', 'URL', '#', 'normal', 'fas fa-list', 0, 1, 0, 1, 6, '2020-10-12 09:07:59', '2021-10-19 09:54:56'),
(2, 'Manajemen Pengguna', 'URL', '#', 'normal', 'fas fa-list', 0, 1, 0, 1, 4, '2020-10-12 09:07:59', '2021-07-26 02:58:15'),
(3, 'Verifikasi Pelanggan Baru', 'Route', 'AdminCmsVerifyCustomersControllerGetIndex', 'normal', 'fas fa-user-check', 2, 1, 0, 1, 1, '2020-10-12 02:17:23', '2021-07-26 03:12:14'),
(4, 'Data Pelanggan', 'Route', 'AdminCmsCustomersControllerGetIndex', 'normal', 'fas fa-users', 2, 1, 0, 1, 2, '2020-10-12 02:17:23', '2021-07-26 03:02:03'),
(5, 'Data Pemantau', 'Route', 'AdminCmsAdminsControllerGetIndex', 'normal', 'fas fa-user-secret', 2, 1, 0, 1, 3, '2020-10-12 02:17:23', '2021-07-26 02:59:01'),
(6, 'Permohonan Baru', 'Route', 'AdminCmsNewRequestsControllerGetAdd', 'normal', 'fas fa-star', 27, 1, 0, 1, 1, '2020-10-12 02:17:23', '2021-07-22 16:49:24'),
(7, 'Data Pengujian', 'URL', '#', 'normal', 'fas fa-prescription-bottle', 0, 1, 0, 1, 2, '2020-10-12 09:07:59', '2022-11-01 06:57:08'),
(8, 'Parameter Uji', 'Route', 'AdminCmsParametersControllerGetIndex', 'normal', 'fas fa-th', 1, 1, 0, 1, 1, '2020-10-12 02:17:23', '2021-10-19 09:55:59'),
(9, 'Daftar Permohonan', 'Route', 'AdminCmsRequestsControllerGetIndex', 'normal', 'fas fa-list-ol', 7, 1, 0, 1, 1, '2020-10-12 02:17:23', '2022-11-01 06:57:30'),
(10, 'Data Petugas', 'Route', 'AdminCmsMTsControllerGetIndex', 'normal', 'fas fa-user-secret', 2, 1, 0, 1, 4, '2020-10-12 02:17:23', '2021-07-26 02:52:55'),
(21, 'Laporan Hasil Pengujian', 'Route', 'AdminCmsResultsControllerGetIndex', 'normal', 'fas fa-calculator', 0, 0, 0, 1, 1, '2020-10-12 02:17:23', '2021-07-26 03:01:50'),
(22, 'Daftar Tugas Analis', 'Route', 'AdminCmsAnalystTasksControllerGetIndex', 'normal', 'fas fa-prescription-bottle-alt', 7, 1, 0, 1, 2, '2020-10-12 02:17:23', '2021-07-30 08:51:50'),
(23, 'Penilaian Pelanggan', 'Route', 'AdminCmsRatingsControllerGetIndex', 'normal', 'fas fa-star', 0, 1, 0, 1, 5, '2020-10-12 02:17:23', '2021-08-06 04:48:04'),
(24, 'Laporan', 'URL', '#', 'normal', 'fas fa-th-large', 0, 0, 0, 1, 2, '2020-10-12 09:07:59', '2021-09-08 15:21:14'),
(25, 'Laporan PNBP', 'Route', 'AdminCmsReportPNBPControllerGetIndex', 'normal', 'fas fa-chart-line', 24, 0, 0, 1, 1, '2020-10-12 02:17:23', '2021-09-08 15:23:36'),
(26, 'Faqs', 'Route', 'AdminCmsFaqsControllerGetIndex', 'normal', 'fas fa-question', 0, 0, 0, 1, 3, '2020-10-12 02:17:23', '2021-10-19 09:04:45'),
(27, 'Pengujian Saya', 'URL', '#', 'normal', 'fas fa-list-ul', 0, 1, 0, 1, 1, '2022-11-01 06:54:36', NULL),
(28, 'Lacak Permohonan', 'Route', 'AdminCmsRequestsControllerGetIndex', 'normal', 'fas fa-receipt', 27, 1, 0, 1, 2, '2020-10-12 02:17:23', '2022-11-01 06:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus_privileges`
--

CREATE TABLE `cms_menus_privileges` (
  `id` int UNSIGNED NOT NULL,
  `id_cms_menus` int DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_menus_privileges`
--

INSERT INTO `cms_menus_privileges` (`id`, `id_cms_menus`, `id_cms_privileges`) VALUES
(92, 19, 1),
(93, 19, 2),
(120, 20, 3),
(121, 20, 1),
(132, 6, 5),
(138, 10, 6),
(139, 10, 1),
(140, 2, 6),
(141, 2, 3),
(142, 2, 2),
(143, 2, 1),
(147, 5, 6),
(148, 5, 1),
(165, 21, 6),
(166, 21, 4),
(167, 21, 3),
(168, 21, 5),
(169, 21, 2),
(170, 21, 1),
(171, 4, 6),
(172, 4, 3),
(173, 4, 2),
(174, 4, 1),
(175, 3, 2),
(176, 3, 1),
(182, 22, 6),
(183, 22, 4),
(184, 22, 3),
(185, 22, 2),
(186, 22, 1),
(187, 23, 6),
(188, 23, 3),
(189, 23, 1),
(190, 24, 6),
(191, 24, 1),
(192, 25, 6),
(193, 25, 1),
(194, 26, 6),
(195, 26, 1),
(196, 1, 6),
(197, 1, 3),
(198, 1, 1),
(199, 8, 6),
(200, 8, 3),
(201, 8, 1),
(202, 27, 5),
(203, 28, 5),
(204, 7, 6),
(205, 7, 4),
(206, 7, 3),
(207, 7, 2),
(208, 7, 1),
(209, 9, 6),
(210, 9, 3),
(211, 9, 2),
(212, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_moduls`
--

CREATE TABLE `cms_moduls` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_moduls`
--

INSERT INTO `cms_moduls` (`id`, `name`, `icon`, `path`, `table_name`, `controller`, `is_protected`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Notifications', 'fa fa-cog', 'notifications', 'cms_notifications', 'NotificationsController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(2, 'Privileges', 'fa fa-cog', 'privileges', 'cms_privileges', 'PrivilegesController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(3, 'Privileges Roles', 'fa fa-cog', 'privileges_roles', 'cms_privileges_roles', 'PrivilegesRolesController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(4, 'Users Management', 'fa fa-users', 'users', 'cms_users', 'AdminCmsUsersController', 0, 1, '2020-01-23 11:26:00', NULL, NULL),
(5, 'Settings', 'fa fa-cog', 'settings', 'cms_settings', 'SettingsController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(6, 'Module Generator', 'fa fa-database', 'module_generator', 'cms_moduls', 'ModulsController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(7, 'Menu Management', 'fa fa-bars', 'menu_management', 'cms_menus', 'MenusController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(8, 'Email Templates', 'fa fa-envelope-o', 'email_templates', 'cms_email_templates', 'EmailTemplatesController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(9, 'Statistic Builder', 'fa fa-dashboard', 'statistic_builder', 'cms_statistics', 'StatisticBuilderController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(10, 'API Generator', 'fa fa-cloud-download', 'api_generator', '', 'ApiCustomController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(11, 'Log User Access', 'fa fa-flag-o', 'logs', 'cms_logs', 'LogsController', 1, 1, '2020-01-23 11:26:00', NULL, NULL),
(12, 'Data Pemantau', 'fa fa-user-secret', 'admins', 'cms_users', 'AdminCmsAdminsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(13, 'Data Pelanggan', 'fa fa-users', 'customers', 'cms_users', 'AdminCmsCustomersController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(14, 'Verifikasi Pelanggan Baru', 'fa fa-user-plus', 'verify-customers', 'cms_users', 'AdminCmsVerifyCustomersController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(15, 'Parameter Uji', 'fa fa-th', 'parameters', 'parameters', 'AdminCmsParametersController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(16, 'Permohonan Baru', 'fa fa-plus-circle', 'new-requests', 'requests', 'AdminCmsNewRequestsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(17, 'Daftar Permohonan', 'fa fa-list-ol', 'requests', 'requests', 'AdminCmsRequestsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(18, 'Laporan Hasil Pengujian', 'fa fa-calculator', 'results', 'results', 'AdminCmsResultsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(19, 'Daftar Parameter Uji', 'fa fa-list-ul', 'request-testings', 'request_testings', 'AdminCmsRequestTestingsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(20, 'Data Petugas', 'fa fa-user-secret', 'staffs', 'cms_users', 'AdminCmsMTsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(21, 'Daftar Tugas Analis', 'fas fa-prescription-bottle-alt', 'analyst-tasks', 'analyst_tasks', 'AdminCmsAnalystTasksController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(22, 'Penilaian Pelanggan', 'fas fa-star', 'ratings', 'ratings', 'AdminCmsRatingsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(23, 'Laporan PNBP', 'fas fa-chart-line', 'report-pnbp', 'requests', 'AdminCmsReportPNBPController', 0, 0, '2020-10-12 05:33:54', NULL, NULL),
(24, 'Faqs', 'fas fa-question', 'faqs', 'faqs', 'AdminCmsFaqsController', 0, 0, '2020-10-12 05:33:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_notifications`
--

CREATE TABLE `cms_notifications` (
  `id` int UNSIGNED NOT NULL,
  `id_cms_users` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_privileges`
--

CREATE TABLE `cms_privileges` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin` tinyint(1) DEFAULT NULL,
  `theme_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_privileges`
--

INSERT INTO `cms_privileges` (`id`, `name`, `is_superadmin`, `theme_color`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, 'skin-green-light', '2020-01-23 11:26:00', NULL),
(2, 'Koord. Adm./Pengelola Contoh', 0, 'skin-green-light', NULL, NULL),
(3, 'Koord. Teknis/Penyelia', 0, 'skin-green-light', NULL, NULL),
(4, 'Analis', 0, 'skin-green-light', NULL, NULL),
(5, 'Pelanggan', 0, 'skin-green-light', NULL, NULL),
(6, 'Pemantau', 0, 'skin-green-light', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_privileges_roles`
--

CREATE TABLE `cms_privileges_roles` (
  `id` int UNSIGNED NOT NULL,
  `is_visible` tinyint(1) DEFAULT NULL,
  `is_create` tinyint(1) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `is_edit` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `id_cms_moduls` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_privileges_roles`
--

INSERT INTO `cms_privileges_roles` (`id`, `is_visible`, `is_create`, `is_read`, `is_edit`, `is_delete`, `id_cms_privileges`, `id_cms_moduls`, `created_at`, `updated_at`) VALUES
(56, 1, 1, 0, 1, 0, 5, 19, NULL, NULL),
(57, 1, 1, 1, 1, 0, 5, 17, NULL, NULL),
(58, 0, 1, 0, 0, 0, 5, 16, NULL, NULL),
(59, 0, 0, 0, 1, 1, 5, 4, NULL, NULL),
(97, 1, 0, 1, 0, 0, 4, 21, NULL, NULL),
(98, 1, 0, 1, 0, 0, 4, 13, NULL, NULL),
(99, 1, 0, 1, 1, 1, 4, 4, NULL, NULL),
(181, 1, 0, 1, 0, 0, 6, 19, NULL, NULL),
(182, 1, 0, 1, 0, 0, 6, 17, NULL, NULL),
(183, 1, 0, 1, 0, 0, 6, 21, NULL, NULL),
(184, 1, 0, 1, 0, 0, 6, 13, NULL, NULL),
(185, 1, 0, 1, 0, 0, 6, 12, NULL, NULL),
(186, 1, 0, 1, 0, 0, 6, 20, NULL, NULL),
(187, 1, 1, 1, 1, 1, 6, 24, NULL, NULL),
(188, 1, 0, 1, 0, 0, 6, 22, NULL, NULL),
(196, 1, 0, 1, 1, 0, 3, 17, NULL, NULL),
(197, 1, 0, 1, 1, 0, 3, 21, NULL, NULL),
(198, 1, 1, 1, 1, 0, 3, 13, NULL, NULL),
(199, 1, 1, 1, 1, 0, 3, 18, NULL, NULL),
(200, 1, 0, 1, 1, 0, 3, 15, NULL, NULL),
(201, 1, 0, 1, 0, 0, 3, 22, NULL, NULL),
(202, 1, 0, 1, 1, 0, 3, 16, NULL, NULL),
(203, 0, 0, 0, 1, 0, 3, 4, NULL, NULL),
(204, 1, 0, 1, 0, 0, 3, 14, NULL, NULL),
(205, 1, 0, 1, 1, 0, 2, 17, NULL, NULL),
(206, 1, 0, 1, 0, 0, 2, 21, NULL, NULL),
(207, 1, 0, 1, 0, 0, 2, 13, NULL, NULL),
(208, 1, 0, 1, 1, 0, 2, 18, NULL, NULL),
(209, 1, 0, 1, 0, 0, 2, 22, NULL, NULL),
(210, 1, 0, 1, 1, 0, 2, 16, NULL, NULL),
(211, 0, 0, 0, 1, 1, 2, 4, NULL, NULL),
(212, 1, 0, 1, 1, 1, 2, 14, NULL, NULL),
(214, 1, 0, 0, 0, 0, 1, 25, '2026-07-07 08:36:41', NULL),
(215, 1, 1, 1, 1, 1, 1, 26, '2026-07-07 08:36:41', NULL),
(216, 0, 1, 1, 1, 1, 1, 27, '2026-07-07 08:36:41', NULL),
(217, 1, 1, 1, 1, 1, 1, 28, '2026-07-07 08:36:41', NULL),
(218, 1, 1, 1, 1, 1, 1, 29, '2026-07-07 08:36:41', NULL),
(219, 1, 1, 1, 1, 1, 1, 30, '2026-07-07 08:36:41', NULL),
(220, 1, 1, 1, 1, 1, 1, 31, '2026-07-07 08:36:41', NULL),
(221, 1, 1, 1, 1, 1, 1, 32, '2026-07-07 08:36:41', NULL),
(222, 1, 1, 1, 1, 1, 1, 33, '2026-07-07 08:36:41', NULL),
(223, 1, 1, 1, 1, 1, 1, 34, '2026-07-07 08:36:41', NULL),
(224, 1, 0, 1, 0, 1, 1, 35, '2026-07-07 08:36:41', NULL),
(225, 1, 1, 1, 1, 1, 1, 16, '2026-07-07 09:01:16', NULL),
(226, 1, 1, 1, 1, 1, 1, 20, '2026-07-07 09:01:16', NULL),
(227, 1, 1, 1, 1, 1, 1, 12, '2026-07-07 09:01:16', NULL),
(228, 1, 1, 1, 1, 1, 1, 18, '2026-07-07 09:01:16', NULL),
(229, 1, 1, 1, 1, 1, 1, 13, '2026-07-07 09:01:16', NULL),
(230, 1, 1, 1, 1, 1, 1, 14, '2026-07-07 09:01:16', NULL),
(231, 1, 1, 1, 1, 1, 1, 21, '2026-07-07 09:01:16', NULL),
(232, 1, 1, 1, 1, 1, 1, 22, '2026-07-07 09:01:16', NULL),
(233, 1, 1, 1, 1, 1, 1, 23, '2026-07-07 09:01:16', NULL),
(234, 1, 1, 1, 1, 1, 1, 24, '2026-07-07 09:01:16', NULL),
(235, 1, 1, 1, 1, 1, 1, 15, '2026-07-07 09:01:16', NULL),
(236, 1, 1, 1, 1, 1, 1, 17, '2026-07-07 09:01:16', NULL),
(237, 1, 0, 1, 0, 0, 5, 18, '2026-07-07 09:10:00', NULL),
(238, 1, 1, 1, 1, 0, 4, 18, NULL, NULL),
(239, 1, 1, 1, 1, 0, 6, 18, NULL, NULL),
(240, 1, 1, 1, 1, 0, 6, 23, NULL, NULL),
(241, 1, 1, 1, 1, 0, 6, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_provinsis`
--

CREATE TABLE `cms_provinsis` (
  `id` int NOT NULL,
  `kd_prov` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

CREATE TABLE `cms_settings` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content_input_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataenum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helper` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_setting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `name`, `content`, `content_input_type`, `dataenum`, `helper`, `created_at`, `updated_at`, `group_setting`, `label`) VALUES
(1, 'login_background_color', 'white', 'text', NULL, 'Input hexacode', '2020-01-23 11:26:00', NULL, 'Login Register Style', 'Login Background Color'),
(2, 'login_font_color', NULL, 'text', NULL, 'Input hexacode', '2020-01-23 11:26:00', NULL, 'Login Register Style', 'Login Font Color'),
(3, 'login_background_image', 'uploads/2020-10/50533576b58ceb07437eba354a5c8700.jpg', 'upload_image', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Login Register Style', 'Login Background Image'),
(4, 'email_sender', 'katalis@jabarprov.go.id', 'text', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Email Setting', 'Email Sender'),
(5, 'smtp_driver', 'smtp', 'select', 'smtp,mail,sendmail', NULL, '2020-01-23 11:26:00', NULL, 'Email Setting', 'Mail Driver'),
(6, 'smtp_host', 'smtp.jabarprov.go.id', 'text', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Email Setting', 'SMTP Host'),
(7, 'smtp_port', '25', 'text', NULL, 'default 25', '2020-01-23 11:26:00', NULL, 'Email Setting', 'SMTP Port'),
(8, 'smtp_username', 'katalis@jabarprov.go.id', 'text', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Email Setting', 'SMTP Username'),
(9, 'smtp_password', 'SanGgabUana%487', 'text', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Email Setting', 'SMTP Password'),
(10, 'appname', 'KATALIS', 'text', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Application Setting', 'Application Name'),
(11, 'default_paper_size', 'A4', 'text', NULL, 'Paper size, ex : A4, Legal, etc', '2020-01-23 11:26:00', NULL, 'Application Setting', 'Default Paper Print Size'),
(12, 'logo', 'uploads/2022-11/aa0bee19f789fa22de5e5d427ee61857.png', 'upload_image', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Application Setting', 'Logo'),
(13, 'favicon', 'uploads/2022-11/2f964a340612d2c572ec6d2a13795288.png', 'upload_image', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Application Setting', 'Favicon'),
(14, 'api_debug_mode', 'false', 'select', 'true,false', NULL, '2020-01-23 11:26:00', NULL, 'Application Setting', 'API Debug Mode'),
(15, 'google_api_key', NULL, 'text', NULL, NULL, '2020-01-23 11:26:00', NULL, 'Application Setting', 'Google API Key'),
(20, 'whatsapp', '62811112431', 'text', NULL, 'Nomor WA saat akun belum terdaftar', '2020-09-01 20:04:44', NULL, 'Application Setting', 'WhatsApp'),
(21, 'maklumat_pelayanan', 'uploads/2021-08/53b83b74c120198fe6a329849100e589.jpg', 'upload_image', NULL, 'Upload Gambar Maklumat', '2021-08-30 12:44:47', '2021-08-30 12:45:24', 'Maklumat Setting', 'Maklumat Pelayanan'),
(22, 'jenis_layanan', 'uploads/2021-09/bab8ddc44ea60aaf07a97ff62896e8ea.png', 'upload_image', NULL, NULL, '2021-09-10 05:07:40', NULL, 'Jenis Layanan Setting', 'Jenis Layanan');

-- --------------------------------------------------------

--
-- Table structure for table `cms_statistics`
--

CREATE TABLE `cms_statistics` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_statistic_components`
--

CREATE TABLE `cms_statistic_components` (
  `id` int UNSIGNED NOT NULL,
  `id_cms_statistics` int DEFAULT NULL,
  `componentID` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_name` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sorting` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE `cms_users` (
  `id` int UNSIGNED NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'images/pp.jpg',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '$2y$10$diRQeu5/BkxPEloxKyfmFuKyHEi0eQ/RSJdUuPVz6w5mUs7fiecL.',
  `platform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_provinsis` int DEFAULT NULL,
  `id_cms_kabupatens` int DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `is_mou` tinyint NOT NULL DEFAULT '0',
  `verifier` int DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Active',
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `nip`, `name`, `company`, `photo`, `email`, `phone`, `address`, `password`, `platform`, `id_cms_provinsis`, `id_cms_kabupatens`, `id_cms_privileges`, `is_mou`, `verifier`, `verified_at`, `status`, `kategori`, `created_at`, `updated_at`) VALUES
(1, NULL, 'User Super Admin', NULL, 'images/pp.jpg', 'super_admin@dummy.com', NULL, NULL, '$2y$10$0W0z0k6Kk3fE9UzFolvlouXi.tTIcAnbeerVDt/s3EuU.7xbMU.uG', NULL, NULL, NULL, 1, 0, NULL, NULL, 'Active', '', '2026-07-07 08:39:25', '2026-07-07 08:39:25'),
(2, NULL, 'User Koord. Adm./Pengelola Contoh', NULL, 'images/pp.jpg', 'koord_admpengelola_contoh@dummy.com', NULL, NULL, '$2y$10$0W0z0k6Kk3fE9UzFolvlouXi.tTIcAnbeerVDt/s3EuU.7xbMU.uG', NULL, NULL, NULL, 2, 0, NULL, NULL, 'Active', '', '2026-07-07 08:39:25', '2026-07-07 08:39:25'),
(3, NULL, 'User Koord. Teknis/Penyelia', NULL, 'images/pp.jpg', 'koord_teknispenyelia@dummy.com', NULL, NULL, '$2y$10$0W0z0k6Kk3fE9UzFolvlouXi.tTIcAnbeerVDt/s3EuU.7xbMU.uG', NULL, NULL, NULL, 3, 0, NULL, NULL, 'Active', '', '2026-07-07 08:39:25', '2026-07-07 08:39:25'),
(4, NULL, 'User Analis', NULL, 'images/pp.jpg', 'analis@dummy.com', NULL, NULL, '$2y$10$0W0z0k6Kk3fE9UzFolvlouXi.tTIcAnbeerVDt/s3EuU.7xbMU.uG', NULL, NULL, NULL, 4, 0, NULL, NULL, 'Active', '', '2026-07-07 08:39:25', '2026-07-07 08:39:25'),
(5, NULL, 'User Pelanggan', NULL, 'images/pp.jpg', 'pelanggan@dummy.com', NULL, NULL, '$2y$10$0W0z0k6Kk3fE9UzFolvlouXi.tTIcAnbeerVDt/s3EuU.7xbMU.uG', NULL, NULL, NULL, 5, 0, NULL, NULL, 'Active', '', '2026-07-07 08:39:25', '2026-07-07 08:39:25'),
(6, NULL, 'User Pemantau', NULL, 'images/pp.jpg', 'pemantau@dummy.com', NULL, NULL, '$2y$10$0W0z0k6Kk3fE9UzFolvlouXi.tTIcAnbeerVDt/s3EuU.7xbMU.uG', NULL, NULL, NULL, 6, 0, NULL, NULL, 'Active', '', '2026-07-07 08:39:25', '2026-07-07 08:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `customs`
--

CREATE TABLE `customs` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int NOT NULL,
  `question` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `answer` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` int NOT NULL,
  `request_id` int NOT NULL,
  `id_cms_users` int NOT NULL,
  `notes` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `id` int NOT NULL,
  `type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `parameter` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `noik` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `price` int NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int NOT NULL,
  `id_cms_users` int NOT NULL,
  `request_id` int NOT NULL,
  `questions` text NOT NULL,
  `notes` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `rating` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `document_no` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_cms_users` int NOT NULL,
  `type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo_1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `size` int NOT NULL,
  `unit` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `unit_others` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `testings` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `param_ready` tinyint NOT NULL DEFAULT '0',
  `noik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `metode` tinyint DEFAULT NULL,
  `sdm` tinyint DEFAULT NULL,
  `bahan_standar` tinyint DEFAULT NULL,
  `bahan_kimia` tinyint DEFAULT NULL,
  `alat` tinyint DEFAULT NULL,
  `estimation_dt` date DEFAULT NULL,
  `kesimpulan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `file_1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `billing_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `report_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `proof_file` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `lhp_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_cms_mt` int DEFAULT NULL,
  `id_cms_staffs` int DEFAULT NULL,
  `id_cms_analyst` int DEFAULT NULL,
  `total` int NOT NULL DEFAULT '0',
  `notes` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Permohonan Baru',
  `questioner_status` tinyint DEFAULT NULL,
  `ready_test_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analyst_tasks`
--
ALTER TABLE `analyst_tasks`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `analyst_tasks_bak`
--
ALTER TABLE `analyst_tasks_bak`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_apicustom`
--
ALTER TABLE `cms_apicustom`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_apikey`
--
ALTER TABLE `cms_apikey`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_dashboard`
--
ALTER TABLE `cms_dashboard`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_email_queues`
--
ALTER TABLE `cms_email_queues`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_email_templates`
--
ALTER TABLE `cms_email_templates`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_informations`
--
ALTER TABLE `cms_informations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_information_categories`
--
ALTER TABLE `cms_information_categories`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_kabupatens`
--
ALTER TABLE `cms_kabupatens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_cms_provinsis_index` (`id_cms_provinsis`) USING BTREE,
  ADD KEY `kd_prov` (`kd_prov`) USING BTREE,
  ADD KEY `kd_kab` (`kd_kab`) USING BTREE;

--
-- Indexes for table `cms_logs`
--
ALTER TABLE `cms_logs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_menus`
--
ALTER TABLE `cms_menus`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_menus_privileges`
--
ALTER TABLE `cms_menus_privileges`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_moduls`
--
ALTER TABLE `cms_moduls`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_notifications`
--
ALTER TABLE `cms_notifications`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_privileges`
--
ALTER TABLE `cms_privileges`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_privileges_roles`
--
ALTER TABLE `cms_privileges_roles`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_provinsis`
--
ALTER TABLE `cms_provinsis`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `kd_prov` (`kd_prov`) USING BTREE;

--
-- Indexes for table `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_statistics`
--
ALTER TABLE `cms_statistics`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_statistic_components`
--
ALTER TABLE `cms_statistic_components`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `customs`
--
ALTER TABLE `customs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `jobs_queue_index` (`queue`(191)) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analyst_tasks`
--
ALTER TABLE `analyst_tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9016;

--
-- AUTO_INCREMENT for table `analyst_tasks_bak`
--
ALTER TABLE `analyst_tasks_bak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_apicustom`
--
ALTER TABLE `cms_apicustom`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_apikey`
--
ALTER TABLE `cms_apikey`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_dashboard`
--
ALTER TABLE `cms_dashboard`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_email_queues`
--
ALTER TABLE `cms_email_queues`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_email_templates`
--
ALTER TABLE `cms_email_templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cms_informations`
--
ALTER TABLE `cms_informations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `cms_information_categories`
--
ALTER TABLE `cms_information_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_kabupatens`
--
ALTER TABLE `cms_kabupatens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT for table `cms_logs`
--
ALTER TABLE `cms_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29650;

--
-- AUTO_INCREMENT for table `cms_menus`
--
ALTER TABLE `cms_menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cms_menus_privileges`
--
ALTER TABLE `cms_menus_privileges`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `cms_moduls`
--
ALTER TABLE `cms_moduls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cms_notifications`
--
ALTER TABLE `cms_notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_privileges`
--
ALTER TABLE `cms_privileges`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cms_privileges_roles`
--
ALTER TABLE `cms_privileges_roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `cms_provinsis`
--
ALTER TABLE `cms_provinsis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `cms_settings`
--
ALTER TABLE `cms_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cms_statistics`
--
ALTER TABLE `cms_statistics`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_statistic_components`
--
ALTER TABLE `cms_statistic_components`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customs`
--
ALTER TABLE `customs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45820;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17999;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1611;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2339;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
