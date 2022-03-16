-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 3 月 16 日 10:32
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `twitter_clone`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `follow_user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `follows`
--

INSERT INTO `follows` (`id`, `status`, `follow_user_id`, `followed_user_id`, `created_at`, `updated_at`) VALUES
(1, 'active', 2, 3, '2021-02-19 07:05:49', '2021-02-19 07:05:49'),
(2, 'active', 2, 1, '2021-02-19 07:05:54', '2021-02-19 07:05:54'),
(3, 'deleted', 1, 3, '2021-11-10 17:13:49', '2021-11-10 17:49:49'),
(4, 'deleted', 1, 3, '2021-11-10 17:14:03', '2021-11-10 17:50:13'),
(5, 'deleted', 1, 3, '2021-11-10 17:17:22', '2021-11-10 17:50:17'),
(6, 'deleted', 1, 3, '2021-11-10 17:50:05', '2021-11-10 17:50:06'),
(7, 'deleted', 1, 3, '2021-11-10 17:50:21', '2021-11-10 17:50:24'),
(8, 'deleted', 1, 3, '2021-11-10 17:50:25', '2021-11-10 17:50:25'),
(9, 'deleted', 1, 3, '2021-11-10 17:50:40', '2021-11-10 17:50:56'),
(10, 'deleted', 1, 3, '2021-11-10 17:51:25', '2021-11-10 17:51:49'),
(11, 'deleted', 1, 3, '2021-11-10 18:01:08', '2021-11-10 18:01:09'),
(12, 'deleted', 1, 3, '2021-11-10 18:01:32', '2021-11-10 18:03:33'),
(13, 'deleted', 1, 2, '2021-11-10 18:06:41', '2021-11-10 18:06:44'),
(14, 'deleted', 1, 2, '2021-11-10 19:03:24', '2021-11-11 10:22:22'),
(15, 'deleted', 1, 2, '2021-11-11 10:23:02', '2021-11-11 10:35:00'),
(16, 'deleted', 1, 2, '2021-11-11 10:35:11', '2021-11-11 10:36:38'),
(17, 'deleted', 1, 2, '2021-11-11 10:39:27', '2021-11-11 10:39:28'),
(18, 'active', 1, 2, '2021-11-11 10:39:29', '2021-11-11 10:39:29'),
(19, 'active', 1, 3, '2021-11-11 13:01:24', '2021-11-11 13:01:24'),
(20, 'deleted', 3, 2, '2021-11-11 15:26:52', '2021-11-11 15:27:13'),
(21, 'active', 3, 1, '2021-11-11 15:27:06', '2021-11-11 15:27:06'),
(22, 'active', 9, 1, '2022-03-05 14:31:17', '2022-03-05 14:31:17');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`id`, `status`, `user_id`, `tweet_id`, `created_at`, `updated_at`) VALUES
(1, 'active', 2, 12, '2021-02-19 07:17:43', '2021-02-19 07:17:43'),
(2, 'deleted', 2, 5, '2021-02-19 07:17:58', '2021-02-19 07:17:58'),
(3, 'active', 2, 7, '2021-02-19 07:17:59', '2021-02-19 07:17:59'),
(4, 'active', 2, 14, '2021-02-19 07:18:01', '2021-02-19 07:18:01'),
(5, 'active', 2, 16, '2021-02-19 07:18:06', '2021-02-19 07:18:06'),
(6, 'active', 2, 18, '2021-02-19 07:18:06', '2021-02-19 07:18:06'),
(7, 'deleted', 4, 4, '2021-11-08 12:56:53', '2021-11-08 12:56:53'),
(8, 'deleted', 4, 4, '2021-11-08 12:56:55', '2021-11-08 12:56:55'),
(9, 'deleted', 4, 4, '2021-11-08 12:57:02', '2021-11-08 12:57:02'),
(10, 'deleted', 4, 4, '2021-11-08 12:57:06', '2021-11-08 12:57:06'),
(11, 'deleted', 4, 4, '2021-11-08 13:07:29', '2021-11-08 13:07:29'),
(12, 'deleted', 4, 4, '2021-11-08 13:10:07', '2021-11-08 13:10:07'),
(13, 'deleted', 4, 5, '2021-11-08 13:10:20', '2021-11-08 13:10:20'),
(14, 'deleted', 4, 6, '2021-11-08 13:11:51', '2021-11-08 13:11:51'),
(15, 'deleted', 4, 4, '2021-11-08 13:13:23', '2021-11-08 13:13:23'),
(16, 'deleted', 4, 7, '2021-11-08 13:14:08', '2021-11-08 13:14:08'),
(17, 'deleted', 4, 7, '2021-11-08 13:14:09', '2021-11-08 13:14:09'),
(18, 'deleted', 4, 4, '2021-11-08 13:14:12', '2021-11-08 13:14:12'),
(19, 'deleted', 4, 4, '2021-11-08 13:14:25', '2021-11-08 13:14:25'),
(20, 'deleted', 4, 4, '2021-11-08 13:14:38', '2021-11-08 13:14:38'),
(21, 'deleted', 1, 10, '2021-11-10 19:03:26', '2021-11-10 19:03:26'),
(22, 'deleted', 1, 10, '2021-11-10 19:03:29', '2021-11-10 19:03:29'),
(23, 'active', 1, 9, '2021-11-11 10:22:16', '2021-11-11 10:22:16'),
(24, 'deleted', 1, 10, '2021-11-11 10:23:11', '2021-11-11 10:23:11'),
(25, 'deleted', 1, 10, '2021-11-11 10:25:56', '2021-11-11 10:25:56'),
(26, 'deleted', 1, 10, '2021-11-11 10:29:05', '2021-11-11 10:29:05'),
(27, 'deleted', 1, 10, '2021-11-11 10:30:12', '2021-11-11 10:30:12'),
(28, 'active', 1, 10, '2021-11-11 10:35:24', '2021-11-11 10:35:24'),
(29, 'active', 1, 10, '2021-11-11 10:35:33', '2021-11-11 10:35:33'),
(30, 'active', 1, 10, '2021-11-11 10:45:28', '2021-11-11 10:45:28'),
(31, 'active', 1, 10, '2021-11-11 10:47:56', '2021-11-11 10:47:56'),
(32, 'active', 1, 10, '2021-11-11 10:48:00', '2021-11-11 10:48:00'),
(33, 'active', 1, 10, '2021-11-11 10:51:33', '2021-11-11 10:51:33'),
(34, 'deleted', 1, 13, '2021-11-11 10:51:48', '2021-11-11 10:51:48'),
(35, 'deleted', 1, 13, '2021-11-11 10:54:54', '2021-11-11 10:54:54'),
(36, 'deleted', 1, 13, '2021-11-11 10:55:33', '2021-11-11 10:55:33'),
(37, 'deleted', 1, 13, '2021-11-11 10:56:14', '2021-11-11 10:56:14'),
(38, 'deleted', 1, 13, '2021-11-11 10:59:56', '2021-11-11 10:59:56'),
(39, 'deleted', 1, 13, '2021-11-11 11:03:48', '2021-11-11 11:03:48'),
(40, 'deleted', 1, 13, '2021-11-11 11:04:42', '2021-11-11 11:04:42'),
(41, 'deleted', 1, 12, '2021-11-11 11:06:08', '2021-11-11 11:06:08'),
(42, 'deleted', 1, 13, '2021-11-11 11:06:10', '2021-11-11 11:06:10'),
(43, 'deleted', 1, 12, '2021-11-11 11:08:30', '2021-11-11 11:08:30'),
(44, 'deleted', 1, 13, '2021-11-11 11:11:08', '2021-11-11 11:11:08'),
(45, 'deleted', 1, 12, '2021-11-11 11:11:16', '2021-11-11 11:11:16'),
(46, 'deleted', 1, 12, '2021-11-11 11:12:34', '2021-11-11 11:12:34'),
(47, 'deleted', 1, 13, '2021-11-11 11:12:37', '2021-11-11 11:12:37'),
(48, 'deleted', 1, 13, '2021-11-11 11:13:37', '2021-11-11 11:13:37'),
(49, 'deleted', 1, 13, '2021-11-11 11:15:00', '2021-11-11 11:15:00'),
(50, 'deleted', 1, 13, '2021-11-11 11:16:48', '2021-11-11 11:16:48'),
(51, 'deleted', 1, 13, '2021-11-11 11:19:42', '2021-11-11 11:19:42'),
(52, 'deleted', 1, 11, '2021-11-11 11:20:15', '2021-11-11 11:20:15'),
(53, 'deleted', 1, 13, '2021-11-11 11:20:52', '2021-11-11 11:20:52'),
(54, 'deleted', 1, 13, '2021-11-11 11:21:27', '2021-11-11 11:21:27'),
(55, 'deleted', 1, 13, '2021-11-11 11:22:14', '2021-11-11 11:22:14'),
(56, 'deleted', 1, 13, '2021-11-11 11:22:23', '2021-11-11 11:22:23'),
(57, 'deleted', 1, 11, '2021-11-11 11:22:33', '2021-11-11 11:22:33'),
(58, 'deleted', 1, 11, '2021-11-11 11:22:43', '2021-11-11 11:22:43'),
(59, 'deleted', 1, 11, '2021-11-11 11:22:58', '2021-11-11 11:22:58'),
(60, 'deleted', 1, 11, '2021-11-11 11:25:02', '2021-11-11 11:25:02'),
(61, 'deleted', 1, 13, '2021-11-11 11:25:56', '2021-11-11 11:25:56'),
(62, 'deleted', 1, 12, '2021-11-11 11:27:03', '2021-11-11 11:27:03'),
(63, 'deleted', 1, 13, '2021-11-11 11:27:42', '2021-11-11 11:27:42'),
(64, 'deleted', 1, 13, '2021-11-11 11:28:01', '2021-11-11 11:28:01'),
(65, 'active', 1, 20, '2021-11-11 11:30:38', '2021-11-11 11:30:38'),
(66, 'deleted', 1, 6, '2021-11-11 11:35:00', '2021-11-11 11:35:00'),
(67, 'deleted', 1, 12, '2021-11-11 11:35:09', '2021-11-11 11:35:09'),
(68, 'deleted', 1, 12, '2021-11-11 11:40:09', '2021-11-11 11:40:09'),
(69, 'deleted', 1, 12, '2021-11-11 11:42:48', '2021-11-11 11:42:48'),
(70, 'deleted', 1, 13, '2021-11-11 11:44:42', '2021-11-11 11:44:42'),
(71, 'active', 1, 3, '2021-11-11 11:46:11', '2021-11-11 11:46:11'),
(72, 'active', 1, 19, '2021-11-11 11:46:54', '2021-11-11 11:46:54'),
(73, 'deleted', 1, 13, '2021-11-11 11:47:24', '2021-11-11 11:47:24'),
(74, 'deleted', 1, 13, '2021-11-11 11:47:25', '2021-11-11 11:47:25'),
(75, 'deleted', 1, 13, '2021-11-11 11:53:00', '2021-11-11 11:53:00'),
(76, 'deleted', 1, 12, '2021-11-11 11:54:07', '2021-11-11 11:54:07'),
(77, 'active', 1, 12, '2021-11-11 11:54:29', '2021-11-11 11:54:29'),
(78, 'deleted', 1, 13, '2021-11-11 11:56:43', '2021-11-11 11:56:43'),
(79, 'deleted', 1, 13, '2021-11-11 12:00:39', '2021-11-11 12:00:39'),
(80, 'deleted', 1, 13, '2021-11-11 12:05:10', '2021-11-11 12:05:10'),
(81, 'deleted', 1, 13, '2021-11-11 12:06:51', '2021-11-11 12:06:51'),
(82, 'deleted', 1, 13, '2021-11-11 12:06:53', '2021-11-11 12:06:53'),
(83, 'active', 1, 13, '2021-11-11 13:01:26', '2021-11-11 13:01:26'),
(84, 'deleted', 9, 23, '2022-03-05 13:23:40', '2022-03-05 13:23:40'),
(85, 'deleted', 9, 23, '2022-03-05 13:23:41', '2022-03-05 13:23:41'),
(86, 'deleted', 9, 23, '2022-03-05 13:23:41', '2022-03-05 13:23:41'),
(87, 'deleted', 9, 23, '2022-03-05 13:23:54', '2022-03-05 13:23:54'),
(88, 'active', 9, 23, '2022-03-06 12:50:49', '2022-03-06 12:50:49'),
(89, 'deleted', 9, 24, '2022-03-06 12:51:13', '2022-03-06 12:51:13'),
(90, 'active', 9, 24, '2022-03-06 12:51:26', '2022-03-06 12:51:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `received_user_id` int(11) NOT NULL,
  `sent_user_id` int(11) NOT NULL,
  `message` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `notifications`
--

INSERT INTO `notifications` (`id`, `status`, `received_user_id`, `sent_user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 'active', 3, 2, 'フォローされました。', '2021-02-19 07:05:49', '2021-02-19 07:05:49'),
(2, 'active', 1, 2, 'フォローされました。', '2021-02-19 07:05:54', '2021-02-19 07:05:54'),
(3, 'active', 3, 2, 'いいね！されました。', '2021-02-19 07:17:43', '2021-02-19 07:17:43'),
(4, 'active', 1, 2, 'いいね！されました。', '2021-02-19 07:17:58', '2021-02-19 07:17:58'),
(5, 'active', 2, 1, 'フォローされました。', '2021-11-10 19:03:24', '2021-11-10 19:03:24'),
(6, 'active', 2, 1, 'フォローされました。', '2021-11-11 10:23:02', '2021-11-11 10:23:02'),
(7, 'active', 2, 1, 'フォローされました。', '2021-11-11 10:35:11', '2021-11-11 10:35:11'),
(8, 'active', 2, 1, 'フォローされました。', '2021-11-11 10:39:27', '2021-11-11 10:39:27'),
(9, 'active', 2, 1, 'フォローされました。', '2021-11-11 10:39:29', '2021-11-11 10:39:29'),
(10, 'active', 3, 1, 'いいね！されました。', '2021-11-11 12:06:51', '2021-11-11 12:06:51'),
(11, 'active', 3, 1, 'いいね！されました。', '2021-11-11 12:06:53', '2021-11-11 12:06:53'),
(12, 'active', 3, 1, 'フォローされました。', '2021-11-11 13:01:24', '2021-11-11 13:01:24'),
(13, 'active', 3, 1, 'いいね！されました。', '2021-11-11 13:01:26', '2021-11-11 13:01:26'),
(14, 'active', 2, 3, 'フォローされました。', '2021-11-11 15:26:52', '2021-11-11 15:26:52'),
(15, 'active', 1, 3, 'フォローされました。', '2021-11-11 15:27:06', '2021-11-11 15:27:06'),
(16, 'active', 8, 9, 'いいね！されました。', '2022-03-05 13:23:40', '2022-03-05 13:23:40'),
(17, 'active', 8, 9, 'いいね！されました。', '2022-03-05 13:23:41', '2022-03-05 13:23:41'),
(18, 'active', 8, 9, 'いいね！されました。', '2022-03-05 13:23:41', '2022-03-05 13:23:41'),
(19, 'active', 8, 9, 'いいね！されました。', '2022-03-05 13:23:54', '2022-03-05 13:23:54'),
(20, 'active', 1, 9, 'フォローされました。', '2022-03-05 14:31:17', '2022-03-05 14:31:17'),
(21, 'active', 8, 9, 'いいね！されました。', '2022-03-06 12:50:49', '2022-03-06 12:50:49'),
(22, 'active', 9, 9, 'いいね！されました。', '2022-03-06 12:51:13', '2022-03-06 12:51:13'),
(23, 'active', 9, 9, 'いいね！されました。', '2022-03-06 12:51:26', '2022-03-06 12:51:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `replys`
--

DROP TABLE IF EXISTS `replys`;
CREATE TABLE `replys` (
  `id` int(11) NOT NULL,
  `tweet_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `reply_body` varchar(140) NOT NULL,
  `edit` varchar(15) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `replys`
--

INSERT INTO `replys` (`id`, `tweet_id`, `user_id`, `reply_body`, `edit`, `created_at`, `updated_at`) VALUES
(1, 0, 9, 'hello', NULL, '2022-03-06 15:49:33', '2022-03-06 15:49:33'),
(2, NULL, 9, 'tesu', NULL, '2022-03-06 15:56:24', '2022-03-06 15:56:24'),
(3, 20, 9, 'hellohello', NULL, '2022-03-06 16:00:35', '2022-03-06 16:00:35'),
(4, 24, 9, 'ddd', NULL, '2022-03-06 16:10:20', '2022-03-06 16:10:20'),
(5, 24, 9, 'hello', NULL, '2022-03-06 16:13:20', '2022-03-06 16:13:20'),
(6, 21, 9, '森', NULL, '2022-03-07 16:32:03', '2022-03-07 16:32:03'),
(7, 16, 9, 'hello', NULL, '2022-03-07 16:46:40', '2022-03-07 16:46:40'),
(8, 24, 9, 'テスト', NULL, '2022-03-07 17:01:20', '2022-03-07 17:01:20'),
(9, 24, 9, 'こんにちは', NULL, '2022-03-07 17:01:27', '2022-03-07 17:01:27'),
(10, 24, 9, 'ありがとう', NULL, '2022-03-07 17:04:22', '2022-03-07 17:04:22'),
(11, 21, 9, '綺麗', '管理者により編集されました。', '2022-03-15 21:52:52', '2022-03-15 21:52:52'),
(12, 17, 9, 'リプライがありません', '管理者により削除されました。', '2022-03-15 21:57:45', '2022-03-15 21:57:45'),
(13, 17, 9, 'good', NULL, '2022-03-15 22:03:42', '2022-03-15 22:03:42'),
(14, 33, 9, 'リプライがありません', '管理者により削除されました。', '2022-03-15 22:18:07', '2022-03-15 22:18:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `tweets`
--

DROP TABLE IF EXISTS `tweets`;
CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `user_id` int(11) NOT NULL,
  `body` varchar(140) NOT NULL,
  `edit` varchar(15) DEFAULT NULL,
  `image_name` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `tweets`
--

INSERT INTO `tweets` (`id`, `status`, `user_id`, `body`, `edit`, `image_name`, `created_at`, `updated_at`) VALUES
(1, 'active', 2, 'hello', NULL, NULL, '2018-01-19 05:32:02', '2018-01-19 05:32:02'),
(2, 'active', 2, 'いいいいい\r\nいいいいい', NULL, NULL, '2018-02-20 05:32:15', '2018-02-20 05:32:15'),
(3, 'active', 2, 'ううううう\r\nううううう', NULL, NULL, '2018-08-05 05:32:30', '2018-08-05 05:32:30'),
(4, 'active', 1, '太郎1です', NULL, NULL, '2018-08-21 06:32:57', '2018-08-21 06:32:57'),
(5, 'active', 1, '太郎1のつぶやき2', NULL, NULL, '2019-03-22 05:33:12', '2019-03-22 05:33:12'),
(6, 'active', 1, '太郎1のつぶやき3', NULL, NULL, '2019-04-09 05:33:38', '2019-04-09 05:33:38'),
(7, 'active', 1, '太郎1のつぶやき4', NULL, NULL, '2019-11-10 05:33:54', '2019-11-10 05:33:54'),
(8, 'active', 1, '太郎1のつぶやき5', NULL, NULL, '2019-12-01 05:34:40', '2019-12-01 05:34:40'),
(9, 'active', 2, 'えええええ\r\nえええええ', NULL, NULL, '2020-06-18 05:35:10', '2020-06-18 05:35:10'),
(10, 'active', 2, 'おおおおお\r\nおおおおお', NULL, NULL, '2020-07-11 05:35:17', '2020-07-11 05:35:17'),
(12, 'active', 3, 'YYY', NULL, NULL, '2020-10-25 05:35:31', '2020-10-25 05:35:31'),
(13, 'active', 3, 'ZZZ', NULL, NULL, '2021-01-03 05:35:34', '2021-01-03 05:35:34'),
(14, 'active', 1, '太郎1のつぶやき6', NULL, NULL, '2021-01-19 05:35:57', '2021-01-19 05:35:57'),
(16, 'active', 1, 'ツイートがありません', '管理者により削除されました。', NULL, '2021-03-10 05:40:04', '2021-03-10 05:40:04'),
(17, 'active', 1, '太郎1のつぶやき9', NULL, 'sample-post.jpg', '2021-04-05 05:36:07', '2021-04-05 05:36:07'),
(18, 'active', 1, '太郎1のつぶやき10', NULL, NULL, '2021-04-18 12:36:12', '2021-04-18 12:36:12'),
(20, 'active', 4, 'こんにちは', NULL, NULL, '2021-11-08 15:55:05', '2021-11-08 15:55:05'),
(21, 'active', 4, 'forest', '管理者により編集されました。', '4_20211108155519.jpeg', '2021-11-08 15:55:19', '2021-11-08 15:55:19'),
(23, 'active', 8, 'ツイートがありません', '管理者により削除されました。', NULL, '2022-01-26 14:27:49', '2022-01-26 14:27:49'),
(31, 'active', 9, 'ツイートがありません', '管理者により削除されました。', NULL, '2022-03-12 16:57:31', '2022-03-12 16:57:31'),
(32, 'active', 9, 'test2', NULL, NULL, '2022-03-12 16:57:34', '2022-03-12 16:57:34'),
(33, 'active', 9, 'ツイートがありません', '管理者により削除されました。', NULL, '2022-03-15 22:16:25', '2022-03-15 22:16:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `manager` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `nickname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(128) NOT NULL,
  `image_name` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `manager`, `status`, `nickname`, `name`, `email`, `password`, `image_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'active', '太郎1', 'user1', 'test1@example.com', '$2y$10$vH3LhLuEfhLPxtpxsQ7z8.ZEkXZQqfLX9uFG9snf30EZedPB58LJW', 'sample-person.jpg', '2021-02-19 05:28:51', '2021-02-19 05:28:51'),
(2, NULL, 'active', 'kebin2', 'kebin2', 'kebint2@example.com', '$2y$10$ywiY/hMt0vkrwxGkEEufqufmTW4w27JpOisYEgKU/Hh93X/V08inO', '2_20211110131117.jpeg', '2021-02-19 05:30:36', '2021-11-10 13:11:17'),
(3, NULL, 'active', '太郎3', 'taro3', 'taro3@example.com', '$2y$10$EfgOLU4ABSDy1LMxGndW2e9PZvPJzjTucEr3A6hGIUEuYQe2ETcsy', '3_20211110132907.jpeg', '2021-02-19 05:31:13', '2021-11-10 13:30:21'),
(4, NULL, 'active', 'テスト', 'test', 'test@tech', '$2y$10$3hb7tohFppfTWirovoaB8elqaczHeyesXNj0bq2dZdUxrnU.GM8Em', NULL, '2021-11-08 12:15:58', '2021-11-08 12:15:58'),
(5, NULL, 'active', '太郎', 'taro10', 'test@tech', '$2y$10$Ot0P.SfOfDDMwkdiRqEE/uuKhy49TDTq98lOV3hxuR2eDCPDPf4Vm', NULL, '2021-11-25 16:30:57', '2021-11-25 16:30:57'),
(6, NULL, 'active', '太郎', 'taro', 'test@tech', '$2y$10$Rbje/nlKykEWBB7f3LVKLeba5Eb2NSGGEgOp2kKH4Xy9WBibzl8ja', NULL, '2021-11-25 16:31:25', '2021-11-25 16:31:25'),
(7, NULL, 'active', 'たなか', 'tanaka', 'tanaka@cloud.com', '$2y$10$4ubhdotwtsZVqpuhL8svgeCm2lPskPu1xzwTOBXCe9XKsTOQjFyU.', NULL, '2021-11-25 16:50:11', '2021-11-25 16:50:11'),
(8, NULL, 'active', 'test1111', 'test1111', 'test1111@test', '$2y$10$4jk/ytBaxpkViPUR8p0dreaGBz8PEbE.7FPR0KJa1xWYvxJLH.Yl6', NULL, '2022-01-26 14:26:37', '2022-01-26 14:26:37'),
(9, NULL, 'active', 'ziro', 'ziroziro', 'ziroziro@test', '$2y$10$HdZ90M21pJw7wlLQjVkKIOpImDkkqqvVTmOMyIoJ7f9U5awbhb1ju', NULL, '2022-03-05 13:00:42', '2022-03-05 13:00:42'),
(14, 'active', 'active', '管理者', 'manager', 'management@test', '$2y$10$MsJp8n81wxPjh4RZ2XR9eubrszSmNnJRaE200AdwgU6qd1dUSn5/m', NULL, '2022-03-07 18:08:48', '2022-03-07 18:08:48');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `follow_user_id` (`follow_user_id`),
  ADD KEY `followed_user_id` (`followed_user_id`);

--
-- テーブルのインデックス `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tweet_id` (`tweet_id`);

--
-- テーブルのインデックス `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `received_user_id` (`received_user_id`),
  ADD KEY `sent_user_id` (`sent_user_id`);

--
-- テーブルのインデックス `replys`
--
ALTER TABLE `replys`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `body` (`body`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `nickname` (`nickname`),
  ADD KEY `name` (`name`),
  ADD KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- テーブルの AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- テーブルの AUTO_INCREMENT `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `replys`
--
ALTER TABLE `replys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
