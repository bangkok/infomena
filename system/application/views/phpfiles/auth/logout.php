<div>
	<h2><?=$content_title?></h2>
	
	<p>Вы залогинились: <b><?=$logDate?></b><br />
	Имя пользователя: <b><?=$user->login?></b><br />
	Email: <b><?=$user->email?></b></p>
	<div>
	<form id="authLogout" action="<?=base_url()?>auth/logout" method="POST">
		<input type="submit" name="sub" value="Выйти" />
	</form>
	</div>
</div>