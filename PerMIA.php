<?php
	include 'config.php';
	if(!isset($_SESSION))
    {
        session_start();
    }

	// if(!$_SESSION['userId'])  // make changes here to remove the Login.php direct
	// {
	// 	header("Location: Login.php");
	// 	die();
	// }
	$languageArray= array("en-US"=>"English Task Description", 
	"zh-CN"=>"Simplified Chinese Task Description", 
	"zh-HK"=>"Traditional Chinese Task Desrption",
	"fr-FR"=>"French Task Description",
	"de-DE"=>"German Task Description", 
	"es-ES"=>"Spanish Task Description", 
	"it-IT"=>"Italian Task Description");

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
	if($_SESSION['language3']!=""){
		$Language4Description=$languageArray[$_SESSION['language4']];
	}
	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_set_charset('utf8', $con);
	mysql_query("SET NAMES utf8");
	//mysql_query("set names 'utf8'",$con);
	mysql_select_db($_DATABASE);

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

	if(isset($_SESSION['current_query']))
	{
		if($_SESSION['current_query'])
		{
			$current_query = $_SESSION['current_query'];
		}
		else
		{
			$current_query = 0;
		}
	}
	else
	{
		$current_query = 0;
	}

	if(isset($_REQUEST["interface"]))
	{
		$_SESSION['interface'] = $_REQUEST["interface"];
	}

	if(isset($_REQUEST["taskid"])) {
		$taskid = intval($_REQUEST['taskid']);
		$_SESSION['taskid'] = $taskid;
		$result = mysql_query("SELECT * FROM P4MobileMnewsSearches WHERE TaskID = $taskid");
		//$result = mysql_query("SELECT TaskQuestion FROM Tasks WHERE TaskID = $taskid");
		$row = mysql_fetch_assoc($result);
		$_SESSION['taskid'] = $taskid;
		$_SESSION['task1_text'] = $row[$_SESSION['language1']];
		$_SESSION['task2_text'] = $row[$_SESSION['language2']];
		$_SESSION['task3_text'] =  $row[$_SESSION['language3']];
		$_SESSION['task4_text'] = $row[$_SESSION['language4']];
	} else if (isset($_SESSION["task"])) {
		$task_text = $_SESSION["task"];
	}

	//setting up variables
	$localised = $_SESSION['localised'];
	// foreach ($_SESSION as $key=>$value) {
	// 	echo $key . " " . $value;
	// 	echo "<br/>";
	// }
	// die();
	$InterfaceLanguage = $_SESSION['InterfaceLanguage'];

	if($InterfaceLanguage=='ar-XA' || $InterfaceLanguage=='he-IL')
	{
		$interface_direction = 'rtl';

	}
	else
	{
		$interface_direction = '';
	}

	if($_SESSION['interface'])
	{
		if($_SESSION['interface']=='tabbed')
		{
			$option_type = 'radio';
			$option_display = 'nothidden';
			$display_style = 'merged';
		}

		if($_SESSION['interface']=='dynamic')
		{
			$option_type = 'radio';
			$option_display = 'nothidden';
			$display_style = 'merged';
		}

		if($_SESSION['interface']=='non-blended-panel')
		{
			$option_type = 'checkbox';
			$option_display = 'hidden';
			$display_style = 'nonmerged';
		}

		if($_SESSION['interface']=='panel')
		{
			$option_type = 'checkbox';
			$option_display = 'nothidden';
			$display_style = 'nonmerged';
		}

		if($_SESSION['interface']=='recommender')
		{
			$option_type = 'radio';
			$option_display = 'nothidden';
			$display_style = 'recommender';
		}

	}
	else
	{
		$option_type = 'checkbox';
		$option_display = 'hidden';
		$display_style = 'merged';
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

	$direction1='';
	$direction2='';
	$direction3='';
	$direction4='';

	$number_of_boxes = 0;
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

	//determining language directions
	if($language1 == 'ar-XA' || $language1 == 'he-IL')
	{
		 $direction1='rtl';
	}
	else
	{
		$direction1='ltr';
	}

	if($language2 == 'ar-XA' || $language2 == 'he-IL')
	{
		 $direction2='rtl';
	}
	else
	{
		$direction2='ltr';
	}

	if($language3 == 'ar-XA' || $language3 == 'he-IL')
	{
		 $direction3='rtl';
	}
	else
	{
		$direction3='ltr';
	}

	if($language4 == 'ar-XA' || $language4 == 'he-IL')
	{
		 $direction4='rtl';
	}
	else
	{
		$direction4='ltr';
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



// 	//tabbed interface
// 	if($_SESSION['interface']=='tabbed')
// 	{
// 		$name1 = "language";
// 		$name2 = "language";
// 		$name3 = "language";
// 		$name4 = "language";

// 		if(isset($_REQUEST["language"]) && $_REQUEST["language"]!="")
// 		{
// 			$number_of_boxes++;
// 			$selected_language = $_REQUEST["language"];

// 			if($selected_language==$language1)
// 			{
// 				$checked1='checked';
// 				$selected_language1 = $selected_language;
// 			}
// 			else
// 			{
// 				$selected_language1 = '';
// 			}
// 			if($selected_language==$language2)
// 			{
// 				$checked2='checked';
// 				$selected_language2 = $selected_language;
// 			}
// 			else
// 			{
// 				$selected_language2 = '';
// 			}
// 			if($selected_language==$language3)
// 			{
// 				$checked3='checked';
// 				$selected_language3 = $selected_language;
// 			}
// 			else
// 			{
// 				$selected_language3 = '';
// 			}
// 			if($selected_language==$language4)
// 			{
// 				$checked4='checked';
// 				$selected_language4 = $selected_language;
// 			}
// 			else
// 			{
// 				$selected_language4 = '';
// 			}
// 		}
// 		else
// 		{
// 			$checked1='checked';
// 		}
// 	}

//tabbed interface
if($_SESSION['interface']=='tabbed')
{
	$name1 = "language";
	$name2 = "language";
	$name3 = "language";
	$name4 = "language";

	if(isset($_REQUEST["language"]) && $_REQUEST["language"]!="")
	{
		$number_of_boxes++;
		$selected_language = $_REQUEST["language"];

		if($selected_language==$language1)
		{
			$checked1='checked';
			$selected_language1 = $selected_language;
		}
		else
		{
			$selected_language1 = '';
		}
		if($selected_language==$language2)
		{
			$checked2='checked';
			$selected_language2 = $selected_language;
		}
		else
		{
			$selected_language2 = '';
		}
		if($selected_language==$language3)
		{
			$checked3='checked';
			$selected_language3 = $selected_language;
		}
		else
		{
			$selected_language3 = '';
		}
		if($selected_language==$language4)
		{
			$checked4='checked';
			$selected_language4 = $selected_language;
		}
		else
		{
			$selected_language4 = '';
		}
	}
	else
	{
		$checked1='checked';
	}
}


	//recommender interface
	else if($_SESSION['interface']=='recommender')
	{
		$name1 = "language";
		$name2 = "language";
		$name3 = "language";
		$name4 = "language";

		if(isset($_REQUEST["language"]))
		{
			$selected_language = $_REQUEST["language"];

			if($selected_language==$language1)
			{
				$checked1='checked';
			}
			if($selected_language==$language2)
			{
				$checked2='checked';
			}
			if($selected_language==$language3)
			{
				$checked3='checked';
			}
			if($selected_language==$language4)
			{
				$checked4='checked';
			}

			$selected_language1 = $language1;
			$selected_language2 = $language2;
			$selected_language3 = $language3;
			$selected_language4 = $language4;

			if($selected_language1 != '')
			{
				$number_of_boxes++;
			}
			if($selected_language2 != '')
			{
				$number_of_boxes++;
			}
			if($selected_language3 != '')
			{
				$number_of_boxes++;
			}
			if($selected_language4 != '')
			{
				$number_of_boxes++;
			}

		}
		else
		{
			$checked1='checked';
		}
	}


	//panel and vertical interface
	else
	{
		$name1 = "language1";
		$name2 = "language2";
		$name3 = "language3";
		$name4 = "language4";

		if(isset($_REQUEST["language1"])  && $_REQUEST["language1"]!="")
		{
			$selected_language1 = $_REQUEST["language1"];
			$checked1='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language1 = '';
		}

		if(isset($_REQUEST["language2"])  && $_REQUEST["language2"]!="")
		{
			$selected_language2 = $_REQUEST["language2"];
			$checked2='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language2 = '';
		}

		if(isset($_REQUEST["language3"]) && $_REQUEST["language3"]!="")
		{
			$selected_language3 = $_REQUEST["language3"];
			$checked3='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language3 = '';
		}

		if(isset($_REQUEST["language4"]) && $_REQUEST["language4"]!="")
		{
			$selected_language4 = $_REQUEST["language4"];
			$checked4='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language4 = '';
		}

		if($number_of_boxes==0 && $firstSearch )
		{
			$checked1='checked';
			$checked2='checked';
			$checked3='checked';
			$checked4='checked';
		}

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

	if($_SESSION['interface']=='recommender' || $_SESSION['interface']=='dynamic')
	{
		$number_of_results = 10;
		$number_of_main_results = 10;

		if($number_of_boxes<3)
		{
			$number_of_secondary_results = 5;
		}
		else if($number_of_boxes<4)
		{
			$number_of_secondary_results = 4;
		}
		else
		{
			$number_of_secondary_results = 3;
		}

		if($checked1=='checked')
		{
			$number_of_results1 = $number_of_main_results;
			$number_of_results2 = $number_of_secondary_results;
			$number_of_results3 = $number_of_secondary_results;
			$number_of_results4 = $number_of_secondary_results;
		}
		if($checked2=='checked')
		{
			$number_of_results1 = $number_of_secondary_results;
			$number_of_results2 = $number_of_main_results;
			$number_of_results3 = $number_of_secondary_results;
			$number_of_results4 = $number_of_secondary_results;
		}
		if($checked3=='checked')
		{
			$number_of_results1 = $number_of_secondary_results;
			$number_of_results2 = $number_of_secondary_results;
			$number_of_results3 = $number_of_main_results;
			$number_of_results4 = $number_of_secondary_results;
		}
		if($checked4=='checked')
		{
			$number_of_results1 = $number_of_secondary_results;
			$number_of_results2 = $number_of_secondary_results;
			$number_of_results3 = $number_of_secondary_results;
			$number_of_results4 = $number_of_main_results;
		}
	}
	else if($number_of_boxes<2 || $display_style=="merged")
	{
		$number_of_results = 12;
		$number_of_results1 = 12;
		$number_of_results2 = 12;
		$number_of_results3 = 12;
		$number_of_results4 = 12;
	}
	else if($number_of_boxes<3)
	{
		$number_of_results = 6;
		$number_of_results1 = 6;
		$number_of_results2 = 6;
		$number_of_results3 = 6;
		$number_of_results4 = 6;
	}
	else if($number_of_boxes<4)
	{
		$number_of_results = 4;
		$number_of_results1 = 4;
		$number_of_results2 = 4;
		$number_of_results3 = 4;
		$number_of_results4 = 4;
	}
	else
	{
		$number_of_results = 3;
		$number_of_results1 = 3;
		$number_of_results2 = 3;
		$number_of_results3 = 3;
		$number_of_results4 = 3;
	}
	$_SESSION[number_of_boxes] = $number_of_boxes;
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="styleResultPage.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageRight.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageHeader<?php echo $interface_direction;?>.css">
		<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
		<!-- <script src="src/iframeResizer.contentWindow.min.js" type="text/javascript"></script> -->
		<script src="http://davidjbradshaw.com/iframe-resizer/js/iframeResizer.contentWindow.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			var relevantBasket = [];
			var currentinterface = <?php echo json_encode($_SESSION['interface'])?>;

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

			function setRelevants() {
				var relevants = $('.favButton');
				for (var d = 0; d < relevants.length; d++) {
					for (var k = 0; k < relevantBasket.length; k++) {
						if ($(relevants[d]).parent().children('a').attr('href') === relevantBasket[k].link && $(relevants[d]).parent().parent().attr('language') === relevantBasket[k].language) {
							$(relevants[d]).addClass("unFavButton");
							$(relevants[d]).removeClass("favButton");
							$(relevants[d]).css("color", "red");
							$(relevants[d]).text("Not Relevant");
							break;
						}
					}
				}
			}

			function singleSearchOnNextPrevious(text, number_of_results, language, number, direction, source)
			{
				if(number==1)
				{
					pagination1 = pagination1 + direction;
					pagination = pagination1;
				}
				else if(number==2)
				{
					pagination2 = pagination2 + direction;
					pagination = pagination2;
				}
				else if(number==3)
				{
					pagination3 = pagination3 + direction;
					pagination = pagination3;
				}
				else if(number==4)
				{
					pagination4 = pagination4 + direction;
					pagination = pagination4;
				}

				offset=(pagination-1)*number_of_results;

				$(".next", $("#translatedQuery"+number)).hide();
				$(".previous", $("#translatedQuery"+number)).hide();
				$("#translatedResultsValues"+number).html('');
				$("#translatedResultsValues"+number).html('<img src=\'images/ajax-loader.gif\'/>');

				text = reverse_htmlspecialchars(text);

				$.post("search.php", { searchText: text, market: language, results: number_of_results, offset: offset, source: source}).done(
					function( data ) {
					$("#translatedResultsValues"+number).html(data);
					$(".next", $("#translatedQuery"+number)).show();
					if(pagination>1)
					{
						text = htmlspecialchars(text);

						$(".previous a", $("#translatedQuery"+number)).replaceWith("<a href=''>&lt; <?php echo $localised['Previous']?></a>");
						previousString = "javascript:singleSearchOnNextPrevious(\""+text+"\","+number_of_results+",\""+language+"\","+number+","+(-1)+",'"+source+"')";
						$(".previous a", $("#translatedQuery"+number)).attr('href', previousString);

						$(".previous", $("#translatedQuery"+number)).show();
					}
          setRelevants();
				}
			);
			}

			function singleSearchOnEditedTranslation(text, number_of_results, language, number, source)
			{
				if(number==1)
				{
					pagination1 = 1;
				}
				else if(number==2)
				{
					pagination2 = 1;
				}
				else if(number==3)
				{
					pagination3 = 1;
				}
				else if(number==4)
				{
					pagination4 = 1;
				}

				$(".next", $("#translatedQuery"+number)).hide();
				$(".previous", $("#translatedQuery"+number)).hide();
				$(".next", $("#translatedQuery"+number)).children('a').attr("href", "javascript:singleSearchOnNextPrevious(\""+htmlspecialchars(text)+"\","+number_of_results+",\""+language+"\","+number+","+1+",'"+source+"')");
				$("#translatedResultsValues"+number).html('');
				$("#translatedResultsValues"+number).html('<img src=\'images/ajax-loader.gif\'/>');

				$.post( "search.php", { searchText: text, market: language, results: number_of_results, offset: 0, source: source} ).done(function( data ) {
					$("#translatedResultsValues"+number).html(data);
					$(".next", $("#translatedQuery"+number)).show();
				});
			}

			function translateAndSearch(text, number_of_results1, number_of_results2, number_of_results3, number_of_results4, language1, language2, language3, language4, source)
			{
				var boxnumber = 0;
				var finishedLoading = 0;
				if(text!='')
				{
						var total_languages = 0;
						if (language2 === '') {
							total_languages = 1;
						} else if (language3 === '') {
							total_languages = 2;
						} else if (language4 === '') {
							total_languages = 3;
						} else {
							total_languages = 4;
						}

						if(language1!='')
						{
							boxnumber++;
							addBoxOrientation(boxnumber, 'translatedQuery1');

							$('#translatedQuery1').show();
							$("#translatedQueryValue1").html('<img src=\'images/ajax-loader.gif\'/>');
							$("#translatedResultsValues1").html('<img src=\'images/ajax-loader.gif\'/>');

							$.post( "translate.php", { text: text, to: language1} ).done(function( data ) {
								console.log(data);
								translatedQuery1 = data;

								$("#translatedQueryValue1").html("<span class='queryText'>" + translatedQuery1  + "</span> <span class='edit <?php echo $extras_visibility?>'><?php if($localised['Edit']){echo $localised['Edit'];} else {echo "Edit";} ?></span><div class='editPanel'></div>");

								translatedQuery1 = $('<span>').html(translatedQuery1).text();
								$.post( "search.php", { searchText: translatedQuery1, market: language1, results: number_of_results1, offset: 0, source: source} ).done(function( data ) {

									finishedLoading += 1;

									$("#translatedResultsValues1").html(data);

									translatedQuery1 = htmlspecialchars(translatedQuery1);

									$(".next a", $("#translatedQuery1")).replaceWith("<a href=''><?php echo $localised['Next']?> &gt;</a>");
									nextString = "javascript:singleSearchOnNextPrevious(\""+translatedQuery1+"\","+number_of_results1+",\""+language1+"\","+1+","+1+",'"+source+"')";
									$(".next a", $("#translatedQuery1")).attr('href', nextString);

									console.log("total_languages: " + total_languages + "finishedLoading: " + finishedLoading);
									setRelevants();
									// if (total_languages === finishedLoading) {
									// 	setRelevants();
									// }
								});
					 		});

						}

						if(language2!='')
						{
							boxnumber++;
							addBoxOrientation(boxnumber, 'translatedQuery2');

							$('#translatedQuery2').show();
							$("#translatedQueryValue2").html('<img src=\'images/ajax-loader.gif\'/>');
							$("#translatedResultsValues2").html('<img src=\'images/ajax-loader.gif\'/>');

							$.post( "translate.php", { text: text, to: language2} ).done(
								function( data ) {
								translatedQuery2 = data;

								$("#translatedQueryValue2").html("<span class='queryText'>" + translatedQuery2  + "</span> <span class='edit <?php echo $extras_visibility?>'><?php if($localised['Edit']){echo $localised['Edit'];} else {echo "Edit";} ?></span><div class='editPanel'></div>");
								translatedQuery2 = $('<span>').html(translatedQuery2).text();

								$.post( "search.php", { searchText: translatedQuery2, market: language2, results: number_of_results2, offset: 0, source: source} ).done(function( data ) {
									finishedLoading += 1;

									$("#translatedResultsValues2").html(data);

									translatedQuery2 = htmlspecialchars(translatedQuery2);

									$(".next", $("#translatedQuery2")).append("<a href=''><?php echo $localised['Next']?> &gt;</a>");
									nextString = "javascript:singleSearchOnNextPrevious(\""+translatedQuery2+"\","+number_of_results2+",\""+language2+"\","+2+","+1+",'"+source+"')";
									$(".next a", $("#translatedQuery2")).attr('href', nextString);

									console.log("total_languages: " + total_languages + "finishedLoading: " + finishedLoading);
									// if (total_languages === finishedLoading) {
									// 	setRelevants();
									// }
										setRelevants();
								});
						 	}
						);
						}

						if(language3!='')
						{
							boxnumber++;
							addBoxOrientation(boxnumber, 'translatedQuery3');

							$('#translatedQuery3').show();
							$("#translatedQueryValue3").html('<img src=\'images/ajax-loader.gif\'/>');
							$("#translatedResultsValues3").html('<img src=\'images/ajax-loader.gif\'/>');

							$.post( "translate.php", { text: text, to: language3 } ).done(function( data ) {
								translatedQuery3 = data;
								$("#translatedQueryValue3").html("<span class='queryText'>" + translatedQuery3  + "</span> <span class='edit <?php echo $extras_visibility?>'><?php if($localised['Edit']){echo $localised['Edit'];} else {echo "Edit";} ?></span><div class='editPanel'></div>");
								translatedQuery3 = $('<span>').html(translatedQuery3).text();
								$.post( "search.php", { searchText: translatedQuery3, market: language3, results: number_of_results3, offset: 0, source: source} ).done(function( data ) {

									finishedLoading += 1;

									$("#translatedResultsValues3").html(data);

									translatedQuery3 = htmlspecialchars(translatedQuery3);

									$(".next", $("#translatedQuery3")).append("<a href=''><?php echo $localised['Next']?> &gt;</a>");
									nextString = "javascript:singleSearchOnNextPrevious(\""+translatedQuery3+"\","+number_of_results3+",\""+language3+"\","+3+","+1+",'"+source+"')";
									$(".next a", $("#translatedQuery3")).attr('href', nextString);

									console.log("total_languages: " + total_languages + "finishedLoading: " + finishedLoading);
									setRelevants();
									// if (total_languages === finishedLoading) {
									// 	setRelevants();
									// }
								});
						 	});
						}

						if(language4!='')
						{
							boxnumber++;
							addBoxOrientation(boxnumber, 'translatedQuery4');

							$('#translatedQuery4').show();
							$("#translatedQueryValue4").html('<img src=\'images/ajax-loader.gif\'/>');
							$("#translatedResultsValues4").html('<img src=\'images/ajax-loader.gif\'/>');

							$.post( "translate.php", { text: text, to: language4 } ).done(function( data ) {
								translatedQuery4 = data;
								$("#translatedQueryValue4").html("<span class='queryText'>" + translatedQuery4  + "</span> <span class='edit <?php echo $extras_visibility?>'><?php if($localised['Edit']){echo $localised['Edit'];} else {echo "Edit";} ?></span><div class='editPanel'></div>");
								translatedQuery4 = $('<span>').html(translatedQuery4).text();

								$.post( "search.php", { searchText: translatedQuery4, market: language4, results: number_of_results4, offset: 0, source: source} ).done(function( data ) {
									finishedLoading += 1;

									$("#translatedResultsValues4").html(data);

									translatedQuery4 = htmlspecialchars(translatedQuery4);

									$(".next", $("#translatedQuery4")).append("<a href=''><?php echo $localised['Next']?> &gt;</a>");
									nextString = "javascript:singleSearchOnNextPrevious(\""+translatedQuery4+"\","+number_of_results4+",\""+language4+"\","+4+","+1+",'"+source+"')";
									$(".next a", $("#translatedQuery4")).attr('href', nextString);

									console.log("total_languages: " + total_languages + "finishedLoading: " + finishedLoading);
									setRelevants();
									// if (total_languages === finishedLoading) {
									// 	setRelevants();
									// }
								});
						 	});
						}
				}
			}

			function addBoxOrientation(boxnumber, boxname)
			{
				if(boxnumber%2 != 0)
				{
					$('#'+boxname).addClass('leftbox');
				}
				else
				{
					$('#'+boxname).addClass('rightbox');
				}
			}

			$( document ).ready(function() {

				// get relevant basket
				var json_string = getCookie("basket");
				if (json_string === "") {
					relevantBasket = [];
				} else {
					relevantBasket = JSON.parse(json_string);
				}

				//recommender fix
				$(".recommender.checked").insertBefore("#translatedQuery1");
				//end recommender fix
				translateAndSearch(
					'<?php echo htmlspecialchars($text, ENT_QUOTES); ?>',
					'<?php echo $number_of_results1 ?>',
					'<?php echo $number_of_results2 ?>',
					'<?php echo $number_of_results3 ?>',
					'<?php echo $number_of_results4 ?>',
					'<?php echo $selected_language1 ?>',
					'<?php echo $selected_language2 ?>',
					'<?php echo $selected_language3 ?>',
					'<?php echo $selected_language4 ?>',
					'<?php echo $source ?>');
				$("*[type='radio']").change(function () {
					$( "#submitbutton" ).trigger( "click" );
				});

				$("*[type='checkbox']").change(function () {
					$( "#submitbutton" ).trigger( "click" );
				});

				pagination1 = 1;
				pagination2 = 1;
				pagination3 = 1;
				pagination4 = 1;

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

				request.done(function( msg ) {});

			});

			//EDIT LOGGING
			$(document).on('click', '.editSubmit', function()
			{

				editedQuery = $(this).siblings().val() ;
				language = $(this).attr('language');


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

			$(document).on("click", ".edit", function(event){

				language = $(this).parent().attr('language');
				boxnumber = $(this).parent().attr('languagenumber');

				$(this).parent().children(".editPanel").html("<input id='input"+boxnumber+"' type='text' size='40'/><input id='submit"+boxnumber+"' type='submit' class='editSubmit' language='"+language+"' value='<?php echo $localised['Submit'] ?>'/><div class='hidden translationAlternatives translationAlternatives"+boxnumber+"'></div>");
				$(this).parent().children(".editPanel").children('#input'+boxnumber).val($(this).parent().children(".queryText").html());
				$(this).parent().children(".editPanel").slideToggle('slow');

				// Get original query
				text = $("#searchText").attr("value");

				$.post( "getTranslations.php", { text: text, to: language.substr(0,2)} ).done(function( data ) {
					$(".translationAlternatives"+boxnumber).html("<div class='AlternativeTitle'><?php echo $localised['Alternatives'] ?>: </div>" + data);
					$(".translationAlternatives"+boxnumber).slideDown('slow');
				});
				//////

				$( "#submit"+ boxnumber + "").click(function(boxnumber, language) {
					language = $(this).parent().parent().attr('language');
					boxnumber = $(this).parent().parent().attr('languagenumber');

					text = $("#input"+boxnumber).val();
					$(this).parent().parent().children(".editPanel").hide();
					$(this).parent().parent().children(".queryText").html(text);
					singleSearchOnEditedTranslation(text, '<?php echo $number_of_results ?>', language, boxnumber, '<?php echo $source ?>')
				});
			});

			// Favorite basket
			$(document).on('click', '.favButton', function()
			{
				link = $(this).parent().children('a').attr('href');
				language = $(this).parent().parent().attr('language');

				title = $(this).text();
				snippet= $(this).parent().parent().children('.snippet').text();
				rank= $(this).parent().parent().attr('rank');

				relevantBasket.push({ type: 'favorite', link: link, language: language, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface, queryid: "<?php echo $_SESSION['current_query'];?>"});

				$(this).addClass("unFavButton");
				$(this).removeClass("favButton");
				$(this).css("color", "red");
				$(this).text("Not Relevant");


			});

			$(document).on('click', '.unFavButton', function()
			{
				link = $(this).parent().children('a').attr('href');
				language = $(this).parent().parent().attr('language');

				title = $(this).text();
				snippet= $(this).parent().parent().children('.snippet').text();
				rank= $(this).parent().parent().attr('rank');

				// fix this so it removes the right one
				relevantBasket.splice(relevantBasket.indexOf({ type: 'favorite', link: link, language: language, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface, queryid: "<?php echo $_SESSION['current_query'];?>"}), 1);

				$(this).addClass("favButton");
				$(this).removeClass("unFavButton");
				$(this).css("color", "#FBC02D");
				$(this).text("Relevant");
			});

			//LINK CLICK LOGGING
			$(document).on('click contextmenu', 'a', function()
			{
				var json_strings = JSON.stringify(relevantBasket);
				setCookie("basket", "", 365);
				setCookie("basket", json_strings, 365);

				link = $(this).attr('href');
				language = $(this).parent().parent().attr('language');

				if(language != undefined)
				{
					title = $(this).text();
					snippet= $(this).parent().parent().children('.snippet').text();
					rank= $(this).parent().parent().attr('rank');
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

      //task performance,
			$(document).on('click', '#finish', function()
			{
				for (var i = 0; i < relevantBasket.length; i++) {
					var request = $.ajax({
					  type: 'GET',
					  url: 'Log.php',
					  data: { type: relevantBasket[i].type, link: relevantBasket[i].link, language: relevantBasket[i].language, title: relevantBasket[i].title, snippet: relevantBasket[i].snippet, rank: relevantBasket[i].rank, currentinterface: relevantBasket[i].currentinterface, queryid: relevantBasket[i].queryid},
					  dataType: "html",
					  async:false
					});
					request.done(function( msg ) {
					});
				}
				setCookie("basket", "", 365);
				window.location.href = "studyManager.php";
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
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<body>
		<div class='container'>
			<div class='headerContainer<?php echo $option_display?>'oncopy="return false" oncut="return false" onpaste="return false">
				<?php
				$taskid = intval($_REQUEST['taskid']);
				//&& $_SESSION['taskid'] == 0
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
						echo "<br/>";
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
				<td width="150">
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
					<br/><br/>


					<div id='options' class='<?php echo $option_display;?>'>
				<?php

				$language1_holder = $_SESSION['language_codes'][$language1];
				if($language1 != "" && !$_SESSION['injected'])
						{
							echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name1,ENT_QUOTES) . '" id="language1" value="' . $language1 . '" class="css-' . $option_type . '"' . $checked1 .'>
			<label for="language1" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language1] . '</label>';
						} else if ($_SESSION['interface'] == 'panel'){
							//$_SESSION['language1'] = "en-US";
// 							echo "<h2>" . htmlspecialchars($name1,ENT_QUOTES) . "</h2>";
// 							echo "<h2>" . htmlspecialchars($name2,ENT_QUOTES) . "</h2>";
							$_SESSION['injected'] = true;
							echo '<input type="checkbox" name="language" id="language1" value="'.$_SESSION['language1'].'" class="css-checkbox" <?php echo $checked1; ?>  > 
									<label for="language1" class="css-checkbox-label">'. $_SESSION['language1'].'</label>';
						} else if($_SESSION['interface'] == 'tabbed'){
							//$_SESSION['language1'] = "en-US";
							$_SESSION['injected'] = true;
							echo '<input type="radio" name="language" id="language1" value="'.$_SESSION['language1'].'" class="css-radio" checked="">';
							echo '<label for="language1" class="css-radio-label">'. $_SESSION['language1'].'</label>';
						}
				if($language2 != "" && !$_SESSION['injected'])
						{
							echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name2,ENT_QUOTES) . '" id="language2" value="' . $language2 . '" class="css-' . $option_type . '"' . $checked2 .'>
					<label for="language2" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language2] . '</label>';
						} else if ($_SESSION['interface'] == 'panel'){
							//$_SESSION['language2'] = "zh-CN";
							$_SESSION['injected'] = true;
							echo '<input type="checkbox" name="language" id="language2" value="'.$_SESSION['language2'].'" class="css-checkbox" <?php echo $checked2; ?>> 
									<label for="language2" class="css-checkbox-label">'. $_SESSION['language2'] .'</label>';
						} else if($_SESSION['interface'] == 'tabbed'){
							//$_SESSION['language2'] = "zh-CN";
							$_SESSION['injected'] = true;
							echo '<input type="radio" name="language" id="language2" value="'.$_SESSION['language2'].'" class="css-radio" >';
							echo '<label for="language2" class="css-radio-label">'.$_SESSION['language2'].'</label>';
						}
				if($language3 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name3,ENT_QUOTES) . '" id="language3" value="' . $language3 . '" class="css-' . $option_type . '"' . $checked3 .'>
				<label for="language3" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language3] . '</label>';
				}
				if($language4 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name4,ENT_QUOTES) . '" id="language4" value="' . $language4 . '" class="css-' . $option_type . '"' . $checked4 .'>
			<label for="language4" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language4] . '</label>';
				}


				?>
					</div>
					</div>
				</form>
			</div>

			<div class='resultContainer<?php echo $option_display?>'>
				<?php

				for($i=1;$i<5;$i++)
				{
					echo "<div id='translatedQuery" . $i . "' class='hidden box" . $number_of_boxes . " " . $display_style  . " " . ${"checked" . $i} ." " . ${"direction" . $i} . "'>" .
						"<div class='header'>" .
							"<div id='translatedQueryValue" . $i . "'  languagenumber='" . $i . "' language='" . ${'language'.$i} . "' class='query'></div>" .
						"</div>" .
						"<br/><br/>" .
						"<div id='translatedResultsValues" . $i . "'></div>" .
						"<div class='pagination'>" .
							"<div class='previous left'><a href=''></a></div>" .
							"<div class='next right'><a href=''></a></div>" .
						"</div>" .
					"</div>";

				}

				?>
			</div>
		</div>
	</body>
</html>
