<?php
			session_start();
			
			if(!$_SESSION['username'])
			{
				header("Location: Login.php");
				die();
			}
			
			include 'config.php';

			header('Content-Type: text/html; charset=utf-8');
			
			$message ='';

			$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);

			if (!$con)
			{
			    die('Could not connect: ' . mysql_error());
			}

			mysql_select_db($_DATABASE);

			//Save data
			
			foreach ($_GET as $key => $value)
			{
				$query = "Insert into QuestionnaireAnswers (username,question,answer) Values('";
			 	$query .= $_SESSION['username'] . "','" . $key . "','" ;
				$query .= preg_replace("/[^\w\d ]/ui", ' ', $value) . "');";
				
				if (!mysql_query($query)) {
					$message .= mysql_error();
				}
			}								
			
			mysql_close($con);
			
			header('Refresh: 6; url=InterfaceChoice.php');
					
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
					include 'top.php';
				?>
		
				<div class='container'>
					<div class='headerContainer'>
						<div class='mainContainer'>
							<br/><br/><br/>
							<div class='instruction centerText'>Thank you very much for your Feedback!</div>
							<br/><br/>
							<div class='instruction centerText'>redirecting back to interface choice now...</div>
						</div>
					</div>			
				</div>
				
				<?php
					echo $message;
				?>
	</body>
</html>
