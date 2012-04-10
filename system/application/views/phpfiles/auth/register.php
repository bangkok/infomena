<div style="width:80%; margin-top:10px; clear:left;">
<center><?=$message?></center>
<form name=send action="#add" ENCTYPE="multipart/form-data" method=post>
 <table width=60% border=0 cellpadding=1 cellspacing=5 class="table">
  

 
<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ ¦д¦Ш¦Ю --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->fio_error?><?}?></td></tr>
<tr>
	<td nowrap> <b><?=$fields['fio']?>:</b></td>
	
	<td width="100%"><input <?if($this->validation){?> value="<?=$this->validation->fio?>"<?}?> style="width:100%;" type=text name=fio maxlength=50></td>
</tr>
<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ ¦д¦Ш¦Ю --------------------------?>

<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ mail -------------------------?>
<tr>
	<td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->mail_error?><?}?></td>
</tr>
<tr>
	<td> <b><?=$fields['mail']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->mail?>"<?}?> style="width:100%;" type=text name=mail  maxlength=50></td>
</tr>
<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ mail -------------------------?>

<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ ¦Т¦-¦¬TА¦-TБTВ --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->old_error?><?}?> <input value="1" type=hidden name=old ></td></tr>
<tr>
	<td nowrap> <b><?=$fields['old']?>:</b></td>
	<td>
	<table><tr>
	<td><?if($this->validation){?><?=$this->validation->old_y_error?><?}?></td>
	<td><?if($this->validation){?><?=$this->validation->old_m_error?><?}?></td>
	<td><?if($this->validation){?><?=$this->validation->old_d_error?><?}?></td>
	</tr><tr>
	<td nowrap><b><?=$fields['old_y']?></b> <input <?if($this->validation){?> value="<?=$this->validation->old_y?>"<?}?>  type=text name="old_y"  size=4 maxlength=4></td>
	
	<td nowrap><b><?=$fields['old_m']?></b> <input <?if($this->validation){?> value="<?=$this->validation->old_m?>"<?}?>  type=text name="old_m"  size=2 maxlength=2></td>
		
	<td nowrap><b><?=$fields['old_d']?></b> <input <?if($this->validation){?> value="<?=$this->validation->old_d?>"<?}?>  type=text name="old_d"  size=2 maxlength=2></td>
	</tr></table>
	</td>
</tr>
<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ ¦Т¦-¦¬TА¦-TБTВ --------------------------?>

<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ ¦Ы¦-¦¦¦¬¦- -------------------------?>
<tr>
	<td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->login_error?><?}?></td>
</tr>
<tr>
	<td> <b><?=$fields['login']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->login?>"<?}?> style="width:100%;" type=text name=login size=16 maxlength=16></td>
</tr>
<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ ¦Ы¦-¦¦¦¬¦- -------------------------?>

<?// --------------------- 1 ¦Я¦-TА¦-¦¬TМ --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->pass1_error?><?}?></td></tr>
<tr>
	<td nowrap> <b><?=$fields['pass1']?>:</b></td>
	
	<td width="100%"><input type="password"  value="" style="width:100%;" type=text name=pass1 maxlength=90></td>
</tr>
<?// --------------------- 1 ¦Я¦-TА¦-¦¬TМ --------------------------?>


<?// --------------------- 2 ¦Я¦-TА¦-¦¬TМ --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->pass2_error?><?}?></td></tr>
<tr>
	<td> <b><?=$fields['pass2']?>:</b></td>
	
	<td width="100%"><input  type="password"  value=""  style="width:100%;" type=text name=pass2 maxlength=90></td>
</tr>
<?// --------------------- 2 ¦Я¦-TА¦-¦¬TМ --------------------------?>



<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ kcaptcha ¦¦TБTВTМ ¦¦TЙ¦¦ ¦- ¦¬¦-¦-TЛ¦¬¦¬ ¦¬¦-TА¦-¦¬TМ -----?>
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
<?// --------------------- ¦а¦-¦¬¦+¦¦¦¬ kcaptcha ¦¦TБTВTМ ¦¦TЙ¦¦ ¦- ¦¬¦-¦-TЛ¦¬¦¬ ¦¬¦-TА¦-¦¬TМ -----?>

<tr>
	<td></td>
	<td align="left" style="padding-top:10px"><input class="art-button" type=submit value="<?=$fields['submit']?>" name=send></td>
	
</tr>
</table>
</form>
</div>
<?//---- ¦Я¦-¦¬TП ¦¬¦-¦¬¦-¦¬¦-¦¦¦-¦¬TП -----------?>








<?/*





<div style="margin-top: 10px; margin-left: 20px;">
	<div>
	<form id="registerAjax" action="<?=base_url()?>auth/registration" method="POST">
		<div><?=$regMsg?></div>	
	
		<div><?=$this->validation->name_error;?></div>
		<div>¦дя¬-?¦Ю:</div>
		<div><input type="text" name="name" value="<?=$this->validation->name;?>" /></div>

		<div><?=$this->validation->username_error;?></div>
		<div>я¬-?¦-TП ¦¬¦-¦¬TМ¦¬¦-¦-¦-TВ¦¦¦¬TП:</div>
		<div><input type="text" name="username" value="<?=$this->validation->username;?>" /></div>
		
		<div><?=$this->validation->password_error;?></div>
		<div>¦Я¦-TА¦-¦¬TМ:</div>
		<div><input type="password" name="password" value="" /></div>
		
		<div>¦Я¦-¦-TВ¦-TА ¦¬¦-TА¦-¦¬TП:</div>
		<div><input type="password" name="password2" value="" /></div>
		
		<div><?=$this->validation->email_error;?></div>
		<div>Email:</div>
		<div><input type="text" name="email" value="<?=$this->validation->email;?>" /></div>

		<div><?=$this->validation->tel_error;?></div>
		<div>¦Ъ¦-¦-TВ¦-¦¦TВ¦-TЛ¦¦ TВ¦¦¦¬¦¦TД¦-¦-:</div>
		<div><input type="text" name="tel" value="<?=$this->validation->tel;?>" /></div>
		
		<div><?=$this->validation->code_error;?></div>
		<div>¦Ъ¦-¦+:</div>
		<div>
			<img id="registerCaptAjax" src="<?=base_url()?>auth/captcha/<?=rand(0, 999999999)?>" height="50" width="100" title="¦Ъ¦¬¦¬¦¦ ¦+¦¬TП ¦¬¦-¦-¦¦¦-TЛ" /><br />
			<input type="text" value="" maxlength="16" name="code" />
		</div>
		<div>
			<input type="submit" name="sub" value="¦Ч¦-TА¦¦¦¦¦¬TБTВTА¦¬TА¦-¦-¦-TВTМTБTП" />
		</div>
	</form>
	</div>
</div>

*/?>