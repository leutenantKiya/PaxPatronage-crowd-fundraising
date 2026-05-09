
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*!40000 DROP DATABASE IF EXISTS `paxpatronage`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `paxpatronage` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `paxpatronage`;
DROP TABLE IF EXISTS `donasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `donasi` (
  `id_donasi` int(11) NOT NULL AUTO_INCREMENT,
  `kampanye_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name_hidden` tinyint(1) NOT NULL DEFAULT 0,
  `amount` decimal(15,2) NOT NULL,
  `metode_bayar` varchar(255) NOT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `bukti` varchar(255) NOT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_donasi`),
  KEY `kampanye_id` (`kampanye_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `donasi_ibfk_1` FOREIGN KEY (`kampanye_id`) REFERENCES `kampanye` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `donasi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `donasi_chk_amount` CHECK (`amount` >= 10000)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `donasi` WRITE;
/*!40000 ALTER TABLE `donasi` DISABLE KEYS */;
INSERT INTO `donasi` VALUES (1,3,2,0,10000.00,'Transfer Bank BCA','Semoga cepat sembuh!','uploads/bukti/donasi_seed.png','verified','2026-05-08 22:44:21'),(2,3,2,0,50000.00,'Transfer Bank BCA','Tetap semangat!','uploads/bukti/pending_001.png','verified','2026-05-08 22:45:36'),(3,3,2,1,100000.00,'DANA',NULL,'uploads/bukti/pending_002.png','pending','2026-05-08 22:45:36'),(4,2,2,0,25000.00,'OVO','Buat yang butuh','uploads/bukti/pending_003.png','rejected','2026-05-08 22:45:36'),(5,2,2,1,250000.00,'Transfer Bank Mandiri','Semoga bermanfaat','uploads/bukti/pending_004.png','pending','2026-05-08 22:45:36');
/*!40000 ALTER TABLE `donasi` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `kampanye`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kampanye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kampanye` varchar(255) NOT NULL,
  `jenis_kampanye` varchar(100) NOT NULL,
  `target_kampanye` decimal(15,2) NOT NULL,
  `tanggal_dimulai` datetime NOT NULL,
  `tanggal_berakhir` datetime NOT NULL,
  `deskripsi` text NOT NULL,
  `alamat_jalan` varchar(255) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `path_gambar` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dana_terkumpul` decimal(15,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `kampanye_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `kampanye` WRITE;
/*!40000 ALTER TABLE `kampanye` DISABLE KEYS */;
INSERT INTO `kampanye` VALUES (2,'Sedekah makan mewah kiya','Sedekah',1000000000.00,'2026-05-07 00:00:00','2026-05-30 00:00:00','Sedekah memberi Kiya secuil Ikan King Salmon untuk sarapan','Jl. Dr. Wahidin Sudirohusodo No. 5-25','Yogyakarta','DI Yogyakarta','img-kampanye/kampanye_1_2026-05-09_06-20-07.png',1,0.00),(3,'Biaya Perawatan USS Geral F. Ford','Perawatan',1000000.00,'2026-05-15 00:00:00','2026-05-31 00:00:00','Perawatan kapal perang','Jl. Dr. Wahidin Sudirohusodo No. 5-25','Yogyakarta','DI Yogyakarta','img-kampanye/kampanye_1_2026-05-06_23-26-08.png',1,60000.00);
/*!40000 ALTER TABLE `kampanye` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `user_type` tinyint(1) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'anton@gmail.com','123','Antonius Kiya','08386854493',0,''),(2,'user@gmail.com','123','user','08386854493',1,'Jalan Damai No.1 - 10000');
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

