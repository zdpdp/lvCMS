/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50714
Source Host           : 127.0.0.1:3306
Source Database       : cms

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-08-07 16:49:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_article
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '文章标题',
  `classId` int(11) DEFAULT NULL COMMENT '类别',
  `userId` int(30) DEFAULT NULL COMMENT '作者',
  `created_at` datetime DEFAULT NULL COMMENT '创建于',
  `updated_at` datetime DEFAULT NULL COMMENT '更新于',
  `content` text COMMENT '内容',
  `original` tinyint(4) DEFAULT NULL COMMENT '是否原创 1是 0否',
  `source` varchar(255) DEFAULT NULL COMMENT '文章来源 （非原创基础上）',
  `thumbnail` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `clickNum` int(50) DEFAULT '0' COMMENT '点击数量',
  `state` int(4) DEFAULT NULL COMMENT '状态 0置顶 1正常 2草稿 3回收站',
  `top` tinyint(4) DEFAULT '0' COMMENT '1置顶 0不置顶',
  PRIMARY KEY (`id`),
  KEY `文章属于哪个类别` (`classId`),
  CONSTRAINT `文章属于哪个类别` FOREIGN KEY (`classId`) REFERENCES `cms_article_class` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES ('22', '测试3', '9', '21', '2017-07-30 03:38:23', '2017-08-07 15:14:24', '<p>你好啊哈哈你好啊哈哈你好啊哈哈你好啊哈哈你好啊哈哈</p><p>你好啊哈哈你好啊哈哈</p><p><br/></p><p>你好啊哈哈</p><p>你好啊哈哈</p>', '1', '', '/images/userHead/211501385903.jpg', '0', '0', '1');
INSERT INTO `cms_article` VALUES ('23', '测试2', '9', '21', '2017-07-30 11:39:01', '2017-08-07 15:14:24', '<p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\"><img src=\"/ueditor/php/upload/image/20170802/1501658589613677.png\" title=\"1501658589613677.png\" alt=\"image.png\"/></p><p style=\"white-space: normal;\"><span style=\"color: rgb(255, 0, 0);\">大家好大家好大家好大家好大家好大家好</span></p><p style=\"white-space: normal;\"><span style=\"color: rgb(255, 0, 0);\">大家好</span></p><h1 style=\"white-space: normal;\"><span style=\"color: rgb(255, 0, 0);\">大家好</span></h1><h1 style=\"white-space: normal;\"><span style=\"color: rgb(255, 0, 0);\">大家好</span></h1><h1 style=\"white-space: normal;\"><span style=\"color: rgb(255, 0, 0);\">大家好大家好</span></h1><p style=\"white-space: normal;\"><span style=\"color: rgb(255, 0, 0);\">大家好大家好大家好大家好大家好大家好</span></p><p style=\"white-space: normal;\">大家好</p><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好大家好</h1><p style=\"white-space: normal;\">大家好大家好大家好大家好大家好大家好</p><p style=\"white-space: normal;\">大家好</p><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好</h1><p style=\"white-space: normal;\">大家好大家好大家好大家好大家好大家好</p><p style=\"white-space: normal;\">大家好</p><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好大家好</h1><p style=\"white-space: normal;\">大家好大家好大家好大家好大家好大家好</p><p style=\"white-space: normal;\">大家好</p><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好大家好</h1><p style=\"white-space: normal;\">大家好大家好大家好大家好大家好大家好</p><p style=\"white-space: normal;\">大家好</p><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大家好</h1><h1 style=\"white-space: normal;\">大</h1><h1 style=\"white-space: normal;\">大</h1>', '1', '', '/images/userHead/211501385909.jpg', '12', '0', '1');
INSERT INTO `cms_article` VALUES ('24', 'ceshi 3', '7', '21', '2017-08-02 15:51:47', '2017-08-07 16:30:57', '<p>cenimei&nbsp;<img src=\"/ueditor/php/upload/image/20170802/1501689078813140.png\" title=\"1501689078813140.png\" alt=\"image.png\"/></p>', '1', null, '/images/articleImg/211501689107.jpg', '17', '0', '0');

