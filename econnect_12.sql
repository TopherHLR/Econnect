-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: econnect
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `admin_logs`
--

DROP TABLE IF EXISTS `admin_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_logs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `action_type` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_logs`
--

LOCK TABLES `admin_logs` WRITE;
/*!40000 ALTER TABLE `admin_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `eco_actions`
--

DROP TABLE IF EXISTS `eco_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eco_actions` (
  `action_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `archive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`action_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `eco_actions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eco_actions`
--

LOCK TABLES `eco_actions` WRITE;
/*!40000 ALTER TABLE `eco_actions` DISABLE KEYS */;
INSERT INTO `eco_actions` VALUES (1,'Practice mindful water use','1765238983_image_2025-12-09_080942046.png','Even small changes like shortening your showers or turning off the tap while soaping can save liters every day. Reusing greywater for plants or cleaning helps conserve fresh water where it matters most.','Water & Energy','Action',1,'2025-12-09 00:09:43',0),(2,'The Carbon Footprint of Food','1765239110_image_2025-12-09_081148820.png','Choose more plant-based meals throughout the week. Plant-based foods generally require fewer resources to produce and release fewer greenhouse gases compared to meat. Even swapping one or two meals a week can make a meaningful difference to your carbon footprint.','Food','Action',1,'2025-12-09 00:11:50',0),(3,'Food Waste Data Causes & Impacts','1765239214_image_2025-12-09_081332703.png','Plan meals and store food properly to avoid unnecessary waste. When we reduce what we throw away, we honour the water, land, and energy used to produce our food. Small actions like freezing leftovers or using older ingredients first help keep food out of landfills.','General','Action',1,'2025-12-09 00:13:34',0),(4,'Buy Less and Choose Timeless Fashion.','1765239639_image_2025-12-09_082036563.png','Fast fashion floods the market with cheaply made clothes that are worn only a few times before being discarded. Choosing fewer, durable pieces reduces waste and lowers the environmental impact of clothing production. Your wardrobe decisions can directly help slow down overproduction and resource depletion.','Fasion','Action',1,'2025-12-09 00:20:39',0),(5,'Donate or Repurpose Old Clothes','1765239671_image_2025-12-09_082110009.png','Textile waste is a growing crisis that harms landfills and ecosystems worldwide. Instead of throwing away old clothes, donate them to charities or repurpose them into cleaning rags or DIY projects. Each garment saved keeps harmful waste out of the environment and extends the life of valuable materials.','General','Action',1,'2025-12-09 00:21:11',0),(6,'Wash Clothes Smartly to Reduce Microplastics','1765239845_image_2025-12-09_082403136.png','TITLE\r\nRelease of microplastic fibers from synthetic textiles during household washing\r\n\r\nDESCRIPTION \r\nTextile materials are one of the primary sources of microplastic pollution. The washing procedure is by far the most significant way that textile products release microplastic fibers (MPFs). Therefore, in this study, the effects of various textile raw materials (A acrylic, PA polyamide, PET polyester, RPET recycled polyester and PP polypropylene), fabric construction properties (woven, knitted), thickness and basis weight values on MPFs release at different washing stages (pre-washing, soaping/rinsing) were examined separately. To mimic the most popular home washing procedures, a 10-min pre-wash and a 35-min soaping/rinsing phase at 40 °C were selected for the washing procedure. Utilizing the Image J program on macroscopic images captured by a high-resolution SL. R camera, the microfibers collected by filtering the water have been visually counted. According to the results, knitted fabrics released fewer MPFs than woven fabrics, with the woven acrylic sample (A3-w) exhibiting the highest release (2405 MPFs). The number of MPFs increased along with the thickness and weight of the fabric. Recycled polyester was found to release more MPFs than virgin polyester under the same conditions (1193 MPFs vs. 908 MPFs). This study demonstrates how recycled polyester, although initially an environmentally beneficial solution, can eventually become detrimental to the environment. Furthermore, it is known that the pre-washing procedure—which is optional—releases a lot more MPFs than the soaping and rinsing procedures, and that stopping this procedure will drastically lower the amount of MPFs incorporated into the water.\r\nWash Clothes Smartly to Reduce Microplastics.\r\nSynthetic fabrics release microplastic fibers during washing, which pollute rivers and oceans. Wash clothes less frequently, use lower temperatures, and avoid pre-washing cycles to cut down on microfiber release. Small changes in laundry habits can have a big impact on marine life.','General','Action',1,'2025-12-09 00:24:05',0);
/*!40000 ALTER TABLE `eco_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eco_library`
--

DROP TABLE IF EXISTS `eco_library`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eco_library` (
  `library_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `source_link` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `type` enum('Topic','Action') DEFAULT 'Topic',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `archive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`library_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `eco_library_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eco_library`
--

LOCK TABLES `eco_library` WRITE;
/*!40000 ALTER TABLE `eco_library` DISABLE KEYS */;
INSERT INTO `eco_library` VALUES (1,'Water scarcity','1765238913_image_2025-12-09_080717488.png','Water scarcity limits access to safe water for drinking and for practising basic hygiene at home, in schools and in health-care facilities. When water is scarce, sewage systems can fail and the threat of contracting diseases like cholera surges. Scarce water also becomes more expensive.\r\n\r\nWater scarcity takes a greater toll on women and children because they are often the ones responsible for collecting it. When water is further away, it requires more time to collect, which often means less time at school. Particularly for girls, a shortage of water in schools impacts student enrolment, attendance and performance. Carrying water long distances is also an enormous physical burden and can expose children to safety risks and exploitation.','https://www.unicef.org/wash/water-scarcity','Water & Energy','Topic',1,'2025-12-09 08:08:34',0),(2,'The Carbon Footprint Of Food','1765239060_image_2025-12-09_081056792.png','With the world becoming increasingly aware of the issues presented by climate change, we are all more conscious of how we travel, what we buy, and who we buy from. But are we keeping track of what we eat?\r\n\r\nDid you know that food production is responsible for a quarter of all greenhouse gas emissions? Many different factors affect the carbon footprint of our food, which is why here at Climateq, we think it’s important to explain the carbon journey of your food and how you can make a difference to climate change with your diet.','https://www.climateq.co.uk/resources/the-carbon-footprint-of-food/','Food','Topic',1,'2025-12-09 08:11:00',0),(3,'Environmental Impacts of Food Production','1765239172_image_2025-12-09_081239963.png','TITLE \r\nEnvironmental Impacts of Food Production\r\nDescription \r\nFirst, it requires large amounts of fresh water, which can cause significant environmental pressures in regions with water stress. It needs water as input and pollutes rivers, lakes, and oceans by releasing nutrients.\r\n\r\nIt is a crucial driver of climate change, responsible for around one-quarter of the world’s greenhouse gas emissions.\r\n\r\nFinally, agriculture has a massive impact on the world’s environment due to its enormous land use. Half of the world’s habitable land is used for agriculture.\r\n\r\nLarge parts of the world that were once covered by forests and wildlands are now used for agriculture. This loss of natural habitat has been the main driver for reducing the world’s biodiversity. Wildlife can rebound if we reduce agricultural land use and allow natural lands to be restored.\r\n\r\nEnsuring everyone has access to a nutritious diet sustainably is one of the most significant challenges we face. On this page, you can find our data, visualizations, and writing relating to the environmental impacts of food.\r\nTitle\r\nFood Waste Data—Causes & Impacts\r\nDESCRIPTION\r\nIn line with the United States Environmental Protection Agency (EPA) and the United Nations’ definition, ReFED now defines “food waste” as uneaten food and inedible parts  (e.g., peels, pits, bones) going to the following eight destinations: composting, anaerobic digestion, landfill, combustion, sewer, dumping, spread onto land, or not harvested. It’s a subset of “surplus food”—which ReFED defines as all food that goes unsold or unused by a business or that goes uneaten at home—including food and inedible parts that are donated, fed to animals, repurposed to produce other products, and all of the destinations represented in food waste. Some surplus food is inevitable, but the goal of food waste reduction efforts is not only to get food out of landfills. It’s also to make sure food is going to its “highest and best use”—that is, being eaten by people. This can be seen in guidance provided by the EPA in its Wasted Food Scale. Essentially, all of the resources required to produce, transport, store, and sell a truckload of strawberries have been better used when those strawberries are consumed by people rather than, for example, added to soil as compost—or worse, sent to landfill. The U.S. Government has set a 50% food waste reduction goal that aims to cut the amount of food waste in the retail, food service, and residential sectors in half, in line with United Nations Sustainable Development Goal 12.3.','https://refed.org/food-waste/the-problem/',NULL,'Topic',1,'2025-12-09 08:12:52',0),(4,'What is the difference between global warming and climate change?','1765239307_image_2025-12-09_081504825.png','Although people tend to use these terms interchangeably, global warming is just one aspect of climate change. “Global warming” refers to the rise in global temperatures due mainly to the increasing concentrations of greenhouse gases in the atmosphere. “Climate change” refers to the increasing changes in the measures of climate over a long period of time – including precipitation, temperature, and wind patterns','https://www.usgs.gov/faqs/what-difference-between-global-warming-and-climate-change','Climate Awareness','Topic',1,'2025-12-09 08:15:07',0),(5,'Fast fashion environmental impact','1765239372_image_2025-12-09_081610330.png','The term fast fashion has become more prominent in conversations surrounding fashion, sustainability, and environmental consciousness. The term refers to “cheaply produced and priced garments that copy the latest catwalk styles and get pumped quickly through stores in order to maximise on current trends.”\r\n\r\nThe fast fashion model is so-called because it involves the rapid design, production, distribution, and marketing of clothing. This means that retailers are able to pull large quantities of greater product variety and allow consumers to get more fashion and product differentiation at a low price.','https://earth.org/fast-fashions-detrimental-effect-on-the-environment/','Fashion','Topic',1,'2025-12-09 08:16:12',0),(6,'Textile waste crisis','1765239420_image_2025-12-09_081657677.png','The accumulation of discarded clothing and textiles, driven by overproduction and consumption, which poses a significant threat to environmental health.','https://lifestyle.sustainability-directory.com/term/textile-waste-crisis/',NULL,'Topic',1,'2025-12-09 08:17:00',0);
/*!40000 ALTER TABLE `eco_library` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `feedback_chk_1` CHECK ((`rating` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` VALUES (1,5,'Maganda',5,'2025-12-09 01:00:22'),(2,6,'Nagustuhan ko talaga ‘yung idea ng paggamit ng reusable bag. Simula nang gawin ko ‘to, mas konti na yung plastic waste namin sa bahay.',5,'2025-12-09 01:11:32'),(3,2,'Grabe, ang ganda ng initiative na ‘to! Parang unti-unti ko nang nagiging habit ang pag-off ng ilaw kapag hindi kailangan.',5,'2025-12-09 01:15:41'),(4,3,'Ang saya kasi hindi lang para sa environment ‘yung goal, kundi para sa future generations din. Parang may sense of purpose talaga.',5,'2025-12-09 01:16:32'),(5,4,'Since I started bringing my own tumbler, napansin kong ang dami ko palang naiwasang plastic bottles. Simple habit pero malaking tulong',4,'2025-12-09 01:17:38'),(6,7,'Ang ganda ng concept ng eco-awareness activities. Mas na-appreciate ko ‘yung nature and how small choices make big impacts.',5,'2025-12-09 01:19:22'),(7,8,'Napaka-inspiring ng project na ‘to. Hindi lang siya about saving the environment, kundi about changing mindsets.',5,'2025-12-09 01:21:16'),(8,9,'I started composting at home dahil sa mga eco tips na nakita ko dito. Nakakatuwa kasi nababawasan talaga ang basura namin.',4,'2025-12-09 01:23:22'),(9,10,'What I love about this initiative is how it makes sustainability simple and doable for everyone. Hindi intimidating.',5,'2025-12-09 01:25:18'),(10,11,'I really appreciate how this eco system encourages action, hindi lang puro awareness. May results talaga.',5,'2025-12-09 01:26:35'),(11,12,'cutie po ng system',5,'2025-12-09 08:13:40');
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_10_18_000001_create_sessions_only_table',1),(4,'2025_10_21_141129_add_email_verified_at_to_users_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `from_user_id` int DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `source_table` varchar(100) DEFAULT NULL,
  `source_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_from_user_id` (`from_user_id`),
  KEY `idx_type` (`type`),
  KEY `idx_source` (`source_table`,`source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,2,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!','2025-12-08 22:04:30','2025-12-08 14:04:22'),(2,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Reusable Bottle Day\" has been added. Check it out!',NULL,'2025-12-08 15:12:57'),(3,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Reusable Bottle Day\" has been added. Check it out!',NULL,'2025-12-08 15:12:57'),(4,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Reusable Bottle Day\" has been added. Check it out!',NULL,'2025-12-08 15:12:57'),(5,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Eco Tip Share\" has been added. Check it out!',NULL,'2025-12-08 15:14:10'),(6,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Eco Tip Share\" has been added. Check it out!',NULL,'2025-12-08 15:14:10'),(7,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Eco Tip Share\" has been added. Check it out!',NULL,'2025-12-08 15:14:10'),(8,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Bring-Your-Own Bag Mini Task\" has been added. Check it out!',NULL,'2025-12-08 15:14:59'),(9,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Bring-Your-Own Bag Mini Task\" has been added. Check it out!',NULL,'2025-12-08 15:14:59'),(10,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Bring-Your-Own Bag Mini Task\" has been added. Check it out!',NULL,'2025-12-08 15:14:59'),(11,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Trash-Free Desk Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:15:28'),(12,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Trash-Free Desk Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:15:28'),(13,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Trash-Free Desk Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:15:28'),(14,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Digital Declutter Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:15:56'),(15,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Digital Declutter Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:15:56'),(16,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Digital Declutter Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:15:56'),(17,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Eco Outfit Day\" has been added. Check it out!',NULL,'2025-12-08 15:23:47'),(18,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Eco Outfit Day\" has been added. Check it out!',NULL,'2025-12-08 15:23:47'),(19,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Eco Outfit Day\" has been added. Check it out!',NULL,'2025-12-08 15:23:47'),(20,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Family Recycling Day\" has been added. Check it out!',NULL,'2025-12-08 15:28:42'),(21,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Family Recycling Day\" has been added. Check it out!',NULL,'2025-12-08 15:28:42'),(22,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Family Recycling Day\" has been added. Check it out!',NULL,'2025-12-08 15:28:42'),(23,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Plant Swap Day\" has been added. Check it out!',NULL,'2025-12-08 15:30:23'),(24,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Plant Swap Day\" has been added. Check it out!',NULL,'2025-12-08 15:30:23'),(25,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Plant Swap Day\" has been added. Check it out!',NULL,'2025-12-08 15:30:23'),(26,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"EcoBrew Cup Return Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:31:44'),(27,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"EcoBrew Cup Return Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:31:44'),(28,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"EcoBrew Cup Return Challenge\" has been added. Check it out!',NULL,'2025-12-08 15:31:44'),(29,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"EcoBrew Sustainable Meal Combo\" has been added. Check it out!',NULL,'2025-12-08 15:32:14'),(30,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"EcoBrew Sustainable Meal Combo\" has been added. Check it out!',NULL,'2025-12-08 15:32:14'),(31,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"EcoBrew Sustainable Meal Combo\" has been added. Check it out!',NULL,'2025-12-08 15:32:14'),(32,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew 10% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:39:29'),(33,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew 10% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:39:29'),(34,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew 10% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:39:29'),(35,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew 10% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:39:29'),(36,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Hot Brew\" has been added. Check it out!',NULL,'2025-12-08 15:40:05'),(37,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Hot Brew\" has been added. Check it out!',NULL,'2025-12-08 15:40:05'),(38,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Hot Brew\" has been added. Check it out!',NULL,'2025-12-08 15:40:05'),(39,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Hot Brew\" has been added. Check it out!',NULL,'2025-12-08 15:40:05'),(40,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"20% OFF EcoMerch\" has been added. Check it out!',NULL,'2025-12-08 15:40:35'),(41,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"20% OFF EcoMerch\" has been added. Check it out!',NULL,'2025-12-08 15:40:35'),(42,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"20% OFF EcoMerch\" has been added. Check it out!',NULL,'2025-12-08 15:40:35'),(43,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"20% OFF EcoMerch\" has been added. Check it out!',NULL,'2025-12-08 15:40:35'),(44,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Cold Brew Treat\" has been added. Check it out!',NULL,'2025-12-08 15:44:13'),(45,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Cold Brew Treat\" has been added. Check it out!',NULL,'2025-12-08 15:44:13'),(46,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Cold Brew Treat\" has been added. Check it out!',NULL,'2025-12-08 15:44:13'),(47,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Cold Brew Treat\" has been added. Check it out!',NULL,'2025-12-08 15:44:13'),(48,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"5% Café Purchase Discount\" has been added. Check it out!',NULL,'2025-12-08 15:44:44'),(49,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"5% Café Purchase Discount\" has been added. Check it out!',NULL,'2025-12-08 15:44:44'),(50,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"5% Café Purchase Discount\" has been added. Check it out!',NULL,'2025-12-08 15:44:44'),(51,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"5% Café Purchase Discount\" has been added. Check it out!',NULL,'2025-12-08 15:44:44'),(52,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Pastry and Cookie Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:45:49'),(53,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Pastry and Cookie Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:45:49'),(54,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Pastry and Cookie Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:45:49'),(55,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Pastry and Cookie Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:45:49'),(56,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"15% OFF Purchase\" has been added. Check it out!',NULL,'2025-12-08 15:46:19'),(57,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"15% OFF Purchase\" has been added. Check it out!',NULL,'2025-12-08 15:46:19'),(58,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"15% OFF Purchase\" has been added. Check it out!',NULL,'2025-12-08 15:46:19'),(59,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"15% OFF Purchase\" has been added. Check it out!',NULL,'2025-12-08 15:46:19'),(60,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Espresso-Based\" has been added. Check it out!',NULL,'2025-12-08 15:47:47'),(61,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Espresso-Based\" has been added. Check it out!',NULL,'2025-12-08 15:47:47'),(62,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Espresso-Based\" has been added. Check it out!',NULL,'2025-12-08 15:47:47'),(63,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Espresso-Based\" has been added. Check it out!',NULL,'2025-12-08 15:47:47'),(64,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew Combo Discount\" has been added. Check it out!',NULL,'2025-12-08 15:48:31'),(65,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew Combo Discount\" has been added. Check it out!',NULL,'2025-12-08 15:48:31'),(66,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew Combo Discount\" has been added. Check it out!',NULL,'2025-12-08 15:48:31'),(67,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"EcoBrew Combo Discount\" has been added. Check it out!',NULL,'2025-12-08 15:48:31'),(68,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Refill Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:49:10'),(69,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Refill Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:49:10'),(70,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Refill Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:49:10'),(71,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Refill Coupon\" has been added. Check it out!',NULL,'2025-12-08 15:49:10'),(72,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"25% OFF PASTA-LICIOUS Order\" has been added. Check it out!',NULL,'2025-12-08 15:50:46'),(73,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"25% OFF PASTA-LICIOUS Order\" has been added. Check it out!',NULL,'2025-12-08 15:50:46'),(74,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"25% OFF PASTA-LICIOUS Order\" has been added. Check it out!',NULL,'2025-12-08 15:50:46'),(75,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"25% OFF PASTA-LICIOUS Order\" has been added. Check it out!',NULL,'2025-12-08 15:50:46'),(76,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Signature Drink\" has been added. Check it out!',NULL,'2025-12-08 15:51:16'),(77,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Signature Drink\" has been added. Check it out!',NULL,'2025-12-08 15:51:16'),(78,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Signature Drink\" has been added. Check it out!',NULL,'2025-12-08 15:51:16'),(79,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Free Signature Drink\" has been added. Check it out!',NULL,'2025-12-08 15:51:16'),(80,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"30% OFF Total Bill\" has been added. Check it out!',NULL,'2025-12-08 15:51:49'),(81,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"30% OFF Total Bill\" has been added. Check it out!',NULL,'2025-12-08 15:51:49'),(82,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"30% OFF Total Bill\" has been added. Check it out!',NULL,'2025-12-08 15:51:49'),(83,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"30% OFF Total Bill\" has been added. Check it out!',NULL,'2025-12-08 15:51:49'),(84,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Early Bird 12% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:52:24'),(85,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Early Bird 12% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:52:24'),(86,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Early Bird 12% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:52:24'),(87,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"Early Bird 12% Discount\" has been added. Check it out!',NULL,'2025-12-08 15:52:24'),(88,3,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-08 16:06:12'),(89,4,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-08 16:06:12'),(90,5,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!','2025-12-09 00:22:26','2025-12-08 16:06:12'),(91,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Pick Up One Trash\" has been added. Check it out!',NULL,'2025-12-08 16:46:09'),(92,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Pick Up One Trash\" has been added. Check it out!',NULL,'2025-12-08 16:46:09'),(93,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Pick Up One Trash\" has been added. Check it out!',NULL,'2025-12-08 16:46:09'),(94,5,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Pick Up One Trash\" has been added. Check it out!','2025-12-09 00:46:29','2025-12-08 16:46:09'),(95,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Turn Off Unused Lights\" has been added. Check it out!',NULL,'2025-12-08 16:48:29'),(96,3,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Turn Off Unused Lights\" has been added. Check it out!',NULL,'2025-12-08 16:48:29'),(97,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Turn Off Unused Lights\" has been added. Check it out!',NULL,'2025-12-08 16:48:29'),(98,5,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Turn Off Unused Lights\" has been added. Check it out!','2025-12-09 00:48:42','2025-12-08 16:48:29'),(99,1,5,'quest_accepted',NULL,NULL,'New Quest Accepted','Andrea has accepted a quest. Awaiting submission.',NULL,'2025-12-08 16:48:53'),(100,1,5,'quest_submitted',NULL,NULL,'Quest Submission Pending','Andrea has submitted progress for review.',NULL,'2025-12-08 16:50:30'),(101,5,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'Turn Off Unused Lights\' has been verified. You earned 5 points!',NULL,'2025-12-08 16:51:57'),(102,1,12,'quest_accepted',NULL,NULL,'New Quest Accepted','Allen James has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:22:27'),(103,1,12,'quest_accepted',NULL,NULL,'New Quest Accepted','Allen James has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:22:37'),(104,1,12,'quest_accepted',NULL,NULL,'New Quest Accepted','Allen James has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:22:52'),(105,1,4,'quest_accepted',NULL,NULL,'New Quest Accepted','Egg has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:26:27'),(106,1,4,'quest_submitted',NULL,NULL,'Quest Submission Pending','Egg has submitted progress for review.',NULL,'2025-12-09 00:27:29'),(107,1,4,'quest_accepted',NULL,NULL,'New Quest Accepted','Egg has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:29:27'),(108,1,2,'quest_accepted',NULL,NULL,'New Quest Accepted','Christopher has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:33:44'),(109,1,2,'quest_submitted',NULL,NULL,'Quest Submission Pending','Christopher has submitted progress for review.',NULL,'2025-12-09 00:35:54'),(110,2,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'Trash-Free Desk Challenge\' has been verified. You earned 5 points!',NULL,'2025-12-09 00:36:57'),(111,4,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'Reusable Bottle Day\' has been verified. You earned 5 points!',NULL,'2025-12-09 00:37:13'),(112,1,2,'quest_accepted',NULL,NULL,'New Quest Accepted','Christopher has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:38:04'),(113,1,2,'quest_submitted',NULL,NULL,'Quest Submission Pending','Christopher has submitted progress for review.',NULL,'2025-12-09 00:38:56'),(114,1,2,'quest_accepted',NULL,NULL,'New Quest Accepted','Christopher has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:39:22'),(115,2,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'EcoBrew Cup Return Challenge\' has been verified. You earned 50 points!',NULL,'2025-12-09 00:39:37'),(116,1,2,'quest_accepted',NULL,NULL,'New Quest Accepted','Christopher has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:40:05'),(117,1,2,'quest_submitted',NULL,NULL,'Quest Submission Pending','Christopher has submitted progress for review.',NULL,'2025-12-09 00:40:57'),(118,2,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'Family Recycling Day\' has been verified. You earned 25 points!',NULL,'2025-12-09 00:41:06'),(119,1,2,'quest_accepted',NULL,NULL,'New Quest Accepted','Christopher has accepted a quest. Awaiting submission.',NULL,'2025-12-09 00:42:19'),(120,1,2,'quest_submitted',NULL,NULL,'Quest Submission Pending','Christopher has submitted progress for review.',NULL,'2025-12-09 00:45:14'),(121,2,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'Plastic-Free Lunch Challenge\' has been verified. You earned 15 points!',NULL,'2025-12-09 00:45:47'),(122,2,1,'badge_unlocked',NULL,NULL,'New Badge Unlocked!','Congratulations! You unlocked the \'Eco-Explorer\' badge. Check it in your My Progress page!',NULL,'2025-12-09 00:45:47'),(123,1,14,'quest_accepted',NULL,NULL,'New Quest Accepted','Lee has accepted a quest. Awaiting submission.',NULL,'2025-12-09 01:42:46'),(124,3,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(125,7,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(126,8,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(127,9,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(128,10,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(129,11,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(130,13,5,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"Daily Eco Taps\" has been assigned to you. Complete it within 24 hours!',NULL,'2025-12-12 05:15:36'),(131,2,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"testing\" has been added. Check it out!',NULL,'2025-12-12 06:02:07'),(132,4,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"testing\" has been added. Check it out!',NULL,'2025-12-12 06:02:08'),(133,5,1,'new_quest',NULL,NULL,'New Quest Available!','A new quest \"testing\" has been added. Check it out!',NULL,'2025-12-12 06:02:08'),(134,1,14,'quest_accepted',NULL,NULL,'New Quest Accepted','Lee has accepted a quest. Awaiting submission.',NULL,'2025-12-12 06:08:08'),(135,1,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(136,2,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(137,3,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(138,4,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(139,5,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(140,6,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(141,7,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!','2025-12-12 15:36:06','2025-12-12 06:09:15'),(142,8,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(143,9,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(144,10,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(145,11,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(146,12,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(147,13,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(148,14,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(149,15,1,'new_voucher',NULL,NULL,'New Voucher Available!','A new voucher \"For Cathy\" has been added. Check it out!',NULL,'2025-12-12 06:09:15'),(150,1,14,'quest_submitted',NULL,NULL,'Quest Submission Pending','Lee has submitted progress for review.',NULL,'2025-12-12 06:09:32'),(151,14,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'Eco Outfit Day\' has been verified. You earned 25 points!',NULL,'2025-12-12 06:09:54'),(152,14,1,'badge_unlocked',NULL,NULL,'New Badge Unlocked!','Congratulations! You unlocked the \'Eco-Novice\' badge. Check it in your My Progress page!',NULL,'2025-12-12 06:09:54'),(153,1,14,'voucher_redeem',NULL,NULL,'Voucher Redeemed',' has redeemed a voucher: For Cathy',NULL,'2025-12-12 06:10:16'),(154,14,1,'voucher_update','user_vouchers',1,'Voucher Status Updated','Admin has updated the status of your voucher to used',NULL,'2025-12-12 06:11:51'),(155,1,15,'quest_accepted',NULL,NULL,'New Quest Accepted','Shynne Misfah has accepted a quest. Awaiting submission.',NULL,'2025-12-12 08:03:12'),(156,1,15,'quest_submitted',NULL,NULL,'Quest Submission Pending','Shynne Misfah has submitted progress for review.',NULL,'2025-12-12 08:04:32'),(157,15,1,'quest_verified',NULL,NULL,'Quest Submission Verified','Your submission for \'EcoBrew Cup Return Challenge\' has been verified. You earned 50 points!','2025-12-12 16:48:10','2025-12-12 08:05:50'),(158,1,15,'voucher_redeem',NULL,NULL,'Voucher Redeemed',' has redeemed a voucher: For Cathy',NULL,'2025-12-12 08:14:27'),(159,1,15,'quest_accepted',NULL,NULL,'New Quest Accepted','Shynne Misfah has accepted a quest. Awaiting submission.',NULL,'2025-12-12 08:47:48'),(160,1,15,'quest_accepted',NULL,NULL,'New Quest Accepted','Shynne Misfah has accepted a quest. Awaiting submission.',NULL,'2025-12-12 08:50:09');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `quest_submissions`
--

DROP TABLE IF EXISTS `quest_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quest_submissions` (
  `submission_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `quest_id` int NOT NULL,
  `proof_link` text,
  `qr_verified` tinyint(1) DEFAULT '0',
  `admin_validated` tinyint(1) DEFAULT '0',
  `status` enum('pending','completed','rejected','archived') DEFAULT 'pending',
  `tap_progress` int DEFAULT '0',
  `date_submitted` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_completed` datetime DEFAULT NULL,
  `verified_by` int DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`submission_id`),
  KEY `user_id` (`user_id`),
  KEY `quest_id` (`quest_id`),
  KEY `verified_by` (`verified_by`),
  CONSTRAINT `quest_submissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `quest_submissions_ibfk_2` FOREIGN KEY (`quest_id`) REFERENCES `quests` (`quest_id`) ON DELETE CASCADE,
  CONSTRAINT `quest_submissions_ibfk_3` FOREIGN KEY (`verified_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quest_submissions`
--

LOCK TABLES `quest_submissions` WRITE;
/*!40000 ALTER TABLE `quest_submissions` DISABLE KEYS */;
INSERT INTO `quest_submissions` VALUES (1,2,1,NULL,0,0,'rejected',0,'2025-12-08 22:04:22',NULL,NULL,NULL),(2,3,18,NULL,0,0,'rejected',0,'2025-12-09 00:06:12',NULL,NULL,NULL),(3,4,18,NULL,0,0,'completed',100,'2025-12-09 00:06:12','2025-12-09 08:28:37',NULL,NULL),(4,5,18,NULL,0,0,'completed',100,'2025-12-09 00:06:12','2025-12-09 00:16:44',NULL,NULL),(5,5,20,NULL,0,0,'completed',0,'2025-12-09 00:48:53','2025-12-09 00:50:30',1,'quest_proofs/Mp8nVrGnmQAQBmvUXgfq1w9yTDk3CZHnC5hMSsyE.jpg'),(6,12,2,NULL,0,0,'rejected',0,'2025-12-09 08:22:27',NULL,NULL,NULL),(7,12,5,NULL,0,0,'rejected',0,'2025-12-09 08:22:37',NULL,NULL,NULL),(8,12,3,NULL,0,0,'rejected',0,'2025-12-09 08:22:52',NULL,NULL,NULL),(9,4,2,'https://tasweer.com.pk/collections/tumblers?srsltid=AfmBOoqLwVcATSXg5tdVWeCefnS42I3OudrnNp9QoAVJ0WosdKwSiGSR',0,0,'completed',0,'2025-12-09 08:26:27','2025-12-09 08:27:29',1,'quest_proofs/hasbjrsU7BmswBRgkETAejL6fJVzIkoMuX1vRqe5.png'),(10,4,5,NULL,0,0,'rejected',0,'2025-12-09 08:29:27',NULL,NULL,NULL),(11,2,5,'https://www.facebook.com/share/p/1ZzyNzH4Wq/',0,0,'completed',0,'2025-12-09 08:33:44','2025-12-09 08:35:54',1,'quest_proofs/tlAvrq5TvBE7m5570IXqbuRyX6iK1xE9kYuAqNlH.jpg'),(12,2,18,NULL,0,0,'completed',100,'2025-12-09 08:34:07','2025-12-09 08:36:21',NULL,NULL),(13,2,15,NULL,0,0,'completed',0,'2025-12-09 08:38:04','2025-12-09 08:38:56',1,'quest_proofs/JLZupPfY6dxJnrpASy2dPCNrbBuTTc0YRl4H2bfJ.png'),(14,2,13,NULL,0,0,'pending',0,'2025-12-09 08:39:22',NULL,NULL,NULL),(15,2,10,NULL,0,0,'completed',0,'2025-12-09 08:40:05','2025-12-09 08:40:56',1,'quest_proofs/RgFnNa9sg4Fxvpzq8Z3aMlMiWsaLRjLqHqs3daWn.png'),(16,2,7,'https://www.facebook.com/groups/dieselknucklebusters/posts/1114202130214445/',0,0,'completed',0,'2025-12-09 08:42:19','2025-12-09 08:45:10',1,'quest_proofs/4syLJeznFn92jjAiYtXO7ajh0kY12pVgYLcP3mKx.png'),(17,14,18,NULL,0,0,'rejected',25,'2025-12-09 09:41:25',NULL,NULL,NULL),(18,14,5,NULL,0,0,'rejected',0,'2025-12-09 09:42:46',NULL,NULL,NULL),(19,3,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(20,7,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(21,8,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(22,9,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(23,10,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(24,11,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(25,13,21,NULL,0,0,'pending',0,'2025-12-12 13:15:36',NULL,NULL,NULL),(26,5,21,NULL,0,0,'completed',100,'2025-12-12 13:17:07','2025-12-12 13:18:21',NULL,NULL),(27,14,21,NULL,0,0,'pending',44,'2025-12-12 14:07:02',NULL,NULL,NULL),(28,14,8,'http://192.168.1.22:8000/',0,0,'completed',0,'2025-12-12 14:08:08','2025-12-12 14:09:32',1,'quest_proofs/RtLjnqeK83AmZSlxgOeBNS6bNY1lyxcHvzupByvv.jpg'),(29,15,21,NULL,0,0,'completed',100,'2025-12-12 15:55:27','2025-12-12 15:56:15',NULL,NULL),(30,15,15,NULL,0,0,'completed',0,'2025-12-12 16:03:12','2025-12-12 16:04:32',1,'quest_proofs/vyy3ThbOalvyHpLMPTwSfFaJHccDyAf8XZCgthWo.jpg'),(31,15,8,NULL,0,0,'rejected',0,'2025-12-12 16:47:48',NULL,1,NULL),(32,15,22,NULL,0,0,'pending',0,'2025-12-12 16:50:09',NULL,NULL,NULL);
/*!40000 ALTER TABLE `quest_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quests`
--

DROP TABLE IF EXISTS `quests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quests` (
  `quest_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `points_reward` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','ending_soon','closed','archived') DEFAULT 'active',
  `created_by` int DEFAULT NULL,
  `required_points` int DEFAULT '0',
  PRIMARY KEY (`quest_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `quests_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quests`
--

LOCK TABLES `quests` WRITE;
/*!40000 ALTER TABLE `quests` DISABLE KEYS */;
INSERT INTO `quests` VALUES (1,'Daily Eco Taps','Complete a small eco-taps today! Get 100 Tree taps today.','Small Quest',5,'2025-12-08','2025-12-09','closed',2,0),(2,'Reusable Bottle Day','Use a reusable bottle for the entire day; no plastic bottles allowed. Require a photo of the reusable bottle with caption: “Reusable Bottle Day for ECOnnect.\"','Small Quest',5,'2025-12-09','2025-12-10','closed',1,0),(3,'Eco Tip Share','Share one original eco-tip on social media. Must include hashtag #ECOnnect. Require screenshot of posted eco-tip.','Small Quest',5,'2025-12-09','2025-12-11','closed',1,0),(4,'Bring-Your-Own Bag Mini Task','Use a reusable eco-bag during any purchase. Eco-bag must be visible with purchased item. Require photo proof.','Small Quest',5,'2025-12-09','2025-12-09','closed',1,0),(5,'Trash-Free Desk Challenge','Maintain a trash-free desk for one day; submit before-and-after photos with no single-use trash visible.','Small Quest',5,'2025-12-09','2025-12-11','closed',1,0),(6,'Digital Declutter Challenge','Free at least 500MB of device storage; submit before-and-after screenshots with timestamp and ECOnnect hashtag.','Small Quest',5,'2025-12-09','2025-12-11','closed',1,0),(7,'Plastic-Free Lunch Challenge','Eat lunch using no single-use plastics. Show participant with food and ECOnnect logo/tag.','Medium Quest',15,'2025-12-09','2025-12-16','active',1,10),(8,'Eco Outfit Day','Wear a thrifted, reused, borrowed, or upcycled outfit (70% minimum). Show full outfit with reused items listed.','Medium Quest',25,'2025-12-10','2025-12-17','active',1,0),(9,'Clean Corner Project','Clean a small area and submit before-and-after photos with the participant and an ECOnnect sign.','Medium Quest',25,'2025-12-10','2025-12-13','active',1,10),(10,'Family Recycling Day','Do a household recycling sort with 3 labeled bins and participating family members.','Medium Quest',25,'2025-12-09','2025-12-16','active',1,0),(11,'Paper Reuse Art Project','Create artwork using only reused paper materials; include process and final output.','Big Quest',50,'2025-12-10','2025-12-24','active',1,10),(12,'Green Commute Day','Use sustainable transport for one full day; show departure and arrival proof with route details.','Big Quest',50,'2025-12-09','2025-12-16','active',1,20),(13,'Plant Swap Day','Exchange any plant/seedling with someone else; both participants must post holding the swapped plants with labels.','Big Quest',50,'2025-12-09','2025-12-16','active',1,0),(14,'Green Corner Setup','Create a mini eco-corner with plants and an eco-bin; show before-and-after and 1-week follow-up.','Big Quest',50,'2025-12-11','2025-12-19','active',1,20),(15,'EcoBrew Cup Return Challenge','Buy any drink using EcoBrew’s reusable cup program; return the cup on your next visit and show timestamped proof of both transactions.','Big Quest',50,'2025-12-09','2025-12-30','active',1,0),(16,'EcoBrew Sustainable Meal Combo','Purchase any EcoBrew meal or drink combo labeled “sustainable pick,” and show proof of using no single-use plastics when consuming it.','Big Quest',50,'2025-12-10','2025-12-17','active',1,0),(17,'EcoBrew Loyalty Green Stamp','Buy any EcoBrew drink and get a special “Green Stamp” from ECOnnect; collect 3 stamps (3 different days) and submit all proofs.','Big Quest',50,'2025-12-09','2026-01-09','active',1,10),(18,'Daily Eco Taps','Complete a small eco-taps today! Get 100 Tree taps today.','Small Quest',5,'2025-12-09','2025-12-10','closed',2,0),(19,'Pick Up One Trash','User picks up a single piece of trash and disposes of it properly.','Small Quest',5,'2025-12-09','2025-12-09','closed',1,0),(20,'Turn Off Unused Lights','User switches off lights when leaving a room.','Small Quest',5,'2025-12-09','2025-12-10','closed',1,0),(21,'Daily Eco Taps','Complete a small eco-taps today! Get 100 Tree taps today.','Small Quest',5,'2025-12-12','2025-12-13','active',2,0),(22,'testing','testing','Medium Quest',25,'2025-12-12','2025-12-13','active',1,10);
/*!40000 ALTER TABLE `quests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('10gT26whxTWWkUN1U7bg43Qb2jPxNfXTAwPbstQl',14,'192.168.1.25','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGNoRnVKY1pxVVdCUWVSbzRVNzNLTHNFeE13Tmg5Z3FKajhlOGk0NCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xOTIuMTY4LjEuMjI6ODAwMC93aWRnZXRzL3JhbmRvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE0O30=',1765522688),('FIiL4DjKdEbwfon8rujw7T71kSu6w4cDZkl2rnYz',NULL,'192.168.1.27','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic2RDSzJDV0lkMEJORHdyWHFoYVhIRUhtOXcyT0tERnZ6TEEzaXpHZSI7czo3OiJzdWNjZXNzIjtzOjI1OiJZb3UgaGF2ZSBiZWVuIGxvZ2dlZCBvdXQuIjtzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MTp7aTowO3M6Nzoic3VjY2VzcyI7fX19',1765522503),('Fiz5Dpizl720EwpWGvYmMQLkS32IjYXJqJlN1bDt',1,'192.168.1.22','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicFJxcnZnZFNLWFpSeHBGOWhBM2phN291b1luVm92OWxOUFZJbzRPTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjEuMjI6ODAwMC9hZG1pblJld2FyZHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1765520836),('fo9qcUVs7gEH15OPEsP22nrr9sH8AgSNhqcCH3a5',7,'192.168.1.26','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiczFST1JPcUdYM1Y0RkNsTmU5QUJDVW9rVHdaSkdjZWo4SGg4c2hTVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xOTIuMTY4LjEuMjI6ODAwMC9yZXdhcmRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9',1765524966),('L2dO8dh4n9L9UjI6OGpoFbh7Wm76hp4kIS250fwZ',16,'192.168.1.25','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWk5UeVdETzRxRVhxQzVSYnAzMDg3Wm04d0llbkJiUGsxakNCdDVKSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xOTIuMTY4LjEuMjI6ODAwMC9yZXdhcmRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTY7fQ==',1765526767),('RdZplMqZf2h7yVOFaAswHe6ByDELKytXuHcONDCU',1,'192.168.1.27','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXZEMnlkdHJXM2t6V1lScjFuTlVVVWRXSHdmbjEzUkN1VUZsSnZrZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xOTIuMTY4LjEuMjI6ODAwMC9hZG1pbkFuYWx5dGljcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1765529750),('rSvtMsgMyIDEG337Bq1cxiXPVd4ItNFxF7V5aG0I',1,'192.168.1.26','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0R4aURSQlRkU2diZnhDSm44M1ppelVsZzB0NUZudlM1S0lWaG1tVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xOTIuMTY4LjEuMjI6ODAwMC9hZG1pbkhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1765526812);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_eco_actions`
--

DROP TABLE IF EXISTS `user_eco_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_eco_actions` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `action_id` int NOT NULL,
  `log_date` date NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  KEY `action_id` (`action_id`),
  CONSTRAINT `user_eco_actions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `user_eco_actions_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `eco_actions` (`action_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_eco_actions`
--

LOCK TABLES `user_eco_actions` WRITE;
/*!40000 ALTER TABLE `user_eco_actions` DISABLE KEYS */;
INSERT INTO `user_eco_actions` VALUES (1,2,4,'2025-12-09'),(2,2,6,'2025-12-09'),(3,14,6,'2025-12-09'),(4,15,4,'2025-12-12');
/*!40000 ALTER TABLE `user_eco_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_libraries`
--

DROP TABLE IF EXISTS `user_libraries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_libraries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `library_id` bigint unsigned NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_libraries`
--

LOCK TABLES `user_libraries` WRITE;
/*!40000 ALTER TABLE `user_libraries` DISABLE KEYS */;
INSERT INTO `user_libraries` VALUES (1,2,6,'2025-12-09 00:24:30'),(2,2,5,'2025-12-09 00:24:35'),(3,2,4,'2025-12-09 00:24:38'),(4,14,6,'2025-12-09 01:33:06'),(6,15,6,'2025-12-12 07:27:30'),(7,15,5,'2025-12-12 07:27:32');
/*!40000 ALTER TABLE `user_libraries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_points_history`
--

DROP TABLE IF EXISTS `user_points_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_points_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `activity_type` enum('Tree Tap','Eco Action','Quest','Voucher Redemption','Invalid Streak Bonus','Admin Adjustment') DEFAULT 'Tree Tap',
  `source_id` int DEFAULT NULL,
  `points_change` int NOT NULL,
  `voided` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_points_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_points_history`
--

LOCK TABLES `user_points_history` WRITE;
/*!40000 ALTER TABLE `user_points_history` DISABLE KEYS */;
INSERT INTO `user_points_history` VALUES (1,5,'Tree Tap',NULL,5,0,'2025-12-09 00:16:44'),(2,5,'Quest',5,5,0,'2025-12-09 00:51:57'),(3,4,'Tree Tap',NULL,5,0,'2025-12-09 08:28:37'),(4,2,'Tree Tap',NULL,5,0,'2025-12-09 08:36:21'),(5,2,'Quest',11,5,0,'2025-12-09 08:36:57'),(6,4,'Quest',9,5,0,'2025-12-09 08:37:13'),(7,2,'Quest',13,50,0,'2025-12-09 08:39:37'),(8,2,'Quest',15,25,0,'2025-12-09 08:41:06'),(9,2,'Quest',16,15,0,'2025-12-09 08:45:47'),(10,5,'Tree Tap',NULL,5,0,'2025-12-12 13:18:21'),(11,14,'Quest',28,25,0,'2025-12-12 14:09:54'),(12,14,'Voucher Redemption',15,-1,0,'2025-12-12 14:10:16'),(13,15,'Tree Tap',NULL,5,0,'2025-12-12 15:56:15'),(14,15,'Quest',30,50,0,'2025-12-12 16:05:50'),(15,15,'Voucher Redemption',15,-1,0,'2025-12-12 16:14:27');
/*!40000 ALTER TABLE `user_points_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `user_summary`
--

DROP TABLE IF EXISTS `user_summary`;
/*!50001 DROP VIEW IF EXISTS `user_summary`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `user_summary` AS SELECT 
 1 AS `user_id`,
 1 AS `first_name`,
 1 AS `last_name`,
 1 AS `total_points`,
 1 AS `completed_quests`,
 1 AS `total_actions`,
 1 AS `redeemed_vouchers`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_vouchers`
--

DROP TABLE IF EXISTS `user_vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_vouchers` (
  `redemption_id` int NOT NULL AUTO_INCREMENT,
  `redeem_points_cost` int DEFAULT '0',
  `user_id` int NOT NULL,
  `voucher_id` int NOT NULL,
  `voucher_code` varchar(100) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `redeemed_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','used','expired') DEFAULT 'active',
  PRIMARY KEY (`redemption_id`),
  UNIQUE KEY `voucher_code` (`voucher_code`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `user_id` (`user_id`),
  KEY `voucher_id` (`voucher_id`),
  CONSTRAINT `user_vouchers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `user_vouchers_ibfk_2` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`voucher_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_vouchers`
--

LOCK TABLES `user_vouchers` WRITE;
/*!40000 ALTER TABLE `user_vouchers` DISABLE KEYS */;
INSERT INTO `user_vouchers` VALUES (1,1,14,15,'LY2I4OYXSB','IOT9EFCDTJ','2025-12-12 14:10:16','used'),(2,1,15,15,'0DNA2CFJEV','ZXCU3EHSWM','2025-12-12 16:14:27','active');
/*!40000 ALTER TABLE `user_vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `user_type` enum('guest','verified_user','admin','seller') DEFAULT 'guest',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_verified` tinyint(1) DEFAULT '0',
  `total_points` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `qr_code` (`qr_code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'8ugged.0ut@gmail.com','2025-11-24 23:47:50','$2y$12$UH7N3BksVtH1AXM27i6U0uLeSLdw8iU04yjuQORQh.5pM8QQOcqXm',NULL,'admin',1,1,0,'2025-11-24 23:47:50','2025-11-24 23:47:50','Admin','','Account'),(2,'cthilairon@gmail.com',NULL,'$2y$12$AHh0wBMb6jVmqzF5j1wdKOTo2ZiWODe0IDCPm0raa6f2x/s0Ntyhe','USER-2-DR6UNZXB2S','verified_user',1,1,0,'2025-12-08 22:04:22','2025-12-08 22:15:58','Christopher','Cordez','Hilairon'),(3,'akivanique@gmail.com',NULL,'$2y$12$0rse.e1BbZ4TXdi07ttWZuAgqnUxiTbJ5OqDqN7OG5dFiC672q3wu','USER-3-JEU3EWT8CF','guest',1,1,0,'2025-12-08 22:27:04','2025-12-08 22:27:04','Alleny','Perez','Hernandez'),(4,'eggstein69@gmail.com',NULL,'$2y$12$KbGNNgzcEzoHSM1vGavBHOm/PjkPRF3DhuC5XhxLJzwK7FwLf1NDy','USER-4-JAUPCIHMBK','verified_user',1,1,0,'2025-12-08 22:29:38','2025-12-09 08:26:19','Egg',NULL,'Stein'),(5,'andreajanel20@gmail.com',NULL,'$2y$12$9c1uWlbhSPbqUXN6nzXHBOKK7aFFeolw0mII7W2YLPnPL.Y.nQFmG','USER-5-O0ILXN0MPN','verified_user',1,1,0,'2025-12-09 00:06:11','2025-12-09 00:12:20','Andrea',NULL,'Ricalde'),(6,'ricalde.an@gmail.com',NULL,'$2y$12$XHwsE6uU8pp0/NIEO0e8eebPPeODlX1gfLaZ0bc5NZGpEUxDY6IPa','USER-6-RDBQNXZA8I','verified_user',1,1,0,'2025-12-09 01:11:05','2025-12-09 01:13:24','Deya',NULL,'Ricalde'),(7,'kaytlynfaorie@gmail.com',NULL,'$2y$12$kCpOK8JbDJBNviDJ0SRhXun7vxIzh/1dHTKNyDAgtvDCzqH.1J.PW','USER-7-CAK2HQMA4P','guest',1,1,0,'2025-12-09 01:19:05','2025-12-09 01:19:05','Kaytlyn',NULL,'Faorie'),(8,'chitogenoelle@gmail.com',NULL,'$2y$12$Vexf7oDqFio04E1ew9rnI.Gtd7mM5ZYzRObsWcxvw/PKfMNa3LEMi','USER-8-SJFPK2OGRW','guest',1,1,0,'2025-12-09 01:20:58','2025-12-09 01:20:58','Chito',NULL,'Noelle'),(9,'assocphoto02@gmail.com',NULL,'$2y$12$boLleBVD1JOR68f6gnFOy.7KpEhNbicDupV94nBp1j8QMGS3.eHkm','USER-9-HGANV1WWVU','guest',1,1,0,'2025-12-09 01:23:08','2025-12-09 01:23:08','Steve',NULL,'Harrington'),(10,'trsrx080720@gmail.com',NULL,'$2y$12$KHMQpg8Q2jG1BiG2346s2OjHLGJII3Qtto1M.eCC3wWfWJXL/GUbm','USER-10-C6HUI7L6SA','guest',1,1,0,'2025-12-09 01:25:04','2025-12-09 01:25:04','Joy',NULL,'Mendoza'),(11,'kimteume080720@gmail.com',NULL,'$2y$12$pehiLU73ygSKSYg1cjTut.VGnoJD6xCG4trDsuFgdm67p7ZeeUqka','USER-11-RT8XGNXBVY','guest',1,1,0,'2025-12-09 01:26:21','2025-12-09 01:26:21','Czine',NULL,'Cereban'),(12,'silangallenjames@gmail.com',NULL,'$2y$12$NFENhP.Be6qzy/J2fdvjveadyDIMo7Nc4vponyDCYqdyRxO.qE5Na','USER-12-IQUZ1HDJVN','verified_user',1,1,0,'2025-12-09 08:06:42','2025-12-09 08:18:38','Allen James','M.','Silang'),(13,'raphcasabal@gmail.com',NULL,'$2y$12$4fpfni3udA6In.mXWdLmt.Eo2gZbD96RDZ01sbGo5fMOaxgOfPQ7G','USER-13-NXZO7NVP41','guest',1,1,0,'2025-12-09 09:20:08','2025-12-09 09:20:08','Ains',NULL,'Pisano'),(14,'cgg8981@gmail.com',NULL,'$2y$12$O8vVopidU8np7UbvmF13/unfcx8vATllksqjXiPUykzv/MZet8laO','USER-14-HVAEYFS2SB','verified_user',1,1,0,'2025-12-09 09:32:18','2025-12-12 14:34:07','Lee',NULL,'Casabal'),(15,'sunshineanna820@gmail.com',NULL,'$2y$12$7h.7fLpOOf4ZySeBUTC5DuzZ.2tPZtQ.N7/Y4Vwd38RD5u1.kqDom','USER-15-WDDRETRDZD','verified_user',1,1,0,'2025-12-12 14:00:09','2025-12-12 15:54:38','Shynne Misfah','Lacay','Aranda'),(16,'hanygruezo@gmail.com',NULL,'$2y$12$/ebRCRom8sX3w/raJK/8tON40s9fCLz2qkEOt3CWhE64ToeZWzH5e','USER-16-T6S4F07YVE','guest',1,1,0,'2025-12-12 15:17:33','2025-12-12 15:17:33','Cat',NULL,'Gruzo');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vouchers` (
  `voucher_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text,
  `required_points` int NOT NULL,
  `discount_value` varchar(50) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`voucher_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `vouchers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vouchers`
--

LOCK TABLES `vouchers` WRITE;
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
INSERT INTO `vouchers` VALUES (1,'EcoBrew 10% Discount','Gives the user a ten percent discount on any single café purchase.',150,'10','2026-03-30',1,1),(2,'Free EcoBrew Blend','Allows the user to redeem one ecobrew blend.',300,'100','2026-04-15',1,1),(3,'20% OFF PASTA-IN-A-TRAY','Provides a twenty percent discount on any Pasta-In-a-Tray food menu.',450,'20','2026-05-01',1,1),(4,'Cold Brew Treat','Redeem one free cold brew (100% off).',350,'100','2026-04-10',1,1),(5,'5% Café Purchase Discount','ffers a five percent discount on a single café transaction.',80,'5','2026-03-20',1,1),(6,'Free Pastry and Cookie Coupon','Redeem one free pastry and cookie item of choice.',280,'100','2026-04-05',1,1),(7,'15% OFF Purchase','Grants a fifteen percent discount on any solo beverage order.',180,'15','2026-05-15',1,1),(8,'Free Espresso-Based','Redeem one Espresso-Based completely free.',320,'100','2026-04-20',1,1),(9,'EcoBrew Combo Discount','Provides a ten percent discount on a drink-plus-pastry combo.',200,'10','2026-06-10',1,1),(10,'Free Refill Coupon','Lets the user redeem one free refill on any brewed coffee.',120,'100','2026-03-28',1,1),(11,'25% OFF PASTA-LICIOUS Order','Gives twenty-five percent off on any one pasta-licious menu.',300,'25','2026-06-20',1,1),(12,'Free Signature Drink','Redeem any signature drink of choice for free.',400,'100','2026-05-31',1,1),(13,'30% OFF Total Bill','Provides thirty percent discount on one full transaction.',650,'30','2026-07-08',1,1),(14,'Early Bird 12% Discount','Grants a twelve percent discount for purchases made before 12 PM.',160,'10','2025-12-31',0,1),(15,'For Cathy','Claim this!',1,'100','2025-12-13',1,1);
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `user_summary`
--

/*!50001 DROP VIEW IF EXISTS `user_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `user_summary` AS select `u`.`user_id` AS `user_id`,`u`.`first_name` AS `first_name`,`u`.`last_name` AS `last_name`,`u`.`total_points` AS `total_points`,count(distinct `uq`.`quest_id`) AS `completed_quests`,count(distinct `ua`.`action_id`) AS `total_actions`,count(distinct `uv`.`voucher_id`) AS `redeemed_vouchers` from (((`users` `u` left join `user_eco_actions` `ua` on((`u`.`user_id` = `ua`.`user_id`))) left join `quest_submissions` `uq` on(((`u`.`user_id` = `uq`.`user_id`) and (`uq`.`status` = 'completed')))) left join `user_vouchers` `uv` on((`u`.`user_id` = `uv`.`user_id`))) group by `u`.`user_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-15 20:17:31
