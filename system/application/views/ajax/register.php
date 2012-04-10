<?if (/*false && */(!isset($run) || !$run)):?>
<?
define('DOMAIN_NAME',$_SERVER['HTTP_HOST']);

        


$months=array('Месяц','Январь','Февраль','Март','Апрель',
         'Май','Июнь','Июль','Август',
         'Сентябрь','Октябрь','Ноябрь','Декабрь');
  $kol_days=array('День','31','29','31','30','31','30','31','31','30','31','30','31');
  $currencies=array('INFO','USD','EUR','UAH','RUR');
    
	//------------------- member constants
	$status=array(	'Добро пожаловать!',
					'Чай,кофе,обменяться',
					'Полцарства за коня!',
					'У нас все получится!',
					'Идут перегоровы!',
					'Не беспокоить',
					'Вышел на минутку',
					'Перерыв',
					'Шампанского!',
					'Я молодец!',
					'Свой вариант'
				  );
	$contacts_fields=array('tel','mtel','icq','skype','url');
	$contacts_fields_title=array('Тел.','Моб. тед.','icq','skype','web');	

		$sname = session_name();
        $sid = session_id();
		$region_sel="<select name=region disabled><option>Выбрать</option></select>";
		$town_sel="<select name=region disabled><option>Выбрать</option></select>";
		$mon_len=count($months);
		$mon_sel="<select name=monb id='monb'>";
		for ($i=0;$i<$mon_len;$i++)
			{
				$mon_sel.="<option value='$i' ". $this->validation->set_select('monb', $i). ">$months[$i]</option>";
			}
		$mon_sel.="</select>";	
		$days_sel="<select name=dayb id='dayb'>
					<option value=0>День</option>";
		for ($i=1;$i<=31;$i++)
		{
			$days_sel.="<option value='$i' ". $this->validation->set_select('dayb', $i). ">$i</option>";
		}
		$days_sel.="</select>";
		$year_sel="<select name=year id='yearb'><option value='0'>Год</option>";
		for ($i=date("Y")-10;$i>=date("Y")-70;$i--)
		{
			$year_sel.="<option value='$i' ". $this->validation->set_select('year', $i). ">$i</option>";
		}
		$year_sel.="</select>";

		if(!(isset($geo['countrys']) && !empty($geo['countrys'])))
			$countrys = "<div id='country'><select name=country class='geo' disabled='disabled'><option value='null'>Страна</option>";
		else {
			$countrys = "<div id='country'><select name=country class='geo' onchange=\"geo('c', this.value)\"><option value='null'>Страна</option>";
			foreach ($geo['countrys'] as $country)
				$countrys .= "<option value='$country->id' ".$this->validation->set_select('country', $country->id)."  >$country->title</option>";
		}
		$countrys .= "</select></div>";

		
		if(!(isset($geo['regions'][$geo['curcountry']]) && !empty($geo['regions'][$geo['curcountry']])))
			$regions = "<div id='region'><select name=region class='geo' disabled='disabled'><option value='null'>Регион</option>";
		else{
			$regions = "<div id='region'><select name=region class='geo' onchange=\"geo('r', this.value)\"><option value='null'>Регион</option>";
			foreach ($geo['regions'][$geo['curcountry']] as $region)
				$regions .= "<option value='$region->id' ".$this->validation->set_select('region', $region->id)." >$region->title</option>";
		}
		$regions .= "</select></div>";
		
		if(!(isset($geo['towns'][$geo['curregion']]) && !empty($geo['towns'][$geo['curregion']])))
			$towns = "<div id='town'><select name=town class='geo' disabled='disabled'><option value='null'>Город</option>";
		else{
			$towns = "<div id='town'><select name=town class='geo'><option value='null'>Город</option>";
			foreach ($geo['towns'][$geo['curregion']] as $town)
				$towns .= "<option value='$town->id' ".$this->validation->set_select('town', $town->id).">$town->title</option>";
		}
		$towns .= "</select></div>";
		
		$content="";
?>
		<div class='but_close'><img src='/images/close_button.png'></div>
		<center><?=$message?></center>
