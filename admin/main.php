<?php
	define("CANNONICALROOTPATH", "./../");
	session_start();
	if (!isset($_SESSION["admin"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosadmin_header.php";
?>

<p>Página principal del administrador</p>

<?php
	include "../cromosadmin_footer.php";
?>