-- ----------------------------
-- Table structure for cms_article_class
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_class`;
CREATE TABLE `cms_article_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fatherId` int(11) DEFAULT NULL,
  `className` varchar(255) NOT NULL COMMENT '类别名',
  `remarkable` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否允许评论 1完全开放 2完全禁止 3登录后允许',
  `visitable` tinyint(4) NOT NULL DEFAULT '1' COMMENT '游客允许浏览 1完全开放 2完全禁止 3登录后允许',
  `downloadable` tinyint(4) NOT NULL DEFAULT '1' COMMENT '游客是否允许下载附件 1完全开放 2完全禁止 3登录后允许',
  PRIMARY KEY (`id`),
  KEY `父类别` (`fatherId`),
  CONSTRAINT `父类别` FOREIGN KEY (`fatherId`) REFERENCES `cms_article_class` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article_class
-- ----------------------------
INSERT INTO `cms_article_class` VALUES ('1', null, '父1', '3', '1', '3');
INSERT INTO `cms_article_class` VALUES ('3', null, '父3', '1', '1', '3');
INSERT INTO `cms_article_class` VALUES ('5', '1', '儿1', '1', '1', '3');
INSERT INTO `cms_article_class` VALUES ('6', null, '儿2', '1', '1', '3');
INSERT INTO `cms_article_class` VALUES ('7', '3', '儿3', '1', '1', '1');
INSERT INTO `cms_article_class` VALUES ('9', '1', '儿5', '1', '1', '1');

-- ----------------------------
-- Table structure for cms_friends
-- ----------------------------
DROP TABLE IF EXISTS `cms_friends`;
CREATE TABLE `cms_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `top` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否置顶（显示首页） 1是 0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_friends
-- ----------------------------
INSERT INTO `cms_friends` VALUES ('5', '百度', 'http://www.baidu.com', '0');
INSERT INTO `cms_friends` VALUES ('6', '新浪', 'http://www.163.com', '1');

