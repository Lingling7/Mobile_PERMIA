<?php
	session_start();

	$_SESSION['studyId'] = $_SESSION['studyId'] + 1 % 5;
	$_SESSION['studyphase'] = 1;
	header("Location: studyManager.php");
	die();
?>