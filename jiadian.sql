-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-14 04:31:43
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jiadian`
--
CREATE DATABASE IF NOT EXISTS `jiadian` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jiadian`;

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(600) NOT NULL,
  `jiadianid` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `zongjia` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jiadianid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `addtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `jiadianid`, `username`, `comment`, `addtime`) VALUES
(13, 14, '00001', '168', '2016-11-13 20:47:49'),
(14, 15, '00001', '这电视不会炸吧！', '2016-11-13 22:57:28');

-- --------------------------------------------------------

--
-- 表的结构 `jiadian`
--

CREATE TABLE IF NOT EXISTS `jiadian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(600) NOT NULL,
  `img` varchar(150) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `jiadian`
--

INSERT INTO `jiadian` (`id`, `name`, `img`, `description`, `price`) VALUES
(5, '海尔冰箱 BCD-196TMPI双开门', 'image/58287b2bead99.jpg', '196升热销冰箱，适合三口之家使用，两天约1度电。优质发泡料，超微孔发泡更均匀，保温效果更好；自动低温补偿，根据外部温度变化自动调节制冷温度；压花铝板蒸发器，制冷快，耐腐蚀；角蒸发器，底部抽屉双面制冷，食材真正冻透。', 1999),
(11, '美的冰箱 36分贝图书馆级静音', 'image/58287bc59cbab.jpg', '时尚活力面板，36分贝静音生活，两天不到一度电', 990),
(12, '小米电视机', 'image/58287c1e28c64.jpg', '用户体检为本', 3500),
(13, '奥克斯空调', 'image/58287c7dca7f2.jpg', '一天只用一度电，变频二级能效，30秒速冷，PID遥感低温除湿！', 1500),
(14, '海尔高效定频壁挂式空调', 'image/58287d56adbad.jpg', '海尔高效定频壁挂式空调 KFR-33GW/10EBBAL13U1套机', 1800),
(15, '三星LED液晶电视', 'image/58287dc3b277d.jpg', '三星(SAMSUNG) UA55JU50SWJXXZ 55英寸 4K超高清 网络 智能 LED液晶电视', 3000);

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `addtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `addtime`) VALUES
(1, '此时不买家电更待何时！', '11周年店庆，全场9.5折，满30000元赠送小米电视一台，送完为止，你还在等什么！', '2016-11-13 22:14:26'),
(2, '双十一家电跳楼大甩卖', '不是9折，不是8折，而是全场5折！从未有过的优惠力度', '2016-11-13 22:16:10');

-- --------------------------------------------------------

--
-- 表的结构 `orderlist`
--

CREATE TABLE IF NOT EXISTS `orderlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(600) NOT NULL,
  `jiadianid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `zongjia` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` varchar(200) NOT NULL DEFAULT '未填写',
  `status` varchar(20) DEFAULT '未处理',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `orderlist`
--

INSERT INTO `orderlist` (`id`, `username`, `jiadianid`, `name`, `price`, `number`, `zongjia`, `time`, `addtime`, `address`, `status`) VALUES
(21, '00001', 15, '三星LED液晶电视', 3000, 2, 6000, '2016-11-13 22:57:16', '2016-11-13 14:57:37', '', '已处理'),
(22, '00001', 5, '海尔冰箱 BCD-196TMPI双开门', 1999, 2, 3998, '2016-11-14 11:25:56', '2016-11-14 03:26:03', '东软', '未处理'),
(23, '00001', 11, '美的冰箱 36分贝图书馆级静音', 990, 1, 990, '2016-11-14 11:26:29', '2016-11-14 03:26:36', 'wojia', '未处理'),
(24, '00001', 5, '海尔冰箱 BCD-196TMPI双开门', 1999, 1, 1999, '2016-11-14 11:29:49', '2016-11-14 03:30:00', 'wojia', '未处理'),
(25, '00001', 14, '海尔高效定频壁挂式空调', 1800, 1, 1800, '2016-11-14 11:29:54', '2016-11-14 03:30:00', 'wojia', '未处理');

-- --------------------------------------------------------

--
-- 表的结构 `slideshow`
--

CREATE TABLE IF NOT EXISTS `slideshow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `slideshow`
--

INSERT INTO `slideshow` (`id`, `url`) VALUES
(1, '78523'),
(2, '554'),
(3, '4787');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(16) NOT NULL,
  `rank` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `rank`) VALUES
(21, '121', '121', '普通会员'),
(22, 'lll', '123', 'vip会员'),
(23, '00001', '123456789', 'vip会员');

-- --------------------------------------------------------

--
-- 表的结构 `useradmin`
--

CREATE TABLE IF NOT EXISTS `useradmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `useradmin`
--

INSERT INTO `useradmin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
