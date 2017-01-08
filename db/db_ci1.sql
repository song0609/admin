/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : db_ci

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2017-01-08 12:30:34
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_admin
-- ----------------------------
INSERT INTO `tc_admin` VALUES ('1', 'root', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `tc_admin` VALUES ('2', 'admin', '21232f297a57a5a743894a0e4a801fc3');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_client
-- ----------------------------
INSERT INTO `tc_client` VALUES ('1', 'client', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '', '1', '0.00');

-- ----------------------------
-- Table structure for tc_comments
-- ----------------------------
DROP TABLE IF EXISTS `tc_comments`;
CREATE TABLE `tc_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `part_time_id` int(11) NOT NULL DEFAULT '0' COMMENT '兼职id',
  `comments` varchar(512) NOT NULL DEFAULT '' COMMENT '评论',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_comments
-- ----------------------------
INSERT INTO `tc_comments` VALUES ('1', '1', '不错！', '2015-04-09 17:10:21');
INSERT INTO `tc_comments` VALUES ('2', '1', '很不错', '2015-04-09 17:10:30');
INSERT INTO `tc_comments` VALUES ('3', '1', '很棒', '2015-04-09 17:18:09');
INSERT INTO `tc_comments` VALUES ('5', '1', '不错', '2015-04-10 14:54:21');
INSERT INTO `tc_comments` VALUES ('6', '1', '不错', '2015-05-17 15:15:53');

-- ----------------------------
-- Table structure for tc_foundlost_message
-- ----------------------------
DROP TABLE IF EXISTS `tc_foundlost_message`;
CREATE TABLE `tc_foundlost_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `happen_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '发生时间',
  `happen_place` varchar(64) NOT NULL DEFAULT '' COMMENT '发生地点',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系电话',
  `remarks` varchar(128) NOT NULL DEFAULT '' COMMENT '备注',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `found_or_lost` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0代表遗失，1代表拾获',
  `is_display` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_foundlost_message
-- ----------------------------
INSERT INTO `tc_foundlost_message` VALUES ('7', '2015-04-10 12:30:00', '教学楼', '13800138123', '在富力教学楼205遗失一个黑色钱包', '1', '0', '0', '2016-12-20 20:23:43');
INSERT INTO `tc_foundlost_message` VALUES ('3', '2015-04-13 23:11:29', '饭堂', '12345678900', '黑色钱包，昨天在南海捡到', '1', '1', '1', '2015-05-05 16:01:35');
INSERT INTO `tc_foundlost_message` VALUES ('5', '2015-04-13 23:11:29', '教学楼', '12345678900', '学生卡，昨天在南海捡到', '6', '0', '1', '2015-04-24 11:47:10');
INSERT INTO `tc_foundlost_message` VALUES ('6', '2015-01-12 12:20:23', '礼堂', '12345678099', '遗失银行卡', '2', '1', '1', '2015-04-24 11:47:27');
INSERT INTO `tc_foundlost_message` VALUES ('9', '2015-05-04 10:00:00', '教学楼202', '18823476543', '拾获一红色钱包', '1', '1', '1', '2015-05-05 00:00:00');
INSERT INTO `tc_foundlost_message` VALUES ('10', '2015-05-16 10:00:00', '南海楼608', '18845678900', '黑色钱包，里面有身份证、学生卡', '1', '0', '1', '2015-05-17 00:00:00');
INSERT INTO `tc_foundlost_message` VALUES ('11', '2015-05-15 11:00:00', '图书馆', '19982321249', '红色钱包', '1', '0', '1', '2015-05-17 00:00:00');
INSERT INTO `tc_foundlost_message` VALUES ('12', '2015-05-18 12:00:00', '饭堂', '18823476543', '在饭堂遗失一黑色钱包，里面有银行卡', '1', '0', '1', '2015-05-17 00:00:00');

-- ----------------------------
-- Table structure for tc_foundlost_type
-- ----------------------------
DROP TABLE IF EXISTS `tc_foundlost_type`;
CREATE TABLE `tc_foundlost_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `type_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_foundlost_type
-- ----------------------------
INSERT INTO `tc_foundlost_type` VALUES ('1', '钱包');
INSERT INTO `tc_foundlost_type` VALUES ('2', '银行卡');
INSERT INTO `tc_foundlost_type` VALUES ('3', '手机');
INSERT INTO `tc_foundlost_type` VALUES ('4', '电脑');
INSERT INTO `tc_foundlost_type` VALUES ('5', '文具');
INSERT INTO `tc_foundlost_type` VALUES ('6', '学生卡');
INSERT INTO `tc_foundlost_type` VALUES ('7', '其他');
INSERT INTO `tc_foundlost_type` VALUES ('8', '33');

-- ----------------------------
-- Table structure for tc_parttime
-- ----------------------------
DROP TABLE IF EXISTS `tc_parttime`;
CREATE TABLE `tc_parttime` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `contents` varchar(512) NOT NULL DEFAULT '' COMMENT '内容',
  `contact_way` varchar(32) NOT NULL DEFAULT '' COMMENT '联系方式',
  `is_display` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `create_time` date NOT NULL DEFAULT '0000-00-00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_parttime
-- ----------------------------
INSERT INTO `tc_parttime` VALUES ('1', '家教兼职', '找高中数理化家教，50元每小时', '宋先生：2000233', '1', '2015-04-08');
INSERT INTO `tc_parttime` VALUES ('2', '派传单', '100/一天', '宋先生：2000233', '1', '2015-04-08');
INSERT INTO `tc_parttime` VALUES ('3', '家教兼职', '找英语家教，暨南花园高中学生', '12325171877', '1', '2015-04-09');
INSERT INTO `tc_parttime` VALUES ('4', '网上兼职', '网络推广100元/一天', '黄先生18826478564', '1', '2015-04-09');
INSERT INTO `tc_parttime` VALUES ('5', '1', '1', '1', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('6', '1', '1', '1', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('7', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('8', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('9', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('10', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('11', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('12', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('13', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('14', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('15', '', '', '', '0', '0000-00-00');
INSERT INTO `tc_parttime` VALUES ('16', '', '', '', '0', '0000-00-00');
