<?if(isset($edit_general) && $edit_general==true):?>
<?
			if(!(isset($geo['countrys']) && !empty($geo['countrys'])))
			$countrys = "<div id='country'><select name=country class='geo' disabled='disabled'><option value='null'>Страна</option>";
		else {
			$countrys = "<div id='country'><select name=country class='geo' onchange=\"geo('c', this.value)\"><option value='null' onclick=\"geo('c', null)\";>Страна</option>";
			foreach ($geo['countrys'] as $country){
				if($country->id != $geo['curcountry'])$selected = '';
				else $selected = 'selected="selected"';
				$countrys .= "<option value='$country->id' $selected >$country->title</option>";
			}
		}
		$countrys .= "</select></div>";

		
		if(!(isset($geo['regions'][$geo['curcountry']]) && !empty($geo['regions'][$geo['curcountry']])))
			$regions = "<div id='region'><select name=region class='geo' disabled='disabled'><option value='null'>Регион</option>";
		else{
			$regions = "<div id='region'><select name=region class='geo' onchange=\"geo('r', this.value)\"><option value='null' onclick=\"geo('r', null)\">Регион</option>";
			foreach ($geo['regions'][$geo['curcountry']] as $region){
				if($region->id != $geo['curregion'])$selected = '';
				else $selected = 'selected="selected"';
				$regions .= "<option value='$region->id' $selected >$region->title</option>";
			}
		}
		$regions .= "</select></div>";
		
		if(!(isset($geo['towns'][$geo['curregion']]) && !empty($geo['towns'][$geo['curregion']])))
			$towns = "<div id='town'><select name=town class='geo' disabled='disabled'><option value='null'>Город</option>";
		else{
			$towns = "<div id='town'><select name=town class='geo'><option value='null'>Город</option>";
			foreach ($geo['towns'][$geo['curregion']] as $town){
				if($town->id != $geo['curtown'])$selected = '';
				else $selected = 'selected="selected"';
				$towns .= "<option value='$town->id' $selected >$town->title</option>";
			}
		}
		$towns .= "</select></div>";
?>
<?=$message?>
<style type="text/css">
input[type="checkbox"],
input[type="radio"]{
margin:0;padding:0;
opacity:0;
filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}
.checkboxOn {
text-align: left;
background:url(/images/radio_bga.png) no-repeat 0 3px;
}
.checkboxOff {
text-align: left;
background:url(/images/radio_bg.png) no-repeat 0 3px;
}

</style>
<script type="text/javascript">
function CheckboxCheck (Elem/*, DivId*/) {
  if (Elem.checked) {
	/*document.getElementById(DivId).className="checkboxOn";*/
	$(Elem).parent().removeClass().addClass('checkboxOn');
   }
	else {
	 /*document.getElementById(DivId).className="checkboxOff";*/
	 $(Elem).parent().removeClass().addClass('checkboxOff');
	}
}

//$('span').removeClass().addClass('checkboxOn')


function RadioCheck (Elem) {
  if (Elem.checked) {
	/*document.getElementById(DivId).className="checkboxOn";*/
	$('input[type='+Elem.type+'][name='+Elem.name+']').parent('span').removeClass().addClass('checkboxOff');
	$(Elem).parent('span').removeClass().addClass('checkboxOn');
   }
}
</script>

