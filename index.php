<?php
	define("CANNONICALROOTPATH", "./");
	include "./sessionManagement.php";

	if (isset($_SESSION["user"])) {
		if (isset($_SESSION["admin"])) {
			include "./cromosadmin_header.php";
		} else {
			include "./cromosuser_header.php";
		}
	} else {
		include "./cromos_header.php";
	}

	if (isset($_GET["error"]) && ($_GET["error"] == "timeout")) {
		echo '<script language="javascript">';
		echo 'alert("Superado el periodo de inactividad. Sesión cerrada. Pulse aceptar para continuar.")';
		echo '</script>';
	}
?>

<p>Contenido de la página índice</p>

<?php
	if (isset($_SESSION["user"])) {
		if (isset($_SESSION["admin"])) {
			include_once "./cromosadmin_footer.php";
		} else {
			include_once "./cromosuser_footer.php";
		}
	} else {
		include_once "./cromos_footer.php";
	}
?>
