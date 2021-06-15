<?php
	define("CANNONICALROOTPATH", "./../");
	session_start();
	if (!isset($_SESSION["admin"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosadmin_header.php";

	if (isset($_POST["submit"])) {
		include "./../sqldatabase/conectarbd.php";

		//echo '<pre>'; print_r($_FILES); echo '</pre>';
		$nombreColeccion = $_POST["nombreColeccionText"];
		$precioAlbum = $_POST["precioAlbumNumber"];
		$nombres = array();
		$precios = array();
		$cantidades = array();
		$imagenes = array();
		for ($i = 0; $i < $_POST["numCromosNumber"]; $i++) {
			$nombres[$i] = $_POST["cromoNombre" . $i];
			$precios[$i] = $_POST["cromoPrecio" . $i];
			$cantidades[$i] = $_POST["cromoUds" . $i];
			$imagenes[$i] = file_get_contents($_FILES['cromoImg' . $i]['tmp_name']);
		}

		insertarColeccionAlbum($nombreColeccion, $nombres, $precios, $cantidades, $imagenes, $precioAlbum);
		unset($_POST);
		header("location: ./main.php?status=updateSuccess");
		exit();
	}
?>

<form  enctype="multipart/form-data" method="POST" action=" <?php echo $_SERVER['PHP_SELF']; ?>">
	<div>
		Nombre de la colección:
		<input name="nombreColeccionText" type="text"></input>
	</div>
	<div>
		Precio del album:
		<input name="precioAlbumNumber" type="number" min="0"></input>
	</div>
	<div>
		Diseño del album:
		<input name="disennioAlbumText" type="text" readonly value="3x3"></input>
	</div>
	<div>
		Número de cromos:
		<input id="idNumCromos" name="numCromosNumber" type="number" min="1"></input>
		<input 					name="numCromosButton" type="button" value="Actualizar" onclick="onClickUpdateCromos()"></input>
	</div>
	<div> Nombre - Precio - Cantidad disponible - Imagen </div>
	<div id="divCromos"></div>
	<input type="submit" name="submit"></input>
</form>

<script>
	function onClickUpdateCromos() {
		let divFormCromos = document.getElementById("divCromos");
		while (divFormCromos.firstChild) { // Limpiar el contenedor de componentes antiguos.
			divFormCromos.removeChild(divFormCromos.lastChild);
		}
		for(let i=0; i<document.getElementById("idNumCromos").value; i++) { // Reconstruir la parte variable del formulario.
			let div = document.createElement("div");

			let inputDiv = document.createElement("input");
			console.log("cromoNombre" + i);
			inputDiv.setAttribute("name", "cromoNombre" + i);
			inputDiv.setAttribute("type", "text");
			div.appendChild(inputDiv);

			inputDiv = document.createElement("input");
			inputDiv.setAttribute("name", "cromoPrecio" + i);
			inputDiv.setAttribute("type", "number");
			inputDiv.setAttribute("step", "0.01");
			inputDiv.setAttribute("min", "0");
			div.appendChild(inputDiv);

			inputDiv = document.createElement("input");
			inputDiv.setAttribute("name", "cromoUds" + i);
			inputDiv.setAttribute("type", "number");
			inputDiv.setAttribute("min", "0");
			div.appendChild(inputDiv);

			inputDiv = document.createElement("input");
			inputDiv.setAttribute("name", "cromoImg" + i);
			inputDiv.setAttribute("id", "cromoImg" + i);
			inputDiv.setAttribute("type", "file");
			inputDiv.setAttribute("accept", "image/*");
			div.appendChild(inputDiv);

			divFormCromos.appendChild(div);
		}
	}
</script>

<?php
	include "../cromosadmin_footer.php";
?>
