-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-08-2020 a las 01:12:01
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `modulo_consultas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `dni` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `recupera_contraseña` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`dni`, `nombre`, `apellido`, `email`, `contraseña`, `recupera_contraseña`) VALUES
('40363860', 'OrneAdmin', 'CorseAdmin', 'orcorsetti@gmail.com', 'ocorsetti', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `legajo` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de Alumnos Cargados';

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`legajo`, `nombre`, `apellido`, `email`) VALUES
('44034', 'Ornela', 'Corsetti', 'orcorsetti@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `cod_con` int(11) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  `hora` time NOT NULL,
  `dia_semana` int(11) NOT NULL,
  `cod_mat` int(11) NOT NULL,
  `dni` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `dni` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `recupera_contraseña` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`dni`, `nombre`, `apellido`, `email`, `contraseña`, `recupera_contraseña`) VALUES
('40363860', 'OrneDocente', 'CorsettiDocente', 'orcorsetti@gmail.com', 'ocorsetti', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incripciones`
--

CREATE TABLE `incripciones` (
  `legajo` varchar(15) NOT NULL,
  `cod_con` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `cod_mat` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `año_cursado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mat_doc`
--

CREATE TABLE `mat_doc` (
  `cod_mat` int(11) NOT NULL,
  `dni` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `recupera_contraseña` (`recupera_contraseña`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`legajo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`cod_con`),
  ADD KEY `fk_mat_doc` (`cod_mat`,`dni`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `recupera_contraseña` (`recupera_contraseña`);

--
-- Indices de la tabla `incripciones`
--
ALTER TABLE `incripciones`
  ADD PRIMARY KEY (`legajo`,`cod_con`,`fecha_creacion`) USING BTREE,
  ADD KEY `fk_consultas` (`cod_con`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`cod_mat`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `mat_doc`
--
ALTER TABLE `mat_doc`
  ADD PRIMARY KEY (`cod_mat`,`dni`),
  ADD KEY `fk_docentes` (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `cod_con` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `cod_mat` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `fk_mat_Doc` FOREIGN KEY (`cod_mat`,`dni`) REFERENCES `mat_doc` (`cod_mat`, `dni`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `incripciones`
--
ALTER TABLE `incripciones`
  ADD CONSTRAINT `fk_alumnos` FOREIGN KEY (`legajo`) REFERENCES `alumnos` (`legajo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consultas` FOREIGN KEY (`cod_con`) REFERENCES `consultas` (`cod_con`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `mat_doc`
--
ALTER TABLE `mat_doc`
  ADD CONSTRAINT `fk_docentes` FOREIGN KEY (`dni`) REFERENCES `docentes` (`dni`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_materias` FOREIGN KEY (`cod_mat`) REFERENCES `materias` (`cod_mat`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
