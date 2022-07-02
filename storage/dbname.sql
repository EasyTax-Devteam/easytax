-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: easytax
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

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
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `narration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mpesa_checkout_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mpesa_log` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (5,'5','initial bill','80',1,'A027154198T','ws_CO_08122021171657281105','{\n            \"ResponseCode\": \"0\",\n            \"ResponseDescription\":\"The service request has been accepted successsfully\",\n            \"MerchantRequestID\":\"129863-7919031-1\",\n            \"CheckoutRequestID\":\"ws_CO_08122021171657281105\",\n            \"ResultCode\": \"0\",\n            \"ResultDesc\":\"The service request is processed successfully.\"\n        }\n        ','2021-12-08 14:16:49','2021-12-08 14:18:02'),(6,'6','initial bill','100',1,'A007154198X','ws_CO_17022022102219898128','{\n            \"ResponseCode\": \"0\",\n            \"ResponseDescription\":\"The service request has been accepted successsfully\",\n            \"MerchantRequestID\":\"22685-26923210-1\",\n            \"CheckoutRequestID\":\"ws_CO_17022022102219898128\",\n            \"ResultCode\": \"0\",\n            \"ResultDesc\":\"The service request is processed successfully.\"\n        }\n        ','2022-02-17 07:22:00','2022-02-17 07:22:43'),(8,'7','initial bill','150',1,'P003454198X','ws_CO_17022022104255239600','{\n            \"ResponseCode\": \"0\",\n            \"ResponseDescription\":\"The service request has been accepted successsfully\",\n            \"MerchantRequestID\":\"80778-26353408-1\",\n            \"CheckoutRequestID\":\"ws_CO_17022022104255239600\",\n            \"ResultCode\": \"0\",\n            \"ResultDesc\":\"The service request is processed successfully.\"\n        }\n        ','2022-02-17 07:42:48','2022-02-17 07:43:07');
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itax_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (3,'idd.otuya@outlook.com','A027154198T','0705969696','Juma','James','123wsss','2021-12-08 14:16:49','2021-12-08 14:16:49'),(4,'iotuya05@gmail.com','A007154198X','0705007984','Idd','Juma','1234567','2022-02-17 07:22:00','2022-02-17 07:22:00'),(5,'idd.otuya@outlook.com','P003454198X','Sampel llp','A003454198X','inc.','P003454198X','2022-02-17 07:42:48','2022-02-17 07:42:48');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_11_27_115808_create_services_table',1),(6,'2021_11_27_124534_create_payments_table',1),(7,'2021_11_27_125745_create_sites_table',1),(8,'2021_11_27_135307_create_order_assignments_table',1),(10,'2021_12_06_103030_create_bills__table',2),(11,'2021_12_06_103158_create_orders_table',2),(12,'2021_11_27_144438_create_customers_table',3),(13,'2021_12_08_070500_add_cols_to_payments_table',4),(14,'2021_12_08_100454_add_acts_to_orders_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_assignments`
--

DROP TABLE IF EXISTS `order_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_assignments_order_admin_unique` (`order`,`admin`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_assignments`
--

