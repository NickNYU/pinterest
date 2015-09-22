-- phpMyAdmin SQL Dump
-- version 4.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-09-22 14:42:05
-- 服务器版本： 5.5.42
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pinterest`
--

-- --------------------------------------------------------

--
-- 表的结构 `board`
--

CREATE TABLE IF NOT EXISTS `board` (
  `bid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `bname` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `builttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lasttime` datetime DEFAULT NULL,
  `secret` binary(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `board`
--

INSERT INTO `board` (`bid`, `uid`, `bname`, `description`, `category`, `builttime`, `lasttime`, `secret`) VALUES
(14, 494287, 'first', '', '', '2015-04-29 13:57:44', NULL, 0x30),
(15, 494287, 'Second', 'nice try', 'picture', '2015-04-30 02:48:14', NULL, 0x30),
(16, 494288, 'Jacobs', 'nice try', 'picture', '2015-04-30 03:22:25', NULL, 0x30);

--
-- 触发器 `board`
--
DELIMITER $$
CREATE TRIGGER `createboardcover` AFTER INSERT ON `board`
 FOR EACH ROW begin
    insert into cover(bid,pid) values (NEW.bid,103);

    
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `board_pins`
--
CREATE TABLE IF NOT EXISTS `board_pins` (
`bid` int(11)
,`bname` varchar(50)
,`num` bigint(21)
);

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `bid` int(11) NOT NULL DEFAULT '0',
  `comtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 触发器 `comment`
--
DELIMITER $$
CREATE TRIGGER `deletecomment` BEFORE INSERT ON `comment`
 FOR EACH ROW begin
    if NEW.bid in (
        (select bid 
        from BOARD 
        where  secret = 1 and uid<>NEW.uid and uid  not in (
            select uid1 from friendship where uid2 = NEW.uid) and
         uid not in (select uid2 from friendship where uid1 = NEW.uid))
        )
    then delete from NEW;
    end if;

end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `cover`
--

CREATE TABLE IF NOT EXISTS `cover` (
  `bid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `cover`
--

INSERT INTO `cover` (`bid`, `pid`) VALUES
(14, 103),
(15, 103),
(16, 103);

-- --------------------------------------------------------

--
-- 表的结构 `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `bid` int(11) NOT NULL DEFAULT '0',
  `followtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `friendrequest`
--

CREATE TABLE IF NOT EXISTS `friendrequest` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `fre_uid` int(11) NOT NULL DEFAULT '0',
  `requesttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `replytime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `friendship`
--
CREATE TABLE IF NOT EXISTS `friendship` (
`uid1` int(11)
,`uid2` int(11)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `like_num`
--
CREATE TABLE IF NOT EXISTS `like_num` (
`pid` int(11)
,`num` bigint(21)
);

-- --------------------------------------------------------

--
-- 表的结构 `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `pid` int(11) NOT NULL,
  `link` varchar(500) DEFAULT NULL,
  `local` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `picture`
--

INSERT INTO `picture` (`pid`, `link`, `local`) VALUES
(103, 'http://www.independent.co.uk/incoming/article8465213.ece/alternates/w620/v2-cute-cat-picture.jpg', 'http://www.independent.co.uk/incoming/article8465213.ece/alternates/w620/v2-cute-cat-picture.jpg'),
(104, NULL, 'picture/1430315901.jpg'),
(105, NULL, 'picture/1430315939.jpg'),
(106, NULL, 'picture/1430315964.jpg'),
(107, NULL, 'picture/1430316003.jpg'),
(108, NULL, 'picture/1430316029.jpg'),
(109, NULL, 'picture/1430316051.jpg'),
(110, NULL, 'picture/1430316273.jpg'),
(111, NULL, 'picture/1430316323.jpg'),
(112, NULL, 'picture/1430316396.jpg'),
(113, NULL, 'picture/1430316416.jpg'),
(114, NULL, 'picture/1430316433.jpg'),
(115, NULL, 'picture/1430316619.jpg'),
(116, NULL, 'picture/1430316638.jpg'),
(117, NULL, 'picture/1430317016.jpg'),
(119, NULL, 'picture/1430317376.jpg'),
(120, NULL, 'picture/1430317529.png'),
(121, NULL, 'picture/1430317849.jpg'),
(123, 'http://images.shibashake.com/wp-content/blogs.dir/7/files/2010/03/IMG_1239.jpg', 'picture/1430362640.jpeg'),
(124, NULL, 'picture/1430362665.jpg'),
(125, NULL, 'picture/1430362682.jpg'),
(126, NULL, 'picture/1430362692.jpg'),
(127, NULL, 'picture/1430362703.jpg'),
(128, NULL, 'picture/1430362722.jpg'),
(129, NULL, 'picture/1430364174.jpg'),
(130, NULL, 'picture/1430364322.jpg');

--
-- 触发器 `picture`
--
DELIMITER $$
CREATE TRIGGER `deletepin` BEFORE DELETE ON `picture`
 FOR EACH ROW begin
   
     delete from pin where pin.pid=OLD.pid;
   
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `pic_repins`
--
CREATE TABLE IF NOT EXISTS `pic_repins` (
`pid` int(11)
,`num` bigint(21)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `pic_user`
--
CREATE TABLE IF NOT EXISTS `pic_user` (
`pid` int(11)
,`uid1` int(11)
,`uid2` int(11)
);

-- --------------------------------------------------------

--
-- 表的结构 `pin`
--

CREATE TABLE IF NOT EXISTS `pin` (
  `pid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `ptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `prebid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `pin`
--

INSERT INTO `pin` (`pid`, `bid`, `ptime`, `tag`, `description`, `prebid`) VALUES
(104, 14, '2015-04-29 13:58:21', NULL, 'first_picture', NULL),
(105, 14, '2015-04-29 13:58:59', NULL, 'second', NULL),
(106, 14, '2015-04-29 13:59:24', NULL, '', NULL),
(107, 14, '2015-04-29 14:00:03', NULL, '', NULL),
(108, 14, '2015-04-29 14:00:29', NULL, '', NULL),
(109, 14, '2015-04-29 14:00:51', NULL, '', NULL),
(110, 14, '2015-04-29 14:04:33', NULL, '', NULL),
(111, 14, '2015-04-29 14:05:23', NULL, '', NULL),
(112, 14, '2015-04-29 14:06:36', NULL, '', NULL),
(113, 14, '2015-04-29 14:06:56', NULL, '', NULL),
(114, 14, '2015-04-29 14:07:13', NULL, '', NULL),
(115, 14, '2015-04-29 14:10:19', NULL, '', NULL),
(116, 14, '2015-04-29 14:10:38', NULL, '', NULL),
(117, 14, '2015-04-29 14:16:56', NULL, '', NULL),
(121, 14, '2015-04-29 14:30:49', NULL, '', NULL),
(119, 14, '2015-04-29 14:22:56', NULL, '', NULL),
(120, 14, '2015-04-29 14:25:29', NULL, '', NULL),
(125, 15, '2015-04-30 02:58:02', NULL, '', NULL),
(123, 14, '2015-04-30 02:57:20', NULL, 'Husky', NULL),
(124, 15, '2015-04-30 02:57:45', NULL, 'Girl', NULL),
(126, 15, '2015-04-30 02:58:12', NULL, '', NULL),
(127, 14, '2015-04-30 02:58:23', NULL, '', NULL),
(128, 15, '2015-04-30 02:58:42', NULL, '', NULL),
(129, 16, '2015-04-30 03:22:54', NULL, '', NULL),
(130, 16, '2015-04-30 03:25:22', NULL, '', NULL);

--
-- 触发器 `pin`
--
DELIMITER $$
CREATE TRIGGER `insertcover` AFTER UPDATE ON `pin`
 FOR EACH ROW begin
    if NEW.bid  in 
        (select bid 
        from cover where pid =31
        )
    then update cover set cover.pid=NEW.pid where cover.bid=NEW.bid;
    end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `uid` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `profile`
--

INSERT INTO `profile` (`uid`, `pid`, `birthday`, `address`, `gender`, `update_time`) VALUES
(494287, NULL, NULL, NULL, NULL, '2015-04-29 13:42:52'),
(494288, NULL, NULL, NULL, NULL, '2015-04-30 03:21:10');

-- --------------------------------------------------------

--
-- 表的结构 `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `ratetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `similar`
--
CREATE TABLE IF NOT EXISTS `similar` (
`uid1` int(11)
,`uid2` int(11)
,`bid1` int(11)
,`bid2` int(11)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `sum`
--
CREATE TABLE IF NOT EXISTS `sum` (
`uid1` int(11)
,`uid2` int(11)
,`num` bigint(21)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `sum_pic`
--
CREATE TABLE IF NOT EXISTS `sum_pic` (
`uid1` int(11)
,`uid2` int(11)
,`num` bigint(21)
);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL,
  `uname` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(12) DEFAULT NULL,
  `builttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `logintime` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=494289 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`uid`, `uname`, `email`, `password`, `builttime`, `logintime`) VALUES
(494287, 'chen', 'cz739@nyu.edu', 'zhuchen', '2015-04-29 13:42:52', '2015-04-30 20:29:34'),
(494288, 'jacob', 'jw3122@nyu.edu', 'wangjingbo', '2015-04-30 03:21:10', NULL);

--
-- 触发器 `user`
--
DELIMITER $$
CREATE TRIGGER `createprofile` AFTER INSERT ON `user`
 FOR EACH ROW begin
	insert into profile(uid) values (NEW.uid);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `your_repins`
--
CREATE TABLE IF NOT EXISTS `your_repins` (
`uid` int(11)
,`pid` int(11)
);

-- --------------------------------------------------------

--
-- 视图结构 `board_pins`
--
DROP TABLE IF EXISTS `board_pins`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `board_pins` AS (select `b`.`bid` AS `bid`,`b`.`bname` AS `bname`,count(0) AS `num` from (`board` `b` join `pin` `p`) where (`b`.`bid` = `p`.`bid`) group by `b`.`bid`);

-- --------------------------------------------------------

--
-- 视图结构 `friendship`
--
DROP TABLE IF EXISTS `friendship`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `friendship` AS (select `f`.`uid` AS `uid1`,`f`.`fre_uid` AS `uid2` from `friendrequest` `f` where (`f`.`state` = 'yes'));

-- --------------------------------------------------------

--
-- 视图结构 `like_num`
--
DROP TABLE IF EXISTS `like_num`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `like_num` AS (select distinct `rate`.`pid` AS `pid`,count(0) AS `num` from `rate` group by `rate`.`pid`);

-- --------------------------------------------------------

--
-- 视图结构 `pic_repins`
--
DROP TABLE IF EXISTS `pic_repins`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pic_repins` AS (select `your_repins`.`pid` AS `pid`,count(0) AS `num` from `your_repins` group by `your_repins`.`pid`);

-- --------------------------------------------------------

--
-- 视图结构 `pic_user`
--
DROP TABLE IF EXISTS `pic_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pic_user` AS (select distinct `p1`.`pid` AS `pid`,`b1`.`uid` AS `uid1`,`b2`.`uid` AS `uid2` from (((`board` `b1` join `board` `b2`) join `pin` `p1`) join `pin` `p2`) where ((`b1`.`uid` <> `b2`.`uid`) and (`p1`.`pid` = `p2`.`pid`) and (`p1`.`bid` = `b1`.`bid`) and (`p2`.`bid` = `b2`.`bid`)));

-- --------------------------------------------------------

--
-- 视图结构 `similar`
--
DROP TABLE IF EXISTS `similar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `similar` AS (select distinct `b1`.`uid` AS `uid1`,`b2`.`uid` AS `uid2`,`b1`.`bid` AS `bid1`,`b2`.`bid` AS `bid2` from (`board` `b1` join `board` `b2`) where ((`b1`.`uid` <> `b2`.`uid`) and ((`b1`.`bname` like `b2`.`bname`) or (`b1`.`category` like `b2`.`category`) or (`b1`.`description` like `b2`.`description`))));

-- --------------------------------------------------------

--
-- 视图结构 `sum`
--
DROP TABLE IF EXISTS `sum`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sum` AS (select distinct `similar`.`uid1` AS `uid1`,`similar`.`uid2` AS `uid2`,count(`similar`.`bid1`) AS `num` from `similar` group by `similar`.`uid1`);

-- --------------------------------------------------------

--
-- 视图结构 `sum_pic`
--
DROP TABLE IF EXISTS `sum_pic`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sum_pic` AS (select distinct `pic_user`.`uid1` AS `uid1`,`pic_user`.`uid2` AS `uid2`,count(`pic_user`.`pid`) AS `num` from `pic_user` group by `pic_user`.`uid1`);

-- --------------------------------------------------------

--
-- 视图结构 `your_repins`
--
DROP TABLE IF EXISTS `your_repins`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `your_repins` AS (select `b`.`uid` AS `uid`,`p`.`pid` AS `pid` from (`pin` `p` join `board` `b`) where ((`b`.`bid` = `p`.`bid`) and (`p`.`prebid` <> 0)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`uid`,`pid`,`bid`,`comtime`),
  ADD KEY `comment_ibfk_2` (`pid`),
  ADD KEY `comment_ibfk_3` (`bid`);

--
-- Indexes for table `cover`
--
ALTER TABLE `cover`
  ADD PRIMARY KEY (`bid`,`pid`),
  ADD KEY `cover_ibfk_2` (`pid`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`uid`,`bid`,`followtime`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `friendrequest`
--
ALTER TABLE `friendrequest`
  ADD PRIMARY KEY (`uid`,`fre_uid`,`requesttime`),
  ADD KEY `fre_uid` (`fre_uid`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `pin`
--
ALTER TABLE `pin`
  ADD PRIMARY KEY (`pid`,`bid`,`ptime`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`uid`,`pid`,`ratetime`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=494289;
--
-- 限制导出的表
--

--
-- 限制表 `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `board_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- 限制表 `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `picture` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`bid`) REFERENCES `board` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `cover`
--
ALTER TABLE `cover`
  ADD CONSTRAINT `cover_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `picture` (`pid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cover_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `board` (`bid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `board` (`bid`);

--
-- 限制表 `friendrequest`
--
ALTER TABLE `friendrequest`
  ADD CONSTRAINT `friendrequest_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `friendrequest_ibfk_2` FOREIGN KEY (`fre_uid`) REFERENCES `user` (`uid`);

--
-- 限制表 `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `picture` (`pid`);

--
-- 限制表 `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `picture` (`pid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
