SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` bigint(4) NOT NULL,
  `department` char(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '中国地质大学（北京）\r\n地球科学与资源学院\r\n工程技术学院\r\n材料科学与工程学院\r\n信息工程学院\r\n水资源与环境学院\r\n能源学院\r\n人文经管学院\r\n外国语学院\r\n珠宝学院\r\n地球物理与信息技术学院\r\n海洋学院\r\n土地科学技术学院\r\n数理学院\r\n思想政治教育学院\r\n科学研究院\r\n\r\n体育课部\r\n机关\r\n教务处\r\n学院路教学共同体\r\n软件学院\r\n学生工作处\r\n武装部（保卫处）\r\n国防生选培办\r\n团委\r\n成人教育学院\r\n校医院\r\n现代教育技术中心\r\n第二图书阅览室\r\n课程联盟\r\n',
  `password` char(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for counter
-- ----------------------------
DROP TABLE IF EXISTS `counter`;
CREATE TABLE `counter`  (
  `cnt` int(3) NULL DEFAULT NULL,
  `lastday` char(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for info
-- ----------------------------
DROP TABLE IF EXISTS `info`;
CREATE TABLE `info`  (
  `id` bigint(10) NOT NULL,
  `type` int(3) NOT NULL DEFAULT 0 COMMENT '$AWARD = [\r\n    100 => \'十佳本科生\',\r\n    101 => \'十佳研究生\',\r\n    200 => \'三好学生\',\r\n    201 => \'优秀学生干部\',\r\n    300 => \'学风标兵\',\r\n    301 => \'文艺标兵\',\r\n    302 => \'体育标兵\',\r\n    303 => \'公益标兵\',\r\n    304 => \'社会实践标兵\',\r\n    305 => \'科技创新标兵\',\r\n    400 => \'本科生国家奖学金\',\r\n    401 => \'研究生国家奖学金\',\r\n    402 => \'国家励志奖学金\',\r\n    403 => \'曾宪梓奖学金\',\r\n    404 => \'中国石油奖学金\',\r\n    405 => \'中国石化英才奖学金\',\r\n    406 => \'杨起奖学金\',\r\n    407 => \'杨遵仪奖学金\',\r\n    408 => \'郝诒纯奖学金\',\r\n    409 => \'冯景兰奖学金\',\r\n    410 => \'地球化学人才奖学金\',\r\n    411 => \'翟裕生奖学金\',\r\n    412 => \'赵鹏大奖学金\',\r\n    413 => \'希尔威矿业奖学金\',\r\n    414 => \'航勘院地质奖学金\',\r\n    415 => \'中国科学院奖学金\',\r\n    416 => \'龙润奖学金\',\r\n    500 => \'地大自强之星\',\r\n    600 => \'优秀班集体\',\r\n    601 => \'十佳班集体\',\r\n    700 => \'优秀学生宿舍\',\r\n    701 => \'十佳学生宿舍\'\r\n];\r\n',
  `name` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT '班级/寝室名称',
  `position` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT '职务',
  `situation` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT '基本情况',
  `performance` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT '突出表现',
  `experience` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT '心得体会/获奖感言',
  PRIMARY KEY (`id`, `type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` bigint(10) NOT NULL DEFAULT 0,
  `name` char(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sex` char(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `department` char(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `major` char(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` char(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `mobile` bigint(11) NULL DEFAULT NULL,
  `verification` char(16) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `flag` tinyint(1) NULL DEFAULT 0,
  `photo` tinyint(1) NULL DEFAULT 0,
  `political` tinyint(2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
