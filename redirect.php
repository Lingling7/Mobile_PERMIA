<?php
	$website = $_GET["website"];
?>

<base href="<?=$website?>">

<?php
	// $remote = fopen($website, "r");
	// fpassthru($remote);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $website);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	echo $output;;
?>
