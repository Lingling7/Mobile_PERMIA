<?php

	session_start();

	if(!$_SESSION['username'])
	{
		header("Location: Login.php");
		die();
	}

	$phase=$_REQUEST['phase'];
	$phase++;
	
	if($phase<=3)
	{
		header("Location: TaskScreen.php?phase=$phase");
	}
	else if($phase==4)
	{
		header("Location: PostQuestionnaire.php?phase=$phase");
	}
	else
	{
		header("Location: Thankyou.php");
	}

?>