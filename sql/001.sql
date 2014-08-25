ALTER TABLE `users` CHANGE `avatar` `avatar` VARCHAR(150)  CHARACTER SET utf8  NULL  DEFAULT NULL;

CREATE TABLE `account_event_report_ids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reportid` int(11) DEFAULT NULL,
  `eventid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `account_event_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `schema_version` (
  `migration_code` varchar(256) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT 'Must match the filename of the SQL file in the /sql directory.',
  `extra_notes` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`migration_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `schema_version` 
  (`migration_code`, 
   `extra_notes`, 
   `applied_at`) 
  VALUES (
    '001', 
    'Updated `users.avatar` default value (NULL). Created tables for account event reports. Created the `schema_versions` table.',
    CURRENT_TIMESTAMP
  );