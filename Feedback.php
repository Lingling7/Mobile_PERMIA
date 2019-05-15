<?php
		
			session_start();
			
			if(!$_SESSION['username'])
			{
				header("Location: Login.php");
				die();
			}
			
			header('Content-Type: text/html; charset=utf-8');
					
		?>
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
		
		<html>
			<head>
				<link rel="stylesheet" type="text/css" href="style.css">
				<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
				<script src="Javascript/jquery.validate.min.js" type="text/javascript"></script>
				<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
				<script src="lightbox/lightbox.min.js"></script>
				<link href="lightbox/lightbox.css" rel="stylesheet" />
				<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
				
				<script type='text/javascript'>
						$(document).ready(function() {

						    $('.toggler').change(function()
							{
								var checked = this.checked;
								toggled_name = $(this).attr("id");
								
								if(checked)
								{
									$('#questions'+toggled_name).show();
								}
								else
								{
									$('#questions'+toggled_name).hide();
								}
									
						    });
						});	
				</script>
				<title>
					PerMIA
				</title>
			</head>
			<body>
				
				<?php
					include 'top.php';
				?>
		
		<div class='container'>
			<div class='headerContainer'>
				<div class='mainContainer'>
					
				
				<form class='questionnaire' action="SaveQuestionnaire.php" method="get">
				
					<div class='instruction'>PerMIA interface questions:</div> <br />
									
					Which PerMIA interfaces did you use?<br/><br/>
					
					<div id='images'>
						<div class='image'>
							<a href="images/Tabbed.png" data-lightbox="image1" data-title="Tabbed">
								<img src='images/Tabbed.png' width='100px'/>
							</a>
						</div>
						<div class='image'>
							<a href="images/Recommender.png" data-lightbox="image2" data-title="Side-bar">
								<img src='images/Recommender.png' width='100px' />
							</a>
						</div>
						<div class='image'>
							<a href="images/Non-blended-panel.png" data-lightbox="image3" data-title="Panel">
								<img src='images/Non-blended-panel.png' width='100px' />
							</a>
						</div>
						<div class='image'>
							<a href="images/Interleaved.png" data-lightbox="image4" data-title="Interleaved">
								<img src='images/Interleaved.png' width='100px' />
							</a>
						</div>
						<div class='image'>
							<a href="images/Non-blended-vertical.png" data-lightbox="image5" data-title="Universal Search">
								<img src='images/Non-blended-vertical.png' width='100px' />
							</a>
						</div>
					</div>
					
					
					<div id="options" class='interfacefeedback'>
						<div class='interfacefeedbackoption'>					
							<input type="checkbox" name="q101" id="tabbed" value="yes" class="css-checkbox toggler">
							<label for="tabbed" class="css-checkbox-label">Tabbed</label>
						</div>
						<div class='interfacefeedbackoption'>
							<input type="checkbox" name="q102" id="recommender" value="yes" class="css-checkbox toggler">
							<label for="recommender" class="css-checkbox-label">Side-bar</label>
						</div>
						<div class='interfacefeedbackoption'>
							<input type="checkbox" name="q103" id="panels" value="yes" class="css-checkbox toggler">
							<label for="panels" class="css-checkbox-label">Panels</label>
						</div>
						<div class='interfacefeedbackoption'>
							<input type="checkbox" name="q104" id="interleaved" value="yes" class="css-checkbox toggler">
							<label for="interleaved" class="css-checkbox-label">Interleaved</label>
						</div>
						<div class='interfacefeedbackoption'>
							<input type="checkbox" name="q105" id="vertical" value="yes" class="css-checkbox toggler">
							<label for="vertical" class="css-checkbox-label">Universal Search</label>
						</div>
					</div><br/>
					
					
					
					<br/><br/>Which interface was your favourite?<br/><br/>
					<div id="options">					
						<input type="radio" name="q106" id="tabbed2" value="tabbed" class="css-radio2">
						<label for="tabbed2" class="css-radio2-label">Tabbed</label>
						<input type="radio" name="q106" id="recommender2" value="recommender" class="css-radio2">
						<label for="recommender2" class="css-radio2-label">Side-bar</label>
						<input type="radio" name="q106" id="panels2" value="panels" class="css-radio2">
						<label for="panels2" class="css-radio2-label">Panels</label>
						<input type="radio" name="q106" id="interleaved2" value="interleaved" class="css-radio2">
						<label for="interleaved2" class="css-radio2-label">Interleaved</label>
						<input type="radio" name="q106" id="vertical2" value="vertical" class="css-radio2">
						<label for="vertical2" class="css-radio2-label">Universal Search</label>
					</div><br/>
					
					<br/><br/>Which one did you like the least?<br/><br/>
					<div id="options">					
						<input type="radio" name="q107" id="tabbed3" value="tabbed" class="css-radio2">
						<label for="tabbed3" class="css-radio2-label">Tabbed</label>
						<input type="radio" name="q107" id="recommender3" value="recommender" class="css-radio2">
						<label for="recommender3" class="css-radio2-label">Side-bar</label>
						<input type="radio" name="q107" id="panels3" value="panels" class="css-radio2">
						<label for="panels3" class="css-radio2-label">Panels</label>
						<input type="radio" name="q107" id="interleaved3" value="interleaved" class="css-radio2">
						<label for="interleaved3" class="css-radio2-label">Interleaved</label>
						<input type="radio" name="q107" id="vertical3" value="vertical" class="css-radio2">
						<label for="vertical3" class="css-radio2-label">Universal Search</label>
					</div><br/><br/><br/>
					
					What are the reasons for choosing your favourite and least favourite?<br/>
					<textarea cols="60" rows="10" id="q108" name="q108"></textarea> <br />
					
					
					
					<div id='questionstabbed' class='hidden'>
						<br /><br />
						What did you like or dislike regarding the tabbed interface?<br/>
						<textarea cols="60" rows="10" id="q5" name="q5"></textarea> <br />
					</div>
	
					
					<div id='questionsrecommender' class='hidden'>
						<br /><br />
						What did you like or dislike regarding the side-bar interface?<br/>
						<textarea cols="60" rows="10" id="q6" name="q6"></textarea> <br />
					</div>
					
					<div id='questionspanels' class='hidden'>
						<br /><br />
						What did you like or dislike regarding the panels interface?<br/>
						<textarea cols="60" rows="10" id="q7" name="q7"></textarea> <br />
					</div>
					
					<div id='questionsinterleaved' class='hidden'>
						<br /><br />
						What did you like or dislike regarding the interleaved interface?<br/>
						<textarea cols="60" rows="10" id="q8" name="q8"></textarea> <br />
					</div>
					
					<div id='questionsvertical' class='hidden'>
						<br /><br />
						What did you like or dislike regarding the universal search interface?<br/>
						<textarea cols="60" rows="10" id="q9" name="q9"></textarea> <br />
					</div>

					<br /><br /><br />

					<div class='instruction'>General multilingual interface questions: </div><br />
					
					I feel overwhelmed when different languages are shown on the same screen.<br/><br/>
					<div id="options">				
						agree<input type="radio" name="q1" id="q1a" value="1" class="css-radio2">
						<label for="q1a" class="css-radio2-label"></label>
						<input type="radio" name="q1" id="q1b" value="2" class="css-radio2">
						<label for="q1b" class="css-radio2-label"></label>
						<input type="radio" name="q1" id="q1c" value="3" class="css-radio2">
						<label for="q1c" class="css-radio2-label"></label>
						<input type="radio" name="q1" id="q1d" value="4" class="css-radio2">
						<label for="q1d" class="css-radio2-label"></label>
						<input type="radio" name="q1" id="q1e" value="5" class="css-radio2">
						<label for="q1e" class="css-radio2-label"></label>disagree
					</div> <br /> <br /><br />
					I like it when the content is presented in the language it was originally created.<br/><br/>
					<div id="options">					
						agree<input type="radio" name="q2" id="q2a" value="1" class="css-radio2">
						<label for="q2a" class="css-radio2-label"></label>
						<input type="radio" name="q2" id="q2b" value="2" class="css-radio2">
						<label for="q2b" class="css-radio2-label"></label>
						<input type="radio" name="q2" id="q2c" value="3" class="css-radio2">
						<label for="q2c" class="css-radio2-label"></label>
						<input type="radio" name="q2" id="q2d" value="4" class="css-radio2">
						<label for="q2d" class="css-radio2-label"></label>
						<input type="radio" name="q2" id="q2e" value="5" class="css-radio2">
						<label for="q2e" class="css-radio2-label"></label>disagree
					</div> <br /> <br /><br />
					I would prefer to have all content presented in a single language.<br/><br/>
					<div id="options">					
						agree<input type="radio" name="q3" id="q3a" value="1" class="css-radio2">
						<label for="q3a" class="css-radio2-label"></label>
						<input type="radio" name="q3" id="q3b" value="2" class="css-radio2">
						<label for="q3b" class="css-radio2-label"></label>
						<input type="radio" name="q3" id="q3c" value="3" class="css-radio2">
						<label for="q3c" class="css-radio2-label"></label>
						<input type="radio" name="q3" id="q3d" value="4" class="css-radio2">
						<label for="q3d" class="css-radio2-label"></label>
						<input type="radio" name="q3" id="q3e" value="5" class="css-radio2">
						<label for="q3e" class="css-radio2-label"></label>disagree
					</div> <br /> <br /><br />
					Any other general comments?<br/>
					<textarea cols="60" rows="10" id="q4" name="q4"></textarea> <br />

					
					<br /><br /><br />
					<input type="submit" value="Send Feedback!"><br /><br /><br /><br />
				</form>
				</div>
			</div>			
		</div>
	</body>
</html>
