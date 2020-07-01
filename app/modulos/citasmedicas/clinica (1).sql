-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-06-2020 a las 07:54:48
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `fecha_de_registro` datetime NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `hora_cita` time NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `id_especialista` int(11) NOT NULL,
  `padecimiento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha_cita`, `fecha_de_registro`, `id_paciente`, `hora_cita`, `id_especialidad`, `id_especialista`, `padecimiento`) VALUES
(40, '2020-06-26', '2020-06-22 00:37:34', 1, '15:00:00', 2, 2, 'el duende verde lo hizo');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `citas_medicas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `citas_medicas` (
`apellido_especialista` varchar(20)
,`apellido_paciente` varchar(20)
,`cedula_especialista` int(10)
,`cedula_paciente` int(11)
,`fecha_cita` date
,`fecha_de_registro` datetime
,`hora_cita` time
,`id_especialidad` int(11)
,`id_especialista` int(11)
,`id_paciente` int(11)
,`nombre_especialidad` varchar(20)
,`nombre_especialista` varchar(20)
,`nombre_paciente` varchar(20)
,`padecimiento` text
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id_especialidad` int(11) NOT NULL,
  `nombre_especialidad` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id_especialidad`, `nombre_especialidad`) VALUES
(2, 'Bailarina xD'),
(3, 'Cantante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialista`
--

CREATE TABLE `especialista` (
  `id_especialista` int(11) NOT NULL,
  `nombre_especialista` varchar(20) NOT NULL,
  `apellido_especialista` varchar(20) NOT NULL,
  `cedula_especialista` int(10) NOT NULL,
  `id_especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `especialista`
--

INSERT INTO `especialista` (`id_especialista`, `nombre_especialista`, `apellido_especialista`, `cedula_especialista`, `id_especialidad`) VALUES
(2, 'Steven', 'Vazques', 957943830, 2),
(5, 'Carlos', 'Rodriguez', 957943855, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `nombre_paciente` varchar(20) NOT NULL,
  `apellido_paciente` varchar(20) NOT NULL,
  `cedula_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nombre_paciente`, `apellido_paciente`, `cedula_paciente`) VALUES
(1, 'ariel', 'farfan', 957943855);

-- --------------------------------------------------------

--
-- Estructura para la vista `citas_medicas`
--
DROP TABLE IF EXISTS `citas_medicas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `citas_medicas`  AS  select `pa`.`id_paciente` AS `id_paciente`,`pa`.`nombre_paciente` AS `nombre_paciente`,`pa`.`apellido_paciente` AS `apellido_paciente`,`pa`.`cedula_paciente` AS `cedula_paciente`,`ci`.`fecha_cita` AS `fecha_cita`,`ci`.`fecha_de_registro` AS `fecha_de_registro`,`ci`.`hora_cita` AS `hora_cita`,`ci`.`padecimiento` AS `padecimiento`,`esp`.`id_especialidad` AS `id_especialidad`,`esp`.`nombre_especialidad` AS `nombre_especialidad`,`especi`.`id_especialista` AS `id_especialista`,`especi`.`nombre_especialista` AS `nombre_especialista`,`especi`.`apellido_especialista` AS `apellido_especialista`,`especi`.`cedula_especialista` AS `cedula_especialista` from (((`cita` `ci` join `paciente` `pa` on((`pa`.`id_paciente` = `ci`.`id_paciente`))) join `especialidad` `esp` on((`ci`.`id_especialidad` = `esp`.`id_especialidad`))) join `especialista` `especi` on((`ci`.`id_especialista` = `especi`.`id_especialista`))) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_especialidad` (`id_especialidad`),
  ADD KEY `id_especialista` (`id_especialista`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `especialista`
--
ALTER TABLE `especialista`
  ADD PRIMARY KEY (`id_especialista`),
  ADD UNIQUE KEY `cedula_especialista` (`cedula_especialista`),
  ADD KEY `id_especialidad` (`id_especialidad`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `especialista`
--
ALTER TABLE `especialista`
  MODIFY `id_especialista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`id_especialista`) REFERENCES `especialista` (`id_especialista`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `especialista`
--
ALTER TABLE `especialista`
  ADD CONSTRAINT `especialista_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
