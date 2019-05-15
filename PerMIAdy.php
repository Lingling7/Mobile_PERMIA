<?php 
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	if(!$_SESSION['username'])
	{
		header("Location: Login.php");
		die();
	}
	
	if(isset($_REQUEST['experiment']))
	{
		$_SESSION['experiment'] = true;
		$extras_visibility = 'hidden';
	}
	else if(isset($_SESSION['experiment']))
	{
		$extras_visibility = 'hidden';
	}
	else
	{
		$_SESSION['experiment'] = false;
		$extras_visibility = '';
	}
	
	header('Content-Type: text/html; charset=utf-8');

	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'>";

	if(isset($_REQUEST["interface"]))
	{
		$_SESSION['interface'] = $_REQUEST["interface"];
	}
	
	
	
	//setting up variables
	
	$localised = $_SESSION['localised'];
	$InterfaceLanguage = $_SESSION['InterfaceLanguage'];
	
	if($InterfaceLanguage=='ar-XA' || $InterfaceLanguage=='he-IL')
	{
		$interface_direction = 'rtl';
		$interface_direction_alignment = 'right';
	}
	else
	{
		$interface_direction = '';
		$interface_direction_alignment = 'left';
	}
	
	if($_SESSION['interface'])
	{
		if($_SESSION['interface']=='dynamic')
		{
			$option_type = 'radio';
			$option_display = 'hidden';
		}
	}
	else
	{
		$option_type = 'checkbox';
		$option_display = 'nothidden';
	}
	
	$firstSearch = true;
	$checked1='';
	$checked2='';
	$checked3='';
	$checked4='';
	$checkedweb='';
	$checkednews='';
	
	$language1='';
	$language2='';
	$language3='';
	$language4='';
	
	$selected_language1='';
	$selected_language2='';
	$selected_language3='';
	$selected_language4='';
	
	$number_of_languages = 0;
	$number_of_main_results = 10;
	$number_of_secondary_results = 3;
 	
	//getting user languages
	if($_SESSION['language1'])
	{
		$language1 = $_SESSION['language1'];
	}
	if($_SESSION['language2'])
	{
		$language2 = $_SESSION['language2'];
	}
	if($_SESSION['language3'])
	{
		$language3 = $_SESSION['language3'];
	}
	if($_SESSION['language4'])
	{
		$language4 = $_SESSION['language4'];
	}

	//getting source type
	if(isset($_REQUEST["source"]))
	{
		$source = $_REQUEST["source"];
		
		if($source=='Web')
		{
			$checkedweb='checked';
		}
		if($source=='News')
		{
			$checkednews='checked';
		}
	}
	else
	{
		$checkedweb='checked';
	}
	
	

	//getting selected language
	
	$name1 = "language1";
	$name2 = "language2";
	$name3 = "language3";
	$name4 = "language4";
	
	if(isset($_REQUEST["language1"]) && $_REQUEST["language1"]!="")
	{
		$selected_language1 = $_REQUEST["language1"];
		$checked1='checked';
		++$number_of_languages;
	}
	else
	{
		$selected_language1 = '';
	}

	if(isset($_REQUEST["language2"]) && $_REQUEST["language2"]!="")
	{
		$selected_language2 = $_REQUEST["language2"];
		$checked2='checked';
		++$number_of_languages;
	}
	else
	{
		$selected_language2 = '';
	}

	if(isset($_REQUEST["language3"]) && $_REQUEST["language3"]!="")
	{
		$selected_language3 = $_REQUEST["language3"];
		$checked3='checked';
		++$number_of_languages;
	}
	else
	{
		$selected_language3 = '';
	}

	if(isset($_REQUEST["language4"]) && $_REQUEST["language4"]!="")
	{
		$selected_language4 = $_REQUEST["language4"];
		$checked4='checked';
		++$number_of_languages;
	}
	else
	{
		$selected_language4 = '';
	}
	
	
		
	
	
	if(isset($_REQUEST["searchText"]))
	{
		$firstSearch = false;
		$text = $_REQUEST["searchText"];
	}
	else
	{
		$text = '';
	}
	
	
	if($number_of_languages==0 && $firstSearch)
	{
		$checked1='checked';
		$checked2='checked';
		$checked3='checked';
		$checked4='checked';
	}
	
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="styleResultPage.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageRight.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageHeader<?php echo $interface_direction;?>.css">
		<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
		<script src="src/iframeResizer.contentWindow.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			
			var languagenames = [];
			languagenames[1] = <?php echo json_encode($_SESSION["language_codes"][$language1])?>;
			languagenames[2] = <?php echo json_encode($_SESSION['language_codes'][$language2])?>;
			languagenames[3] = <?php echo json_encode($_SESSION['language_codes'][$language3])?>;
			languagenames[4] = <?php echo json_encode($_SESSION['language_codes'][$language4])?>;
			var currentinterface = <?php echo json_encode($_SESSION['interface'])?>;
			
			var results = [];
		
			function translateAndSearchAll(text, number_of_main_results, page, source, language1, language2, language3, language4)
			{
				if(text!='' && (language1 != '' || language2 != '' || language3 != '' || language4))
				{	
					$("#loaderplaceholder").html('<img src=\'images/ajax-loader.gif\'/>');
					$("#resultList").html('<img src=\'images/ajax-loader.gif\'/>');
					$("#translatedQuery").toggle();
					
					//translating			
					$.when(
						translateOne(text, language1),
						translateOne(text, language2),
						translateOne(text, language3),
						translateOne(text, language4)
					).done(function( tr1, tr2, tr3, tr4) {
					    //searching after translating
						$.when(
							searchOne(tr1[0], language1, 3, page, '<?php echo $source?>', 1),
							searchOne(tr1[0], language1, 7, page+3, '<?php echo $source?>', 1),
							searchOne(tr2[0], language2, 3, page, '<?php echo $source?>', 2),
							searchOne(tr3[0], language3, 3, page, '<?php echo $source?>', 3),
							searchOne(tr4[0], language4, 3, page, '<?php echo $source?>', 4)
						  ).done(function( r1a, r1b, r2, r3, r4) {
							//updating results after searching
							updateResults(r1a[0], r1b[0], r2[0], r3[0], r4[0]);
							
							text1 = htmlspecialchars(tr1[0]);
							text2 = htmlspecialchars(tr2[0]);
							text3 = htmlspecialchars(tr3[0]);
							text4 = htmlspecialchars(tr4[0]);
							
							$(".next").append("<a href=''><?php echo $localised['Next']?> &gt;</a>");
							
							nextString = "javascript:singleSearchOnNextPrevious(\""+text1+"\",\""+text2+"\",\""+text3+"\",\""+text4+"\",\""+language1+"\",\""+language2+"\",\""+language3+"\",\""+language4+"\","+number_of_main_results+","+(page+1)+",'"+source+"')";
							$(".next a").attr('href', nextString);
							
						});
					});
				}
			}


			function singleSearchOnNextPrevious(text1, text2, text3, text4, language1, language2, language3, language4, number_of_main_results, direction, source)
			{
					pagination = pagination + direction;
					offset=(pagination-1)*number_of_main_results;
					
					$("#loaderplaceholder").html('<img src=\'images/ajax-loader.gif\'/>');
					$("#resultList").html('<img src=\'images/ajax-loader.gif\'/>');
					
					$(".next a").hide();
					$(".previous a").hide();
					
					if(pagination<2)
					{
					   //searching after translating
						$.when(
							searchOne(text1, language1, 3, offset, '<?php echo $source?>', 1),
							searchOne(text1, language1, 7, offset+3, '<?php echo $source?>', 1),
							searchOne(text2, language2, 3, offset, '<?php echo $source?>', 2),
							searchOne(text3, language3, 3, offset, '<?php echo $source?>', 3),
							searchOne(text4, language4, 3, offset, '<?php echo $source?>', 4)
						  ).done(function( r1a, r1b, r2, r3, r4) {
							//updating results after searching
							updateResults(r1a[0], r1b[0], r2[0], r3[0], r4[0]);
						
							$(".next a").show();
	
						});
					}
					else
					{
						//searching after translating
							$.when(
								searchOne(text1, language1, <?php echo $number_of_main_results?>, offset, '<?php echo $source?>', 1)
							  ).done(function( r1) {
								//updating results after searching
								$("#resultList").html(r1);

								$(".next a").show();

								$(".previous a").replaceWith("<a href=''>&lt; <?php echo $localised['Previous']?></a>");
								previousString ="javascript:singleSearchOnNextPrevious(\""+text1+"\",\""+text2+"\",\""+text3+"\",\""+text4+"\",\""+language1+"\",\""+language2+"\",\""+language3+"\",\""+language4+"\","+<?php echo $number_of_main_results?>+","+(-1)+",'<?php echo $source?>')";
								$(".previous a").attr('href', previousString);

								$(".previous").show();

							});
					}
			}
			
