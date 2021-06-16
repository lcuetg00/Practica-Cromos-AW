<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	include "../sqldatabase/conectarbd.php";
	//include_once "./../debugops.php";

	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}
	include "../cromosuser_header.php";

	function mostrarColeccionesActivas($mysqli) {
	  $arrayNombresIds = tomarNombresIdsColecciones($mysqli);
	  echo '<table id="tableColeccion" border="1">';
	  echo '<h3>Comprar álbums</h3>';
	  for($i=0;$i<$arrayNombresIds['length'];$i++) {
			$result = recogerAlbumByIdColeccion($mysqli,$arrayNombresIds['ids'][$i]);
			$rowitem = mysqli_fetch_array($result);
			echo "<tr>";
	    echo "<td>" . $rowitem[COLUMNANOMBRE] . "</td>";
	    echo "<td>" . $rowitem['Precio'] . " puntos</td>";
	    echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input type=hidden name=input value=".  $rowitem['IdAlbum'] .">";
			echo "<input type=hidden name= flag value=1 >";
			echo "<input type=submit value=Comprar name=submit />";
			echo "</form>";
			echo "</td>";
	    echo "</tr>";
		}
	  echo "</table>";
	}

	echo '<div class="content"><div class="vContainerCenteredContents">';
	$mysqli = connectToDatabase();
	if (isset($_POST['input'])) {
		$idAlbum=$_POST['input'];
		if(usuarioTieneAlbumConId($mysqli,$_SESSION["dbId"],$idAlbum) == false) {
			$dineroSocio = $_SESSION["saldo"];
			$precioAlbum = recogerPrecioAlbum($mysqli,$idAlbum);
			if($dineroSocio>$precioAlbum) {
				$_SESSION["saldo"] = $dineroSocio-$precioAlbum;
				actualizarSaldoUsuario($mysqli,$_SESSION["dbId"],$_SESSION["saldo"]);
				comprarAlbumUsuario($mysqli,$_SESSION["dbId"],$idAlbum);
				unset($_POST);
				header("location: ./comprar.php?status=albumExitoCompra");
				exit();
			} else {
				unset($_POST);
				header("location: ./comprar.php?status=albumSaldoInsuf");
				exit();
			}
		} else {
			unset($_POST);
			header("location: ./comprar.php?status=albumYaComprado");
			exit();
		}

	} else {
		mostrarColeccionesActivas($mysqli);
	}
	closeConnection($mysqli);
	echo '</div></div>'
?>


<?php
	include "../cromosuser_footer.php";
?>
