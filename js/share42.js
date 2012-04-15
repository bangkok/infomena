/*
 * http://share42.com
 * Date: 09.04.2011
 * (c) 2011, Dimox
 */
function share42(f,u,t){
	if(!u)u=location.href;
	if(!t)t=document.title;u=encodeURIComponent(u);
	t=encodeURIComponent(t);
	var s=new Array(
	'"#" onclick="window.open(\'http://vkontakte.ru/share.php?url='+u+'\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=554, height=421, toolbar=0, status=0\');return false" title="Поделиться В Контакте"',
	'"http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl='+u+'&title='+t+'" title="Добавить в Одноклассники"',
	'"http://www.facebook.com/sharer.php?u='+u+'&t='+t+'" title="Поделиться в Facebook"',
	'"http://twitter.com/share?text='+t+'&url='+u+'" title="Добавить в Twitter"',
	'"http://connect.mail.ru/share?url='+u+'&title='+t+'" title="Поделиться в Моем Мире@Mail.Ru"',
	'"http://zakladki.yandex.ru/newlink.xml?url='+u+'&name='+t+'" title="Добавить в Яндекс.Закладки"'
	
	/*
	'"http://www.facebook.com/sharer.php?u='+u+'&t='+t+'" title="Поделиться в Facebook"',
	'"http://connect.mail.ru/share?url='+u+'&title='+t+'" title="Поделиться в Моем Мире@Mail.Ru"',
	'"http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl='+u+'&title='+t+'" title="Добавить в Одноклассники"',
	'"http://twitter.com/share?text='+t+'&url='+u+'" title="Добавить в Twitter"',
	'"#" onclick="window.open(\'http://vkontakte.ru/share.php?url='+u+'\', \'_blank\', \'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=554, height=421, toolbar=0, status=0\');return false" title="Поделиться В Контакте"',
	'"http://zakladki.yandex.ru/newlink.xml?url='+u+'&name='+t+'" title="Добавить в Яндекс.Закладки"'
	*/);
	var img=new Array(
			"ico_vkontakte.gif",
			"ico_odnoklas.gif",
			"ico_facebook.gif",
			"ico_twi.gif",
			"mailru.gif",			
			"ya.gif"
			);
	for(i=0;i<s.length;i++)
		document.write('<div class="icon"><a rel="nofollow" href='+s[i]+' target="_blank"><img src="/images/blocks/'+img[i]+'"></a></div>')

}
