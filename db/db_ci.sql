/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : db_ci

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2017-01-21 18:17:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tc_admin
-- ----------------------------
DROP TABLE IF EXISTS `tc_admin`;
CREATE TABLE `tc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(160) NOT NULL DEFAULT '' COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tc_advertisment
-- ----------------------------
DROP TABLE IF EXISTS `tc_advertisment`;
CREATE TABLE `tc_advertisment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) NOT NULL DEFAULT '0' COMMENT '广告主id对应client.id',
  `ads_name` varchar(255) NOT NULL DEFAULT '' COMMENT '广告名称',
  `ads_type` varchar(64) NOT NULL DEFAULT '' COMMENT '广告模式',
  `platform` varchar(32) NOT NULL DEFAULT '' COMMENT '投放平台',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `ads_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '广告地址',
  `ads_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '广告状态：0暂停，1投放中',
  `discount` decimal(15,2) NOT NULL DEFAULT '1.00' COMMENT '折扣',
  `third_platform` int(10) NOT NULL DEFAULT '0' COMMENT '第三方广告平台id',
  `username` varchar(128) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tc_client
-- ----------------------------
DROP TABLE IF EXISTS `tc_client`;
CREATE TABLE `tc_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(160) NOT NULL DEFAULT '' COMMENT '密码',
  `advertiser` varchar(32) NOT NULL DEFAULT '' COMMENT '广告主名称',
  `linkman` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '电话',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT 'email',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '广告主状态，1:：开通，0：关闭',
  `remain_count` decimal(15,2) DEFAULT '0.00' COMMENT '账户余额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tc_consume
-- ----------------------------
DROP TABLE IF EXISTS `tc_consume`;
CREATE TABLE `tc_consume` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) NOT NULL DEFAULT '0',
  `third_platform` tinyint(4) NOT NULL DEFAULT '0' COMMENT '第三方平台',
  `consume` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '当日当前消耗',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tc_finance
-- ----------------------------
DROP TABLE IF EXISTS `tc_finance`;
CREATE TABLE `tc_finance` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '财务信息表',
  `client_id` int(10) NOT NULL DEFAULT '0' COMMENT '广告主id',
  `money` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '充值时间',
  `note` varchar(128) NOT NULL DEFAULT '' COMMENT '备注',
  `third_platform` tinyint(4) NOT NULL DEFAULT '0' COMMENT '充值到的平台',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tc_third_platform
-- ----------------------------
DROP TABLE IF EXISTS `tc_third_platform`;
CREATE TABLE `tc_third_platform` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `third_platform` int(10) NOT NULL DEFAULT '0' COMMENT '第三方平台标识',
  `client_id` int(10) NOT NULL DEFAULT '0' COMMENT '客户id',
  `total_account` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '用户在第三方平台充值总额',
  `pay_account` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '历史消耗总额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
