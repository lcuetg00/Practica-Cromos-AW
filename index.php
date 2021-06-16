<?php
	define("CANNONICALROOTPATH", "./");
		//include "./debugops.php";
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


<div class="content">
	<div class="vContainerCenteredContents">
		<h1>Bienvenido a TodoCromos.com</h1>
		<div style="padding:30px 0"></div>
		<div class="vContainerCenteredContents">
			<h2>2021-06-22: Novedades</h2>
			<p>Celebración de un <a class="href" href="./eventos.php">nuevo torneo</a>.</p>
		</div>
		<div style="padding:20px 0"></div>
		<div class="vContainerCenteredContents">
			<h2>2021-06-18: Novedades</h2>
			<p>Presentación de las nuevas colecciones.</p>
		</div>
		<div style="padding:20px 0"></div>
		<div class="vContainerCenteredContents">
			<h2>2021-06-16: Novedades</h2>
			<p>Apertura de la página web.</p>
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
