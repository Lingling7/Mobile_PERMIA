<?php
	session_start();

	header('Content-Type: text/html; charset=utf-8');

	if($_REQUEST["text"]!='')
	{
	        $accountKey = '2Lmd9VneTkyPpUqPyZeDiSBdRRSDDfvZikK9l+J81W0';
	        $ServiceRootURL =  "https://api.datamarket.azure.com/Bing/Synonyms/";
 
	        $WebSearchURL = $ServiceRootURL;

	        $context = stream_context_create(array(
	            'https' => array(
	                'request_fulluri' => true,
	                'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
	            )
	        ));

			$request = $WebSearchURL . 'GetSynonyms&Query=' . urlencode('\'' . $_REQUEST["text"] . '\'');

	        $response = file_get_contents($request, 0, $context);
        
	        $jsonobj = json_decode($response);
        
        	echo $jsonobj;
	}
?>