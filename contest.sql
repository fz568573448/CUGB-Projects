SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  `coj` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `situation` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `time` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ip` char(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `verification` char(16) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `flag` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
