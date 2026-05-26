-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 07:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trabe`
--

-- --------------------------------------------------------

--
-- Table structure for table `abastecimiento`
--

CREATE TABLE `abastecimiento` (
  `ID_prod` int(11) NOT NULL,
  `fk_id_material` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `precio` float NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abastecimiento`
--

INSERT INTO `abastecimiento` (`ID_prod`, `fk_id_material`, `fk_id_proveedor`, `precio`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 8, 1, 50, '2026-04-29 18:09:13', '2026-04-22 18:14:23', '2026-04-29 18:09:13'),
(2, 5, 2, 55, '2026-04-24 07:43:11', '2026-04-24 07:43:11', NULL),
(3, 5, 1, 5, '2026-04-24 14:29:05', '2026-04-24 14:29:05', NULL),
(4, 9, 3, 30, '2026-04-24 18:08:40', '2026-04-24 18:08:40', NULL),
(5, 9, 1, 10, '2026-04-24 18:11:04', '2026-04-24 18:11:04', NULL),
(6, 15, 1, 2500, '2026-04-30 02:10:32', '2026-04-30 02:10:32', NULL),
(7, 16, 1, 1800, '2026-04-30 02:10:32', '2026-04-30 02:10:32', NULL),
(8, 17, 1, 80, '2026-04-30 02:10:32', '2026-04-30 02:10:32', NULL),
(9, 18, 4, 15, '2026-04-30 02:47:01', '2026-04-30 02:47:01', NULL),
(10, 19, 4, 15, '2026-04-30 02:47:01', '2026-04-30 02:47:01', NULL),
(11, 20, 4, 15, '2026-04-30 02:47:01', '2026-04-30 02:47:01', NULL),
(12, 21, 4, 150, '2026-04-30 14:34:12', '2026-04-30 14:34:12', NULL),
(13, 22, 4, 400, '2026-04-30 14:34:12', '2026-04-30 14:34:12', NULL),
(14, 23, 4, 3, '2026-04-30 14:34:12', '2026-04-30 14:34:12', NULL),
(15, 21, 1, 150, '2026-04-30 18:36:18', '2026-04-30 18:36:18', NULL),
(16, 22, 1, 400, '2026-04-30 18:36:18', '2026-04-30 18:36:18', NULL),
(17, 23, 1, 3, '2026-04-30 18:36:18', '2026-04-30 18:36:18', NULL),
(18, 15, 2, 120, '2026-05-11 10:47:37', '2026-05-11 10:47:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `nombre`, `descripcion`, `deleted_at`) VALUES
(1, 'Acabados', 'Materiales que transforman una estructura base en un espacio habitable, estético y funcional', NULL),
(2, 'estructura', 'estructura fuerte', NULL),
(3, 'Plomeria', 'Para plomeros', NULL),
(4, 'Instalacion Electrica', 'Electrica', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `ID_cliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`ID_cliente`, `nombre`, `telefono`, `direccion`, `deleted_at`, `updated_at`, `email`) VALUES
(1, 'juan', '4568385', 'av tec', '2026-04-24 18:29:43', NULL, NULL),
(2, 'Fabricio Ochoa', '3471045969', 'Arboledas', NULL, NULL, 'correofabricio@correo.com.mx'),
(3, 'Nahum Aleman', '3121451565', 'La Reserva', '2026-05-21 18:42:02', NULL, NULL),
(4, 'Alan Contreras', '3121059482', 'Calle #100\n', NULL, '2026-05-09 21:25:20', 'alanissaccontr32@gmail.com'),
(5, 'Alan Isaac', '3121552349', 'abc', NULL, NULL, 'alan@correo.com');

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion`
--

CREATE TABLE `cotizacion` (
  `ID_cotizacion` int(11) NOT NULL,
  `fk_id_proyecto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `total` float NOT NULL,
  `costo_equipo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gastos_generales` decimal(5,2) NOT NULL DEFAULT 10.00,
  `margen_ganancia` decimal(5,2) NOT NULL DEFAULT 15.00,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cotizacion`
--

INSERT INTO `cotizacion` (`ID_cotizacion`, `fk_id_proyecto`, `fecha`, `estado`, `total`, `costo_equipo`, `gastos_generales`, `margen_ganancia`, `deleted_at`, `created_at`) VALUES
(1, 3, '2026-04-30', 0, 33800.8, 999.98, 10.00, 15.00, NULL, NULL),
(9, 11, '2026-05-06', 0, 8538.75, 0.00, 10.00, 15.00, NULL, NULL),
(10, 18, '2026-05-20', 0, 2024, 0.00, 10.00, 15.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detallecotizacion`
--

CREATE TABLE `detallecotizacion` (
  `ID_DetalleCotiza` int(11) NOT NULL,
  `fk_id_cotizacion` int(11) NOT NULL,
  `fk_id_material` int(11) DEFAULT NULL,
  `fk_id_proveedor` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` decimal(10,2) DEFAULT NULL,
  `tiempo_entrega_dias` int(11) DEFAULT NULL,
  `fk_id_mano_obra` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detallecotizacion`
--

INSERT INTO `detallecotizacion` (`ID_DetalleCotiza`, `fk_id_cotizacion`, `fk_id_material`, `fk_id_proveedor`, `cantidad`, `precio_unit`, `tiempo_entrega_dias`, `fk_id_mano_obra`, `deleted_at`) VALUES
(1, 9, NULL, NULL, 45, 150.00, NULL, 6, '2026-05-25 17:04:56'),
(2, 1, NULL, NULL, 6, 1000.00, NULL, 3, '2026-05-25 17:05:28'),
(3, 1, NULL, NULL, 12, 80.00, NULL, 4, '2026-05-25 17:05:28'),
(4, 10, NULL, NULL, 10, 160.00, NULL, 7, '2026-05-25 17:06:07'),
(5, 9, NULL, NULL, 45, 150.00, NULL, 6, NULL),
(6, 1, NULL, NULL, 6, 1000.00, NULL, 3, '2026-05-25 17:07:51'),
(7, 1, NULL, NULL, 12, 80.00, NULL, 4, '2026-05-25 17:07:51'),
(8, 10, NULL, NULL, 10, 160.00, NULL, 7, NULL),
(9, 1, NULL, NULL, 6, 1000.00, NULL, 3, '2026-05-25 18:22:29'),
(10, 1, NULL, NULL, 12, 80.00, NULL, 4, '2026-05-25 18:22:29'),
(11, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-25 18:28:29'),
(12, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-25 18:28:29'),
(13, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 03:45:29'),
(14, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 03:45:29'),
(15, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 03:46:17'),
(16, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 03:46:17'),
(17, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 04:45:39'),
(18, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 04:45:39'),
(19, 9, 22, 4, 20, 400.00, NULL, NULL, NULL),
(20, 1, 18, 4, 15, 15.00, NULL, NULL, NULL),
(21, 1, 9, 1, 1500, 10.00, NULL, NULL, NULL),
(22, 10, 18, 4, 12, 15.00, NULL, NULL, NULL),
(23, 10, 5, 1, 10, 5.00, NULL, NULL, NULL),
(24, 1, 16, 1, 2, 1800.00, NULL, NULL, NULL),
(25, 1, 18, 4, 8, 15.00, NULL, NULL, NULL),
(26, 1, 16, 1, 1, 1800.00, NULL, NULL, NULL),
(27, 1, 16, 1, 1, 1800.00, NULL, NULL, NULL),
(28, 1, 15, 2, 21, 120.00, NULL, NULL, NULL),
(29, 1, 20, 4, 15, 15.00, NULL, NULL, NULL),
(34, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 04:49:04'),
(35, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 04:49:04'),
(36, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 04:52:40'),
(37, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 04:52:40'),
(38, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 05:11:52'),
(39, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 05:11:52'),
(40, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 05:17:20'),
(41, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 05:17:20'),
(42, 1, NULL, NULL, 6, NULL, NULL, 3, '2026-05-26 05:25:22'),
(43, 1, NULL, NULL, 12, NULL, NULL, 4, '2026-05-26 05:25:22'),
(44, 1, NULL, NULL, 6, NULL, NULL, 3, NULL),
(45, 1, NULL, NULL, 12, NULL, NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detallecotizacion_abastecimiento`
--

CREATE TABLE `detallecotizacion_abastecimiento` (
  `ID_det_ab` int(11) NOT NULL,
  `fk_id_cotizacion` int(11) NOT NULL,
  `fk_id_abastecimiento` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detallecotizacion_abastecimiento`
--

INSERT INTO `detallecotizacion_abastecimiento` (`ID_det_ab`, `fk_id_cotizacion`, `fk_id_abastecimiento`, `cantidad`, `deleted_at`) VALUES
(1, 9, 13, 20, NULL),
(2, 1, 9, 15, '2026-05-26 04:45:39'),
(3, 1, 5, 1500, '2026-05-26 04:45:39'),
(4, 10, 9, 12, NULL),
(5, 10, 3, 10, NULL),
(6, 1, 7, 2, '2026-05-26 04:45:39'),
(7, 1, 9, 8, '2026-05-26 04:45:39'),
(8, 1, 7, 1, '2026-05-26 04:45:39'),
(9, 1, 7, 1, '2026-05-26 04:45:39'),
(10, 1, 18, 21, '2026-05-26 04:45:39'),
(11, 1, 11, 15, '2026-05-26 04:45:39'),
(12, 1, 5, 1500, '2026-05-26 04:49:04'),
(13, 1, 7, 2, '2026-05-26 04:49:04'),
(14, 1, 7, 1, '2026-05-26 04:49:04'),
(15, 1, 7, 1, '2026-05-26 04:49:04'),
(16, 1, 18, 21, '2026-05-26 04:49:04'),
(17, 1, 5, 1500, '2026-05-26 04:52:40'),
(18, 1, 7, 2, '2026-05-26 04:52:40'),
(19, 1, 7, 1, '2026-05-26 04:52:40'),
(20, 1, 7, 1, '2026-05-26 04:52:40'),
(21, 1, 18, 21, '2026-05-26 04:52:40'),
(22, 1, 5, 1500, '2026-05-26 05:11:52'),
(23, 1, 7, 2, '2026-05-26 05:11:52'),
(24, 1, 7, 1, '2026-05-26 05:11:52'),
(25, 1, 7, 1, '2026-05-26 05:11:52'),
(26, 1, 18, 21, '2026-05-26 05:11:52'),
(27, 1, 5, 1500, '2026-05-26 05:17:20'),
(28, 1, 7, 2, '2026-05-26 05:17:20'),
(29, 1, 7, 1, '2026-05-26 05:17:20'),
(30, 1, 7, 1, '2026-05-26 05:17:20'),
(31, 1, 18, 21, '2026-05-26 05:17:20'),
(32, 1, 5, 1500, '2026-05-26 05:25:22'),
(33, 1, 7, 2, '2026-05-26 05:25:22'),
(34, 1, 7, 1, '2026-05-26 05:25:22'),
(35, 1, 7, 1, '2026-05-26 05:25:22'),
(36, 1, 18, 21, '2026-05-26 05:25:22'),
(37, 1, 5, 1600, NULL),
(38, 1, 7, 2, NULL),
(39, 1, 7, 1, NULL),
(40, 1, 7, 1, NULL),
(41, 1, 18, 21, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detallesorden`
--

CREATE TABLE `detallesorden` (
  `ID_Detalle_orden` int(11) NOT NULL,
  `fk_id_orden` int(11) NOT NULL,
  `fk_id_detalle_cotiza` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manoobra`
--

CREATE TABLE `manoobra` (
  `ID_mano_obra` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `fk_id_servicio` int(11) NOT NULL,
  `unidad` varchar(15) NOT NULL,
  `precio` float NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manoobra`
--

INSERT INTO `manoobra` (`ID_mano_obra`, `fk_id_proveedor`, `fk_id_servicio`, `unidad`, `precio`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 3, 2, 'dia', 1000, '2026-04-24 18:27:23', '2026-04-24 18:27:23', '2026-04-24 18:25:21'),
(2, 2, 3, 'bulto', 100, '2026-04-24 18:27:03', '2026-04-24 18:27:03', '2026-04-24 18:26:56'),
(3, 3, 2, 'dia', 1000, NULL, '2026-04-24 18:27:23', '2026-04-24 18:27:23'),
(4, 3, 4, 'hora', 80, NULL, '2026-04-27 18:46:37', '2026-04-27 18:46:37'),
(5, 1, 4, 'hora', 95, NULL, '2026-04-27 18:46:37', '2026-04-27 18:46:37'),
(6, 1, 5, 'm2', 150, NULL, '2026-04-27 18:47:29', '2026-04-27 18:47:29'),
(7, 2, 5, 'hora', 160, NULL, '2026-04-27 18:47:29', '2026-04-27 18:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `materiales`
--

CREATE TABLE `materiales` (
  `ID_Material` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `medidas` varchar(20) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL,
  `ficha_tecnica` text DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materiales`
--

INSERT INTO `materiales` (`ID_Material`, `nombre`, `codigo`, `medidas`, `fk_id_categoria`, `ficha_tecnica`, `deleted_at`) VALUES
(1, 'Pintura', 'PIN-223', 'Cubeta 20L', 1, NULL, NULL),
(2, 'yeso', '22', 'bulto 10kg', 1, NULL, NULL),
(3, 'azulejo', '14', 'pieza', 1, NULL, NULL),
(5, 'Concreto', 'C-152', 'bulto', 2, NULL, NULL),
(6, 'Concreto', 'C-152', 'Bulto', 2, NULL, '2026-04-29 18:08:51'),
(7, 'Concreto', 'C-152', 'Bulto', 2, NULL, '2026-04-29 18:09:03'),
(8, 'Concreto', 'C-152', 'Bulto', 2, NULL, '2026-04-29 18:09:13'),
(9, 'Ladrillos', 'LAD-01', 'pz', 2, NULL, NULL),
(10, 'Enchufes', 'E-502', 'Pieza', 4, NULL, NULL),
(15, 'Arena Fina', 'MAT-001', 'Tonelada', 2, NULL, NULL),
(16, 'Grava', 'MAT-002', 'Tonelada', 2, NULL, NULL),
(17, 'Cal', 'MAT-003', 'Bulto', 2, NULL, NULL),
(18, 'Codo 45', 'MAT-004', 'Pieza', 3, NULL, NULL),
(19, 'Tee', 'MAT-005', 'Pieza', 3, NULL, NULL),
(20, 'Cople', 'MAT-006', 'Pieza', 3, NULL, NULL),
(21, 'Panel de fibra', 'MAT-007', 'Pieza', 1, NULL, NULL),
(22, 'Placa de aluminio', 'MAT-008', 'Pieza', 1, NULL, NULL),
(23, 'Ladrillo expusto', 'MAT-009', 'Pieza', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_23_143332_add_soft_deletes_to_tables', 2),
(6, '2026_05_18_151001_add_role_to_users_table', 2),
(7, '2026_05_25_160304_add_costos_adicionales_to_cotizacion', 3),
(8, '2026_05_25_161358_add_fk_id_material_to_detallecotizacion', 4),
(9, '2026_05_25_164232_add_foreign_keys_to_detallecotizacion', 5),
(10, '2026_05_25_165052_fix_detallecotizacion_foreign_keys', 6);

-- --------------------------------------------------------

--
-- Table structure for table `ordenes`
--

CREATE TABLE `ordenes` (
  `ID_Orden` int(11) NOT NULL,
  `fk_id_proyecto` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `no_orden` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preciohistorico`
--

CREATE TABLE `preciohistorico` (
  `ID_preciohist` int(11) NOT NULL,
  `precio` float NOT NULL,
  `fk_id_material` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `ID_proveedor` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_contacto` varchar(40) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `correo_e` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'Ambos',
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`ID_proveedor`, `nombre`, `nombre_contacto`, `telefono`, `correo_e`, `direccion`, `tipo`, `deleted_at`, `updated_at`) VALUES
(1, 'Cemex', 'Pedro Rocha', '312251152', 'p.rocha@gmail.com', 'V. Carranza 254', 'Ambos', NULL, NULL),
(2, 'Cementos Tolteca', 'Tolteca', '3121455678', 'tolteca@gmail.com', 'av. enrique 133', 'Ambos', NULL, NULL),
(3, 'Nuevo', 'Pedro Rocha', '3123123212', 'correo@gmail.com', 'Direccion 2', 'Servicios', NULL, NULL),
(4, 'Nahum', 'Nahum Aleman', '3121455145', 'Nahum@tecnm.mx', 'La reserva', 'Ambos', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proyecto`
--

CREATE TABLE `proyecto` (
  `ID_proyecto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fk_id_cliente` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `presupuesto` float NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proyecto`
--

INSERT INTO `proyecto` (`ID_proyecto`, `nombre`, `fk_id_cliente`, `estado`, `fecha_ini`, `fecha_fin`, `presupuesto`, `deleted_at`) VALUES
(1, 'abaña rustca', 3, 1, '2026-04-17', '2026-04-30', 70000, NULL),
(2, 'Casa 2 pisos', 3, 1, '2026-04-24', '2026-04-25', 10000, NULL),
(3, 'Remodelacion', 2, 1, '2026-04-30', NULL, 33800.8, NULL),
(4, 'Remodelacion', 3, 1, '2026-04-30', NULL, 0, '2026-05-09 21:47:38'),
(5, 'Remodelacion', 3, 1, '2026-04-30', NULL, 0, NULL),
(6, 'Remodelacion', 3, 1, '2026-04-30', NULL, 0, NULL),
(7, 'Remodelacion', 3, 1, '2026-04-30', NULL, 0, NULL),
(8, 'Remodelacion', 3, 1, '2026-04-30', NULL, 0, NULL),
(9, 'Remodelacion', 3, 1, '2026-04-30', NULL, 0, NULL),
(10, 'Obra', 2, 1, '2026-04-30', '2026-05-31', 30000, NULL),
(11, 'casa del arbol', 2, 1, '2026-05-06', '2026-05-08', 8538.75, NULL),
(12, 'Piscina', 5, 1, '2026-05-21', '2026-05-29', 15000, NULL),
(13, 'Piscina', 5, 1, '2026-05-21', '2026-05-29', 15000, NULL),
(14, 'Piscina', 5, 1, '2026-05-21', '2026-05-29', 15000, NULL),
(15, 'Piscina', 5, 1, '2026-05-21', '2026-05-29', 15000, NULL),
(16, 'Piscina', 5, 1, '2026-05-21', '2026-05-29', 15000, NULL),
(17, 'Piscina', 5, 1, '2026-05-20', '2026-05-22', 10000, NULL),
(18, 'Piscina', 5, 1, '2026-05-20', NULL, 2024, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `servicio`
--

CREATE TABLE `servicio` (
  `ID_servicio` int(11) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicio`
--

INSERT INTO `servicio` (`ID_servicio`, `fk_id_categoria`, `nombre`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 1, 'servicio 1', '2026-04-24 18:26:08', '2026-04-24 18:26:08', '2026-04-24 18:24:43'),
(2, 2, 'servicio A', NULL, '2026-04-24 18:27:23', '2026-04-24 18:25:21'),
(3, 1, 'serv', '2026-04-24 18:27:03', '2026-04-24 18:27:03', '2026-04-24 18:26:56'),
(4, 2, 'Cableado', NULL, '2026-04-27 18:46:37', '2026-04-27 18:46:37'),
(5, 1, 'Cerrajeria', NULL, '2026-04-27 18:47:29', '2026-04-27 18:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'juan', NULL, NULL, '$2y$12$uER2r8OU3xbhA2HdpMvlS.HmcvOyoCUl/emqJVaPwaNEj1azOh/Vq', 'admin', NULL, NULL, '2026-05-18 21:17:19'),
(2, 'user', 'user@gmail.com.mx', NULL, '$2y$12$uER2r8OU3xbhA2HdpMvlS.HmcvOyoCUl/emqJVaPwaNEj1azOh/Vq', 'user', NULL, NULL, '2026-05-22 01:29:56'),
(3, 'Nahum', 'nahumaleman@gmail.com', NULL, '$2y$12$lujlymlpaoeL0leX/CrSVOFZuO0chg3EZVEiAMGbF2U.rPdFgtk/a', 'admin', NULL, '2026-05-23 09:37:26', '2026-05-23 09:37:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abastecimiento`
--
ALTER TABLE `abastecimiento`
  ADD PRIMARY KEY (`ID_prod`),
  ADD KEY `ID_Material` (`fk_id_material`),
  ADD KEY `ID_proveedor` (`fk_id_proveedor`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_cliente`);

--
-- Indexes for table `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`ID_cotizacion`),
  ADD KEY `fk_id_proyecto` (`fk_id_proyecto`);

--
-- Indexes for table `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD PRIMARY KEY (`ID_DetalleCotiza`),
  ADD KEY `fk_id_cotizacion` (`fk_id_cotizacion`),
  ADD KEY `fk_id_mano_obra` (`fk_id_mano_obra`),
  ADD KEY `fk_detalle_material` (`fk_id_material`),
  ADD KEY `fk_detalle_proveedor` (`fk_id_proveedor`);

--
-- Indexes for table `detallecotizacion_abastecimiento`
--
ALTER TABLE `detallecotizacion_abastecimiento`
  ADD PRIMARY KEY (`ID_det_ab`),
  ADD KEY `fk_id_cotizacion` (`fk_id_cotizacion`),
  ADD KEY `fk_id_abastecimiento` (`fk_id_abastecimiento`);

--
-- Indexes for table `detallesorden`
--
ALTER TABLE `detallesorden`
  ADD PRIMARY KEY (`ID_Detalle_orden`),
  ADD KEY `fk_id_detalle_cotiza` (`fk_id_detalle_cotiza`),
  ADD KEY `fk_id_orden` (`fk_id_orden`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `manoobra`
--
ALTER TABLE `manoobra`
  ADD PRIMARY KEY (`ID_mano_obra`),
  ADD KEY `fk_id_mano_obra_contac` (`fk_id_proveedor`),
  ADD KEY `fk_id_servicio` (`fk_id_servicio`);

--
-- Indexes for table `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`ID_Material`),
  ADD KEY `fk_id_categoria` (`fk_id_categoria`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`ID_Orden`),
  ADD KEY `fk_id_proyecto` (`fk_id_proyecto`),
  ADD KEY `ordenes_fk_id_proveedor_foreign` (`fk_id_proveedor`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `preciohistorico`
--
ALTER TABLE `preciohistorico`
  ADD PRIMARY KEY (`ID_preciohist`),
  ADD KEY `fk_id_material` (`fk_id_material`),
  ADD KEY `fk_id_proveedor` (`fk_id_proveedor`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`ID_proveedor`);

--
-- Indexes for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`ID_proyecto`),
  ADD KEY `fk_id_cliente` (`fk_id_cliente`);

--
-- Indexes for table `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`ID_servicio`),
  ADD KEY `fk_id_categoria` (`fk_id_categoria`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abastecimiento`
--
ALTER TABLE `abastecimiento`
  MODIFY `ID_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `ID_cotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  MODIFY `ID_DetalleCotiza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `detallecotizacion_abastecimiento`
--
ALTER TABLE `detallecotizacion_abastecimiento`
  MODIFY `ID_det_ab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `detallesorden`
--
ALTER TABLE `detallesorden`
  MODIFY `ID_Detalle_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manoobra`
--
ALTER TABLE `manoobra`
  MODIFY `ID_mano_obra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `materiales`
--
ALTER TABLE `materiales`
  MODIFY `ID_Material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `ID_Orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preciohistorico`
--
ALTER TABLE `preciohistorico`
  MODIFY `ID_preciohist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `ID_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `ID_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `servicio`
--
ALTER TABLE `servicio`
  MODIFY `ID_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abastecimiento`
--
ALTER TABLE `abastecimiento`
  ADD CONSTRAINT `abastecimiento_ibfk_1` FOREIGN KEY (`fk_id_material`) REFERENCES `materiales` (`ID_Material`),
  ADD CONSTRAINT `abastecimiento_ibfk_2` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`);

--
-- Constraints for table `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `FK_Cotizacion_Proyecto` FOREIGN KEY (`fk_id_proyecto`) REFERENCES `proyecto` (`ID_proyecto`);

--
-- Constraints for table `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD CONSTRAINT `FK_DetalleCotizacion_Cotizacion` FOREIGN KEY (`fk_id_cotizacion`) REFERENCES `cotizacion` (`ID_cotizacion`),
  ADD CONSTRAINT `fk_detalle_mano_obra` FOREIGN KEY (`fk_id_mano_obra`) REFERENCES `manoobra` (`ID_mano_obra`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_detalle_material` FOREIGN KEY (`fk_id_material`) REFERENCES `materiales` (`ID_Material`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_detalle_proveedor` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`) ON DELETE SET NULL;

--
-- Constraints for table `detallecotizacion_abastecimiento`
--
ALTER TABLE `detallecotizacion_abastecimiento`
  ADD CONSTRAINT `detallecotizacion_abastecimiento_ibfk_1` FOREIGN KEY (`fk_id_cotizacion`) REFERENCES `cotizacion` (`ID_cotizacion`),
  ADD CONSTRAINT `detallecotizacion_abastecimiento_ibfk_2` FOREIGN KEY (`fk_id_abastecimiento`) REFERENCES `abastecimiento` (`ID_prod`);

--
-- Constraints for table `detallesorden`
--
ALTER TABLE `detallesorden`
  ADD CONSTRAINT `FK_DetallesOrden_DetalleCotizacion` FOREIGN KEY (`fk_id_detalle_cotiza`) REFERENCES `detallecotizacion` (`ID_DetalleCotiza`),
  ADD CONSTRAINT `FK_DetallesOrden_Ordenes` FOREIGN KEY (`fk_id_orden`) REFERENCES `ordenes` (`ID_Orden`);

--
-- Constraints for table `manoobra`
--
ALTER TABLE `manoobra`
  ADD CONSTRAINT `FK_DetalleManoObra_ManoObraContac` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`),
  ADD CONSTRAINT `manoobra_ibfk_1` FOREIGN KEY (`fk_id_servicio`) REFERENCES `servicio` (`ID_servicio`);

--
-- Constraints for table `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `FK_Materiales_Categoria` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`ID_Categoria`);

--
-- Constraints for table `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `FK_Ordenes_Proyecto` FOREIGN KEY (`fk_id_proyecto`) REFERENCES `proyecto` (`ID_proyecto`),
  ADD CONSTRAINT `ordenes_fk_id_proveedor_foreign` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`);

--
-- Constraints for table `preciohistorico`
--
ALTER TABLE `preciohistorico`
  ADD CONSTRAINT `FK_PrecioHistorico_Materiales` FOREIGN KEY (`fk_id_material`) REFERENCES `materiales` (`ID_Material`),
  ADD CONSTRAINT `FK_PrecioHistorico_Proveedores` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`);

--
-- Constraints for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `FK_Proyecto_Clientes` FOREIGN KEY (`fk_id_cliente`) REFERENCES `clientes` (`ID_cliente`);

--
-- Constraints for table `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`ID_Categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
