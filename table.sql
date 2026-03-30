-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2026-03-29 21:53:09
-- 服务器版本： 5.7.38-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `192_168_1_3`
--

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `theme` varchar(50) DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`id`, `theme`) VALUES
(1, 'time-light'),
(2, 'time-light');

-- --------------------------------------------------------

--
-- 表的结构 `score_log`
--

CREATE TABLE `score_log` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL COMMENT '学生ID',
  `rule_id` int(11) DEFAULT '0',
  `type` enum('add','minus') NOT NULL COMMENT 'add加分 minus扣分',
  `score` int(11) NOT NULL COMMENT '本次变动分数',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `score_rules`
--

CREATE TABLE `score_rules` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '规则名称',
  `score` int(11) NOT NULL COMMENT '积分（正数加分，负数扣分）',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分规则表';

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `class` varchar(50) NOT NULL,
  `score` int(11) DEFAULT '100',
  `avatar` varchar(255) DEFAULT '' COMMENT '头像',
  `title_id` int(11) DEFAULT '0' COMMENT '绑定头衔ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `titles`
--

CREATE TABLE `titles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '头衔名称',
  `color` varchar(50) NOT NULL DEFAULT '#333333' COMMENT '头衔颜色',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='头衔表';

--
-- 转储表的索引
--

--
-- 表的索引 `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `score_log`
--
ALTER TABLE `score_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- 表的索引 `score_rules`
--
ALTER TABLE `score_rules`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `score_log`
--
ALTER TABLE `score_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- 使用表AUTO_INCREMENT `score_rules`
--
ALTER TABLE `score_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- 使用表AUTO_INCREMENT `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
