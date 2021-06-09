<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/config_cromos.php";
	include_once "cromos_header.php"
?>

<section class="signup-form">
	<h2>Sign Up</h2>
	<div class="signup-form-form">
		<form action="dologin.php" method="post">
			Nombre: <input type="text" name="user"></input></br>
			Contraseña: <input type="text" name="password"></input></br>
			Contraseña (de nuevo): <input type="text" name="password2"></input></br>
			<button type="submit" name="submit">Registrar</button></br>
		</form>
	</div>
	<?php
		if (isset($_GET["error"])) {
			switch ($_GET["error"]) {
				case "userNotSet";
					echo "<p>El campo usuario está incompleto</p>";
				break;
				case "passwordNotSet";
					echo "<p>El campo contraseña está incompleto</p>";
				break;
				case "userInvalid";
					echo "<p>El campo usuario debe contener de 4 a 16 caracteres alfadecimales y debe empezar por una letra</p>";
				break;
				case "passwordInvalid";
					echo "<p>El campo contraseña debe contener de 6 a 16 caracteres alfadecimales incluídos \"! ? . -\" y debe empezar por una letra</p>";
				break;
				case "userAlreadyExists";
					echo "<p>El usuario introducido ya existe</p>";
				break;
				case "";
					echo "<p></p>";
				break;
			}
		}
	 ?>
</section>


<?php
	include_once "cromos_footer.php"
?>
