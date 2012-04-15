function logout()
{
//	alert($("#authLogin").find("input[name='login']").val());
	ajax.doLoad({
		block:'loginning', method:'logoutAjax', loadInfo:'<img style="margin-top: 10px;" src="/img/indicator.gif" />',
		param:{'sub':'log'}, 
		hist:true, infoBlock:'loginning', controller:'auth'});
}

$("#authLogin").submit(function(){
	logout();
	return false;
});

$("#logoutBtn").click(function(){
	logout();
	return false;
});