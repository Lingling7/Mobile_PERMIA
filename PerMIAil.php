<?php
	include 'config.php';
	include 'localise.php';
	if(!isset($_SESSION))
    {
        session_start();
    }

	// if(!$_SESSION['userId'])
	// {
	// 	header("Location: Login.php");
	// 	die();
	// }
	$languageArray= array("en-US"=>"English Description", "zh-CN"=>"Simplified Chinese Description", "zh-HK"=>"Traditional Chinese Desrption",
												"fr-FR"=>"French Description", "de-DE"=>"German Description", "es-ES"=>"Spanish Description", "it-IT"=>"Italian Description");

	$Language1Description="";
	$Language2Description="";
	$Language3Description="";
	$Language4Description="";
	// echo $_SESSION['language1'] . " " . $language1;
	if($_SESSION['language1']!=""){
		$Language1Description=$languageArray[$_SESSION['language1']];
	}
	if($_SESSION['language2']!=""){
		$Language2Description=$languageArray[$_SESSION['language2']];
	}
	if($_SESSION['language3']!=""){
		$Language3Description=$languageArray[$_SESSION['language3']];
	}
	if($_SESSION['language4']!=""){
		$Language4Description=$languageArray[$_SESSION['language4']];
	}

	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_set_charset('utf8', $con);
	mysql_query("set names 'utf8'",$con);
	mysql_select_db($_DATABASE);

	if(isset($_REQUEST["taskid"])) {
		$taskid = intval($_REQUEST['taskid']);
		$_SESSION['taskid'] = $taskid;
		$result = mysql_query("SELECT * FROM P4MobileMnewsSearches WHERE TaskID = $taskid");
		//$result = mysql_query("SELECT TaskQuestion FROM Tasks WHERE TaskID = $taskid");
		$row = mysql_fetch_assoc($result);
		$_SESSION['task1_text'] = $row[$_SESSION['language1']];
		$_SESSION['task2_text'] = $row[$_SESSION['language2']];
		$_SESSION['task3_text'] =  $row[$_SESSION['language3']];
		$_SESSION['task4_text'] = $row[$_SESSION['language4']];
	} else if (isset($_SESSION["task"])) {
		$task_text = $_SESSION["task"];
	}


	if(isset($_REQUEST['experiment']))
	{
		$_SESSION['experiment'] = true;
		$extras_visibility = 'hidden';
	}
	else if(isset($_SESSION['experiment']))
	{
		if($_SESSION['experiment']==true)
		{
			$extras_visibility = 'hidden';
		}
		else
		{
			$extras_visibility = '';
		}

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
		if($_SESSION['interface']=='interleaved-dynamic')
		{
			$option_type = 'checkbox';
			$option_display = 'nothidden';
		}
		if($_SESSION['interface']=='non-blended-vertical')
		{
			$option_type = 'checkbox';
			$option_display = 'nothidden';
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
	$number_of_results = 0;

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

	if($number_of_languages<2)
	{
		$number_of_results = 12;
	}
	else if($number_of_languages<3)
	{
		$number_of_results = 6;
	}
	else if($number_of_languages==3)
	{
		$number_of_results = 4;
	}
	else
	{
		$number_of_results = 3;
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
		<script src="src/iframeResizer.contentWindow.min.js" type="text/javascript">
		</script>
		
		<script type="text/javascript">

			var favoriteBasket = [];

			var languagenames = [];
			languagenames[1] = <?php echo json_encode($_SESSION["language_codes"][$language1])?>;
			languagenames[2] = <?php echo json_encode($_SESSION['language_codes'][$language2])?>;
			languagenames[3] = <?php echo json_encode($_SESSION['language_codes'][$language3])?>;
			languagenames[4] = <?php echo json_encode($_SESSION['language_codes'][$language4])?>;
			var currentinterface = <?php echo json_encode($_SESSION['interface'])?>;

			var results = [];

			function setCookie(cname, cvalue, exdays) {
			    var d = new Date();
			    d.setTime(d.getTime() + (exdays*24*60*60*1000));
			    var expires = "expires="+d.toUTCString();
			    document.cookie = cname + "=" + cvalue + "; " + expires;
			}

			function getCookie(cname) {
			    var name = cname + "=";
			    var ca = document.cookie.split(';');
			    for(var i = 0; i < ca.length; i++) {
			        var c = ca[i];
			        while (c.charAt(0) == ' ') {
			            c = c.substring(1);
			        }
			        if (c.indexOf(name) == 0) {
			            return c.substring(name.length, c.length);
			        }
			    }
			    return "";
			}

			function translateAndSearchAll(text, number_of_results, page, source, language1, language2, language3, language4)
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
							searchOne(tr1[0], language1, <?php echo $number_of_results?>, page, '<?php echo $source?>', 1),
							searchOne(tr2[0], language2, <?php echo $number_of_results?>, page, '<?php echo $source?>', 2),
							searchOne(tr3[0], language3, <?php echo $number_of_results?>, page, '<?php echo $source?>', 3),
							searchOne(tr4[0], language4, <?php echo $number_of_results?>, page, '<?php echo $source?>', 4)
						  ).done(function(
								r1, r2, r3, r4) {
							//updating results after searching
							updateResults(r1[0], r2[0], r3[0], r4[0]);

							text1 = htmlspecialchars(tr1[0]);
							text2 = htmlspecialchars(tr2[0]);
							text3 = htmlspecialchars(tr3[0]);
							text4 = htmlspecialchars(tr4[0]);

							$(".next").append("<a href=''><?php echo $localised['Next']?> &gt;</a>");

							nextString = "javascript:singleSearchOnNextPrevious(\""+text1+"\",\""+text2+"\",\""+text3+"\",\""+text4+"\",\""+language1+"\",\""+language2+"\",\""+language3+"\",\""+language4+"\","+number_of_results+","+(page+1)+",'"+source+"')";
							$(".next a").attr('href', nextString);

							var favs = $('.favButton');
							console.log(favs);
							console.log(favoriteBasket);
							for (var d = 0; d < favs.length; d++) {
								for (var k = 0; k < favoriteBasket.length; k++) {
									if ($(favs[d]).parent().children('a').attr('href') === favoriteBasket[k].link && $(favs[d]).parent().parent().attr('language') === favoriteBasket[k].language) {
										$(favs[d]).addClass("unFavButton");
										$(favs[d]).removeClass("favButton");
										$(favs[d]).css("color", "red");
										$(favs[d]).text("Not Relevant");
										break;
									}
								}
							}
						});
					});
				}
			}

			function singleSearchOnNextPrevious(text1, text2, text3, text4, language1, language2, language3, language4, number_of_results, direction, source)
			{
					pagination = pagination + direction;
					offset=(pagination-1)*number_of_results;

					$("#loaderplaceholder").html('<img src=\'images/ajax-loader.gif\'/>');
					$("#resultList").html('<img src=\'images/ajax-loader.gif\'/>');

					$(".next a").hide();
					$(".previous a").hide();

					   //searching after translating
					$.when(
						searchOne(text1, language1, <?php echo $number_of_results?>, offset, '<?php echo $source?>', 1),
						searchOne(text2, language2, <?php echo $number_of_results?>, offset, '<?php echo $source?>', 2),
						searchOne(text3, language3, <?php echo $number_of_results?>, offset, '<?php echo $source?>', 3),
						searchOne(text4, language4, <?php echo $number_of_results?>, offset, '<?php echo $source?>', 4)
					  ).done(function( r1, r2, r3, r4) {
						//updating results after searching
						updateResults(r1[0], r2[0], r3[0], r4[0]);

						$(".next a").show();

						if(pagination>1)
						{
							$(".previous a").replaceWith("<a href=''>&lt; <?php echo $localised['Previous']?></a>");
							previousString ="javascript:singleSearchOnNextPrevious(\""+text1+"\",\""+text2+"\",\""+text3+"\",\""+text4+"\",\""+language1+"\",\""+language2+"\",\""+language3+"\",\""+language4+"\","+<?php echo $number_of_results?>+","+(-1)+",'<?php echo $source?>')";
							$(".previous a").attr('href', previousString);

							$(".previous").show();
						}
						var favs = $('.favButton');
						console.log(favoriteBasket);
						for (var d = 0; d < favs.length; d++) {
							for (var k = 0; k < favoriteBasket.length; k++) {
								if ($(favs[d]).parent().children('a').attr('href') === favoriteBasket[k].link && $(favs[d]).parent().parent().attr('language') === favoriteBasket[k].language) {
									$(favs[d]).addClass("unFavButton");
									$(favs[d]).removeClass("favButton");
									$(favs[d]).css("color", "red");
									$(favs[d]).text("Not Relevant");
									break;
								}
							}
						}
					});
			}

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
					searchOne(text1, language1, <?php echo $number_of_results?>, 0, '<?php echo $source?>', 1),
					searchOne(text2, language2, <?php echo $number_of_results?>, 0, '<?php echo $source?>', 2),
					searchOne(text3, language3, <?php echo $number_of_results?>, 0, '<?php echo $source?>', 3),
					searchOne(text4, language4, <?php echo $number_of_results?>, 0, '<?php echo $source?>', 4)
				  ).done(function( r1, r2, r3, r4) {
					//updating results after searching
					updateResults(r1[0], r2[0], r3[0], r4[0]);

					nextString = "javascript:singleSearchOnNextPrevious(\""+text1+"\",\""+text2+"\",\""+text3+"\",\""+text4+"\",\""+language1+"\",\""+language2+"\",\""+language3+"\",\""+language4+"\","+<?php echo $number_of_results?>+","+1+",'<?php echo $source?>')";
					$(".next a").attr('href', nextString);

					$(".next a").show();
				});


			}

			function translateOne(text, to)
			{
				return $.post( "translate.php", { text: text, to: to});
			}

			function searchOne(text, to, results, offset, source, number)
			{
				$("#loaderplaceholder").html('');

				if(text!='')
				{
					$("#translatedQueryValue" + number).html(text  + " |");
				}

				return $.post( "search.php", { searchText: text, market: to, results: results, offset: offset, source: source});
			}

			function updateResults(r1, r2, r3, r4){

				$(".editAll").html('<?php if($localised['Edit']){echo $localised['Edit'];}else{echo "Edit";}?>');

				$("#resultList").html('');
				language1results = r1; //$.parseHTML( r1 );
				language2results = r2; //$.parseHTML( r2 );
				language3results = r3; //$.parseHTML( r3 );
				language4results = r4; //$.parseHTML( r4 );

				console.log("r1 " + r1);
				console.log("language1results " + language1results);

				var languageArray = new Array();
				var languageNameArray = new Array();

				if(language1results!=null && $(language1results).children().get(0))
				{
					languageArray.push(language1results);
					languageNameArray.push(languagenames[1]);
				}

				if(language2results!=null && $(language2results).children().get(0))
				{
					languageArray.push(language2results);
					languageNameArray.push(languagenames[2]);
				}

				if(language3results!=null && $(language3results).children().get(0))
				{
					languageArray.push(language3results);
					languageNameArray.push(languagenames[3]);
				}

				if(language4results!=null && $(language4results).children().get(0))
				{
					languageArray.push(language4results);
					languageNameArray.push(languagenames[4]);
				}

				if(<?php echo json_encode($_SESSION['interface'])?> == 'non-blended-vertical')
				{
					for( j=0 ; j< <?php echo $number_of_languages?> ; j++)
					{//split different languages
					//$("#resultList").append("<div class='separator-text' align='<?php echo $interface_direction_alignment?>'>"+ languageNameArray[j]+"</div>");
					//$("#resultList").append("<hr class='separator' align='<?php echo $interface_direction_alignment?>'>");
					$("#resultList").append($(languageArray[j]));
					$("#resultList").append("<hr class='separator' align='<?php echo $interface_direction_alignment?>'>");


					}
					
				}
				else
				{
					for( k=0 ; k< <?php echo $number_of_languages?> ; k++)
					{
						headerinformation = $('<div></div>');
						$(headerinformation).html(languageArray[k]);
						headerinformation = $(headerinformation).find('link,script');
						console.log(headerinformation);
						$("#resultList").prepend(headerinformation);	
					}

					for( j=0 ; j< <?php echo $number_of_results?> ; j++)
					{
						for( k=0 ; k< <?php echo $number_of_languages?> ; k++)
						{
							$("#resultList").append($(languageArray[k]).children().get(j));
						}
					}
				}

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
							$(".translationAlternatives"+1).html(" <div class='AlternativeTitle2'> <?php if($localised['Alternatives']){echo $localised['Alternatives'];}else{echo "Alternatives";}?> </div> " + data);
							$(".translationAlternatives"+1).slideDown('slow');
						});
						$.post( "getTranslations.php", { text: text, to: languageArray[2].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+2).html(" <div class='AlternativeTitle2'> <?php if($localised['Alternatives']){echo $localised['Alternatives'];}else{echo "Alternatives";}?> </div> " + data);
							$(".translationAlternatives"+2).slideDown('slow');
						});
						$.post( "getTranslations.php", { text: text, to: languageArray[3].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+3).html(" <div class='AlternativeTitle2'> <?php if($localised['Alternatives']){echo $localised['Alternatives'];}else{echo "Alternatives";}?> </div> " + data);
							$(".translationAlternatives"+3).slideDown('slow');
						});
						$.post( "getTranslations.php", { text: text, to: languageArray[4].substr(0,2)} ).done(function( data ) {
							$(".translationAlternatives"+4).html(" <div class='AlternativeTitle2'> <?php if($localised['Alternatives']){echo $localised['Alternatives'];}else{echo "Alternatives";}?> </div> " + data);
							$(".translationAlternatives"+4).slideDown('slow');
						});
						//////


				 	$(this).parent().children(".editPanel2").append("<br/><div class='editSubmit'><input id='submitEdits' type='submit' value='<?php if($localised['Submit']){echo $localised['Submit'];}else{echo "Submit";}  ?>'/></div>");
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

			$(document).on('click', '.favButton', function()
			{
				link = $(this).parent().children('a').attr('href');
				language = $(this).parent().parent().attr('language');

				title = $(this).text();
				snippet= $(this).parent().parent().children('.snippet').text();
				rank= $(this).parent().parent().attr('rank');

				favoriteBasket.push({ type: 'favorite', link: link, language: language, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface, queryid: "<?php echo $_SESSION['current_query'];?>"});

				$(this).addClass("unFavButton");
				$(this).removeClass("favButton");
				$(this).css("color", "red");
				$(this).text("Not Relevant");

				console.log(favoriteBasket);

			});

			$(document).on('click', '.unFavButton', function()
			{
				link = $(this).parent().children('a').attr('href');
				language = $(this).parent().parent().attr('language');

				title = $(this).text();
				snippet= $(this).parent().parent().children('.snippet').text();
				rank= $(this).parent().parent().attr('rank');

				// fix this so it removes the right one
				favoriteBasket.splice(favoriteBasket.indexOf({ type: 'favorite', link: link, language: language, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface, queryid: "<?php echo $_SESSION['current_query'];?>"}), 1);

				$(this).addClass("favButton");
				$(this).removeClass("unFavButton");
				$(this).css("color", "#FBC02D");
				$(this).text("Relevant");

				console.log(favoriteBasket);
			});

			//LINK CLICK LOGGING
			$(document).on('click contextmenu', 'a', function()
			{

				link = $(this).attr('href');
				language = $(this).parent().parent().attr('language');
				var json_strings = JSON.stringify(favoriteBasket);
				setCookie("basket", "", 365);
				setCookie("basket", json_strings, 365);

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

			$(document).on('click', '#finish', function()
			{
				setCookie("basket", "", 365);
				for (var i = 0; i < favoriteBasket.length; i++) {
					var request = $.ajax({
					  type: 'POST',
					  url: 'Log.php',
					  data: { type: favoriteBasket[i].type, link: favoriteBasket[i].link, language: favoriteBasket[i].language, title: favoriteBasket[i].title, snippet: favoriteBasket[i].snippet, rank: favoriteBasket[i].rank, currentinterface: favoriteBasket[i].currentinterface, queryid: favoriteBasket[i].queryid},
					  dataType: "html",
					  async:false
					});
					request.done(function( msg ) {
					});
				}
				window.location.href = "studyManager.php";
			});


			$( document ).ready(function() {
				var json_string = getCookie("basket");
				if (json_string === "") {
					favoriteBasket = [];
				} else {
					favoriteBasket = JSON.parse(json_string);
				}
				translateAndSearchAll('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', '<?php echo $number_of_results ?>', 0, '<?php echo $source ?>','<?php echo $selected_language1 ?>','<?php echo $selected_language2 ?>','<?php echo $selected_language3 ?>','<?php echo $selected_language4 ?>');

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
		<div class='container'>

			<div class='headerContainer<?php echo $option_display?>' oncopy="return false" oncut="return false" onpaste="return false">
				<?php
				$taskid = intval($_REQUEST['taskid']);
				if($_SESSION['taskid'] === 0){
					echo "<span class=practiceTaskDisplay>This is a Practice Task</span>";
					echo "<br/>";
				}
				?>

				<table width="100%"> <tr> <td>
					<?php
					echo "<span class=taskDisplay>";
					echo "<u>";
					if($Language1Description){
						echo $Language1Description;
					} else {
						echo "English Task Description";
					}
					echo "</u>: ";
					if($_SESSION['task1_text']){
						echo htmlspecialchars($_SESSION['task1_text']);
					} else {
						echo htmlspecialchars("Find documents that describe or discuss the impact of consumer boycotts.");
					}
					echo "</span>";
					// echo "<br/>";
					echo "<span class=taskDisplay>";
					echo "<u>";
					if($Language2Description){
						echo $Language2Description;
					} else {
						echo "Simplified Chinese Task Description";
					}
					echo "</u>: ";
					if($_SESSION['task2_text']){
						echo htmlspecialchars($_SESSION['task2_text']);
					} else {
						echo htmlspecialchars("寻找有关消费者联合抵制商品造成冲击的文章");
					}
					echo "</span>";
						if ($Language3Description != "") {
							echo "<span class=taskDisplay> <u>$Language3Description</u>: ";
							echo htmlspecialchars($_SESSION['task3_text']);
							echo "</span>";
						}
						if ($Language4Description != "") {
							echo "<span class=taskDisplay> <u>$Language4Description</u>: ";
							echo htmlspecialchars($_SESSION['task4_text']);
							echo "</span>";
						}
					?>
				</td>
				<td width="110">
					<?php
						echo "<a id='finish' href='#'>Finish Task</a>";
					?>
				</td>
				</tr> </table>
				
				<form>
					<div class='inputBoxes'>
					<input type="hidden" name="interface" value="<?php echo $_SESSION['interface']?>">
					<input type="text" style="width:500px;" id="searchText" name="searchText" value="<?php echo htmlspecialchars($text,ENT_QUOTES)?>">
					<input type="submit" id='submitbutton' value="<?php if($localised['Search']) {echo $localised['Search'];} else { echo "Search";}?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

					<br/><!-- <br/> -->

					<div id='options' class='<?php echo $option_display;?>'>
				<?php
				if($language1 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name1,ENT_QUOTES) . '" id="language1" value="' . $language1 . '" class="css-' . $option_type . '"' . $checked1 .'><label for="language1" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language1] . '</label>';
				} else {
					echo '<input type="checkbox" name="language1" id="language1" value="en-US" class="css-checkbox" checked=""> <label for="language1" class="css-checkbox-label">English</label>';
				}
				if($language2 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name2,ENT_QUOTES) . '" id="language2" value="' . $language2 . '" class="css-' . $option_type . '"' . $checked2 .'><label for="language2" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language2] . '</label>';
				} else {
					echo '<input type="checkbox" name="language2" id="language2" value="ch-ZN" class="css-checkbox" checked=""> <label for="language2" class="css-checkbox-label">中文</label>';
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
							<div class='header2'>
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

							<div id='translatedResultsValues' class='translatedResultsValues'>
								<div id='resultList'>
								</div>
							</div>
							<div class='pagination'>
								<div class='previous left'><a href=''></a></div>
								<div class='next right'><a href=''></a></div>
							</div>
							</div>

			</div>

		</div>
		  
	</body>
</html>
