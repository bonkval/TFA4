SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `avatar` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
  (1, 'Cedrick Vales', 'cedrick.vales@example.com', '0967-676-7676', '2026-09-15 00:00:00'),
  (2, 'Joseph Bondoc', 'joseph.bondoc@example.com', '0967-676-7676', '2026-09-15 00:00:00'),
  (3, 'Philyip Caluag', 'philyip.caluag@example.com', '0967-676-7676', '2026-09-15 00:00:00'),
  (4, 'Lexus Medina', 'lexus.medina@example.com', '0967-676-7676', '2026-09-15 00:00:00'),
  (5, 'Raining Odarbe', 'raining.odarbe@example.com', '0967-676-7676', '2026-09-15 00:00:00');

INSERT IGNORE INTO `users` (`id`, `username`, `full_name`, `password`, `created_at`) VALUES
  (1, 'cvales', 'Cedrick Vales', '$2y$10$9r56.is7DmyZNT8Eos5VLutmdl2ElQ8wOzJM/Be.hUieqiEWrlBEa', '2026-09-15 00:00:00'),
  (2, 'jbondoc', 'Joseph Bondoc', '$2y$10$9r56.is7DmyZNT8Eos5VLutmdl2ElQ8wOzJM/Be.hUieqiEWrlBEa', '2026-09-15 00:00:00'),
  (3, 'pcaluag', 'Philyip Caluag', '$2y$10$9r56.is7DmyZNT8Eos5VLutmdl2ElQ8wOzJM/Be.hUieqiEWrlBEa', '2026-09-15 00:00:00'),
  (4, 'lmedina', 'Lexus Medina', '$2y$10$9r56.is7DmyZNT8Eos5VLutmdl2ElQ8wOzJM/Be.hUieqiEWrlBEa', '2026-09-15 00:00:00'),
  (5, 'rodarbe', 'Raining Odarbe', '$2y$10$9r56.is7DmyZNT8Eos5VLutmdl2ElQ8wOzJM/Be.hUieqiEWrlBEa', '2026-09-15 00:00:00');
