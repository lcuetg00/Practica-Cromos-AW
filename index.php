<?php
	define("CANNONICALROOTPATH", "./");
		include "./debugops.php";
	include "./sessionManagement.php";
		include "./dataFiles/filefunctions.php";
		include "./sqldatabase/conectarbd.php";

	if (isset($_SESSION["dbId"])) {
		include "./cromosuser_header.php";
	} else if (isset($_SESSION["admin"])) {
		include "./cromosadmin_header.php";
	} else {
		include "./cromos_header.php";
	}

	if (isset($_GET["error"]) && ($_GET["error"] == "timeout")) {
		echo '<script language="javascript">';
		echo 'alert("Superado el periodo de inactividad. Sesión cerrada. Pulse aceptar para continuar.")';
		echo '</script>';
	}
	if (isset($_GET["error"]) && ($_GET["error"] == "dbConnectionError")) {
		echo '<script language="javascript">';
		echo 'alert("Error de conexión con el servidor. Si ha realizado operaciones y/o cambios recientes, estos pueden no haberse realizado y/o almacenado.")';
		echo '</script>';
	}
?>

<p>Contenido de la página índice</p>

<?php
	if (isset($_SESSION["dbId"])) {
		include "./cromosuser_footer.php";
	} else if (isset($_SESSION["admin"])) {
		include "./cromosadmin_footer.php";
	} else {
		include "./cromos_footer.php";
	}
?>