-- ----------------------------
-- Table structure for cms_function
-- ----------------------------
DROP TABLE IF EXISTS `cms_function`;
CREATE TABLE `cms_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` int(11) NOT NULL COMMENT '权限级别 1导航栏一级菜单  2导航栏二级菜单 3页面功能',
  `EnglishName` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL COMMENT '权限名',
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `father_id` int(11) DEFAULT NULL COMMENT '父级权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_function
-- ----------------------------
INSERT INTO `cms_function` VALUES ('1', '1', 'UsgeMgr', '用户管理', null, 'fa fa-user fa-fw', null);
INSERT INTO `cms_function` VALUES ('2', '1', 'SiteMgr', '站点管理', null, 'fa fa-home fa-fw', null);
INSERT INTO `cms_function` VALUES ('3', '1', 'ArticleMgr', '文章管理', null, 'fa fa-pencil-square fa-fw', null);
INSERT INTO `cms_function` VALUES ('4', '2', 'PersonPage', '个人信息', '/userInfo', null, '13');
INSERT INTO `cms_function` VALUES ('5', '2', 'AllUserPage', '所有用户', '/allUser', null, '1');
INSERT INTO `cms_function` VALUES ('6', '2', 'AddUserPage', '添加用户', '/addUser', null, '1');
INSERT INTO `cms_function` VALUES ('7', '2', 'RoleMgrPage', '角色管理', '/role', null, '1');
INSERT INTO `cms_function` VALUES ('8', '2', 'AllArticlePage', '所有文章', '/allArticle', null, '3');
INSERT INTO `cms_function` VALUES ('9', '2', 'AddArticlePage', '添加文章', '/addArticle', null, '3');
INSERT INTO `cms_function` VALUES ('10', '2', 'ArticleClassPage', '文章类别', '/articleClass', null, '3');
INSERT INTO `cms_function` VALUES ('11', '2', 'SiteSetPage', '常规设置', '/siteSetting', null, '2');
INSERT INTO `cms_function` VALUES ('12', '3', 'editSiteSetting', '修改站点设置', '/admin/site/set', null, '11');
INSERT INTO `cms_function` VALUES ('13', '1', 'PersonMgr', '个人资料', null, 'fa fa-address-card-o fa-fw', null);
INSERT INTO `cms_function` VALUES ('14', '3', 'addRole', '添加角色', '/admin/user/newRole', null, '7');
INSERT INTO `cms_function` VALUES ('15', '3', 'grantPower', '角色授权', '/admin/user/editRolePermission', null, '7');
INSERT INTO `cms_function` VALUES ('16', '3', 'deleteRole', '删除角色', '/admin/user/deleteRole', null, '7');
INSERT INTO `cms_function` VALUES ('17', '3', 'editRole', '修改角色', '/admin/user/editRoleBaseInfo', null, '7');
INSERT INTO `cms_function` VALUES ('18', '3', 'addOneUser', '添加用户', '/admin/addUser/addOneUser', null, '6');
INSERT INTO `cms_function` VALUES ('19', '3', 'editUser', '编辑用户信息', '/admin/allUser/editUser', null, '5');
INSERT INTO `cms_function` VALUES ('20', '3', 'deleteUser', '删除用户', '/admin/allUser/deleteUser', null, '5');
INSERT INTO `cms_function` VALUES ('21', '3', 'editSelfInfo', '修改个人信息', '/admin/userInfo/saveBase', null, '4');
INSERT INTO `cms_function` VALUES ('22', '3', 'addArticleClass', '添加类别', '/admin/articleClass/addClass', null, '10');
INSERT INTO `cms_function` VALUES ('23', '3', 'deleteArticleClass', '删除类别', '/admin/articleClass/deleteClass', null, '10');
INSERT INTO `cms_function` VALUES ('24', '3', 'editArticleClass', '修改类别', '/admin/articleClass/editClass', null, '10');
INSERT INTO `cms_function` VALUES ('25', '3', 'postAttachMent', '上传附件', '/admin/addArticle/attach', null, '9');
INSERT INTO `cms_function` VALUES ('26', '3', 'publicArticle', '发布文章/草稿', '/admin/addArticle/public', null, '9');
INSERT INTO `cms_function` VALUES ('27', '3', 'editArticle', '编辑文章', '/admin/addArticle/edit', null, '9');
INSERT INTO `cms_function` VALUES ('28', '3', 'deleteArticle', '删除文章', '/admin/allArticle/delete', null, '8');
INSERT INTO `cms_function` VALUES ('29', '3', 'addArticleToBin', '文章加入回收站', '/admin/allArticle/recycleBin', null, '8');
INSERT INTO `cms_function` VALUES ('30', '3', 'backArticleFromBin', '从回收站还原', '/admin/allArticle/back', null, '8');
INSERT INTO `cms_function` VALUES ('31', '2', 'friendLinkPage', '友情链接', '/friends', null, '2');
INSERT INTO `cms_function` VALUES ('32', '3', 'editFriend', '编辑友情链接', '/admin/friends/edit', null, '31');
INSERT INTO `cms_function` VALUES ('33', '3', 'addFriend', '新增友情链接', '/admin/friends/add', null, '31');
INSERT INTO `cms_function` VALUES ('34', '3', 'deleteFriend', '删除友情链接', '/admin/friends/delete', null, '31');
INSERT INTO `cms_function` VALUES ('35', '2', 'remarkMgrPage', '评论管理', '/remark', null, '3');
INSERT INTO `cms_function` VALUES ('36', '3', 'replyRemark', '回复评论', '/admin/remark/reply', null, '35');
INSERT INTO `cms_function` VALUES ('37', '3', 'deleteRemark', '删除评论', '/admin/remark/delete', null, '35');
INSERT INTO `cms_function` VALUES ('39', '3', 'editRemark', '编辑评论', '/admin/remark/edit', null, '35');
INSERT INTO `cms_function` VALUES ('40', '1', 'VisitMgr', '访问管理', null, 'fa  fa-sign-in  fa-fw', null);
INSERT INTO `cms_function` VALUES ('41', '2', 'VisitLogPage', '访问统计', '/visit', null, '40');
INSERT INTO `cms_function` VALUES ('42', '3', 'upArticle', '置顶文章', '/admin/allArticle/up', null, '8');
INSERT INTO `cms_function` VALUES ('43', '3', 'downArticle', '取消置顶文章', '/admin/allArticle/down', null, '8');
INSERT INTO `cms_function` VALUES ('44', '3', 'batchDeleteUser', '批量删除用户', '/admin/allUser/batchDelete', null, '5');
INSERT INTO `cms_function` VALUES ('45', '3', 'batchChangeUser', '批量修改用户状态', '/admin/allUser/batchChange', null, '5');
INSERT INTO `cms_function` VALUES ('46', '3', 'batchDeleteFrendLink', '批量删除友情链接', '/admin/friends/batchDelete', null, '31');
INSERT INTO `cms_function` VALUES ('47', '3', 'batchDeleteArticle', '批量删除文章', '/admin/allArticle/batchDelete', null, '8');
INSERT INTO `cms_function` VALUES ('48', '3', 'batchChangeArticle', '批量改变文章状态', '/admin/allArticle/batchChange', null, '8');
INSERT INTO `cms_function` VALUES ('49', '3', 'batchDeleteRemark', '批量删除评论', '/admin/remark/batchDelete', null, '35');

