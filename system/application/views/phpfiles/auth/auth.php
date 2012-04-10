<?=$message?>

<?if (!isset($auth)||!is_array($auth)):?>
<div style="margin-top:15px;">
<form name=feed onSubmit="" action="/auth/login" method=post>    
 <table width=300 border=0 cellpadding=1 cellspacing=5 class="table">

<?// --------------------- Раздел Логин -------------------------?>
<tr>
	<td valign="bottom" colspan="2" align="center" nowrap><?if(isset($this->validation)&&$this->validation){?><?=$this->validation->login_error?><?}?></td>
</tr>
<tr>
	<td> <b><?=$fields['login']?>:</b></td>
	
	<td><input <?if(isset($this->validation)&&$this->validation){?> value="<?=$this->validation->login?>"<?}?> style="width:100%;" type=text name=login size=50 maxlength=50></td>
</tr>
<?// --------------------- Раздел Логин -------------------------?>


<?// --------------------- 1 Пароль --------------------------?>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if(isset($this->validation)&&$this->validation){?><?=$this->validation->pass_error?><?}?></td></tr>
<tr>
	<td nowrap> <b><?=$fields['pass']?>:</b></td>
	
	<td width="100%"><input type="password"  value="" style="width:100%;" type=text name=pass maxlength=90></td>
</tr>
<?// --------------------- 1 Пароль --------------------------?>

<tr>
	<th colspan=2 align="right"><input class="art-button" type=submit value="<?=$fields['enter']?>" name=send></th>
</tr>

<tr>
	<th colspan=2 align="right">
	<div  style="font-size:11px;margin-top:5px;">
	    <a  href="/auth/register">Регистрация</a>
		&nbsp;|&nbsp;
		<a href="/auth/forgot">Забыл пароль</a>
	</div>
	
	</th>
</tr>
</table>
</form>
</div>

<?endif;?>









	