<?
			if(!(isset($geo['countrys']) && !empty($geo['countrys'])))
			$countrys = "<div id='country'><select name=country class='geo' disabled='disabled'><option value='null'>Страна&nbsp;</option>";
		else {
			$countrys = "<div id='country'><select name=country class='geo' onchange=\"geo('c', this.value)\"><option value='null' onclick=\"geo('c', null)\";>Страна&nbsp;</option>";
			foreach ($geo['countrys'] as $country){
				if($country->id != $geo['curcountry'])$selected = '';
				else $selected = 'selected="selected"';
				$countrys .= "<option value='$country->id' $selected >$country->title&nbsp;</option>";
			}
		}
		$countrys .= "</select></div>";

		
		if(!(isset($geo['regions'][$geo['curcountry']]) && !empty($geo['regions'][$geo['curcountry']])))
			$regions = "<div id='region'><select name=region class='geo' disabled='disabled'><option value='null'>Регион&nbsp;</option>";
		else{
			$regions = "<div id='region'><select name=region class='geo' onchange=\"geo('r', this.value)\"><option value='null' onclick=\"geo('r', null)\">Регион&nbsp;</option>";
			foreach ($geo['regions'][$geo['curcountry']] as $region){
				if($region->id != $geo['curregion'])$selected = '';
				else $selected = 'selected="selected"';
				$regions .= "<option value='$region->id' $selected >$region->title&nbsp;</option>";
			}
		}
		$regions .= "</select></div>";
		
		if(!(isset($geo['towns'][$geo['curregion']]) && !empty($geo['towns'][$geo['curregion']])))
			$towns = "<div id='town'><select name=town class='geo' disabled='disabled'><option value='null'>Город&nbsp;</option>";
		else{
			$towns = "<div id='town'><select name=town class='geo'><option value='null'>Город&nbsp;</option>";
			foreach ($geo['towns'][$geo['curregion']] as $town){
				if($town->id != $geo['curtown'])$selected = '';
				else $selected = 'selected="selected"';
				$towns .= "<option value='$town->id' $selected >$town->title&nbsp;</option>";
			}
		}
		$towns .= "</select></div>";
		
		if(isset($razdel)){
		if(empty($razdel))
			$rubrika = "<div id='town'><select name=razdel class='geo' disabled='disabled'><option value='null'>Рубрика&nbsp;</option>";
		else{
			$rubrika = "<div id='town'><select name=razdel class='geo'><option value='null'>Рубрика&nbsp;</option>";
			foreach ($razdel as $item){
				if($item->id != $currazdel)$selected = '';
				else $selected = 'selected="selected"';
				$rubrika .= "<option value='$item->id' $selected >$item->title&nbsp;</option>";
			}
		}
		$rubrika .= "</select></div>";	}else $rubrika = '';
?>
<div class="filter">
<form method="POST">
<table><tr><td style="padding:5px 0 0 8px;">
Фильтр: </td><td valign="middle"> 
<?=$countrys?></td><td>
<?=$regions?></td><td>
<?=$towns?></td><td>
<?if(!empty($rubrika)){?><div style="margin:0 0 5px 0"><?=$rubrika?></div><?}?>

<input type="submit" value="Выбрать" name="filter" class="button" style="width:90px;float:right">

</td></tr>
</table>


</form>
</div>