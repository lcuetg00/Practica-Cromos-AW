<?php
	include_once "cromos_header.php"
?>

<section class="signup-form">
	<h2>Sign Up</h2>
	<div class="signup-form-form">
		<form action="user/dologin.php" method="post">
			Nombre: <input type="text" name="user"></input></br>
			Contraseña: <input type="text" name="password"></input></br>
			Contraseña (de nuevo): <input type="text" name="password2"></input></br>
			<button type="submit" name="submit">Registrar</button></br>
		</form>
	</div>
</section>

<?php
	include_once "cromos_footer.php"
?>
