-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.46 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for studentinformationbsis 3a
CREATE DATABASE IF NOT EXISTS `studentinformationbsis 3a` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `studentinformationbsis 3a`;

-- Dumping structure for table studentinformationbsis 3a.student_performance
CREATE TABLE IF NOT EXISTS `student_performance` (
  `performance_id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(10) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `grade` decimal(3,2) DEFAULT NULL,
  PRIMARY KEY (`performance_id`),
  KEY `student_id` (`student_id`),
  KEY `subject_name` (`subject_name`),
  CONSTRAINT `student_performance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  CONSTRAINT `student_performance_ibfk_2` FOREIGN KEY (`subject_name`) REFERENCES `subjects` (`subject_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table studentinformationbsis 3a.student_performance: ~4 rows (approximately)
INSERT INTO `student_performance` (`performance_id`, `student_id`, `subject_name`, `grade`) VALUES
	(1, 'S10', 'Web Dev', 1.25),
	(2, 'S10', 'PHP/MySQL', 1.50),
	(3, 'S11', 'Web Dev', 2.00),
	(4, 'S11', 'Networking', 1.75);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
