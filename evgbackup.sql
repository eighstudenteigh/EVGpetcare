-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: switchyard.proxy.rlwy.net    Database: thesis
-- ------------------------------------------------------
-- Server version	9.2.0

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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
-- Table structure for table `file_request_items`
--

DROP TABLE IF EXISTS `file_request_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_request_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `file_request_id` bigint unsigned NOT NULL,
  `file_id` bigint unsigned NOT NULL,
  `copies` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_request_items_file_request_id_foreign` (`file_request_id`),
  KEY `file_request_items_file_id_foreign` (`file_id`),
  CONSTRAINT `file_request_items_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_request_items_file_request_id_foreign` FOREIGN KEY (`file_request_id`) REFERENCES `file_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_request_items`
--

LOCK TABLES `file_request_items` WRITE;
/*!40000 ALTER TABLE `file_request_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_request_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_requests`
--

DROP TABLE IF EXISTS `file_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `school_year_id` bigint unsigned DEFAULT NULL,
  `semester_id` bigint unsigned DEFAULT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_requests_student_id_foreign` (`student_id`),
  KEY `file_requests_school_year_id_foreign` (`school_year_id`),
  KEY `file_requests_semester_id_foreign` (`semester_id`),
  CONSTRAINT `file_requests_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  CONSTRAINT `file_requests_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL,
  CONSTRAINT `file_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_requests`
--

LOCK TABLES `file_requests` WRITE;
/*!40000 ALTER TABLE `file_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_requirements`
--

DROP TABLE IF EXISTS `file_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_requirements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `file_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_requirements_file_id_foreign` (`file_id`),
  CONSTRAINT `file_requirements_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_requirements`
--

LOCK TABLES `file_requirements` WRITE;
/*!40000 ALTER TABLE `file_requirements` DISABLE KEYS */;
INSERT INTO `file_requirements` VALUES (1,1,'Fully Accomplished Form 8','2025-04-09 04:49:19','2025-04-09 04:49:19'),(2,13,'2x2 ID Picture (attire with collar, recent, white background)','2025-04-09 08:34:47','2025-04-09 08:34:47'),(3,13,'Barangay Certification (first-time jobseeker)','2025-04-09 08:35:16','2025-04-09 08:35:16'),(4,13,'Clearance Form (Form 10)','2025-04-09 08:35:45','2025-04-09 08:35:45'),(5,13,'Photocopy of PSA Birth Certificate','2025-04-09 08:37:05','2025-04-09 08:37:05'),(6,13,'Photocopy of PSA Marriage Certificate (for female married)','2025-04-09 08:38:15','2025-04-09 08:51:36'),(7,13,'Form 137(if admitted as freshmen)','2025-04-09 08:39:29','2025-04-09 08:52:19'),(8,13,'TOR with copy for PRMSU as remarks from last HEI','2025-04-09 08:41:18','2025-04-09 08:41:18'),(9,19,'Photocopy of last TOR issued(if available)','2025-04-09 08:42:14','2025-04-09 08:42:14'),(10,15,'Affidavit of Loss','2025-04-09 08:43:27','2025-04-09 08:43:49'),(11,14,'Official Transcript of Records','2025-04-09 08:44:04','2025-04-09 08:44:04'),(12,15,'PSA Birth Certificate','2025-04-09 08:44:50','2025-04-09 08:44:50'),(13,15,'Official Transcript of Records','2025-04-09 08:45:13','2025-04-09 08:45:13'),(14,18,'Original Transcript of Records','2025-04-09 08:46:12','2025-04-09 08:46:12'),(15,17,'Photocopy of Transcript of Records','2025-04-09 08:47:16','2025-04-09 08:47:16'),(16,20,'2x2 ID Picture (attire with collar, recent, white background)','2025-04-09 08:49:54','2025-04-09 08:49:54'),(17,20,'Clearance Form (Form 10)','2025-04-09 08:50:21','2025-04-09 08:50:21'),(18,20,'Photocopy of PSA Birth Certificate','2025-04-09 08:50:48','2025-04-09 08:50:48'),(19,20,'Photocopy of PSA Marriage Certificate (for female married)','2025-04-09 08:51:54','2025-04-09 08:51:54'),(20,20,'Form 137(if admitted as freshmen)','2025-04-09 08:52:38','2025-04-09 08:52:38');
/*!40000 ALTER TABLE `file_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'Units Earned',1,'2025-02-26 22:54:40','2025-04-09 03:15:39'),(2,'Grades (per semester/term)',1,'2025-03-25 08:38:45','2025-04-09 03:16:10'),(3,'Grades (all terms attended)',1,'2025-03-25 08:38:56','2025-04-09 03:18:43'),(4,'General Weighted Average',1,'2025-03-26 05:15:49','2025-04-09 03:19:35'),(5,'Academic Completions',1,'2025-03-26 05:16:02','2025-04-09 03:20:00'),(6,'Graduation',1,'2025-03-26 05:16:33','2025-04-09 03:20:28'),(7,'As a candidate for Graduation',1,'2025-04-09 03:20:46','2025-04-09 03:20:52'),(8,'As Honor Graduation',1,'2025-04-09 03:21:16','2025-04-09 03:21:16'),(9,'Subjects Enrolled / Curriculum',1,'2025-04-09 03:21:46','2025-04-09 03:21:46'),(10,'Enrollment / Registration',1,'2025-04-09 03:22:18','2025-04-09 03:22:18'),(11,'English as a Medium of Instruction',1,'2025-04-09 03:22:40','2025-04-09 03:22:40'),(12,'Course Description (maximum of 5 per certification)',1,'2025-04-09 03:23:07','2025-04-09 03:23:07'),(13,'Transcript of Records (1st time Requests)',1,'2025-04-09 03:23:26','2025-04-09 08:33:00'),(14,'Original Diploma',1,'2025-04-09 03:23:39','2025-04-09 03:23:39'),(15,'Copy of Diploma',1,'2025-04-09 03:23:49','2025-04-09 03:23:49'),(16,'Form 137',1,'2025-04-09 03:24:00','2025-04-09 03:24:50'),(17,'Related Learning Experience',1,'2025-04-09 03:24:18','2025-04-09 03:24:18'),(18,'Certification / Authentication / Verification',1,'2025-04-09 03:24:42','2025-04-09 03:24:42'),(19,'Copy of Transcript of Records',1,'2025-04-09 08:33:31','2025-04-09 08:33:31'),(20,'Transfer Credentials (Honorable dismissal with Certificate of Grades)',1,'2025-04-09 08:48:47','2025-04-09 08:48:47');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
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
  `attempts` tinyint unsigned NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_02_08_164553_create_students_table',1),(8,'2025_02_10_094936_modify_preferred_time_column_in_schedules_table',5),(14,'2025_02_09_030156_add_is_admin_and_faculty_id_to_users_table',6),(15,'2025_02_09_060408_create_files_table',6),(16,'2025_02_10_085840_add_preferred_time_to_schedules_table',6),(17,'2025_02_11_060703_create_permission_tables',6),(18,'2025_02_24_054821_create_password_resets_table',6),(19,'2025_02_25_071336_add_reason_school_year_semester_to_schedules_table',6),(20,'2025_02_25_081736_create_school_years_table',6),(21,'2025_02_25_081817_create_semesters_table',6),(22,'2025_02_27_063825_add_school_semester_id_to_schedules',7),(23,'2025_02_27_064405_add_school_year_id_to_schedules',7),(24,'2025_03_25_171751_update_schedules_table',8),(25,'2025_03_26_030000_update_schedules_table',9),(26,'2025_03_26_121538_add_manual_fields_to_schedules',10),(27,'2025_03_26_132312_add_role_to_users_table',11),(28,'2025_04_09_094329_file_requirements_table',12),(29,'2025_04_09_094527_file_requests_table',13),(30,'2025_04_09_094707_file_request_items_table',14),(31,'2025_04_10_140551_add_reference_id_to_schedules_table',15),(32,'2025_04_10_150702_add_compliance_addressed_to_schedules_status_enum',16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',5);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
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
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2025-03-26 06:09:59','2025-03-26 06:09:59');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_year_id` bigint unsigned DEFAULT NULL,
  `semester_id` bigint unsigned DEFAULT NULL,
  `student_id` bigint unsigned DEFAULT NULL,
  `file_id` bigint unsigned NOT NULL,
  `preferred_date` date NOT NULL,
  `status` enum('pending','approved','rejected','completed','compliance_addressed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_time` enum('AM','PM') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AM',
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `copies` int NOT NULL DEFAULT '1',
  `school_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manual_school_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manual_semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_student_id_foreign` (`student_id`),
  KEY `schedules_school_year_id_foreign` (`school_year_id`),
  KEY `schedules_semester_id_foreign` (`semester_id`),
  KEY `schedules_reference_id_foreign` (`reference_id`),
  CONSTRAINT `schedules_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `schedules` (`id`),
  CONSTRAINT `schedules_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  CONSTRAINT `schedules_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (50,1,2,8,12,'2025-04-18','compliance_addressed',NULL,'test compliance',NULL,'2025-04-10 07:56:36','2025-04-10 08:47:49',NULL,'AM','test compliance',1,NULL,NULL,NULL,NULL),(53,1,2,8,12,'2025-04-21','compliance_addressed',NULL,'Test',NULL,'2025-04-10 08:55:49','2025-04-11 14:56:54',NULL,'AM','test',1,NULL,NULL,NULL,NULL),(54,1,2,8,14,'2025-04-21','approved',NULL,NULL,NULL,'2025-04-10 08:55:49','2025-04-10 09:46:59',NULL,'AM','test multi files',1,NULL,NULL,NULL,NULL),(59,1,2,9,12,'2025-04-17','approved',NULL,NULL,NULL,'2025-04-11 04:45:05','2025-04-11 04:53:42',NULL,'AM','Test',5,NULL,NULL,NULL,NULL),(60,1,2,10,14,'2025-04-16','approved',NULL,NULL,NULL,'2025-04-11 04:47:05','2025-04-11 04:56:58',NULL,'AM','For job application requirements',1,NULL,NULL,NULL,NULL),(62,1,2,8,12,'2025-04-17','approved',53,NULL,NULL,'2025-04-11 14:56:54','2025-04-11 14:58:09',NULL,'AM','Pending compliance',1,NULL,NULL,NULL,NULL),(63,1,2,8,6,'2025-04-22','pending',NULL,NULL,NULL,'2025-04-12 07:37:05','2025-04-12 07:37:05',NULL,'AM','Test',1,NULL,NULL,NULL,NULL),(64,1,2,8,1,'2025-04-18','pending',NULL,NULL,NULL,'2025-04-13 17:44:11','2025-04-13 17:44:11',NULL,'AM','Test',1,NULL,NULL,NULL,NULL),(65,1,2,8,12,'2025-04-22','pending',NULL,NULL,NULL,'2025-04-13 17:48:38','2025-04-13 17:48:38',NULL,'AM','2',1,NULL,NULL,NULL,NULL),(66,1,2,8,1,'2025-04-22','pending',NULL,NULL,NULL,'2025-04-13 17:48:39','2025-04-13 17:48:39',NULL,'AM','2',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_years`
--

DROP TABLE IF EXISTS `school_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `school_years` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `school_years_year_unique` (`year`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_years`
--

LOCK TABLES `school_years` WRITE;
/*!40000 ALTER TABLE `school_years` DISABLE KEYS */;
INSERT INTO `school_years` VALUES (1,'2024-2025','2025-02-27 00:14:47','2025-02-27 00:14:47');
/*!40000 ALTER TABLE `school_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semesters`
--

DROP TABLE IF EXISTS `semesters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semesters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_year_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `semesters_school_year_id_foreign` (`school_year_id`),
  CONSTRAINT `semesters_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semesters`
--

LOCK TABLES `semesters` WRITE;
/*!40000 ALTER TABLE `semesters` DISABLE KEYS */;
INSERT INTO `semesters` VALUES (1,'1st Semester',1,'2025-02-27 00:15:05','2025-02-27 00:15:05'),(2,'2nd Semester',1,'2025-03-25 08:31:58','2025-03-25 08:31:58');
/*!40000 ALTER TABLE `semesters` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('aGfjNwtLYpFJkHCHFO1iilMFrTPV9iwpEqohGcjD',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRUxyY080ekZJc0k3cEZOWjhBemdZWHJqT2wyVWtyWVoyVjdmbWN6MCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3R1ZGVudC9zY2hlZHVsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTQ6ImxvZ2luX3N0dWRlbnRfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=',1742982852),('IC6SyGQy33EL7V2QdXVfvX6malYXHlSZ49rffyAC',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFFHUk1wN1lETW9qMTNPYnBNcG16aWc5WTk3cW9FdGo0d1R3SUZQWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L3NjaGVkdWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NDoibG9naW5fc3R1ZGVudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',1742989310),('vD8zcMvk5qazMLq4i2vzYlTVXq4xmngOZX3MEFzG',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXdscW9uZ0d5NGg2Q01JeVVBcWJpYnl1R0tlTk1kVUE5M3dYM0E0SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=',1744040513);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_student_id_unique` (`student_id`),
  UNIQUE KEY `students_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'0000001','Studentante','Test','Studentedited@gmail.com','BSCS','09239371611','$2y$12$N0RruQtBt1I68astYqaB7eMb9/qYTy5PqLfd5sl/Tv.MVFQeUjvMe','2025-02-08 19:40:46','2025-02-23 02:28:04'),(2,'0000002','Sung','Jin Woo','Addnewstudent@gmail.com','BSCS','09239371611','$2y$12$k6FTLT.zCnN/ASPHgDrHfOzN1Ztq/5NvQ4CB1RrmDSwXOI7EuS/iO','2025-02-12 02:51:48','2025-02-13 05:21:42'),(4,'0000003','Third','Student','thirdstudent@gmail.com','BSCS','09239371611','$2y$12$gJeDbqgG4MbPGUzmXrmFbuE7czPXQVQNu1YkzmQX4iPXHHiiJzY7K','2025-02-12 23:15:59','2025-02-12 23:15:59'),(6,'12-31231','Trersrser','Sdfsdf','testessetst@gmail.com','BAT','09542816926','$2y$12$eMt9vnsFFNmO6wEiDOufAu3J9r/9FO9bkgvptcstxNizma0io7JGe','2025-03-25 20:59:40','2025-03-25 20:59:40'),(7,'12-38172','Aasdasdasdasdasd','Aasdasdasd','dumdumlangs3@gm','BSCS','09542816926','$2y$12$2Mm8BI950c64.6imR50h9uye8CCKY6OHdd/JGyks2z.pLJTnsXyTG','2025-04-07 08:33:32','2025-04-07 08:33:32'),(8,'20-00255','Darius','Mora','dariusanity122@gmail.com','BSCS','09542816926','$2y$12$92CKZInwQxY607Qyt4Znt.y25eoLrOg9xvvMEbO4/4xqX/IoMbq1i','2025-04-09 07:46:58','2025-04-09 07:46:58'),(9,'21-16027','Ace','Sembrano','ceaonarbmes13@gmail.com','BSCS','09636272881','$2y$12$Zv97K0X9S/gEeDHfezG38OXxGLN3.YUty5RRo9F0vVswKTig15YxW','2025-04-11 03:36:05','2025-04-11 03:36:05'),(10,'21-160133','Fedelino','Pimentel','fedelinopimentel16@gmail.com','BSCS','09707638768','$2y$12$gZlKEIc2CExd1b/We6US1.4AkP9oqN1CYYRftDj2lrLN2P4/EvwmW','2025-04-11 04:40:04','2025-04-11 04:40:04');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `prevent_student_id_update` BEFORE UPDATE ON `students` FOR EACH ROW BEGIN
    IF OLD.id != NEW.id THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot change the student ID once it is in use';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `is_admin` tinyint(1) NOT NULL DEFAULT '1',
  `faculty_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_faculty_id_unique` (`faculty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Test','prmsuadmintest@gmail.com',NULL,'$2y$12$GlDMOMiTuXs8ydHfTybRYOYiw3qK6WxW2PbT/O6jZz5e/NbBR9.2u',NULL,'2025-02-08 19:38:46','2025-02-08 19:38:46',1,'0000001','admin'),(2,'Admin Test2','prmsuadminhasrole@gmail.com',NULL,'$2y$12$jvhRSriIzHnqkYzs9cZ6v.DeVM9Wfi.iDco8oazGXzW9GTqM7uQ5i','rYLAGfQFF8y4Wxnfved4dxGrTNXh1YEk3ftKPtQsonVZGck1ueFTxB5qWAHT','2025-02-10 22:27:58','2025-02-10 22:27:58',1,'0000002','admin'),(3,'Super Admin','superadmin@example.com',NULL,'$2y$12$RfpHoyrOlk0R2r8HICxj0ewzTa5lhNg4roHDz1RDipXhSXRIsQlqO',NULL,'2025-03-26 05:27:16','2025-03-26 06:00:50',1,'FAC12345','superadmin'),(4,'faculty1','faculty1@gmail.com',NULL,'$2y$12$F6xu6GJhSNX.Qvh/cPnH7eP9zEyDhaLWwGLEkExNtLnpEezuDbEmW',NULL,'2025-03-26 06:08:45','2025-03-26 06:08:45',1,'12371236','admin'),(5,'test faculty','testfaculty@gmail.com',NULL,'$2y$12$31dHwciRYd7eFM5PFbI2TO1jrNP8W27ZMIcao3ldcjsXSY6Ek4HIS',NULL,'2025-03-26 06:16:38','2025-03-26 06:16:38',1,'236877','admin');
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

-- Dump completed on 2025-04-16 12:07:51
