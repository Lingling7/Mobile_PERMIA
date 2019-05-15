<?php
			session_start();
			
			if(!$_SESSION['username'])
			{
				header("Location: Login.php");
				die();
			}
			
			header('Content-Type: text/html; charset=utf-8');
			
			session_destroy() 					
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
						<div class='mainContainer'>
							<br/><br/><br/>
							<div class='instruction centerText'>Thank you very much for your participation!</div>
						</div>
					</div>			
				</div>
	</body>
</html>
