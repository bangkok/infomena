function log()
{
//	alert($("#authLogin").find("input[name='login']").val());
	ajax.doLoad({
		block:'loginning', method:'loginAjax', loadInfo:'<img style="margin-top: 10px;" src="/img/indicator.gif" />',
		param:
			{	'login':$("#authLogin").find("input[name='login']").val(),
				'passwd':$("#authLogin").find("input[name='passwd']").val(),
				'sub':'log'
			}, 
		hist:true, infoBlock:'loginning', controller:'auth'});
}

$("#authLogin").submit(function(){
	log();
	return false;
});

$("#loginBtn").click(function(){
	log();
	return false;
});