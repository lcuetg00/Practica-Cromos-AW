<?php
	session_start();
	define("CANNONICALROOTPATH", "./../");
	if (!isset($_SESSION["user"])) {
		header("location: ../index.php");
		exit();
	}
	include_once "../cromoslogged_header.php";
?>

<p>Página principal del usuario</p>

<?php
	include_once "../cromoslogged_footer.php";
?>
