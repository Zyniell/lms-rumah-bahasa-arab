-- Database Schema for Rumah Bahasa Arab (RBA) LMS
-- Framework: CodeIgniter 3.1.13 + MySQL 8.0+

CREATE DATABASE IF NOT EXISTS `lms_rumah_bahasa_arab` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lms_rumah_bahasa_arab`;

-- 1. Table: users
DROP TABLE IF EXISTS `lesson_progress`;
DROP TABLE IF EXISTS `enrollments`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `lessons`;
DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'student') NOT NULL DEFAULT 'student',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table: courses
CREATE TABLE `courses` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `thumbnail` VARCHAR(255) NULL,
  `type` ENUM('free', 'paid') NOT NULL DEFAULT 'free',
  `price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('published', 'draft') NOT NULL DEFAULT 'published',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table: lessons
CREATE TABLE `lessons` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `youtube_url` VARCHAR(255) NOT NULL,
  `youtube_video_id` VARCHAR(50) NOT NULL,
  `order_num` INT NOT NULL DEFAULT 1,
  `description` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_lessons_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Table: transactions
CREATE TABLE `transactions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `transaction_code` VARCHAR(50) NOT NULL UNIQUE,
  `user_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `payment_proof` VARCHAR(255) NULL,
  `payment_notes` TEXT NULL,
  `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` TEXT NULL,
  `approved_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_transactions_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Table: enrollments
CREATE TABLE `enrollments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  `enrolled_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('active', 'revoked') NOT NULL DEFAULT 'active',
  UNIQUE KEY `uq_user_course` (`user_id`, `course_id`),
  CONSTRAINT `fk_enrollments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_enrollments_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Table: lesson_progress
CREATE TABLE `lesson_progress` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  `lesson_id` INT UNSIGNED NOT NULL,
  `completed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_user_lesson` (`user_id`, `lesson_id`),
  CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_progress_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_progress_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Data: Initial Users (Admin & Student)
-- Password Admin: admin123
-- Password Santri: santri123
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin Rumah Bahasa Arab', 'admin@rumahbahasaarab.com', '$2y$10$j91.Kfk5jSX3B0s8bWLC8OsTquyc4urvs7NKbT2yY7eNti1kWc2cC', 'admin', NOW()),
(2, 'Ahmad Santri', 'santri@rumahbahasaarab.com', '$2y$10$h580tMxWw43bTtS/02LRPO8QZ2YWhbBDLDx1y38PiVRSb/YEdyn.e', 'student', NOW());

-- Seed Data: Courses (1 Free, 1 Paid)
INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `type`, `price`, `status`, `created_at`) VALUES
(1, 'Dasar-Dasar Nahwu & Shorof untuk Pemula', 'dasar-dasar-nahwu-shorof-pemula', 'Panduan pengenalan tata bahasa Arab (Nahwu dan Shorof) dari tingkat dasar. Memahami pembagian kata (Isim, Fi\'il, Huruf), tanda-tanda i\'rob dasar, dan struktur kalimat sederhana bahasa Arab.', 'nahwu_pemula.jpg', 'free', 0.00, 'published', NOW()),
(2, 'Percakapan Bahasa Arab Sehari-hari (Al-Muhadatsah Al-Yaumiyyah)', 'percakapan-bahasa-arab-sehari-hari', 'Kelas intensif latihan percakapan bahasa Arab praktis untuk kebutuhan sehari-hari, ungkapan perkenalan, aktivitas harian, lingkungan sekolah, hingga berkomunikasi dengan santun.', 'muhadatsah.jpg', 'paid', 149000.00, 'published', NOW());

-- Seed Data: Lessons for Course 1 (Free)
INSERT INTO `lessons` (`id`, `course_id`, `title`, `youtube_url`, `youtube_video_id`, `order_num`, `description`, `created_at`) VALUES
(1, 1, 'Materi 1: Pengantar Bahasa Arab & Pembagian Kata (Al-Kalimah)', 'https://www.youtube.com/watch?v=5V920h7j7jE', '5V920h7j7jE', 1, 'Mengenal hakikat kalimat dalam bahasa Arab dan tiga komponen dasarnya: Isim, Fi\'il, dan Huruf.', NOW()),
(2, 1, 'Materi 2: Ciri-Ciri Isim (Kata Benda) dan Contoh Penggunaannya', 'https://www.youtube.com/watch?v=kYJ7x6Wc5v8', 'kYJ7x6Wc5v8', 2, 'Mengenal tanda-tanda khusus kalimat Isim seperti Tanwin, Alif Lam (Al-), dan Huruf Jar.', NOW()),
(3, 1, 'Materi 3: Mengenal Fi\'il (Kata Kerja): Madhi, Mudhari\', dan Amr', 'https://www.youtube.com/watch?v=Z1gq9V5iVqQ', 'Z1gq9V5iVqQ', 3, 'Pembagian kata kerja dalam bahasa Arab berdasarkan waktu terjadinya perbuatan serta kaidah dasarnya.', NOW());

-- Seed Data: Lessons for Course 2 (Paid)
INSERT INTO `lessons` (`id`, `course_id`, `title`, `youtube_url`, `youtube_video_id`, `order_num`, `description`, `created_at`) VALUES
(4, 2, 'Materi 1: Ta\'aruf (Perkenalan Diri & Menanyakan Kabar)', 'https://www.youtube.com/watch?v=L_LUpnjgPso', 'L_LUpnjgPso', 1, 'Kosakata dan ungkapan penting saat berkenalan dengan penutur bahasa Arab dengan intonasi yang tepat.', NOW()),
(5, 2, 'Materi 2: Percakapan di Lingkungan Sekolah & Asrama', 'https://www.youtube.com/watch?v=kJQP7kiw5Fk', 'kJQP7kiw5Fk', 2, 'Dialog praktis seputar aktivitas belajar, jadwal harian, dan komunikasi santun dengan teman dan guru.', NOW()),
(6, 2, 'Materi 3: Ungkapan Praktis Saat Berbelanja & Bertanya Arah', 'https://www.youtube.com/watch?v=e-ORhEE9VVg', 'e-ORhEE9VVg', 3, 'Menanyakan harga, menawar barang, serta petunjuk arah dalam bahasa Arab fusha yang mudah dipahami.', NOW());
