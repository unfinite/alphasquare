-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2014 a las 23:48:56
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `alphasquare`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_events`
--

CREATE TABLE IF NOT EXISTS `account_events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `object` varchar(30) DEFAULT NULL,
  `event` varchar(30) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `ip` binary(16) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) DEFAULT NULL,
  `to` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(20) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `clicked` tinyint(1) NOT NULL DEFAULT '0',
  `time` int(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api`
--

CREATE TABLE IF NOT EXISTS `api` (
  `userid` int(11) NOT NULL,
  `apikey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=206 ;

--
-- Disparadores `comments`
--
DROP TRIGGER IF EXISTS `after_create_comment`;
DELIMITER //
CREATE TRIGGER `after_create_comment` AFTER INSERT ON `comments`
 FOR EACH ROW BEGIN
	-- UPDATE debates SET comments_count = comments_count+1 WHERE id = NEW.postid;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_delete_comment`;
DELIMITER //
CREATE TRIGGER `after_delete_comment` AFTER DELETE ON `comments`
 FOR EACH ROW BEGIN	
	DELETE FROM alerts 
		WHERE `from` = OLD.userid 
			AND object_id = OLD.id 
			AND `action` = 'comment';
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `debates`
--

CREATE TABLE IF NOT EXISTS `debates` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `content` varchar(500) CHARACTER SET latin1 NOT NULL,
  `tags` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `up_votes` int(10) NOT NULL DEFAULT '0' COMMENT 'Cache of up votes',
  `down_votes` int(11) DEFAULT '0' COMMENT 'Cache of down votes',
  `comments_count` int(11) NOT NULL COMMENT 'Cache of comment count',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `searchindex` (`content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=581 ;

--
-- Disparadores `debates`
--
DROP TRIGGER IF EXISTS `after_debate_delete`;
DELIMITER //
CREATE TRIGGER `after_debate_delete` AFTER DELETE ON `debates`
 FOR EACH ROW -- Delete data related to debate
BEGIN
	-- Delete debate's votes
	DELETE FROM votes WHERE postid = OLD.id;
	-- Delete debate's comments
	DELETE FROM comments WHERE postid = OLD.id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `following`
--

CREATE TABLE IF NOT EXISTS `following` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `followid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`,`followid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Disparadores `following`
--
DROP TRIGGER IF EXISTS `after_unfollow`;
DELIMITER //
CREATE TRIGGER `after_unfollow` AFTER DELETE ON `following`
 FOR EACH ROW BEGIN
	-- Delete follow alert
	DELETE FROM alerts 
	WHERE action = 'follow'
	AND `from` = OLD.userid
	AND object_id = OLD.followid
	AND object_type = 'user';
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forgot_password`
--

CREATE TABLE IF NOT EXISTS `forgot_password` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `token` varchar(32) DEFAULT NULL COMMENT 'md5 token',
  `created` int(20) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tagline` varchar(100) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT '50',
  `bio` text,
  `location` varchar(50) DEFAULT NULL,
  `website_title` varchar(100) DEFAULT NULL,
  `website_url` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `favorite_movies` text,
  `favorite_tv` text,
  `favorite_music` text,
  `favorite_quotes` text,
  `avatar` varchar(150) NOT NULL DEFAULT '',
  `status` tinytext NOT NULL,
  `joined` int(20) NOT NULL,
  `last_login` int(20) DEFAULT NULL,
  `followers` int(11) NOT NULL DEFAULT '0',
  `following` int(11) NOT NULL DEFAULT '0',
  `official` tinyint(1) NOT NULL DEFAULT '0',
  `employee` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Disparadores `users`
--
DROP TRIGGER IF EXISTS `after_user_delete`;
DELIMITER //
CREATE TRIGGER `after_user_delete` AFTER DELETE ON `users`
 FOR EACH ROW -- Delete the user's data

BEGIN

	-- Delete from following table
	DELETE FROM `following` WHERE userid = OLD.id OR followid = OLD.id;

	-- Delete debates
	DELETE FROM `debates` WHERE userid = OLD.id;

	-- Delete comments
	DELETE FROM `comments` WHERE userid = OLD.id;

	-- Delete votes
	DELETE FROM `votes` WHERE userid = OLD.id;

	-- Delete forgot password tokens
	DELETE FROM `forgot_password` WHERE userid = OLD.id;
	
	-- Delete oauth accounts
	DELETE FROM `user_oauth` WHERE userid = OLD.id;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_links`
--

CREATE TABLE IF NOT EXISTS `user_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `text` varchar(35) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `created` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_oauth`
--

CREATE TABLE IF NOT EXISTS `user_oauth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `oauth_provider` varchar(20) DEFAULT NULL,
  `oauth_uid` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`userid`,`oauth_uid`,`oauth_provider`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`postid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Disparadores `votes`
--
DROP TRIGGER IF EXISTS `after_delete_vote`;
DELIMITER //
CREATE TRIGGER `after_delete_vote` AFTER DELETE ON `votes`
 FOR EACH ROW BEGIN
	DELETE FROM `alerts`
	WHERE `object_id` = OLD.postid
	AND `from` = OLD.userid
	AND (`action` = 'like' OR `action` = 'dislike');
END
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

