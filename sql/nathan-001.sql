ALTER TABLE `users` CHANGE `avatar` `avatar` VARCHAR(150)  CHARACTER SET utf8  NULL  DEFAULT NULL;

CREATE TABLE `account_event_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `ids` varchar(400) DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `schema_version` (
  `migration_code` varchar(256) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT 'Should match the filename of the SQL file in the /sql directory.',
  `extra_notes` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`migration_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `schema_version` (`migration_code`, `extra_notes`) 
VALUES (
    '001', 
    'Updated `users.avatar` default value (NULL). Created tables for account event reports. Created the `schema_versions` table.'
);