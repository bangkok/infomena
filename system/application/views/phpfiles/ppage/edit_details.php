<?if(isset($edit_details) && $edit_details==true):?>
<form method='post' action="/ppage/edit_details" enctype="multipart/form-data">
											<table cellspacing=0 cellpadding=0 border=0 class='data_table'>
												<tr><td><textarea name=detailed_info cols=50 rows=6 style="width:100%"><?=$user->detailed_info?></textarea></td></tr>
												<tr><td><input type=submit value='Обновить' class='button'></td></tr>
											</table>
											<input type=hidden name=go value=true>
										  </form>
<?else:?>
<?=$user->detailed_info?>
<?endif;?>