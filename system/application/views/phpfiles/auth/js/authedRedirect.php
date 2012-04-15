$("#muser").html('<span>Вы авторизованы как <strong><?=$user->login?></strong></span>: ');

$("#mlogin").hide();
$("#mlogout").show();
$("#mtools").show();
$("#muser").show();

$("#authf").html('');
$("#tools").html('');

$("#authf").dialog('close');
$("#tools").dialog('open');
$("#tools").show();

ajax.doLoad({
	block:'tools', method:'<?=$methodAfter?>', loadInfo:'<?=$info?>',
	param: new Array(new Array(''),0),
	hist:true, infoBlock:'tools', controller:'<?=$controllerAfter?>'});
	
