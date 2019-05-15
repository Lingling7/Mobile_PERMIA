<?php
		
			session_start();
			
			if(!$_SESSION['username'])
			{
				header("Location: Login.php");
				die();
			}
			
			include 'config.php';

			header('Content-Type: text/html; charset=utf-8');
			
			
			//get question
			$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);

			if (!$con)
			{
			    die('Could not connect: ' . mysql_error());
			}

			mysql_select_db($_DATABASE);

			$query = "select TaskQuestion FROM P4MobileMnewsTasks WHERE Tasks.id=(SELECT Task" . $_REQUEST['phase'] . " FROM P4MobileMnewsTaskAssignment WHERE UserId='". $_SESSION['username'] . "')";

			$result = mysql_query($query);
			
			if (!$result) {
			    $message  = 'Invalid query: ' . mysql_error() . "\n";
			    $message .= 'Whole query: ' . $query;
			}

			$row = mysql_fetch_assoc($result);
			$question = $row['TaskQuestion'];
			
			mysql_close($con);
					
?>
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
		
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
		<script src="Javascript/jquery.validate.min.js" type="text/javascript"></script>
		<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
		<script src="lightbox/lightbox.min.js"></script>
		<link href="lightbox/lightbox.css" rel="stylesheet" />
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
				<div class='mainContainer'>
					
				
				<form class='questionnaire' action="Next.php" method="post">
					<input type="hidden" id="phase" name="phase" value="<?php echo $_REQUEST['phase']?>">
					
					<div class='instruction'>Task <?php echo $_REQUEST['phase']?> </div> <br />
									
					<?php echo $question?><br/>
					<textarea cols="80" rows="10" id="q108" name="q108"></textarea> <br />

					<br /><br /><br />
					<input type="submit" value="Submit and continue"><br /><br /><br /><br />
				</form>
				</div>
			</div>			
		</div>
	</body>
</html>
