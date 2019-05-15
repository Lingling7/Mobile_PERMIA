<?php
		
			session_start();
			
			header('Content-Type: text/html; charset=utf-8');
		
			$message ='';
			
			include 'config.php';

			if(isset($_REQUEST["submitted"]))
			{
				
				if(isset($_REQUEST["username"]) && $_REQUEST["username"]!='')
				{
						$username = $_REQUEST["username"];
						$FirstName = $_REQUEST["FirstName"];
						$LastName = $_REQUEST["LastName"];
						$Email = $_REQUEST["Email"];
						
						$language1 = $_REQUEST["language1"];
						$language2 = $_REQUEST["language2"];
						$language3 = $_REQUEST["language3"];
						$language4 = $_REQUEST["language4"];
						
						$language1readingproficiency = $_REQUEST["language1readingproficiency"];
						$language2readingproficiency = $_REQUEST["language2readingproficiency"];
						$language3readingproficiency = $_REQUEST["language3readingproficiency"];
						$language4readingproficiency = $_REQUEST["language4readingproficiency"];
						
						$language1writingproficiency = $_REQUEST["language1writingproficiency"];
						$language2writingproficiency = $_REQUEST["language2writingproficiency"];
						$language3writingproficiency = $_REQUEST["language3writingproficiency"];
						$language4writingproficiency = $_REQUEST["language4writingproficiency"];
						
						$language1listeningproficiency = $_REQUEST["language1listeningproficiency"];
						$language2listeningproficiency = $_REQUEST["language2listeningproficiency"];
						$language3listeningproficiency = $_REQUEST["language3listeningproficiency"];
						$language4listeningproficiency = $_REQUEST["language4listeningproficiency"];
						
						if($language1!="" && $language2!="" && $language1readingproficiency!=0 && $language2readingproficiency!=0)
						{

							$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);

							if (!$con)
							{
							    die('Could not connect: ' . mysql_error());
							}

							mysql_select_db($_DATABASE);

							//User data
							$query = "Insert into User values ('$username','$password','$Email','$FirstName','$LastName')";
							if (!mysql_query($query)) {
						
								if(mysql_errno() == 1062)
								{
									$message = '<div class="error">Oops, this username is already taken, please choose a new one!</div>';
								}
								else
								{
									$message = mysql_error();
									mysql_close($con);
								}
							}
							//Proceed to store languages
							else
							{
								//Language 1
								$query = "Insert into LanguagePreferences values ('$username','$language1', 1, $language1readingproficiency, $language1writingproficiency, $language1listeningproficiency)";
								mysql_query($query);
								$message = mysql_error();

								//Language 2
								$query = "Insert into LanguagePreferences values ('$username','$language2', 2, $language2readingproficiency, $language2writingproficiency, $language2listeningproficiency)";
								mysql_query($query);
								$message = mysql_error();

								//Language 3
								if($language3!="")
								{
									$query = "Insert into LanguagePreferences values ('$username','$language3', 3, $language3readingproficiency, $language3writingproficiency, $language3listeningproficiency)";
									mysql_query($query);
									$message = mysql_error();
								}
								
								//Language 4
								if($language4!="")
								{
									$query = "Insert into LanguagePreferences values ('$username','$language4', 4, $language4readingproficiency, $language4writingproficiency, $language4listeningproficiency)";
									mysql_query($query);
									$message = mysql_error();
								}
							}					
						}
						else
						{
							$message = '<div class="error">You must choose at least a first language (language 1) and a second language (language 2), as well as the corresponding proficiencies</div>';	
						}
				}
				else{
					$message = '<div class="error">Please enter a username!</div>';		
				}
				
				if($message=='')
				{
					mysql_close($con);
					
					$_SESSION['username']=$username;
					$_SESSION['language1']=$language1;
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
					
					$language_codes = array(
					    "ar-XA" => "Arabic",
						"bg-BG" => "Bulgarian",
						"zh-CN" => "Chinese - Simplified",
						"zh-HK" => "Chinese - Traditional",
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
					
					$_SESSION['language_codes']=$language_codes;
					
					header("Location: Next.php?phase=0");
					die();
				}
				
			}
					
		?>
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
		
		<html>
			<head>
				<link rel="stylesheet" type="text/css" href="style.css">
				<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
				<script src="Javascript/jquery.validate.min" type="text/javascript"></script>
				<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
				<script type='text/javascript'>
					function checkEntry(){

					}
				</script>
				<title>
					PerMIA
				</title>
			</head>
			<body>
				
				<div class='topBar'>
					<div class='topContainer'>
						<div class='topLink left permia'>PerMIA</div>
						<div class='topLink right'><a href='Login.php'>Log in</a></div>
					</div>
				</div>
		
		<div class='container'>
			<div class='headerContainer'>

				<div class='mainContainer'>
					
				
				<form>
					<div class='instruction'>Please choose a username and enter some quick information about yourself: <br /><br /></div>
					Username* <input type="text" size="45" id="username" name="username" required> <br /> <br />
					First name&nbsp; <input type="text" size="45" id="FirstName" name="FirstName"> <br /> <br />
					Last name&nbsp; <input type="text" size="45" id="LastName" name="LastName"> <br /> <br />
					Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="45" id="Email" name="Email"> <br /> <br /><br />
					<div class='instruction'>Please indicate up to 4 languages that you are proficient in (at least 2), and your proficiency in them: <br /> <br /></div>
					
					Language 1* 
					<select name='language1' required>
							<option value="">select language</option>
						  	<option value="en-US">English</option>
							<option value="ar-XA">Arabic</option>
							<option value="bg-BG">Bulgarian</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="hr-HR">Croatian</option>
							<option value="cs-CZ">Czech</option>
							<option value="da-DK">Danish</option>
							<option value="nl-NL">Dutch</option>
							<option value="et-EE">Estonian</option>
							<option value="fi-FI">Finnish</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="el-GR">Greek</option>
							<option value="he-IL">Hebrew</option>
							<option value="hu-HU">Hungarian</option>
							<option value="it-IT">Italian</option>
							<option value="ja-JP">Japanese</option>
							<option value="ko-KR">Korean</option>
							<option value="lv-LV">Latvian</option>
							<option value="lt-LT">Lithuanian</option>
							<option value="nb-NO">Norwegian</option>
							<option value="pl-PL">Polish</option>
							<option value="pt-PT">Portuguese</option>
							<option value="ro-RO">Romanian</option>
							<option value="ru-RU">Russian</option>
							<option value="sk-SK">Slovak</option>
							<option value="sl-SL">Slovenian</option>
							<option value="es-ES">Spanish</option>
							<option value="sv-SE">Swedish</option>
							<option value="th-TH">Thai</option>
							<option value="tr-TR">Turkish</option>
							<option value="uk-UA">Ukrainian</option>
						</select>
						<select name='language1readingproficiency' required>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language1writingproficiency' required>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language1listeningproficiency' required>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
							
							
							
						
						 <br /><br />
						Language 2* <select name='language2' required>
							<option value="">select language</option>
						  	<option value="en-US">English</option>
							<option value="ar-XA">Arabic</option>
							<option value="bg-BG">Bulgarian</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="hr-HR">Croatian</option>
							<option value="cs-CZ">Czech</option>
							<option value="da-DK">Danish</option>
							<option value="nl-NL">Dutch</option>
							<option value="et-EE">Estonian</option>
							<option value="fi-FI">Finnish</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="el-GR">Greek</option>
							<option value="he-IL">Hebrew</option>
							<option value="hu-HU">Hungarian</option>
							<option value="it-IT">Italian</option>
							<option value="ja-JP">Japanese</option>
							<option value="ko-KR">Korean</option>
							<option value="lv-LV">Latvian</option>
							<option value="lt-LT">Lithuanian</option>
							<option value="nb-NO">Norwegian</option>
							<option value="pl-PL">Polish</option>
							<option value="pt-PT">Portuguese</option>
							<option value="ro-RO">Romanian</option>
							<option value="ru-RU">Russian</option>
							<option value="sk-SK">Slovak</option>
							<option value="sl-SL">Slovenian</option>
							<option value="es-ES">Spanish</option>
							<option value="sv-SE">Swedish</option>
							<option value="th-TH">Thai</option>
							<option value="tr-TR">Turkish</option>
							<option value="uk-UA">Ukrainian</option>
						</select>
						<select name='language2readingproficiency' required>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language2writingproficiency' required>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language2listeningproficiency' required>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						
						
						 <br /><br />
						Language 3&nbsp; <select name='language3'>
							<option value="">select language</option>
							<option value="">no third language</option>
						  	<option value="en-US">English</option>
							<option value="ar-XA">Arabic</option>
							<option value="bg-BG">Bulgarian</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="hr-HR">Croatian</option>
							<option value="cs-CZ">Czech</option>
							<option value="da-DK">Danish</option>
							<option value="nl-NL">Dutch</option>
							<option value="et-EE">Estonian</option>
							<option value="fi-FI">Finnish</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="el-GR">Greek</option>
							<option value="he-IL">Hebrew</option>
							<option value="hu-HU">Hungarian</option>
							<option value="it-IT">Italian</option>
							<option value="ja-JP">Japanese</option>
							<option value="ko-KR">Korean</option>
							<option value="lv-LV">Latvian</option>
							<option value="lt-LT">Lithuanian</option>
							<option value="nb-NO">Norwegian</option>
							<option value="pl-PL">Polish</option>
							<option value="pt-PT">Portuguese</option>
							<option value="ro-RO">Romanian</option>
							<option value="ru-RU">Russian</option>
							<option value="sk-SK">Slovak</option>
							<option value="sl-SL">Slovenian</option>
							<option value="es-ES">Spanish</option>
							<option value="sv-SE">Swedish</option>
							<option value="th-TH">Thai</option>
							<option value="tr-TR">Turkish</option>
							<option value="uk-UA">Ukrainian</option>
						</select>
						<select name='language3readingproficiency'>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language3writingproficiency'>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language3listeningproficiency'>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						
						 <br /><br />
						Language 4&nbsp; <select name='language4'>
							<option value="">select language</option>
							<option value="">no fourth language</option>
						  	<option value="en-US">English</option>
							<option value="ar-XA">Arabic</option>
							<option value="bg-BG">Bulgarian</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="hr-HR">Croatian</option>
							<option value="cs-CZ">Czech</option>
							<option value="da-DK">Danish</option>
							<option value="nl-NL">Dutch</option>
							<option value="et-EE">Estonian</option>
							<option value="fi-FI">Finnish</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="el-GR">Greek</option>
							<option value="he-IL">Hebrew</option>
							<option value="hu-HU">Hungarian</option>
							<option value="it-IT">Italian</option>
							<option value="ja-JP">Japanese</option>
							<option value="ko-KR">Korean</option>
							<option value="lv-LV">Latvian</option>
							<option value="lt-LT">Lithuanian</option>
							<option value="nb-NO">Norwegian</option>
							<option value="pl-PL">Polish</option>
							<option value="pt-PT">Portuguese</option>
							<option value="ro-RO">Romanian</option>
							<option value="ru-RU">Russian</option>
							<option value="sk-SK">Slovak</option>
							<option value="sl-SL">Slovenian</option>
							<option value="es-ES">Spanish</option>
							<option value="sv-SE">Swedish</option>
							<option value="th-TH">Thai</option>
							<option value="tr-TR">Turkish</option>
							<option value="uk-UA">Ukrainian</option>
						</select>
						<select name='language4readingproficiency'>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language4writingproficiency'>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language4listeningproficiency'>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						
						<br /><br /><br />
						<input type="hidden" name="submitted" value="true">
						<?php echo $message . "<br>"; ?>
						<input type="submit" value="Save and get started!" action="">
				</form>
				</div>

			</div>			
		</div>
	</body>
</html>
