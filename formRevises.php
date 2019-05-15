<?php
	include 'config.php';
	session_start();

	header('Content-Type: text/html; charset=utf-8');

	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
  if (!$con) {
      die('Could not connect: ' . mysql_error());
  }
	mysql_select_db($_DATABASE);

	if(!$_SESSION['userId'])
	{
		header("Location: Login.php");
		die();
	}
	if(isset($_REQUEST["submitted"])) {
		$taskid = $_REQUEST['_taskid'];
    echo "line 19 " . $taskid;
		$result = mysql_query("SELECT * FROM SurveyQuestions WHERE TaskID = $taskid");
		if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
		}
		$i = 1;
		while($row = mysql_fetch_assoc($result)) {
			if (isset($_REQUEST[$i])) {
				$response = $_REQUEST[$i];
				$userId = $_SESSION['userId'];
				$question = $row['QuestionText'];
				echo $i . " " . $question . " ". $response . "; ";
				$system = $_SESSION['recent_interface'];
				$query = "INSERT INTO `Answers` (`id`, `question`, `user`, `response`, `system`) VALUES (NULL, '$question', '$userId', '$response', '$system')";
					if (!mysql_query($query)) {
						$message = mysql_error();
						mysql_close($con);
					}
			}
			$i = $i + 1;
		}
		header("Location: studyManager.php");
		die();
	}


	$taskid = $_REQUEST['taskid'];
  echo "line 47 " . $taskid;

	$result = mysql_query("SELECT * FROM SurveyQuestions WHERE TaskID = $taskid ORDER BY question_order");
	if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="Javascript/jquery.validate.min" type="text/javascript"></script>
	<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
	<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>

	<title>
		PerMIA
	</title>
</head>
<body>

	<?php
		include 'tasktop.php';
	?>

	<div class='container'>
		<div class='headerContainer'>
			<div class='instruction'>
				<p>Welcome to the PerMIA project.<br/>
				   Please fill out this form to get started.</p>
			</div>
			<div class='mainContainer'>
				<form id="questionForm">
					<?php
						$prev_was_multiple = false;
						while($row = mysql_fetch_assoc($result)) {
							$question_id = $row['question_order'];
							if ($row['type'] == 'text') {
								if ($prev_was_multiple) {
									echo "</select>";
									echo "<br>";
									echo "<br>";
									$prev_was_multiple = false;
								}
								echo "<br>";
								echo $row['question_text'];
								echo "<br>";
								if ($row['size'] == 'small') {
									echo "<input type='text' size='40' name='$question_id'> <br />";
									echo "<br>";
								} else if ($row['size'] == 'medium') {
									echo "<input type='text' size='50' name='$question_id'> <br />";
								} else if ($row['size'] == 'large') {
									echo "<textarea rows='5' cols='70' name='$question_id' form='questionForm'></textarea> <br />";
									echo "<br>";
								}
							} else if ($row['type'] == 'multiple' && $row['q_order'] == 1) {
								echo "<br>";
								if ($prev_was_multiple) {
									echo "</select>";
									echo "<br>";
									echo "<br>";
								}
								$prev_was_multiple = true;
								$name = $row['q_option'];
								echo $row['question_text'];
								echo "<br>";
								echo "<select name='$question_id'>";
								echo "<option value='$name'>$name</option>";
							} else if ($row['type'] == 'multiple' && $row['q_order'] != 1) {
								echo "<br>";
								$prev_was_multiple = true;
								$name = $row['q_option'];
								echo "<option value='$name'>$name</option>";
							} else if ($row['type'] == 'radio' && $row['q_order'] == 1) {
								echo "<br>";
								if ($prev_was_multiple) {
									echo "</select>";
									echo "<br>";
									echo "<br>";
									$prev_was_multiple = false;
								}
								$_id = $row['id'];
								echo $row['question_text'];
								$_option = $row['q_option'];
								echo "<br/>";
								echo "<input type='radio' id='$_id' name='$question_id' value='$_option' class='css-radio2'>";
								echo "<label for='$_id' class='css-radio2-label'></label>";
								echo " " . $_option . "&nbsp;&nbsp;";
								if ($row['size'] == "large") {
									echo "<br/>";
							  }

							} else if ($row['type'] == 'radio' && $row['q_order'] != 1) {
								$_id = $row['id'];
								$_option = $row['q_option'];
								echo "<input type='radio' id='$_id' name='$question_id' value='$_option' class='css-radio2'>";
								echo "<label for='$_id' class='css-radio2-label'></label>";
								echo " " . $_option . "&nbsp;&nbsp;";
								if ($row['size'] == "large") {
									echo "<br/>";
							  }
							} else {
								echo "invalid queston type in database.";
							}
						}
						if ($prev_was_multiple) {
									echo "</select>";
									echo "<br></br>";
									$prev_was_multiple = false;
						}
					?>
					<br>
					<?php
						$taskid = $_REQUEST['taskid'];
						echo "<input type='hidden' name='_taskid' value='$taskid'>";
					?>
					<br></br>
					<input type="hidden" name="submitted" value="true">
					<input type="submit" value="Submit Survey" action="">
					<br>
				</form>
			</div>
		</div>
	</div>
	</body>
</html>
