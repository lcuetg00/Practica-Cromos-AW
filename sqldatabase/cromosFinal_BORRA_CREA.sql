-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.25-0ubuntu0.20.04.1 - (Ubuntu)
-- SO del servidor:              Linux
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para cromos
DROP DATABASE IF EXISTS `cromos`;
CREATE DATABASE IF NOT EXISTS `cromos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cromos`;

-- Volcando estructura para tabla cromos.album
DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `IdAlbum` int unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Precio` double NOT NULL DEFAULT '0',
  `IdColeccion` int unsigned NOT NULL,
  PRIMARY KEY (`IdAlbum`,`IdColeccion`),
  KEY `fk_coleccion_album` (`IdColeccion`),
  CONSTRAINT `fk_coleccion_album` FOREIGN KEY (`IdColeccion`) REFERENCES `coleccion` (`IdColeccion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla cromos.coleccion
DROP TABLE IF EXISTS `coleccion`;
CREATE TABLE IF NOT EXISTS `coleccion` (
  `IdColeccion` int unsigned NOT NULL AUTO_INCREMENT,
  `Estado` enum('Activo','Inactivo') NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`IdColeccion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla cromos.cromo
DROP TABLE IF EXISTS `cromo`;
CREATE TABLE IF NOT EXISTS `cromo` (
  `IdCromo` int unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `UnidadesDisponibles` int unsigned NOT NULL,
  `Imagen` blob NOT NULL,
  `Precio` double NOT NULL,
  `IdColeccion` int unsigned NOT NULL,
  PRIMARY KEY (`IdCromo`,`IdColeccion`),
  KEY `fk_coleccion_cromo` (`IdColeccion`),
  CONSTRAINT `fk_coleccion_cromo` FOREIGN KEY (`IdColeccion`) REFERENCES `coleccion` (`IdColeccion`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla cromos.poseealbum
DROP TABLE IF EXISTS `poseealbum`;
CREATE TABLE IF NOT EXISTS `poseealbum` (
  `IdAlbum` int unsigned NOT NULL,
  `IdSocio` int unsigned NOT NULL,
  PRIMARY KEY (`IdAlbum`,`IdSocio`),
  KEY `fk_poseealbum_socio` (`IdSocio`),
  CONSTRAINT `fk_poseealbum_album` FOREIGN KEY (`IdAlbum`) REFERENCES `album` (`IdAlbum`) ON UPDATE CASCADE,
  CONSTRAINT `fk_poseealbum_socio` FOREIGN KEY (`IdSocio`) REFERENCES `socio` (`IdSocio`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla cromos.poseecromo
DROP TABLE IF EXISTS `poseecromo`;
CREATE TABLE IF NOT EXISTS `poseecromo` (
  `IdCromo` int unsigned NOT NULL,
  `IdSocio` int unsigned NOT NULL,
  `Cantidad` int unsigned NOT NULL,
  PRIMARY KEY (`IdCromo`,`IdSocio`),
  KEY `fk_poseecromo_socio` (`IdSocio`),
  CONSTRAINT `fk_poseecromo_cromo` FOREIGN KEY (`IdCromo`) REFERENCES `cromo` (`IdCromo`) ON UPDATE CASCADE,
  CONSTRAINT `fk_poseecromo_socio` FOREIGN KEY (`IdSocio`) REFERENCES `socio` (`IdSocio`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla cromos.socio
DROP TABLE IF EXISTS `socio`;
CREATE TABLE IF NOT EXISTS `socio` (
  `IdSocio` int unsigned NOT NULL AUTO_INCREMENT,
  `Saldo` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdSocio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
