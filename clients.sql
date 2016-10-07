/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : clients

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-07 18:07:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for client_admin
-- ----------------------------
DROP TABLE IF EXISTS `client_admin`;
CREATE TABLE `client_admin` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` tinyint(4) unsigned DEFAULT NULL,
  `level` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_admin
-- ----------------------------
INSERT INTO `client_admin` VALUES ('1', 'admin', '14e1b600b1fd579f47433b88e8d85291', '1', '1');
INSERT INTO `client_admin` VALUES ('2', 'rehack', 'dfc4ae407ca619b8d4a03b9f14034277', '1', '1');

-- ----------------------------
-- Table structure for client_department
-- ----------------------------
DROP TABLE IF EXISTS `client_department`;
CREATE TABLE `client_department` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `department` char(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_department
-- ----------------------------

-- ----------------------------
-- Table structure for client_disease
-- ----------------------------
DROP TABLE IF EXISTS `client_disease`;
CREATE TABLE `client_disease` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `disease_name` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_disease
-- ----------------------------

-- ----------------------------
-- Table structure for client_menu
-- ----------------------------
DROP TABLE IF EXISTS `client_menu`;
CREATE TABLE `client_menu` (
  `menuid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuname` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_menu
-- ----------------------------
INSERT INTO `client_menu` VALUES ('1', '网电咨询管理', 'icon-sys', 'menu1/treegrid.html', '0');
INSERT INTO `client_menu` VALUES ('2', '网电咨询', 'icon-sys', 'menu1/treegrid.html', '1');
INSERT INTO `client_menu` VALUES ('3', '系统设置', 'icon-sys', 'menu1/treegrid.html', '0');
INSERT INTO `client_menu` VALUES ('4', '管理员设置', 'icon-sys', 'menu1/treegrid.html', '3');
INSERT INTO `client_menu` VALUES ('5', '权限设置', 'icon-sys', 'menu1/treegrid.html', '3');

-- ----------------------------
-- Table structure for client_role
-- ----------------------------
DROP TABLE IF EXISTS `client_role`;
CREATE TABLE `client_role` (
  `id` tinyint(4) NOT NULL,
  `role` char(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `department` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_role
-- ----------------------------

-- ----------------------------
-- Table structure for client_users_info
-- ----------------------------
DROP TABLE IF EXISTS `client_users_info`;
CREATE TABLE `client_users_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL,
  `age` tinyint(2) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `tel` char(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_info
-- ----------------------------
