INSERT INTO Questions
  (QuestionId, QuestionText, QuestionType, TextboxSize)
VALUES
  (1, "Where are you?", "text", "small");

INSERT INTO Studies (StudyId) VALUES
  (0), (1), (2), (3), (4), (5), (6), (7), (8), (9),
  (10), (11), (12), (13), (14), (15), (16), (17), (18), (19),
  (20), (21), (22), (23), (24), (25), (26), (27), (28), (29),
  (30), (31), (32), (33), (34), (35), (36), (37), (38), (39),
  (40), (41), (42), (43), (44), (45), (46), (47), (48), (49);

INSERT INTO Tasks (TaskId, SearchId) VALUES
  (0, NULL), (1, NULL), (2, NULL), (3, NULL), (4, NULL),
  (5, NULL), (6, NULL), (7, NULL), (8, NULL), (9, NULL),
  (10, NULL), (11, NULL), (12, NULL), (13, NULL), (14, NULL),
  (15, NULL), (16, NULL), (17, NULL), (18, NULL), (19, NULL),
  (20, NULL), (21, NULL), (22, NULL), (23, NULL), (24, NULL);

INSERT INTO StudiesToTasks (StudyId, TaskId)
SELECT S.StudyId, T.TaskId
FROM Studies S
  CROSS JOIN Tasks T;

UPDATE StudiesToTasks SET
  Ordering = TaskId
WHERE TaskId IN (0, 1, 2, 3, 24);

INSERT INTO SearchTask
  (SearchId, Type, EnglishQuery, ChineseSimQuery, ChineseTraQuery, FrenchQuery, GermanQuery, SpanishQuery, ItalianQuery)
