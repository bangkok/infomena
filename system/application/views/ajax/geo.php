<?
/*
		if(!(isset($geo['countrys']) && !empty($geo['countrys'])))
			$countrys = "<div id='country'><select name=country class='geo' disabled='disabled'><option value='null'>Страна</option>";
		else {
			$countrys = "<div id='country'><select name=country id='country' class='geo'><option value='null'>Страна</option>";
			foreach ($geo['countrys'] as $country)
				$countrys .= "<option value='$country->id' >$country->title</option>";
		}
		$countrys .= "</select></div>";
*/
		
		if(!(isset($geo['regions'][$geo['curcountry']]) && !empty($geo['regions'][$geo['curcountry']])))
			$regions = "<div id='region'><select name=region class='geo' disabled='disabled'><option value='null'>Регион</option>";
		else{
			$regions = "<div id='region'><select name=region id='region' class='geo' onchange=\"geo('r', this.value)\"><option value='null'>Регион</option>";
			foreach ($geo['regions'][$geo['curcountry']] as $region)
				$regions .= "<option value='$region->id'>$region->title</option>";
		}
		$regions .= "</select></div>";
		
		if(!(isset($geo['towns'][$geo['curregion']]) && !empty($geo['towns'][$geo['curregion']])))
			$towns = "<div id='town'><select name=town class='geo' disabled='disabled'><option value='null'>Город</option>";
		else{
			$towns = "<div id='town'><select name=town id='town' class='geo'><option value='null'>Город</option>";
			foreach ($geo['towns'][$geo['curregion']] as $town)
				$towns .= "<option value='$town->id' >$town->title</option>";
		}
		$towns .= "</select></div>";
?>
<?
if($geo['geo'] == 'c')
	echo $regions;
elseif($geo['geo'] == 'r') {
	echo $towns;
}
?>