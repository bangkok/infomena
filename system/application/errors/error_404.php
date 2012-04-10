<?php header("HTTP/1.1 404 Not Found"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"

xml:lang="en" lang="en">

<head>

<title>Запрошеная страница не найдена [error 404]</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>



<body>

<?
// tests
$ver = 'standart';
$ver = 'other';

if ($ver == 'standart')
{
?>
	<div id="content">
		<h1><?php  echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
<?	
}
else
{
	
$tests = false;
if ($tests)
{
	echo "<strong>Тесты (жать 2 раза):</strong><br />";
	echo "<a href=\"/dfg/dfg/dfg\">Плохая ссылка с этого сайта</a><br />";
	echo "<a href=\"/dfg/dfg/sdf/otherotherother\">Плохая ссылка с другого сайта</a><br />";
	echo "<a href=\"/dfg/dfg/dfg.looksmart.co?sdf=dfg&q=fdghf+dgdf+dfg\">Плохая ссылка с поисковика</a><br />";
	echo "<a href=\"/dfg/dfg/dfg.looksmart.co?sdf=dfg&q=дом+dgdf+dfg\">Плохая ссылка с поисковика с словом [дом]</a><br />";
	echo "<br /><br />";
}


if ($_SERVER['HTTP_HOST'] == 'yangoly.loc')
{
	$config["A_SMTP"] = "localhost";
	$config["A_SMTP_port"] = "25";
	$config["A_SMTP_user"] = "";
	$config["A_SMTP_pass"] = "";
	$config["A_admin_mail"] = "box4list@ya.ru";
	$config["A_admin_mail_CC"] =array(

						);

	// стандартные страницы
	$helpLinks = array(
			array ("link" => "/", "text" => "домашняя страница", "title" => "переход на домашнюю старницу"),
			array ("link" => "http://".$_SERVER['HTTP_HOST']."/map/", "text" => "карта сайта", "title" => "")
			//array ("link" => "/sitemap", "text" => "Карта Сайта", "title" => "Полная карта сайта")
		);
		
	$helpSearchLinks = array(
//			array ("link" => "http://".$_SERVER['HTTP_HOST']."/dfg/", "text" => "поиск адреса", "title" => ""),
	);
		
	// соответствие терминов в поисковике страницам сайта
	$termLinks = array();

	$aliasLinks = array(
			"shift.loc"
		);	
							
}
else
{
	$config["A_SMTP"] = "localhost";
	$config["A_SMTP_port"] = "25";
	$config["A_SMTP_user"] = "";
	$config["A_SMTP_pass"] = "";
	//$config["A_admin_mail"] = "";
	$config["A_admin_mail"] = "box4list@ya.ru";
	$config["A_admin_mail_CC"] =array(
							
						);
						
	// стандартные страницы
	$helpLinks = array(
			array ("link" => "/", "text" => "домашняя страница", "title" => "переход на домашнюю старницу"),
			array ("link" => "http://".$_SERVER['HTTP_HOST']."/map/", "text" => "карта сайта", "title" => "")
		);
		
	$helpSearchLinks = array(

	);
		
	// соответствие терминов в поисковике страницам сайта
	$termLinks = array(
			
		);
	
	// алиасы домена сайта
	$aliasLinks = array(
			"yangoly.com.ua"
		);							
}
?>

<h1>Запрошеная страница отсутствует <small>[error 404]</small></h1>
<p>... но возможно мы вам поможем</p>


<?
//phpinfo();
$blnSearchReferral = false;
$blnInsiteReferral = false;
$strSite = "";

if (isset($_SERVER["HTTP_REFERER"]))
	$strReferrer = strtolower($_SERVER["HTTP_REFERER"]);
else
	$strReferrer = "";

if (strlen($strReferrer) == 0)
	{
	//not referred from anything at all, apparently!
	$str = '';
	$str .= 'Мы думаем одна из следующих ссылок окажется вам полезной:</p>';
	$str .= '<p>';
	foreach ($helpLinks AS $val)
	{
		$str .= "<a href='".$val["link"]."' title=\"".$val["title"]."\">".$val["text"]."</a><br />";
	}	
	$str .= '</p>';
	$str .= '<hr />';
	$str .= '<p><strong>Вы не попали на нужную страницу потому что:</strong></p>';
	$str .= '<ol type="a">';
	$str .= '<li>У вас <strong>устаревший bookmark/favourite</strong></li>';
	$str .= '<li>Поисковый сайт содержит <strong>устаревший список ссылок на нас</strong></li>';
	$str .= '<li>Вы <strong>ошиблись в наборе адреса</strong></li>';
	$str .= '</ol>';
	echo $str;
}
else
{	
	if (
		stripos($strReferrer, ".looksmart.co") != ""
		|| stripos($strReferrer, ".ifind.freeserve") != ""
		|| stripos($strReferrer, ".ask.co") != ""
		|| stripos($strReferrer, "google.co") != ""
		|| stripos($strReferrer, "altavista.co") != ""
		|| stripos($strReferrer, "msn.co") != ""
		|| stripos($strReferrer, "yahoo.co") != ""
		|| stripos($strReferrer, "yandex.ru") != ""
		|| stripos($strReferrer, "rambler.ru") != ""
		|| stripos($strReferrer, "meta.ua") != ""
		)
	{
		//we have been referred to from a known search engine
		
		$blnSearchReferral = true;
		$arrSite = explode("/", $strReferrer);
		$arrParams = explode("?", $strReferrer);
		$strSearchTerms = $arrParams[1];
		$arrParams = explode("&", $strSearchTerms);
		
		$strSite=$arrSite[2];
		$sQryStr="";
		
		//define what search terms are in use
		$arrQueryStrings = array();
		$arrQueryStrings[0] = "q=";	//google, altavista, msn
		$arrQueryStrings[1] = "p=";	//yahoo
		$arrQueryStrings[2] = "ask=";	//ask jeeves
		$arrQueryStrings[3] = "key=";	//looksmart
		
		for ($i=0; $i < count($arrParams); $i++)
		//loop through all the parameters in the referring page's URL
		{
			for ($q=0; $q < count($arrQueryStrings); $q++)
			{
				$sQryStr = $arrQueryStrings[$q];
				if (stripos($arrParams[$i], $sQryStr) != "" )
				{
					//we've found a search term!
					$strSearchTerms = $arrParams[$i];
					$strSearchTerms = explode($sQryStr, $strSearchTerms);
					$strSearchTerms = $strSearchTerms[1];
					$strSearchTerms = str_replace($strSearchTerms, "+", " ");
				}
			}
		}
		echo "<p>Вы осуществляли поиск на <strong><a href='" 
			.$strReferrer 
			."' target='_blank'>" 
			.$strSite 
			."</a></strong> по запросу \"<strong>" 
			.urldecode($strSearchTerms) 
			."</strong>\". Однако, их индекс должно быть устарел.</p>";
		echo "<h3>Не все потеряно!</h3>";
		echo "<p>Мы думаем следующие страницы на нашем сайте вам помогут:</p>";
		//--------------------------------------------------------------
		// edit and repeat for all pages you want to match to the search phrases found
		
		$findTerms = false;
		foreach ($termLinks AS $val)
		{
			$inArray = false;
			foreach ($val["terms"] AS $valT)
			{
				if (stripos(urldecode($strSearchTerms), $valT) != "")
				{
					$inArray = true;
					$findTerms = true;
					break;
				}				
			}
			if ($inArray)
			{
				echo "<a href='".$val["link"]."' title=\"".$val["title"]."\">".$val["text"]."</a><br />";
			}
		}
		

		
		if (!$findTerms)
		{
			foreach ($helpSearchLinks AS $val)
			{
				echo "<a href=\"".$val["link"]."\" title=\"".$val["title"]."\">".$val["text"]."</a><br />";
			}
		}
		//--------------------------------------------------------------
	}//end of section dealing with referral from known search engine
	
	if (!$blnSearchReferral)
	{
		// for referrals from other sites with broken links
		// ------------------------------------------------
		$strSite = $strReferrer;
		$strSite = explode("/", $strSite);
		$strSite = $strSite[2];
		echo "<p>Вы перешли по неверной ссылке с сайта: <strong><a href='" 
			.$strReferrer
			."' target='_blank'>"
			.$strSite 
			."</a></strong><br />"
			."Мы предлагаем вам перейти по одной из следующих ссылок:</p>";
	}
	else
	{
		echo "<p>Или вы можете попробовать перейти на одну из следующих страниц:</p>";
	}
	
	foreach ($helpLinks AS $val)
	{
		echo "<a href=\"".$val["link"]."\" title=\"".$val["title"]."\">".$val["text"]."</a><br />";
	}
	
	if (!$blnSearchReferral)
	{
		// for referrals from other sites with broken links
		// ------------------------------------------------
		
		$blnInsiteReferral = false; 
		foreach ($aliasLinks AS $val)
		{
			if (stripos($strReferrer, $val) != "" && stripos($strReferrer, "otherotherother") == "")
			{
				$blnInsiteReferral = true;
				break;
			}	
		}
		

		$txt = '';
		$txt .= 'Неверная ссылка на страницу - ['.$_SERVER["REQUEST_URI"].'] reffer - ['.$strReferrer."]\n\n";
		$txt .= 'IP: '.$_SERVER["REMOTE_ADDR"];
		
		$subj = $_SERVER['HTTP_HOST']."/Error404/ - ".date("Y-m-d H:i:s");
		
		require_once APPPATH."libraries/swift/Swift.php";
		require_once APPPATH."libraries/swift/Swift/Connection/SMTP.php";
		
		//Start Swift
		try {
			$smtp = new Swift_Connection_SMTP($config["A_SMTP"], $config["A_SMTP_port"]);
			$smtp->setUsername($config["A_SMTP_user"]);
			$smtp->setpassword($config["A_SMTP_pass"]);
			 
			$swift = new Swift($smtp);
			
			//Create the message
			$message = new Swift_Message($subj, $txt, "text/plain", "8bit", "UTF-8");
			
			$message->headers->setLanguage("ru");
			$message->headers->setCharset("UTF-8");
								
			$recipients = new Swift_RecipientList();
			$recipients->addTo($config["A_admin_mail"]);
			//Use addCc()
			foreach ($config["A_admin_mail_CC"] AS $val)
				$recipients->addCc($val);
			
			//Now check if Swift actually sends it
			$swift->send($message, $recipients, $config["A_admin_mail"]);
			//$data['error']="Спасибо! Ваше сообщение получено<br /> и будет рассмотрено в ближайшее время.";
		} catch (Swift_ConnectionException $e) {
				
		} catch (Swift_Message_MimeException $e) {
				
		}				

	}
}

}// end ver

?>

</body>
</html>
