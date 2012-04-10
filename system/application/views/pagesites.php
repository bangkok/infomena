<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?=$Content['title']?></title>
<meta name="keywords" content="<?=$Content['keywords']?>" />
<meta name="description" content="<?=$Content['description']?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" type="image/png" href="/img/favicon.ico" />

<?=$Styles?>

<?=$Js?>

<?//=$to_head;?>
<?if(!empty($Messages['block_message'])):?>
<script type="text/javascript">
$.growlUI('<?=$Messages['block_message']?>', '');
</script>
<? endif ?>
	
<?include "google-analytics.js.inc"?>
	
</head>
<body>
<div class='cont' id="topbl" >
	<div id='plus'><img src="/images/top_plus.png"></div><div id='plus_content'>Сделать стартовой</div>
	<div id='regall'>
		<?//=$auth_content?>
		<?$this->load->view('block/auth.inc.php',$this->data)?>
	</div>	
</div>
<div class='tr'></div>


<div class='cont' id='main_links'>
<div id="home"><a href="/"><img src="/images/home.gif"></img></a><a href="#"><img src="/images/start.gif"></img></a><a href="/ppage/support"><img src="/images/mail.gif"></img></a></div>
	<div class="top_menu">
	<?$this->load->view('block/menutop.inc.php', $this->data)?>
	</div>
</div>

<div class='cont' id="header">
	<div id='logobl'><a href="/"><img src='/images/logo.png'></a></div>
	<div id='searchbl'>
		<form method='post' action="/search">
		<div id='search_field'>
			<div class="bgleft"></div>
			<div class="bgrigth"></div>
				<input type=text name=searchq id='main_search_input' value='Инфомена - самый выгодный способ меняться' onClick="this.value=''" ><input type=submit value='Найти' id='main_search_button'>
		</div>
		<table width='508' cellspacing=0 cellpadding=2 border=0 id='search_choise'>
		<tr><td id='main_search_predl' nowrap>
			<span class="art">
			<input type="checkbox" name="predl" >Предложение 
			&nbsp;&nbsp;&nbsp;<input type="checkbox" name="spros" >Спрос
			</span>		
		<!--<img src='/images/radio_bga.png' id='radio1'> Предложение</td><td id='main_search_spros'><img src='/images/radio_bg.png' id='radio0'> Спрос-->
		</td><td id='main_search_advsearch'><a href='/search'>Расширенный поиск</a>
		</td></tr>
		</table>
		<input type=hidden name=type value='1' id='form_type'>
		</form>
	</div>
	
<?$this->load->view('block/podel')?>	
	
</div>
<table cellspacing=0 cellpadding=0 border=0 class='cont'>
<tr><td class='left' rowspan="2">
<div class="red"><?=$this->load->view('block/redblock',$this->data)?></div>
<?=$this->load->view('block/leftmenu',$this->data);?>

<?//=$this->load->view('block/block',array('text'=>'Блок редактируется','name'=>'Отзывы'))?>
<?//=$this->load->view('block/block',array('text'=>'Блок редактируется','name'=>'Опрос недели'))?>
</td>

<td height="1">
<div class="main"><?$this->load->view('block/block', $Content)?></div></td>
<?$this->load->view('block/right',$this->data)?>
</tr>

<?if(isset($this->data['Urgently'])):?>
<tr>

<td colspan="2">
<div class="urgently"><?$this->load->view('block/block', 
				array('text'=>$this->load->view('block/urgently',$this->data,true),'name'=>'Срочно куплю за <i><b>info</b></i>'))?></div>
</td>
</tr>
<?endif;?>
</table>
<?$this->load->view('block/footer')?>

<div id="copy"><?=$Content['copy']?></div>

<div id='ajax'></div>
<div id="helper"></div>
<div id='ajax2'></div>
</body>
</html>