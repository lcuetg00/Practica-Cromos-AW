<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	include "../sqldatabase/conectarbd.php";
	include_once "./../debugops.php";

	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}
	include "../cromosuser_header.php";

	if (isset($_POST['input'])) {
		$idAlbum=$_POST['input'];
		if(usuarioTieneAlbumConId($mysqli,$_SESSION["dbId"],$idAlbum) == false) {
			$dineroSocio = $_SESSION["saldo"];
			$precioAlbum = recogerPrecioAlbum($mysqli,$idAlbum);
			if($dineroSocio>$precioAlbum) {
				$_SESSION["saldo"] = $dineroSocio-$precioAlbum;
				actualizarSaldoUsuario($mysqli,$_SESSION["dbId"],$_SESSION["saldo"]);
				comprarAlbumUsuario($mysqli,$_SESSION["dbId"],$idAlbum);
				echo "<script type='text/javascript'>alert('Album Comprado');</script>";
			} else {
				echo "<script type='text/javascript'>alert('No tienes puntos suficientes para comprar el album');</script>";
			}
		} else {
			echo "<script type='text/javascript'>alert('Ya tienes el album, no puedes comprar otro');</script>";
		}

	} else {
		mostrarColeccionesActivas($mysqli);
	}
?>





<?php
	include "../cromosuser_footer.php";

	function mostrarColeccionesActivas($mysqli) {
	  $arrayNombresIds = tomarNombresIdsColeccionesDisponibles($mysqli);
	  echo '<table id="tableColeccion" border="1">';
	  echo "<tr>";
	  echo "<td>Nombre</td>";
	  echo "<td>Precio</td>";
	  echo "<td></td>";
	  echo "<tr>";
	  for($i=0;$i<$arrayNombresIds['length'];$i++) {
			$result = recogerAlbumByIdColeccion($mysqli,$arrayNombresIds['ids'][$i]);
			$rowitem = mysqli_fetch_array($result);
			echo "<tr>";
	    echo "<td>" . $rowitem[COLUMNANOMBRE] . "</td>";
	    echo "<td>" . $rowitem['Precio'] . "</td>";
	    echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input hidden type=text name=input value=".  $rowitem['IdAlbum'] .">";
			echo "<input type=hidden name= flag value=1 >";
			echo "<input type=submit value=Comprar name=submit />";
			echo "</form>";
			echo "</td>";
	    echo "</tr>";
		}
	  echo "</table>";
	}

?>
