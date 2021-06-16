<?php
	define("CANNONICALROOTPATH", "./");
	include "./sessionManagement.php";

	if (isset($_SESSION["user"])) {
		header("location: ./index.php");
		exit();
	}

	include "./cromos_header.php";
?>

<form class="login" action="dologin.php" method="post">
	<div class="vContainer">
		<img src="img/avatar.png" alt="Avatar" class="avatar"></img>
		<h3>INICIAR SESION</h3>
	</div>
	<div class="vContainer">
		<label for="user">Nombre de usuario:</label>
		<input type="text" placeholder="Introduce tu nombre de usuario" name="user" required></input>

		<label for="password">Contraseña:</label>
		<input type="password" placeholder="Introduce tu contraseña" name="password" required></input>

		<button type="submit" name ="submit">Iniciar Sesión</button>
	</div>
	<div class="vContainer">
		<button type="button" class="flashyButton" onclick="history.back()">Volver</button>
	</div>
</form>

<?php
	include "./cromos_footer.php";

	if (isset($_GET["error"])) {
		switch ($_GET["error"]) {
			case "userNotSet";
				echo '<script language="javascript">';
				echo 'alert("El campo usuario está incompleto")';
				echo '</script>';
				break;
			case "passwordNotSet";
				echo '<script language="javascript">';
				echo 'alert("El campo contraseña está incompleto")';
				echo '</script>';
				break;
			case "userPasswordInvalid";
				echo '<script language="javascript">';
				echo 'alert("El usuario y/o la contraseña no existen en la base de datos")';
				echo '</script>';
				break;
		}
	}
?>
