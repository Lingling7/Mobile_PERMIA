
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">

		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

		<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
		<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
	</head>
	<body>


<!-- FANCYBOX CONFIGURATION AND X-FRAME CHECK -->
	<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox.<?php $randomNumber = mt_rand(); echo $randomNumber;?>").fancybox({
				overlay: {
					locked : false
				},
				iframe: {
					preload : false
				},
				width: 1000,
				height: 1000,
				beforeShow: function(){
        		//Check for X-Frames
					iframe = document.getElementsByTagName('iframe')[0];
					url = iframe.src;
				
					iframe.setAttribute("sandbox", "allow-forms allow-pointer-lock allow-same-origin allow-scripts");
				
					$.ajax({url: "check-x-frame.php", data: {url: url }, success: function(result){
				
					//If X-Frames restriction, route through YQL
						if(result.trim()=="true"){
					
							iframe.src = "about:blank";
			
							getData = function (data) {
								if (data && data.query && data.query.results && data.query.results.resources && data.query.results.resources.content && data.query.results.resources.status == 200) loadHTML(data.query.results.resources.content);
								else if (data && data.error && data.error.description) loadHTML(data.error.description);
								else loadHTML('Error: Cannot load ' + url);
							};

							loadURL = function (src) {
								url = src;
								var script = document.createElement('script');
								script.src = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20data.headers%20where%20url%3D%22' + encodeURIComponent(url) + '%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=getData';
								document.body.appendChild(script);
							};

							loadHTML = function (html) {
								iframe.src = 'about:blank';
								iframe.contentWindow.document.open();				
								iframe.contentWindow.document.write(html.replace(/<head>/i, '<head><base href="' + url + '"><scr' + 'ipt>document.addEventListener("click", function(e) { if(e.target && e.target.nodeName == "A") { e.preventDefault(); parent.loadURL(e.target.href); } });</scr' + 'ipt>'));
								iframe.contentWindow.document.close();
							}

							loadURL(url);
						}
					}});	
    		}
        })
    });
	</script>
	
	
		<?php
			if(!isset($_SESSION))
		    {
		        session_start();
		    }

			header('Content-Type: text/html; charset=utf-8');

			include 'date.php';

			if($_SESSION['experiment'])
			{
				$target = "_blank";
			}
			else
			{
				$target = "_blank";
			}

			if($_REQUEST["searchText"]!='')
			{
					
			        $accountKey = '906deedb70af4679a1314dfceb49af82';

			        if ($_REQUEST["source"] == "News") 
					{
						$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v7.0/news/search";
			    	}
			    	else
			    	{
// 			        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v7.0/search";
			    		$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v7.0/news/search";
			    	}
			        $WebSearchURL = $ServiceRootURL;

			        $context = stream_context_create(array(
			            'http' => array(
			                'request_fulluri' => true,
			                'header' => "Ocp-Apim-Subscription-Key: " . $accountKey
			            ),
			            'ssl' => array(
		 					'verify_peer' => false,
		 					'verify_peer_name' => false,
		 				)
			        ));

			        if ($_REQUEST["source"] == "News") 
					{
						$request = $WebSearchURL . '?q=' . urlencode( $_REQUEST["searchText"] ) . '&mkt=' . urlencode( $_REQUEST["market"]  ) . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"];
					}
					else
					{
						$request = $WebSearchURL . '?q=' . urlencode( $_REQUEST["searchText"] ) . '&mkt=' . urlencode( $_REQUEST["market"]  ) . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"];
 						//$request = $WebSearchURL . '?q=' . urlencode( $_REQUEST["searchText"] ) . '&mkt=' . urlencode( $_REQUEST["market"]  ) . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"] . "&responsefilter=webpages";
							
					}

			        $response = @file_get_contents($request, 0, $context);

			        $jsonobj = json_decode($response);        
	        
	        
	        

			        echo('<div id="resultList">');
		            if ($_SESSION["interface"] == "panel" && $_SESSION[number_of_boxes] > 1) 
		            {
								$resultListItem = "panelresultlistitem";
								$title="panelTitle";
								$titleWidth = "panelTitleWidth";
								$snippet="panelSnippet";
					} 
					else 
					{
								$resultListItem = "resultlistitem";
								$title = "generalTitle";
								$titleWidth = "generalTitleWidth";
								$snippet="generalSnippet";
					}

							$i = 1;

					if ($_REQUEST["source"] == "News") 
					{
						if (is_array($jsonobj->value) || is_object($jsonobj->value))
						{
					        foreach($jsonobj->value as $value)
					        {
					        	parse_str($value->url, $output);
		    					$finalURL = $output['r'];

					            echo('<div class= " '. $resultListItem . ' " rank="rank' . $i . '" language="'. $_REQUEST["market"] .'">');
											echo('<div class= " ' . $title . ' ">');
												echo ('<a class="fancybox fancybox.iframe '  . $titleWidth . ' ' . $randomNumber . '" href="' . $finalURL . '">');
												//echo ('<a class="fancybox fancybox.iframe '  . $titleWidth . '" href="redirect.php?website=' . $value->Url . '">');
												//echo('<a href="' . $value->Url .  '" target="' . $target . '" class=" ' . $titleWidth . '">');
									            echo(strip_tags($value->name));
									            echo('</a>');

												echo('<a href="javascript:;" style="color:#FBC02D; font-size:90%; float:right;" class="favButton">Relevant</a>');

											echo('</div>');

												echo('<div class=\'url\'>' . urldecode($value->provider[0]->name));
												$news_date = urldecode($value->datePublished);
												$news_date = Date_Difference::getStringResolved($news_date, $_REQUEST["market"]);
												echo(' - ' . $news_date  . '</div>');

										echo('<div class=" '. $snippet .' ">' . strip_tags($value->description) . '</div>');
										echo('</div>');
										$i++;
					        }
					    }
					}
					else
					{  // new version 04202019 news
						if (is_array($jsonobj->value) || is_object($jsonobj->value))
						{	
							// echo "<br>";
							//sleep(2);
							if(($_SESSION['interface']) == 'non-blended-vertical')
							{	
								if ($_REQUEST["market"]=='en-US') {
									echo '<button class="collapsibleexpand active">'.'English'.'</button>';
									echo '<div class="content">';
								}elseif ($_REQUEST["market"]=='zh-CN') {
									echo '<button class="collapsibleexpand">'.'中文'.'</button>';
									echo '<div class="content">';
								}elseif ($_REQUEST["market"]=='zh-HK') {
									echo '<button class="collapsibleexpand">'.'粵語'.'</button>';
									echo '<div class="content">';
								}elseif ($_REQUEST["market"]=='es-ES') {
									echo '<button class="collapsibleexpand">'.'Español'.'</button>';
									echo '<div class="content">';
								}
								// echo "<br>";
								// echo '<button class="collapsibleexpand">'.$_REQUEST["market"].'</button>';
								// echo '<div class="content">';
							}

						
							echo "<table style= 'width: 100%; border: 1px solid black; border-collapse: collapse; border-spacing: 1em; background-color: #FFFFFF'>";
							foreach($jsonobj->value as $value)
							{
								$finalURL = strip_tags($value->url);//title url
								echo"<tr style= 'border-bottom: 1px solid black; margin-top: 0;' >";

									echo"<td>";
									echo '<img src="'.strip_tags($value->image->thumbnail->contentUrl).'" height="100" width="100">';
									echo"</td>";

									echo"<td>";
										echo('<div class= " '. $resultListItem . ' " rank="rank' . $i . '" language="'. $_REQUEST["market"] .'">');
											echo('<div class= " ' . $title . ' ">');
												echo ('<a class="fancybox fancybox.iframe '  . $titleWidth . ' ' . $randomNumber . '" href="' . $finalURL . '">');
												echo(strip_tags($value->name));
												echo('</a>');

												echo('<a href="javascript:;" style="color:#FBC02D; font-size:90%; float:right;" class="favButton">Relevant</a>');
											echo('</div>');
												echo('<div class=\'url\'>' . urldecode($value->provider[0]->name));
												$news_date = urldecode($value->datePublished);
												$news_date = Date_Difference::getStringResolved($news_date, $_REQUEST["market"]);
												echo(' - ' . $news_date  . '</div>');

												echo('<div class=" '. $snippet .' ">' . strip_tags($value->description) . '</div>');
											
										echo('</div>');
									echo"</td>";

								echo"</tr>";
								
								$i++;
							}
							echo "</table>";

							if(($_SESSION['interface']) == 'non-blended-vertical')
							{
								echo '</div>';
							}
						}
// 						if (is_array($jsonobj->webPages->value) || is_object($jsonobj->webPages->value))
// 						{
// 					        foreach($jsonobj->webPages->value as $value)
// 					        {
// 					        	parse_str($value->url, $output);
// 		    					$finalURL = $output['r'];

// 					            echo('<div class= " '. $resultListItem . ' " rank="rank' . $i . '" language="'. $_REQUEST["market"] .'">');
// 											echo('<div class= " ' . $title . ' ">');
	// 											echo ('<a class="fancybox fancybox.iframe '  . $titleWidth . ' ' . $randomNumber . '" href="' . $finalURL . '">');
	// 											//echo ('<a class="fancybox fancybox.iframe '  . $titleWidth . '" href="redirect.php?website=' . $value->Url . '">');
	// 											//echo('<a href="' . $value->Url .  '" target="' . $target . '" class=" ' . $titleWidth . '">');
	// 								            echo(strip_tags($value->name));
	// 								            echo('</a>');

// 												echo('<a href="javascript:;" style="color:#FBC02D; font-size:90%; float:right;" class="favButton">Relevant</a>');

// 											echo('</div>');

// 											echo('<div class=\'url\'>' . urldecode($value->displayUrl) . '</div>');

// 										echo('<div class=" '. $snippet .' ">' . strip_tags($value->snippet) . '</div>');
// 								echo('</div>');
// 										$i++;
// 					        }
// 					    }
					}
					
			    echo ('</div>');
			}
		?>
		<script>//collapseAll Interface
		   /* var coll = document.getElementsByClassName("collapsibleexpand");
		    var i;

		    for (i = 0; i < coll.length; i++) {
		    	
		        coll[i].addEventListener("click", function() {
		            this.classList.toggle("active");
		            var content = this.nextElementSibling;
		            if (content.style.maxHeight){
		                content.style.maxHeight = null;
		            } else {
		                content.style.maxHeight = content.scrollHeight + "px";
		            }
		        });
		        // coll[i].classList.toggle("active");
		        coll[i].nextElementSibling.style.maxHeight = "2100px";//show 6 news
		        
		    }*/var coll2 = document.getElementsByClassName("collapsibleexpand");
		    var i2;

		    for (i2 = 0; i2 < coll2.length; i2++) {
		    	
		        coll2[i2].classList.toggle("active");
		        coll2[i2].nextElementSibling.style.maxHeight = "2100px";//show 6 news
		    }
	    $(document).ready(function(){

		    $( ".collapsibleexpand" ).on('click',function() {
		    	
                    this.classList.toggle("active");
		            var content = this.nextElementSibling;
		            if (content.style.maxHeight){
		                content.style.maxHeight = null;
		            } else {
		                content.style.maxHeight = content.scrollHeight + "px";
		            }
		        coll[i].classList.toggle("active");
		        coll[i].nextElementSibling.style.maxHeight = "2100px";//show 6 news
		    });
		   
		});


		</script>
		
	</body>
</html>
