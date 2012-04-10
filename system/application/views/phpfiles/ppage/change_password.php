<?if(isset($change_password) && $change_password==true):?>
<form method="post">
	<table cellspacing="0" cellpadding="2" border="0" style="/*width: 400px;*/" class="data_table"><tbody>
				<tr><td colspan="2"><span id='error_oldpwd' class='ferr'><?if($this->validation){?><?=$this->validation->oldpwd_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['oldpwd']?>:</td><td><input type="password" name="oldpwd"></td></tr>
				<tr><td colspan="2"><span id='error_newpwd1' class='ferr'><?if($this->validation){?><?=$this->validation->newpwd1_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['newpwd1']?>:</td><td><input type="password" name="newpwd1"></td></tr>
				<tr><td colspan="2"><span id='error_newpwd2' class='ferr'><?if($this->validation){?><?=$this->validation->newpwd2_error?><?}?></span></td></tr>
		<tr><td class="gr"><?=$fields['newpwd2']?>:</td><td><input type="password" name="newpwd2"></td></tr>


		
<!--Капча-->
<tr><td align=right><span id='refresh_but'><?=$fields['torenew']?></span></td><td align=left><img class="captcha" src="/auth/captcha/<?=rand();?>" id='codimg'></td></tr>
<tr><td colspan="2"><span id='error_cod' class='ferr'><?if($this->validation){?><?=$this->validation->cod_error?><?}?></span></td></tr>
<tr><td class="gr"><?=$fields['cod']?>:<span id='error_cod' class='ferr'></span></td><td align=left><input type=text name=cod class=input id='cod' style="width:100px"></td></tr>
<!--/Капча-->
		<tr><td colspan="2"><input type="submit" class="button" value="<?=$fields['changepass']?>"></td></tr>
	</tbody></table>
	<input type="hidden" value="true" name="go">
</form>
<?else:?>
<?endif;?>