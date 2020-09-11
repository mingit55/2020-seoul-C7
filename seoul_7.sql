-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 20-09-11 11:18
-- 서버 버전: 10.1.30-MariaDB
-- PHP 버전: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `seoul_7`
--
CREATE DATABASE IF NOT EXISTS `seoul_7` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `seoul_7`;

-- --------------------------------------------------------

--
-- 테이블 구조 `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `iid` int(11) NOT NULL,
  `answer` text NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `answers`
--

INSERT INTO `answers` (`id`, `iid`, `answer`, `answered_at`) VALUES
(1, 1, '답변 테스트', '2020-09-10 12:31:42'),
(2, 2, 'ㅁㄴㅇㅁㄴㅇ', '2020-09-10 12:33:06'),
(3, 3, '<script>\r\nalert(\"!!!!!!!\");\r\n</script>', '2020-09-10 12:34:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `artworks`
--

CREATE TABLE `artworks` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `hash_tags` text NOT NULL,
  `uid` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rm_reason` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `artworks`
--

INSERT INTO `artworks` (`id`, `title`, `content`, `hash_tags`, `uid`, `image`, `created_at`, `rm_reason`) VALUES
(1, '테스트', '테스트', '[\"테스트\"]', 3, '1599784124.jpg', '2020-09-11 00:28:44', '그냥 ^^'),
(2, '테스트2', '테스트222', '[\"테스ㅡㅌ\"]', 3, '1599786944.jpg', '2020-09-11 01:15:44', NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `history`
--

INSERT INTO `history` (`id`, `uid`, `point`) VALUES
(1, 5, 110);

-- --------------------------------------------------------

--
-- 테이블 구조 `inquires`
--

CREATE TABLE `inquires` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `inquires`
--

INSERT INTO `inquires` (`id`, `title`, `content`, `created_at`, `uid`) VALUES
(1, '문의 테스트', '테스트', '2020-09-10 12:26:41', 3),
(2, '<script>alert(\'어림도 없지!\')</script>', '<script>alert(\'어떨까요\');</script>\r\n\r\n\r\n\r\n\r\n     ☮☮☮☮☮☮☮☮☮☮☮☮', '2020-09-10 12:28:20', 3),
(3, '문의하기', 'ㄴㄴㅇㅁㄴㅇㅁㅂㄴ', '2020-09-10 12:33:44', 4);

-- --------------------------------------------------------

--
-- 테이블 구조 `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `hasCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `inventory`
--

INSERT INTO `inventory` (`id`, `uid`, `pid`, `hasCount`) VALUES
(2, 5, 2, -3),
(3, 3, 2, 7);

-- --------------------------------------------------------

--
-- 테이블 구조 `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `files` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `notices`
--

INSERT INTO `notices` (`id`, `title`, `content`, `files`, `created_at`) VALUES
(6, '수정 후123', '수정 후123', '[\"1599739876-download (1).tar\"]', '2020-09-10 12:07:59');

-- --------------------------------------------------------

--
-- 테이블 구조 `papers`
--

CREATE TABLE `papers` (
  `id` int(11) NOT NULL,
  `paper_name` varchar(150) NOT NULL,
  `uid` int(11) NOT NULL,
  `width_size` int(11) NOT NULL,
  `height_size` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `hash_tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `papers`
--

INSERT INTO `papers` (`id`, `paper_name`, `uid`, `width_size`, `height_size`, `point`, `image`, `hash_tags`) VALUES
(2, '콩콩 한지', 5, 100, 100, 10, '/uploads/1599741986-2.jpg', '[\"콩콩\"]');

-- --------------------------------------------------------

--
-- 테이블 구조 `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `score` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `scores`
--

INSERT INTO `scores` (`id`, `uid`, `aid`, `score`) VALUES
(1, 5, 2, 4.5),
(2, 4, 2, 0.5);

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `image` varchar(150) NOT NULL,
  `type` varchar(10) NOT NULL,
  `point` int(11) NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`id`, `user_email`, `password`, `user_name`, `image`, `type`, `point`) VALUES
(1, 'admin', '1234', '관리자', '', 'admin', 1000),
(2, 'admin', '1234', '관리자', '', 'admin', 1000),
(3, 'user1@gmail.com', 'qwe123QWE!@#', '일유저', '1599737303-3.jpg', 'normal', 890),
(4, 'user2@gmail.com', 'qwe123QWE!@#', '이유저', '1599741208-2.jpg', 'normal', 1000),
(5, 'company1@gmail.com', 'qwe123QWE!@#', '일회사', '1599741852-beesflow_logo.jpg', 'company', 1110);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `inquires`
--
ALTER TABLE `inquires`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `inquires`
--
ALTER TABLE `inquires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
