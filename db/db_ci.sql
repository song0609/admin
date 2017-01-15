/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : db_ci

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2017-01-15 23:09:02
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_admin
-- ----------------------------
INSERT INTO `tc_admin` VALUES ('1', 'root', '202cb962ac59075b964b07152d234b70');
INSERT INTO `tc_admin` VALUES ('2', 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `tc_admin` VALUES ('6', 'root1', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for tc_advertisment
-- ----------------------------
DROP TABLE IF EXISTS `tc_advertisment`;
CREATE TABLE `tc_advertisment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) NOT NULL DEFAULT '0' COMMENT '广告主id对应client.id',
  `ads_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '广告名称',
  `ads_type` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '广告模式',
  `platform` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '投放平台',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `ads_url` varchar(1024) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '广告地址',
  `ads_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '广告状态：0暂停，1投放中',
  `discount` decimal(15,2) NOT NULL DEFAULT '1.00' COMMENT '折扣',
  `third_platform` int(10) NOT NULL DEFAULT '0' COMMENT '第三方广告平台id',
  `username` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tc_advertisment
-- ----------------------------
INSERT INTO `tc_advertisment` VALUES ('1', '1', '网赚横幅房东', '横幅', '安卓', '1.00', 'http://www.baidu.com', '0', '0.80', '1', 'abc@qq.com', '123456');
INSERT INTO `tc_advertisment` VALUES ('2', '2', 'ads1', '横幅', '安卓', '0.90', 'http://www.baidu.com', '1', '0.90', '1', 'abc', '123456');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_client
-- ----------------------------
INSERT INTO `tc_client` VALUES ('1', 'client', 'e10adc3949ba59abbe56e057f20f883e', '唯品会', '张三', '18826788988', '12344@qq.com', '1', '1.00');
INSERT INTO `tc_client` VALUES ('2', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '淘宝', '小名', '1223454555', '667889@qq.com', '1', '0.00');
INSERT INTO `tc_client` VALUES ('3', 'test1', 'e10adc3949ba59abbe56e057f20f883e', '苹果', '不少', '111134444', 'fsd@qq.com', '1', '0.00');
INSERT INTO `tc_client` VALUES ('4', 'addclient', 'e10adc3949ba59abbe56e057f20f883e', 'yy娱乐', '飞飞', '111111', '8888@qq.com', '1', '0.00');
INSERT INTO `tc_client` VALUES ('6', 'test33', '202cb962ac59075b964b07152d234b70', '非师范', '黎姿', '18825167802', 'fdf@qq.com', '1', '0.00');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_finance
-- ----------------------------
INSERT INTO `tc_finance` VALUES ('1', '1', '0.00', '0', '222');
INSERT INTO `tc_finance` VALUES ('2', '2', '1000.00', '1484492541', '1w');
