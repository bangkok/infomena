<?php
//if(isset($this->data['auth']))print_r($this->data['auth']);
	if (isset($this->data["authed"]) && $this->data["authed"])
	{
		if(isset($block_message) && !empty($block_message)){
		?>
		<script type="text/javascript">
$.growlUI('<?=$block_message?>', '');
</script>
		<script type="text/javascript">
$('td.left div.red').load('/ajax/redblock');
</script>
		<?}?>
		<div id='reg_open_but'><img src="/images/top_open.png" id='regc_img'></div>
				<div id="regc">
				<table cellspacing=0 cellpadding=1 border=0 width='100%'>
				<tr><td width='70px' class='nick'><a href="/ppage"><?=$auth['name']?></a></td><td align=right colspan=2>На счету: <?=$auth['info']?> <i>info</i></td></tr>
				<tr><td>
				<?$this->load->view('block/ratinga',array('rating'=>$auth["rating"]))?>
				<!--<img src="/images/stars_temp.png">-->
				</td><td colspan=2>&nbsp;</td></tr>
				</table><table cellspacing=0 cellpadding=1 border=0 width='100%'>
				<tr><td rowspan=4><img class="avatar" src="<?if($auth["avatar"]):?>/image/<?=$auth["avatar"]?>.jpg/<?=rand();?><?else:?>/img/default.png<?endif;?>"/></td>
					<td colspan=2 class='tdnew'>Новых:</td></tr>
				<tr><td colspan=2><img src='/images/amail.png'> сообщений <a href="/ppage/talk/messages"><?=$CntMessagesNew?></a></td></tr>
				<tr><td colspan=2><img src='/images/areview.png'> отзывов <a href="/members"><?=$CntUserComments?></a></td></tr>
				<tr><td><a href='/ppage'>В кабинет</a></td><td align=right id='exit2'>Выйти</td></tr>
				
				</table>
			   </div>
		<div id="reg">
			<div class="regt" id='regt4'><a href="/ppage" class='nick'><?=$auth['name']?></a></div>
			<div class="regt" id='regt5'><img src='/images/let_com.png'></div>
			<div class="regt" id='regt6'>(<a href="/ppage/talk/messages"><?=$CntMessagesNew?></a>/<a href="/members"><?=$CntUserComments?></a>)</div>
			<div class="regt" id='exit'>Выйти</div>
		</div>
		<script type="text/javascript">$('#main_menu').css('display','block');</script>
<?	}else{
		if(isset($block_message) && !empty($block_message)){
		?>
<script type="text/javascript">
$.growlUI('<?=$block_message?>', '');
</script>
		<?}?>
<div id='reg_open_but'><img src="/images/top_open.png" id='regc_img'></div>
			<div id="regc">
			<form id='auth' method='post' action="javascript:auth();">
			<table cellspacing=0 cellpadding=0 border=0>
				<tr><td>E-mail</td></tr>
<?
$login="";
if(!empty($this->data['saveauth'])) $login = $this->data['saveauth'];
?>
			
				<tr><td><input type=text name=login class='input' value="<?=$login?>"></td></tr>
				<tr><td>Пароль (<span id='pwd_remind'>Забыли пароль?</span>)</td></tr>
				<tr><td><input type=password name=pwd class='input'></td></tr>
				<tr><td colspan=2><input type=checkbox name=save class='checkbox'> Запомнить меня</td></tr>
			</table>
			<div class="regt" id='regt3'>Регистрация</div><div class="regt" id='regt2'>Войти</div>
					<input type="submit" style="display:none;">
			</form>
		</div>
		<div id="reg">
			<div class="regt" id='regt'>Регистрация</div>
			<div class="regt" id='regt2'>Войти</div>
			
		</div>
<?}?>