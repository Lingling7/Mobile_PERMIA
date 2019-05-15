<?php 

session_start();

if(!$_SESSION['username'])
{
	header("Location: Login.php");
	die();
}

$localised = $_SESSION['localised'];

header('Content-Type: text/html; charset=utf-8');

?>

	<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'>

	 <html>
	   <head>
			<link rel='stylesheet' type='text/css' href='style.css'>
			<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
			<script src='Javascript/jquery-1.11.0.min.js' type='text/javascript'></script>
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
				
				

				
				<div class='topText'><?php echo $localised['Please choose one of our interfaces!']?></div>
				
				<div class='interfaceChoice'>
					<div class='interfaceRow'>
						<div class='interface'>
							<div class='interfaceName'>Tabbed</div>
							<a href='PerMIA.php?interface=tabbed'><img src='images/Tabbed.png' width='300px' /></a>
						</div>
						<div class='interface'>
							<div class='interfaceName'>Side-bar</div>
							<a href='PerMIA.php?interface=recommender'><img src='images/Recommender.png' width='300px' /></a>
						</div>
					</div>
					<div class='interfaceRow'>
						<div class='interface'>
							<div class='interfaceName'>Panels</div>
							<a href='PerMIA.php?interface=panel'><img src='images/Dynamic.png' width='300px' /></a>
						</div>
						<div class='interface'>
							<div class='interfaceName'>Interleaved</div>
							<a href='PerMIAil.php?interface=interleaved-dynamic'><img src='images/Interleaved.png' width='300px' /></a>
						</div>
					</div>
					<div class='interfaceRow'>
						<div class='interface'>
							<div class='interfaceName'>Universal Search</div>
							<a href='PerMIAil.php?interface=non-blended-vertical'><img src='images/Non-blended-vertical.png' width='300px' /></a>
						</div>
<!--					<div class='interface'>
							<div class='interfaceName'>Dynamic</div>
							<a href='PerMIAdy.php?interface=dynamic'><img src='images/Non-blended-vertical.png' width='300px' /></a>
						</div>
-->
					</div>
			</div>			
		</div>
	</body>
</html>