<?php 
	session_start();
	include 'localise.php';
	
	$searchText = $_REQUEST["searchText"];
	$source = $_REQUEST["source"];
				
	$_SESSION['username']="experiment_" . $_REQUEST["randomid"];
	$_SESSION['language1']=$_REQUEST["language1"];
	$_SESSION['InterfaceLanguage']=$_REQUEST["language1"];
	$_SESSION['language2']=$_REQUEST["language2"];
	$_SESSION['language3']=$_REQUEST["language3"];
	$_SESSION['language4']=$_REQUEST["language4"];

	if($language1=='en-US')
	{
		$_SESSION['localised'] = $localised_en;
	}
	else if($language1=='de-DE')
	{
		$_SESSION['localised'] = $localised_de;
	}
	else if($language1=='fr-FR')
	{
		$_SESSION['localised'] = $localised_fr;
	}
	else if($language1=='zh-CN')
	{
		$_SESSION['localised'] = $localised_zh;
	}
	else if($language1=='he-IL')
	{
		$_SESSION['localised'] = $localised_he;
	}
	else{
		$_SESSION['localised'] = $localised_en;
	}
	
	if($_REQUEST["interface"]==1)
	{
		$redirect = 'PerMIA.php?experiment=true&interface=tabbed&searchText='. $searchText . '&source=' . $source . '&language=' . $_REQUEST["language1"];
	}
	else if($_REQUEST["interface"]==2)
	{
		$redirect = 'PerMIA.php?experiment=true&interface=recommender&searchText='. $searchText . '&source=' . $source . '&language=' . $_REQUEST["language1"];
	}
	else if($_REQUEST["interface"]==3)
	{
		$redirect = 'PerMIA.php?experiment=true&interface=dynamic&searchText='. $searchText . '&source=' . $source . '&language1=' . $_REQUEST["language1"] . '&language2=' . $_REQUEST["language2"] . '&language3=' . $_REQUEST["language3"] . '&language4=' . $_REQUEST["language4"];
	}
	else if($_REQUEST["interface"]==4)
	{
		$redirect = 'PerMIAil.php?experiment=true&interface=interleaved-dynamic&searchText='. $searchText . '&source=' . $source . '&language1=' . $_REQUEST["language1"] . '&language2=' . $_REQUEST["language2"] . '&language3=' . $_REQUEST["language3"] . '&language4=' . $_REQUEST["language4"];
	}
	else if($_REQUEST["interface"]==5)
	{
		$redirect = 'PerMIAil.php?experiment=true&interface=non-blended-vertical&searchText='. $searchText . '&source=' . $source . '&language1=' . $_REQUEST["language1"] . '&language2=' . $_REQUEST["language2"] . '&language3=' . $_REQUEST["language3"] . '&language4=' . $_REQUEST["language4"];
	}


	$language_codes = array(
		"ar-XA" => "العربية",
		"bg-BG" => "Български",
		"zh-CN" => "中文",
		"zh-HK" => "粵語",
		"hr-HR" => "Hrvatski",
		"cs-CZ" => "Čeština",
		"da-DK" => "Dansk",
		"nl-NL" => "Nederlands",
		"en-US" => "English",
		"en-GB" => "English",
		"et-EE" => "Eesti",
		"fi-FI" => "Suomi",
		"fr-FR" => "Français",
		"de-DE" => "Deutsch",
		"el-GR" => "Ελληνικά",
		"he-IL" => "עברית",
		"hu-HU" => "Magyar",
		"it-IT" => "Italiano",
		"ja-JP" => "日本語",
		"ko-KR" => "한국어",
		"lv-LV" => "Latviešu",
		"lt-LT" => "Lietuvių",
		"nb-NO" => "Norsk",
		"pl-PL" => "Polski",
		"pt-BR" => "Português",
		"ro-RO" => "Română",
		"ru-RU" => "Русский",
		"sk-SK" => "Slovenčina",
		"sl-SL" => "Slovenščina",
		"es-ES" => "Español",
		"sv-SE" => "Svenska",
		"th-TH" => "ไทย",
		"tr-TR" => "Türkçe",
		"uk-UA" => "Українська",
	);

	$_SESSION['language_codes']=$language_codes;
	
	
	if($_SESSION['InterfaceLanguage']=='en-US')
	{
		$_SESSION['localised'] = $localised_en;
	}
	else if($_SESSION['InterfaceLanguage']=='de-DE')
	{
		$_SESSION['localised'] = $localised_de;
	}
	else if($_SESSION['InterfaceLanguage']=='fr-FR')
	{
		$_SESSION['localised'] = $localised_fr;
	}
	else if($_SESSION['InterfaceLanguage']=='zh-CN')
	{
		$_SESSION['localised'] = $localised_zh;
	}
	else if($_SESSION['InterfaceLanguage']=='he-IL')
	{
		$_SESSION['localised'] = $localised_he;
	}
	else{
		$_SESSION['localised'] = $localised_en;
	}
	

	header("Location: $redirect");
	die();				
?>
