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

-- Dumping structure for table studentinformationbsis 3a.students
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` varchar(10) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `home_address` varchar(100) NOT NULL,
  `zip_code` int DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  KEY `zip_code` (`zip_code`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`zip_code`) REFERENCES `branches` (`zip_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table studentinformationbsis 3a.students: ~2 rows (approximately)
INSERT INTO `students` (`student_id`, `student_name`, `home_address`, `zip_code`) VALUES
	('S10', 'Alice Reyes', 'Baao', 4432),
	('S11', 'Bob Miller', 'Iriga', 4431);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
