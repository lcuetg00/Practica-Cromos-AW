<?php
	session_start();
	define("CANNONICALROOTPATH", "./");
	if (isset($_SESSION["user"])) {
		include_once "./cromoslogged_header.php";
	} else {
		include_once "./cromos_header.php";
	}
?>

<p>Contenido de la página índice</p>

<?php
	if (isset($_SESSION["user"])) {
		include_once "./cromoslogged_footer.php";
	} else {
		include_once "./cromos_footer.php";
	}
?>
