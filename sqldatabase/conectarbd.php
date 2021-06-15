<?php

define("DBDB", "cromos");
define("DBUSER", "root");
define("DBPASSWORD", "");


define("COLUMNAIDSOCIO","IdSocio");
define("COLUMNASALDOSOCIO","Saldo");

define("COLUMNAIDCOLECCION","IdColeccion");
define("COLUMNAIDCROMO","IdCromo");
define("COLUMNAESTADO","Estado");

define("COLUMNANOMBRE","Nombre");
define("COLUMNAUNIDADESDISPONIBLES","UnidadesDisponibles");
define("COLUMNAIMAGEN","Imagen");

function connectToDatabase() {
  $mysqli = new mysqli('localhost', DBUSER, DBPASSWORD, DBDB) or die("No se puede conectar");

 //Comprobamos si se conecta bien a la base de datos:
  if (mysqli_connect_errno()) {
    echo "Error al conectarse a la base de datos";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit();
  }
 return $mysqli;
}
function closeConnection($mysqli) {
  $mysqli -> close();
}

function insertarAlbum($mysqli, $nombreAlbum, $precio, $idColeccion) { // Returns: IdSocio del socio insertado.
  $sql = "INSERT INTO album(IdAlbum, Nombre, Precio, IdColeccion) VALUES (null,$nombreAlbum,$precio,$idColeccion)";
  $mysqli->query($sql);
}

function insertarUsuario($mysqli) { // Returns: IdSocio del socio insertado.
  $sql = "INSERT INTO socio (IdSocio, Saldo) VALUES (null,0)";
  $mysqli->query($sql);
  $sql = "SELECT * FROM socio ORDER BY IdSocio DESC";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  return $row[COLUMNAIDSOCIO];
}

function insertarColeccion($nombreColeccion, $nombres, $precios, $cantidades, $imagenes) {
	$mysqli = connectToDatabase();
    $sql = "INSERT INTO coleccion(IdColeccion, Estado,Nombre) VALUES (null,'Activo','$nombreColeccion')";
    if ($mysqli->query($sql) === TRUE) { //recogemos el id nuevo para asignarle los cromos
      $result = $mysqli->query("SELECT * FROM coleccion ORDER BY IdColeccion DESC");
      $row = $result->fetch_assoc();
      $idColeccion = $row[COLUMNAIDCOLECCION];
	  closeConnection($mysqli);
	  $db = new PDO("mysql:host=localhost;dbname=cromos", DBUSER, DBPASSWORD);
      for($i=0;$i<count($nombres);$i++) {
		  $stmt = $db->prepare("INSERT INTO cromo(IdCromo, Nombre,UnidadesDisponibles,Imagen,Precio,IdColeccion) VALUES (null,?,?,?,?,?)");
		  $stmt->bindParam(1, $nombres[$i]);
		  $stmt->bindParam(2, $cantidades[$i]);
		  $stmt->bindParam(3, $imagenes[$i]);
		  $stmt->bindParam(4, $precios[$i]);
		  $stmt->bindParam(5, $row[COLUMNAIDCOLECCION]);
		  $stmt->execute();
      }
    } else {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
	  closeConnection($mysqli);
    }
}
function tomarNombresIdsColecciones($mysqli) { // Returns: Array ("nombres" => Array con los nombres, "ids" => Array con los ids, "length" => Int numero de elementos totales)
  $sql = "SELECT * FROM coleccion";
  $result = $mysqli->query($sql);
  $ids = array();
  $nombres = array();
  $i=0;
  $j=0;
  while ($row = $result->fetch_assoc()) {
    foreach($row as $key => $value){
       if($key=='IdColeccion') {
         $ids[$i] = $row['IdColeccion'];
         $i++;
       }
       if($key=='Nombre') {
         $nombres[$j] = $row['Nombre'];
         $j++;
       }
     }
  }
  return array("nombres" => $nombres, "ids" => $ids, "length" => $i);
}



function tomarNombresIdsColeccionesDisponibles($mysqli) {
  $sql = "SELECT * FROM coleccion WHERE IdColeccion IN (SELECT IdColeccion FROM cromo WHERE UnidadesDisponibles>0)";
  $result = $mysqli->query($sql);
  $ids = array();
  $nombres = array();
  $i=0;
  $j=0;
  while ($row = $result->fetch_assoc()) {
    foreach($row as $key => $value){
       if($key=='IdColeccion') {
         $ids[$i] = $row['IdColeccion'];
         $i++;
       }
       if($key=='Nombre') {
         $nombres[$j] = $row['Nombre'];
         $j++;
       }
     }
  }
  return array("nombres" => $nombres, "ids" => $ids, "length" => $i);
}

//function tomarNombresIdsColeccionesDisponibles($mysqli) { // Returns: Array ("nombres" => Array con los nombres, "ids" => Array con los ids)
//  $result = $mysqli->query($sql);

