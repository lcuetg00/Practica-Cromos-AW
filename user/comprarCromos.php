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
					actualizarCromoDisponiblesTienda($mysqli,$idCromo);
					comprarCromoUsuario($mysqli,$_SESSION["dbId"],$idCromo);
					echo "<script type='text/javascript'>alert('Se ha comprado el cromo');</script>";
				} else {
					echo "<script type='text/javascript'>alert('No tienes puntos suficiente para comprar el cromo');</script>";
				}
			} else {
				echo "No tienes el album de la colección, compra el album para poder guardar los cromos";
			}
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
	  echo "<td></td>";
	  echo "<tr>";
	  for($i=0;$i<$arrayNombresIds['length'];$i++) {
			echo "<tr>";
	    echo "<td>" . $arrayNombresIds['nombres'][$i] . "</td>";
	    echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input hidden type=text name=input value=". "Col" . $arrayNombresIds['ids'][$i] .">";
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
	    echo "<td>" . $rowitem['Precio'] . "</td>";
	    $image = $rowitem['Imagen'];
	    echo"<td>";
	      echo '<img width="150" height="210" src="data:image/jpg;base64,' . base64_encode( $image ) . '" />';
	    echo"</td>";
			echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input hidden type=text name=input value=". "Cro" . $rowitem[COLUMNAIDCROMO] ."-" . $idColeccion .">";
			echo "<input type=hidden name= flag value=1 >";
			echo "<input type=submit value=Comprar name=submit />";
			echo "</form>";
			echo "</td>";
	    echo "</tr>";
	  }
	  echo "</table>";
	}




?>
