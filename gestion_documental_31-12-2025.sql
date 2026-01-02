-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-12-2025 a las 17:29:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_documental`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_control`
--

CREATE TABLE `area_control` (
  `area_id` varchar(50) NOT NULL,
  `area_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditlog`
--

CREATE TABLE `auditlog` (
  `audit_id` varchar(50) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `document_id` varchar(50) NOT NULL,
  `version_id` varchar(50) NOT NULL,
  `details` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distributionlist`
--

CREATE TABLE `distributionlist` (
  `distribution_id` varchar(50) NOT NULL,
  `document_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `notified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document`
--

CREATE TABLE `document` (
  `document_id` varchar(50) NOT NULL,
  `owner_user_id` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `cost_center` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `area_id` varchar(50) NOT NULL,
  `type_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentapproval`
--

CREATE TABLE `documentapproval` (
  `approval_id` varchar(50) NOT NULL,
  `version_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `role_at_approval` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comments` varchar(250) NOT NULL,
  `action_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documenttype`
--

CREATE TABLE `documenttype` (
  `type_id` varchar(50) NOT NULL,
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentversion`
--

CREATE TABLE `documentversion` (
  `version_id` varchar(50) NOT NULL,
  `document_id` varchar(50) NOT NULL,
  `version_number` varchar(50) NOT NULL,
  `change_reason` varchar(150) NOT NULL,
  `file_path` varchar(250) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `is_current` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `externaldocument`
--

CREATE TABLE `externaldocument` (
  `external_doc_id` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `source` varchar(50) NOT NULL,
  `valid_from` varchar(50) NOT NULL,
  `valid_to` varchar(50) NOT NULL,
  `responsible_user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `module` varchar(10) NOT NULL,
  `name_module` varchar(40) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `role_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `rut_trab` varchar(12) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `quality` varchar(5) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`rut_trab`, `user_id`, `user_name`, `last_name`, `email`, `active`, `quality`, `pass`) VALUES
('763138399', 'ADM01', 'Administrador', 'Administrador', 'vpavez@tymelectricos.cl', 1, 'ADMIN', '$2y$10$8F7OjZFDQGAtiwVi9VSHjOjeoH4TnNi/GERdWVKQUwW2VSkGrJzG6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userrole`
--

CREATE TABLE `userrole` (
  `user_id` varchar(50) NOT NULL,
  `role_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_movement`
--

CREATE TABLE `user_movement` (
  `rut_trab` varchar(12) NOT NULL,
  `module` varchar(10) NOT NULL,
  `permit` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area_control`
--
ALTER TABLE `area_control`
  ADD PRIMARY KEY (`area_id`);

--
-- Indices de la tabla `auditlog`
--
ALTER TABLE `auditlog`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `version_id` (`version_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indices de la tabla `distributionlist`
--
ALTER TABLE `distributionlist`
  ADD PRIMARY KEY (`distribution_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indices de la tabla `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `owner_user_id` (`owner_user_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indices de la tabla `documentapproval`
--
ALTER TABLE `documentapproval`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `version_id` (`version_id`);

--
-- Indices de la tabla `documenttype`
--
ALTER TABLE `documenttype`
  ADD PRIMARY KEY (`type_id`);

--
-- Indices de la tabla `documentversion`
--
ALTER TABLE `documentversion`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `document_id` (`document_id`);

--
-- Indices de la tabla `externaldocument`
--
ALTER TABLE `externaldocument`
  ADD PRIMARY KEY (`external_doc_id`),
  ADD KEY `responsible_user_id` (`responsible_user_id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `DELETE USER MOVEMENTS` (`rut_trab`);

--
-- Indices de la tabla `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indices de la tabla `user_movement`
--
ALTER TABLE `user_movement`
  ADD PRIMARY KEY (`rut_trab`),
  ADD UNIQUE KEY `rut_trab` (`rut_trab`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditlog`
--
ALTER TABLE `auditlog`
  ADD CONSTRAINT `auditlog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `auditlog_ibfk_2` FOREIGN KEY (`version_id`) REFERENCES `documentversion` (`version_id`),
  ADD CONSTRAINT `auditlog_ibfk_3` FOREIGN KEY (`document_id`) REFERENCES `document` (`document_id`);

--
-- Filtros para la tabla `distributionlist`
--
ALTER TABLE `distributionlist`
  ADD CONSTRAINT `distributionlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `distributionlist_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `document` (`document_id`);

--
-- Filtros para la tabla `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`owner_user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `document_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area_control` (`area_id`),
  ADD CONSTRAINT `document_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `documenttype` (`type_id`);

--
-- Filtros para la tabla `documentapproval`
--
ALTER TABLE `documentapproval`
  ADD CONSTRAINT `documentapproval_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `documentapproval_ibfk_2` FOREIGN KEY (`version_id`) REFERENCES `documentversion` (`version_id`);

--
-- Filtros para la tabla `documentversion`
--
ALTER TABLE `documentversion`
  ADD CONSTRAINT `documentversion_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `documentversion_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `document` (`document_id`);

--
-- Filtros para la tabla `externaldocument`
--
ALTER TABLE `externaldocument`
  ADD CONSTRAINT `externaldocument_ibfk_1` FOREIGN KEY (`responsible_user_id`) REFERENCES `user` (`user_id`);

--
-- Filtros para la tabla `userrole`
--
ALTER TABLE `userrole`
  ADD CONSTRAINT `userrole_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `userrole_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