<form method='post' action="/ppage/edit_general">
	<table cellspacing=0 cellpadding=2 border=0 class='data_table' style="/*width:500px;*/">

		<tr><td colspan="2"><span id='error_nick' class='ferr'><?if($this->validation){?><?=$this->validation->nickcheck_error?><?}?></span></td></tr>
		<tr><td colspan="2"><span id='error_fio' class='ferr'><?if($this->validation){?><?=$this->validation->fio_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['fio']?>:</td><td><input type=text name=fio value='<?=$user->fio?>'>
<!--		
		<span <?if($user->nickcheck=='fio')echo 'class="checkboxOn"';else echo 'class="checkboxOff"';?>>
			<input type="radio" onclick="RadioCheck(this);" name="nickcheck" <?if($user->nickcheck=='fio')echo 'checked'?> value="fio">
		</span>	
-->
		</td></tr>
		<tr><td colspan="2"><span id='error_nickname' class='ferr'><?if($this->validation){?><?=$this->validation->nickname_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['nickname']?>:</td><td><input type=text name=nickname value='<?=$user->nickname?>'>
<!--
		<span <?if($user->nickcheck=='nickname')echo 'class="checkboxOn"';else echo 'class="checkboxOff"';?>>
			<input type="radio" onclick="RadioCheck(this);" name="nickcheck" <?if($user->nickcheck=='nickname')echo 'checked'?> value="nickname">
		</span>	
-->
</td></tr>
		
		<tr><td colspan="2"><span id='error_org' class='ferr'><?if($this->validation){?><?=$this->validation->org_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['org']?>:</td><td><input type=text name=org value='<?=$user->org?>'>
<!--		
		<span <?if($user->nickcheck=='org')echo 'class="checkboxOn"';else echo 'class="checkboxOff"';?>>
			<input type="radio" onclick="RadioCheck(this);" name="nickcheck" <?if($user->nickcheck=='org')echo 'checked'?> value="org">
		</span>
-->
		</td></tr>
		
		<tr><td colspan="2"><span id='error_country' class='ferr'><?if($this->validation){?><?=$this->validation->country_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['country']?>:</td><td><?=$countrys?></td></tr>
		<tr><td colspan="2"><span id='error_region' class='ferr'><?if($this->validation){?><?=$this->validation->region_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['region']?>:</td><td><?=$regions?></td></tr>
		<tr><td colspan="2"><span id='error_town' class='ferr'><?if($this->validation){?><?=$this->validation->town_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['town']?>:</td><td><?=$towns?></td></tr>
		<tr><td></td><td><input type=submit value='<?=$fields['torenew']?>' class='button'></td></tr>
	</table>
	<input type=hidden name=go value=true>
</form>
<?else:?>
			<table cellspacing="0" cellpadding="0" border="0" align="center" >
				<tr><td class="gr"><?=$fields['fio']?>:</td><td><?=$user->fio?> <?//=$user->soname?></td></tr>
				<tr><td class="gr"><?=$fields['nickname']?>:</td><td><?=$user->nickname?></td></tr>
				<tr><td class="gr"><?=$fields['org']?>:</td><td><?=$user->org?></td></tr>
<?
$y1= date('Y',strtotime($user->birthdate));
$m1= date('m',strtotime($user->birthdate));
$d1= date('d',strtotime($user->birthdate));
$y2= date('Y');
$m2= date('m');
$d2= date('d');
//$d= ($d1-$d2) ? max(($d1-$d2)/abs($d1-$d2),0) : 0;
//$m= ($m1-$m2+$d) ? max(($m1-$m2+$d)/abs($m1-$m2+$d),0) : 0;
$d= ($d1-$d2)>0 ? 1 : 0;
$m= ($m1-$m2+$d)>0 ? 1 : 0;
?>				
				<tr><td class="gr"><?=$fields['old']?>:</td><td><?=$y2-$y1-$m?> лет</td></tr>
				<tr><td class="gr"><?=$fields['inservicewith']?>:</td><td><?=date('d.m.Y',strtotime($user->ad))?></td></tr>
				<tr><td class="gr"><?=$fields['country']?>:</td><td><?=$geo['countrys'][$user->country]->title?></td></tr>
				<tr><td class="gr"><?=$fields['region']?>:</td><td><?=$geo['regions'][$user->country][$user->region]->title?></td></tr>
				<tr><td class="gr"><?=$fields['town']?>:</td><td><?=$geo['towns'][$user->region][$user->town]->title?></td></tr>
			</table>	
<?endif;?>