-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2020 a las 10:00:14
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `residencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `residente` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `dia` date NOT NULL,
  `come` tinyint(1) DEFAULT NULL,
  `cena` tinyint(1) DEFAULT NULL,
  `asiste_comida` tinyint(1) DEFAULT NULL,
  `asiste_cena` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`residente`, `dia`, `come`, `cena`, `asiste_comida`, `asiste_cena`) VALUES
('lusky1996@gmail.com', '2020-06-15', 1, 1, 0, 0),
('lusky1996@gmail.com', '2020-06-16', 1, 1, 0, 0),
('lusky1996@gmail.com', '2020-06-17', 1, 1, 0, 0),
('lusky1996@gmail.com', '2020-06-18', 1, 1, 0, 0),
('lusky1996@gmail.com', '2020-06-19', 1, 1, 0, 0),
('residente@residente.es', '2020-06-29', 0, 1, 0, 1),
('residente@residente.es', '2020-07-01', 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(1) NOT NULL,
  `hora_comida` time NOT NULL,
  `hora_cena` time NOT NULL,
  `limite_hora_comida` int(2) DEFAULT NULL,
  `limite_hora_cena` int(2) DEFAULT NULL,
  `registro` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `hora_comida`, `hora_cena`, `limite_hora_comida`, `limite_hora_cena`, `registro`) VALUES
(1, '14:00:00', '22:00:00', 2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `numero` smallint(6) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `residente1` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `residente2` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `disponible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `dia` date NOT NULL,
  `comida` varchar(300) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cena` varchar(300) COLLATE utf8mb4_spanish_ci NOT NULL,
  `modificado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`dia`, `comida`, `cena`, `modificado`) VALUES
('2020-06-08', '', '', 0),
('2020-06-15', 'DIEGO', 'dsadsa', 0),
('2020-06-16', 'DIEGO', 'dsadsa', 0),
('2020-06-17', 'DIEGO', 'dsadsa', 0),
('2020-06-18', 'DIEGO', 'dsadsa', 0),
('2020-06-19', 'DIEGO', 'dsadsa', 0),
('2020-06-29', 'Patatas fritas con pechugas', 'Tortilla', 0),
('2020-07-01', 'Paella', 'Merluza', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` int(11) NOT NULL,
  `dia` date DEFAULT NULL,
  `titulo` varchar(60) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `dia`, `titulo`, `descripcion`) VALUES
(19, '2020-06-15', 'idjoeiwjdoeiw', 'dmewljdewpoijdmewd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `residente` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `dia` date NOT NULL,
  `extension` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `mes` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correcto` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parte`
--

CREATE TABLE `parte` (
  `id` int(11) NOT NULL,
  `residente` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `gravedad` int(11) NOT NULL,
  `motivo` text COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `parte`
--

INSERT INTO `parte` (`id`, `residente`, `gravedad`, `motivo`) VALUES
(27, 'director1111a@directora.es', 0, 'efsdczx'),
(28, 'residente@residente.es', 0, 'dsadsa'),
(29, 'residente@residente.es', 1, 'dsadsa'),
(30, 'residente@residente.es', 1, 'dsadsa'),
(31, 'residente@residente.es', 2, 'dsadsa'),
(32, 'residente@residente.es', 2, 'dsadsa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permanencia`
--

CREATE TABLE `permanencia` (
  `id` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `residente` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `dia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `email` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `dni` varchar(9) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `f_nac` date DEFAULT NULL,
  `contraseña` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rol` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`email`, `nombre`, `apellidos`, `dni`, `f_nac`, `contraseña`, `rol`) VALUES
('cocinera@cocinera.es', 'Cocinera', 'Cocinera Oficial', '77013276F', '1111-11-11', 'Cocinera1234.', 2),
('dewldew@lfmwefew.es', 'dew', 'dwed dwedw', '77013276F', '2020-06-12', 'dewdewA1.', 0),
('director1111a@directora.es', 'Jose', 'Vazquez dewdew', '77013276F', '2020-06-16', 'Directora1234.', 3),
('dwqdewdew@ofikwe.es', 'dewdew', 'dewdew dewdew', '77013276F', '2020-06-20', 'fjdslfjdsl1aaA', 0),
('lusky1991116@gmail.com', 'dewdewd dew', 'dwedweddew dw', '77013276F', '2020-06-15', 'fjdslfjdslaAaa1', 0),
('lusky199111s6@gmail.com', 'Jose', 'Vazquez dewdew', '77013276A', '2020-06-23', 'fdsjklA1', 3),
('lusky199116@gmail.com', 'dewdew', 'dewdewd dewdewdew', '77013276F', '2020-06-19', 'dasassasdA1', 0),
('lusky19916@gmail.com', 'DEWDEW', 'dewde dewdew', '77013276F', '2020-06-12', 'dewdeA1.', 0),
('lusky1996@gmail.com', 'Diego', 'Lusquiños Otero', '77013276F', '2020-06-10', 'Directora1234.', 3),
('lusky1996@gmail.com11', 'Manuel', 'Varela Diaz', '77013276F', '2020-06-11', 'fjdslfjdslA1', 3),
('lusky1996@gmail.com22323', 'dewdew', 'dewdew dew', '77013276F', '2020-06-19', 'FSDaa1.a', 0),
('lusky1996dazx@gmail.com', 'dew', 'dwe dewd', '77013276A', '2020-06-25', 'fjdslfjdslaA1', 4),
('lusky1996ddd@gmail.com', 'dsadsa', 'dsad dsadsa', '77013276F', '2020-06-15', 'dsakjna1A', 4),
('lusky1996dwq@gmail.com', 'Jose', 'Vazquez dsa', '77013276F', '2020-06-18', 'fjdslfjdslA1.', 3),
('lusky1998@gmail.com', 'Jose', 'Vazquez dwe', '77013276A', '2020-06-11', 'fjdslfjdslA1', 0),
('residente@residente.es', 'Jose', 'Vazquez dewdew', '77013276F', '2020-06-16', 'Residente1234.', 3),
('secretaria@secretaria.es', 'directora', 'directora directora', '77013276F', '2020-06-01', 'Secretaria1234.', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`residente`,`dia`),
  ADD KEY `dia_menu_asistencia` (`dia`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `res_residente1_habitacion` (`residente1`),
  ADD KEY `res_residente2_habitacion` (`residente2`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`dia`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residente_pago` (`residente`);

--
-- Indices de la tabla `parte`
--
ALTER TABLE `parte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parte_usuario` (`residente`);

--
-- Indices de la tabla `permanencia`
--
ALTER TABLE `permanencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residente_permanencia` (`residente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `parte`
--
ALTER TABLE `parte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `dia_menu_asistencia` FOREIGN KEY (`dia`) REFERENCES `menu` (`dia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_residentes_aistencia` FOREIGN KEY (`residente`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `res_residente1_habitacion` FOREIGN KEY (`residente1`) REFERENCES `usuario` (`email`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `res_residente2_habitacion` FOREIGN KEY (`residente2`) REFERENCES `usuario` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `residente_pago` FOREIGN KEY (`residente`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parte`
--
ALTER TABLE `parte`
  ADD CONSTRAINT `parte_usuario` FOREIGN KEY (`residente`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permanencia`
--
ALTER TABLE `permanencia`
  ADD CONSTRAINT `residente_permanencia` FOREIGN KEY (`residente`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
