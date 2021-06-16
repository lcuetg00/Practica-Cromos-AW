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

	function addButtons($numTablas) {
		echo '<div class="hContainer">
				<input type=button onclick=onClickPrevious() id=prev style="width:20px;" value="<"></input>
				<input type=number style="width:40px;" numTablas="'.$numTablas.'" id=num readonly value=1></input>
				<input type=button onclick=onClickNext() id=next style="width:20px;" value=">"></input>
				</div>';
	}
	function mostrarAlbunesUsuario($mysqli,$idSocio) {
	  $result = recogerAlbunesUsuario($mysqli,$idSocio);
	  echo '<table class="fitContent" id="tableAlbum" border="1">';
	  while($rowitem = mysqli_fetch_array($result)) {
	    //Esto hay que hacerlo porque poseealbum no tiene ni el nombre ni el id de la coleccion
	    $buscarDatosAlbum = recogerAlbumById($mysqli,$rowitem['IdAlbum']);
	    $filaAlbum = mysqli_fetch_array($buscarDatosAlbum);
	    $idColeccionAlbum = $filaAlbum[COLUMNAIDCOLECCION];
	    echo "<tr>";
	    echo "<td>" . $filaAlbum[COLUMNANOMBRE] . "</td>";
		echo "<td>" . recogerEstadoColeccion($mysqli, $filaAlbum[COLUMNAIDCOLECCION], $idSocio) . "</td>";
	    echo "<td>";
			echo "<form method=POST action=" . $_SERVER['PHP_SELF'] .">";
			echo "<input type=hidden name=input value=". $filaAlbum[COLUMNAIDCOLECCION] ."></input>";
			echo "<input type=hidden name=flag value=1></input>";
			echo "<input type=submit value=Acceder name=submit></input>";
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
	  $i = 0;
	  echo '<div style="margin: 10px auto 10px auto">';
	  while ($m < $numCromosColeccion) {
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
	              echo '<p>Cantidad: '. $rowitem['Cantidad'] . '</p>';
	            echo"</td>";
	            $rowitem = mysqli_fetch_array($result);
			} else if ($m < $numCromosColeccion) {
	            echo"<td>";
	              echo '<div style="padding:130px 75px"></div>';
	            echo"</td>";
			} else {
	            echo"<td>";
	              echo '<div style="padding:130px 75px; background-color:black;"></div>';
	            echo"</td>";
			}
  			$m++;
	      }
	      echo "</tr>";
	    }
	    echo "</table>";
		$i++;
	}
	  echo '</div>';
	  return $i;
	}

	echo '<div class="content"><div class="vContainerCenteredContents">';
	echo '<h2>VER COLECCIÓN</h2>';
	$mysqli = connectToDatabase();
	if (isset($_POST['input'])) {
		$numTablas = crearTablasAlbum($mysqli, $_SESSION["dbId"],$_POST["input"]);
		if ($numTablas > 1) {
			addButtons($numTablas);
		}
	} else {
		mostrarAlbunesUsuario($mysqli, $_SESSION["dbId"]);
	}
	closeConnection($mysqli);
	echo '</div></div>'
?>

<script>
	var bPrev = document.getElementById("prev");
	var iNum = document.getElementById("num");
	var bNext = document.getElementById("next");
	var numTablas = iNum.getAttribute("numTablas");
	var currentTabla = 0;
	bPrev.disabled = true;
	function onClickPrevious() {
		document.getElementById(currentTabla).setAttribute("hidden", "");
		iNum.value--;
		currentTabla--;
		if (currentTabla == 0) {
			bPrev.disabled = true;
		}
		bNext.disabled = false;
		document.getElementById(currentTabla).removeAttribute("hidden");
	}
	function onClickNext() {
		document.getElementById(currentTabla).setAttribute("hidden", "");
		iNum.value++;
		currentTabla++;
		if (currentTabla == numTablas-1) {
			bNext.disabled = true;
		}
		bPrev.disabled = false;
		document.getElementById(currentTabla).removeAttribute("hidden");
	}
</script>

<?php
	include "../cromosuser_footer.php";
?>
