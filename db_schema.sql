DROP TABLE IF EXISTS StudiesToTasks;
DROP TABLE IF EXISTS Searches;
DROP TABLE IF EXISTS TasksToQuestions;
DROP TABLE IF EXISTS Questions;
DROP TABLE IF EXISTS Tasks;
DROP TABLE IF EXISTS Users;

CREATE TABLE Users (
  UserId INT(11) NOT NULL AUTO_INCREMENT,
  InitTime DATETIME NOT NULL,
  PRIMARY KEY (UserId));

CREATE TABLE Tasks (
  TaskId INT(11) NOT NULL,
  SearchId INT(11) DEFAULT NULL,
  PRIMARY KEY (TaskId));

CREATE TABLE Questions (
  QuestionId INT(11) NOT NULL AUTO_INCREMENT,
  QuestionText MEDIUMTEXT NOT NULL,
  QuestionType ENUM("text", "checkbox", "radio") NOT NULL,
  TextboxSize ENUM("small", "medium", "large") DEFAULT NULL,
  PRIMARY KEY (QuestionId));

  CREATE TABLE SurveyQuestions (
    QuestionId INT(11) NOT NULL AUTO_INCREMENT,
    QuestionText MEDIUMTEXT NOT NULL,
    QuestionType ENUM("text", "checkbox", "radio") NOT NULL,
    TextboxSize ENUM("small", "medium", "large") DEFAULT NULL,
    MultiQuestionOption VARCHAR(2048) DEFAULT NULL,
    MultiQuestionOrder INT(11) DEFAULT NULL,
    TaskId INT(11) NOT NULL,
    QuestionOrder INT(11) NOT NULL,
    PRIMARY KEY (QuestionId));


    PRIMARY KEY (QuestionId));

CREATE TABLE TasksToQuestions (
  TaskId INT(11) NOT NULL,
  QuestionId INT(11) NOT NULL,
  Ordering INT(11) NOT NULL,
  CONSTRAINT fk_TasksToQuestions_TaskId FOREIGN KEY (TaskId)
    REFERENCES Tasks (TaskId),
  CONSTRAINT fk_TasksToQuestions_QuestionId FOREIGN KEY (QuestionId)
    REFERENCES Questions (QuestionId));

CREATE TABLE Searches (
   SearchId INT(11) NOT NULL AUTO_INCREMENT,
   Type text NOT NULL,
   EnglishQuery MEDIUMTEXT NOT NULL,
   ChineseSimQuery MEDIUMTEXT NOT NULL,
   ChineseTraQuery MEDIUMTEXT NOT NULL,
   FrenchQuery MEDIUMTEXT NOT NULL,
   GermanQuery MEDIUMTEXT NOT NULL,
   SpanishQuery MEDIUMTEXT NOT NULL,
   ItalianQuery MEDIUMTEXT NOT NULL,
   PRIMARY KEY(SearchId));


   PRIMARY KEY (SearchId));

CREATE TABLE Studies (
   StudyId INT(11) NOT NULL,
   PRIMARY KEY (StudyId));

