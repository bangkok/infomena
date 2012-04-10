<div class='but_close'><img src='/images/close_button.png'></div>
					<table cellspacing=0 cellpadding=2 border=0 id='regf' style="margin-bottom:0">
							<tr><td width="100" align="left"><img src='/images/slogo.png'></td><td align=left><span class='head' style="padding-left:5px">Конвертор <i>info</i></span></td></tr>
					</table>
<style type="text/css">
#conv table{text-align:left;margin:0 auto;margin-bottom:30px}
#conv select{background-color:#F2F5FA; border:0; width:55px; text-align:left;}
/*#conv select:active{outline: 0 none !important}*/
#conv option{background-color:#F2F5FA; border:0;  text-align:left; margin:0;padding:0;}
#conv input{width:130px}
#checkval{background-color:#6271ae; padding:5px}
</style>
	
<form method='post' id="conv">		
<table cellpadding="3" cellspacing="0">
<tr><td></td><td>выбрать валюту
	<select name="valuta1" onchange="changeval(this,'valuta1');conv();">
		<?foreach ($Valuta as $v):?><option class="n" value="<?=$v->id?>" ><?=$v->name?></option><?endforeach;?>
	</select>
</td><td></td></tr>
<tr><td>Сумма:</td><td><input type="text" name="val" onkeyup="conv();"></td><td width="40"><span id="valuta1"><?=$Valuta[0]->name?></span></td></tr>
<tr><td></td><td>выбрать валюту
	<select name="valuta2" onchange="changeval(this,'valuta2');conv();">
		<?foreach ($Valuta as $v):?><option class="n" value="<?=$v->id?>"><?=$v->name?></option><?endforeach;?>
	</select>
</td><td></td></tr>
<!--<tr><td></td><td align="center"><input type="submit" value="Посчитать" onclick="conv();return false;" id="checkval" class="button" ></td><td></td></tr>-->
<tr><td>Сумма:</td><td><input type="text" name="summ"></td><td><span id="valuta2"><?=$Valuta[0]->name?></span></td></tr>
</table>
</form>


