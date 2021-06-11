<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	if (!isset($_SESSION["user"]) ||
			isset($_SESSION["admin"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosuser_header.php";
?>

<p>Página principal del usuario</p>

<?php
	include "../cromosuser_footer.php";
?>
