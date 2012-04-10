<?$this->lang->load('date', $this->data['lang']);?>
<p><?=date('d')?> <?=$this->lang->line(date('F'))?> <?=date('Y')?><?=$this->lang->line("date_year")?> <?date('Y-m-d')?></p>
<p><b><?=$this->lang->line($sign)?></b></p>
<?=$horo[$sign]?><br>