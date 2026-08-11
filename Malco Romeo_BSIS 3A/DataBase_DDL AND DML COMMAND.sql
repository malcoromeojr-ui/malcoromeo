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


-- Dumping database structure for bsis3a
CREATE DATABASE IF NOT EXISTS `bsis3a` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bsis3a`;

-- Dumping structure for table bsis3a.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` int NOT NULL,
  `CourseID` varchar(50) DEFAULT NULL,
  `CourseName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.course: ~6 rows (approximately)
INSERT INTO `course` (`id`, `CourseID`, `CourseName`) VALUES
	(101, 'Dep105', 'BSIS'),
	(102, 'Dep104', 'BSED'),
	(103, 'Dep103', 'BEED'),
	(104, 'Dep101', 'BPED'),
	(105, 'Dep105', 'BSIS'),
	(106, 'Dep106', 'ACT');

-- Dumping structure for table bsis3a.section
CREATE TABLE IF NOT EXISTS `section` (
  `id` int NOT NULL,
  `SectionID` varchar(50) DEFAULT NULL,
  `SectionName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.section: ~3 rows (approximately)
INSERT INTO `section` (`id`, `SectionID`, `SectionName`) VALUES
	(101, 'Sec04', 'BSIS-3A'),
	(102, 'Sec01', 'BSIS-3B'),
	(103, 'Sec04', 'BSED-2A');

-- Dumping structure for table bsis3a.students
CREATE TABLE IF NOT EXISTS `students` (
  `StudentID` int NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Course` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bsis3a.students: ~5 rows (approximately)
INSERT INTO `students` (`StudentID`, `FirstName`, `LastName`, `Course`) VALUES
	(101, 'romeo', 'malco', 'BSIS 3A'),
	(102, 'Elisa ', 'barra ', 'BSIS-3B'),
	(103, 'hazel', 'saluya', 'BSED-3A'),
	(105, 'michael', 'Brondial', 'ACT-3A'),
	(106, 'cla', 'Ciron', 'BSIS 3A');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