//	$data = tomarNombresIdsColecciones($mysqli);
//	$tNames = $data["nombres"];
//	$tIds = $data["ids"];
//    $ns = array();
//    $is = array();
//	$j = 0;
//	for ($i = 0; $i < $data["length"]; $i++) {
//		if (true) { // Solo si la colección con id $ids[$i] tiene cartas por vender,
//	  	    $ns[$j] = $tNames[$i];
//	  	    $is[$j] = $tIds[$i];
//			$j++;
//		}
//	}
//    return array("nombres" => $ns, "ids" => $is, "length" => $j);
//}

function recogerSaldoUsuario($mysqli,$idSocio) {  // Returns: Saldo del usuario.
  $sql = "SELECT Saldo FROM socio WHERE IdSocio = $idSocio";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  return $row[COLUMNASALDOSOCIO];
}

function actualizarSaldoUsuario($mysqli,$idSocio,$nuevoSaldo) {
  $sql = "UPDATE socio SET Saldo=$nuevoSaldo WHERE IdSocio = $idSocio";
  $mysqli->query($sql);
}

function recogerCromosColeccion($mysqli,$idColeccion) { // Returns: Conjunto de filas de elementos "cromo"
  $sql = "SELECT * FROM cromo WHERE IdColeccion=$idColeccion ORDER BY IdCromo ASC";
  $result = $mysqli->query($sql);
  return $result;
}
//Recoge todos los cromos que tengan unidades disponibles de una coleccion
function recogerCromosColeccionDisponibles($mysqli,$idColeccion) { // Returns: Conjunto de filas de elementos "cromo"
  $sql = "SELECT * FROM cromo WHERE UnidadesDisponibles>0 AND IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  return $result;
}
function coleccionDisponeDeCromos($mysqli,$idColeccion) { // Returns: true si la colección tiene cromos que vender, false si no.
  $sql = "SELECT * FROM cromo WHERE UnidadesDisponibles>0 AND IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  if ($row = $result->fetch_assoc()) {
	  return true;
  }
  return false;
}

function actualizarCromoDisponiblesTienda($mysqli,$idCromo) {
  $sql = "UPDATE cromo SET UnidadesDisponibles=UnidadesDisponibles-1 WHERE IdCromo = $idCromo";
  $mysqli->query($sql);
}
function actualizarCromoUsuario($mysqli,$idSocio,$idCromo,$nuevaCantidad) {
  $sql = "UPDATE poseecromo SET Cantidad=$nuevaCantidad WHERE IdSocio = $idSocio AND IdCromo = $idCromo";
  $mysqli->query($sql);
}
function incrementarCromoUsuario($mysqli,$idSocio,$idCromo) {
  $sql = "UPDATE poseecromo SET Cantidad=Cantidad+1 WHERE IdSocio = $idSocio AND IdCromo = $idCromo";
  $mysqli->query($sql);
}

function comprarCromoUsuario($mysqli,$idSocio,$idCromo) {
  $sql = "SELECT * FROM poseecromo WHERE IdSocio=$idSocio AND IdCromo=$idCromo";
  $result = $mysqli->query($sql);
  if($result->num_rows == 0) { //No tiene el cromo, le insertamos una unidad
    $sql = "INSERT INTO poseecromo(IdCromo,IdSocio,Cantidad) VALUES ('$idCromo','$idSocio',1)";
    $mysqli->query($sql);
  } else { //Lo incrementamos en una unidad;
    incrementarCromoUsuario($mysqli,$idSocio,$idCromo);
  }
}

function comprarAlbumUsuario($mysqli,$idSocio,$idAlbum) {
  $sql = "INSERT INTO poseealbum(IdAlbum,IdSocio) VALUES ('$idAlbum','$idSocio')";
  $mysqli->query($sql);
}

/*
function actualizarEstadoColeccion($mysqli,$idColeccion,$estado) {
  if($estado==true) {
    $sql = "UPDATE coleccion SET Estado='Activo' WHERE IdColeccion = $idColeccion";
  } else {
    $sql = "UPDATE coleccion SET Estado='Inactivo' WHERE IdColeccion = $idColeccion";
  }
  if ($mysqli->query($sql) === TRUE) {
    echo "Actualizado Correctamente";
  } else {
    echo "Error al actualizar: " . $mysqli->error;
  }
}
*/

//function recogerDatosAlbunes($mysqli) { //Metodo para consultar los albunes (prueba)
//  $sql = "SELECT * FROM album";
//  $result = $mysqli->query($sql);

// while ($row = $result->fetch_assoc()) {
//   foreach($row as $key => $value){
//      echo $key . " " . $value .";";
//    }
//    echo "<br>";
// }
//}


function recogerIndiceInicialCromoColeccion($mysqli, $idColeccion) {
  $sql = "SELECT * FROM cromo WHERE IdColeccion=$idColeccion ORDER BY IdCromo ASC";
  $result = $mysqli->query($sql);
  $row = mysqli_fetch_array($result);
  return $row[COLUMNAIDCROMO];
}

