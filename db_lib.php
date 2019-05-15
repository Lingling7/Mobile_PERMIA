<?php
  function RecordTaskStart($userId, $studyId, $taskId) {
    $sqlTmpl = <<<EOQ
        INSERT INTO TaskPerformance
          (UserId, StudyId, TaskId, TaskStart)
        VALUES
          (%d, %d, %d, NOW())
EOQ;
    $sql = sprintf($sqlTmpl, $userId, $studyId, $taskId);
    mysql_query($sql);
  }

    mysql_query(
        sprintf(<<<EOQ
            INSERT INTO TaskPerformance
              (UserId, StudyId, TaskId, TaskStart)
            VALUES
              (%d, %d, %d, NOW())
            EOQ;
            )
            "INSERT INTO TaskPerformance (UserId, StudyId, TaskId, TaskStart)
        )
		    INSERT INTO TaskPerformance
				  (user_id, study_id, task_id, task_start)
			  VALUES (
				  " . $_SESSION['userId'] . ", " .
					$_SESSION['studyId'] . ", " .
					$_SESSION['taskId'] . ", NOW());");
}

familyName("Jani");
familyName("Hege");
familyName("Stale");
familyName("Kai Jim");
familyName("Borge");
?>
