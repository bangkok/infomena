<?if(!empty($message)){?><?=$message;}?>
<form method='post'>
<table cellspacing="0" cellpadding="0" border="0" class="myprofile"><tr>
<td width="65%" valign="top">

	<table cellspacing="0" cellpadding="0" class="art">
	<tr><td colspan="2" class="err"><?if($this->validation){?><?=$this->validation->type_error?><?}?></td></tr>
	<tr><td class="gr">Добавить:<br><br></td><td width="100%">
	<span class="art">
		<input type="radio" onchange="comis(0,0)" name="type" <?if($catalog->type == 'predl') echo 'checked="checked"'?> value="predl">Предложение 
		&nbsp;&nbsp;&nbsp;
		<input type="radio" onchange="comis(0,0)" name="type" <?if($catalog->type == 'spros') echo 'checked="checked"'?> value="spros">Спрос
	</span>
	</td></tr>
	<tr><td colspan="2" class="err"><?if($this->validation){?><?=$this->validation->title_error?><?}?></td></tr>
	<tr><td class="gr">Наименование:</td><td><input type=text name=title value="<?=$catalog->title?>" style="width:230px"></td></tr>
	<tr><td colspan="2" class="err"><?if($this->validation){?><?=$this->validation->desc_error?><?}?></td></tr>
	<tr><td class="gr">Описание:</td><td><textarea name=desc cols=50 rows=6 style="width:100%"><?=$catalog->desc?></textarea></td></tr>
	<tr><td colspan="2" class="err"><?if($this->validation){?><?=$this->validation->razdel_error?><?}?></td></tr>
	<tr><td class="gr">Рубрика:</td><td>
							<select name="razdel" style="width:235px">
								<option class="first" value="">Выбрать рубрику</option>
							<?foreach ($Razdel as $c):?>
								<option class="n" value="<?=$c->id?>"<?if($catalog->razdel == $c->id) echo ' selected="selected"';?>><?=$c->title?></option>
							<?endforeach;?>
							</select>
	</td></tr>
	<tr><td colspan="2" class="err"><?if($this->validation){?><?=$this->validation->tegs_error?><?}?></td></tr>
	<tr><td class="gr">Ключевые слова:</td><td><input type=text name=tegs value="<?=$catalog->tegs?>" style="width:230px"></td></tr>
	
	<tr><td class="gr">Оплата:</td><td>
		<input type="radio" id="info100" name="pay_type" <?if($catalog->pay_type == 'info100') echo 'checked="checked"'?> value="info100" onchange="$('.valdisplay').css({'display':'none'});comis(0,0);">100% info
		<div style="float:right"><input type="radio" name="pay_type" <?if($catalog->pay_type == 'infocash') echo 'checked="checked"'?> value="infocash" onchange="$('.valdisplay').css({'display':''});comis(0,0);"><i>info</i>&nbsp; + &nbsp;наличные </div>
	</td></tr>
	<tr class="valdisplay"><td></td><td align="right">В процентах: <input type=text id="peri" name=peri value="<?=$catalog->peri?>" maxlength="2" size="4" id="per1" 
onkeyup="$('#perc').val(sub100(this.value));comis(0,0);">%&nbsp;&nbsp;&nbsp;<input type=text id="perc" name=perc value="" size="4" disabled style="text-align:right;color:#000">%</td></tr>
	
	</table>
		
	<table style="margin-top:20px">
	<tr><td colspan="2" class="err"><?if($this->validation){?><?=$this->validation->price_info_error?><?=$this->validation->price_cash_error?><?}?></td></tr>
	<tr><td class="gr">Стоимость:</td><td width="100%"><input type=text id="price_info" name=price_info value="<?=$catalog->price_info?>" onkeyup="comis(this, 0);" o> <i>info</i>
	<span class="valdisplay"> + <input type=text id="price_cash" name=price_cash value="<?=$catalog->price_cash?>" size="12" disabled style="text-align:right;color:#000"> 
	<select id="valuta" name="valuta" style="width:60px; border:0" onchange="ivaluta()">
		<!--<option class="first" value="">выбрать валюту</option>-->
		<?foreach ($Valuta as $v):?><option class="n" curs="<?=$v->koef?>" value="<?=$v->id?>" <?if($catalog->valuta == $v->id) echo 'selected="selected"';?>><?=$v->name?></option><?endforeach;?>
	</select>	</span>
	<!--<span id="valuta">EUR</span>-->
	</td></tr>

	<tr><td class="gr">Комиссия сервиса 5%:</td><td nowrap><input id="comis2" type="text" name=tel value="" disabled style="text-align:right;color:#000""> <i>info</i> 

	</td></tr>
	<tr><td class="gr">Всего к оплате:</td><td><input id="cost" type=text name=cost value="" disabled style="text-align:right;color:#000">  <i>info</i>
	<span id="cost_cash" class="valdisplay"></span></td></tr>
	<tr><td class="gr">Действительно до:</td><td><input type=text name=breack_date value="<?=date("d-m-Y",time()+60*60*24*30)?>" onfocus="this.select();lcs(this)"
	onclick="event.cancelBubble=true;this.select();lcs(this)"></td></tr>
	<tr><td class="gr">Статус предложения:</td><td>
	
							<select  name="status" onchange='stat(this.value)' style=" width:125px">
								<option class="first" value="">Выбрать статус</option>
								<option id='op_self' class="n" value="-1" <?if($catalog->status==-1){?>selected="selected"<?}?>>Свой вариант</option>
