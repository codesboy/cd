/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : clients

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-14 19:11:09
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
-- Table structure for client_dev_from
-- ----------------------------
DROP TABLE IF EXISTS `client_dev_from`;
CREATE TABLE `client_dev_from` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dev` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_dev_from
-- ----------------------------
INSERT INTO `client_dev_from` VALUES ('1', '企划部');
INSERT INTO `client_dev_from` VALUES ('2', '网络部');
INSERT INTO `client_dev_from` VALUES ('3', '网络渠道');

-- ----------------------------
-- Table structure for client_disease
-- ----------------------------
DROP TABLE IF EXISTS `client_disease`;
CREATE TABLE `client_disease` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `disease_name` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_disease
-- ----------------------------
INSERT INTO `client_disease` VALUES ('1', '口腔正畸');
INSERT INTO `client_disease` VALUES ('2', '口腔内科');
INSERT INTO `client_disease` VALUES ('3', '洁牙');
INSERT INTO `client_disease` VALUES ('4', '美白');
INSERT INTO `client_disease` VALUES ('5', '美容冠');
INSERT INTO `client_disease` VALUES ('6', '其他');

-- ----------------------------
-- Table structure for client_doctors
-- ----------------------------
DROP TABLE IF EXISTS `client_doctors`;
CREATE TABLE `client_doctors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doctor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_doctors
-- ----------------------------
INSERT INTO `client_doctors` VALUES ('1', '曾杨');
INSERT INTO `client_doctors` VALUES ('2', '冯洁');

-- ----------------------------
-- Table structure for client_from
-- ----------------------------
DROP TABLE IF EXISTS `client_from`;
CREATE TABLE `client_from` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_from
-- ----------------------------
INSERT INTO `client_from` VALUES ('1', '道闸广告', '1');
INSERT INTO `client_from` VALUES ('2', '电梯广告', '1');
INSERT INTO `client_from` VALUES ('3', '搜狗pc', '2');
INSERT INTO `client_from` VALUES ('4', '微博', '3');
INSERT INTO `client_from` VALUES ('5', '微信', '3');
INSERT INTO `client_from` VALUES ('6', '朋友介绍', '1');
INSERT INTO `client_from` VALUES ('7', '朋友介绍', '2');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_menu
-- ----------------------------
INSERT INTO `client_menu` VALUES ('1', '网电咨询管理', 'icon-sys', '', '0');
INSERT INTO `client_menu` VALUES ('2', '网电咨询', 'icon-tip', 'menu1/treegrid.html', '1');
INSERT INTO `client_menu` VALUES ('3', '系统设置', 'icon-sys', '', '0');
INSERT INTO `client_menu` VALUES ('4', '管理员设置', 'icon-sys', 'menu1/treegrid.html', '3');
INSERT INTO `client_menu` VALUES ('5', '权限设置', 'icon-sys', 'menu1/treegrid.html', '3');
INSERT INTO `client_menu` VALUES ('7', '新增客户信息', 'icon-add', '../Useradd/', '1');
INSERT INTO `client_menu` VALUES ('6', '数据字典', null, '', '3');

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
-- Table structure for client_users_consumer
-- ----------------------------
DROP TABLE IF EXISTS `client_users_consumer`;
CREATE TABLE `client_users_consumer` (
  `uid` int(10) unsigned NOT NULL,
  `disease_id` int(11) NOT NULL,
  `cash` decimal(10,0) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_consumer
-- ----------------------------

-- ----------------------------
-- Table structure for client_users_info
-- ----------------------------
DROP TABLE IF EXISTS `client_users_info`;
CREATE TABLE `client_users_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL,
  `usersn` char(20) NOT NULL,
  `age` tinyint(2) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `tel` char(11) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usersn` (`usersn`),
  UNIQUE KEY `tel` (`tel`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_info
-- ----------------------------

-- ----------------------------
-- Table structure for client_users_zixun
-- ----------------------------
DROP TABLE IF EXISTS `client_users_zixun`;
CREATE TABLE `client_users_zixun` (
  `uid` int(10) unsigned NOT NULL,
  `zx_disease` varchar(255) NOT NULL,
  `zx_tool` varchar(255) NOT NULL,
  `zx_time` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_zixun
-- ----------------------------

-- ----------------------------
-- Table structure for client_zx_tools
-- ----------------------------
DROP TABLE IF EXISTS `client_zx_tools`;
CREATE TABLE `client_zx_tools` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tool` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_zx_tools
-- ----------------------------
INSERT INTO `client_zx_tools` VALUES ('1', '商务通');
INSERT INTO `client_zx_tools` VALUES ('2', 'QQ');
INSERT INTO `client_zx_tools` VALUES ('3', '微信');
