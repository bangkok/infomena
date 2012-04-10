
<script type="text/javascript">
reg_form();
/*
	$.blockUI({ message: $('#ajax').load('/ajax_features/newpassword/<?=$user?>/<?=$code?>' ,pwd_succ), css: { width: '470px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
	*/
</script>
<div style="width:80%; margin-top:10px; clear:left;">
<center><?=$message?></center>
<form name=send action="#add" method=post>
 <table width=60% border=0 cellpadding=1 cellspacing=5 class="table">
  

 
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
	<th colspan=2 align="center"><input class="submit" type=submit value="<?=$fields['submit']?>" name=send></th>
</tr>
</table>
</form>
</div>