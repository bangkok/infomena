<?if(isset($Catalog) && !empty($Catalog)){?><?
$predl=$spros= "";
if(!empty($Type)){
	if($Type=='predl') $predl=" checked";
	if($Type=='spros') $spros=" checked";
}else {$Type = 'predl';$predl=" checked";}
$cont['name'] = '<span class="art"><input type="checkbox" name="predl" id="catpredl" onclick="catalog();"'.$predl.'>Предложения <input type="checkbox" name="spros" id="catspros" onclick="catalog();"'.$spros.'>Спрос</span>';
if(!empty($ShowCatalog))$cont['name'] = 'Каталог: '.$cont['name'];
$cont['text'] = $this->load->view('block/catalog','',true);
?>
<?if(!empty($ShowCatalog)){?><td class='right' id="catalogblock"><?=$this->load->view('block/block', $cont)?></td>
<?}else{?>
<div id="catalogblock"><?=$this->load->view('block/fixedblock', $cont)?></div><?}?><?}?>
