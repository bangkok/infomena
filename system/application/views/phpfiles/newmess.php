<?if(!empty($MSG)) echo $MSG?>
<form method="POST">
<table class="form" cellpadding="0" cellspacing="0">
<tr><td class="field">Написать: </td><td><?=$user->nickname?></td></tr>
<tr><td class="valid" colspan="2"><?=$this->validation->theme_error?></td></tr>
<tr><td class="field">Тема: </td><td><input type="text" name="theme" value="<?=$this->validation->theme?>" size="50"></td></tr>
<tr><td class="valid" colspan="2"><?=$this->validation->message_error?></td></tr>
<tr><td class="field">Сообщение: </td><td><textarea name="message" rows="5"><?=$this->validation->message?></textarea></td></tr>
<tr><td></td><td><input type="submit" name="send" class="button" value="Отправить"></td></tr>
</table>
</form>