VALUES
  (0,	"Learning",	"Find documents that describe or discuss the impact of consumer boycotts.",	'寻找有关消费者联合抵制商品造成冲击的文章.',	'尋找有關消費者聯合抵製商品造成衝擊的文章',	'Trouver des documents décrivant ou discutant de l\'impact des boycotts de consommateurs.',	'Finde Dokumente, die die Wirkung von Verbraucherboykotts beschreiben oder diskutieren.',	'Encontrar documentos que describan o discutan el impacto de boicots de los consumidores',	'Si trovino documenti che descrivono o discutono l\'impatto di boicottaggi da parte dei consumatori.');
  (1,	"Learning",	"Look for information on the existence and/or the discovery of remains of the seven wonders of the ancient world.", 	"找出有关于目前存在或被发现遗迹的远古世界七个奇观的资讯。", 	"找出有關於目前存在或被發現遺跡的遠古世界七個奇觀的資訊。", "Trouvez des informations sur l'existence et/ou la découverte de vestiges des sept merveilles du monde.",	"Suche nach Informationen über die Existenz und/oder die Entdeckung von Überresten der Sieben Weltwunder der Antike.", "Busque información sobre la existencia y/o el descubrimiento de los restos de las siete maravillas del mundo.", "Cerca informazioni sull'esistenza e/o la scoperta delle rovine (di una o più) delle sette meraviglie del Mondo Antico."),
  （2,	"Learning",	"Find publications providing general introductions to food allergies and the prevention of such allergies.",	"查找介绍食物过敏和预防食物过敏的出版物。",	"查找介紹食物過敏和預防食物過敏的出版物。"，	"Trouver des publications introduisant aux allergies alimentaires et à la préventions de telles allergies.",	"Finden Sie allgemeine Einführungen über Allergien auf Lebensmittel und Allergieprävention.", "Encuentre publicaciones que proporcionen instrucciones generales sobre alergias alimenticias y sobre la prevención de este tipo de alergias.",	"trova le pubblicazioni che forniscono introduzioni generali sulle allergie alimentari e su come prevenire tali allergie.")
  (3,	"Learning",	"We seek any information on human cloning including claims of the production of the first human clone.",	"我们想要寻找关于人类复制的资讯,包括第一个复制人的出生",	"我們想要尋找關於人類複製的資訊,包括第一個複製人的出生",	"Nous cherchons des informations sur le clonage humain incluant les revendications concernant la mise au point du premier clone humain.",	"Wir suchen Informationen über das Klonen von Menschen, einschließlich Ansprüche der Produktion des ersten menschlichen Klones.",	"Buscamos cualquier información sobre clonación humana incluyendo reivindicaciones de haber producido el primer clon humano.",	"Si trovino informazioni sulla clonazione umana inclusi annunci riguardanti la produzione del primo clone umano.");
  (4,	"Learning",	"Find documents which describe injuries to professional footballers during football (soccer) matches or pre-match training sessions.", 	"寻找有关职业足球员的比赛或训练伤害的文件。",	"尋找有關職業足球員的比賽或訓練傷害的文件。",	"Trouver des documents traitant des blessures de footballeurs professionnels durant des matches de football ou des sessions d'entraînement avant un match.",	"Finde Dokumente, die über Verletzungen von Berufsfußballspielern während eines Fußballspiels oder des Trainings vor einem Fußballspiel berichten."	, "Encontrar documentos que describan lesiones de jugadores de fútbol profesional durante un partido de fútbol o en un partido de pretemporada.",	"Si trovino documenti che descrivono infortuni accaduti a calciatori professionisti durante partite di calcio o allenamenti.");
  (5,	"Doing",	"You want to buy Yves Saint Laurent boots.
You want to find places to buy, reviews, etc.",	"你想购买Yves Saint Laurent (YSL)牌的靴子。
你想查找到购买地点，评论，等等。",	"你想購買YSL牌的靴子。你想查找到購買地點，評論，等等。",	"Vous souhaitez acheter des bottes Yves Saint Laurent.
Vous souhaitez trouver des boutiques, commentaires, etc.",	"Sie möchten Yves Saint Laurent Stiefel kaufen.
Sie suchen nach Einzelhändler, Kundenrezensionen, usw.",	"Tu quieres comprar botas de Yves Saint Laurent.
Tu quieres encontrar lugares para comprar, opiniones, etc.",	"Vuoi acquistare degli stivali Yves Saint Laurent.
Vuoi trovare dei posti per comprare, avere recensioni, etc.");
 (6, "Doing",	"Find recipes for chocolate puddings.", 	"查找巧克力布丁的食谱。",	"查找巧克力布丁的食譜。",	"Trouver des recettes de gâteaux au chocolat.",	"Finden Sie Rezepte für Schokoladendesserts.",	"Encuentre recetas de pudín de chocolate.",	"Trova ricette di budini al cioccolato.");
  (7,	"Doing", "You want to know how a .csv file can be imported in excel.",	"你想知道如何用Excel软件导入csv文件。",	"你想知道如何用Excel軟件導入csv文件。",	"Vous voulez savoir comment un fichier .csv peut être importé dans Excel.",	"Sie wollen wissen, wie eine CSV-Datei in Excel importiert werden kann.",	"Cómo importar un archivo .csv en Excel?",	"Come importare un file .csv in Excel?");
  （8，	"Doing", "Only publications which specifically provide information on climbs that are not difficult or give instructions on rock climbing for beginners are of interest.",	"仅限具体提供简单的攀岩信息或者给攀岩初学者指导信息的出版物。",	"僅限具體提供簡單的攀岩信息或者給攀岩初學者指導信息的出版物。",	"Seulement les publications qui donnent spécifiquement des informations sur des voies d'escalades faciles ou bien des manuels pour la pratique de l'escalade pour débutants	", "Nur Veröffentlichungen, die Informationen über leichte Klettertouren oder Instruktionen über das Bergsteigen oder Klettern von Anfängern enthalten, sind von Interesse.",	"Sólo las publicaciones que proporcionan información específica sobre los ascensos que no son difíciles o dan instrucciones para principiantes son de interés.",	"Sono ritenute interessanti pubblicazioni che forniscano specificatamente informazioni su scalate che non siano difficili, o che diano istruzioni sull'arrampicata per principianti.");
  （9,	"FactFinding",	"What is the current price of oil?", "现在油价是多少", "現在油價是多少", "Quel est prix du pétrole actuel?", "Wie hoch ist der gegenwärtige Ölpreis?", "¿Cuál es el precio actual del petróleo?",	"Qual è l'attuale prezzo della benzina?"）;

  (10,	"FactFinding",	"Give the names and/or location of places that have been designated as UNESCO World Heritage Sites of outstanding beauty or importance.",	"列出被 UNESCO 指定为美丽或重要世界古迹的地区的名字或位置。", "列出被UNESCO 指定為美麗或重要世界古蹟的地區的名字或位置。", 	"Fournir le nom et/ou la localisation de lieux déclarés Patrimoine mondial par l'UNESCO en raison de leur beauté exceptionnelle ou de leur importance.", 	"Nenne die Namen und/oder die Lage von Orten, die als UNESCO-Weltkulturerbe von besonderer Schönheit oder Bedeutung benannt wurden.",	"Nombre los nombres y/o situación de lugares que hayan sido designados como patrimonio de la humanidad por la UNESCO por su destacada belleza o importancia.",	"Si trovino documenti riportanti il nome e/o il luogo di siti che per bellezza o importanza siano stati designati patrimoni dell'umanità.");
  (11,	"FactFinding",	"What conditions can trigger asthma in children?",	"什么情况会导致儿童出现气喘?",	"什麼情況會導致兒童出現氣喘?",	"Quelles conditions peuvent déclencher de l'asthme chez l'enfant ?", 	"Welche Bedingungen können Asthma bei Kindern auslösen?",	"¿Qué condiciones pueden producir el asma en niños?",	"Quali circostanze favoriscono l'asma nei bambini?")，
  (12,	"FactFinding",	"How high above ground level is the ozone layer?",	"臭氧层离地面有多高？",	"臭氧層離地面有多高？",	"Quel pays est revenu au sein de l'UNESCO après 38 ans d'absence ?",	"Auf welcher Höhe befindet sich das Ozonloch?",	"¿A qué altura está la capa de ozono?",	"A che altezza è lo strato di ozono?");



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

      INSERT INTO SurveyQuestions (QuestionId，QuestionText, QuestionType, TextboxSize，MultiQuestionOption，MultiQuestionOrder，TaskId，QuestionOrder)
      VALUES
      (1, "What's your country of origin?", "text", "small", NULL, NULL, 2, 1);


      CREATE TABLE `Study` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `study_id` int(11) NOT NULL,
        `task_type` varchar(40) CHARACTER SET latin1 NOT NULL,
        `task_id` int(11) NOT NULL,
        `task_order` int(11) NOT NULL,
        `system` int(11) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf32;

      INSERT INTO Study(id, study_id, task_type, task_id, task_order, system)
      VALUES (1, 1, "survey", 1, 1, 1),
             (2, 1, "survey", 2, 2, 1),
             (3, 1, "survey", 3, 3, 1),
             (4, 1, "task", 4, 4, 1),
             (5, 1, "task", 5, 5, 2),
             (6, 1, "task", 6, 6, 3);
             (7, 2, "survey", 1, 1, 1),
             (8, 2, "survey", 2, 2, 1),
             (9, 2, "survey", 3, 3, 1),
             (10, 2, "task", 6, 4, 4),
             (11, 2, "task", 5, 5, 3),
             (12, 2, "task", 4, 6, 2),
             (13, 3, "survey", 1, 1, 1),
             (14, 3, "survey", 2, 2, 1),
             (15, 3, "survey", 3, 3, 2),
             (16, 3, "task", 5, 4, 3);
             (17, 3, "task", 4, 5, 2),
             (18, 3, "task", 6, 6, 1),
             (19, 4, "survey", 1, 1, 1),
             (20, 4, "survey", 2, 2, 1),
             (21, 4, "survey", 3, 3, 2),
             (22, 4, "task", 5, 4, 4),
             (23, 4, "task", 4, 5, 2),
             (24, 4, "task", 6, 6, 1),

UPDATE `sdb_hccweb`.`Questions` SET `question_text`='What is your country of origin' WHERE `id`='1';
UPDATE `sdb_hccweb`.`Questions` SET `question_text`='What is your age' WHERE `id`='2';
UPDATE `sdb_hccweb`.`Questions` SET `TaskID`='3', `question_order`='3' WHERE `id`='14';
UPDATE `sdb_hccweb`.`Questions` SET `TaskID`='3', `question_order`='3' WHERE `id`='13';
UPDATE `sdb_hccweb`.`Questions` SET `TaskID`='3', `question_order`='4' WHERE `id`='15';
UPDATE `sdb_hccweb`.`Questions` SET `TaskID`='3', `question_order`='5' WHERE `id`='16';
