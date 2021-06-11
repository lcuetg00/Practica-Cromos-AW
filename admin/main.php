<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
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
