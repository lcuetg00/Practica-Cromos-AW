<?php
	define("CANNONICALROOTPATH", "./");
	include "./sessionManagement.php";

	if (isset($_SESSION["dbId"])) {
		include "./cromosuser_header.php";
	} else if (isset($_SESSION["admin"])) {
		include "./cromosadmin_header.php";
	} else {
		include "./cromos_header.php";
	}
?>

<div class="content">
	<div class="vContainerCenteredContents">
		<h1>Eventos</h1>
		<div style="padding:15px 0"></div>
		<div class="vContainerCenteredContents">
			<h2>2021-06-22 Torneo de cartas</h2>
			<p>Lugar: (por determinar)</p>
			<p>Hora: (por determinar)</p>
			<p>Sets permitidos: (por determinar)</p>
			<p>Participantes: (por determinar)</p>
		</div>
		<div style="padding:20px 0"></div>
	</div>
</div>

<?php
	if (isset($_SESSION["dbId"])) {
		include "./cromosuser_footer.php";
	} else if (isset($_SESSION["admin"])) {
		include "./cromosadmin_footer.php";
	} else {
		include "./cromos_footer.php";
	}
?>
