<div style="width:100%">
<?if(isset($message) && !empty($message)):?><h2><?=$message?></h2><?else:?><?=$content?><?endif;?>
<p>&nbsp;</p>
<form name=horo_set action="#set" method=post>
<!--<input type="checkbox" name="horo[enabled]" value="y" <?if($settings['enabled'] == "y")echo "checked";?>><?=$this->lang->line('enabled')?><br><br>
-->
<?//print_r($settings)?>
<?foreach($settings as $key => $item):?>
	<input type="checkbox" name="horo[<?=$key?>]" value="y" <?if($item == "y")echo "checked";?>><?=$this->lang->line($key)?><br>
	<?if($key == 'enabled'):?><br><?endif;?>
<?endforeach?>
<input class="art-button" type=submit value="<?=$this->lang->line('select')?>" name=send>
</form>
</div>