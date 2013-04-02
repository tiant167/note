-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 04 月 02 日 14:17
-- 服务器版本: 5.5.29
-- PHP 版本: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `note`
--

-- --------------------------------------------------------

--
-- 表的结构 `note_blog`
--

CREATE TABLE IF NOT EXISTS `note_blog` (
  `blogid` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blogid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `note_blog`
--

INSERT INTO `note_blog` (`blogid`, `userid`, `title`, `content`, `time`) VALUES
(1, 2, '测试仪下', '03f905484be52d91b6c329588e62496db06a37a2cd7b66ce222bf1484611db748b7ed2500a171431e3b21598ad3dff768dbcd03e481d677fbaf5443b31b22d0c4ab0f5aa5ac44fc61f255d7b66a26574b2cbf6799dcdf364b5eb21026ee5be8ce7def279bde043dbed89dfc0f2c8b10303f46edb92cf7ae826b0d976715d05cd1bf25a3b14ac5acbaebe8424f73c3e6c', '2013-04-01 05:40:50'),
(2, 2, '最后是一个问号', '8e02ce6ba744eeea9ef41b18a56f0807b99e178f25e2d1f7d93d73acb03e2e5c9f222c10b064f0b9ea77605cf29f96aa386331889b672972a32c690cc519d6a133b0bfd0fa6240c805b19f25ffd7de7ce586a32733f132190a68ceb3f69a70b676f2cd46b73754e5616395f1760043ec', '2013-03-31 14:16:28');

-- --------------------------------------------------------

--
-- 表的结构 `note_user`
--

CREATE TABLE IF NOT EXISTS `note_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` char(32) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `note_user`
--

INSERT INTO `note_user` (`id`, `username`, `password`) VALUES
(1, '庄坚强', '0a316145ac93d3467ef7d3c8634ff5ea'),
(2, '杜肖肖', '67599cbf7c5c2f93e8a1f92679771bf5');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