<?$i=0;foreach ($Cat_stat as $s): $i++;	if($s->id != $catalog->status) $style = $selected = '';else {$selected = 'selected="selected"';}?>
								<option <?//=$style?> id = "op<?=$i?>" class="n" value="<?=$s->id?>" <?=$selected?>><?=$s->name?></option>
<?endforeach;?>
								
							</select>
						<div id='status_self' style="margin-top:5px;<?if($catalog->status != -1){?>display:none<?}?>">	
						<input type="text" value="<?=$catalog->status_self?>" name="status_self" >
						</div>	
	
	
<!--	<input type=text name=status value="<?=$catalog->status//$Cat_stat[0]->name?>" >-->
<a href="#" onclick="convinfo();return false;" style="float:right">Конвертор info</a></td></tr>
	</table>

</td>

<td class="pereg_vert" style="width:30px"></td>

<td valign="top">
<!--
	<table cellspacing="0" cellpadding="0" border="0">
	<tr><td class="gr" colspan="2">Добавить фото/видео:<br><br></td></tr>
	<tr><td colspan="2"><input type=text name=tel value="" style="width:100%"></td></tr>
	<tr><td><a href="#">Выбрать</a></td><td align="right"><a href="#">Загрузить</a></td></tr>
	<tr><td colspan="2"><input type=text name=tel value="" style="width:100%"></td></tr>
	<tr><td><a href="#">Выбрать</a></td><td align="right"><a href="#">Загрузить</a></td></tr>
	<tr><td colspan="2"><input type=text name=tel value="" style="width:100%"></td></tr>
	<tr><td><a href="#">Выбрать</a></td><td align="right"><a href="#">Загрузить</a></td></tr>

	<tr><td colspan="2" height="30"></td></tr>
	<tr><td width="120"><div style="height:70px; background:#ccc"></div></td><td align="right" style="vertical-align:middle;"><a href="#">Удалить фото</a></td></tr>
	<tr><td colspan="2" height="15"></td></tr>
	<tr><td width="120"><div style="height:70px; background:#ccc"></div></td><td align="right" style="vertical-align:middle;"><a href="#">Удалить фото</a></td></tr>
	<tr><td colspan="2"  height="15"></td></tr>
	<tr><td width="120"><div style="height:70px; background:#ccc"></div></td><td align="right" style="vertical-align:middle;"><a href="#">Удалить фото</a></td></tr>
	</table>
-->	

	<table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap style="vertical-align:middle;">
	<tr><td class="gr" colspan="2">Добавить фото/видео:<br><br></td></tr>
   </td></tr></table>
    <div id="images">
    <?if(isset($catalog->images)) foreach ($catalog->images as $file):?>
    <table><tr><td>
    	<img src="/image/<?=$file->prevue?>.jpg" alt="<?=$file->file_name?>" class="upimg"></td><td style="vertical-align:middle;text-align:right" nowrap><a href="#" onclick="delimg('<?=$file->id?>',<?=$catalog->id?>);return false;" >Удалить фото<a/><div class="br">
    	</td></td></table><div class="br"></div>
    <?endforeach;?>
    
    <?if(isset($images)) foreach ($images as $file):?>
    <table class="temp-images"><tr><td>
    	<img src="/uploads/<?=$file->id?>.jpg" alt="<?=$file->file_name?>" class="upimg" id="upimg<?=$file->id?>" onclick="return ajaxFileUpload('<?=$file->id?>');"></td><td style="vertical-align:middle;text-align:right">
    	<a href="#" onclick="return ajaxFileUpload(<?=$file->id?>);">Редактировать</a>
    	<a href="/ppage/my_bussines/del/<?=$file->id?>" onclick="delimg('<?=$file->id?>',<?=$catalog->id?>);return false;" >Отменить<a/><div class="br">
    	</td></td></table><div class="br"></div>
    <?endforeach;?>
    </div>
         <table style="margin-bottom:10px"><tr><td width="120"><div style="height:70px; background:#ccc"></div>
     
         </td><td align="right" style="vertical-align:middle;"></td></tr></table>
     <table cellpadding="0" cellspacing="0"><tr><td style="padding:0;width:2px"></td><td><div id="uploadButton"></div></td></tr></table>
     <div id="status"></div>	
</td>

<tr><td> 
	<table cellspacing="0" cellpadding="0">
	<tr><td align="left"><button type="reset" class="blink"><span>Вернуть</span></button></td><td>	<input type=hidden name=go value=true><input type="submit" value="Обновить" style="float:right" class="button"><td></tr>
	</table> 
</td><td colspan="2"></td></tr>
</tr></table>
<input type="hidden" value="<?=$catalog->id?>" name="pos">
</form>
<script type="text/javascript">
comis(0, 0);
</script>	