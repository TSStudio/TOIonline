SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--
-- 数据库： `apps`
--
-- --------------------------------------------------------
--
-- 表的结构 `TOIsubmissions`
--
CREATE TABLE `TOIsubmissions` (
  `serial` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `prob` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- 表的结构 `TOIusers`
--
CREATE TABLE `TOIusers` (
  `id` int(11) NOT NULL,
  `nickname` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `passcode` varchar(65) COLLATE utf8mb4_general_ci NOT NULL,
  `salt` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- 转储表的索引
--
--
-- 表的索引 `TOIsubmissions`
--
ALTER TABLE `TOIsubmissions`
  ADD PRIMARY KEY (`serial`),
  ADD KEY `id` (`id`),
  ADD KEY `prob` (`prob`);
--
-- 表的索引 `TOIusers`
--
ALTER TABLE `TOIusers`
  ADD PRIMARY KEY (`id`);
--
-- 在导出的表使用AUTO_INCREMENT
--
--
-- 使用表AUTO_INCREMENT `TOIsubmissions`
--
ALTER TABLE `TOIsubmissions`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `TOIusers`
--
ALTER TABLE `TOIusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;