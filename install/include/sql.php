<?php

$db = mysql_connect($_POST['massalcugshost'], $_POST['massalcugsuser'], $_POST['massalcugspassword']);
$database = ($_POST['massdb']);

$tabel = array(
1 => "CREATE DATABASE ".$database."",

2 => "CREATE TABLE `accounts` (
  `num` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;",

3 => "CREATE TABLE `config` (
  `num` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `params` varchar(20) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;",

4 => "CREATE TABLE `displays` (
  `num` int(11) NOT NULL,
  `display` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `sel` text NOT NULL,
  PRIMARY KEY (`num`),
  KEY `num` (`num`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;",

5 => "CREATE TABLE `groups` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `pic` varchar(20) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `avatar` text NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;",

6 => "CREATE TABLE `modul` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `backcolor` varchar(20) NOT NULL,
  `fontcolor` varchar(20) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;", 

7 => "INSERT INTO accounts values ('0', 'admin', 'cd5ea73cd58f827fa78eef7197b8ee606c99b2e6')",

8 => "INSERT INTO config values ('1', 'moulserver', '1')",

9 => "INSERT INTO config values ('2', 'reload', '30')");


for($x=1; $x <= sizeof($tabel); $x++)
{
	mysql_select_db($database);
	$sql = mysql_query($tabel[$x]) or die ('<meta http-equiv="refresh" content="0"; URL=?State=ERROR&ERROR=3">');
}

?>