/*** TO DO - FIX EDIT ***
			function searchOnEditedTranslations(text1, text2, text3, text4, language1, language2, language3, language4)
			{
				pagination = 1;
				
				$(".next a").hide();
				$(".previous a").hide();
				$("#resultList").html('<img src=\'images/ajax-loader.gif\'/>');
				
				if(text1==undefined)
				{
					text1='';
				}
				
				if(text2==undefined)
				{
					text2='';
				}
				
				if(text3==undefined)
				{
					text3='';
				}
				
				if(text4==undefined)
				{
					text4='';
				}
				
				$.when(
					searchOne(text1, language1, <?php echo $number_of_main_results?>, 0, '<?php echo $source?>', 1),
					searchOne(text2, language2, <?php echo $number_of_secondary_results?>, 0, '<?php echo $source?>', 2),
					searchOne(text3, language3, <?php echo $number_of_secondary_results?>, 0, '<?php echo $source?>', 3),
					searchOne(text4, language4, <?php echo $number_of_secondary_results?>, 0, '<?php echo $source?>', 4)
				  ).done(function( r1, r2, r3, r4) {
					//updating results after searching
					updateResults(r1[0], r2[0], r3[0], r4[0]);
					
					nextString = "javascript:singleSearchOnNextPrevious(\""+text1+"\",\""+text2+"\",\""+text3+"\",\""+text4+"\",\""+language1+"\",\""+language2+"\",\""+language3+"\",\""+language4+"\","+<?php echo $number_of_main_results?>+","+1+",'<?php echo $source?>')";
					$(".next a").attr('href', nextString);
					
					$(".next a").show();	
				});
				
						
			}
			
*** END TO DO ***/
			
			function translateOne(text, to)
			{
				return $.post( "translate.php", { text: text, to: to});	
			}
			
			function searchOne(text, to, results, offset, source, number)
			{
				$("#loaderplaceholder").html('');
				
				if(text!='')
				{
					$("#translatedQueryValue" + number).html(text);
				}
				
				return $.post( "search.php", { searchText: text, market: to, results: results, offset: offset, source: source});
			}
			
			function updateResults(r1a, r1b, r2, r3, r4){
				
				$(".editAll").html('<?php echo $localised['Edit']?>');

				$("#resultList").html('');
				
				language1aresults = $.parseHTML( r1a );			
				language1bresults = $.parseHTML( r1b );
				language2results = $.parseHTML( r2 );
				language3results = $.parseHTML( r3 );
				language4results = $.parseHTML( r4 );
				
				var languageArray = new Array();
				var languageNameArray = new Array();
				var languageNumberArray = new Array();
				
				// DO THE REORDERING ACCORDING TO CONFIGURATION (Result lists 1 and 2 are in L1, 3 is in L2, 4 is in L3, 5 is in L4)
				
				var configuration ='middle';
				
				if(configuration == 'top')
				{
								
					if(language2results!=null)
					{
						languageArray.push(language2results);
						languageNameArray.push(languagenames[2]);
						languageNumberArray.push(2);
					}
				
					if(language3results!=null)
					{
						languageArray.push(language3results);
						languageNameArray.push(languagenames[3]);
						languageNumberArray.push(3);
					}
				
					if(language4results!=null)
					{
						languageArray.push(language4results);
						languageNameArray.push(languagenames[4]);
						languageNumberArray.push(4);
					}
					
					if(language1aresults!=null)
					{
						languageArray.push(language1aresults);
						languageNameArray.push(languagenames[1]);
						languageNumberArray.push(1);
					}
					
					if(language1bresults!=null)
					{
						languageArray.push(language1bresults);
						languageNameArray.push(languagenames[1]);
						languageNumberArray.push(1);
					}
				
				}
				if(configuration == 'middle')
				{
					if(language1aresults!=null)
					{
						languageArray.push(language1aresults);
						languageNameArray.push(languagenames[1]);
						languageNumberArray.push(1);
					}
				
					if(language2results!=null)
					{
						languageArray.push(language2results);
						languageNameArray.push(languagenames[2]);
						languageNumberArray.push(2);
					}
				
					if(language3results!=null)
					{
						languageArray.push(language3results);
						languageNameArray.push(languagenames[3]);
						languageNumberArray.push(3);
					}
				
					if(language4results!=null)
					{
						languageArray.push(language4results);
						languageNameArray.push(languagenames[4]);
						languageNumberArray.push(4);
					}
					
					if(language1bresults!=null)
					{
						languageArray.push(language1bresults);
						languageNameArray.push(languagenames[1]);
						languageNumberArray.push(1);
					}
				

				}
				else if(configuration == 'bottom')
				{
					if(language1aresults!=null)
					{
						languageArray.push(language1aresults);
						languageNameArray.push(languagenames[1]);
						languageNumberArray.push(1);
					}

					if(language1bresults!=null)
					{
						languageArray.push(language1bresults);
						languageNameArray.push(languagenames[1]);
						languageNumberArray.push(1);
					}
				
					
					if(language2results!=null)
					{
						languageArray.push(language2results);
						languageNameArray.push(languagenames[2]);
						languageNumberArray.push(2);
					}
				
					if(language3results!=null)
					{
						languageArray.push(language3results);
						languageNameArray.push(languagenames[3]);
						languageNumberArray.push(3);
					}
				
					if(language4results!=null)
					{
						languageArray.push(language4results);
						languageNameArray.push(languagenames[4]);
						languageNumberArray.push(4);
					}
				}

				for( j=0 ; j< <?php echo $number_of_languages+1?> ; j++)
				{
					
					if(j>0 && languageNameArray[j]!=languageNameArray[j-1])
					{
						$("#resultList").append("<hr class='separator-dynamic' align='<?php echo $interface_direction_alignment?>'>");
					}
					
					
					
					if(languageNameArray[j]!=languageNameArray[j-1] && languageNameArray[j]!=languagenames[1])
					{		
						$("#resultList").append("<div class='extra-results'><div class='separator-dynamic-text-top' align='<?php echo $interface_direction_alignment?>'>"+languageNameArray[j]+": \""+$("#translatedQueryValue" + languageNumberArray[j]).html()+"\"</div></div>");
						$("#resultList").append("<div class='extra-results'>" + $(languageArray[j]).html() + "</div>");
					}
					else
					{
						$("#resultList").append($(languageArray[j]));
					}
					
					
					
					
					/* TO DO: MORE RESULTS FEATURE
					if(languageNameArray[j]!=languagenames[1])
					{
						$("#resultList").append("<div class='more-results' align='<?php echo $interface_direction_alignment?>'><a href='"+$("#translatedQueryValue" + (j+1)).html()+"'>More results</a></div>");
					}
					*/
				}
				
				$("#resultList").append("<hr class='separator-dynamic' align='<?php echo $interface_direction_alignment?>'>");
			}
			
			//edit function
			$(document).on("click", ".editAll", function(event){

				languageArray = new Array();

				$(this).parent().children(".editPanel2").html('');
				
				$(this).parent().children(".queries").each(function() {
					languagenumber = $(this).attr('languagenumber');
					
					text = $(this).text().substring(0, $(this).text().length - 2);
					language = $(this).attr('language');
					id = $(this).attr('id');
					
					languageArray[languagenumber]=language;
					
					if(text!='')
					{
						$(this).parent().children(".editPanel2").append("<div class='alternativetranslations2'><div class='editPanel2Input'><input id='input"+languagenumber+"' type='text' size='40'/></div><div class='hidden alternative2 translationAlternatives"+languagenumber+"'></div><br/><br/>");
						$('#input'+languagenumber).val(text);
					}
					
					
				  });
						
						// Get alternatives for original query
						text = $("#searchText").attr("value");

					  	$.post( "getTranslations.php", { text: text, to: languageArray[1].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+1).html(" <div class='AlternativeTitle2'> <?php echo $localised['Alternatives']?> </div> " + data);
							$(".translationAlternatives"+1).slideDown('slow');
						});
						$.post( "getTranslations.php", { text: text, to: languageArray[2].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+2).html(" <div class='AlternativeTitle2'> <?php echo $localised['Alternatives']?> </div> " + data);
							$(".translationAlternatives"+2).slideDown('slow');
						});
						$.post( "getTranslations.php", { text: text, to: languageArray[3].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+3).html(" <div class='AlternativeTitle2'> <?php echo $localised['Alternatives']?> </div> " + data);
							$(".translationAlternatives"+3).slideDown('slow');
						});
						$.post( "getTranslations.php", { text: text, to: languageArray[4].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+4).html(" <div class='AlternativeTitle2'> <?php echo $localised['Alternatives']?> </div> " + data);
							$(".translationAlternatives"+4).slideDown('slow');
						});
						//////
						
				
				 	$(this).parent().children(".editPanel2").append("<br/><div class='editSubmit'><input id='submitEdits' type='submit' value='<?php echo $localised['Submit'] ?>'/></div>");
				  	$(this).parent().children(".editPanel2").slideToggle('slow');
				
					$( "#submitEdits").click(function() {
						
						language1 = $(this).parent().parent().parent().children().eq(0).attr('language');
						language2 = $(this).parent().parent().parent().children().eq(1).attr('language');
						language3 = $(this).parent().parent().parent().children().eq(2).attr('language');
						language4 = $(this).parent().parent().parent().children().eq(3).attr('language');
					
						text1 = $("#input"+1).val();
						text2 = $("#input"+2).val();
						text3 = $("#input"+3).val();
						text4 = $("#input"+4).val();

						searchOnEditedTranslations(text1, text2, text3, text4, language1, language2, language3, language4);
					});
			});
			
			
			
			
			
			//QUERY LOGGING
			$(document).on('click', '#submitbutton', function()
			{
				
				searchQuery = $('#searchText').val() ;
				language1 = $('#language1').prop('checked');
				language2 = $('#language2').prop('checked');
				language3 = $('#language3').prop('checked');
				language4 = $('#language4').prop('checked');
				web = $('#source1').prop('checked');
				news = $('#source2').prop('checked');
								
				var request = $.ajax({
				  type: 'POST',
				  url: 'Log.php',
				  data: { type: 'query', searchQuery: searchQuery, language1: language1, language2: language2, language3: language3, language4: language4, web: web, news: news, currentinterface: currentinterface},
				  dataType: "html",
				  async:false
				});

				request.done(function( msg ) {
					;
				});
				
			});
			
			//TO DO: EDIT LOGGING
			$(document).on('click', '.editSubmit', function()
			{	
				editedQuery = 'all';
				language = 'all';
				
					
				var request = $.ajax({
				  type: 'POST',
				  url: 'Log.php',
				  data: { type: 'edit', editedQuery: editedQuery, language: language},
				  dataType: "html",
				  async:false
				});

				request.done(function( msg ) {
				});
				
			});
			
			//LINK CLICK LOGGING
			$(document).on('click contextmenu', 'a', function()
			{

				link = $(this).attr('href');
				language = $(this).parent().parent().attr('language');
				
				if(language != undefined)
				{
					title = $(this).text();
					snippet= $(this).parent().parent().children('.snippet').text();
					rank= $(this).parent().parent().attr('rank');;
				}
				else
				{
					language = '';
					title = '';
					snippet = '';
					rank = '';
				}
						
				var request = $.ajax({
				  type: 'POST',
				  url: 'Log.php',
				  data: { type: 'link', link: link, language: language, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface},
				  dataType: "html",
				  async:false
				});

				request.done(function( msg ) {
				});
			});
			
			
			
			
			$( document ).ready(function() {
				translateAndSearchAll('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', '<?php echo $number_of_main_results ?>', 0, '<?php echo $source ?>','<?php echo $selected_language1 ?>','<?php echo $selected_language2 ?>','<?php echo $selected_language3 ?>','<?php echo $selected_language4 ?>');
				
				$("*[type='checkbox']").change(function () {
					$( "#submitbutton" ).trigger( "click" );
				});
				
				$("*[type='radio']").change(function () {
					$( "#submitbutton" ).trigger( "click" );
				});
				
				pagination = 1;
			});
			
			//helper methods
			function htmlspecialchars(string){
				return string
				         .replace(/&/g, "&amp;")
				         .replace(/</g, "&lt;")
				         .replace(/>/g, "&gt;")
				         .replace(/"/g, "&quot;")
				         .replace(/'/g, "&#039;");
				}
				
			function reverse_htmlspecialchars(string){
					return string
					         .replace(/&amp;/g, "&")
					         .replace(/&lt;/g, "<")
					         .replace(/&gt;/g, ">")
					         .replace(/&quot;/g, "\"")
					         .replace(/&#039;/g, "'");
				}
				
				
			
		</script>
		<title>
			PerMIA
		</title>
	
	</head>
	<body>
		
		<?php
			if(!$_SESSION['experiment'])
			{
				include 'top'. $interface_direction . '.php';
			}
			else
			{
				include 'topreduced'. $interface_direction . '.php';
			}
		?>
		
		<div class='container'>
			
			<div class='headerContainer<?php echo $option_display?>'>
				<form>
					<div class='inputBoxes'>
					<input type="hidden" name="interface" value="<?php echo $_SESSION['interface']?>">
					<input type="text" style="width:500px;" id="searchText" name="searchText" value="<?php echo htmlspecialchars($text,ENT_QUOTES)?>">
					<input type="submit" id='submitbutton' value="<?php echo $localised['Search']?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					
					&nbsp;&nbsp;<input type='radio' name='source' id='source1' value='Web' class='<?php echo $extras_visibility ;?> css-radio2 ' <?php echo $checkedweb ;?>><label for='source1' class='<?php echo $extras_visibility ;?> css-radio2-label'> <?php echo $localised['Web']?> </label>
					<input type='radio' name='source' id='source2' value='News' class='<?php echo $extras_visibility ;?> css-radio2 ' <?php echo $checkednews ;?>><label for='source2' class='<?php echo $extras_visibility ;?> css-radio2-label'><?php echo $localised['News']?></label>
					
					<br/><br/>
					
					<div id='options' class='<?php echo $option_display;?>'>						
				<?php
				
				if($language1 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name1,ENT_QUOTES) . '" id="language1" value="' . $language1 . '" class="css-' . $option_type . '"' . $checked1 .'><label for="language1" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language1] . '</label>';
				}
				if($language2 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name2,ENT_QUOTES) . '" id="language2" value="' . $language2 . '" class="css-' . $option_type . '"' . $checked2 .'><label for="language2" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language2] . '</label>';
				}
				if($language3 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name3,ENT_QUOTES) . '" id="language3" value="' . $language3 . '" class="css-' . $option_type . '"' . $checked3 .'><label for="language3" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language3] . '</label>';
				}
				if($language4 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name4,ENT_QUOTES) . '" id="language4" value="' . $language4 . '" class="css-' . $option_type . '"' . $checked4 .'><label for="language4" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language4] . '</label>';
				}
				
				
				?>
					</div>
					
					
					
					</div>
				</form>
			</div>
			<div class='resultContainer<?php echo $option_display?>'>

						<div id='translatedQuery' class='hidden box1 merged <?php echo $interface_direction;?>'>
							<div class='header2 hidden'>
								<div id='loaderplaceholder' class='loader'></div>
								<div id='translatedQueryValues' class='translatedQueryValues'>
								<?php
									for($i=1;$i<5;$i++)
									{
										echo "<div id='translatedQueryValue" . $i . "'  languagenumber='" . $i . "' language='" . ${'language'.$i} . "' class='queries'></div>";
									}
								?>
								<div class='editAll <?php echo $extras_visibility?>'></div>
								<div class='editPanel2 <?php echo $extras_visibility?>'></div>
								</div>
							</div>
							
							<div id='translatedResultsValues' class='translatedResultsValues'><div ID='resultList'></div></div>
							<div class='pagination'>
								<div class='previous left'><a href=''></a></div>
								<div class='next right'><a href=''></a></div>
							</div>
							</div>
				
			</div>
			
		</div>
	</body>
</html>
