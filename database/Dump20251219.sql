-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tourism_permits_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area_permit`
--

DROP TABLE IF EXISTS `area_permit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area_permit` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permit_id` char(36) NOT NULL,
  `area_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `area_permit_permit_id_foreign` (`permit_id`),
  KEY `area_permit_area_id_foreign` (`area_id`),
  CONSTRAINT `area_permit_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `area_permit_permit_id_foreign` FOREIGN KEY (`permit_id`) REFERENCES `permits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_permit`
--

LOCK TABLES `area_permit` WRITE;
/*!40000 ALTER TABLE `area_permit` DISABLE KEYS */;
INSERT INTO `area_permit` VALUES (1,'019b36d8-dba3-7156-8128-d6f5a218b3f8',1),(2,'019b36d8-dba3-7156-8128-d6f5a218b3f8',2),(3,'019b36db-d18c-7275-bfc0-ebe7c976fdc9',1),(4,'019b36db-d18c-7275-bfc0-ebe7c976fdc9',2),(5,'019b36dc-66f8-7243-8ad1-c2c6ea204729',1),(6,'019b36dc-66f8-7243-8ad1-c2c6ea204729',2),(7,'019b36dd-7a96-7227-a5ec-77234693afbb',1),(8,'019b36dd-7a96-7227-a5ec-77234693afbb',2),(9,'019b36de-cfac-72da-a2d3-111131b87684',1),(10,'019b36de-cfac-72da-a2d3-111131b87684',2),(11,'019b36df-1492-71c7-bede-2806f1374120',1),(12,'019b36df-1492-71c7-bede-2806f1374120',2),(13,'019b36df-6204-71b9-8208-7b0696baa4c4',1),(14,'019b36df-6204-71b9-8208-7b0696baa4c4',2),(15,'019b36df-938d-718b-9f81-acde1ffb888b',1),(16,'019b36df-938d-718b-9f81-acde1ffb888b',2),(17,'019b36e0-23d0-704c-86ec-bebdb4f599ad',1),(18,'019b36e0-23d0-704c-86ec-bebdb4f599ad',2),(19,'019b3705-1e76-70c2-819d-a5ae4fe2145a',1),(20,'019b3705-1e76-70c2-819d-a5ae4fe2145a',2),(21,'019b3706-7810-71d1-aaa2-3cf29ca5d10d',1),(22,'019b3706-7810-71d1-aaa2-3cf29ca5d10d',2),(23,'019b3707-789f-734b-a0fb-d799a1ea60ac',1),(24,'019b3707-789f-734b-a0fb-d799a1ea60ac',2),(25,'019b370a-cdac-72f3-847c-2ab2a08e9fcb',1),(26,'019b370a-cdac-72f3-847c-2ab2a08e9fcb',2),(27,'019b370b-67e9-719f-bce2-c8d061847752',1),(28,'019b370b-67e9-719f-bce2-c8d061847752',2);
/*!40000 ALTER TABLE `area_permit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `areas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `areas_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Bandarban Area',1,'2025-12-19 07:27:15','2025-12-19 07:27:15'),(2,'Keukarana',1,'2025-12-19 07:27:23','2025-12-19 07:27:23');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
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
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
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
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `drivers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drivers`
--

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_12_16_191848_create_permits_table',1),(5,'2025_12_16_200958_create_tour_guides_table',1),(6,'2025_12_16_201340_add_tour_guide_id_to_permits_table',1),(7,'2025_12_17_041358_add_verification_code_to_users_table',1),(8,'2025_12_17_092619_create_team_members_table',1),(9,'2025_12_17_110851_add_verification_fields_to_users_table',2),(10,'2025_12_18_093854_add_role_to_users_table',3),(11,'2025_12_18_102106_create_drivers_table',4),(12,'2025_12_18_103908_add_details_to_team_members_table',5),(13,'2025_12_18_110256_add_details_to_tourism_tables',6),(14,'2025_12_18_111308_make_visit_date_nullable_on_permits_table',7),(15,'2025_12_18_111719_remove_unique_constraint_from_permits',8),(16,'2025_12_18_124115_create_site_settings_table',9),(17,'2025_12_18_160413_add_2fa_to_users_table',10),(18,'2025_12_18_180702_add_detailed_fields_to_guides_table',11),(19,'2025_12_18_182235_add_military_details_to_users_table',12),(20,'2025_12_18_194250_add_status_to_permits_table',13),(21,'2025_12_19_052604_add_details_to_team_members',14),(22,'2025_12_19_053559_add_payment_fields_to_permits_table',15),(23,'2025_12_19_090040_add_driver_details_to_permits_table',16),(24,'2025_12_19_090728_add_payment_and_leader_columns_to_permits_table',17),(25,'2025_12_19_100644_fix_permits_to_uuid',18),(26,'2025_12_19_113933_create_areas_table',19),(27,'2025_12_19_113935_create_area_permit_table',19),(28,'2025_12_19_133736_remove_area_name_from_permits_table',20),(29,'2025_12_19_142218_add_is_defense_to_permits_table',21);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
-- Table structure for table `permits`
--

DROP TABLE IF EXISTS `permits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permits` (
  `id` char(36) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `total_members` int(11) NOT NULL,
  `leader_name` varchar(255) NOT NULL,
  `leader_nid` varchar(255) NOT NULL,
  `is_defense` tinyint(1) NOT NULL DEFAULT 0,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `visit_date` date DEFAULT NULL,
  `arrival_datetime` datetime DEFAULT NULL,
  `departure_datetime` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` tinyint(1) NOT NULL DEFAULT 1,
  `document_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_guide_id` bigint(20) unsigned DEFAULT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `vehicle_ownership` varchar(255) DEFAULT NULL COMMENT 'Local Car or Personal Car',
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_contact` varchar(255) DEFAULT NULL,
  `driver_emergency_contact` varchar(255) DEFAULT NULL,
  `driver_blood_group` varchar(5) DEFAULT NULL,
  `driver_license_no` varchar(255) DEFAULT NULL,
  `driver_nid` varchar(255) DEFAULT NULL,
  `bkash_trx_id` varchar(255) DEFAULT NULL,
  `bkash_payment_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permits_tour_guide_id_foreign` (`tour_guide_id`),
  CONSTRAINT `permits_tour_guide_id_foreign` FOREIGN KEY (`tour_guide_id`) REFERENCES `tour_guides` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permits`
--

LOCK TABLES `permits` WRITE;
/*!40000 ALTER TABLE `permits` DISABLE KEYS */;
INSERT INTO `permits` VALUES ('019b3618-9af5-7223-9a0e-d53e7757894f','Dexter',1,'LA','3423423',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-19 16:04:00','2025-12-20 16:04:00','active',400.00,1,'permits/HTBAxQke6fKpKTlkb4DkwYdkJwGZUrXdsPMO8mkU.pdf','2025-12-19 04:12:20','2025-12-19 04:12:20',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','AB+','dfwe324','32432423','SIM_TRX_29BD036C','BK_SIM_1766139140'),('019b36d8-dba3-7156-8128-d6f5a218b3f8','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/20hR2c5w235xBLXOASqIE17NHJlh6plzVBM2Igaa.pdf','2025-12-19 07:42:20','2025-12-19 07:42:20',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_F42120A5','BK_SIM_1766151740'),('019b36db-d18c-7275-bfc0-ebe7c976fdc9','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/dRnrDw3GGMQdUnLWEMWcr0JOvlCNgr37StOf6hxI.pdf','2025-12-19 07:45:34','2025-12-19 07:45:34',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_9E5FA3E9','BK_SIM_1766151934'),('019b36dc-66f8-7243-8ad1-c2c6ea204729','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/c5XDgWZ139G7kn1xfNqRyWtK4oPlnlzfprG0kVKQ.pdf','2025-12-19 07:46:12','2025-12-19 07:46:12',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_E884777A','BK_SIM_1766151972'),('019b36dd-7a96-7227-a5ec-77234693afbb','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/KrlnqqCapdownuuJD5BXq8zyJZEhpgJykIA46roi.pdf','2025-12-19 07:47:23','2025-12-19 07:47:23',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_AD3E1570','BK_SIM_1766152043'),('019b36de-cfac-72da-a2d3-111131b87684','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/gjTg0cJcas8alofgHtHzpjLVllyheSX8fvCIXNCJ.pdf','2025-12-19 07:48:50','2025-12-19 07:48:50',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_29A43ADD','BK_SIM_1766152130'),('019b36df-1492-71c7-bede-2806f1374120','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/0wf7Rqo7C656NqD0zUgXHMqbAY8CpDMqDtDeBLVx.pdf','2025-12-19 07:49:08','2025-12-19 07:49:08',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_2BB87D1C','BK_SIM_1766152148'),('019b36df-6204-71b9-8208-7b0696baa4c4','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/C8ZPjLYo6x2jVk3xCgSlWyFy6PaaDppvV5yxerrZ.pdf','2025-12-19 07:49:27','2025-12-19 07:49:27',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_C1730226','BK_SIM_1766152167'),('019b36df-938d-718b-9f81-acde1ffb888b','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/UFnybwDOvbHCWHpPhEXqwjIoBmbUPLdcLXMEx7fq.pdf','2025-12-19 07:49:40','2025-12-19 07:49:40',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_542FC604','BK_SIM_1766152180'),('019b36e0-23d0-704c-86ec-bebdb4f599ad','Sample Text Name',1,'Lamim Zakir Pronay','3423423',0,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-20 19:35:00','2025-12-27 07:34:00','active',400.00,1,'permits/CNhv3RgXqboFeEZBN9pq6R4ekZOtTcSxG65vCgw4.pdf','2025-12-19 07:50:17','2025-12-19 07:50:17',2,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','B+','dfwe324','32432423','SIM_TRX_BFCFFC7D','BK_SIM_1766152217'),('019b3705-1e76-70c2-819d-a5ae4fe2145a','Sample Text Name',2,'Lamim Zakir Pronay','3423423',1,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-11 20:29:00','2025-12-19 08:30:00','active',400.00,1,'permits/gosj3Plp0MWGTSxrUI5bBFNcWmeh0P4biBpQ6gLv.pdf','2025-12-19 08:30:41','2025-12-19 08:30:41',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_B665BAE3','BK_SIM_1766154641'),('019b3706-7810-71d1-aaa2-3cf29ca5d10d','Sample Text Name',2,'Lamim Zakir Pronay','3423423',1,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-11 20:29:00','2025-12-19 08:30:00','active',400.00,1,'permits/B9jztX3GOtCZo13j85W4vI5tQHbYUDamEqJPlp06.pdf','2025-12-19 08:32:09','2025-12-19 08:32:09',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_69B14753','BK_SIM_1766154729'),('019b3707-789f-734b-a0fb-d799a1ea60ac','Sample Text Name',2,'lookkkkkkkkokokoko','3423423',1,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-11 20:29:00','2025-12-19 08:30:00','active',400.00,1,'permits/sU4X2kLyrQWYKtSTEAkVpCOhMdkG5YJS7mGM9dEG.pdf','2025-12-19 08:33:15','2025-12-19 08:33:15',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_274044C5','BK_SIM_1766154795'),('019b370a-cdac-72f3-847c-2ab2a08e9fcb','Sample Text Name',2,'lookkkkkkkkokokoko','3423423',1,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-11 20:29:00','2025-12-19 08:30:00','active',400.00,1,'permits/C3EJNcv2BLfCTesB6FoTme2wjWSDVjTHPHHCNK69.pdf','2025-12-19 08:36:53','2025-12-19 08:36:53',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_08FF891A','BK_SIM_1766155013'),('019b370b-67e9-719f-bce2-c8d061847752','Sample Text Name',2,'lookkkkkkkkokokoko','3423423',1,'01927063305','pronayfarab03@gmail.com',NULL,'2025-12-11 20:29:00','2025-12-19 08:30:00','active',400.00,1,'permits/WAYHCeOIug94BW8gXP90tXTAFXSP7spHvaNCqhuP.pdf','2025-12-19 08:37:33','2025-12-19 08:37:33',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_29A20E6B','BK_SIM_1766155053'),('1','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','completed',0.00,1,'permits/YSaGxoUb37vDa5CDWdw4mvDHPtMdOwfUG7rMF4Fo.pdf','2025-12-18 05:13:43','2025-12-19 00:28:44',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('10','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/rnsfNQoD49FMxMwJxCF8mqInxUSnCNi19RP64Hc9.pdf','2025-12-18 08:15:41','2025-12-18 08:15:41',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('11','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/GhhpzUg70j2XbABoQIwbjpeDvmUO4KpHilxYRGhf.pdf','2025-12-18 08:30:28','2025-12-18 08:30:28',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('12','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/3PK3QSacoCWv87cT4AwVmvVz4g8XMdAsyvpttiFi.pdf','2025-12-18 08:30:38','2025-12-18 08:30:38',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('13','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/3DTQ9ttWNlEeElKz5N2p1aJwLjvdOrHUNEkznFON.pdf','2025-12-18 08:34:18','2025-12-18 08:34:18',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('14','Sample Text Name',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-20 01:20:00','2025-12-21 11:18:00','completed',0.00,1,'permits/pIwczGytq52Q1KRBOV5XeLg7wpc2SV4uQhbiHoJJ.pdf','2025-12-18 23:19:20','2025-12-19 02:45:15',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('15','Sample Text Name',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-20 01:20:00','2025-12-21 11:18:00','completed',0.00,1,'permits/6vCKKLwJRiZ3VYSm1xE9r3GOwqMyhyFg4xFVB6Ry.pdf','2025-12-18 23:19:27','2025-12-19 00:28:24',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('16','Sample Text Name',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-20 01:20:00','2025-12-21 11:18:00','completed',0.00,1,'permits/VNxdqDfVlPJKUdtnnK6nk0u6PRYblm8JxVwHEBqA.pdf','2025-12-18 23:22:09','2025-12-19 02:48:23',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('17','Sample Text Changed',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-20 01:20:00','2025-12-21 11:18:00','active',0.00,1,'permits/3upVp1ZczfrQaDjm7CKCdtoajoPzcVa9OmLAoM9u.pdf','2025-12-18 23:23:30','2025-12-19 00:14:54',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('18','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',500.00,1,'permits/eFBvZwcXm8Fno2Hoar8dZDcbYw14oQr5P8m65M7d.pdf','2025-12-19 03:10:03','2025-12-19 03:10:03',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SIM_TRX_B20F4D3A','BK_SIM_1766135403'),('19','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',500.00,1,'permits/QKRDVTHEnTXmJjIQzVoV7SMlLAwfOJ2rQ9cwXogS.pdf','2025-12-19 03:12:50','2025-12-19 03:12:50',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SIM_TRX_4964A661','BK_SIM_1766135570'),('20','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',500.00,1,'permits/pcgCsFnpvbvCnMVuiU6RaVkgvQeecoIjGi1SnUgM.pdf','2025-12-19 03:14:47','2025-12-19 03:14:47',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SIM_TRX_A88234D4','BK_SIM_1766135687'),('21','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',500.00,1,'permits/ukmzIZGI0EBw4aY9F9qp0wGTI2dquo9KnItgcCO3.pdf','2025-12-19 03:16:48','2025-12-19 03:16:48',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SIM_TRX_79E7D54E','BK_SIM_1766135808'),('22','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',500.00,1,'permits/DrdU6yDbd4owkcYz0s4esQEZRSPkjImi4d0LN9WE.pdf','2025-12-19 03:18:18','2025-12-19 03:18:18',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_6C2D53E5','BK_SIM_1766135898'),('23','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',600.00,1,'permits/KBtswhQ5SLr586sM9gt5ANnXs7lTavsCxUcgULHV.pdf','2025-12-19 03:26:38','2025-12-19 03:26:38',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_9B860456','BK_SIM_1766136398'),('24','Dexter',1,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',10.00,1,'permits/chywOa08jO0vwPXYbJIT515aDqTbLi5dncPQe9yF.pdf','2025-12-19 03:26:59','2025-12-19 03:26:59',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_F94328D1','BK_SIM_1766136419'),('25','Dexter',2,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',10.00,1,'permits/hxFeWqStxz0T5LjYJf6r2fndhn1Dms80AfC5m1BR.pdf','2025-12-19 03:27:28','2025-12-19 03:27:28',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_AB2CDCC8','BK_SIM_1766136448'),('26','Dexter',2,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',20.00,1,'permits/PV5fppzdU0YwqY96PEirwKoyDRtkKTcEhzNVmmit.pdf','2025-12-19 03:32:57','2025-12-19 03:32:57',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_7B8C6329','BK_SIM_1766136777'),('27','Dexter',2,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',400.00,1,'permits/jTgEBcE98HCc1Ik4MoT6egMfAdPsOW9SAUQLtZUp.pdf','2025-12-19 03:33:31','2025-12-19 03:33:31',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_3218AF83','BK_SIM_1766136811'),('28','Dexter',2,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',400.00,1,'permits/fLQIu12POJAThdRqsF3RIoVi0xSmBRXYXoxh4bbl.pdf','2025-12-19 03:34:31','2025-12-19 03:34:31',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_492A966F','BK_SIM_1766136871'),('29','Dexter',2,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',400.00,1,'permits/U1yN2shbNvEHPeZ8z6whi0JRKLAmeKoqELVXonqc.pdf','2025-12-19 03:39:07','2025-12-19 03:39:07',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_21B38C30','BK_SIM_1766137147'),('30','Dexter',2,'LA','345345345',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-20 15:05:00','2025-12-21 15:05:00','active',410.00,1,'permits/F4gslJ0dQBYfjYMnAnMnuJBTaQdMcaGksV28AGPP.pdf','2025-12-19 03:39:24','2025-12-19 03:39:24',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','A-','dfwe324','32432423','SIM_TRX_B16D8E5F','BK_SIM_1766137164'),('31','Dexter',2,'LA','3423423',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-21 08:44:00','2025-12-26 08:39:00','active',410.00,1,'permits/Nj2Yg9iQVTG4UmhC5F8IQvpGR8rLqTp4tzhBrsGY.pdf','2025-12-19 03:40:13','2025-12-19 03:40:13',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_7BDFA8CA','BK_SIM_1766137213'),('32','Dexter',2,'LA','3423423',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-21 08:44:00','2025-12-26 08:39:00','active',410.00,1,'permits/ivQqANtEKHfwWIJwFLIQaQPFvwv6kPGSW2VvJkzC.pdf','2025-12-19 03:42:14','2025-12-19 03:42:14',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_A428408E','BK_SIM_1766137334'),('33','Dexter',2,'LA','3423423',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-21 08:44:00','2025-12-26 08:39:00','active',410.00,1,'permits/067qd7N6JgBveadjPGA5yGo10sxI7qgUXCHPI9tI.pdf','2025-12-19 03:45:35','2025-12-19 03:45:35',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_7392CCC2','BK_SIM_1766137535'),('34','Dexter',2,'LA','3423423',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-21 08:44:00','2025-12-26 08:39:00','active',800.00,1,'permits/1CC0ZcKONW6riJh4hQg906J4L1JsvVzQbp6Baf4n.pdf','2025-12-19 03:48:29','2025-12-19 03:48:29',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999',NULL,'dfwe324','32432423','SIM_TRX_1F8A161D','BK_SIM_1766137709'),('35','Dexter',1,'LA','3423423',0,'01518616659','pronayfarab02@gmail.com',NULL,'2025-12-19 16:04:00','2025-12-20 16:04:00','active',400.00,1,'permits/9A3HRTaephgQTxm5PHlrtHE2MgYS5OopGjJE5x9O.pdf','2025-12-19 04:04:44','2025-12-19 04:04:44',1,NULL,'Local Car','Sfsdffe','safasf','32432432','9999999999','AB+','dfwe324','32432423','SIM_TRX_6873CDD7','BK_SIM_1766138684'),('4','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/viIu1cyBW12VEfK9STgkaWiqsq9fDuhqP3n2cE4G.pdf','2025-12-18 05:18:08','2025-12-18 05:18:08',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('5','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/s9jAGBOAfVosBqHU2AoQ6VWz6pVJC9HQtU8CmvKG.pdf','2025-12-18 05:24:16','2025-12-18 05:24:16',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('6','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/jDXy3v14LojVn66AmXLWaxjtKsjhNJrAbmhZVkqp.pdf','2025-12-18 05:44:16','2025-12-18 05:44:16',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('7','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/v6etHPvc8Xei2P0mYHvNmMlogsWMcx2mfqLkiv26.pdf','2025-12-18 05:50:14','2025-12-18 05:50:14',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('8','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/0tJFE4rsnAKrNqX0qPwf6imEfiFHdOjxWdIRWgO8.pdf','2025-12-18 05:52:20','2025-12-18 05:52:20',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),('9','Abida Sultana',1,'Lamim Zakir Pronay','123213',0,'01927063305','pronayfarab02@gmail.com',NULL,'2025-12-18 17:01:00','2025-12-19 07:01:00','active',0.00,1,'permits/m8lVKYdIaR7yfu7o6MQc1aXnxFJFw8u46nTZswfj.pdf','2025-12-18 06:43:32','2025-12-18 06:43:32',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `permits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
INSERT INTO `sessions` VALUES ('4pgcfGuB4C484HcDP09zD6Ej1QIvw0fGuFytc0Lm',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS3hJNVQ4MXc3TlpoazdFMVZMZGRvRkU2UHBlYUZzNXd3MzB3U0dhMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJtaXQvdmVyaWZ5LzE3IjtzOjU6InJvdXRlIjtzOjEzOiJwZXJtaXQudmVyaWZ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1766122968),('RleEptqiAE0gsDcYOnaUR1CRqyLjE7fiy6pKAiJK',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoidlA0dUt5QVk0YTdxN1VzMUgyOFZRRHo4cGN0U0tXdkRvZEk1SWVKViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMzoicGVybWl0LmNyZWF0ZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMjoiMmZhX3ZlcmlmaWVkIjtiOjE7fQ==',1766139141),('v76sTrG6Ds5ZyeGavV7RCtmDpYpKPAnOBa9reu04',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0','YTo2OntzOjY6Il90b2tlbiI7czo0MDoidVVNSEtpT1dDWEZXb1hHNURueXFxcHVZOHJTbk9ScnlBbnlaa0plVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMzoicGVybWl0LmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMjoiMmZhX3ZlcmlmaWVkIjtiOjE7fQ==',1766155053);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'permit_instructions','Provide accurate information.\r\n\r\nBe respectful of local traditions and culture.\r\n\r\nSeek assistance from law enforcement or the administration for any needs.\r\n\r\nAbide by the existing laws of the country.\r\n\r\nMake an effort to preserve and improve the environment.\r\n\r\nTravel only with designated guides and drivers.\r\n\r\nRefrain from visiting unauthorized places or taking risky initiatives (such as entering the river during the rainy season, traveling on dangerous paths, or staying overnight in the forest).\r\n\r\nSubmit information cards at Army Camps or Police Outposts.','2025-12-18 08:15:33','2025-12-18 08:15:33'),(2,'emergency_contacts','ZIC Ruma Zone: 01769-291545\r\n\r\nSignals Ruma Zone: 01852-495087\r\n\r\nBazar Camp Signals: 01769-291546\r\n\r\nOfficer-in-Charge, Ruma Police Station, Ruma, Bandarban Hill District: 01320-110533','2025-12-18 08:15:33','2025-12-18 08:15:33'),(3,'site_logo','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALIAAACfCAYAAABduIOAAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAABfESURBVHhe7Z1bbBzXecf/3zkzs1xeRFIUxYsp2bItU3Ety1IlS1bjyo6cQDBcBE4e0jYPAfqUtg9JUaBAUTQtij4GbR76mIc2sFMkVRpDMGoYtevAsqMoka1EikRK1o0SI5kil+RyudzLzJzTh5ldLWf3DIfkjLgrn5/wF4E5M7O7s/85+53vXIaEEO8S0Reg0bQoUsrzpI2saSb+7fs/xtVbGZiWuWy76wp0tDH8zV98DZ2dXcvKtJE1TYbEM8e+jd+czQAd1vIiW8JoL+LWz76LwaGHlhVJKc+zZVs0mg2me1MX0NeDts3dy8T6erC5txuMNbbsijWylAITN2/BsR0Qo2BxTBAoqVP7JHz6lkdIiWLRDm6OCQkpBB5+eBu6upaHBcsROPK17+D93y6grX15aFF2gS2pAs6/8ffYOjC0rCxSaJFbyOLEe2fQM7ANUrjB4nUjpER32kJX2oCQMli8biQAixP6OoxgUawUbAFHJHPDVD5Dykji7B4TtzP40p99DyXbAeeNa721IkGwF+bx1r//NY699HywuAaBI3/8j3j/QoiR//vv1mbkhew8PrxwC0M7dkHY8d+xQkr0dFjoaTfhJmFkCaQMQm9bsCReyhLJGVkCKQPgwYIYufnpPHa9/A8o2g6MBIzsZOfw1vf/HMeOHg4W1yBw5E/+Ce+P5dCWbmBkawnnj/8ttg7WGznSOxauC8e24TgJybZh297fJGQncAMGsW2RsOK/yWtxbBucZGICQ7TwkRhA3P/bQArUJRrNRkAEMN5Y2sia1kB6Zg0auCq1XdUlGs1GwFRGNrSRNS0EkW/mBtKhhaZlqMbIQSNzSBCEEJibm8OVK1dw+fJllEolQBtZ03QoYmTiHI4QWFzMYeziRbz99ts4deoUZmdngSSMzBgD5xwUKdeyNhjnEXM5zQkRgcWcq72fSCnhCgHXFcGi9VMxMi2XJAYr1Ya+vj7s3bcPr776Ko4ePYr+/n4gipEZY5FNKYTA0lIeuYUFuG78vYAAQMRQKhYhRQIX8T5ABJRKJSzmci17LxIR0ikLm7rSwaJ1IkNjZAlCuVxGOp3G8PAwRkZGYBhej21DI0spcfr0aVy5cgX5fB7lcnllMxOBMYYLvz6D0yffxZ3f3YRpBkYwrRPDMJDNzuHHr/8HcgvZ6odoJRgjLC3l8dGZX/qdz61FsVjGwad34NWjz+CF/U+gd1M7nDhrZkVoUYmbVT5UGnl+fh75fB6u60KIaBecfDP3bR0A5/F3qAohkLJSGBgagmjRGpkRkF9chGWlYBgNL39TwzhDZn4R03M5fDqTjX1cBogUPXtr6BBhjOHIkSN48skn0dvbi7a2FORK4yCkhJQS+w49jz2/fwgPbXsEtl0O7rUuhBBoS6fx8h+9is19W+DYTnCXpsd2JEa2bceh5/4g8W7nJEhZBsavT+HtDy/iV7+dwN3MQrxjM4j5OeNGUleOynfQ1tYG0zRh2/bKJq5BCuE1BhKKkaWUKJfLXo3c+Fem6ZH+Td+KSAkYnME0OBjzfoHjQ9bFxcu02hpZo9k4qEFYoQcNaVoNIoAzEGsk9U+wNrKmqSAigBGokRQZC2gja5oOpo2seQAgP/3GiNVJG1nTMhChviZmBOLeXxXayJomwwshVFIRychSJi/4HbZJSBMN4bqJCRH7FbyhFqxOnPH118gGJ5gGweTJyODeuhY8IYXcyLFBlZ/FBJUkRIS2rk6kE5LV1RFao1YgRmDBsKK2saeomVZcDmB+fg43Ju9i565R2Ha0u2q1cAqPf9aDhGfmdjOZ81dQXN/YSPbdA3eyRXzzP38DWwjwCIZbFYwjOzuNf/7iCP5w/9PB0hrKeOmvXsOHd9vRaS1/D7bk6LWncPq7r2Lr0PCyssjLATACOAM4o0TEiLwaLUElTfD14lbiEMFIWTATkpGyVv5Z8eeeBuPianwccngkI0vUx7SxKviCmg1BCgGRkKKOHyf/11klFZGMrNHcL8gfCqySCnWJRrMRNAgpqqFFSGyhjaxpKrzQwhsgVC8om9XayJqmQhVakD/22TQt5PN55HI5LC4uVo/TRtY0F+SlyYJhBecctmPj9p3buHPnDn74wx/i+PHjKBQKgDayptnwauRgSOGl3kzTQt/mzRgcHMDu3bsxOjoKy/ImOGsja5oKIgJvEFowxqrbOzu7cPjwYTz33HPVSc6xG1lKGZomiYN7rVjNRkAEuELCEVLR9FoHwZ6ggFSvp3TcjRs3kMvl/OUAoiWzOSfMz83il7/4OZLyMueEX5/9CEtLebCQBLkmGVwp0W5yHNjeg0MP9yBlsPgemSGlsrHnNfjUplKWTExM4NatW1jILqBUKiGKZzgjzM/PY2lpCZxHOGANGByYm53F/Px8YjeLJgR/MaCetIGetAmDEeLyMfza3pudXa+wX2GlFXbu3In+/n4MDA6gvb0dUdZocRyBwaEh7D/wLBwnwgFroFyW2H/gWfT1bYHrJvMaGjWMCCVH4OS1WfzsSgZLZRc8Si0XESJWN+qPvNlPoUM1lEYeHh5Gf38/SqVS5DUYhAQ6OjrRtWlTrHdpLRJAd083UqlUYq+hUUMElB2JkiNQTqAiIQIYr6+NvfAiuPc9Qoo8wqrzRoikVmmswXVbd4GTBwGvhqRI4eZqYcxrBzVSWJtoRSNrNPcTIn9Yr0IqtJE1TYXX2GMNQgs9jFPTKki/Rm5gYsa8mlqFNrKmqSDVLOq1pt80mo2AWFgeObj3PbSRNU1FaGihY2RNq+CFEfUdIist6xDZyJSgNBuPBFB2BcqO8P4moCipf/KHOgRr4kqMrDrHiutaZOfncGliCo89MZrIow4kAJMzGCE/G+tB+hcnrFcoDtotin89iPtIruTirfN3IfyxFHHCOEdmZhrPDjLs2/25YPE93BL+9F/exJizFWm+3LEuGbCyt/Bff/l5DA49tKxMSnk+kpEv3vgUO3bugmPbweJ1IwFYnCHFSTlEb73I6n/JIAF0p5O7Ge8HJUfg0u08ZEJGnpmexhargKee3BUsvodbxNe/9z8YVxjZzN7Ej7/5eQwO1xs5Uj0VDAWSUJIQ6mOuuNXqSAkUHZGoVGFBLcr0m+7Z07QM1edF1sfIjOkOEU0LoUy/6RpZ00p4oVp9SFGZhKqaRtd4q0azQRDVL3LJmTeMU0qBXC4Hx7Fx8uRJfPDBB8jn84A2sqbZYARwXj/6zeAMkALFUgnZ+SzOnDmDy5cv63UtNM0Jqw7aXy6CRCplYWDrVvRt2YJvfetb+OpXv4otW7Z4xwVPpNFsJF5jr/7pvYx5a2g7jtcpxxhDd3d39bhYjSwlYBiGt/pLhJzhWrEsrgz614v3GThMk0fKe34WISKYlgXTSoVmElaNPx6ZK7Sm9Nvc3BxsuwzOeeQ3a5gcU5/ewaXxi+CG+knua4WIIKXE+XPnsZRPZl0Lw2S4cf06bk7chGkqL89nFsYYCkt5XPtkHOPnz8Jx7Mj+iILXedUga7HCHEHlN/Xxxx/jzp1PMTV1N/JiKCmL4+qVS/jFhychpYj1A1YwTIZL42OYnr4Lw1C+/TVjcMLMzDQuXxqHFXiOhcZDCImb1z7B7ckbmJ2ZBjeM4C5rhqmyFoytvkaWUqKjowO9vb3o6+tDW1saIsLCFsWig9179uHoF4/5j1VY+ZjVYpcd7H/2EIaGhmHb8c/Wtm2BkZFt2LtvP4rF+M/f6kgpYVoWHnl8FJ/bvQ89vX1wnfgekkT+s2qCWQu2ljl7RIRDhw6hq6urmqCOghACHR1deGjbw4mY2FtXjuORR7bDtKxEXkMIicGhIfT2bdYLwDRASgnLsrDjsVEMPbQdVioFKeO74b3GnkIhPmxo5PUghAvbLgc3x0q57CZi4gqO48J13AdiMFASSClRLpdg2+XYvwcWorDvI3YjazTrgYgarjRUeYydCm1kTRMhvdFvDTpE1px+02g2AoJf+wYbenyN6TeNZiOohBGNREw9i0gbWdM0VKZZBcOKWqnQRtY0FQyVgUMNFNy5BgYArutifHy8OrZTo9kovMHzjbVih4jrujhx4gSmpqaC5YBf5YuE5fUEtq4eBChhRYEI4IzVxceegnvfgwGAZVnYtWsXXLe+q1ECSFsMnRZhUxtPRJ0phjaTWlZpMzx+awUkALvBoipxyXaFsqFWS7Vnr0F8TFA/1okBqD4Ktb+/P1gOKYEOi9BlAd1pHrt60p6R0xZDewsr5FevNZASJVckKoUHl8FwL2dcq2oeWXGdGfwnOC0tLVUHLQd5UH46NeEEQ4G4FQVGAGeNFTYEnQHAjh078JWvfAV9fX3Bco3mviHhx8gNBtVH6tlrb2+HZVmRR7lpNEnBKDjFqUbku70BIZW1RnOfkV5niNGgNq7IMAwUCgVkMhlkMpnqodrImqaC4K2FHJTBGVzHxu07t2HbNl5//XX85Cc/0csBaJqTyozpoIgkLNNA/5Z+uK6L/fv3Y8+ePd5EZ21kTTMhoZ6zZzAC5wxEhN7eXhw+fBgHDx4E594kZ21kTVPB4KfbGoQXYbl6bWTNqiEicG7AMMz4M101qbZGUqE0shDehELDMOJ/s5qWhYhQLhUxPzeDzMwUbLscqz9CO0RCXkZp5FOnTuH69evIZDIoFovBYs1nFCKCY9u4cPZX+Nlbb2D6zu9gml6DKw68MKI+7VaRIo2sNjLnHFJKtLW1JbY8lab1kAAM00R3Ty9Gf+8ZdPX0wnUbD21YLZWevbqOkBqpUBYdOHAAjz76aLXXT6MBACkErFQbnt5/GLv3P4dN3fEZGdJLvQUzFhWtKUaupDVcN9k1JDSth5QStl2GXS75bSm1wVaLskNEZy00rYO3HICqi3pNNbJGc7+R8Bt6vD6siDRDRKNpFtRrv3m9eqrhb9rImqaCNYiPa6VCG1nTVJA/3qKhQhqV2siapqIyQ6TOxPqBkZpWggAwEJhvzoq4et4poI2saTbUjT1PKiIZubKIiiuSke5vaQ4ouERVjAqJCqpIvzYO5o+reeTgATWElQH+hyvYEksOsFB0Y1e24KLkaCdvNEQEi/PElOJ8ZbP5fiM/xKhTyM0Q5dwazf1BVuLh+tpY9+xpWgqqMW2dsIZhnBrNRkBEdfF1RZwIpmHAcRxIKZcNZtNG1jQVqg4RTgyu62Imk0Eul8N7772HN998E3Nzc4A2sqaZ8GZRNzayl5YD2lIpZLNZuK67bMKHNrKmqSDci4eXCzANAx2dnRgeHsaLL76Il19+Gb29vYA2sqbZUE114swLOxzHgWVZdZOitZE1TYUXD9eHFhWpiN3ItMLgDs2DQVLfM9WFFMulYkUj3xvQvDJEgG3bcF0ntBdG09oI4VbXPYl3Pqf05+zVd4asuUPkxo0bmJycRC6XQ6lUimRMzhnm5+fwv2+/FWl/TevBGEexUMDZX36Id//np1iYn4NhGMHd1kRY1sLLXASPuIfSyOfOncP169dh8OhvUsJ7Ik9bOu3dqSEvrGlVJAzDQLGwBMMw4QrXz/7Gg5dHVii4cw3KsldeeQUHDx5ER2cHUqlUpBFqriOwqbsHL7z4kveWIhyjaS2EEDCtFA49fxRHvvQK+rZshePYwd3WjNezp5YKpZEZY7Asq9odGJXKz8wqDtG0GEQEXv2e4/2iyQ8tyB/6GZQKpZHXSrAPXPNgktT3HJa1oJAQJnYjazTrgfxaWSUV2sia5oK80KWRwpysjaxpHvxEV122wl/TIsTH2sia5iJYC1fFvIFDKsLKNJr7TjAmvic/vFC0L7WRNU1DxaNhDT4VkYxM1VilPkEdhzgLeYea+4aUCUm59GA9BICYl2oL/gsjkpHvrWkh45eUcFwJ6a+dkYRk1Kv4GSdY+8Ul5hs0CqrGXkUqSAjxLhF9IVhQoZBbwHd+egbFTSPgcIPF68ZghE+n85iaycMwIt1Xq6Jgu9g12IV//fpe/2ZJxtWMrVRnrB0JwGCAFbYc5TqREija8X+/8Btw0zMzyGfnsGvXaLC4SmEpj/fPjGH76NMQgW5v00rh2uUL2P1wHx4aGVlWJqU8v6KRi4sL+OYPfo7Z9BCsJIxsMNyYXMCtOwuJGDlfdrF3ezfe+PbzkBJwEzRy/O/eQwIwOZBK0MhJM5vJYHpmBqOj4UY++dEYHhl9Gm4DI1+9dAFPKYwc6dqbnJAyGKwkxBnaTIa0xRNRu8XRZnrPQ0ElBktIGjWr+iUMXtgIFzmSkTWa+wWFJBXIH31XKBQwMTGBTz75BOVyGdBG1jQbwQq4IkYE13UwPTMNxhhOnz6NDz74AJlMBtBG1jQdwR69SkcIAMu0MDw8DM459uzZgxdeeAH9/f2ANrKm2WAh6TcAcB0XhmFgdHQUO3bsqI5/10bWNBfBmKJGfsXcEG1kTVMR1tgL6xDRRtY0DRL3al6VVMRuZEdIlByRSLcwAXBcCdsVcEQCL+DDOYNhsEQ+A/zOE8NUr/X7WYahvqFHfo0MUl+zOiPbto2zZ8/i9OnTyGQycIWAEAIhNwPg300E4In+DhzY1o3utAE3ZrPZrsQj/e049Fgf9m7vif38AGAYhMuXxnH1ylVY1kqfevVwRsjMZDB2YRyWEf/5Wxr/6+SVRl8Dqagry+fzuHTpEs6dO4dCoYC52VlvgZaaJTxVuFKiO21g59YOdFoccftMSImdA50Y7mlDvuQk0t3MOWFqagqLi7nQpwitGQIkJG5O3PDufE0dwdrYE0JHwNW5s7OzE1/+8pfxjW98AyMjIxgYGEB7e3t1iSQV5A8AGp/K480Ld3F3sQwj5rEBlsHwfxen8c6Fu7iRWYIZ4eZaLbYt8cQTu/DYYztRLsd/owgh0dnZhT1798G24z9/qxOMiYNSUecEwzCQTqdhWRYAwHXdyNO+hQTyZQdLtgvb9dbxih3yXsN1ZegHWytCSAwODaC9oyPy514NUgKpVAqDQ1uDRRr4OWNWn0NmqzXyemH+gnNhL7oeyH+NpM4PAI7jtQuSQkoJR9fGSurDCj+0CPnOYzeyRrMeSCVtZE0r4aXaGnWKrLKxp9FsJLW1b52CO9egjaxpGqRvYlWNHJYN1UbWNB11NXElPtZG1rQKQfMGpUIbWdNEVJ4hoggtQqrkFY0spcRioYyFoo1cFJUcLNmyfnuIsktlzOVLkbVQdDEf8ZjZxRIWCmUIf8xIFMF/eHdwe1ySUoKI6rbHqcp3F9welyoEt6vkui5cd+VZ+HVpN18sPLJYeV0Lp1zCD97+OXIOW3FFIAJg2w5mZ2cxMDAAqRyrdA9GhMWlMvJLdqSxDUSEu9PT6N60qdr7GIbjSmzutPCFz22NtOINI8LcnPeAl86ursi9eyu1qmspl8tYWFjAli39Ed6Rtwfza6qV9/au0fT0NHp6emCaZuTPEBUiwsLCAqSU6O7uXvH8RIR8Po/h4WGMBKby15LPL+LipSt4+pln6rrvUynChd+OYUtPV905Iq1rsRbs/ALMjk3BzfHhFgHeFtwaG8ViAVJKpNPtwaLYyGbn0d3dE9wcG/Pz8+js7IztiUtBHMdBqVRCR0dHsGjN5POLGLt0BXv2NjCyRbhwYQybuxsbecXQIiqFQgHvvPMOPvroo8RMPDs7i48//hiZ+XywKBZmZ2dx5swZ5HKLiZhYCIFTp07h/PnziZl4bGwMx48fT8zEUkpcvXoVt2/fjtXE8M/NOYdJnnFrxQGYpgXOvTVKasMbRImRo8IYQ2dnJ9KVR5MlQDabRaFQgG3H9xShWlzXheM4mJqaChbFguu6aG9vh2EYiV2jvr4+jIyMVL/wuCkUCjhx4gQuX74cLFo3hmEiMzONC2NjuHjx0jKNX76Ma1evYHZ2FpOTk3jjjTdQKpWqxyYSWmgeXObm5vDaa6/h2LFj2LlzZ7B43WSzWRSLRZAi15ZOp5HNZnHu3Dm89NJLsCwruRhZ41HJTjxIOI6DsbEx9Pf3Y3BwMFi8IWgjr4FsNosf/ehH2L59O3p7e2GaJiYmJvD4449XW/Lt7e2YnJzEU089hUcffTR4Ck3MxNrY+6zgOA6GhobAGMO1a9cwOTmJQqGAW7dugYhw+/ZtXLt2DTMzM4k0tjSN0TXyOqkNHxzH0ebdAKSU5/8fJGf24Bun1c0AAAAASUVORK5CYII=','2025-12-18 08:30:18','2025-12-18 08:30:18'),(4,'site_name','Bandarban Entry Permit','2025-12-18 08:30:18','2025-12-18 08:30:18'),(5,'permit_fee','400','2025-12-19 03:26:30','2025-12-19 03:48:25');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permit_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nid_or_passport` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(20) NOT NULL,
  `age_category` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_permit_id_foreign` (`permit_id`),
  CONSTRAINT `team_members_permit_id_foreign` FOREIGN KEY (`permit_id`) REFERENCES `permits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES (1,'1','Lamim Zakir Pronay','123213','2025-12-18 05:13:43','2025-12-18 05:13:43',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL),(2,'4','Lamim Zakir Pronay','111111111111','2025-12-18 05:18:08','2025-12-18 05:18:08',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL),(3,'5','Lamim Zakir Pronay','111111111111','2025-12-18 05:24:16','2025-12-18 05:24:16',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL),(4,'6','Lamim Zakir Pronay','111111111111','2025-12-18 05:44:16','2025-12-18 05:44:16','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(5,'7','Lamim Zakir Pronay','111111111111','2025-12-18 05:50:14','2025-12-18 05:50:14','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(6,'8','Lamim Zakir Pronay','111111111111','2025-12-18 05:52:20','2025-12-18 05:52:20','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(7,'9','Lamim Zakir Pronay','111111111111','2025-12-18 06:43:32','2025-12-18 06:43:32','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(8,'10','Lamim Zakir Pronay','111111111111','2025-12-18 08:15:41','2025-12-18 08:15:41','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(9,'11','Lamim Zakir Pronay','111111111111','2025-12-18 08:30:28','2025-12-18 08:30:28','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(10,'12','Lamim Zakir Pronay','111111111111','2025-12-18 08:30:38','2025-12-18 08:30:38','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(11,'13','Lamim Zakir Pronay','111111111111','2025-12-18 08:34:18','2025-12-18 08:34:18','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','222222222','9999999999','B+'),(12,'14','Lamim Zakir Sarker','111111111111','2025-12-18 23:19:20','2025-12-19 02:44:17','Zakir Hossain',34,'Male','Adult','Holding 167 Upazila Sarak','Doctor','01518616659','9999999999','B+'),(13,'15','Lamim Zakir Pronay','111111111111','2025-12-18 23:19:27','2025-12-18 23:19:27','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','01518616659','9999999999','B+'),(14,'16','Lamim Zakir Pronay','111111111111','2025-12-18 23:22:09','2025-12-18 23:22:09','Zakir Hossain',34,'','','Holding 167 Upazila Sarak','Engineer','01518616659','9999999999','B+'),(15,'17','Lamim Zakir fuufu','111111111111','2025-12-18 23:23:30','2025-12-19 00:14:54','Zakir Hossain',34,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01518616659','9999999999','B+'),(16,'18','Lamim Zakir Pronay','111111111111','2025-12-19 03:10:03','2025-12-19 03:10:03','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(17,'19','Lamim Zakir Pronay','111111111111','2025-12-19 03:12:50','2025-12-19 03:12:50','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(18,'20','Lamim Zakir Pronay','111111111111','2025-12-19 03:14:47','2025-12-19 03:14:47','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(19,'21','Lamim Zakir Pronay','111111111111','2025-12-19 03:16:48','2025-12-19 03:16:48','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(20,'22','Lamim Zakir Pronay','111111111111','2025-12-19 03:18:18','2025-12-19 03:18:18','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(21,'23','Lamim Zakir Pronay','111111111111','2025-12-19 03:26:38','2025-12-19 03:26:38','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(22,'24','Lamim Zakir Pronay','111111111111','2025-12-19 03:26:59','2025-12-19 03:26:59','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(23,'25','Lamim Zakir Pronay','111111111111','2025-12-19 03:27:28','2025-12-19 03:27:28','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(24,'25','Lamim Zakir Pronay','4234234','2025-12-19 03:27:28','2025-12-19 03:27:28','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','324234235','B+'),(25,'26','Lamim Zakir Pronay','111111111111','2025-12-19 03:32:57','2025-12-19 03:32:57','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(26,'26','Lamim Zakir Pronay','4234234','2025-12-19 03:32:57','2025-12-19 03:32:57','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','324234235','B+'),(27,'27','Lamim Zakir Pronay','111111111111','2025-12-19 03:33:31','2025-12-19 03:33:31','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(28,'27','Lamim Zakir Pronay','4234234','2025-12-19 03:33:31','2025-12-19 03:33:31','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','324234235','B+'),(29,'28','Lamim Zakir Pronay','111111111111','2025-12-19 03:34:31','2025-12-19 03:34:31','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(30,'28','Lamim Zakir Pronay','4234234','2025-12-19 03:34:31','2025-12-19 03:34:31','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','324234235','B+'),(31,'29','Lamim Zakir Pronay','111111111111','2025-12-19 03:39:07','2025-12-19 03:39:07','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(32,'29','Lamim Zakir Pronay','4234234','2025-12-19 03:39:07','2025-12-19 03:39:07','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','324234235','B+'),(33,'30','Lamim Zakir Pronay','111111111111','2025-12-19 03:39:24','2025-12-19 03:39:24','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(34,'30','Lamim Zakir Pronay','4234234','2025-12-19 03:39:24','2025-12-19 03:39:24','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','324234235','B+'),(35,'31','Lamim Zakir Pronay','111111111111','2025-12-19 03:40:13','2025-12-19 03:40:13','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(36,'31','Lamim Zakir Pronay','4234234','2025-12-19 03:40:13','2025-12-19 03:40:13','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','123','B+'),(37,'32','Lamim Zakir Pronay','111111111111','2025-12-19 03:42:14','2025-12-19 03:42:14','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(38,'32','Lamim Zakir Pronay','4234234','2025-12-19 03:42:14','2025-12-19 03:42:14','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','123','B+'),(39,'33','Lamim Zakir Pronay','111111111111','2025-12-19 03:45:35','2025-12-19 03:45:35','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(40,'33','Lamim Zakir Pronay','4234234','2025-12-19 03:45:35','2025-12-19 03:45:35','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','123','B+'),(41,'34','Lamim Zakir Pronay','111111111111','2025-12-19 03:48:29','2025-12-19 03:48:29','Zakir Hossain',34,'Male','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(42,'34','Lamim Zakir Pronay','4234234','2025-12-19 03:48:29','2025-12-19 03:48:29','cd',45,'Male','Adult','Holding 167 Upazila Sarak','4534','01927063305','123','B+'),(43,'019b3618-9af5-7223-9a0e-d53e7757894f','Lamim Zakir Pronay','111111111111','2025-12-19 04:12:20','2025-12-19 04:12:20','Zakir Hossain',34,'Female','Adult','pronayfarab02@gmail.com','Engineer','1927063305','9999999999','B+'),(44,'019b36d8-dba3-7156-8128-d6f5a218b3f8','Lamim Zakir Pronay','123213','2025-12-19 07:42:20','2025-12-19 07:42:20','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(45,'019b36db-d18c-7275-bfc0-ebe7c976fdc9','Lamim Zakir Pronay','123213','2025-12-19 07:45:34','2025-12-19 07:45:34','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(46,'019b36dc-66f8-7243-8ad1-c2c6ea204729','Lamim Zakir Pronay','123213','2025-12-19 07:46:12','2025-12-19 07:46:12','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(47,'019b36dd-7a96-7227-a5ec-77234693afbb','Lamim Zakir Pronay','123213','2025-12-19 07:47:23','2025-12-19 07:47:23','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(48,'019b36de-cfac-72da-a2d3-111131b87684','Lamim Zakir Pronay','123213','2025-12-19 07:48:50','2025-12-19 07:48:50','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(49,'019b36df-1492-71c7-bede-2806f1374120','Lamim Zakir Pronay','123213','2025-12-19 07:49:08','2025-12-19 07:49:08','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(50,'019b36df-6204-71b9-8208-7b0696baa4c4','Lamim Zakir Pronay','123213','2025-12-19 07:49:27','2025-12-19 07:49:27','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(51,'019b36df-938d-718b-9f81-acde1ffb888b','Lamim Zakir Pronay','123213','2025-12-19 07:49:40','2025-12-19 07:49:40','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(52,'019b36e0-23d0-704c-86ec-bebdb4f599ad','Lamim Zakir Pronay','123213','2025-12-19 07:50:17','2025-12-19 07:50:17','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(53,'019b3705-1e76-70c2-819d-a5ae4fe2145a','Lamim Zakir Pronay','123213','2025-12-19 08:30:41','2025-12-19 08:30:41','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(54,'019b3705-1e76-70c2-819d-a5ae4fe2145a','Lamim Zakir Pronay','2324','2025-12-19 08:30:41','2025-12-19 08:30:41','wewqe',232,'Female','Adult','Holding 167 Upazila Sarak','tease','01927063305','2423432','b+'),(55,'019b3706-7810-71d1-aaa2-3cf29ca5d10d','Lamim Zakir Pronay','123213','2025-12-19 08:32:09','2025-12-19 08:32:09','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(56,'019b3706-7810-71d1-aaa2-3cf29ca5d10d','Lamim Zakir Pronay','2324','2025-12-19 08:32:09','2025-12-19 08:32:09','wewqe',232,'Female','Adult','Holding 167 Upazila Sarak','tease','01927063305','2423432','b+'),(57,'019b3707-789f-734b-a0fb-d799a1ea60ac','Lamim Zakir Pronay','123213','2025-12-19 08:33:15','2025-12-19 08:33:15','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(58,'019b3707-789f-734b-a0fb-d799a1ea60ac','Lamim Zakir Pronay','2324','2025-12-19 08:33:15','2025-12-19 08:33:15','wewqe',232,'Female','Adult','Holding 167 Upazila Sarak','tease','01927063305','2423432','b+'),(59,'019b370a-cdac-72f3-847c-2ab2a08e9fcb','Lamim Zakir Pronay','123213','2025-12-19 08:36:53','2025-12-19 08:36:53','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(60,'019b370a-cdac-72f3-847c-2ab2a08e9fcb','Lamim Zakir Pronay','2324','2025-12-19 08:36:53','2025-12-19 08:36:53','wewqe',232,'Female','Adult','Holding 167 Upazila Sarak','tease','01927063305','2423432','b+'),(61,'019b370b-67e9-719f-bce2-c8d061847752','Lamim Zakir Pronay','123213','2025-12-19 08:37:33','2025-12-19 08:37:33','Zakir Hossain',22,'Male','Adult','Holding 167 Upazila Sarak','Engineer','01927063305','9999999999','B+'),(62,'019b370b-67e9-719f-bce2-c8d061847752','Lamim Zakir Pronay','2324','2025-12-19 08:37:33','2025-12-19 08:37:33','wewqe',232,'Female','Adult','Holding 167 Upazila Sarak','tease','01927063305','2423432','b+');
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_guides`
--

DROP TABLE IF EXISTS `tour_guides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_guides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `license_id` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nid_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tour_guides_license_id_unique` (`license_id`),
  UNIQUE KEY `tour_guides_email_unique` (`email`),
  UNIQUE KEY `tour_guides_nid_number_unique` (`nid_number`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_guides`
--

LOCK TABLES `tour_guides` WRITE;
/*!40000 ALTER TABLE `tour_guides` DISABLE KEYS */;
INSERT INTO `tour_guides` VALUES (1,'Lamim Zakir Pronay','213213',1,'123213','2025-12-18 03:36:14','2025-12-18 03:36:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Aman Rathor','08272953868',1,'234325','2025-12-18 12:13:01','2025-12-18 12:13:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tour_guides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ba_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `corps` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google2fa_secret` text DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `formation` varchar(255) DEFAULT NULL,
  `appointment` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `date_of_commission` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_ba_no_unique` (`ba_no`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','System Admin','','','admin@example.com',NULL,'$2y$12$NkObrZVLg2vIAj8D1qojje16RfTMkrFvLH2.v0YfeCxoqjQBTAtba','admin',NULL,'2025-12-17 05:09:11','2025-12-18 23:12:56','BITRCF3GGYAMHYLJ',NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2025-12-19 21:07:05
