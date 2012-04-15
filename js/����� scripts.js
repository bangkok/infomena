$(document).ready(function(){
    $.blockUI.defaults = { 
    message:  '<h1></h1>', 
    css: { 
        padding:        0, 
        margin:         0, 
        width:          '30%', 
        top:            '40%', 
        left:           '35%', 
        textAlign:      'center', 
        color:          '#000', 
        border:         '3px solid #aaa', 
        backgroundColor:'#f2f5fa', 
        cursor:         'default' 
    }, 
    overlayCSS:  { 
        backgroundColor: '#000', 
        opacity:         0.3 
    }, 
    growlCSS: { 
        width:    '350px', 
        top:      '10px', 
        left:     '', 
        right:    '10px', 
        border:   'none', 
        padding:  '5px', 
        opacity:   0.6, 
        cursor:    null, 
        color:    '#fff', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius':    '10px' 
    }, 
    iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank', 
    forceIframe: false, 
    baseZ: 100, 
    centerX: true, 
    centerY: true, 
    allowBodyStretch: true, 
    bindEvents: true, 
    constrainTabKey: true, 
    fadeIn:  200, 
    fadeOut:  400, 
    timeout: 0, 
    showOverlay: true, 
    focusInput: true, 
    applyPlatformOpacityRules: true, 
    onUnblock: null, 
    quirksmodeOffsetHack: 4 
}; 
		$('#plus').hover(function(){$('#plus_content').toggle();},function(){$('#plus_content').toggle();})
		$('#plus').click(bookmark);
		$('#regt').live('click',reg_form);
		$('#regt3').live('click',reg_form);
		$('#reg_open_but').live('click',reg_but_open);
		$('#pwd_remind').live('click',pwd_remind);
		$('#main_search_predl').click(function(){
			$('#radio1').attr('src','/images/radio_bga.png');
			$('#radio0').attr('src','/images/radio_bg.png');
			$('#form_type').val('1');
		});
		$('#main_search_spros').click(function(){
			$('#radio0').attr('src','/images/radio_bga.png');
			$('#radio1').attr('src','/images/radio_bg.png');
			$('#form_type').val('0');
		});
		$('#regt2').click(function(){
		if ($('#regc_img').attr('src')=='/images/top_open.png') 
		{reg_but_open();$('#regc_img').attr('src','/images/top_close.png');} else
		 {
		query = $("#auth").serialize();
		$.post('/ajax_features/auth.php',query,function(data){
					$('#ajax').html(data);
					$.blockUI({ message: $('#ajax'), css: { width: '450px',top:'10px' } });
					$('#regall').load('/ajax_features/update_auth_block.php');
					$.growlUI('Вы успешно вошли в систему', '');
					$('#but_close').click($.unblockUI);
					//$('#exit').click(logout);
					$('#reg_open_but').click(reg_but_open);
					});
		 }
		});
		$('#exit').live('click',logout);
		$('#exit2').live('click',logout);
		

				
});
function pwd_remind()
{
	$.blockUI({ message: $('#ajax').load('/ajax_features/pwd_remind.php','',pwd_succ), css: { width: '450px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
}
function reg_form()
{
	$.blockUI({ message: $('#ajax').load('/ajax_features/register','',reg_succ), css: { width: '450px',top:'10px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
}
function calc_open()
{
	$.blockUI({ message: $('#ajax').load('/ajax_features/calc.php','',reg_succ), css: { width: '350px',top:'80px' } });
	$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
}
function reg_but_open()
{
	$('#regc').slideToggle();
	$('#reg').slideToggle();
	if ($('#regc_img').attr('src')=='/images/top_open.png') 
	$('#regc_img').attr('src','/images/top_close.png'); else $('#regc_img').attr('src','/images/top_open.png');
}
function logout()
{
	$.get('/ajax_features/out.php','',function(){
				$('#regall').load('/ajax_features/update_auth_block.php');
				$.growlUI('Выход из системы', 'Вы успешно вышли изсистемы.');
				});
}
function pwd_succ()
{
	$('#but_close').click($.unblockUI);	
	$('#but_send').click(function(){
			he=0;
			cod=$('#cod').val();
			$.get('/ajax_features/cod_check.php?text='+cod,'',
			function(data){ 
				if (data==0) {$('#error_cod').html('Вы неправильно ввели код на картинке');$('#error_cod').css('display','block');he=1;}
			});
						
		if (!he) 
			{
				email=$('#email').val();
				$.get('/ajax_features/pwd_remind.php?email='+email,'',function(data){
					$('#ajax').html(data);
					$('#but_close').click($.unblockUI);
				});
			}
	});
	
	$('#refresh_but').click(function(){
		sid=$('#sid').val();
		sname=$('#sname').val();
		rid=Math.floor(Math.random()*1000000);
		
		$('#codimg').attr('src','/auth/captcha/'+sname+'='+sid+'&r='+rid);
		});
		
		
		
} 
function reg_succ()
{
	$('#country').autocomplete('/ajax_features/autocomplete.php', {
    delay:10,
    minChars:2,
    matchSubset:1,
    autoFill:true,
    maxItemsToShow:10
    });
	$('#town').autocomplete('/ajax_features/autocomplete_town.php', {
    delay:10,
    minChars:2,
    matchSubset:1,
    autoFill:true,
    maxItemsToShow:10
    });
	$('#region').autocomplete('/ajax_features/autocomplete_region.php', {
    delay:10,
    minChars:2,
    matchSubset:1,
    autoFill:true,
    maxItemsToShow:10
    });
	$('#refresh_but').click(function(){
		sid=$('#sid').val();
		sname=$('#sname').val();
		rid=Math.floor(Math.random()*1000000);
		$('#codimg').attr('src','/auth/captcha/'+sname+'='+sid+'&r='+rid);
	})
	$('#regbut').click(function(){
			he=0;
			/*
			if ($('#nam').val()=='') {$('#error_nam').html('Вы не указали свое имя');he=1;} else {$('#error_nam').html('');}
			if ($('#fam').val()=='') {$('#error_fam').html('Вы не указали свою фамилию');he=1} else {$('#error_fam').html('');}
			if ($('#email').val()=='') {$('#error_email').html('Вы не указали email');he=1;} else {$('#error_email').html('');}
			if ($('#country').val()=='') {$('#error_country').html('Вы не указали страну');he=1;} else {$('#error_country').html('');}
			if ($('#region').val()=='') {$('#error_region').html('Вы не указали регион');he=1;} else {$('#error_region').html('');}
			if ($('#town').val()=='') {$('#error_town').html('Вы не указали город');he=1;} else {$('#error_town').html('');}
			cod=$('#cod').val();
			$.get('/ajax_features/cod_check.php?text='+cod,'',

			function(data){ 
				if (data==0) {$('#error_cod').html('Вы неправильно ввели код на картинке');$('#error_cod').css('display','block');he=1;}
			});
			if ($('#p1').val()=='') {$('#error_p1').html('Вы не указали пароль');he=1;} else
			{
				if ($('#p1').val()!=$('#p2').val()) {$('#error_p1').html('Введенные пароли не совпадают');he=1;} else {$('#error_p1').html('');}
			}
			//*/
		if (!he) 
			{
				query = $("#reg_form").serialize();
				//alert(query);
				$.post('/ajax_features/register',query,function(data){
					$('#ajax').html(data);
					
					$('#but_close').click($.unblockUI);
				});
			}
		
	});
	$('#but_close').click($.unblockUI);							
}
function bookmark(){
 var url = window.document.location;
 var title = window.document.title;
 a=document.getElementById('plus');
 if ($.browser.msie  && 9 > $.browser.version && $.browser.version >= 4) window.external.AddFavorite(url,title);
 else if ($.browser.opera) {
  a.href = url;
  a.rel = "sidebar";
  a.title = url+','+title;
  return true;
 }
 else if ($.browser.mozilla) window.sidebar.addPanel(title,url,"");
 else {
		$.blockUI({ message: "<p>Для того, чтобы добавить эту страницу в закладки, нажмите <b>Сtrl+D</b></p>" });
		$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
	  }
 return false;
}
function change_country()
{
	c=$('#scountry').val();
	$('#cregion').load('/ajax_features/change_region.php?country='+c);
}
function change_region()
{
	c=$('#sregion').val();
	$('#ctown').load('/ajax_features/change_town.php?region='+c);
}
function change_cur()
{
	c=$('#valuta').val();
	$('#cur').html(c);
}
function change_oplata(p)
{
	c=$('#oplata').val();
	$('#fplus').toggle();
	$('#cur').toggle();
	$('#valuta').toggle();
	$('#p2').toggle();
	if (p) $('#p2').val('');
	calc_sum();
}
function calc_sum()
{
	p1=$('#p1').val();
	p2=$('#p2').val();
	p1=p1-0;
	p2=p2-0;
	p3=(p1+p2)*0.05;
	$('#pcom').val(p3);
	ppay=parseFloat(p1+p3);
	$('#ppay').val(ppay);
}



