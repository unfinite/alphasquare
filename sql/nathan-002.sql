ALTER TABLE `account_events` CHANGE `ip` `ip` VARCHAR(45)  NULL  DEFAULT NULL;

INSERT INTO `schema_version` (`migration_code`, `extra_notes`)
VALUES('nathan-002', 'Changed ip in account events from binary to varchar.');