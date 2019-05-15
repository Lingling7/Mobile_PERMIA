TRUNCATE TABLE UserLog;
TRUNCATE TABLE LanguagePreferencesEx;
TRUNCATE TABLE TaskPerformance;
TRUNCATE TABLE AnswersEx;
TRUNCATE TABLE FavoriteLogEx;
TRUNCATE TABLE EditLogEx;
TRUNCATE TABLE LinkLogEx;
TRUNCATE TABLE QueryLogEx;


Alter Table Searches
change column `SimplifiedChineseTaskDescription` `zh-CN` varchar(2048) CHARACTER SET utf8 NOT NULL,
change column `TraditionalChineseTaskDescription` `zh-HK` varchar(2048) CHARACTER SET utf8 NOT NULL,
change column `FrenchTaskDescription`  `fr-FR` varchar(2048)  CHARACTER SET utf8 NOT NULL,
change column `GermanTaskDescription` `de-DE` varchar(2048)  CHARACTER SET utf8 NOT NULL,
change column `SpanishTaskDescription` `es-ES` varchar(2048)  CHARACTER SET utf8 NOT NULL,
change column `ItalianTaskDescription` `it-IT` varchar(2048)  CHARACTER SET utf8 NOT NULL;


Alter Table Searches
change column SimplifiedChineseTaskDescription zh-CN varchar(2048) CHARACTER SET utf8 NOT NULL,
change column TraditionalChineseTaskDescription zh-HK varchar(2048) CHARACTER SET utf8 NOT NULL,
change column FrenchTaskDescription  fr-FR varchar(2048)  CHARACTER SET utf8 NOT NULL,
change column GermanTaskDescription de-DE varchar(2048)  CHARACTER SET utf8 NOT NULL,
change column SpanishTaskDescription es-ES varchar(2048)  CHARACTER SET utf8 NOT NULL,
change column ItalianTaskDescription it-IT varchar(2048)  CHARACTER SET utf8 NOT NULL;


ALTER SCHEMA sdb_hccweb DEFAULT CHARACTER SET UTF-8

Use the ALTER DATABASE and ALTER TABLE commands.

ALTER DATABASE ddb_hccweb CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE LanguagePreferencesEx CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE TaskPerformance CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE AnswersEx CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE FavoriteLogEx CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE EditLogEx CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE LinkLogEx CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE QueryLogEx CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
