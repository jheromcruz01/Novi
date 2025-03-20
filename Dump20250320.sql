-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: novi
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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submitted_date` varchar(45) DEFAULT NULL,
  `ig_username` varchar(45) DEFAULT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `contact_number` varchar(45) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `province` varchar(155) DEFAULT NULL,
  `city` varchar(155) DEFAULT NULL,
  `barangay` varchar(155) DEFAULT NULL,
  `payment_method` varchar(45) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'16/03/2025 18:14:21','kittykatt.kittkatt','Kathlyn Mae Baja','09392834004','1986 RCN Dela Paz Dormitory P. Burgos St.','Pampanga','Angeles City','Lourdes Sur','Unionbank',0),(2,'16/03/2025 20:06:58','Lushmiaaa','Lushmia Fej Samaniego','09603827283','Blk 11 lot 4 East bellevue ph1 Brgy san isidro rodriguez rizal','Rizal','Rodriguez ','San isidro','Gcash',0),(3,'16/03/2025 21:51:47','ellesiii','Jouniella Ibarra','09761066608','Block 7 Lot 16, Aster St., VM Townhomes','Metro Manilq','Muntinlupa City','Barangay Putatan','Unionbank',0),(4,'17/03/2025 16:49:28','laleylaine','Jodi Calarion','09950016017','Unit B MGDD Apartment 2 Hawk St. Palo Alto','Cavite','Bacoor','Habay 1','Gcash',0),(5,'17/03/2025 22:21:48','vaughn_ardelicious','Ardel Abellano','09175992086','T4-23L Pioneer Woodlands Condominium, Barangka Ilaya, Mandaluyong City','Metro Manila','Mandaluyong','Barangka Ilaya','Gcash',0),(6,'17/03/2025 22:49:37','addlib_andrei','Andred Mejia','09985466426','#31 Alleyc15 P. Rosales St. Santa Ana Pateros','Metro Manila Pateros','Pateros','Santa Ana','Gcash',0),(7,'18/03/2025 17:23:45','Johnthirdee','JOHN OLIVER S. AUSTRIA III','09175337360','Bdo Heroes Hills Barangay Paligsahan Q. Ave. Q.City.','Metro Manila','Quezon City','Paligsahan','Gcash',0),(8,'18/03/2025 18:39:21','joycenavarro__','Mary Joyce Carmel Navarro','09175070730','454 San Rafael St. San Miguel Manila (Four Cousins Dental Clinic) ','Metro Manila','Manila','641','Gcash',0),(9,'18/03/2025 18:53:23','milk__and__cereal','Bryle Adriatico','09175686676','18-09 Casiana St Eroreco Subd Brgy Mandalagan Bacolod City','Negros Occidental','Bacolod City','Brgy. Mandalagan','Gcash',0),(10,'18/03/2025 19:49:28','johneusebio_','John Stephen S. Eusebio','0916 660 8926','41 sampaguita st. Sta. Quiteria Village, Caloocan City','Metro Manila','Caloocan City','162','Gcash',0),(11,'18/03/2025 21:04:09','carladln','Ma. Carmela C. De Leon ','09237328381','262 Km. 37 ','Bulacan','Sta. Maria ','Pulong Buhangin ','Gcash',0),(12,'19/03/2025 19:20:08','test','Nicole Arizabal','995901950','Blk E Lot 11 Progressive 6','Cavite','Bacoor','Bayanan','Unionbank',1),(13,'19/03/2025 19:20:08','test','Nicole Arizabal','995901950','Blk E Lot 11 Progressive 6','Cavite','Bacoor','Bayanan','Unionbank',0),(14,'19/03/2025 20:41:09','africakenneth','John Kenneth Africa','09272520193','Ka Wings Unlimited Chicken, Lawa Calamba City Laguna','Laguna','Calamba','Lawa','Gcash',0),(15,'19/03/2025 22:41:54','mlclmchrs','Malcolm Malabanan ','09152858582','51 M.H. del Pilar st., Palatiw, Pasig City ','Metro Manila','Pasig','Palatiw','Gcash',0),(16,'19/03/2025 23:48:11','donavanbautistajr','Donavan Bautista Jr','09171172779','149-K Dr Sixto Antonio Avenue ','Metro Manila','Pasig','Rosario','Gcash',0),(17,'20/03/2025 00:13:34','cjleekwan','CJ Kwan','09175246858','2619 Luxor Condominium, Enrique St., Malate','Metro Manila','Manila','Brgy. 728','Gcash',0);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(155) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,'Clothes Bundle',162,'23065.45',0),(2,'Coat Rack',1,'509',0),(3,'Hanger',10,'251',0),(4,'Phone Tripod',1,'737.92',0),(5,'Waybill printer',1,'2727',0),(6,'Tela',1,'202',0),(7,'Shipping Fee',8,'580',1);
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `miner` varchar(45) DEFAULT NULL,
  `mine_price` varchar(45) DEFAULT NULL,
  `lock_price` varchar(45) DEFAULT NULL,
  `image` varchar(225) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'N001','Black','M','Available',NULL,'249','269','products/yFYD8KTpQ2f2FUpSR56xUbvi99lxaUuxQRB0BcCn.png',0),(2,'N002','Black','M-L','Available',NULL,'249','269','products/bQvkos4VsfYR2l29ZWZMJ3YIJQa45CwkmEgIgUN0.png',0),(3,'N003','Black','M-L','Sold','Nicole','269','289','products/u07egqnB3lpHdmu6bP9A43cWC8K5xVek2g0jcFml.png',0),(4,'N004','Black','M-L','Sold','Nicole','269','289','products/y2t4McsztcximTcMadboSh0yOHz0ONfzbkofRHHZ.png',0),(5,'N005','Black','M-L','Available',NULL,'249','269','products/RrWOuA1PfRCe1JkrYgANShoTaXBmpwGy1sC595qk.png',0),(6,'N006','Black','M-L','Available',NULL,'249','269','products/0VOoCh5o6Vm8Ynbi9AY6faNINGiTBQroxDJhByrt.png',0),(7,'N007','Black','M-L','Available',NULL,'269','289','products/IFbQUi32SVNBddkVz4aqKbo08B0QBm6KL4jLLfHH.png',0),(8,'Test','Black','S','Available',NULL,'0','0',NULL,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(45) DEFAULT NULL,
  `transaction_date` timestamp NULL DEFAULT current_timestamp(),
  `shipping_fee` varchar(45) DEFAULT NULL,
  `total_amount` varchar(45) DEFAULT NULL,
  `total_sales` varchar(45) DEFAULT NULL,
  `order_status` varchar(45) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_products`
--

DROP TABLE IF EXISTS `sales_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` varchar(45) DEFAULT NULL,
  `product_id` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_products`
--

LOCK TABLES `sales_products` WRITE;
/*!40000 ALTER TABLE `sales_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(55) NOT NULL,
  `middlename` varchar(55) DEFAULT NULL,
  `lastname` varchar(55) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(155) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `added_by` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jherom',NULL,'Cruz',1,'ROM','$2y$10$DiFnQMvjS1aipwJ7GfvC.OwVGnM2rpbYotqFcVgVJDuICT6gQcfn2',0,'2025-03-19 02:47:44','2025-03-19 02:47:44','System'),(2,'Nicole',NULL,'Arizabal',1,'nicole','$2y$10$4FyfOx/A156CVfc/4JZcV.bCkJNCSsKCZxgALxa7Kdvu9I83fQhW6',0,'2025-03-18 18:55:42','2025-03-19 02:55:42','ROM');
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

-- Dump completed on 2025-03-20 11:43:03
