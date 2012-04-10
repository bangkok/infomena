<div class="loginHead">Вы авторизованы как:</div>
<form method="post" name="authLogin" id="authLogin">
	<div style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px; font-size: 0.7em;">
		Время аторизации:
			<div style="margin-left: 10px; font-weight: bold;"><?=$logDate?></div>
		Имя пользователя:
			<div style="margin-left: 10px; font-weight: bold;"><?=$userData->login?></div>
		Имя:
			<div style="margin-left: 10px; font-weight: bold;"><?=$userData->name?></div>
		Email: 
			<div style="margin-left: 10px; font-weight: bold;"><?=$userData->email?></div>
	</div>
	<div style="margin-top: 5px; font-size: 0.7em; font-family: arial, sans-serif;">
		<a href="/auth/logout" style="text-decoration: none; color: #294d80" id="logoutBtn">Выйти</a> 
		| 
		<a href="/auth/profile" style="text-decoration: none; color: #294d80" id="editBtn">Редактировать данные</a>
	</div>
</form>