-- ----------------------------
-- Table structure for cms_permission
-- ----------------------------
DROP TABLE IF EXISTS `cms_permission`;
CREATE TABLE `cms_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `function_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_allownav_ibfk_2` (`function_id`),
  KEY `cms_permission_ibfk_1` (`role_id`),
  CONSTRAINT `cms_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `cms_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=754 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_permission
-- ----------------------------
INSERT INTO `cms_permission` VALUES ('81', '2', '1');
INSERT INTO `cms_permission` VALUES ('82', '2', '2');
INSERT INTO `cms_permission` VALUES ('83', '2', '5');
INSERT INTO `cms_permission` VALUES ('84', '2', '6');
INSERT INTO `cms_permission` VALUES ('85', '2', '7');
INSERT INTO `cms_permission` VALUES ('86', '2', '11');
INSERT INTO `cms_permission` VALUES ('87', '2', '12');
INSERT INTO `cms_permission` VALUES ('88', '2', '14');
INSERT INTO `cms_permission` VALUES ('89', '2', '15');
INSERT INTO `cms_permission` VALUES ('90', '2', '16');
INSERT INTO `cms_permission` VALUES ('91', '2', '17');
INSERT INTO `cms_permission` VALUES ('92', '2', '18');
INSERT INTO `cms_permission` VALUES ('93', '2', '19');
INSERT INTO `cms_permission` VALUES ('94', '2', '20');
INSERT INTO `cms_permission` VALUES ('95', '2', '25');
INSERT INTO `cms_permission` VALUES ('301', '5', '10');
INSERT INTO `cms_permission` VALUES ('302', '5', '22');
INSERT INTO `cms_permission` VALUES ('706', '1', '1');
INSERT INTO `cms_permission` VALUES ('707', '1', '2');
INSERT INTO `cms_permission` VALUES ('708', '1', '3');
INSERT INTO `cms_permission` VALUES ('709', '1', '4');
INSERT INTO `cms_permission` VALUES ('710', '1', '5');
INSERT INTO `cms_permission` VALUES ('711', '1', '6');
INSERT INTO `cms_permission` VALUES ('712', '1', '7');
INSERT INTO `cms_permission` VALUES ('713', '1', '8');
INSERT INTO `cms_permission` VALUES ('714', '1', '9');
INSERT INTO `cms_permission` VALUES ('715', '1', '10');
INSERT INTO `cms_permission` VALUES ('716', '1', '11');
INSERT INTO `cms_permission` VALUES ('717', '1', '12');
INSERT INTO `cms_permission` VALUES ('718', '1', '13');
INSERT INTO `cms_permission` VALUES ('719', '1', '14');
INSERT INTO `cms_permission` VALUES ('720', '1', '15');
INSERT INTO `cms_permission` VALUES ('721', '1', '16');
INSERT INTO `cms_permission` VALUES ('722', '1', '17');
INSERT INTO `cms_permission` VALUES ('723', '1', '18');
INSERT INTO `cms_permission` VALUES ('724', '1', '19');
INSERT INTO `cms_permission` VALUES ('725', '1', '20');
INSERT INTO `cms_permission` VALUES ('726', '1', '21');
INSERT INTO `cms_permission` VALUES ('727', '1', '22');
INSERT INTO `cms_permission` VALUES ('728', '1', '23');
INSERT INTO `cms_permission` VALUES ('729', '1', '24');
INSERT INTO `cms_permission` VALUES ('730', '1', '25');
INSERT INTO `cms_permission` VALUES ('731', '1', '26');
INSERT INTO `cms_permission` VALUES ('732', '1', '27');
INSERT INTO `cms_permission` VALUES ('733', '1', '28');
INSERT INTO `cms_permission` VALUES ('734', '1', '29');
INSERT INTO `cms_permission` VALUES ('735', '1', '30');
INSERT INTO `cms_permission` VALUES ('736', '1', '31');
INSERT INTO `cms_permission` VALUES ('737', '1', '32');
INSERT INTO `cms_permission` VALUES ('738', '1', '33');
INSERT INTO `cms_permission` VALUES ('739', '1', '34');
INSERT INTO `cms_permission` VALUES ('740', '1', '35');
INSERT INTO `cms_permission` VALUES ('741', '1', '36');
INSERT INTO `cms_permission` VALUES ('742', '1', '37');
INSERT INTO `cms_permission` VALUES ('743', '1', '39');
INSERT INTO `cms_permission` VALUES ('744', '1', '40');
INSERT INTO `cms_permission` VALUES ('745', '1', '41');
INSERT INTO `cms_permission` VALUES ('746', '1', '42');
INSERT INTO `cms_permission` VALUES ('747', '1', '43');
INSERT INTO `cms_permission` VALUES ('748', '1', '44');
INSERT INTO `cms_permission` VALUES ('749', '1', '45');
INSERT INTO `cms_permission` VALUES ('750', '1', '46');
INSERT INTO `cms_permission` VALUES ('751', '1', '47');
INSERT INTO `cms_permission` VALUES ('752', '1', '48');
INSERT INTO `cms_permission` VALUES ('753', '1', '49');

-- ----------------------------
-- Table structure for cms_remark
-- ----------------------------
DROP TABLE IF EXISTS `cms_remark`;
CREATE TABLE `cms_remark` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `articleId` int(30) NOT NULL,
  `content` text,
  `userId` int(30) DEFAULT NULL,
  `tempName` varchar(255) DEFAULT NULL,
  `ancestor_id` int(40) DEFAULT NULL COMMENT '最高层级 祖宗评论',
  `father_id` int(40) DEFAULT NULL COMMENT '回复属于哪个评论',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0回收站',
  PRIMARY KEY (`id`),
  KEY `ancestor_id` (`ancestor_id`),
  KEY `father_id` (`father_id`),
  CONSTRAINT `cms_remark_ibfk_1` FOREIGN KEY (`ancestor_id`) REFERENCES `cms_remark` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cms_remark_ibfk_2` FOREIGN KEY (`father_id`) REFERENCES `cms_remark` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_remark
