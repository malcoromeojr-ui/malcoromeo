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


-- Dumping database structure for byisp_db
CREATE DATABASE IF NOT EXISTS `byisp_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `byisp_db`;

-- Dumping structure for table byisp_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table byisp_db.roles: ~2 rows (approximately)
INSERT INTO `roles` (`role_id`, `role_name`) VALUES
	(1, 'Admin'),
	(2, 'Youth_User');

-- Dumping structure for table byisp_db.service_categories
CREATE TABLE IF NOT EXISTS `service_categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table byisp_db.service_categories: ~3 rows (approximately)
INSERT INTO `service_categories` (`category_id`, `category_name`, `description`) VALUES
	(1, 'Educational Assistance', 'Scholarships, school supplies, and student aid.'),
	(2, 'Sports & Recreation', 'Tournament registrations and sports equipment requests.'),
	(3, 'Certificate of Youth Residency', 'Barangay clearance/certificate for youth applicants.');

-- Dumping structure for table byisp_db.service_requests
CREATE TABLE IF NOT EXISTS `service_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `category_id` int NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `requested_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`request_id`),
  KEY `profile_id` (`profile_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `youth_profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `service_requests_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`category_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table byisp_db.service_requests: ~5 rows (approximately)
INSERT INTO `service_requests` (`request_id`, `profile_id`, `category_id`, `purpose`, `status`, `requested_at`) VALUES
	(1, 2, 1, 'Application for College Financial Assistance Program', 'Pending', '2026-10-10 17:03:36'),
	(2, 2, 3, 'Requirement for Summer Internship Application', 'Approved', '2026-10-10 17:03:36'),
	(3, 3, 1, 'Book Allowance and School Supplies Assistance', 'Approved', '2026-10-11 09:15:00'),
	(4, 4, 2, 'Barangay Inter-Purok Basketball League Registration', 'Approved', '2026-10-11 10:30:00'),
	(5, 5, 3, 'Certificate of Youth Residency for Scholarship Application', 'Pending', '2026-10-12 08:00:00');

-- Dumping structure for table byisp_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table byisp_db.users: ~5 rows (approximately)
INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `created_at`) VALUES
	(1, 'admin_sk', 'Password123!', 1, '2026-10-10 17:03:35'),
	(2, 'juan_delacruz', 'Password123!', 2, '2026-10-10 17:03:35'),
	(3, 'maria_santos', 'Password123!', 2, '2026-10-10 17:03:35'),
	(4, 'carlos_reyes', 'Password123!', 2, '2026-10-10 17:03:35'),
	(5, 'ana_gomez', 'Password123!', 2, '2026-10-10 17:03:35');

-- Dumping structure for table byisp_db.youth_profiles
CREATE TABLE IF NOT EXISTS `youth_profiles` (
  `profile_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `purok` varchar(50) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `educational_status` varchar(50) NOT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `youth_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table byisp_db.youth_profiles: ~5 rows (approximately)
INSERT INTO `youth_profiles` (`profile_id`, `user_id`, `first_name`, `last_name`, `birthdate`, `gender`, `purok`, `contact_number`, `educational_status`) VALUES
	(1, 1, 'SK', 'Chairperson', '2001-01-15', 'Female', 'Purok 1', '09123456789', 'Graduated'),
	(2, 2, 'Juan', 'Dela Cruz', '2005-06-20', 'Male', 'Purok 3', '09987654321', 'Enrolled'),
	(3, 3, 'Maria', 'Santos', '2004-11-05', 'Female', 'Purok 2', '09198765432', 'Enrolled'),
	(4, 4, 'Carlos', 'Reyes', '2003-03-12', 'Male', 'Purok 4', '09223344556', 'Enrolled'),
	(5, 5, 'Ana', 'Gomez', '2006-08-25', 'Female', 'Purok 5', '09334455667', 'Enrolled');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
