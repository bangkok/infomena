<?//====================== Поля заполнения ========?>
<?if(!empty($contacts)):?>
<div class="contacts-text">
     <?=$contacts?>
</div>
<?endif;?>

<h1><?=$this->lang->line('feedback');?></h1>
<div class="contacts">
<center><?=$message?></center>
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
	
	<td  ><input  value="<?if($this->validation) echo $this->validation->fio; elseif (isset($user))echo $user->fio;?>"  type=text name=fio size=50 maxlength=90></td>
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

<?// --------------------- Телефон --------------------------?>
<tr><td valign="bottom" colspan="3" align="center" nowrap><?if($this->validation){?><?=$this->validation->phone_error?><?}?></td></tr>
<tr>
	<td class="required"></td>
	<td nowrap><b><?=$fields['phone']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->phone?>" <?}?> type=text name=phone size=50 maxlength=90></td>
</tr>
<?// --------------------- Телефон --------------------------?>

<?// --------------------- Опыт работы: ---------------------?>
<tr><td valign="bottom" colspan="3" align="center" nowrap><?if($this->validation){?><?=$this->validation->message_error?><?}?></td></tr>

<tr>
	<td class="required">*</td>
	<td id="window_mail_с_text" nowrap><b><?=$fields['message']?>:</b></td>
	
	<td id="window_mail_с_text"><textarea rows="4" name=message style="width:270px"><?if($this->validation){?><?=$this->validation->message?><?}?></textarea></td>
</tr>
<?// --------------------- Опыт работы: ---------------------?>


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


