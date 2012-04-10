<div style="width:80%; margin-top:10px; clear:left;">
<center><?=$message?></center>



<div><h3>Введите либо Ваш логин, либо Ваш e-mail.</h3></div>

<form name=send action="#add" method=post>
 <table width=60% border=0 cellpadding=1 cellspacing=5 class="table">
  
<?// --------------------- Раздел Логин -------------------------?>
<tr>
	<td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->login_error?><?}?></td>
</tr>
<tr>
	<td> <b><?=$fields['login']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->login?>"<?}?> style="width:100%;" type=text name=login size=50 maxlength=50></td>
</tr>
<?// --------------------- Раздел Логин -------------------------?>


<?// --------------------- Раздел mail -------------------------?>
<tr>
	<td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->mail_error?><?}?></td>
</tr>
<tr>
	<td> <b><?=$fields['mail']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->mail?>"<?}?> style="width:100%;" type=text name=mail size=50 maxlength=50></td>
</tr>
<?// --------------------- Раздел mail -------------------------?>


<?// --------------------- Раздел kcaptcha есть еще в забыли пароль -----?>
<tr><td colspan="2" align="center" height="30" nowrap><?if($this->validation){?><?=$this->validation->captcha_error?><?}?></td></tr>


<tr>
	<td> <b><?=$fields['captcha']?>:</b></td>
	
	<td>
	  <table width="100%" border=0 cellpadding=1 cellspacing=0>
	  <tr>
	     <td valign="middle" width="50" nowrap><input style="width:40px;" type=text name=captcha size=15 maxlength=7></td>
	     <td width="120" valign="middle" nowrap><img style="margin:0 0 0 10px;" id="captchaI" src="/auth/captcha"></td>
	     <td align="left"><a class="dalee" style="float:left;" href="#" alt="here" onclick="captchaJ(); return false;"><?=$fields['torenew']?></a></td>    
	     
	  </tr></table>
	</td>
</tr>
<?// --------------------- Раздел kcaptcha есть еще в забыли пароль -----?>

<tr>
	<th colspan=2 align="center"><input class="art-button" type=submit value="<?=$fields['submit']?>" name=send></th>
</tr>
</table>
</form>
</div>
<?//---- Поля заполнения -----------?>

