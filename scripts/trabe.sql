-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2026 a las 20:35:03
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `trabe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abastecimiento`
--

CREATE TABLE `abastecimiento` (
  `ID_prod` int(11) NOT NULL,
  `fk_id_material` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `precio` float NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `abastecimiento`
--

INSERT INTO `abastecimiento` (`ID_prod`, `fk_id_material`, `fk_id_proveedor`, `precio`, `updated_at`, `created_at`) VALUES
(1, 8, 1, 50, '2026-04-22 18:14:23', '2026-04-22 18:14:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `nombre`, `descripcion`) VALUES
(1, 'Acabados', 'Materiales que transforman una estructura base en un espacio habitable, estético y funcional'),
(2, 'estructura', 'estructura fuerte'),
(3, 'Plomeria', 'Para plomeros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_cliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `direccion` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_cliente`, `nombre`, `telefono`, `direccion`) VALUES
(1, 'juan', '4568385', 'av tec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `ID_cotizacion` int(11) NOT NULL,
  `fk_id_proyecto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecotizacion`
--

CREATE TABLE `detallecotizacion` (
  `ID_DetalleCotiza` int(11) NOT NULL,
  `fk_id_material` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `fk_id_cotizacion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` float NOT NULL,
  `tiempo_entrega_dias` int(11) DEFAULT NULL,
  `fk_id_mano_obra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesorden`
--

CREATE TABLE `detallesorden` (
  `ID_Detalle_orden` int(11) NOT NULL,
  `fk_id_orden` int(11) NOT NULL,
  `fk_id_detalle_cotiza` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
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
-- Estructura de tabla para la tabla `manoobra`
--

CREATE TABLE `manoobra` (
  `ID_mano_obra` int(11) NOT NULL,
  `fk_id_proveedor` int(11) NOT NULL,
  `fk_id_servicio` int(11) NOT NULL,
  `unidad` varchar(15) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `ID_Material` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `medidas` varchar(20) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL,
  `ficha_tecnica` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`ID_Material`, `nombre`, `codigo`, `medidas`, `fk_id_categoria`, `ficha_tecnica`) VALUES
(1, 'Pintura', 'PIN-223', 'Cubeta 20L', 1, NULL),
(2, 'yeso', '22', 'bulto 10kg', 1, NULL),
(3, 'azulejo', '14', 'pieza', 1, NULL),
(5, 'Concreto', 'C-152', 'bulto', 2, NULL),
(6, 'Concreto', 'C-152', 'Bulto', 2, NULL),
(7, 'Concreto', 'C-152', 'Bulto', 2, NULL),
(8, 'Concreto', 'C-152', 'Bulto', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `ID_Orden` int(11) NOT NULL,
  `fk_id_proyecto` int(11) NOT NULL,
  `no_orden` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
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
-- Estructura de tabla para la tabla `preciohistorico`
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
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `ID_proveedor` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_contacto` varchar(40) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo_e` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`ID_proveedor`, `nombre`, `nombre_contacto`, `telefono`, `correo_e`, `direccion`) VALUES
(1, 'Cemex', 'Pedro Rocha', 312251152, 'p.rocha@gmail.com', 'V. Carranza 254');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `ID_proyecto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fk_id_cliente` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `presupuesto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`ID_proyecto`, `nombre`, `fk_id_cliente`, `estado`, `fecha_ini`, `fecha_fin`, `presupuesto`) VALUES
(1, 'abaña rustca', 1, 1, '2026-04-17', '2026-04-30', 70000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `ID_servicio` int(11) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'juan', NULL, NULL, '$2y$12$cGON8Gx.Oxo7UhJTFRxineRiz7r/kyEHA9NpL6YtP/iGMKSa4zrjq', NULL, NULL, '2026-04-21 00:26:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abastecimiento`
--
ALTER TABLE `abastecimiento`
  ADD PRIMARY KEY (`ID_prod`),
  ADD KEY `ID_Material` (`fk_id_material`),
  ADD KEY `ID_proveedor` (`fk_id_proveedor`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_cliente`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`ID_cotizacion`),
  ADD KEY `fk_id_proyecto` (`fk_id_proyecto`);

--
-- Indices de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD PRIMARY KEY (`ID_DetalleCotiza`),
  ADD KEY `fk_id_cotizacion` (`fk_id_cotizacion`),
  ADD KEY `fk_id_mano_obra` (`fk_id_mano_obra`),
  ADD KEY `fk_id_material` (`fk_id_material`),
  ADD KEY `fk_id_proveedor` (`fk_id_proveedor`);

--
-- Indices de la tabla `detallesorden`
--
ALTER TABLE `detallesorden`
  ADD PRIMARY KEY (`ID_Detalle_orden`),
  ADD KEY `fk_id_detalle_cotiza` (`fk_id_detalle_cotiza`),
  ADD KEY `fk_id_orden` (`fk_id_orden`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `manoobra`
--
ALTER TABLE `manoobra`
  ADD PRIMARY KEY (`ID_mano_obra`),
  ADD KEY `fk_id_mano_obra_contac` (`fk_id_proveedor`),
  ADD KEY `fk_id_servicio` (`fk_id_servicio`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`ID_Material`),
  ADD KEY `fk_id_categoria` (`fk_id_categoria`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`ID_Orden`),
  ADD KEY `fk_id_proyecto` (`fk_id_proyecto`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `preciohistorico`
--
ALTER TABLE `preciohistorico`
  ADD PRIMARY KEY (`ID_preciohist`),
  ADD KEY `fk_id_material` (`fk_id_material`),
  ADD KEY `fk_id_proveedor` (`fk_id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`ID_proveedor`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`ID_proyecto`),
  ADD KEY `fk_id_cliente` (`fk_id_cliente`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`ID_servicio`),
  ADD KEY `fk_id_categoria` (`fk_id_categoria`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abastecimiento`
--
ALTER TABLE `abastecimiento`
  MODIFY `ID_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `ID_cotizacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  MODIFY `ID_DetalleCotiza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallesorden`
--
ALTER TABLE `detallesorden`
  MODIFY `ID_Detalle_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `manoobra`
--
ALTER TABLE `manoobra`
  MODIFY `ID_mano_obra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `ID_Material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `ID_Orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preciohistorico`
--
ALTER TABLE `preciohistorico`
  MODIFY `ID_preciohist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `ID_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `ID_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `ID_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abastecimiento`
--
ALTER TABLE `abastecimiento`
  ADD CONSTRAINT `abastecimiento_ibfk_1` FOREIGN KEY (`fk_id_Material`) REFERENCES `materiales` (`ID_Material`),
  ADD CONSTRAINT `abastecimiento_ibfk_2` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`);

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `FK_Cotizacion_Proyecto` FOREIGN KEY (`fk_id_proyecto`) REFERENCES `proyecto` (`ID_proyecto`);

--
-- Filtros para la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD CONSTRAINT `FK_DetalleCotizacion_Cotizacion` FOREIGN KEY (`fk_id_cotizacion`) REFERENCES `cotizacion` (`ID_cotizacion`),
  ADD CONSTRAINT `FK_DetalleCotizacion_DetalleManoObra` FOREIGN KEY (`fk_id_mano_obra`) REFERENCES `manoobra` (`ID_mano_obra`),
  ADD CONSTRAINT `FK_DetalleCotizacion_Materiales` FOREIGN KEY (`fk_id_material`) REFERENCES `materiales` (`ID_Material`),
  ADD CONSTRAINT `FK_DetalleCotizacion_Proveedores` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`);

--
-- Filtros para la tabla `detallesorden`
--
ALTER TABLE `detallesorden`
  ADD CONSTRAINT `FK_DetallesOrden_DetalleCotizacion` FOREIGN KEY (`fk_id_detalle_cotiza`) REFERENCES `detallecotizacion` (`ID_DetalleCotiza`),
  ADD CONSTRAINT `FK_DetallesOrden_Ordenes` FOREIGN KEY (`fk_id_orden`) REFERENCES `ordenes` (`ID_Orden`);

--
-- Filtros para la tabla `manoobra`
--
ALTER TABLE `manoobra`
  ADD CONSTRAINT `FK_DetalleManoObra_ManoObraContac` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`),
  ADD CONSTRAINT `manoobra_ibfk_1` FOREIGN KEY (`fk_id_servicio`) REFERENCES `servicio` (`ID_servicio`);

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `FK_Materiales_Categoria` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`ID_Categoria`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `FK_Ordenes_Proyecto` FOREIGN KEY (`fk_id_proyecto`) REFERENCES `proyecto` (`ID_proyecto`);

--
-- Filtros para la tabla `preciohistorico`
--
ALTER TABLE `preciohistorico`
  ADD CONSTRAINT `FK_PrecioHistorico_Materiales` FOREIGN KEY (`fk_id_material`) REFERENCES `materiales` (`ID_Material`),
  ADD CONSTRAINT `FK_PrecioHistorico_Proveedores` FOREIGN KEY (`fk_id_proveedor`) REFERENCES `proveedores` (`ID_proveedor`);

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `FK_Proyecto_Clientes` FOREIGN KEY (`fk_id_cliente`) REFERENCES `clientes` (`ID_cliente`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`ID_Categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
