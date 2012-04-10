<?php 
function isparent($CUR1,$id)
{
	while(isset($CUR1['id'])){
		if ($CUR1['id'] == $id) return true;
		if (isset($CUR1['parent'])) $CUR1 = $CUR1['parent'];
		else break;
	}
	return false;
}
?>