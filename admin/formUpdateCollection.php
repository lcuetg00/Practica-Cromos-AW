<?php
	define("CANNONICALROOTPATH", "./../");
	session_start();
	if (!isset($_SESSION["admin"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosadmin_header.php";

	include "./../sqldatabase/conectarbd.php";
	// Si el administrador realizó previamente una petición mediante formulario de cambio de cantidad de cartas disponibles.
	if (isset($_POST["submit"])) {
		$db = connectToDatabase();
		for ($i = 0; $i < $_POST["numCromos"]; $i++) {
			actualizarCromoDisponiblesTienda($db, $_POST["id" . $i], $_POST["uds" . $i]);
		}
		closeConnection($db);
		unset($_POST);
		header("location: ./main.php?status=updateSuccess");
		exit();
	}

	// Si el administrador aún no envió su petición, se generan los controles apropiados:
	if (!isset($_GET["collection"])) {
		// Si el administrador aún no ha elegido, se le ofrecerá una lista con colecciones que editar.
		$db = connectToDatabase();
		$dd = tomarNombresIdsColecciones($db);
		$nombres = $dd["nombres"];
		$ids = $dd["ids"];
		$numColecciones = count($nombres);
		if ($numColecciones == 0) {
			echo 'La base de datos no contiene ninguna coleccion';
		} else {
			for ($i = 0; $i < $numColecciones; $i++) {
				echo '<a href="./formUpdateCollection.php?collection='.$ids[$i].'">'.$nombres[$i].' (id: '.$ids[$i].')</a></br>';
			}
		}
		closeConnection($db);
	} else {
		// El administrador podrá editar la colección previamente seleccionada.
		$db = connectToDatabase();
		$result = recogerCromosColeccion($mysqli,$_GET["collection"]);
		$numCromos = 0;
		$htmlCromos = "";
		while($rowitem = mysqli_fetch_array($result)) {
			$htmlCromos = $htmlCromos .
					'<input type="number" name="id'.$numCromos.'" readonly value="'.$rowitem["IdCromo"].'"></input>
					<input type="text" readonly value="'.$rowitem["Nombre"].'"></input>
					<input type="number" readonly value="'.$rowitem["Precio"].'"></input>
					<input type="number" name="uds'.$numCromos.'" min="0" value="'.$rowitem["UnidadesDisponibles"].'"></input></br>';
			$numCromos++;
		}

		echo '<form  enctype="multipart/form-data" method="POST" action="'.$_SERVER['PHP_SELF'].'">
			<div>
				Id de la colección:
				<input name="idColeccionNumber" type="number" readonly value="'.$_GET["collection"].'"></input>
			</div>
			<div>
				Número de cromos diferentes:
				<input name="numCromos" name="numCromosNumber" type="number" readonly value="'.$numCromos.'"></input>
			</div>
			<div> ID - Nombre - Precio - Cantidad disponible</div>
			<div id="divCromos">' . $htmlCromos . '</div>
			<input type="submit" name="submit"></input>
		</form>';

		closeConnection($db);
	}

?>



<?php
	include "../cromosadmin_footer.php";
?>
