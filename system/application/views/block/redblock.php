<?if(isset($MenuLeft) && !empty($MenuLeft)):?>
<?if (!(isset($this->data["authed"]) && $this->data["authed"])) $ShowMenuLeft = true;?>
<?if(empty($ShowMenuLeft)):?>
<style type="text/css">
#fixedleft{position:fixed;left:0px;}
#fixedleft .block{ text-align:left;  background-color:#fff; }
#leftpanel{position:fixed;left:0;width:20px;height:450px;background-color:#FF4E7A;background:url(/images/blocks/red/bok-panel-info.png);display:block; cursor:pointer;}
#fixedleft .block span.tool {position:fixed !important;}
</style>

<div id="leftpanel" onclick="$('#fixedleft').toggle('normal');$(this).toggle('normal');"></div>
<div id="fixedleft" style="display:none;">
<div style="position:fixed; left:0px; height:30px;color:#fff" onclick="$('#leftpanel').toggle('normal');$('#fixedleft').toggle('normal');"></div>
<?endif;?>

<?$MenuLeft=$MenuLeft['child'];

$cont['text'] ='';//print_r($MenuLeft);
foreach ($MenuLeft as $part){
	$cont['text'] .='<p><b>'.$part['name'].'</b></p>
	<ul style="margin:0px 5px 15px 5px">';
	if(isset($part['child']))
	foreach ($part['child'] as $item){

		$cont['text'] .=level($item);
	}
	$cont['text'] .='</ul>';
	
}
if (!(isset($this->data["authed"]) && $this->data["authed"]))
$cont['text'] .=		'<span style="float:left;margin-top:10px"><a href="#" onclick="reg_form();return false;"><img src="/images/blocks/red/regbut.gif" style="border:0"></img></a></span>';
else $cont['text'] .=	'<span style="float:left;margin-top:10px; width:100%;text-align:center"><a href="/ppage/myfinances/buy_info" return false;"><img src="/images/blocks/red/buyinfo.gif" style="border:0"></img></a></span>';

$cont['name'] = 'Как работает сервис';

if(empty($ShowMenuLeft)) $this->load->view('block/left-panel-block', $cont);
else $this->load->view('block/block', $cont);
?>
<?endif;?>

<?if(empty($ShowMenuLeft)):?></div><?endif;?>
<style type="text/css">
.red .block span.tool {
	display:table;
	background:transparent url(/img/lefttool.png) right center no-repeat;
	font-size:12px;
	height:99px;
	width:230px;
	/*padding:5px 10px 15px 50px;*/
	color:#000;	
	/*
	margin-left:165px;
	margin-top:70px;
*/
}
.red .block span.tool>ul{

	padding: 5px 8px 15px 43px;
	display: table-cell; 
	vertical-align: middle;
}

</style>
<script>

$(".red .block ul li a.tool").tooltip({position: 'center right', display:'table',	offset: [5, 0]});
//$(".top_menu a[title]").tooltip();

</script>
<?
function level($item , $out=''){
		if(empty($item['url'])) $item['url'] = $item['link'];
		if(!empty($item['htmlid'])) $class= ' id="'.$item["htmlid"].'" ';else $id ='';
		if(!empty($item['htmlclass'])) $class= ' class="'.$item["htmlclass"].'" ';else $class ='';
		if(!empty($item['title'])) $title = ' title="'.$item["title"].'" ';else $title ='';
		
		$out .='<li><a'.$class.' href="'.$item['url'].'" '.$title.'>'.$item['name'].'</a>';
		if(!empty($item['child'])){
			$level = '';
			foreach ($item['child'] as $child) $level .= level($child); 
			if(!empty($item['htmlclass'])&& $item['htmlclass']=="tool")
			$out .='<span '.$class.' style="display:none;"><ul>'.$level.'</ul></span>';
			else $out .='<ul'.$class.'>'.$level.'</ul>';
		}
		return $out .='</li>';	
}
?>