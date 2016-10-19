/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : clients

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-19 20:14:38
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuname` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_menu
-- ----------------------------
INSERT INTO `client_menu` VALUES ('1', '诊疗管理', 'icon-sys', '', '0');
INSERT INTO `client_menu` VALUES ('2', '客户查询', 'icon-tip', '/index/maindata/', '1');
INSERT INTO `client_menu` VALUES ('3', '消费管理', 'icon-sys', '', '0');
INSERT INTO `client_menu` VALUES ('4', '管理员设置', 'icon-sys', 'menu1/treegrid.html', '15');
INSERT INTO `client_menu` VALUES ('5', '权限设置', 'icon-sys', 'menu1/treegrid.html', '15');
INSERT INTO `client_menu` VALUES ('7', '新增客户', 'icon-add', '/index/useradd/', '1');
INSERT INTO `client_menu` VALUES ('6', '数据字典', null, '', '15');
INSERT INTO `client_menu` VALUES ('15', '系统设置', null, '', '0');
INSERT INTO `client_menu` VALUES ('9', '新增消费', null, '', '3');
INSERT INTO `client_menu` VALUES ('10', '积分管理', null, '', '0');
INSERT INTO `client_menu` VALUES ('11', '积分使用', null, '', '10');

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
  `dev_id` tinyint(3) unsigned NOT NULL,
  `from_id` tinyint(3) unsigned NOT NULL,
  `tool_id` tinyint(3) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usersn` (`usersn`),
  UNIQUE KEY `tel` (`tel`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_info
-- ----------------------------
INSERT INTO `client_users_info` VALUES ('1', 'd', 'FA18769947020403', '0', '0', '13999999999', '1', '1', '1', '1476776994');
INSERT INTO `client_users_info` VALUES ('2', '22', 'FA18848421248925', '0', '0', '13266554412', '1', '1', '1', '1476784842');
INSERT INTO `client_users_info` VALUES ('3', '222', 'FA18849194653144', '56', '0', '13699955415', '3', '5', '2', '1476784919');
INSERT INTO `client_users_info` VALUES ('4', 'kk', 'FA18928770880273', '0', '0', '13555441128', '2', '3', '3', '1476792877');
INSERT INTO `client_users_info` VALUES ('5', '按钮的', 'FA18929163832755', '0', '0', '13544254415', '2', '7', '2', '1476792916');
INSERT INTO `client_users_info` VALUES ('6', '大人', 'FA18930195021612', '0', '0', '13688542147', '1', '6', '2', '1476793019');
INSERT INTO `client_users_info` VALUES ('7', '婆', 'FA18930439985746', '0', '0', '15963201258', '1', '1', '1', '1476793043');
INSERT INTO `client_users_info` VALUES ('8', 'UI', 'FA18931217630190', '56', '1', '14765821452', '3', '4', '2', '1476793121');
INSERT INTO `client_users_info` VALUES ('9', '就开始', 'FA18931619683160', '0', '2', '15596321459', '2', '3', '1', '1476793161');
INSERT INTO `client_users_info` VALUES ('10', '加快了', 'FA18931925530691', '0', '2', '13100247745', '2', '7', '3', '1476793192');
INSERT INTO `client_users_info` VALUES ('11', '健康', 'FA18932266720123', '13', '1', '13687452103', '2', '3', '3', '1476793226');
INSERT INTO `client_users_info` VALUES ('12', '欧P', 'FA19784682156418', '20', '1', '13698748520', '1', '2', '2', '1476878468');

-- ----------------------------
-- Table structure for client_users_yuyue
-- ----------------------------
DROP TABLE IF EXISTS `client_users_yuyue`;
CREATE TABLE `client_users_yuyue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `yy_disease_id` int(10) unsigned NOT NULL,
  `yy_doctor_id` tinyint(3) unsigned NOT NULL,
  `yy_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_yuyue
-- ----------------------------
INSERT INTO `client_users_yuyue` VALUES ('1', '1', '2', '2', '1478332160');
INSERT INTO `client_users_yuyue` VALUES ('2', '2', '1', '2', '1480500031');
INSERT INTO `client_users_yuyue` VALUES ('3', '3', '5', '1', '0');
INSERT INTO `client_users_yuyue` VALUES ('4', '4', '3', '1', '0');
INSERT INTO `client_users_yuyue` VALUES ('5', '5', '2', '0', '0');
INSERT INTO `client_users_yuyue` VALUES ('6', '6', '2', '0', '0');
INSERT INTO `client_users_yuyue` VALUES ('7', '7', '5', '2', '1478175439');
INSERT INTO `client_users_yuyue` VALUES ('8', '8', '6', '1', '0');
INSERT INTO `client_users_yuyue` VALUES ('9', '9', '1', '2', '1477052357');
INSERT INTO `client_users_yuyue` VALUES ('10', '10', '3', '2', '0');
INSERT INTO `client_users_yuyue` VALUES ('11', '11', '2', '2', '0');
INSERT INTO `client_users_yuyue` VALUES ('12', '12', '2', '1', '1480507245');

-- ----------------------------
-- Table structure for client_users_zixun
-- ----------------------------
DROP TABLE IF EXISTS `client_users_zixun`;
CREATE TABLE `client_users_zixun` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `zx_disease_id` tinyint(3) unsigned NOT NULL,
  `zx_tool_id` tinyint(3) unsigned NOT NULL,
  `zx_time` int(11) unsigned NOT NULL,
  `zx_comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_users_zixun
-- ----------------------------
INSERT INTO `client_users_zixun` VALUES ('1', '1', '2', '1', '1476776994', '备注');
INSERT INTO `client_users_zixun` VALUES ('2', '2', '1', '1', '1476784842', 'beuz');
INSERT INTO `client_users_zixun` VALUES ('3', '3', '5', '2', '1476784919', '');
INSERT INTO `client_users_zixun` VALUES ('4', '4', '3', '3', '1476792877', '');
INSERT INTO `client_users_zixun` VALUES ('5', '5', '2', '2', '1476792916', '');
INSERT INTO `client_users_zixun` VALUES ('6', '6', '2', '2', '1476793019', '');
INSERT INTO `client_users_zixun` VALUES ('7', '7', '5', '1', '1476793043', '');
INSERT INTO `client_users_zixun` VALUES ('8', '8', '6', '2', '1476793121', '');
INSERT INTO `client_users_zixun` VALUES ('9', '9', '1', '1', '1476793161', '');
INSERT INTO `client_users_zixun` VALUES ('10', '10', '3', '3', '1476793192', '大');
INSERT INTO `client_users_zixun` VALUES ('11', '11', '2', '3', '1476793226', '');
INSERT INTO `client_users_zixun` VALUES ('12', '12', '2', '2', '1476878468', '统一');

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
