CREATE DATABASE IF NOT EXISTS `tech_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tech_shop`;

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `image` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(1, 'Видеокарта NVIDIA RTX 4070 Ti Super 16GB', 1759.00, 'rtx4070.jpg'),
(2, 'Механична геймърска клавиатура (Logitech G Pro X)', 289.00, 'keyboard.jpg'),
(3, 'Геймърски монитор 27" IPS QHD 165Hz (ASUS TUF)', 545.00, 'monitor.jpg');