/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : 127.0.0.1:3306
 Source Schema         : fruitadmin

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 03/03/2019 23:30:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens`  (
  `access_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`access_token`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
INSERT INTO `oauth_access_tokens` VALUES ('e05551f5b64b44c2b09bbff0262fb5127a8028c0', 'testclient', NULL, '2019-02-24 00:43:13', NULL);
INSERT INTO `oauth_access_tokens` VALUES ('2470a4f577db5c01567eba6d1a5fca8c9efea537', 'testclient', NULL, '2019-02-24 00:46:37', NULL);
INSERT INTO `oauth_access_tokens` VALUES ('832a22c13d0f0eade4bf7680560935136f81c73c', 'testclient', NULL, '2019-02-24 00:51:05', NULL);
INSERT INTO `oauth_access_tokens` VALUES ('f82b90217f39bb9817d5f55534c320516456c86e', 'testclient', NULL, '2019-02-24 01:16:25', NULL);

-- ----------------------------
-- Table structure for oauth_authorization_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_authorization_codes`;
CREATE TABLE `oauth_authorization_codes`  (
  `authorization_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `redirect_uri` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_token` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`authorization_code`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_authorization_codes
-- ----------------------------
INSERT INTO `oauth_authorization_codes` VALUES ('51803b0483863fa245bb264a2a8b94ec1aa6ba7c', 'testclient', NULL, NULL, '2019-02-22 12:36:11', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('b4a5b6837ad3dfe21f9cb79f3c9b53e23ce58be5', 'testclient', NULL, NULL, '2019-02-23 09:14:29', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('59a5c932c6c2036b3433d54e2fbad0965c330bc9', 'testclient', NULL, NULL, '2019-02-23 22:22:44', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('da5ab14140c7c2f3b9c960a9aa1988d8095d1cc1', 'testclient', NULL, NULL, '2019-02-23 22:23:38', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('6352f3b1baa0ff8dadfdd2c9382d7ea367263260', 'testclient', NULL, NULL, '2019-02-23 22:23:43', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('30ff4643c680305eafe594f48253f25bbeb65bf1', 'testclient', NULL, NULL, '2019-02-23 22:47:58', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('44753c9bd426940fd627e47c56ccd155712c5283', 'testclient', NULL, NULL, '2019-02-23 22:50:34', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('8667d73af0a3afc0e451e1cee855cac7649ffaf9', 'testclient', NULL, NULL, '2019-02-23 23:07:18', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('a06bcb1423bfbdb4441e6526f2931466d4888138', 'testclient', NULL, NULL, '2019-02-23 23:48:43', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('0891a27f4dcea7984b70f4af91f071fb693299c2', 'testclient', NULL, NULL, '2019-02-23 23:51:40', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('2637ccf3f20d2c516c513178799a0d456b4f2175', 'testclient', NULL, NULL, '2019-02-24 00:42:48', NULL, NULL);
INSERT INTO `oauth_authorization_codes` VALUES ('cf2e98c852e296a0c958d6c942684d6b1f891783', 'testclient', NULL, NULL, '2019-02-24 00:43:20', NULL, NULL);

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients`  (
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_secret` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `redirect_uri` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `grant_types` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `scope` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
INSERT INTO `oauth_clients` VALUES ('testclient', 'testpass', 'http://www.baidu.com', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for oauth_jwt
-- ----------------------------
DROP TABLE IF EXISTS `oauth_jwt`;
CREATE TABLE `oauth_jwt`  (
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `subject` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `public_key` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens`  (
  `refresh_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`refresh_token`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_refresh_tokens
-- ----------------------------
INSERT INTO `oauth_refresh_tokens` VALUES ('e5b7e4b0472613652c2bd7493ba94da3da524e42', 'testclient', NULL, '2019-03-09 23:43:13', NULL);
INSERT INTO `oauth_refresh_tokens` VALUES ('78090d049dfe1a4a51e67dd949b7c35a1f1adcd0', 'testclient', NULL, '2019-03-09 23:46:37', NULL);
INSERT INTO `oauth_refresh_tokens` VALUES ('a92f6b2b4d14946c6c85bd08504a72a8b4b6087f', 'testclient', NULL, '2019-03-09 23:51:05', NULL);
INSERT INTO `oauth_refresh_tokens` VALUES ('426e4d09790d78561d4e6bfc8863fb2dda6b1222', 'testclient', NULL, '2019-03-10 00:16:25', NULL);

-- ----------------------------
-- Table structure for oauth_scopes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_scopes`;
CREATE TABLE `oauth_scopes`  (
  `scope` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_default` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`scope`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for oauth_users
-- ----------------------------
DROP TABLE IF EXISTS `oauth_users`;
CREATE TABLE `oauth_users`  (
  `username` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `first_name` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email_verified` tinyint(1) NULL DEFAULT NULL,
  `scope` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sys_users
-- ----------------------------
DROP TABLE IF EXISTS `sys_users`;
CREATE TABLE `sys_users`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '昵称',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电话',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `is_admin` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否管理员',
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_users
-- ----------------------------
INSERT INTO `sys_users` VALUES (1, '\'静静\'', '18231656191', '$2y$10$cuHRtrZ3uwjRdCE60DQGz.32A7k0jXz3HNvIrEhK3PaT4p6r74lWe', 0, '');
INSERT INTO `sys_users` VALUES (4, '\'静静\'', '18237656191', '$2y$10$dQswKFieUstpEGg.5dOIoeaz9/FuRHR0I2YGLDZ7eJrD/uwLBKmti', 0, '');

SET FOREIGN_KEY_CHECKS = 1;
