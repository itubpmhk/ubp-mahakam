-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: ubp_mahakam
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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('ubp-mahakam-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1792564091),('ubp-mahakam-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1792564091;',1792564091),('ubp-mahakam-cache-site_settings','a:41:{s:17:\"hero_badge_region\";s:16:\"Kalimantan Timur\";s:15:\"hero_badge_unit\";s:24:\"Unit Bisnis Pembangkitan\";s:11:\"hero_status\";s:15:\"Beroperasi 24/7\";s:10:\"hero_title\";s:41:\"Menjaga terang *Benua Etam*, setiap hari.\";s:13:\"hero_subtitle\";s:139:\"UBP Mahakam mengelola operasi dan pemeliharaan pembangkit listrik yang memasok Sistem Mahakam, untuk Samarinda, Balikpapan, dan sekitarnya.\";s:13:\"video_youtube\";s:43:\"https://www.youtube.com/watch?v=JV9OHAZ2jlk\";s:11:\"video_label\";s:35:\"Video Profil · PLN Indonesia Power\";s:11:\"video_title\";s:26:\"From Energy, Comes Meaning\";s:10:\"strip_text\";s:73:\"Bagian dari PLN Indonesia Power, subholding pembangkitan PT PLN (Persero)\";s:11:\"strip_chips\";s:61:\"Samarinda, Balikpapan, Tenggarong, Kutai Kartanegara, Bontang\";s:13:\"about_heading\";s:38:\"Unit pembangkitan untuk Sistem Mahakam\";s:8:\"about_p1\";s:193:\"Berkedudukan di Kalimantan Timur, UBP Mahakam merupakan unit bisnis pembangkitan PLN Indonesia Power yang bertanggung jawab atas operasi dan pemeliharaan sejumlah pembangkit di wilayah Mahakam.\";s:8:\"about_p2\";s:166:\"Kami bekerja agar setiap unit siap memasok listrik kapan pun dibutuhkan, dengan mengutamakan keselamatan kerja, efisiensi, dan kepedulian terhadap lingkungan sekitar.\";s:11:\"stat1_label\";s:19:\"Kapasitas terpasang\";s:11:\"stat1_value\";s:6:\"— MW\";s:11:\"stat2_label\";s:15:\"Unit pembangkit\";s:11:\"stat2_value\";s:3:\"—\";s:11:\"stat3_label\";s:17:\"Insan UBP Mahakam\";s:11:\"stat3_value\";s:3:\"—\";s:11:\"stat4_label\";s:13:\"Siaga operasi\";s:11:\"stat4_value\";s:4:\"24/7\";s:14:\"commit_heading\";s:42:\"Andal hari ini, siap untuk transisi energi\";s:12:\"news_heading\";s:30:\"Kabar terbaru dari UBP Mahakam\";s:14:\"portal_heading\";s:15:\"Portal Aplikasi\";s:15:\"portal_subtitle\";s:57:\"Akses cepat ke aplikasi dan layanan internal UBP Mahakam.\";s:14:\"akhlak_heading\";s:21:\"Bekerja dengan AKHLAK\";s:15:\"akhlak_subtitle\";s:53:\"Nilai utama BUMN yang kami jalankan dalam keseharian.\";s:11:\"cta_heading\";s:39:\"Menjaga hari ini, menyiapkan masa depan\";s:8:\"cta_text\";s:112:\"Bagian dari PLN Indonesia Power, kami berkomitmen menghadirkan energi yang andal, efisien, dan ramah lingkungan.\";s:12:\"footer_about\";s:104:\"Unit Bisnis Pembangkitan, PLN Indonesia Power. Menjaga pasokan listrik Sistem Mahakam, Kalimantan Timur.\";s:15:\"contact_address\";s:56:\"[Alamat kantor UBP Mahakam]\r\nSamarinda, Kalimantan Timur\";s:13:\"contact_phone\";s:16:\"(0541) ———\";s:13:\"contact_email\";s:18:\"email@contoh.co.id\";s:13:\"contact_hours\";s:37:\"Senin – Jumat, 07.30 – 16.00 WITA\";s:16:\"social_instagram\";s:0:\"\";s:15:\"social_facebook\";s:0:\"\";s:14:\"social_youtube\";s:0:\"\";s:15:\"social_linkedin\";s:0:\"\";s:8:\"social_x\";s:0:\"\";s:19:\"link_whistleblowing\";s:0:\"\";s:11:\"link_career\";s:0:\"\";}',2107924091);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commitments`
--

DROP TABLE IF EXISTS `commitments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commitments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bolt',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commitments`
--

LOCK TABLES `commitments` WRITE;
/*!40000 ALTER TABLE `commitments` DISABLE KEYS */;
INSERT INTO `commitments` VALUES (1,'bolt','Keandalan pasokan','Pemeliharaan terencana dan kesiapan operasi menjadi kunci agar listrik Sistem Mahakam tetap mengalir untuk rumah, industri, dan layanan publik.',1,1,1,'2026-10-20 19:14:12','2026-10-20 19:14:12'),(2,'shield','Keselamatan kerja','Budaya K3 di setiap pekerjaan, menuju target zero accident.',0,1,2,'2026-10-20 19:14:12','2026-10-20 19:14:12'),(3,'leaf','Ramah lingkungan','Pengelolaan emisi dan limbah serta program konservasi di sekitar unit.',0,1,3,'2026-10-20 19:14:12','2026-10-20 19:14:12'),(4,'people','Tumbuh bersama masyarakat','Program TJSL untuk pendidikan, UMKM, dan kesehatan warga sekitar.',0,1,4,'2026-10-20 19:14:12','2026-10-20 19:14:12'),(5,'chart','Digitalisasi operasi','Pemantauan kinerja unit berbasis data untuk keputusan yang lebih cepat.',0,1,5,'2026-10-20 19:14:12','2026-10-20 19:14:12');
/*!40000 ALTER TABLE `commitments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_21_000001_create_settings_table',1),(5,'2026_10_21_000002_create_commitments_table',1),(6,'2026_10_21_000003_create_posts_table',1),(7,'2026_10_21_000004_create_portal_apps_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portal_apps`
--

DROP TABLE IF EXISTS `portal_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portal_apps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Umum',
  `description` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open_new_tab` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portal_apps`
--

LOCK TABLES `portal_apps` WRITE;
/*!40000 ALTER TABLE `portal_apps` DISABLE KEYS */;
INSERT INTO `portal_apps` VALUES (1,'Web DMM','Umum','Website coba coba','https://www.plnindonesiapower.co.id','portal/KCTFdr52btslQLRf0ktxRCjDqT6EQPrltMP2cexy.png',1,1,1,'2026-10-20 19:14:12','2026-10-20 19:48:38'),(2,'Tes','Umum','tes','https://www.plnindonesiapower.co.id','portal/Jbha69wq9urLyJg7kj4d3RxERiehT1iJWnUnuWbS.png',1,1,2,'2026-10-20 19:52:12','2026-10-20 19:52:12'),(3,'tes','Umum','tes','https://www.plnindonesiapower.co.id','portal/aP6ilUxcpHQyfsrZGEkUgyjbx1VZyf16d8vOF2c4.png',1,1,3,'2026-10-20 19:52:33','2026-10-20 19:52:33');
/*!40000 ALTER TABLE `portal_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_media`
--

DROP TABLE IF EXISTS `post_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_media_post_id_foreign` (`post_id`),
  CONSTRAINT `post_media_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_media`
--

LOCK TABLES `post_media` WRITE;
/*!40000 ALTER TABLE `post_media` DISABLE KEYS */;
INSERT INTO `post_media` VALUES (1,1,'image','news/images/ae1pCVDtAEih5YYKDBk0TfnpQXyshdPDDS6VwS5Q.jpg',NULL,'HUT ke-30 UBP Mahakam Hadirkan Kebahagiaan bagi Anak Yatim dan Dhuafa',1,'2026-10-20 19:30:13','2026-10-20 19:30:13');
/*!40000 ALTER TABLE `post_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_status_published_at_index` (`status`,`published_at`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,NULL,'HUT ke-30 UBP Mahakam Hadirkan Kebahagiaan bagi Anak Yatim dan Dhuafa','hut-ke-30-ubp-mahakam-hadirkan-kebahagiaan-bagi-anak-yatim-dan-dhuafa','Samarinda, Kalimantan Timur','<div><strong>SAMARINDA</strong> – Tiga dekade pengabdian bukan sekadar perjalanan menjaga keandalan energi, tetapi juga tentang menghadirkan manfaat dan menebarkan kepedulian bagi sesama. Dalam semangat Hari Kesaktian Pancasila, PLN Indonesia Power UBP Mahakam memaknai HUT ke-30 melalui tasyakuran yang dirangkai dengan santunan anak yatim dan dhuafa di Aula UBP Mahakam, Samarinda. Kegiatan ini menjadi ungkapan syukur sekaligus wujud kepedulian terhadap masyarakat.</div><div>Kegiatan berlangsung khidmat dengan dihadiri Manager PLN Indonesia Power UBP Mahakam, Manager Rumah Zakat, Ketua LAZ Annur, jajaran manajemen, pegawai, PIKK PLN IP UBP Mahakam, serta Tenaga Alih Daya. Rangkaian acara meliputi sambutan, tausiyah, doa bersama, dan penyerahan santunan.</div><div>Manager PLN Indonesia Power UBP Mahakam <strong>Firman Ramdan</strong> menyampaikan, usia ke-30 menjadi momentum untuk memperkuat nilai kepedulian dan memastikan kehadiran perusahaan memberikan manfaat nyata bagi masyarakat.<br><figure data-trix-attachment=\'{\"contentType\":\"image\",\"url\":\"/storage/news/inline/SQwekhqdxLNp1vm7ofho7E57PlGE7zI2iZYQVAny.jpg\",\"caption\":\"PLN Indonesia Power UBP Mahakam\"}\' data-trix-content-type=\"image\" class=\"attachment attachment--preview\"><a href=\"/storage/news/inline/SQwekhqdxLNp1vm7ofho7E57PlGE7zI2iZYQVAny.jpg\"><img src=\"/storage/news/inline/SQwekhqdxLNp1vm7ofho7E57PlGE7zI2iZYQVAny.jpg\" alt=\"\" loading=\"lazy\" width=\"590\" height=\"394\"><figcaption>PLN Indonesia Power UBP Mahakam</figcaption></a></figure>“Memasuki usia ke-30, kami bersyukur dapat terus menjalankan amanah menjaga keandalan pasokan listrik sekaligus berbagi kebahagiaan dengan masyarakat. Bagi kami, pengabdian tidak hanya tentang energi yang menerangi kehidupan, tetapi juga kepedulian yang menguatkan sesama. Semoga santunan ini membawa kebahagiaan bagi anak-anak yatim dan dhuafa, menjadi penyemangat untuk meraih cita-cita, serta mengingatkan kita bahwa setiap kebaikan memiliki arti bagi masa depan,” ujarnya.</div><div>Doa bersama dipanjatkan untuk memohon kesehatan, keselamatan, perlindungan, dan kelancaran bagi seluruh pegawai dalam menjalankan tugas, serta keandalan seluruh unit pembangkit. Doa juga ditujukan agar hujan yang membawa keberkahan segera turun untuk membantu memadamkan kebakaran hutan dan lahan (karhutla) serta memulihkan kualitas udara.</div><div>Santunan diserahkan secara simbolis berupa uang santunan, tas, buku, dan makanan ringan bagi anak-anak yatim dan dhuafa.</div><div>Melalui momentum ini, PLN Indonesia Power UBP Mahakam berharap semangat persatuan, gotong royong, dan kemanusiaan terus diwujudkan melalui aksi nyata, seiring upaya menjaga keandalan energi dan menghadirkan manfaat bagi masyarakat. (*)</div>','news/covers/qQIO0N26UKwxzAoMtsMmwWyyPNOSNUt4pqXSZmhJ.jpg','published','2026-10-20 19:14:00',8,'2026-10-20 19:14:12','2026-10-20 19:40:51'),(2,1,'PLN Indonesia Power UBP Mahakam Perkuat Daya Saing Wirausaha di Era Digital','pln-indonesia-power-ubp-mahakam-perkuat-daya-saing-wirausaha-di-era-digital',NULL,'<div><strong>SAMARINDA</strong> – Perkembangan dunia digital membuka semakin banyak peluang bagi masyarakat untuk mengembangkan usaha. Namun, peluang tersebut juga menghadirkan persaingan yang semakin dinamis. Untuk memperkuat kesiapan pelaku usaha menghadapi tantangan tersebut, PT PLN Indonesia Power Unit Bisnis Pembangkitan (UBP) Mahakam mengoptimalkan program wirausaha melalui sosialisasi dan fasilitasi usaha di Aula Utama Pangempang, Kecamatan Muara Badak.</div><div>Kegiatan ini memberikan pemahaman mengenai Nomor Induk Berusaha (NIB) dan Sertifikat Halal sebagai bagian dari penguatan fondasi usaha.<br>Materi yang diberikan juga membekali pelaku usaha dengan wawasan untuk meningkatkan kredibilitas produk sekaligus merespons kebutuhan pasar di tengah perkembangan ekonomi digital.</div><div>Manager PLN Indonesia Power UBP Mahakam, Syafi’i, menegaskan bahwa penguatan wirausaha harus menyentuh kebutuhan nyata pelaku usaha agar mampu bertahan dan berkembang di tengah persaingan.</div><div>“Di tengah persaingan yang semakin terbuka, pelaku usaha harus memiliki fondasi yang kuat untuk berkembang. NIB dan Sertifikat Halal bukan sekadar dokumen, tetapi menjadi pintu untuk membangun kepercayaan dan memperluas peluang usaha.<br>Kami ingin pendampingan ini memberikan akses yang nyata, sehingga pelaku usaha tidak hanya memahami apa yang harus dilakukan, tetapi juga dapat langsung mengambil langkah untuk mengembangkan usahanya,” tegas Syafi’i.</div><div>Rangkaian kegiatan diisi dengan pemaparan materi, sesi tanya jawab, serta pendampingan langsung dalam proses pembuatan NIB dan pengajuan Sertifikat Halal. Pelaku usaha juga mendapatkan ruang untuk berkonsultasi mengenai kebutuhan dan kendala yang dihadapi dalam menjalankan bisnis.</div><div>Kegiatan turut dilengkapi klinik konsultasi usaha yang memberikan arahan terkait pengembangan bisnis sesuai kebutuhan masing-masing. Pendekatan tersebut diharapkan membantu pelaku usaha menentukan langkah yang lebih tepat dalam mengembangkan potensi dan memperluas pasar.<br><figure data-trix-attachment=\'{\"contentType\":\"image\",\"url\":\"/storage/news/inline/SqDA1f8x97gWgY7rCqkCXxZe045CfDtw2rV0hiE7.jpg\",\"caption\":\"PLN Indonesia Power UBP Mahakam Perkuat Daya Saing Wirausaha di Era Digital\"}\' data-trix-content-type=\"image\" class=\"attachment attachment--preview\"><a href=\"/storage/news/inline/SqDA1f8x97gWgY7rCqkCXxZe045CfDtw2rV0hiE7.jpg\"><img src=\"/storage/news/inline/SqDA1f8x97gWgY7rCqkCXxZe045CfDtw2rV0hiE7.jpg\" alt=\"\" loading=\"lazy\" width=\"590\" height=\"351\"><figcaption>PLN Indonesia Power UBP Mahakam Perkuat Daya Saing Wirausaha di Era Digital</figcaption></a></figure>Melalui program ini, PLN Indonesia Power UBP Mahakam mendorong pelaku usaha semakin siap menghadapi persaingan di era digital melalui penguatan kapasitas, pemanfaatan teknologi, dan kemampuan membaca peluang. Upaya ini menjadi bagian dari pemberdayaan masyarakat untuk memperkuat fondasi wirausaha serta membuka peluang ekonomi yang lebih luas.</div>','news/covers/wQqTpeqsNKZJjLFsnUjO1pjhBZxvzsDQalblmHnQ.jpg','published','2026-10-20 19:37:00',2,'2026-10-20 19:40:27','2026-10-20 19:43:41'),(3,1,'PLN Indonesia Power UBP Mahakam Satukan Langkah Lewat InPower Fun Run','pln-indonesia-power-ubp-mahakam-satukan-langkah-lewat-inpower-fun-run',NULL,'<div><strong>SAMARINDA</strong> – Semangat persatuan dan gotong royong yang menjadi nilai penting dalam peringatan Hari Kesaktian Pancasila diwujudkan PLN Indonesia Power UBP Mahakam melalui InPower Fun Run 2026. Digelar dalam rangka memperingati HUT ke-31 PLN Indonesia Power, kegiatan ini menjadi momentum menyatukan langkah manajemen, pegawai, dan tenaga alih daya dalam semangat kebersamaan, kesehatan, dan kolaborasi.</div><div>Mengusung semangat “Setiap Langkah, Berdampak untuk Negeri”, seluruh peserta bergerak bersama menempuh rute minimal sejauh 6 kilometer. Kegiatan diawali dengan safety briefing dan pemanasan bersama untuk memastikan seluruh rangkaian berlangsung aman, sehat, dan penuh semangat.</div><div>InPower Fun Run tidak sekadar menjadi aktivitas olahraga, tetapi menjadi ruang untuk memperkuat hubungan antarpersonel dan menumbuhkan energi positif di lingkungan kerja. Perbedaan peran dan tanggung jawab tidak menjadi sekat ketika seluruh peserta berada dalam satu lintasan dan bergerak menuju tujuan yang sama.</div><div>Manager PLN Indonesia Power UBP Mahakam, <strong>Syafi’i</strong> menyampaikan, momentum Hari Kesaktian Pancasila menjadi pengingat pentingnya menjaga persatuan dan kebersamaan dalam setiap langkah.</div><div>“Melalui InPower Fun Run tahun ini, kita ingin membangun semangat kebersamaan yang tidak berhenti di lintasan, tetapi juga hadir dalam pekerjaan. Nilai persatuan dan gotong royong menjadi energi untuk memperkuat kolaborasi dan menghadirkan kinerja terbaik bagi perusahaan dan negeri,” ujar Syafi’i.<br><figure data-trix-attachment=\'{\"contentType\":\"image\",\"url\":\"/storage/news/inline/A8rjy8NfJR9oNv0D5bl4jAq1XKXGVvMFK0zX8TOy.jpg\",\"caption\":\"PLN Indonesia Power UBP Mahakam Satukan Langkah Lewat InPower Fun Run\"}\' data-trix-content-type=\"image\" class=\"attachment attachment--preview\"><a href=\"/storage/news/inline/A8rjy8NfJR9oNv0D5bl4jAq1XKXGVvMFK0zX8TOy.jpg\"><img src=\"/storage/news/inline/A8rjy8NfJR9oNv0D5bl4jAq1XKXGVvMFK0zX8TOy.jpg\" alt=\"\" loading=\"lazy\" width=\"590\" height=\"394\"><figcaption>PLN Indonesia Power UBP Mahakam Satukan Langkah Lewat InPower Fun Run</figcaption></a></figure>Semarak kegiatan semakin terasa dengan berbagai challenge, seperti Best Pace dan Best Distance serta pemberian apresiasi dan doorprize kepada peserta.</div><div>Momentum Hari Kesaktian Pancasila dan HUT ke-31 PLN Indonesia Power menjadi pengingat bahwa kekuatan perusahaan lahir dari insan yang mampu bersatu, bergerak bersama, dan saling menguatkan.</div><div>Melalui InPower Fun Run 2026, PLN Indonesia Power UBP Mahakam meneguhkan semangat tersebut: satukan langkah, kobarkan persatuan, dan terus hadir memberikan energi terbaik bagi negeri. (*)</div>','news/covers/XiUz1DVUmzMTNr3LWfDTVcCvMIkEeBr3qrJvud8M.jpg','published','2026-10-20 19:41:00',1,'2026-10-20 19:43:38','2026-10-20 23:08:03');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('TDuSW7JvDfTaPO5Nj86rYte8dvA4hvCcxKnMOO9j',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI0SVZLNjQ1QTdpaXhjcTQzcVZpOEdoTzZRSW1RVUdIODNYNVNpbDNOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1792659357);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'hero_badge_region','Kalimantan Timur','2026-10-20 19:14:12','2026-10-20 19:14:12'),(2,'hero_badge_unit','Unit Bisnis Pembangkitan','2026-10-20 19:14:12','2026-10-20 19:14:12'),(3,'hero_status','Beroperasi 24/7','2026-10-20 19:14:12','2026-10-20 19:14:12'),(4,'hero_title','Menjaga terang *Benua Etam*, setiap hari.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(5,'hero_subtitle','UBP Mahakam mengelola operasi dan pemeliharaan pembangkit listrik yang memasok Sistem Mahakam, untuk Samarinda, Balikpapan, dan sekitarnya.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(6,'video_youtube','https://www.youtube.com/watch?v=JV9OHAZ2jlk','2026-10-20 19:14:12','2026-10-20 19:14:12'),(7,'video_label','Video Profil · PLN Indonesia Power','2026-10-20 19:14:12','2026-10-20 19:14:12'),(8,'video_title','From Energy, Comes Meaning','2026-10-20 19:14:12','2026-10-20 19:14:12'),(9,'strip_text','Bagian dari PLN Indonesia Power, subholding pembangkitan PT PLN (Persero)','2026-10-20 19:14:12','2026-10-20 19:14:12'),(10,'strip_chips','Samarinda, Balikpapan, Tenggarong, Kutai Kartanegara, Bontang','2026-10-20 19:14:12','2026-10-20 19:14:12'),(11,'about_heading','Unit pembangkitan untuk Sistem Mahakam','2026-10-20 19:14:12','2026-10-20 19:14:12'),(12,'about_p1','Berkedudukan di Kalimantan Timur, UBP Mahakam merupakan unit bisnis pembangkitan PLN Indonesia Power yang bertanggung jawab atas operasi dan pemeliharaan sejumlah pembangkit di wilayah Mahakam.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(13,'about_p2','Kami bekerja agar setiap unit siap memasok listrik kapan pun dibutuhkan, dengan mengutamakan keselamatan kerja, efisiensi, dan kepedulian terhadap lingkungan sekitar.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(14,'stat1_label','Kapasitas terpasang','2026-10-20 19:14:12','2026-10-20 19:14:12'),(15,'stat1_value','— MW','2026-10-20 19:14:12','2026-10-20 19:14:12'),(16,'stat2_label','Unit pembangkit','2026-10-20 19:14:12','2026-10-20 19:14:12'),(17,'stat2_value','—','2026-10-20 19:14:12','2026-10-20 19:14:12'),(18,'stat3_label','Insan UBP Mahakam','2026-10-20 19:14:12','2026-10-20 19:14:12'),(19,'stat3_value','—','2026-10-20 19:14:12','2026-10-20 19:14:12'),(20,'stat4_label','Siaga operasi','2026-10-20 19:14:12','2026-10-20 19:14:12'),(21,'stat4_value','24/7','2026-10-20 19:14:12','2026-10-20 19:14:12'),(22,'commit_heading','Andal hari ini, siap untuk transisi energi','2026-10-20 19:14:12','2026-10-20 19:14:12'),(23,'news_heading','Kabar terbaru dari UBP Mahakam','2026-10-20 19:14:12','2026-10-20 19:14:12'),(24,'portal_heading','Portal Aplikasi','2026-10-20 19:14:12','2026-10-20 19:14:12'),(25,'portal_subtitle','Akses cepat ke aplikasi dan layanan internal UBP Mahakam.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(26,'akhlak_heading','Bekerja dengan AKHLAK','2026-10-20 19:14:12','2026-10-20 19:14:12'),(27,'akhlak_subtitle','Nilai utama BUMN yang kami jalankan dalam keseharian.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(28,'cta_heading','Menjaga hari ini, menyiapkan masa depan','2026-10-20 19:14:12','2026-10-20 22:28:11'),(29,'cta_text','Bagian dari PLN Indonesia Power, kami berkomitmen menghadirkan energi yang andal, efisien, dan ramah lingkungan.','2026-10-20 19:14:12','2026-10-20 22:28:11'),(30,'footer_about','Unit Bisnis Pembangkitan, PLN Indonesia Power. Menjaga pasokan listrik Sistem Mahakam, Kalimantan Timur.','2026-10-20 19:14:12','2026-10-20 19:14:12'),(31,'contact_address','[Alamat kantor UBP Mahakam]\r\nSamarinda, Kalimantan Timur','2026-10-20 19:14:12','2026-10-20 22:28:11'),(32,'contact_phone','(0541) ———','2026-10-20 19:14:12','2026-10-20 19:14:12'),(33,'contact_email','email@contoh.co.id','2026-10-20 19:14:12','2026-10-20 19:14:12'),(34,'contact_hours','Senin – Jumat, 07.30 – 16.00 WITA','2026-10-20 19:14:12','2026-10-20 19:14:12'),(35,'social_instagram','','2026-10-20 19:14:12','2026-10-20 19:14:12'),(36,'social_facebook','','2026-10-20 19:14:12','2026-10-20 19:14:12'),(37,'social_youtube','','2026-10-20 19:14:12','2026-10-20 19:14:12'),(38,'social_linkedin','','2026-10-20 19:14:12','2026-10-20 19:14:12'),(39,'social_x','','2026-10-20 19:14:12','2026-10-20 19:14:12'),(40,'link_whistleblowing','','2026-10-20 19:14:12','2026-10-20 19:14:12'),(41,'link_career','','2026-10-20 19:14:12','2026-10-20 19:14:12');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@landingpage.com',NULL,'$2y$12$2CWZ3QRi3.2DHwRfQHC6peX3doZg3Xd5/oBIcpAUOxeVh6Lkp7ila',NULL,'2026-10-20 19:14:12','2026-10-20 19:14:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-23 10:32:25
