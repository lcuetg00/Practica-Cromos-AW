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
		crearTablasAlbum($mysqli,$_SESSION["dbId"],$_POST["input"]);
		addButtons();
	} else {
		mostrarAlbunesUsuario($mysqli,$_SESSION["dbId"]);
	}
?>



<script>
	function onClick() {
		let iNum = document.getElementById("num");
		document.getElementById(iNum.value).setAttribute("hidden", "");
		iNum.value = (iNum.value + 1) % 3;
		document.getElementById(iNum.value).removeAttribute("hidden");
	}
</script>

<?php
	include "../cromosuser_footer.php";

	function addButtons() {
		echo "<input type=number id=num readonly value=0></input>";
		echo "<input type=button onclick=onClick() value=cambiar></input>";
	}
	function mostrarAlbunesUsuario($mysqli,$idSocio) {
	  $result = recogerAlbunesUsuario($mysqli,$idSocio);
	  echo '<table id="tableAlbum" border="1">';
	  echo "<tr>";
	  echo "<td>Nombre</td>";
	  echo "<td>Acceder Album</td>";
	  echo "<tr>";
	  while($rowitem = mysqli_fetch_array($result)) {
	    //Esto hay que hacerlo porque poseealbum no tiene ni el nombre ni el id de la coleccion
	    $buscarDatosAlbum = recogerAlbumById($mysqli,$rowitem['IdAlbum']);
	    $filaAlbum = mysqli_fetch_array($buscarDatosAlbum);
	    $idColeccionAlbum = $filaAlbum[COLUMNAIDCOLECCION];
	    echo "<tr>";
	    echo "<td>" . $filaAlbum[COLUMNANOMBRE] . "</td>";
	    echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input hidden type=text name=input value=". $filaAlbum[COLUMNAIDCOLECCION] .">";
			echo "<input type=hidden name= flag value=1 >";
			echo "<input type=submit value=Resolver name=submit />";
			echo "</form>";
			echo "</td>";
	    echo "</tr>";
	  }
	  echo "</table>";
	}

	function crearTablasAlbum($mysqli,$idSocio,$idColeccion) {
	  $numCromosColeccion = recogerNumeroCromosColeccion($mysqli, $idColeccion);
	  $numPaginas = intdiv($numCromosColeccion,9);
	  if(fmod($numCromosColeccion,9) && $numCromosColeccion>9) { //Si hay resto, le sumamos una pagina mas
	    $numPaginas++;
	  }
	  $idInicial = recogerIndiceInicialCromoColeccion($mysqli, $idColeccion);
	  $result = recogerCromosUsuarioColeccion($mysqli,$idSocio,$idColeccion);
	  $m=0;
	  $rowitem = mysqli_fetch_array($result);
	  for($i = 0; $rowitem != null; $i++){
	    if($i==0) {
	      echo '<table id="'. $i .'" border="1">';
	    } else {
	      echo '<table hidden id="'. $i .'" border="1">';
	    }
	    for($j=0;$j<3;$j++) { //cartas por fila
	      echo "<tr>";
	      for($k=0;$k<3;$k++) {
	          if(isset($rowitem) && $m == ($rowitem['IdCromo']-$idInicial)) {
	            $datosCromo =  mysqli_fetch_array(recogerCromoById($mysqli,$rowitem[COLUMNAIDCROMO]));
	            $imagen= $datosCromo['Imagen'];
	            echo"<td>";
	              echo '<img width="150" height="210" src="data:image/jpg;base64,' . base64_encode( $imagen ) . '" />';
	              echo '<p>Cantidad: '. $datosCromo['UnidadesDisponibles'] . '</p>';
	            echo"</td>";
	            $rowitem = mysqli_fetch_array($result);
	          } else {
	            echo"<td>";
	              echo '<div style="padding:130px 75px"></div>';
	            echo"</td>";
	          }
  			$m++;
	      }
	      echo "</tr>";
	    }
	    echo "</table>";
	  }
	}
?>
