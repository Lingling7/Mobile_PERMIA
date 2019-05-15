<?php
	include "config.php";
	include 'localise.php';
	session_start();
	if(!$_SESSION['userId'])
	{
		echo "Please set userId first";
		die();
	}
	$message ='';
	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_select_db($_DATABASE);

	if (isset($_REQUEST["submitted"])) {

		$userId = $_SESSION['userId'];
		$questionId = 1;
		$response = "Agree";
		$taskid = 14;
		//$question = $row['question_text'];
		//echo $i . " " . $question . " ". $response . "; ";
		$system = $_SESSION['recent_interface'];

		$query = "INSERT INTO `P4MobileMnewsAnswersEx` (`id`, `UserId`, `QuestionId`, `Response`, `TaskID`, `System`) VALUES (NULL, '$userId', '$questionId', '$response', '$taskid', '$system')";
		if (!mysql_query($query)) {
			$message = mysql_error();
			mysql_close($con);
		}
		if($message=='') {
			mysql_close($con);
			header("Location: studyManager.php");
			die();
		}
	}
?>

<!DOCTYPE html>
<html lang="en-US">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<head>
	<title>Consent Form</title>
	<style>
		input[type=submit] {
		padding:5px 15px;
		background:#00cc00;
		border:0 none transparent;
		cursor:pointer;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		font-size: 30px;
		color: #fff;
		-webkit-user-select: none;
		height: 40px;
	    }
	</style>
</head>

<body style="width:80%;margin-left:auto;margin-right:auto">
	<div id="title" style="text-align:center;">
		<h2>Consent Form</h2>
	</div>
	<div id="content">
		<p>Dear Participant:</p>
		<p>The Mobile Computing for Social Benefit Lab, led by Dr. Silvia Figueira in the Department of Computer Engineering at Santa Clara University, is conducting a research study with one Ph.D. student Chenjun Ling to investigate users’ experience and preferences in multilingual news mobile and desktop web search.</p>
		<p>We are requesting your participation, which will involve approximately 60 minutes of your time, during which you will be asked to complete 2-step user study, each step has 12 news search tasks using novel multilingual news search interfaces. In each step, you will first be asked to complete a short demographic questionnaire, including questions regarding your proficiency in multiple different languages. Following a round of standard pretests, you will be presented with several different interfaces, and you will be asked to conduct simple mobile search tasks with different interfaces and mark your favorite search results for each task.</p>
		<p>During the study, we will be recording your eye gaze behavior using an eye tracker, physiological signals using a wearable wristband, and facial expressions using a camera. All information (including questionnaires, task answers, and sensor information) will be stored on a password-protected mobile phone and a password-protected desktop in a locked room.  All information collected will be completely anonymized, i.e. your name will not be associated with any of the information that we collect as part of the study. In addition, the recorded facial expression video will be immediately converted to facial action codes (fully anonymous) after you have completed the study, and the video will then be erased.</P>
		<p>Your participation in this study is entirely voluntary.  If you choose not to participate, or to withdraw from the study at any time, there will be no penalty.  It will not affect your grades (if applicable) in any way.  The results of the research study may be published, but again, no personal data will ever be revealed in any of the publications.</P>
		<p>Possible benefits of your participation are the exposure to novel multilingual news mobile and desktop search research prototypes, and the exposure and engagement in academic research. In addition, you will receive a 15-dollar gift card as a reward. If you have any questions concerning the research study, or would like to hear more about the results, you can contact us at cling@scu.edu or sfigueira@scu.edu or via telephone at (408) 554-4105.</P>
		<p>If you have any questions about your rights as a subject/participant in this research, or if you feel you have been placed at risk, you can contact the Chair of the Human Subjects Committee, through Office of Research Compliance and Integrity at (408) 554-5591.</p>
		
		<p>Sincerely,</p>
		<p>Dr. Silvia Figueira</p>

		<form>
		<input type="checkbox" name="agree" value="agree" required>I have read and understood the above consent form. I certify that I am 18 years of age or older and, by checking the below checkbox and clicking the submit button to enter the study, I indicate my willingness to voluntarily take part in the study.<br><br>
		<!-- <input type="submit" value="Submit"><br> -->
		<input type="hidden" name="submitted" value="true">
		<input type="submit"  value="Submit" action="">
		</form>
	
	</div>
</body>
