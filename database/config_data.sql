-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: katalisbptph_db
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cms_moduls`
--

DROP TABLE IF EXISTS `cms_moduls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_moduls` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_moduls`
--

LOCK TABLES `cms_moduls` WRITE;
/*!40000 ALTER TABLE `cms_moduls` DISABLE KEYS */;
INSERT INTO `cms_moduls` VALUES (1,'Notifications','fa fa-cog','notifications','cms_notifications','NotificationsController',1,1,'2020-01-23 11:26:00',NULL,NULL),(2,'Privileges','fa fa-cog','privileges','cms_privileges','PrivilegesController',1,1,'2020-01-23 11:26:00',NULL,NULL),(3,'Privileges Roles','fa fa-cog','privileges_roles','cms_privileges_roles','PrivilegesRolesController',1,1,'2020-01-23 11:26:00',NULL,NULL),(4,'Users Management','fa fa-users','users','cms_users','AdminCmsUsersController',0,1,'2020-01-23 11:26:00',NULL,NULL),(5,'Settings','fa fa-cog','settings','cms_settings','SettingsController',1,1,'2020-01-23 11:26:00',NULL,NULL),(6,'Module Generator','fa fa-database','module_generator','cms_moduls','ModulsController',1,1,'2020-01-23 11:26:00',NULL,NULL),(7,'Menu Management','fa fa-bars','menu_management','cms_menus','MenusController',1,1,'2020-01-23 11:26:00',NULL,NULL),(8,'Email Templates','fa fa-envelope-o','email_templates','cms_email_templates','EmailTemplatesController',1,1,'2020-01-23 11:26:00',NULL,NULL),(9,'Statistic Builder','fa fa-dashboard','statistic_builder','cms_statistics','StatisticBuilderController',1,1,'2020-01-23 11:26:00',NULL,NULL),(10,'API Generator','fa fa-cloud-download','api_generator','','ApiCustomController',1,1,'2020-01-23 11:26:00',NULL,NULL),(11,'Log User Access','fa fa-flag-o','logs','cms_logs','LogsController',1,1,'2020-01-23 11:26:00',NULL,NULL),(12,'Data Pemantau','fa fa-user-secret','admins','cms_users','AdminCmsAdminsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(13,'Data Pelanggan','fa fa-users','customers','cms_users','AdminCmsCustomersController',0,0,'2020-10-12 05:33:54',NULL,NULL),(14,'Verifikasi Pelanggan Baru','fa fa-user-plus','verify-customers','cms_users','AdminCmsVerifyCustomersController',0,0,'2020-10-12 05:33:54',NULL,NULL),(15,'Parameter Uji','fa fa-th','parameters','parameters','AdminCmsParametersController',0,0,'2020-10-12 05:33:54',NULL,NULL),(16,'Permohonan Baru','fa fa-plus-circle','new-requests','requests','AdminCmsNewRequestsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(17,'Daftar Permohonan','fa fa-list-ol','requests','requests','AdminCmsRequestsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(18,'Laporan Hasil Pengujian','fa fa-calculator','results','results','AdminCmsResultsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(19,'Daftar Parameter Uji','fa fa-list-ul','request-testings','request_testings','AdminCmsRequestTestingsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(20,'Data Petugas','fa fa-user-secret','staffs','cms_users','AdminCmsMTsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(21,'Daftar Tugas Analis','fas fa-prescription-bottle-alt','analyst-tasks','analyst_tasks','AdminCmsAnalystTasksController',0,0,'2020-10-12 05:33:54',NULL,NULL),(22,'Penilaian Pelanggan','fas fa-star','ratings','ratings','AdminCmsRatingsController',0,0,'2020-10-12 05:33:54',NULL,NULL),(23,'Laporan PNBP','fas fa-chart-line','report-pnbp','requests','AdminCmsReportPNBPController',0,0,'2020-10-12 05:33:54',NULL,NULL),(24,'Faqs','fas fa-question','faqs','faqs','AdminCmsFaqsController',0,0,'2020-10-12 05:33:54',NULL,NULL);
/*!40000 ALTER TABLE `cms_moduls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menus`
--

DROP TABLE IF EXISTS `cms_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menus`
--

LOCK TABLES `cms_menus` WRITE;
/*!40000 ALTER TABLE `cms_menus` DISABLE KEYS */;
INSERT INTO `cms_menus` VALUES (1,'Manajemen Data','URL','#','normal','fas fa-list',0,1,0,1,6,'2020-10-12 09:07:59','2021-10-19 09:54:56'),(2,'Manajemen Pengguna','URL','#','normal','fas fa-list',0,1,0,1,4,'2020-10-12 09:07:59','2021-07-26 02:58:15'),(3,'Verifikasi Pelanggan Baru','Route','AdminCmsVerifyCustomersControllerGetIndex','normal','fas fa-user-check',2,1,0,1,1,'2020-10-12 02:17:23','2021-07-26 03:12:14'),(4,'Data Pelanggan','Route','AdminCmsCustomersControllerGetIndex','normal','fas fa-users',2,1,0,1,2,'2020-10-12 02:17:23','2021-07-26 03:02:03'),(5,'Data Pemantau','Route','AdminCmsAdminsControllerGetIndex','normal','fas fa-user-secret',2,1,0,1,3,'2020-10-12 02:17:23','2021-07-26 02:59:01'),(6,'Permohonan Baru','Route','AdminCmsNewRequestsControllerGetAdd','normal','fas fa-star',27,1,0,1,1,'2020-10-12 02:17:23','2021-07-22 16:49:24'),(7,'Data Pengujian','URL','#','normal','fas fa-prescription-bottle',0,1,0,1,2,'2020-10-12 09:07:59','2022-11-01 06:57:08'),(8,'Parameter Uji','Route','AdminCmsParametersControllerGetIndex','normal','fas fa-th',1,1,0,1,1,'2020-10-12 02:17:23','2021-10-19 09:55:59'),(9,'Daftar Permohonan','Route','AdminCmsRequestsControllerGetIndex','normal','fas fa-list-ol',7,1,0,1,1,'2020-10-12 02:17:23','2022-11-01 06:57:30'),(10,'Data Petugas','Route','AdminCmsMTsControllerGetIndex','normal','fas fa-user-secret',2,1,0,1,4,'2020-10-12 02:17:23','2021-07-26 02:52:55'),(21,'Laporan Hasil Pengujian','Route','AdminCmsResultsControllerGetIndex','normal','fas fa-calculator',0,0,0,1,1,'2020-10-12 02:17:23','2021-07-26 03:01:50'),(22,'Daftar Tugas Analis','Route','AdminCmsAnalystTasksControllerGetIndex','normal','fas fa-prescription-bottle-alt',7,1,0,1,2,'2020-10-12 02:17:23','2021-07-30 08:51:50'),(23,'Penilaian Pelanggan','Route','AdminCmsRatingsControllerGetIndex','normal','fas fa-star',0,1,0,1,5,'2020-10-12 02:17:23','2021-08-06 04:48:04'),(24,'Laporan','URL','#','normal','fas fa-th-large',0,0,0,1,2,'2020-10-12 09:07:59','2021-09-08 15:21:14'),(25,'Laporan PNBP','Route','AdminCmsReportPNBPControllerGetIndex','normal','fas fa-chart-line',24,0,0,1,1,'2020-10-12 02:17:23','2021-09-08 15:23:36'),(26,'Faqs','Route','AdminCmsFaqsControllerGetIndex','normal','fas fa-question',0,0,0,1,3,'2020-10-12 02:17:23','2021-10-19 09:04:45'),(27,'Pengujian Saya','URL','#','normal','fas fa-list-ul',0,1,0,1,1,'2022-11-01 06:54:36',NULL),(28,'Lacak Permohonan','Route','AdminCmsRequestsControllerGetIndex','normal','fas fa-receipt',27,1,0,1,2,'2020-10-12 02:17:23','2022-11-01 06:56:46');
/*!40000 ALTER TABLE `cms_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_privileges`
--

DROP TABLE IF EXISTS `cms_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_privileges` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin` tinyint(1) DEFAULT NULL,
  `theme_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_privileges`
--

LOCK TABLES `cms_privileges` WRITE;
/*!40000 ALTER TABLE `cms_privileges` DISABLE KEYS */;
INSERT INTO `cms_privileges` VALUES (1,'Super Admin',1,'skin-green-light','2020-01-23 11:26:00',NULL),(2,'Koord. Adm./Pengelola Contoh',0,'skin-green-light',NULL,NULL),(3,'Koord. Teknis/Penyelia',0,'skin-green-light',NULL,NULL),(4,'Analis',0,'skin-green-light',NULL,NULL),(5,'Pelanggan',0,'skin-green-light',NULL,NULL),(6,'Pemantau',0,'skin-green-light',NULL,NULL);
/*!40000 ALTER TABLE `cms_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menus_privileges`
--

DROP TABLE IF EXISTS `cms_menus_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_menus_privileges` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_menus` int DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menus_privileges`
--

LOCK TABLES `cms_menus_privileges` WRITE;
/*!40000 ALTER TABLE `cms_menus_privileges` DISABLE KEYS */;
INSERT INTO `cms_menus_privileges` VALUES (92,19,1),(93,19,2),(120,20,3),(121,20,1),(132,6,5),(138,10,6),(139,10,1),(140,2,6),(141,2,3),(142,2,2),(143,2,1),(147,5,6),(148,5,1),(165,21,6),(166,21,4),(167,21,3),(168,21,5),(169,21,2),(170,21,1),(171,4,6),(172,4,3),(173,4,2),(174,4,1),(175,3,2),(176,3,1),(182,22,6),(183,22,4),(184,22,3),(185,22,2),(186,22,1),(187,23,6),(188,23,3),(189,23,1),(190,24,6),(191,24,1),(192,25,6),(193,25,1),(194,26,6),(195,26,1),(196,1,6),(197,1,3),(198,1,1),(199,8,6),(200,8,3),(201,8,1),(202,27,5),(203,28,5),(204,7,6),(205,7,4),(206,7,3),(207,7,2),(208,7,1),(209,9,6),(210,9,3),(211,9,2),(212,9,1);
/*!40000 ALTER TABLE `cms_menus_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_settings`
--

DROP TABLE IF EXISTS `cms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content_input_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataenum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helper` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_setting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_settings`
--

LOCK TABLES `cms_settings` WRITE;
/*!40000 ALTER TABLE `cms_settings` DISABLE KEYS */;
INSERT INTO `cms_settings` VALUES (1,'login_background_color','white','text',NULL,'Input hexacode','2020-01-23 11:26:00',NULL,'Login Register Style','Login Background Color'),(2,'login_font_color',NULL,'text',NULL,'Input hexacode','2020-01-23 11:26:00',NULL,'Login Register Style','Login Font Color'),(3,'login_background_image','uploads/2020-10/50533576b58ceb07437eba354a5c8700.jpg','upload_image',NULL,NULL,'2020-01-23 11:26:00',NULL,'Login Register Style','Login Background Image'),(4,'email_sender','katalis@jabarprov.go.id','text',NULL,NULL,'2020-01-23 11:26:00',NULL,'Email Setting','Email Sender'),(5,'smtp_driver','smtp','select','smtp,mail,sendmail',NULL,'2020-01-23 11:26:00',NULL,'Email Setting','Mail Driver'),(6,'smtp_host','smtp.jabarprov.go.id','text',NULL,NULL,'2020-01-23 11:26:00',NULL,'Email Setting','SMTP Host'),(7,'smtp_port','25','text',NULL,'default 25','2020-01-23 11:26:00',NULL,'Email Setting','SMTP Port'),(8,'smtp_username','katalis@jabarprov.go.id','text',NULL,NULL,'2020-01-23 11:26:00',NULL,'Email Setting','SMTP Username'),(9,'smtp_password','SanGgabUana%487','text',NULL,NULL,'2020-01-23 11:26:00',NULL,'Email Setting','SMTP Password'),(10,'appname','KATALIS','text',NULL,NULL,'2020-01-23 11:26:00',NULL,'Application Setting','Application Name'),(11,'default_paper_size','A4','text',NULL,'Paper size, ex : A4, Legal, etc','2020-01-23 11:26:00',NULL,'Application Setting','Default Paper Print Size'),(12,'logo','uploads/2022-11/aa0bee19f789fa22de5e5d427ee61857.png','upload_image',NULL,NULL,'2020-01-23 11:26:00',NULL,'Application Setting','Logo'),(13,'favicon','uploads/2022-11/2f964a340612d2c572ec6d2a13795288.png','upload_image',NULL,NULL,'2020-01-23 11:26:00',NULL,'Application Setting','Favicon'),(14,'api_debug_mode','false','select','true,false',NULL,'2020-01-23 11:26:00',NULL,'Application Setting','API Debug Mode'),(15,'google_api_key',NULL,'text',NULL,NULL,'2020-01-23 11:26:00',NULL,'Application Setting','Google API Key'),(20,'whatsapp','62811112431','text',NULL,'Nomor WA saat akun belum terdaftar','2020-09-01 20:04:44',NULL,'Application Setting','WhatsApp'),(21,'maklumat_pelayanan','uploads/2021-08/53b83b74c120198fe6a329849100e589.jpg','upload_image',NULL,'Upload Gambar Maklumat','2021-08-30 12:44:47','2021-08-30 12:45:24','Maklumat Setting','Maklumat Pelayanan'),(22,'jenis_layanan','uploads/2021-09/bab8ddc44ea60aaf07a97ff62896e8ea.png','upload_image',NULL,NULL,'2021-09-10 05:07:40',NULL,'Jenis Layanan Setting','Jenis Layanan');
/*!40000 ALTER TABLE `cms_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_email_templates`
--

DROP TABLE IF EXISTS `cms_email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_email_templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_email_templates`
--

LOCK TABLES `cms_email_templates` WRITE;
/*!40000 ALTER TABLE `cms_email_templates` DISABLE KEYS */;
INSERT INTO `cms_email_templates` VALUES (1,'Lupa Kata Sandi','forgot_password','Lupa Kata Sandi','<p>Hai, [name]</p><p>Ini merupakan kata sandi terbaru kamu : <b>[password]</b></p><p><b><font color=\"#ff0000\">Mohon setelah melakukan login, segera masuk ke halaman profil di menu pojok kanan atas, lalu lakukan ubah kata sandi.</font></b></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>','Lupa Kata Sandi','KATALIS - Satuan Pelayanan Laboratorium Kimia Agro','katalis@jabarprov.go.id',NULL,'2020-01-23 11:26:00','2022-12-19 05:08:01'),(2,'Pendaftaran Baru','register_account','Pendaftaran Baru','<p>Hai, [name]</p><p>Ini merupakan alamat email &amp; kata sandi Anda untuk dapat login kedalam sistem: </p><p>Email:<b> [email]</b></p><p>Password:<b> [password]</b></p><p><b><font color=\"#ff0000\">Mohon setelah melakukan login, segera masuk ke halaman profil di menu pojok kanan atas, lalu lakukan ubah kata sandi.</font></b></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>','Pendaftaran Baru','KATALIS - Satuan Pelayanan Laboratorium Kimia Agro','katalis@jabarprov.go.id',NULL,'2020-01-23 11:26:00','2022-12-19 05:07:56'),(3,'Informasi Terbaru Dari Permohonan','new_updates','Informasi Terbaru Dari Permohonan','<p>Hai, [name]</p><p>Ini merupakan informasi terbaru dari Permohonan dengan informasi sbb:</p><p> </p><p>No. Dokumen:<b> [document_no]</b></p><p>Status Terbaru:<b> [status]</b></p><p><b><br></b></p><p>[notes]</p><p><br></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>','Pendaftaran Baru','KATALIS - Satuan Pelayanan Laboratorium Kimia Agro','katalis@jabarprov.go.id',NULL,'2020-01-23 11:26:00','2022-12-19 05:07:50'),(4,'Informasi Terbaru','new_updates_2','Informasi Terbaru Dari Permohonan','<p>Hai, [name]</p><p>Ini merupakan informasi terbaru dari Permohonan dengan informasi sbb:</p><p><br></p><p> </p><p>No. Dokumen:<b> [document_no]</b></p><p>Asal Sampel:<span style=\"font-weight: 700;\">&nbsp;[asal_sampel]</span></p><p>Alamat:<span style=\"font-weight: 700;\">&nbsp;[alamat]</span></p><p>Nama Sampel:<span style=\"font-weight: 700;\">&nbsp;[nama_sampel]</span></p><p>Jumlah Sampel:<span style=\"font-weight: 700;\">&nbsp;[jumlah_sampel]</span></p>Jenis Pengujian:<span style=\"font-weight: 700;\">&nbsp;[jenis_pengujian]</span><p></p><p></p><p>Status Terakhir:<b> [status]</b></p><p><b><br></b></p><p>[notes]</p><p><br></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro<br></p>','Pendaftaran Baru','KATALIS - Satuan Pelayanan Laboratorium Kimia Agro','katalis@jabarprov.go.id',NULL,'2020-01-23 11:26:00','2022-12-19 05:07:46'),(5,'Informasi Perkiraan Waktu Penyelesaian','new_updates_3','Informasi Perkiraan Waktu Penyelesaian Dari Permohonan','<p>Hai, [name]</p><p>Ini merupakan informasi terbaru terkait perkiraan waktu penyelesaian dari Permohonan dengan informasi sbb:</p><p><br></p><p> </p><p>No. Dokumen:<b> [document_no]</b></p><p>Asal Sampel:<span style=\"font-weight: 700;\">&nbsp;[asal_sampel]</span></p><p>Alamat:<span style=\"font-weight: 700;\">&nbsp;[alamat]</span></p><p>Nama Sampel:<span style=\"font-weight: 700;\">&nbsp;[nama_sampel]</span></p><p>Jumlah Sampel:<span style=\"font-weight: 700;\">&nbsp;[jumlah_sampel]</span></p>Jenis Pengujian:<span style=\"font-weight: 700;\">&nbsp;[jenis_pengujian]</span><p></p><p></p><p>Perkiraan Waktu Selesai Pengujian:<span style=\"font-weight: 700;\">&nbsp;[perkiraan]</span></p><p>Status Terakhir:<b> [status]</b></p><p><b><br></b></p><p>[notes]</p><p><br></p><p>--</p><p>Salam,</p><p>KATALIS - Satuan Pelayanan Laboratorium Kimia Agro</p>','Informasi Perkiraan Waktu','KATALIS - Satuan Pelayanan Laboratorium Kimia Agro','katalis@jabarprov.go.id',NULL,'2020-01-23 11:26:00','2022-12-19 05:07:41');
/*!40000 ALTER TABLE `cms_email_templates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-07 15:38:58
