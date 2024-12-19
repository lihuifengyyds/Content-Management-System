-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-12-14 21:12:51
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cms`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键ID',
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `salt` char(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码salt',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password`, `salt`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'a45560ff639d3309a50ff8e6e3bb5a0d', '67a4c99c303d1cc6aded13241db464e2', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `adv`
--

CREATE TABLE `adv` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `adv`
--

INSERT INTO `adv` (`id`, `name`, `created_at`, `updated_at`) VALUES
(7, '科技', '2024-12-13 18:39:16', '2024-12-13 18:39:16'),
(8, '运动', '2024-12-13 18:39:48', '2024-12-13 18:39:48'),
(9, '生活', '2024-12-13 18:39:58', '2024-12-13 18:39:58'),
(10, '动漫', '2024-12-13 18:41:46', '2024-12-13 18:41:46');

-- --------------------------------------------------------

--
-- 表的结构 `advcontent`
--

CREATE TABLE `advcontent` (
  `id` int(10) UNSIGNED NOT NULL,
  `advid` int(11) NOT NULL COMMENT '广告位id',
  `path` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片路径',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `advcontent`
--

INSERT INTO `advcontent` (`id`, `advid`, `path`, `created_at`, `updated_at`) VALUES
(7, 7, '54d15542564917a10048225bda7dfc40.jpeg|e5ddd1efbf125639428bdc5cbdfe12ac.jpeg', '2024-12-13 18:39:26', '2024-12-13 19:16:17'),
(8, 8, '5638df0cbaaa12c75fc3788d4c9ceeb9.png', '2024-12-13 18:40:12', '2024-12-13 18:40:12'),
(10, 10, '47481170a169e6c969891574acb50427.jpeg', '2024-12-13 18:41:58', '2024-12-13 18:41:58');

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '栏目名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序值',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `pid`, `name`, `sort`, `created_at`, `updated_at`) VALUES
(10, 0, '新闻', 0, '2024-12-13 18:20:36', '2024-12-13 18:20:36'),
(13, 0, '科技', 0, '2024-12-13 18:24:50', '2024-12-13 18:24:50'),
(14, 0, '世界', 0, '2024-12-13 18:24:58', '2024-12-13 18:24:58'),
(15, 0, '运动', 0, '2024-12-13 18:25:04', '2024-12-13 18:25:04'),
(16, 0, '生活', 0, '2024-12-13 18:28:16', '2024-12-13 18:28:16');

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `content` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `comments`
--

INSERT INTO `comments` (`id`, `uid`, `cid`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 54, '123213', '2024-12-13 17:05:53', '2024-12-13 17:05:53'),
(2, 1, 57, '我也想吃', '2024-12-13 18:45:34', '2024-12-13 18:45:34'),
(3, 1, 60, '666', '2024-12-13 19:20:29', '2024-12-13 19:20:29'),
(4, 1, 58, '吃药', '2024-12-13 19:21:09', '2024-12-13 19:21:09'),
(5, 1, 60, '自律给我自由', '2024-12-13 19:21:49', '2024-12-13 19:21:49'),
(6, 2, 60, '自律给我自由', '2024-12-13 19:23:17', '2024-12-13 19:23:17');

-- --------------------------------------------------------

--
-- 表的结构 `content`
--

CREATE TABLE `content` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '栏目id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态默认1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `content`
--

INSERT INTO `content` (`id`, `cid`, `title`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(55, 10, '飞机', '<p>hello wolrd</p>', '8ebc8acefc348b4c8f67643c9e4e0d64.jpeg', 1, '2024-12-13 18:26:27', '2024-12-13 18:56:21'),
(57, 16, '吃面包', '<p>hello wolrd</p>', 'cc76af25ff4b07ebe0458eded0e9d239.jpeg', 1, '2024-12-13 18:28:46', '2024-12-13 18:28:46'),
(58, 14, 'spro', '<p>hello world</p>', '0c23b55f6c950cfe8ff4d2e4d89cb731.jpeg', 1, '2024-12-13 18:30:31', '2024-12-13 18:30:31'),
(60, 15, '自律', '<p>跑步</p>', '4c75bb04ad7b0e0a01a49dac95b5aa61.png', 1, '2024-12-13 18:35:44', '2024-12-13 18:35:44'),
(61, 13, '科技', '<p>hello world</p>', '477d7f1faf693f5cd0bd6ec12e0f9c0f.png', 1, '2024-12-13 18:36:51', '2024-12-13 18:36:51');

-- --------------------------------------------------------

--
-- 表的结构 `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` bigint(20) UNSIGNED NOT NULL,
  `cid` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `likes`
--

INSERT INTO `likes` (`id`, `uid`, `cid`, `created_at`, `updated_at`) VALUES
(1, 1, 54, '2024-12-13 06:45:12', '2024-12-13 06:45:12'),
(2, 1, 57, '2024-12-13 18:45:23', '2024-12-13 18:45:23'),
(3, 1, 60, '2024-12-13 19:20:11', '2024-12-13 19:20:11'),
(4, 1, 58, '2024-12-13 19:20:57', '2024-12-13 19:20:57'),
(5, 2, 60, '2024-12-13 19:23:01', '2024-12-13 19:23:01');

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_12_04_100356_create_admin_user_table', 1),
(2, '2024_12_05_002508_create_category', 2),
(3, '2024_12_06_002824_content', 3),
(4, '2024_12_11_023129_create_adv', 4),
(5, '2024_12_11_114342_create_advcontent', 5);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'xiaoli', 'lihuifeng595@gmail.com', 'Abc123Abc', '2024-12-12 17:55:31', '2024-12-12 17:55:31'),
(2, 'admin', 'lihuifeng595@gmail.com', '123456', '2024-12-13 19:22:33', '2024-12-13 19:22:33');

--
-- 转储表的索引
--

--
-- 表的索引 `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_user_username_unique` (`username`);

--
-- 表的索引 `adv`
--
ALTER TABLE `adv`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `advcontent`
--
ALTER TABLE `advcontent`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- 表的索引 `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `adv`
--
ALTER TABLE `adv`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `advcontent`
--
ALTER TABLE `advcontent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `content`
--
ALTER TABLE `content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=62;

--
-- 使用表AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
