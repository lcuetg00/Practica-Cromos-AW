<?php
	session_start();
	define("CANNONICALROOTPATH", "./");
	if (isset($_SESSION["user"])) {
		header("location: ./index.php");
		exit();
	}
	include_once "./cromos_header.php";
?>

<section class="login-form">
	<h2>Login</h2>
	<div class="login-form-form">
		<form action="dologin.php" method="post">
			Nombre: <input type="text" name="user"></input></br>
			Contraseña: <input type="text" name="password"></input></br>
			<button type="submit" name="submit">Acceder</button></br>
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
				case "userPasswordInvalid";
					echo "<p>El usuario y/o la contraseña no existen en la base de datos</p>";
				break;
			}
		}
	 ?>
</section>


<?php
	include_once "./cromos_footer.php"
?>
