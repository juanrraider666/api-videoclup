/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : db_api_videoclub

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 12/12/2021 19:06:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for film
-- ----------------------------
DROP TABLE IF EXISTS `film`;
CREATE TABLE `film`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `film_type_id` int(11) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` int(11) NULL DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL,
  `created_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_8244BE2225F297B0`(`film_type_id`) USING BTREE,
  CONSTRAINT `FK_8244BE2225F297B0` FOREIGN KEY (`film_type_id`) REFERENCES `film_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of film
-- ----------------------------
INSERT INTO `film` VALUES (1, 1, 'A Quiet Place Part II', 'aliens have invaded earth and the only way to stay safe is to never make a sound. How do you do it all over again when the novelty is gone?', 3, 1, '2021-12-11 20:37:16', '2021-12-11 20:37:16', NULL);
INSERT INTO `film` VALUES (2, 2, 'Oasis Knebworth 1996', 'The unofficial sequel to 2016’s Supersonic, the beloved documentary that charted the Gallagher brothers’ rise, picks up where that film left off, delving into the story behind two of Britain’s biggest rock concerts.', 3, 1, '2021-12-12 20:42:13', '2021-12-12 20:42:13', NULL);
INSERT INTO `film` VALUES (3, 3, 'Censor', 'It’s hard to believe that Censor is Prano Bailey-Bond’s first movie. It arrives with such a certain vision and such a clear, well-built idea that it promises very good things to come from her.', 3, 1, '2021-12-12 18:25:28', '2021-12-12 18:25:28', NULL);

-- ----------------------------
-- Table structure for film_owner_relation
-- ----------------------------
DROP TABLE IF EXISTS `film_owner_relation`;
CREATE TABLE `film_owner_relation`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NULL DEFAULT NULL,
  `film_listings_id` int(11) NULL DEFAULT NULL,
  `point_value` int(11) NULL DEFAULT NULL,
  `rent_start_day` datetime(0) NULL DEFAULT NULL,
  `rent_end_day` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `IDX_9AA5D89E7E3C61F9`(`owner_id`) USING BTREE,
  INDEX `IDX_9AA5D89E627F08CD`(`film_listings_id`) USING BTREE,
  CONSTRAINT `FK_9AA5D89E627F08CD` FOREIGN KEY (`film_listings_id`) REFERENCES `film` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_9AA5D89E7E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of film_owner_relation
-- ----------------------------
INSERT INTO `film_owner_relation` VALUES (1, 1, 1, 2, '2021-12-12 23:00:58', NULL);
INSERT INTO `film_owner_relation` VALUES (2, 1, 1, 2, '2021-12-12 23:00:58', NULL);
INSERT INTO `film_owner_relation` VALUES (3, 1, 1, 2, '2021-12-12 23:06:09', NULL);
INSERT INTO `film_owner_relation` VALUES (4, 1, 1, 2, '2021-12-12 23:06:09', NULL);
INSERT INTO `film_owner_relation` VALUES (5, 1, 2, 1, '2021-12-12 23:11:23', NULL);
INSERT INTO `film_owner_relation` VALUES (6, 1, 2, 1, '2021-12-12 23:12:07', NULL);
INSERT INTO `film_owner_relation` VALUES (7, 1, 1, 2, '2021-12-12 23:13:28', NULL);
INSERT INTO `film_owner_relation` VALUES (8, 1, 1, 2, '2021-12-12 23:13:28', NULL);
INSERT INTO `film_owner_relation` VALUES (9, 1, 1, 2, '2021-12-12 23:14:36', NULL);
INSERT INTO `film_owner_relation` VALUES (10, 1, 1, 2, '2021-12-12 23:14:36', NULL);
INSERT INTO `film_owner_relation` VALUES (11, 1, 2, 1, '2021-12-12 23:14:51', NULL);
INSERT INTO `film_owner_relation` VALUES (12, 1, 2, 1, '2021-12-12 23:16:05', NULL);
INSERT INTO `film_owner_relation` VALUES (13, 1, 2, 1, '2021-12-12 23:22:34', NULL);
INSERT INTO `film_owner_relation` VALUES (14, 1, 2, 1, '2021-12-12 23:22:47', NULL);
INSERT INTO `film_owner_relation` VALUES (15, 1, 2, 1, '2021-12-12 23:23:31', NULL);
INSERT INTO `film_owner_relation` VALUES (16, 1, 2, 1, '2021-12-12 23:23:45', NULL);

-- ----------------------------
-- Table structure for film_type
-- ----------------------------
DROP TABLE IF EXISTS `film_type`;
CREATE TABLE `film_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `visible` tinyint(1) NULL DEFAULT 0,
  `created_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `point` int(11) NULL DEFAULT NULL,
  `valid_days` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of film_type
-- ----------------------------
INSERT INTO `film_type` VALUES (1, 'Nuevos lanzamientos', 1, 1, '2021-12-11 19:33:48', '2021-12-11 19:33:48', NULL, 2, 1);
INSERT INTO `film_type` VALUES (2, 'Películas normales', 1, 1, '2021-12-11 19:33:56', '2021-12-11 19:33:56', NULL, 1, 3);
INSERT INTO `film_type` VALUES (3, 'Películas viejas', 1, 1, '2021-12-11 19:34:03', '2021-12-11 19:34:03', NULL, 1, 5);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UNIQ_8D93D649E7927C74`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'juan@dev.com', '[]', '$2y$13$XNRZLYN2MVmEWCNCkmywbeHdOKM081xLa7sdBvkeJXoI.d9U.tKzm');

SET FOREIGN_KEY_CHECKS = 1;
