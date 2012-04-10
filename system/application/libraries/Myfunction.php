<?

 function searching($serch,$text)
{
	$text=eregi_replace($serch,$text,'<span class="searh">'.$serch.'</span>');
	//print"<br> ----- ".$text;
	return $text;
	  
}

?>