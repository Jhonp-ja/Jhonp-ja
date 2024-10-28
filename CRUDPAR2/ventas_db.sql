-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 23, 2024 at 11:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ventas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_cliente` int NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventario`
--

INSERT INTO `inventario` (`id`, `nombre`, `stock`, `precio`) VALUES
(1, 'Termo', 50, 5000.00),
(2, 'mouse', 150, 20000.00),
(3, 'tv 55 pulgadas', 10, 1000000.00),
(4, 'comedor 4 puestos', 20, 50000.00),
(5, 'portatil', 80, 15.00),
(6, 'luz led', 100, 2000.00),
(14, 'Camiseta', 100, 20000.00),
(15, 'Pantalones', 50, 15000.00),
(16, 'Zapatos', 75, 30000.00),
(17, 'Sombrero', 200, 5000.00),
(18, 'Bufanda', 80, 25000.00),
(19, 'Chaqueta', 60, 18000.00),
(20, 'Reloj', 40, 35000.00),
(21, 'Gafas de sol', 90, 22000.00),
(22, 'Bolso', 30, 27000.00),
(23, 'Cinturón', 120, 16000.00),
(24, 'Zapatos deportivos', 110, 23000.00),
(25, 'Sudadera', 85, 19000.00),
(26, 'Pantalones cortos', 95, 40000.00),
(27, 'Camisa', 150, 45000.00),
(28, 'Calcetines', 70, 17000.00),
(29, 'Camiseta de manga larga', 65, 29000.00),
(30, 'Vestido', 55, 21000.00);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`) VALUES
(106, 'Arroz', 1000),
(107, 'Arroz ', 3000),
(109, 'Aceite ', 7500),
(110, 'Azucar', 2500),
(111, 'Sal', 1000),
(112, 'Lentejas ', 4500),
(113, 'Pasta', 2000),
(114, 'Sopa Instantánea ', 3500),
(115, 'Leche ', 2200),
(116, 'Café ', 5000),
(117, 'carro', 20000),
(118, 'lentejas', 1500),
(120, 'paquete de cucharas', 10000),
(121, 'paquete de cucharas', 10000),
(122, 'Gaseosa pepsi', 5000),
(123, 'Gaseosa pepsi', 5000),
(124, 'Gaseosa cocacola', 7000),
(125, 'Gaseosa cocacola', 7000),
(126, 'pan cascarita', 200),
(127, 'pan cascarita', 200),
(128, 'libra de yuca', 1000),
(129, 'libra de yuca', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('cliente','administrador') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`) VALUES
(3, 'admin', '$2y$10$hrimpSyuRwqZDBZYJhc2..T6WIRjdhSPsr3a1iMSRYSQNCV8hsFgC', 'cliente'),
(6, 'Super', '$2y$10$EHgAKUK/7/fHMQJ5cSVK/ONVey9pWteNE6L4rIdku0O5jKqEwfJA6', 'administrador');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` int NOT NULL,
  `producto_id` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `producto_id`, `cantidad`, `total`, `fecha`) VALUES
(27, 115, 10, 22000.00, '2024-10-22 15:39:05'),
(54, 107, 2, 6000.00, '2024-10-22 18:13:47'),
(58, 109, 2, 15000.00, '2024-10-22 18:22:00'),
(59, 122, 2, 10000.00, '2024-10-22 18:33:45'),
(60, 106, 1, 1000.00, '2024-10-22 18:38:10'),
(61, 107, 2, 6000.00, '2024-10-22 18:38:34'),
(62, 107, 1, 3000.00, '2024-10-22 18:55:07'),
(63, 107, 2, 6000.00, '2024-10-22 19:25:17'),
(64, 106, 2, 2000.00, '2024-10-22 19:25:31'),
(65, 109, 1, 7500.00, '2024-10-22 19:26:58'),
(66, 117, 4, 80000.00, '2024-10-22 19:27:36'),
(67, 116, 4, 20000.00, '2024-10-22 21:39:48'),
(68, 110, 1, 2500.00, '2024-10-22 21:47:58'),
(69, 107, 1, 3000.00, '2024-10-22 23:14:12'),
(70, 106, 2, 2000.00, '2024-10-22 23:14:39'),
(71, 106, 1, 1000.00, '2024-10-22 23:24:07'),
(72, 107, 1, 3000.00, '2024-10-22 23:24:32'),
(73, 107, 1, 3000.00, '2024-10-22 23:27:27'),
(74, 110, 2, 5000.00, '2024-10-22 23:28:14'),
(75, 107, 2, 6000.00, '2024-10-22 23:34:22'),
(76, 110, 1, 2500.00, '2024-10-22 23:35:03'),
(77, 109, 1, 7500.00, '2024-10-22 23:35:03'),
(78, 106, 1, 1000.00, '2024-10-22 23:35:03'),
(79, 107, 1, 3000.00, '2024-10-22 23:35:03'),
(80, 116, 6, 30000.00, '2024-10-23 00:36:43'),
(81, 125, 1, 7000.00, '2024-10-23 00:40:55'),
(82, 106, 5, 5000.00, '2024-10-23 00:44:29'),
(83, 116, 4, 20000.00, '2024-10-23 00:49:46'),
(84, 107, 5, 15000.00, '2024-10-23 00:52:36'),
(85, 110, 1, 2500.00, '2024-10-23 00:52:36'),
(86, 110, 2, 5000.00, '2024-10-23 06:26:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_cliente` (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
