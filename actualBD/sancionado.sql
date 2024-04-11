/*
 Navicat Premium Data Transfer

 Source Server         : bd
 Source Server Type    : MySQL
 Source Server Version : 80200 (8.2.0)
 Source Host           : localhost:3306
 Source Schema         : sancionado

 Target Server Type    : MySQL
 Target Server Version : 80200 (8.2.0)
 File Encoding         : 65001

 Date: 10/04/2024 15:33:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for catalogo_autoridades
-- ----------------------------
DROP TABLE IF EXISTS `catalogo_autoridades`;
CREATE TABLE `catalogo_autoridades` (
  `id_catalogo_autoridades` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_autoridad` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_catalogo_autoridades`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of catalogo_autoridades
-- ----------------------------
BEGIN;
INSERT INTO `catalogo_autoridades` (`id_catalogo_autoridades`, `nombre_autoridad`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (74, 'Autoridad Sancionadora', 0, '2024-04-08 23:31:30', '2024-04-08 23:31:30', NULL);
COMMIT;

-- ----------------------------
-- Table structure for catalogo_dependencia
-- ----------------------------
DROP TABLE IF EXISTS `catalogo_dependencia`;
CREATE TABLE `catalogo_dependencia` (
  `id_catalogo_dependecia` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_dependencia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nomenclatura` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_catalogo_dependecia`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of catalogo_dependencia
-- ----------------------------
BEGIN;
INSERT INTO `catalogo_dependencia` (`id_catalogo_dependecia`, `nombre_dependencia`, `nomenclatura`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (102, 'dependencia ficticia', 'depfic', 0, '2024-04-08 23:32:12', '2024-04-08 23:32:12', NULL);
COMMIT;

-- ----------------------------
-- Table structure for catalogo_sanciones
-- ----------------------------
DROP TABLE IF EXISTS `catalogo_sanciones`;
CREATE TABLE `catalogo_sanciones` (
  `id_catalogo_sanciones` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_sancion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_catalogo_sanciones`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of catalogo_sanciones
-- ----------------------------
BEGIN;
INSERT INTO `catalogo_sanciones` (`id_catalogo_sanciones`, `nombre_sancion`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (44, 'Sancion impuesta', 0, '2024-04-08 23:31:48', '2024-04-08 23:31:48', NULL);
COMMIT;

-- ----------------------------
-- Table structure for inpugnacion
-- ----------------------------
DROP TABLE IF EXISTS `inpugnacion`;
CREATE TABLE `inpugnacion` (
  `id_inpugnacion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_sancionado` bigint unsigned NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `numero_expediente` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipo` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_inpugnacion`) USING BTREE,
  KEY `id_sancionado` (`id_sancionado`) USING BTREE,
  CONSTRAINT `inpugnacion_ibfk_1` FOREIGN KEY (`id_sancionado`) REFERENCES `sancionados` (`id_sancionado`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of inpugnacion
-- ----------------------------
BEGIN;
INSERT INTO `inpugnacion` (`id_inpugnacion`, `id_sancionado`, `fecha_resolucion`, `numero_expediente`, `tipo`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (14, 13, '2024-04-10', 'expediente/prueba/1234', 'Privada', 0, '2024-04-08 23:34:59', '2024-04-08 23:34:59', NULL);
COMMIT;

-- ----------------------------
-- Table structure for observaciones
-- ----------------------------
DROP TABLE IF EXISTS `observaciones`;
CREATE TABLE `observaciones` (
  `id_observacion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_inpugnacion` bigint unsigned NOT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_observacion`) USING BTREE,
  KEY `id_inpugnacion` (`id_inpugnacion`) USING BTREE,
  CONSTRAINT `observaciones_ibfk_1` FOREIGN KEY (`id_inpugnacion`) REFERENCES `inpugnacion` (`id_inpugnacion`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of observaciones
-- ----------------------------
BEGIN;
INSERT INTO `observaciones` (`id_observacion`, `observacion`, `id_inpugnacion`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 14, 0, '2024-04-08 23:34:59', '2024-04-08 23:34:59', NULL);
COMMIT;

-- ----------------------------
-- Table structure for personas_sancionadas
-- ----------------------------
DROP TABLE IF EXISTS `personas_sancionadas`;
CREATE TABLE `personas_sancionadas` (
  `id_persona_sancionada` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `curp` varchar(18) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rfc` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_persona_sancionada`) USING BTREE,
  UNIQUE KEY `curp_UNIQUE` (`curp`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of personas_sancionadas
-- ----------------------------
BEGIN;
INSERT INTO `personas_sancionadas` (`id_persona_sancionada`, `nombre_completo`, `apellidos`, `curp`, `rfc`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (57, 'Ricardo', 'Garcia Garcia', 'GAGG941124HOCRRL01', 'GOVM860812QA2', 0, '2024-04-08 23:33:15', '2024-04-08 23:33:15', NULL);
COMMIT;

-- ----------------------------
-- Table structure for sancionados
-- ----------------------------
DROP TABLE IF EXISTS `sancionados`;
CREATE TABLE `sancionados` (
  `id_sancionado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_catalogo_autoridades` smallint unsigned NOT NULL,
  `id_catalogo_sancionados` smallint unsigned NOT NULL,
  `id_persona_sancionada` bigint unsigned NOT NULL,
  `id_catalogo_dependencia` bigint unsigned NOT NULL,
  `id_user` bigint unsigned NOT NULL,
  `cargo_servidor_publico` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `numero_expediente` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `observaciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fecha_resolucion` date NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `duracion_resolucion` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `monto` decimal(10,0) DEFAULT NULL,
  `deprecated` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sancionado`) USING BTREE,
  KEY `id_catalogo_autoridades` (`id_catalogo_autoridades`) USING BTREE,
  KEY `id_catalogo_sancionados` (`id_catalogo_sancionados`) USING BTREE,
  KEY `id_persona_sancionada` (`id_persona_sancionada`) USING BTREE,
  KEY `id_user` (`id_user`) USING BTREE,
  KEY `id_catalogo_dependencia` (`id_catalogo_dependencia`) USING BTREE,
  CONSTRAINT `sancionados_ibfk_1` FOREIGN KEY (`id_catalogo_autoridades`) REFERENCES `catalogo_autoridades` (`id_catalogo_autoridades`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sancionados_ibfk_2` FOREIGN KEY (`id_catalogo_sancionados`) REFERENCES `catalogo_sanciones` (`id_catalogo_sanciones`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sancionados_ibfk_3` FOREIGN KEY (`id_persona_sancionada`) REFERENCES `personas_sancionadas` (`id_persona_sancionada`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sancionados_ibfk_4` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sancionados_ibfk_5` FOREIGN KEY (`id_catalogo_dependencia`) REFERENCES `catalogo_dependencia` (`id_catalogo_dependecia`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sancionados
-- ----------------------------
BEGIN;
INSERT INTO `sancionados` (`id_sancionado`, `id_catalogo_autoridades`, `id_catalogo_sancionados`, `id_persona_sancionada`, `id_catalogo_dependencia`, `id_user`, `cargo_servidor_publico`, `numero_expediente`, `observaciones`, `fecha_resolucion`, `fecha_inicio`, `fecha_termino`, `duracion_resolucion`, `monto`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (13, 74, 44, 57, 102, 7, 'Jefe de departamento', 'EXP/12/PRUEBA', 'PRUEBA PRUEBA', '2024-04-20', '2022-08-18', NULL, NULL, NULL, 0, '2024-04-08 23:33:15', '2024-04-08 23:35:34', NULL);
INSERT INTO `sancionados` (`id_sancionado`, `id_catalogo_autoridades`, `id_catalogo_sancionados`, `id_persona_sancionada`, `id_catalogo_dependencia`, `id_user`, `cargo_servidor_publico`, `numero_expediente`, `observaciones`, `fecha_resolucion`, `fecha_inicio`, `fecha_termino`, `duracion_resolucion`, `monto`, `deprecated`, `created_at`, `updated_at`, `deleted_at`) VALUES (14, 74, 44, 57, 102, 7, 'COORDINADOR', 'expediente/nuevo/697', NULL, '2024-04-10', NULL, NULL, '10 meses', 23435435, 0, '2024-04-08 23:33:59', '2024-04-08 23:33:59', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `email`, `cargo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (5, 'ADMIN', 'admin@admin.com', 'Administrador', NULL, '$2y$10$6hrPn.HoY4bORmNSwWP1ueuj.yajqcVC0/62T4yP3kWHmjIG4.b9.', NULL, '2023-11-14 19:30:17', '2023-11-14 19:30:17');
INSERT INTO `users` (`id`, `name`, `email`, `cargo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (7, 'Joaquin', 'admin.24@gmail.com', 'Administrador', NULL, '$2y$10$RpnTMl9uMo0joABCkbERSu9k4NFwWPrDOBE/28QUuTJBpQr1O.vEe', NULL, '2024-02-12 19:56:43', '2024-02-12 19:56:43');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
