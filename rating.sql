SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for info
-- ----------------------------
DROP TABLE IF EXISTS `info`;
CREATE TABLE `info`  (
  `name` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cfid` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cf` int(4) NULL DEFAULT NULL,
  `cfcolor` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `bcid` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `bc` int(4) NULL DEFAULT NULL,
  `bccolor` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
