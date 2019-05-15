<?php
		
			session_start();
			
			if(!$_SESSION['username'])
			{
				header("Location: Login.php");
				die();
			}
			
			header('Content-Type: text/html; charset=utf-8');
					
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
				<div class='mainContainer'>
					
				
				<form class='questionnaire' action="Next.php" method="get">
					<input type="hidden" id="phase" name="phase" value="<?php echo $_REQUEST['phase']?>">
				
					<div class='instruction'>Questionnaire</div> <br />
									
					Any other general comments?<br/>
					<textarea cols="80" rows="10" id="q401" name="q401"></textarea> <br />

					
					<br /><br /><br />
					<input type="submit" value="Submit and continue"><br /><br /><br /><br />
				</form>
				</div>
			</div>			
		</div>
	</body>
</html>
