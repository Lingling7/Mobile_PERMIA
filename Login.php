<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'localise.php';
include 'config.php';
		
			$message ='';
			
			if(isset($_REQUEST["submitted"]))
			{
				
				if(isset($_REQUEST["username"]) && $_REQUEST["username"]!='')
				{
					if(isset($_REQUEST["password"])  && $_REQUEST["password"]!='')
					{
						$username = $_REQUEST["username"];
						$password = $_REQUEST["password"];

						$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);

						if (!$con)
						{
						    die('Could not connect: ' . mysql_error());
						}

						mysql_select_db($_DATABASE);

						//Confirm password
						$result = mysql_query("SELECT Password,InterfaceLanguage FROM P4MobileMnewsUser where username='$username'");
						if (!$result) {
						    $message  = 'Invalid query: ' . mysql_error() . "\n";
						    $message .= 'Whole query: ' . $query;
						}

						$row = mysql_fetch_assoc($result);
						$correct_password = $row['Password'];
						$InterfaceLanguage = $row['InterfaceLanguage'];
							
						if($password==$correct_password)
						{
							
							$result = mysql_query("SELECT language, number, reading, writing, listening FROM P4MobileMnewsLanguagePreferences where userID='$username' order by number");
							if (!$result) {
							    $message  = 'Invalid query: ' . mysql_error() . "\n";
							    die($message);
							}

							while ($row = mysql_fetch_assoc($result)) {
							    if($row['number']==1)
								{
									$language1= $row['language'];
									$language1readingproficiency= $row['reading'];
									$language1writingproficiency= $row['writing'];
									$language1listeningproficiency= $row['listening'];
								}
								else if($row['number']==2)
								{
									$language2= $row['language'];
									$language2readingproficiency= $row['reading'];
									$language2writingproficiency= $row['writing'];
									$language2listeningproficiency= $row['listening'];
								}
								else if($row['number']==3)
								{
									$language3= $row['language'];
									$language3readingproficiency= $row['reading'];
									$language3writingproficiency= $row['writing'];
									$language3listeningproficiency= $row['listening'];
								}
								else if($row['number']==4)
								{
									$language4= $row['language'];
									$language4readingproficiency= $row['reading'];
									$language4writingproficiency= $row['writing'];
									$language4listeningproficiency= $row['listening'];
								}
							    
							}

							mysql_close($con);
							
							$_SESSION['username']=$username;
							$_SESSION['language1']=$language1;
							$_SESSION['InterfaceLanguage']=$InterfaceLanguage;
							$_SESSION['language1readingproficiency']=$language1readingproficiency;
							$_SESSION['language1writingproficiency']=$language1writingproficiency;
							$_SESSION['language1listeningproficiency']=$language1listeningproficiency;
							$_SESSION['language2']=$language2;
							$_SESSION['language2readingproficiency']=$language2readingproficiency;
							$_SESSION['language2writingproficiency']=$language2writingproficiency;
							$_SESSION['language2listeningproficiency']=$language2listeningproficiency;
							$_SESSION['language3']=$language3;
							$_SESSION['language3readingproficiency']=$language3readingproficiency;
							$_SESSION['language3writingproficiency']=$language3writingproficiency;
							$_SESSION['language3listeningproficiency']=$language3listeningproficiency;
							$_SESSION['language4']=$language4;
							$_SESSION['language4readingproficiency']=$language4readingproficiency;
							$_SESSION['language4writingproficiency']=$language4writingproficiency;
							$_SESSION['language4listeningproficiency']=$language4listeningproficiency;
							
							if($InterfaceLanguage=='en-US')
							{
								$_SESSION['localised'] = $localised_en;
							}
							else if($InterfaceLanguage=='de-DE')
							{
								$_SESSION['localised'] = $localised_de;
							}
							else if($InterfaceLanguage=='fr-FR')
							{
								$_SESSION['localised'] = $localised_fr;
							}
							else if($InterfaceLanguage=='zh-CN')
							{
								$_SESSION['localised'] = $localised_zh;
							}
							else if($InterfaceLanguage=='he-IL')
							{
								$_SESSION['localised'] = $localised_he;
							}
							else{
								$_SESSION['localised'] = $localised_en;
							}
							
							/*
							$language_codes = array(
							    "ar-XA" => "Arabic",
								"bg-BG" => "Bulgarian",
								"zh-CN" => "Chinese (Simpl.)",
								"zh-HK" => "Chinese (Trad.)",
								"hr-HR" => "Croatian",
								"cs-CZ" => "Czech",
								"da-DK" => "Danish",
								"nl-NL" => "Dutch",
								"en-US" => "English",
								"et-EE" => "Estonian",
								"fi-FI" => "Finnish",
								"fr-FR" => "French",
								"de-DE" => "German",
								"el-GR" => "Greek",
								"he-IL" => "Hebrew",
								"hu-HU" => "Hungarian",
								"it-IT" => "Italian",
								"ja-JP" => "Japanese",
								"ko-KR" => "Korean",
								"lv-LV" => "Latvian",
								"lt-LT" => "Lithuanian",
								"nb-NO" => "Norwegian",
								"pl-PL" => "Polish",
								"pt-PT" => "Portuguese",
								"ro-RO" => "Romanian",
								"ru-RU" => "Russian",
								"sk-SK" => "Slovak",
								"sl-SL" => "Slovenian",
								"es-ES" => "Spanish",
								"sv-SE" => "Swedish",
								"th-TH" => "Thai",
								"tr-TR" => "Turkish",
								"uk-UA" => "Ukrainian",
							);
							*/
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
							
							header("Location: studyManager.php");
							die();
						}
						else
						{
							$message = '<br><div class="error">Incorrect username or password!</div>';
							mysql_close($con);
						}					
					}
					else
					{
						$message = '<br><div class="error">Please enter a password!</div>';	
					}
				}
				else
				{
					$message = '<br><div class="error">Please enter a username!</div>';		
				}
				
			}
					
		?>
		
		
	<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'>

	 <html>
	   <head>
			<link rel='stylesheet' type='text/css' href='style.css'>
			
			<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-52996822-1', 'auto');
			  ga('send', 'pageview');

			</script>
			
			<script src='Javascript/jquery-1.11.0.min.js' type='text/javascript'></script>
			<title>
				PerMIA
			</title>
		</head>
		<body>
		
			<div class='topBar'>
				<div class='topContainer'>
					<div class='topLink left permia'>PerMIA</div><div class='topLink right'><a href='CreateAccount.php'>Create new account</a></div>
				</div>
			</div>
		
		<div class='container'>
			<div class='headerContainer'>

				<div class='topText'>
					<p>Welcome to the PerMIA project.</p>
					<p>Please log in or create a new account to get started!</p>
				</div>
				<div class='mainContainer'>
					<div class='login'>
					<form>
						Username <input type="text" size="25" id="username" name="username"> <br /> <br />
						Password &nbsp;<input type="password" size="25" id="password" name="password"> <br />
											
						<input type="hidden" name="submitted" value="true">
						<?php echo $message . "<br>"; ?>
						<input type="submit" value="Login" action="">
					</form>
					<div class='smallText'><a href='CreateAccount.php'>Create new account</a></div>
				</div>

			</div>
		</div>
	</body>
</html>