-- ----------------------------
INSERT INTO `cms_remark` VALUES ('2', '22', '1231', null, '', null, null, '2017-08-03 09:56:05', null, '1');
INSERT INTO `cms_remark` VALUES ('3', '22', '测试测试', '21', '', null, null, '2017-08-03 09:56:30', null, '1');
INSERT INTO `cms_remark` VALUES ('4', '22', '再测试下', null, '', '3', null, '2017-08-03 09:57:20', null, '1');
INSERT INTO `cms_remark` VALUES ('5', '22', '哈哈', '21', '', '2', null, '2017-08-03 09:57:37', null, '1');
INSERT INTO `cms_remark` VALUES ('8', '22', '12332', null, '', null, null, '2017-08-03 05:47:31', '2017-08-03 05:47:31', '1');
INSERT INTO `cms_remark` VALUES ('9', '22', '222', null, '', null, null, '2017-08-03 05:47:42', '2017-08-03 05:47:42', '1');
INSERT INTO `cms_remark` VALUES ('10', '22', '2289113', null, '', '9', null, '2017-08-03 05:48:51', '2017-08-03 05:48:51', '1');
INSERT INTO `cms_remark` VALUES ('12', '22', '123123213', null, '', null, null, '2017-08-03 05:50:25', '2017-08-03 05:50:25', '1');
INSERT INTO `cms_remark` VALUES ('13', '22', '123', null, '大哥', '12', null, '2017-08-03 05:51:37', '2017-08-03 05:51:37', '1');
INSERT INTO `cms_remark` VALUES ('16', '22', '1999', null, null, null, null, null, null, '1');

