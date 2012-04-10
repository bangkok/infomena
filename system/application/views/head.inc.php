<!-- include js files -->
<?php
$Js['scripts'] =			'<script type="text/javascript" src="/js/scripts.js"></script>';

$Js['jquery-1.4.2'] =	'<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>';
$Js['jquery.cycle'] =	'<script type="text/javascript" src="/js/jquery.cycle.all.2.74.js"></script>';
$Js['cycle'] =			'<script type="text/javascript"> $("#Brends-Block").cycle({fx: "scrollUp", timeout: 500, speed: 8000, pause:1});</script>';


$Js['jquery.galleria'] =	'<script type="text/javascript" src="/js/jquery.galleria.js"></script>';
$Js['function.galleria'] =	'<script type="text/javascript" src="/js/function.galleria.js"></script>';

$Js['function'] =		'<script type="text/javascript" src="/js/function.js"></script>';

$Js['JsHttpRequest'] =   '<script src="/js/lib/JsHttpRequest/JsHttpRequest.js"></script>';
$Js['products'] =   '<script type="text/javascript" src="/js/products.js"></script>';

$Js['jquery'] =		'<script type="text/javascript" src="/js/jquery.js"></script>';
$Js['tools'] =		'<script type="text/javascript" src="/js/jquery.tools.min.js"></script>';

$Js['plugins'] =		'<script type="text/javascript" src="/js/plugins.min.js"></script>';
$Js['buttons'] =	'<script type="text/javascript" src="/js/buttons.js"></script>';

$Js['blockui'] = '<script language="JavaScript" type="text/javascript" src="/js/blockui.js"></script>';
$Js['corner'] = '<script language="JavaScript" type="text/javascript"  src="/js/corner.js"></script>';

$Js['calendar'] = '<script type="text/javascript" src="/js/calendar.js"></script>';

$Js['slideout'] = '<script type="text/javascript" src="/js/slideout.js"></script>';
$Js['serialScroll'] = "	<script type='text/javascript' src='/js/scrollTo/js/jquery.scrollTo-min.js'></script>
	<script type='text/javascript' src='/js/jquery.serialScroll-min.js'></script>
	<script type='text/javascript' src='/js/init.js'></script>";

$Js['jcarousellite'] ='    
<script type="text/javascript" src="/js/jquery.jcarousellite.min.js"></script>
<script type="text/javascript" src="/js/script_jcarousellite.js"></script>
';



$Js['swfupload'] =   '<script type="text/javascript" src="/js/swfupload.js"></script>
<script type="text/javascript" src="/js/plugins/swfupload.queue.js"></script>';

$Js['upload'] = '<script type="text/javascript" src="/js/upload.js"></script>
<script type="text/javascript">rand = "'.$this->db_session->userdata('session_id').'";</script>';
$Js['upload-avatar'] = '<script type="text/javascript" src="/js/upload-avatar.js"></script>
<script type="text/javascript">rand = "'.$this->db_session->userdata('session_id').'";</script>';

$Js['ajaxfileupload'] =	'<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<script language="JavaScript">'."
function ajaxFileUpload(id){
	$.blockUI({message:$('#ajax').load('/ajax/crop_pos_image/'+id), css: { left:'20%' ,width: '840px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
}					
</script>";
$Js['ajaxfileupload-avatar'] =	'<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<script language="JavaScript">'."
function ajaxFileUpload(id){
	$.blockUI({message:$('#ajax').load('/ajax/crop_pos_image_avatar/'+id), css: { left:'20%' ,width: '640px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
}					
</script>";
$Js['imgareaselect'] =	'<script type="text/javascript" src="/js/jquery.imgareaselect.min.js"></script>';

$Js['google-analytics'] = "<script type=\"text/javascript\">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12508755-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>";

$Js['IE6'] ='<script language="JavaScript">
var ie6= !!( !navigator.userAgent.match(/opera/gim) && navigator.userAgent.match(/msie\s*6\./gim))
if( ie6 ){  alert("Ваш браузер IE6, обновите Ваш браузер");  document.location.href="about:blank"; }
</script>';


?>

<!-- include js files -->

     
     
<!-- include css files -->
<?php
$Style['container']='<link rel="stylesheet" href="/css/container.css" type="text/css" media="screen" />';

$Style['style']='<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen" />';
$Style['style.ie6']='<!--[if IE 6]><link rel="stylesheet" href="/css/style.ie6.css" type="text/css" media="screen" /><![endif]-->';
$Style['style.ie7']='<!--[if IE 7]><link rel="stylesheet" href="/css/style.ie7.css" type="text/css" media="screen" /><![endif]-->';
$Style['style.ie8']='<!--[if IE 8]><link rel="stylesheet" href="/css/style.ie8.css" type="text/css" media="screen" /><![endif]-->';
$Style['page']= '<link rel="stylesheet" href="/css/page.css" type="text/css" media="screen" />';
$Style['forms']= '<link rel="stylesheet" href="/css/forms.css" type="text/css" media="screen" />';
$Style['buttons']= '<link rel="stylesheet" href="/css/buttons.css" type="text/css" media="screen" />';
?>



	
<!-- include css files -->

<?
$this->data['JsArray'] = $Js;
$this->data['StylesArray'] = $Style;
?>


