-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: bpjs
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.17-MariaDB

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
-- Table structure for table `bpjs_participants`
--

DROP TABLE IF EXISTS `bpjs_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bpjs_participants` (
  `nik` varchar(16) NOT NULL,
  `kpj` varchar(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` bigint(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`nik`),
  UNIQUE KEY `bpjs_participants_unique_1` (`kpj`),
  UNIQUE KEY `bpjs_participants_unique_2` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bpjs_participants`
--

LOCK TABLES `bpjs_participants` WRITE;
/*!40000 ALTER TABLE `bpjs_participants` DISABLE KEYS */;
INSERT INTO `bpjs_participants` VALUES ('1111111111111111','66666666666','Helmy Fikri','Husein',89630467896,'helmyfikrih@gmail.com','2024-12-09','Jakarta','Jl. Kayu Manis III RT 06/02 No.41 Pondok Cabe Udik'),('1234567891236567','78965412369','Helmi','Husein',89630467896,'asasas@gmail.com','2024-12-03','pandeglang','Jl. Kayu Manis III'),('7777777777777777','44444444444','helmy fikri','husein',9872837287382,'','2024-12-11','pandeglang','pandeglang'),('8989898989898989','55555555555','Helmy Fikri','Husein',89630467896,'helmyfikrih2@gmail.com','2024-12-11','Jakarta','Jl. Kayu Manis III RT 06/02 No.41 Pondok Cabe Udik');
/*!40000 ALTER TABLE `bpjs_participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('0ad886d4-e067-4ccf-9363-42336da404b5','test123','$2y$10$QNJFnU95YGdNxYHt73tUqukRp8xawLyFvfi8IRblV.zxCSiHD2A4O','2024-12-10 10:07:38'),('7dbd5e8b-5769-4623-b3ca-58e3aa3235e2','test12346','$2y$10$3MZdHRP72ARzeGxnkcjnV.4aewNcuWIyyoYCw1MzeiLBYz8LqilIG','2024-12-11 12:40:27'),('b0e0995f-7ef5-4037-b9ed-45d003e73a0c','test12345','$2y$10$c2T14872UNba7dn48s7SleMltnZamgZXO93LeG5m7vW5NjpFGoacS','2024-12-11 12:38:20'),('f4106b21-02f4-4ba6-b330-880435c0510f','test1234','$2y$10$9FD.1Chm24FzGEmtv5Wh2euygNp4rWNjVZOX8OXqjnyt4LrPgF4YK','2024-12-10 10:08:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'bpjs'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-12 13:27:39