-- ----------------------------
-- Table structure for cms_resource
-- ----------------------------
DROP TABLE IF EXISTS `cms_resource`;
CREATE TABLE `cms_resource` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1文章缩略图  2文章附件',
  `link_id` int(30) NOT NULL COMMENT '关联Id',
  `name` varchar(255) DEFAULT NULL COMMENT '资源名  ',
  `position` varchar(255) NOT NULL COMMENT '存储位置',
  `downloadNum` int(30) DEFAULT '0' COMMENT '下载次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_resource
-- ----------------------------
INSERT INTO `cms_resource` VALUES ('1', '1', '11', '2.jpg', './../resources/attachment/20170728/11501219774.jpg', '0');
INSERT INTO `cms_resource` VALUES ('2', '1', '11', '2.jpg', './../resources/attachment/20170728/11501220015.jpg', '0');
INSERT INTO `cms_resource` VALUES ('3', '1', '12', '2.jpg', './../resources/attachment/20170728/11501219774.jpg', '0');
INSERT INTO `cms_resource` VALUES ('4', '1', '12', '2.jpg', './../resources/attachment/20170728/11501220015.jpg', '0');
INSERT INTO `cms_resource` VALUES ('11', '1', '22', '1.jpg', './../resources/attachment/20170729/11501306890.jpg', '0');
INSERT INTO `cms_resource` VALUES ('12', '1', '22', '2.jpg', './../resources/attachment/20170730/211501385893.jpg', '0');
INSERT INTO `cms_resource` VALUES ('13', '1', '22', '360Safe.exe', './../resources/attachment/20170730/211501385896.exe', '0');
INSERT INTO `cms_resource` VALUES ('14', '1', '23', '2.jpg', './../resources/attachment/20170730/211501385893.jpg', '0');
INSERT INTO `cms_resource` VALUES ('15', '1', '23', '360Safe.exe', './../resources/attachment/20170730/211501385896.exe', '0');
INSERT INTO `cms_resource` VALUES ('16', '1', '24', 'tm-about-img.jpg', './../resources/attachment/20170802/211501689068.jpg', '0');
INSERT INTO `cms_resource` VALUES ('17', '1', '24', 'tm-img-100x100-5.jpg', './../resources/attachment/20170802/211501689071.jpg', '0');

-- ----------------------------
-- Table structure for cms_role
-- ----------------------------
DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '角色名',
  `grade` int(11) NOT NULL COMMENT '角色级别',
  `ifDefault` tinyint(4) DEFAULT '0' COMMENT '是否是默认角色 1是 0不是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_role
-- ----------------------------
INSERT INTO `cms_role` VALUES ('1', '超级管理员', '1', '1');
INSERT INTO `cms_role` VALUES ('2', '管理员', '2', '1');
INSERT INTO `cms_role` VALUES ('3', '普通用户', '9', '1');
INSERT INTO `cms_role` VALUES ('4', '1111', '10', '0');
INSERT INTO `cms_role` VALUES ('5', '888', '10', '0');
INSERT INTO `cms_role` VALUES ('7', 'qweqw', '10', '0');
INSERT INTO `cms_role` VALUES ('8', '1232333', '10', '0');
INSERT INTO `cms_role` VALUES ('9', '你你哦', '10', '0');

