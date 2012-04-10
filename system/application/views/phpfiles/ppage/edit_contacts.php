<?if(isset($edit_contacts) && $edit_contacts==true):?>
<?=$message?>
<form method='post' action="/ppage/edit_contacts">
	<table cellspacing=0 cellpadding=2 border=0 class='data_table' style="/*width:300px;*/">
	<tr><td class="gr"><?=$fields['email']?>:</td><td width="100%"><?=$user->email?></td></tr>
	<tr><td colspan="2"><span id='error_tel' class='ferr'><?if($this->validation){?><?=$this->validation->tel_error?><?}?></span></td></tr>
	<tr><td class="gr"><?=$fields['tel']?>:</td><td align=left><input type=text name=tel value="<?=$user->tel?>"></td></tr>
		<tr><td colspan="2"><span id='error_mtel' class='ferr'><?if($this->validation){?><?=$this->validation->mtel_error?><?}?></span></td></tr>
	<tr><td class="gr"><?=$fields['mtel']?>:</td><td align=left><input type=text name=mtel value="<?=$user->mtel?>"></td></tr>
		<tr><td colspan="2"><span id='error_icq' class='ferr'><?if($this->validation){?><?=$this->validation->icq_error?><?}?></span></td></tr>
	<tr><td class="gr"><?=$fields['icq']?>:</td><td align=left><input type=text name=icq value="<?=$user->icq?>"></td></tr>
		<tr><td colspan="2"><span id='error_skype' class='ferr'><?if($this->validation){?><?=$this->validation->skype_error?><?}?></span></td></tr>
	<tr><td class="gr"><?=$fields['skype']?>:</td><td align=left><input type=text name=skype value="<?=$user->skype?>"></td></tr>
		<tr><td colspan="2"><span id='error_url' class='ferr'><?if($this->validation){?><?=$this->validation->url_error?><?}?></span></td></tr>
	<tr><td class="gr"><?=$fields['url']?>:</td><td align=left><input type=text name=url value="<?=$user->url?>"></td></tr>
		<tr><td></td><td><input type=submit value='<?=$fields['torenew']?>' class='button'></td></tr>

	</table>
	<input type=hidden name=go value=true>
</form>
<?else:?>
		<table>
		<tr>
			<td align="left"><b>Мои контакты</b></td>
			<td style="text-align: right;"><a href="/ppage/edit_contacts">Редактировать</a></td>
		</tr>
		<tr>
			<td colspan="2">
			<table cellspacing="0" cellpadding="0" align="left">
				<tr><td class="gr"><?=$fields['email']?>:</td><td width="100%"><?=$user->email?></td></tr>
				<tr><td class="gr"><?=$fields['tel']?>:</td><td width="100%"><?=$user->tel?></td></tr>
				<tr><td class="gr"><?=$fields['mtel']?>:</td><td><?=$user->mtel?></td></tr>
				<tr><td class="gr"><?=$fields['icq']?>:</td><td><?=$user->icq?></td></tr>
				<tr><td class="gr"><?=$fields['skype']?>:</td><td><?=$user->skype?></td></tr>
				<tr><td class="gr"><?=$fields['url']?>:</td><td><a href="http://<?=str_ireplace("http://",'',$user->url)?>" target="_blank"><?=$user->url?></a></td></tr>
			</table>
			</td>
		</tr>
		</table>
<?endif;?>
