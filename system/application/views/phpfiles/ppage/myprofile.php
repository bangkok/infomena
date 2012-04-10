<table cellspacing="0" cellpadding="0" border="0" class="myprofile">
<tr>

	<td>
<!--LEFT TOP-->
		<table cellspacing="0" cellpadding="0" style="padding-right:10px">
		<tr><td width="100%">
			<table cellspacing="0" cellpadding="0"><tr>
				<td align="left" nowrap><a href="/ppage/change_avatar" style="font-size:9px">Изменить Фото</a></td>
				<td width="100%" align="left">
					<?$this->load->view('block/rating',array('rating'=>$user->rating))?>
					<div class="nickname"><?//=$user->soname?> <?=$user->name?></div></td>
				<td align="right" nowrap><a href="/ppage/change_password">Изменить пароль</a></td>
			</tr></table>
		</td></tr>
		<tr><td>
			<table cellspacing="0" cellpadding="0"><tr>
					<td align="left" valign="top">
					<div id="images"><img class="avatar" src=<?if($user->avatar):?>"/image/<?=$user->avatar?>.jpg/<?=rand();?>"<?else:?>"/img/default.png"<?endif;?>></img></div></td>
					<td width="100%" style="padding-left:10px; vertical-align:middle;">
					
					<table  cellspacing="0" cellpadding="0">
					
					<tr><td colspan="2">
						<table cellspacing="0" cellpadding="0"><tr>
						<td align="left"><span class="gr">Рейтинг сети:</span><?=$user->amount?></td>
						<td style="text-align: right;" nowrap><span class="gr">На счету:</span><b><span class="cost"><?=$user->info;?></span></b> <i><span class="info">info</span></i></td>
						</tr></table>
					</td></tr>	
<?if(isset($change_password) && $change_password==true):?>
		</td></tr><tr><td>
<?$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/change_password')?>
<?elseif(isset($change_avatar) && $change_avatar==true):?>
		</td></tr><tr><td>
<?$this->data['Content']['text']= $this->load->view($this->data['papka'].'/ppage/change_avatar')?>
<?endif;?>			
<form method="post" action="/ppage">				
					<tr><td style="padding-top:10px;">
							<select class="status" name="status" onchange='stat(this.value)'>
								<option class="first" value="">Выбрать статус</option>
								<option id='op_self' class="n" value="-1" <?if($user->status==-1){?>selected="selected"<?}?>>Свой вариант</option>
<?$i=0;foreach ($status as $s): $i++;	if($s->id != $user->status) $style = $selected = '';else {$selected = 'selected="selected"';}?>
								<option <?//=$style?> id = "op<?=$i?>" class="n" value="<?=$s->id?>" <?=$selected?>><?=$s->name?></option>
<?endforeach;?>
								
							</select><br>
						<input type="text" value="<?=$user->status_self?>" name="status_self" id='status_self' style="margin-top:5px; width:280px; <?if($user->status != -1){?>display:none<?}?>">	
					</td>
					<td></td>
					</tr>
					<tr>
						<td>
							<input type="text" onfocus="if (this.value=='Мой девиз (введите свой девиз)') {this.value=''}" onblur="if (this.value=='') { this.value='Мой девиз (введите свой девиз)'}" value="<?if(!empty($user->deviz)){?><?=$user->deviz?><?}else{?>Мой девиз (введите свой девиз)<?}?>" id="deviz" name="deviz">
						</td>
						<td style="vertical-align: bottom;"> 
						<!--<input type="submit" class="but" value="<?=$fields['OK']?>"> -->
						<input type="hidden" value="true" name="go">
						<INPUT TYPE=IMAGE  src="/img/ok.gif" VALUE="<?=$fields['OK']?>" style="color:#6172BA;text-decoration: underline;"> <!--<a href="#">OK</a>--></td>
					</tr>
</form>
					</table>
				<td></tr>
			</table>
		</td></tr>
		</table>
<!--END LEFT TOP-->
	</td>
	<td class="pereg_vert" width="10"></td>
	<td>
<!--RIGHT TOP-->
<?$this->load->view($this->data['papka'].'/ppage/edit_contacts')?>
<!--END RIGHT TOP-->
	</td>
</tr>
<tr>
	<td  style="padding-top:10px"><table style="padding-right:10px"><tr><td align="left" nowrap><b>Обо мне</b></td><td align="right"><a href="/ppage/edit_details">Редактировать</a></td></tr></table></td>
	<td  style="padding-top:10px"></td>
	<td  style="padding-top:10px"><table><tr><td align="left" nowrap><b>Общая информация</b></td><td align="right"><a href="/ppage/edit_general">Редактировать</a></td></tr></table></td>
</tr>
<tr>
	<td colspan="3" class="pereg_horiz" height="20"></td>
</tr>
<tr>
		
		<td>
<!--LEFT BOTTOM-->
<?$this->load->view($this->data['papka'].'/ppage/edit_details')?>
<!--END LEFT BOTTOM-->
		</td>
		<td class="pereg_vert" width="10"></td>
		<td>
<!--RIGHT BOTTOM-->
<?$this->load->view($this->data['papka'].'/ppage/edit_general')?>
<!--END RIGHT BOTTOM-->
		</td>
		
</tr>
</table>