LOCK TABLES `order_assignments` WRITE;
/*!40000 ALTER TABLE `order_assignments` DISABLE KEYS */;
INSERT INTO `order_assignments` VALUES (1,'4','5','2021-12-08 14:27:45','2021-12-08 14:27:45'),(2,'3','6','2022-02-17 07:34:18','2022-02-17 07:34:18'),(3,'5','6','2022-02-17 07:35:48','2022-02-17 07:35:48'),(5,'5','7','2022-02-17 07:44:56','2022-02-17 07:44:56');
/*!40000 ALTER TABLE `order_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itax_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_taxable_income` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paying_kenyan_insurance_policies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kenyan_insurance_policies_paid` text COLLATE utf8mb4_unicode_ci,
  `paid_mortgage_for_tax_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_nine_form` text COLLATE utf8mb4_unicode_ci,
  `income_and_expenses_schedule` text COLLATE utf8mb4_unicode_ci,
  `financial_statements` text COLLATE utf8mb4_unicode_ci,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `progress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_assigned',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (5,'3','A027154198T','123wsss','Yes',NULL,NULL,NULL,NULL,NULL,NULL,'10','2021-12-08 14:16:49','2021-12-08 14:27:45','in_progress'),(6,'4','A007154198X','1234567','Yes','Yes','Life Policy,Medical Policy','Yes',NULL,'a007154198x-income-expense-sch-1645082520.xls',NULL,'9','2022-02-17 07:22:00','2022-02-17 07:34:18','in_progress'),(7,'5','P003454198X','P003454198X','Yes',NULL,NULL,NULL,NULL,NULL,'p003454198x-f-stmt-0-1645083768.xls','12','2022-02-17 07:42:48','2022-02-17 07:44:56','in_progress');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '1',
  `order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mpesa_log` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'PL87TB94ZJ','254705007984','10',1,'5','2021-12-08 14:17:17','2021-12-08 14:17:17','{\"Body\":{\"stkCallback\":{\"MerchantRequestID\":\"129863-7919031-1\",\"CheckoutRequestID\":\"ws_CO_08122021171657281105\",\"ResultCode\":0,\"ResultDesc\":\"The service request is processed successfully.\",\"CallbackMetadata\":{\"Item\":[{\"Name\":\"Amount\",\"Value\":10},{\"Name\":\"MpesaReceiptNumber\",\"Value\":\"PL87TB94ZJ\"},{\"Name\":\"Balance\"},{\"Name\":\"TransactionDate\",\"Value\":20211208171717},{\"Name\":\"PhoneNumber\",\"Value\":254705007984}]}}}}'),(3,'QBH1AWTOAB','254705007984','10',1,'6','2022-02-17 07:22:31','2022-02-17 07:22:31','{\"Body\":{\"stkCallback\":{\"MerchantRequestID\":\"22685-26923210-1\",\"CheckoutRequestID\":\"ws_CO_17022022102219898128\",\"ResultCode\":0,\"ResultDesc\":\"The service request is processed successfully.\",\"CallbackMetadata\":{\"Item\":[{\"Name\":\"Amount\",\"Value\":10},{\"Name\":\"MpesaReceiptNumber\",\"Value\":\"QBH1AWTOAB\"},{\"Name\":\"Balance\"},{\"Name\":\"TransactionDate\",\"Value\":20220217102230},{\"Name\":\"PhoneNumber\",\"Value\":254705007984}]}}}}'),(4,'QBH6AY2YWO','254705007984','10',1,'8','2022-02-17 07:43:03','2022-02-17 07:43:03','{\"Body\":{\"stkCallback\":{\"MerchantRequestID\":\"80778-26353408-1\",\"CheckoutRequestID\":\"ws_CO_17022022104255239600\",\"ResultCode\":0,\"ResultDesc\":\"The service request is processed successfully.\",\"CallbackMetadata\":{\"Item\":[{\"Name\":\"Amount\",\"Value\":10},{\"Name\":\"MpesaReceiptNumber\",\"Value\":\"QBH6AY2YWO\"},{\"Name\":\"Balance\"},{\"Name\":\"TransactionDate\",\"Value\":20220217104302},{\"Name\":\"PhoneNumber\",\"Value\":254705007984}]}}}}');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `artwork` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (9,'Freelancer Tax Return','https://dev.easytax.co.ke/artwork/services/19c41a3f-c3bc-45b9-b99c-084ccaa6bd51.jpeg','100','isFreelance',1,'2021-12-02 09:30:47','2021-12-02 09:30:47'),(10,'Nill Tax Return','https://dev.easytax.co.ke/artwork/services/6fa784cb-426c-4a44-9681-3c263f0d1504.jpeg','80','isNill',1,'2021-12-02 09:31:04','2021-12-02 09:31:04'),(11,'Employee Tax Return','https://dev.easytax.co.ke/artwork/services/82b29f2b-3be3-4dfc-bc8e-76f575c59fa8.jpeg','125','isEmployee',1,'2021-12-02 09:31:21','2021-12-02 09:31:21'),(12,'Company Tax Return','https://dev.easytax.co.ke/artwork/services/06c6ca58-7878-40a7-a75a-a145cb1bac3f.jpeg','150','isCompany',1,'2021-12-02 09:31:32','2021-12-02 09:31:32');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `support_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (1,'info@easytax.co.ke','support@easytax.co.ke','+254 724 166 151','Ewaso Ngiro Road, Off Kabarsiran Avenue','Monday - Friday / 8AM - 5PM','https://web.facebook.com','https://twitter.com','https://linkedin.com','2021-12-02 09:24:07','2021-12-02 09:24:07');
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
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
  `root` tinyint(1) NOT NULL DEFAULT '1',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Root Admin','softbucket.io@gmail.com',NULL,'$2y$10$J21IWQhRv5QaIiRifyB.QuYDijnF67AIi0seunT9ibC/1f4X4oM9a',1,0,1,'AitwPKM0QnBMfcaNra08Qb79LeAChrynrNcCxD6TmgiAj4vQsW5czssjAlee','2021-11-23 00:33:28','2021-11-23 00:33:28'),(3,'Kim test','support@patahapa.com',NULL,'$2y$10$FujI.ti5kzqmTNnhzuLKLeRVzC8MzNRq9biqrxjkphLXcR/V1TaCS',0,1,1,NULL,'2021-11-27 07:19:08','2021-11-27 07:34:40'),(4,'test Admin','test2@gmail.com',NULL,'$2y$10$9cgqSok.etRXfC1DjS/wreZEKCC23r9KmJd0fIm3ER4O93BZMyiLu',0,1,1,'RojHynghRLEfpCAMogEHswVDgL5No34ybrCsecgnzz7yrjRiaid7PdFCokjU','2021-11-27 07:24:58','2021-11-27 07:34:44'),(5,'Samuel Njoroge','snjoroge@sterlingafricallp.com',NULL,'$2y$10$PLUZXexZNw1gqaUSIuE6Fum89gf.KLdcJJ5eYsX5WbCyosZ8ukQrC',0,1,1,NULL,'2022-02-17 07:35:33','2022-02-17 07:35:33');
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

-- Dump completed on 2022-06-19 19:35:15
