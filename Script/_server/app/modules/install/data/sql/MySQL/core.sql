--
-- Author:        Pierre-Henry Soria <ph7software@gmail.com>
-- Copyright:     (c) 2014, Pierre-Henry Soria. All Rights Reserved.
-- License:       See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
-- Link           http://hizup.com
--

CREATE TABLE IF NOT EXISTS H2O_Admin (
  profileId tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  email varchar(120) NOT NULL,
  password varchar(120) NOT NULL,
  name varchar(50) DEFAULT NULL,
  lang char(2) NOT NULL DEFAULT 'en',
  timeZone varchar(6) NOT NULL DEFAULT '-6',
  joinDate datetime DEFAULT NULL,
  lastActivity datetime DEFAULT NULL,
  lastEdit datetime DEFAULT NULL,
  ip varchar(20) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (profileId),
  UNIQUE KEY email (email)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS H2O_Game (
  gameId int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(120) NOT NULL,
  title varchar(120) NOT NULL,
  description varchar(255) NOT NULL,
  keywords varchar(255) NOT NULL,
  thumb varchar(200) NOT NULL,
  file varchar(200) NOT NULL,
  categoryId tinyint(4) unsigned NOT NULL DEFAULT '0',
  addedDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  downloads int(9) unsigned DEFAULT '0',
  votes int(9) unsigned DEFAULT '0',
  score float unsigned DEFAULT '0',
  views int(10) unsigned DEFAULT '0',
  PRIMARY KEY (gameId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS H2O_GameCategory (
  categoryId smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (categoryId),
  UNIQUE KEY (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO H2O_GameCategory (categoryId, name) VALUES
(100, 'Puzzle'),
(101, 'Sports'),
(103, 'Action'),
(104, 'Other'),
(105, 'Shooter'),
(106, 'Arcade'),
(108, 'Fighting'),
(109, 'Racing'),
(110, 'Retro'),
(111, 'Casino'),
(120, 'Color Me');


CREATE TABLE IF NOT EXISTS H2O_Page (
  pageId tinyint(3) unsigned NOT NULL,
  title varchar(120) NOT NULL,
  text text,
  PRIMARY KEY (pageId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO H2O_Page (pageId, title, text) VALUES
(1, 'Privacy Policy', 'PLEASE EDIT THIS PAGE IN YOUR ADMINISTRATION PANEL<br /><br /><br />'),
(2, 'About Us', 'PLEASE EDIT THIS PAGE IN YOUR ADMINISTRATION PANEL<br /><br /><br />'),
(3, 'Contact Us', 'For any feedback, please contact us at: YOUR-EMAIL [AT] YOUR-HOST-MAIL [DOT] COM<br /><br /><br />');


CREATE TABLE IF NOT EXISTS H2O_Ad (
  adId tinyint(3) unsigned NOT NULL,
  code text,
  PRIMARY KEY (adId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO H2O_Ad (adId, code) VALUES
(1, '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-8560246457913786" data-ad-slot="9865718955"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({})</script><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'),
(2, '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-8560246457913786" data-ad-slot="9865718955"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({})</script><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'),
(3, '<ins class="adsbygoogle" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-8560246457913786" data-ad-slot="9785735354"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({})</script><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>');


CREATE TABLE IF NOT EXISTS H2O_Analytics (
  analyticsId tinyint(3) unsigned NOT NULL,
  code text,
  PRIMARY KEY (analyticsId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO H2O_Analytics (analyticsId, code) VALUES
(1, '<script>(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');ga(\'create\',\'UA-YOUR-ID\',\'YOUR-WEBSITE.com\');ga(\'send\',\'pageview\');</script>');