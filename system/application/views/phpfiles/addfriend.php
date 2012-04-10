<?//====================== Поля заполнения ========?>
<?if(!empty($contacts)):?>
<div class="addfriend-text">
     <?=$contacts?>
</div>
<?endif;?>

<h1><?=$this->lang->line('addfriend');?></h1>
<div class="addfriend">
<p><center><?=$message?></center></p>
<form name=send action="#add" method=post>
<style type="text/css">
.report_form{ text-align:center}
</style>
 <table  border=0 class="data_table">
  
<tr><td>*</td><td colspan="2"  style="text-align:left"><span class="poleobkzap"><?=$this->lang->line('poleobkzap');?></span></td></tr>

<?// --------------------- Раздел ФИО --------------------------?>
<tr><td valign="bottom" colspan="3" align="center" nowrap><?if($this->validation){?><?=$this->validation->fio_error?><?}?></td></tr>
<tr>
	<td class="required">*</td>
	<td nowrap><b><?=$fields['fio']?>:</b></td>
	
	<td  ><input <?if($this->validation){?> value="<?=$this->validation->fio?>"<?}?>  type=text name=fio size=50 maxlength=90></td>
</tr>
<?// --------------------- Раздел ФИО --------------------------?>

<?// --------------------- Раздел mail -------------------------?>
<tr>
	<td valign="bottom" colspan="3" align="center" nowrap><?if($this->validation){?><?=$this->validation->mail_error?><?}?></td>
</tr>
<tr>
	<td class="required">*</td>
	<td nowrap><b><?=$fields['mail']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->mail?>"<?}?>  type=text name=mail size=50 maxlength=50></td>
</tr>
<?// --------------------- Раздел mail -------------------------?>



<?// --------------------- Раздел kcaptcha есть еще в забыли пароль -----?>
<tr><td colspan="3" align="center" height="30" nowrap><?if($this->validation){?><?=$this->validation->captcha_error?><?}?></td></tr>


<tr>
	<td class="required">*</td>
	<td nowrap><b><?=$fields['captcha']?>:</b></td>
	
	<td>
	  <table width="100%" border=0 cellpadding=1 cellspacing=0>
	  <tr>
	     <td valign="middle" width="50" nowrap><input style="width:40px;" type=text name=captcha size=15 maxlength=7></td>
	     <td width="120" valign="middle" nowrap><img style="margin:0 0 0 10px;" id="codimg" src="/auth/captcha"></td>
	     <td align="left"><a class="dalee" id="refresh_but" style="float:left;" href="#"><?=$fields['torenew']?></a></td>    
	     
	  </tr></table>
	</td>
</tr>
<?// --------------------- Раздел kcaptcha есть еще в забыли пароль -----?>

<tr>
	<td colspan=2></td><td style="text-align:left"><input class="button" type=submit value="<?=$fields['submit']?>" name=send></td>
</tr>
</table>
</form>
</div>
<?//---- Поля заполнения -----------?>