function recogerNumeroCromosColeccion($mysqli, $idColeccion) {
  $sql = "SELECT * FROM cromo WHERE IdColeccion=$idColeccion";
  $resultadoColeccion = $mysqli->query($sql);
  $numeroCromosColeccion = $resultadoColeccion->num_rows;
  return $numeroCromosColeccion;
}

function recogerEstadoColeccion($mysqli, $idColeccion, $idSocio) {
  $numeroCromosColeccion = recogerNumeroCromosColeccion($mysqli, $idColeccion);

  $sql = "SELECT * FROM poseecromo WHERE IdSocio=$idSocio";
  $resultadoSocio = $mysqli->query($sql);
  $numeroCromosSocio = $resultadoSocio->num_rows;

  if($numeroCromosSocio == 0) {
    return "No Iniciada";
  }
  if($numeroCromosSocio != $numeroCromosColeccion) {
    return "Completada Parcialmente";
  }
  if($numeroCromosSocio == $numeroCromosColeccion) {
    return "Completada";
  }
}

//Esto es una funcion de prueba. Recojo una imagen de la base
//de datos y la muestro (probado con una unica entrada en la base de datos)
//function recogerImagenesCromos($mysqli) {
  //$sql = "SELECT * FROM cromo";
  //$result = $mysqli->query($sql);
  //$numLineas = $result->num_rows;

  //while ($row = $result->fetch_assoc()) {
    //$imageDataString = base64_encode($row['Imagen']);
    //$image = base64_decode($imageDataString);
  //}
  //header("content-type: image/jpeg");

//  echo $image;
//}

function recogerDatosColecciones($mysqli) {
  $sql = "SELECT * FROM coleccion";
  $result = $mysqli->query($sql);
  return $result;
}

function recogerDatosCromos($mysqli) {
  $sql = "SELECT * FROM cromo";
  $result = $mysqli->query($sql);
  $numLineas = $result->num_rows;

  while ($row = $result->fetch_assoc()) {
    echo json_encode($row[COLUMNANOMBRE]);
  }
}

function recogerPrecioCromo($mysqli,$idCromo) {
  $sql = "SELECT * FROM cromo WHERE IdCromo=$idCromo";
  $result = $mysqli->query($sql);
  $row = mysqli_fetch_array($result);
  return $row['Precio'];
}

function recogerPrecioAlbum($mysqli,$idAlbum) {
  $sql = "SELECT * FROM album WHERE IdAlbum=$idAlbum";
  $result = $mysqli->query($sql);
  $row = mysqli_fetch_array($result);
  return $row['Precio'];
}

function usuarioTieneAlbum($mysqli,$idSocio,$idColeccion) {
  $sql = "SELECT * FROM album WHERE IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  $row = mysqli_fetch_array($result);
  $idAlbum = $row['IdAlbum'];
  $sqlBuscarAlbum = "SELECT * FROM poseealbum WHERE IdSocio=$idSocio AND IdAlbum=$idAlbum";
  $result2 = $mysqli->query($sqlBuscarAlbum);
  $numLineas = $result2->num_rows;
  if($numLineas==0) {
    return false;
  } else {
    return true;
  }
}

  function usuarioTieneAlbumConId($mysqli,$idSocio,$idAlbum) {
  $sqlBuscarAlbum = "SELECT * FROM poseealbum WHERE IdSocio=$idSocio AND IdAlbum=$idAlbum";
  $result2 = $mysqli->query($sqlBuscarAlbum);
  $numLineas = $result2->num_rows;
  if($numLineas==0) {
    return false;
  } else {
    return true;
  }
}

function recogerAlbunesUsuario($mysqli,$idSocio) {
  $sql = "SELECT * FROM poseealbum WHERE IdSocio=$idSocio";
  $result = $mysqli->query($sql);
  return $result;
}

function recogerAlbumById($mysqli,$idAlbum) {
  $sql = "SELECT * FROM album WHERE IdAlbum=$idAlbum";
  $result = $mysqli->query($sql);
  return $result;
}

function recogerAlbumByIdColeccion($mysqli,$idColeccion) {
  $sql = "SELECT * FROM album WHERE IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  return $result;
}


function recogerCromosUsuario($mysqli,$idSocio) {
  $sql = "SELECT * FROM poseecromo WHERE IdSocio=$idSocio";
  $result = $mysqli->query($sql);
  return $result;
}


function recogerCromoById($mysqli,$idCromo) {
  $sql = "SELECT * FROM cromo WHERE IdCromo=$idCromo";
  $result = $mysqli->query($sql);
  return $result;
}

function recogerCromosUsuarioColeccion($mysqli,$idSocio,$idColeccion) {
  $sql = "SELECT * FROM poseecromo WHERE IdSocio=$idSocio AND IdCromo IN (SELECT IdCromo FROM cromo WHERE IdColeccion=$idColeccion)";
  $result = $mysqli->query($sql);
  return $result;
}




$mysqli = connectToDatabase();
