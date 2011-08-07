CREATE TABLE `MinerCore` (
  `TransNo` int(10) unsigned NOT NULL auto_increment,
  `UnixMinute` int(10) unsigned default NULL,
  `Date` timestamp NULL default NULL,

#First miner rig with 4 GPU
  `MinerA1` tinyint(3) unsigned default NULL,
  `MinerA2` tinyint(3) unsigned default NULL,
  `MinerA3` tinyint(3) unsigned default NULL,
  `MinerA4` tinyint(3) unsigned default NULL,
#Second miner rig with 3 GPU
  `MinerB1` tinyint(3) unsigned default NULL,
  `MinerB2` tinyint(3) unsigned default NULL,
  `MinerB3` tinyint(3) unsigned default NULL,

#Third miner rig with 2 GPU
  `MinerC1` tinyint(3) unsigned default NULL,
  `MinerC2` tinyint(3) unsigned default NULL,

#Fourth miner rig with 1 GPU
  `MinerD1` tinyint(3) unsigned default NULL,
#... etc

  PRIMARY KEY  (`TransNo`),
  UNIQUE KEY `TransNo` (`TransNo`),
  UNIQUE KEY `UnixMinute` (`UnixMinute`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251;

CREATE TABLE `MinerLoad` (
  `TransNo` int(10) unsigned NOT NULL auto_increment,
  `UnixMinute` int(10) unsigned default NULL,
  `Date` timestamp NULL default NULL,
#First miner rig with 4 GPU
  `MinerA1` tinyint(3) unsigned default NULL,
  `MinerA2` tinyint(3) unsigned default NULL,
  `MinerA3` tinyint(3) unsigned default NULL,
  `MinerA4` tinyint(3) unsigned default NULL,
#Second miner rig with 3 GPU
  `MinerB1` tinyint(3) unsigned default NULL,
  `MinerB2` tinyint(3) unsigned default NULL,
  `MinerB3` tinyint(3) unsigned default NULL,

#Third miner rig with 2 GPU
  `MinerC1` tinyint(3) unsigned default NULL,
  `MinerC2` tinyint(3) unsigned default NULL,

#Fourth miner rig with 1 GPU
  `MinerD1` tinyint(3) unsigned default NULL,
#... etc
  PRIMARY KEY  (`TransNo`),
  UNIQUE KEY `TransNo` (`TransNo`),
  UNIQUE KEY `UnixMinute` (`UnixMinute`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251;

CREATE TABLE `MinerTemp` (
  `TransNo` int(10) unsigned NOT NULL auto_increment,
  `UnixMinute` int(10) unsigned default NULL,
  `Date` timestamp NULL default NULL,
#First miner rig with 4 GPU
  `MinerA1` tinyint(3) unsigned default NULL,
  `MinerA2` tinyint(3) unsigned default NULL,
  `MinerA3` tinyint(3) unsigned default NULL,
  `MinerA4` tinyint(3) unsigned default NULL,
#Second miner rig with 3 GPU
  `MinerB1` tinyint(3) unsigned default NULL,
  `MinerB2` tinyint(3) unsigned default NULL,
  `MinerB3` tinyint(3) unsigned default NULL,

#Third miner rig with 2 GPU
  `MinerC1` tinyint(3) unsigned default NULL,
  `MinerC2` tinyint(3) unsigned default NULL,

#Fourth miner rig with 1 GPU
  `MinerD1` tinyint(3) unsigned default NULL,
#... etc
  PRIMARY KEY  (`TransNo`),
  UNIQUE KEY `TransNo` (`TransNo`),
  UNIQUE KEY `UnixMinute` (`UnixMinute`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251;

CREATE TABLE `MinerVolt` (
  `TransNo` int(10) unsigned NOT NULL auto_increment,
  `UnixMinute` int(10) unsigned default NULL,
  `Date` timestamp NULL default NULL,
#First miner rig with 4 GPU
  `MinerA1` tinyint(3) unsigned default NULL,
  `MinerA2` tinyint(3) unsigned default NULL,
  `MinerA3` tinyint(3) unsigned default NULL,
  `MinerA4` tinyint(3) unsigned default NULL,
#Second miner rig with 3 GPU
  `MinerB1` tinyint(3) unsigned default NULL,
  `MinerB2` tinyint(3) unsigned default NULL,
  `MinerB3` tinyint(3) unsigned default NULL,

#Third miner rig with 2 GPU
  `MinerC1` tinyint(3) unsigned default NULL,
  `MinerC2` tinyint(3) unsigned default NULL,

#Fourth miner rig with 1 GPU
  `MinerD1` tinyint(3) unsigned default NULL,
#... etc
  PRIMARY KEY  (`TransNo`),
  UNIQUE KEY `TransNo` (`TransNo`),
  UNIQUE KEY `UnixMinute` (`UnixMinute`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251;