-- ----------------------------
-- Table structure for cms_site
-- ----------------------------
DROP TABLE IF EXISTS `cms_site`;
CREATE TABLE `cms_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '站点名称',
  `logo` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `defaultRole` int(11) NOT NULL COMMENT '用户注册时默认角色',
  `openRegister` tinyint(4) NOT NULL COMMENT '是否开放注册 1开放 0不开放',
  `ICB` varchar(255) DEFAULT NULL COMMENT '备案号',
  `email` varchar(255) DEFAULT NULL,
  `contacts` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `discription` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `keyWord` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_site_ibfk_1` (`defaultRole`),
  CONSTRAINT `cms_site_ibfk_1` FOREIGN KEY (`defaultRole`) REFERENCES `cms_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_site
-- ----------------------------
INSERT INTO `cms_site` VALUES ('1', 'CMS', '/images/siteImg/logo1501754713.jpg', '/images/siteImg/icon1501754713.jpg', '3', '1', '粤ICP备1000000号', '465201770@qq.com', '郑东平', '15602260750', 'haha', '465201770', '郑东平CMS');

-- ----------------------------
-- Table structure for cms_user
-- ----------------------------
DROP TABLE IF EXISTS `cms_user`;
CREATE TABLE `cms_user` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL COMMENT '用户登录账号',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL COMMENT '用户身份',
  `head` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `register_ip` varchar(255) DEFAULT NULL COMMENT '注册IP地址',
  `register_address` varchar(255) DEFAULT '' COMMENT '注册地址',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '0正常 1禁止登录 2禁止发言 3等待验证 ',
  `sex` tinyint(4) DEFAULT '3' COMMENT '1男 2女 3未知',
  `birth` date DEFAULT NULL COMMENT '生日',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号码',
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userAccount` (`account`) USING HASH,
  KEY `userRole` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_user
-- ----------------------------
INSERT INTO `cms_user` VALUES ('21', '1406100109', '123456', '郑东平', '1', '/images/userHead/211501382108.jpg', null, null, '2017-08-07 16:35:17', null, '', '0', '1', '2017-07-10', '15602260750', '465201770@qq.com');
INSERT INTO `cms_user` VALUES ('23', '1406100110', '123456', '156156', '7', null, null, null, '2017-08-07 12:46:45', null, '', '3', '3', null, null, null);
INSERT INTO `cms_user` VALUES ('24', '1406100112', '123456', '156156', '2', null, null, null, '2017-08-07 12:42:56', null, '', '3', '3', null, null, null);
INSERT INTO `cms_user` VALUES ('25', '1406100113', '123456', '156156', '5', null, null, null, '2017-08-07 12:42:56', null, '', '3', '3', null, null, null);

-- ----------------------------
-- Table structure for cms_visit_log
-- ----------------------------
DROP TABLE IF EXISTS `cms_visit_log`;
CREATE TABLE `cms_visit_log` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0' COMMENT '0访问前台 1登录',
  `userId` int(40) DEFAULT NULL COMMENT '记录登录的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_visit_log
-- ----------------------------
INSERT INTO `cms_visit_log` VALUES ('2', '2017-08-05 10:49:43', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('3', '2017-08-05 11:01:40', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('4', '2017-08-05 11:20:48', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('5', '2017-08-05 11:32:32', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('6', '2017-08-06 10:10:40', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('7', '2017-08-06 10:21:01', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('8', '2017-08-06 10:33:10', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('9', '2017-08-06 11:24:56', '127.0.0.1', '1', '21');
INSERT INTO `cms_visit_log` VALUES ('10', '2017-07-07 12:26:19', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('11', '2017-05-18 15:15:25', null, '0', null);
INSERT INTO `cms_visit_log` VALUES ('12', '2017-08-07 09:33:09', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('13', '2017-08-07 09:33:30', '127.0.0.1', '1', '21');
INSERT INTO `cms_visit_log` VALUES ('14', '2017-08-07 13:10:29', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('15', '2017-08-07 14:52:02', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('16', '2017-08-07 15:04:33', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('17', '2017-08-07 15:31:10', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('18', '2017-08-07 15:32:47', '127.0.0.1', '1', '21');
INSERT INTO `cms_visit_log` VALUES ('19', '2017-08-07 16:03:35', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('20', '2017-08-07 16:16:54', '127.0.0.1', '0', null);
INSERT INTO `cms_visit_log` VALUES ('21', '2017-08-07 16:27:11', '127.0.0.1', '0', null);
