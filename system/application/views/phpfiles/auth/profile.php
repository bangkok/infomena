<div style="width:80%; margin-top:10px; clear:left;">
<center><?=$message?></center>
<form name=send ENCTYPE="multipart/form-data" action="#add" method=post>
 <table width=60% border=0 cellpadding=1 cellspacing=5 class="table">
  

 <?// --------------------- Раздел Логин -------------------------?>
<tr>
	<td> <b><?=$fields['login']?>:</b></td>
	<td><b><?=$auth['login']?></b></td>
</tr>
<?// --------------------- Раздел Логин -------------------------?>
 
 
 <?// --------------------- Раздел ФИО --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->fio_error?><?}?></td></tr>
<tr>
	<td nowrap> <b><?=$fields['fio']?>:</b></td>
	
	<td width="100%"><input <?if($this->validation){?> value="<?=$this->validation->fio?>"<?}?> style="width:100%;" type=text name=fio maxlength=90></td>
</tr>
<?// --------------------- Раздел ФИО --------------------------?>


<?// --------------------- Раздел mail -------------------------?>
<tr>
	<td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->mail_error?><?}?></td>
</tr>
<tr>
	<td> <b><?=$fields['mail']?>:</b></td>
	
	<td><input <?if($this->validation){?> value="<?=$this->validation->mail?>"<?}?> style="width:100%;" type=text name=mail size=50 maxlength=50></td>
</tr>
<?// --------------------- Раздел mail -------------------------?>



<?// --------------------- Раздел Возраст --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->old_error?><?}?> <input value="1" type=hidden name=old></td></tr>
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
<?// --------------------- Раздел Возраст --------------------------?>



<?// --------------------- 1 Пароль --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->pass1_error?><?}?></td></tr>
<tr>
	<td nowrap> <b><?=$fields['newpass']?>:</b></td>
	
	<td width="100%"><input type="password"  value="" style="width:100%;" type=text name=pass1 maxlength=90></td>
</tr>
<?// --------------------- 1 Пароль --------------------------?>


<?// --------------------- 2 Пароль --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->pass2_error?><?}?></td></tr>
<tr>
	<td> <b><?=$fields['pass2']?>:</b></td>
	
	<td width="100%"><input  type="password"  value=""  style="width:100%;" type=text name=pass2 maxlength=90></td>
</tr>
<?// --------------------- 2 Пароль --------------------------?>


<tr>
	<th colspan=2 align="center"><input class="art-button" type=submit value="<?=$fields['change']?>" name=send></th>
</tr>
</table>
</form>
</div>