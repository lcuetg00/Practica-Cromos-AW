-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2021 a las 03:41:03
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cromos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE `album` (
  `IdAlbum` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Precio` double NOT NULL DEFAULT 0,
  `IdColeccion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coleccion`
--

CREATE TABLE `coleccion` (
  `IdColeccion` int(10) UNSIGNED NOT NULL,
  `Estado` enum('Activo','Inactivo') NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cromo`
--

CREATE TABLE `cromo` (
  `IdCromo` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `UnidadesDisponibles` int(10) UNSIGNED NOT NULL,
  `Imagen` blob NOT NULL,
  `Precio` double NOT NULL,
  `IdColeccion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poseealbum`
--

CREATE TABLE `poseealbum` (
  `IdAlbum` int(10) UNSIGNED NOT NULL,
  `IdSocio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poseecromo`
--

CREATE TABLE `poseecromo` (
  `IdCromo` int(10) UNSIGNED NOT NULL,
  `IdSocio` int(10) UNSIGNED NOT NULL,
  `Cantidad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `IdSocio` int(10) UNSIGNED NOT NULL,
  `Saldo` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`IdAlbum`,`IdColeccion`),
  ADD KEY `fk_coleccion_album` (`IdColeccion`);

--
-- Indices de la tabla `coleccion`
--
ALTER TABLE `coleccion`
  ADD PRIMARY KEY (`IdColeccion`);

--
-- Indices de la tabla `cromo`
--
ALTER TABLE `cromo`
  ADD PRIMARY KEY (`IdCromo`,`IdColeccion`),
  ADD KEY `fk_coleccion_cromo` (`IdColeccion`);

--
-- Indices de la tabla `poseealbum`
--
ALTER TABLE `poseealbum`
  ADD PRIMARY KEY (`IdAlbum`,`IdSocio`),
  ADD KEY `fk_poseealbum_socio` (`IdSocio`);

--
-- Indices de la tabla `poseecromo`
--
ALTER TABLE `poseecromo`
  ADD PRIMARY KEY (`IdCromo`,`IdSocio`),
  ADD KEY `fk_poseecromo_socio` (`IdSocio`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`IdSocio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `album`
--
ALTER TABLE `album`
  MODIFY `IdAlbum` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coleccion`
--
ALTER TABLE `coleccion`
  MODIFY `IdColeccion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cromo`
--
ALTER TABLE `cromo`
  MODIFY `IdCromo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `IdSocio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_coleccion_album` FOREIGN KEY (`IdColeccion`) REFERENCES `coleccion` (`IdColeccion`);

--
-- Filtros para la tabla `cromo`
--
ALTER TABLE `cromo`
  ADD CONSTRAINT `fk_coleccion_cromo` FOREIGN KEY (`IdColeccion`) REFERENCES `coleccion` (`IdColeccion`);

--
-- Filtros para la tabla `poseealbum`
--
ALTER TABLE `poseealbum`
  ADD CONSTRAINT `fk_poseealbum_album` FOREIGN KEY (`IdAlbum`) REFERENCES `album` (`IdAlbum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_poseealbum_socio` FOREIGN KEY (`IdSocio`) REFERENCES `socio` (`IdSocio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `poseecromo`
--
ALTER TABLE `poseecromo`
  ADD CONSTRAINT `fk_poseecromo_cromo` FOREIGN KEY (`IdCromo`) REFERENCES `cromo` (`IdCromo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_poseecromo_socio` FOREIGN KEY (`IdSocio`) REFERENCES `socio` (`IdSocio`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
