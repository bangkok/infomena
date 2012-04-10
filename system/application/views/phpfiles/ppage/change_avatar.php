<?if(isset($change_avatar) && $change_avatar==true):?>
<form enctype="multipart/form-data" action="/ppage/change_avatar" method="post">
											<table cellspacing="0" cellpadding="2" border="0" class="data_table" style="margin:0;">
												<tbody>
												<tr>
												<td style="text-align:left">Выберите изображение:</td>
												
												</tr><tr><td style="text-align:left">
												<!--
												<input type="file" onchange="alert(this.value);" name="avatar" accept="image/jpeg, image/png, image/gif" size="20">
												-->
												<table style="width:auto"><tr><td>
												<div id="uploadButton" style="z-index:-100"></div>
												 </td><td>
												 <input type="submit" class="button" value="Подтвердить<?//=$fields['download']?>">
												 </td></tr></table>
												 
												 </td></tr>
												 <div id="status"></div>
												 <!--<div id="images"></div>-->
												
											</tbody></table>

											<input type="hidden" value="true" name="go">
										  </form>
<?else:?>
<?endif;?>