<div id='reg_block'>		
			<form method='post' id='reg_form'>
<table cellspacing=0 cellpadding=1 border=0 id='regf'>
<tr><td><img src='/images/slogo.png'></td><td align=left><span class='head'>Регистрация</span><br><span class='subhead'><?=$fields['allobkzap']?></span></td></tr>
<tr><td colspan="2"><span id='error_parent' class='ferr'><?if($this->validation){?><?=$this->validation->parent_error?><?}?></span></td></tr>
<tr><td class='lefttd' align=right><?=$fields['parent']?>:</td><td align=left>
<input <?if($this->validation){?> value="<?=$this->validation->parent?>"<?}?> type=text name="parent" class=input <?if(!empty($parent_id)){?>disabled<?}?>>
</td></tr>
<tr><td></td><td align=left><span class='subhead'>Введите имя на infomena.com того, кто пригласил Вас в сервис</span></td></tr>
<!--Имя в системе-->
<tr><td colspan="2"><span id='error_nickname' class='ferr'><?if($this->validation){?><?=$this->validation->nickname_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['nickname']?>:</td><td align=left><input <?if($this->validation){?> value="<?=$this->validation->nickname?>"<?}?> type=text name=nickname class=input id='nickname'></td></tr>
<!--/Имя в системе-->
<!--ФИО-->
<tr><td colspan="2"><span id='error_fio' class='ferr'><?if($this->validation){?><?=$this->validation->fio_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['fio']?>:</td><td align=left><input <?if($this->validation){?> value="<?=$this->validation->fio?>"<?}?> type=text name=fio class=input id='fio'></td></tr>
<!--/ФИО--><!--/E-mail-->

<tr><td colspan="2"><span id='error_email' class='ferr'><?if($this->validation){?><?=$this->validation->email_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['email']?>:</td><td align=left><input <?if($this->validation){?>value="<?=$this->validation->email?>"<?}?> type=text name=email class=input id='email'></td></tr>
<!--/E-mail--><!--Пароль-->
<tr><td colspan="2"><span id='error_p1' class='ferr'><?if($this->validation){?><?=$this->validation->p1_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['p1']?>:</td><td align=left><input <?if($this->validation){?>value="<?=$this->validation->p1?>"<?}?> type=password name=p1 class=input id='p1'></td></tr>
<!--/Пароль--><!--Подтверждающий пароль-->
<tr><td colspan="2"><span id='error_p2' class='ferr'><?if($this->validation){?><?=$this->validation->p2_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['p2']?>:</td><td align=left><input <?if($this->validation){?>value="<?=$this->validation->p2?>"<?}?> type=password name=p2 class=input id='p2'></td></tr>
<!--/Подтверждающий пароль--><!--Страна-->

<tr><td colspan="2"><span id='error_country' class='ferr'><?if($this->validation){?><?=$this->validation->country_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['country']?>:</td><td align=left><?=$countrys?></td></tr>
<!--
<tr><td colspan="2"><span id='error_country' class='ferr'><?if($this->validation){?><?=$this->validation->country_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['country']?>:</td><td align=left><input <?if($this->validation){?>value="<?=$this->validation->country?>"<?}?> type=text name=country id='country' class=input></td>
--></tr>
<!--/Страна--><!--Регион-->
<tr><td colspan="2"><span id='error_region' class='ferr'><?if($this->validation){?><?=$this->validation->region_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['region']?>:</td><td align=left><?=$regions?></td></tr>
<!--
<tr><td colspan="2"><span id='error_region' class='ferr'><?if($this->validation){?><?=$this->validation->region_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['region']?>:</td><td align=left><input <?if($this->validation){?>value="<?=$this->validation->region?>"<?}?> type=text name=region class=input id='region'></td>
--></tr>
<!--/Регион--><!--Город-->
<tr><td colspan="2"><span id='error_town' class='ferr'><?if($this->validation){?><?=$this->validation->town_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['town']?>:</td><td align=left><?=$towns?></td></tr>
<!--
<tr><td colspan="2"><span id='error_town' class='ferr'><?if($this->validation){?><?=$this->validation->town_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['town']?>:<span id='error_town' class='ferr'></span></td><td align=left><input <?if($this->validation){?>value="<?=$this->validation->town?>"<?}?> type=text name=town class=input id='town'></td>
--></tr>
<!--/Город--><!--Дата рождения-->
<tr><td colspan="2"><span id='error_birthdate' class='ferr'><?if($this->validation){?><?=$this->validation->birthdate_error?><?}?></span> <input type=hidden name=birthdate  id='birthdate'></td></tr>
<tr><td align=right><?=$fields['birthdate']?>:</td><td align=left><?=$days_sel?> <?=$mon_sel?> <?=$year_sel?></td></tr>
<!--/Дата рождения-->

<tr><td colspan="2"><span id='error_sex' class='ferr'><?if($this->validation){?><?=$this->validation->sex_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['sex']?>:<span id='error_sex'></span></td><td align=left>
	<input type=radio name=sex id='sex' value="m" <?=$this->validation->set_radio('sex', 'm')?> > Мужской 
	<input type=radio name=sex value="w" <?=$this->validation->set_radio('sex', 'w')?> > Женский</td></tr>
<!--Капча-->
<tr><td align=right><span id='refresh_but'><?=$fields['torenew']?></span></td><td align=left><img src="/auth/captcha/<?=rand();?>" id='codimg'></td></tr>
<tr><td colspan="2"><span id='error_cod' class='ferr'><?if($this->validation){?><?=$this->validation->cod_error?><?}?></span></td></tr>
<tr><td align=right><?=$fields['cod']?>:<span id='error_cod' class='ferr'></span></td><td align=left><input type=text name=cod class=input id='cod'></td></tr>
<!--/Капча-->
<tr><td>&nbsp;</td><td align=left><span class=subhead>Введите код подтверждения</span></td></tr>


<tr><td align=right>&nbsp;</td><td align=left valign=middle><img src='/images/new_window.png'> <a href='/ajax_features/text/service_rules' OnClick="service_rules('#ajax2','/ajax_features/text/service_rules');return false;" target="_blank"><?=$fields['rules']?></a></td></tr>
<tr><td colspan="2"><span id='error_rules' class='ferr'><?if($this->validation){?><?=$this->validation->rules_error?><?}?></span></td></tr>
<tr><td align=right>&nbsp;</td><td align=left><table cellspacing=0 cellpadding=0><tr><td><input type=checkbox name=rules id='rules' value="1" <?=$this->validation->set_checkbox('rules', '1');?>></td><td><span class='subhead'><?=$fields['rulesok']?></span><span id='error_rules'></span></td></tr></table></td></tr>
<tr><td>&nbsp;</td><td align=left><input type=button id='regbut' value='' ></td></tr>
</table>
				<input type=hidden name=sid value=<?=$sid?> id='sid'>
				<input type=hidden name=sname value=<?=$sname?> id='sname'>
				<input type=hidden name=go value=true>
				<input id=screen type=hidden name=screen>
				</form>
</div>
<div id='service_rules' style="display:none;"></div>	
<script type="text/javascript">
if (self.screen)
   {
   width = screen.width
   height = screen.height
   }
else if (self.java)
   {
   var jkit = java.awt.Toolkit.getDefaultToolkit();
   var scrsize = jkit.getScreenSize();
   width = scrsize.width;
   height = scrsize.height;
   }
if (width && height) var str = width + " x " + height;
else var str = "неизвестно";
document.getElementById('screen').value = str; 
</script>				
<?else:?>
<div class='but_close'><img src='/images/close_button.png'></div>
					<table cellspacing=0 cellpadding=2 border=0 id='regf'>
							<tr><td width="160" align="left"><img src='/images/slogo.png'></td><td align=left><span class='head'>Регистрация</span></td></tr>
					</table>
		<p style="margin-left:20px;margin-right:40px; ">
		
		Вы успешно прошли регистрацию и получили <b>5 <i>info</i></b> в подарок!<br>
		На Ваш e-mail отправлена ссылка для активации аккаунта.<br><br>
		<h1>Добро пожаловать в сообщество Инфомена!</h1>
		</p>
		&nbsp;
<?endif;?>

