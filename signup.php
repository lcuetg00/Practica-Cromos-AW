<?php
    define("CANNONICALROOTPATH", "./");
    include "./sessionManagement.php";

    if (isset($_SESSION["user"])) {
	    header("location: ./index.php");
	    exit();
    }

    include "./cromos_header.php";
?>

<form class="signup" action="dosignup.php" method="post">
	<div class="vContainer">
		<img src="img/avatar.png" alt="Avatar" class="avatar"></img>
		<h3>REGISTRO</h3>
	</div>
	<div class="vContainer">
		<label for="user">Nombre de usuario:</label>
		<input type="text" placeholder="Introduce tu nombre de usuario" name="user" required></input>

		<label for="password">Contrase&ntilde;a:</label>
		<input type="text" placeholder="Introduce tu contrase&ntilde;a" name="password" required></input>

		<label for="passwordrep">Vuelve a introducir la contrase&ntilde;a:</label>
		<input type="text" placeholder="Vuelve a introducir la contrase&ntilde;a" name="passwordrep" required></input>

		<button type="submit" name="submit">Crear cuenta</button>
	</div>
	<div class="vContainer">
		<button type="button" class="flashyButton" onclick="history.back()">Volver</button>
	</div>
</form>

<?php
    include "cromos_footer.php";

	if (isset($_GET["error"])) {
		switch ($_GET["error"]) {
			case "passwordDoesntMatch":
				echo '<script language="javascript">';
				echo 'alert("Las contrase&ntilde;as no coinciden")';
				echo '</script>';
				break;
			case "userInvalid";
				echo '<script language="javascript">';
				echo 'alert("El campo usuario debe contener de 4 a 16 caracteres alfadecimales y debe empezar por una letra")';
				echo '</script>';
				break;
			case "passwordInvalid";
				echo '<script language="javascript">';
				echo 'alert("El campo contrase&ntilde;a debe contener de 6 a 16 caracteres alfadecimales, inclu�dos \"! ? . -\"")';
				echo '</script>';
				break;
			case "passwordUnsafe";
				echo '<script language="javascript">';
				echo 'alert("La contrase&ntilde;a introducida no es lo suficientemente segura")';
				echo '</script>';
				break;
			case "userAlreadyExists";
				echo '<script language="javascript">';
				echo 'alert("El usuario introducido ya existe")';
				echo '</script>';
				break;
		}
	}
?>
