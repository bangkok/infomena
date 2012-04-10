<script type="text/javascript">


</script>

<div class='but_close'><img src='/images/close_button.png'></div>
					<form method='post' id='reg_form'>
					<table cellspacing=0 cellpadding=2 border=0 id='regf'>
<tr><td><img src='/images/slogo.png'></td><td align=left><span class='head'>Забыли пароль?</span></td></tr>
<tr><td colspan="2"><center><?=$message?></center></td></tr>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->pass1_error?><?}?></td></tr>
<tr><td nowrap> <b><?=$fields['newpass']?>:</b></td><td width="100%"><input type="password"  value="" style="width:100%;" type=text name=pass1></td></tr>
<tr><td valign="bottom" colspan="2" align="center" nowrap><?if($this->validation){?><?=$this->validation->pass2_error?><?}?></td></tr>
<tr><td> <b><?=$fields['pass2']?>:</b></td>	<td width="100%"><input  type="password"  value=""  style="width:100%;" type=text name=pass2 maxlength=90></td></tr>
<tr><th colspan=2 align="center"><input id='newpassword_send' class="submit" type=submit value="<?=$fields['submit']?>" name=send></th></tr>

					</table>
					</form>