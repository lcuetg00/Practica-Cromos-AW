<?php
	define("CANNONICALROOTPATH", "./../");
	session_start();
	if (!isset($_SESSION["admin"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosadmin_header.php";

	if (isset($_GET["status"]) && ($_GET["status"] == "updateSuccess")) {
		echo '<script language="javascript">';
		echo 'alert("Se ha realizado el cambio con éxito")';
		echo '</script>';
	}
	if (isset($_GET["status"]) && ($_GET["status"] == "updateError")) {
		echo '<script language="javascript">';
		echo 'alert("Se ha producido un error al realizar el cambio")';
		echo '</script>';
	}
?>

<p>Página principal del administrador</p>

<?php
	include "../cromosadmin_footer.php";
?>