CREATE TABLE StudiesToTasks (
   StudyId INT(11) NOT NULL,
   TaskId INT(11) NOT NULL,
   Ordering INT(11) DEFAULT NULL,
   PRIMARY KEY (StudyId, TaskId),
   CONSTRAINT fk_StudiesToTasks_StudyId FOREIGN KEY (StudyId)
     REFERENCES Studies (StudyId),
   CONSTRAINT fk_StudiesToTasks_TaskId FOREIGN KEY (TaskId)
     REFERENCES Tasks (TaskId));

     CREATE TABLE `sdb_hccweb`.`FavoriteLogEx` (
       `QueryId` INT NOT NULL,
       `Link` VARCHAR(200) CHARACTER SET 'utf8' NULL,
       `Language` VARCHAR(5) CHARACTER SET 'utf8' NULL,
       `Title` VARCHAR(200) CHARACTER SET 'utf8' NULL,
       `Snippet` VARCHAR(500) CHARACTER SET 'utf8' NULL,
       `Rank` VARCHAR(10) NULL,
       `UserId` INT(11) NULL,
       `Interface` VARCHAR(20) NULL,
       `timestamp` TIMESTAMP NULL,
       PRIMARY KEY (`QueryId`));

       CREATE TABLE `sdb_hccweb`.`LinkLogEx` (
         `Id` INT(11)NOT NULL AUTO_INCREMENT,
         `QueryId` INT(11) NULL,
         `Link` VARCHAR(200) CHARACTER SET 'utf8' NULL,
         `Language` VARCHAR(5) CHARACTER SET 'utf8' NULL,
         `Title` VARCHAR(200) CHARACTER SET 'utf8' NULL,
         `Snippet` VARCHAR(500) CHARACTER SET 'utf8' NULL,
         `Rank` VARCHAR(10) NULL,
         `UserId` INT(11) NULL,
         `Interface` VARCHAR(20) NULL,
         `timestamp` TIMESTAMP NULL,
         PRIMARY KEY (`Id`));

    CREATE TABLE QueryLogEx(
      Id NOT NULL AUTO_INCREMENT,
      UserId INT NOT NULL,
      SearchQuery VARCHAR(300) CHARACTER SET 'utf8' NULL,
      Language1 VARCHAR(10) CHARACTER SET 'utf8' NULL,
      Language2 VARCHAR(10) CHARACTER SET 'utf8' NULL,
      Language3 VARCHAR(10) CHARACTER SET 'utf8' NULL,
      Language4 VARCHAR(10) CHARACTER SET 'utf8' NULL,
      Web VARCHAR(10) CHARACTER SET 'utf8' NULL,
      News VARCHAR(10) CHARACTER SET 'utf8' NULL,
      Interface VARCHAR(20) CHARACTER SET 'utf8' NULL,
      `timestamp` TIMESTAMP NULL,
      PRIMARY KEY (`Id`));

      CREATE TABLE EditLogEx(
        Id INT(11) NOT NULL AUTO_INCREMENT,
        UserId INT NOT NULL,
        QueryId INT(11) NULL,
        EditedQuery VARCHAR(300) CHARACTER SET 'utf8' NULL,
        Language VARCHAR(10) CHARACTER SET 'utf8' NULL,
        Interface VARCHAR(20) CHARACTER SET 'utf8' NULL,
        `timestamp` TIMESTAMP NULL,
        PRIMARY KEY (`Id`));

     CREATE TABLE AnswersEx(
      Id INT(11) NOT NULL AUTO_INCREMENT,
      UserID INT(11) NOT NULL,
      QuestionId INT(11) NOT NULL,
      Response VARCHAR (1024) NOT NULL,
      System INT (11) NOT NULL,
      PRIMARY KEY(Id));

    CREATE TABLE LanguagePreferencesEx(
      UserId INT(11) NOT NULL,
      Language1 VARCHAR(45) NOT NULL,
      L1Reading INT(11) NOT NULL,
      L1Writing INT(11) NOT NULL,
      L1Listening INT(11) NOT NULL,
      Language2 VARCHAR(45) NOT NULL,
      L2Reading INT(11) NOT NULL,
      L2Writing INT(11) NOT NULL,
      L2Listening INT(11) NOT NULL,
      Language3 VARCHAR(45) DEFAULT NULL,
      L3Reading INT(11) DEFAULT NULL,
      L3Writing INT(11) DEFAULT NULL,
      L3Listening INT(11) DEFAULT NULL,
      Language4 VARCHAR(45) DEFAULT NULL,
      L4Reading INT(11) DEFAULT NULL,
      L4Writing INT(11) DEFAULT NULL,
      L4Listening INT(11) DEFAULT NULL,
      PRIMARY KEY(UserId)
    );
