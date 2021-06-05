<?php
	include_once "cromos_header.php"
?>

<section class="login-form">
	<h2>Login</h2>
	<div class="login-form-form">
		<form action="user/dologin.php" method="post">
			Nombre: <input type="text" name="user"></input></br>
			Contraseña: <input type="text" name="password"></input></br>
			<button type="submit" name="submit">Acceder</button></br>
		</form>
	</div>
</section>

<?php
	include_once "cromos_footer.php"
?>
