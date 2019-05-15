echo('<div class="resultlistitem" rank="rank' . $i . '" language="'. $_REQUEST["market"] .'">');
echo('<div ' . $classHtml . '>');
// echo('  <table width="100%"> <tr> <td>');
echo('    <a href="' . $value->Url .  '" target="' . $target . '">');
//echo('    <a href="' . $value->Url .  '" target="' . $target . '" style = "color:#FBC02D; width:50px" >');
echo(strip_tags($value->Title));
echo('    </a>');
// echo('  </td> <td width="5"> </td> <td width="100" style="vertical-align:top; text-align:right;">');
echo('    <a href="javascript:;" style="color:#FBC02D; font-size:90%; float:right;" class="favButton">Relevant</a>');
// echo('  </td> </tr> </table>');
echo('</div>');


.resultlistitem{
	padding-top: 5px;
	padding-bottom: 0px;
	max-width: 520px;
	word-wrap: break-word;
	clear: left;
}

.box1 .resultlistitem{
	padding-top: 5px;
	padding-bottom: 5px;
	max-width: 700px;
	word-wrap: break-word;
}

.resultlistitem a{
	text-decoration: none;
	font-size: 125%;
}

.resultlistitem a:hover{
	text-decoration: underline;
}

.url{
	color: #388222;
}
