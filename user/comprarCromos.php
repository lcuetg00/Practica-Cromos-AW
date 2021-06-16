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

		echo '<div class="content"><div class="vContainerCenteredContents">';
	$mysqli = connectToDatabase();
	if (isset($_POST['input'])) {
		$input = substr($_POST['input'],0,3);
		$value = substr($_POST['input'],3,strlen($_POST['input']));
		if($input == "Col") { //Se pide para ver una coleccion
			mostrarCromosColeccionDisponibles($mysqli,$value);
		} else { //Se va a comprar un cromo
			$idColeccion = substr($value,(strpos($value, '-')+1),strlen($value));
			$idCromo = substr($value,0,strpos($value, '-'));
			//comprobar si tiene el Album
			if(usuarioTieneAlbum($mysqli,$_SESSION["dbId"],$idColeccion) == true) {
				//Comprobar si tiene dinero para pagarlo
				$dineroSocio = $_SESSION["saldo"];
				$precioCromo = recogerPrecioCromo($mysqli,$idCromo);
				if($dineroSocio>$precioCromo) {
					$_SESSION["saldo"] = $dineroSocio-$precioCromo;
					actualizarSaldoUsuario($mysqli,$_SESSION["dbId"],$_SESSION["saldo"]);
					disminuirUnaUnidadCromoDisponibleTienda($mysqli,$idCromo);
					comprarCromoUsuario($mysqli,$_SESSION["dbId"],$idCromo);
					unset($_POST);
					header("location: ./comprar.php?status=cromoExitoCompra");
					exit();
				} else {
					unset($_POST);
					header("location: ./comprar.php?status=cromoSaldoInsuf");
					exit();
				}
			} else {
				unset($_POST);
				header("location: ./comprar.php?status=cromoNoAlbum");
				exit();
			}
		}
	} else {
		mostrarColeccionesActivas($mysqli);
	}
	closeConnection($mysqli);
	echo '</div></div>'
?>





<?php
	include "../cromosuser_footer.php";

	function mostrarColeccionesActivas($mysqli) {
	  $arrayNombresIds = tomarNombresIdsColeccionesDisponibles($mysqli);
	  echo '<h3>Comprar cromos</h3>';
	  echo '<table id="tableColeccion" border="1">';
	  for($i=0;$i<$arrayNombresIds['length'];$i++) {
			echo "<tr>";
	    echo "<td>Cromos " . $arrayNombresIds['nombres'][$i] . "</td>";
	    echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input type=hidden name=input value=". "Col" . $arrayNombresIds['ids'][$i] .">";
			echo "<input type=hidden name= flag value=1 >";
			echo "<input type=submit value=Comprar name=submit />";
			echo "</form>";
			echo "</td>";
	    echo "</tr>";
		}
	  echo "</table>";
	}

	function mostrarCromosColeccionDisponibles($mysqli,$idColeccion) {
	  $result = recogerCromosColeccionDisponibles($mysqli,$idColeccion);
	  echo '<table id="tableCromos" border="1">';
	  echo "<tr>";
	  echo "<td>Nombre</td>";
	  echo "<td>Unidades Disponibles</td>";
	  echo "<td>Precio</td>";
	  echo "<td>Imagen</td>";
		echo "<td></td>";
	  echo "<tr>";
	  while($rowitem = mysqli_fetch_array($result)) {
	    echo "<tr>";
	    echo "<td>" . $rowitem[COLUMNANOMBRE] . "</td>";
	    echo "<td>" . $rowitem[COLUMNAUNIDADESDISPONIBLES] . "</td>";
	    echo "<td>" . $rowitem['Precio'] . " puntos</td>";
	    $image = $rowitem['Imagen'];
	    echo"<td>";
	      echo '<img width="150" height="210" src="data:image/jpg;base64,' . base64_encode( $image ) . '" />';
	    echo"</td>";
			echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input type=hidden name=input value=". "Cro" . $rowitem[COLUMNAIDCROMO] ."-" . $idColeccion ."></input>";
			echo "<input type=hidden name= flag value=1 ></input>";
			echo "<input type=submit value=Comprar name=submit /></input>";
			echo "</form>";
			echo "</td>";
	    echo "</tr>";
	  }
	  echo "</table>";
	}




?>
