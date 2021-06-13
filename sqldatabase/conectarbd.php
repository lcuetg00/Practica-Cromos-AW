<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<?php

function connectToDatabase() {
  $user = 'root'; //Esto es la url (una direccion ip)
  $pass = '';
  $db = 'cromos';
  $mysqli = new mysqli('localhost', $user, $pass, $db) or die("No se puede conectar");

 //Comprobamos si se conecta bien a la base de datos:
  if (mysqli_connect_errno()) {
	  header("location: " .  CANNONICALROOTPATH."index.php?error=dbConnectionError");
	  exit();
  }
 return $mysqli;
}

function closeConnection($mysqli) {
  $mysqli -> close();
}

//Metodo para devolver todas las filas obtenidas de una consulta
function recogerDatosConsulta($mysqli, $sql) {
  $result = $mysqli->query($sql);
  return $result;
}

define("COLUMNAIDSOCIO","IdSocio");
define("COLUMNASALDOSOCIO","Saldo");

function insertarUsuario($mysqli) {
  $sql = "INSERT INTO socio (IdSocio, Saldo) VALUES (null,0)";
  /*
  if ($mysqli->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  */
  $sql = "SELECT * FROM socio ORDER BY IdSocio DESC";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  return $row[COLUMNAIDSOCIO];
}

//Devuelve el saldo del usuario con el id insertado
function recogerSaldoUsuario($mysqli,$idSocio) {
  $sql = "SELECT Saldo FROM socio WHERE IdSocio = ".$idSocio;
  $result = $mysqli->query($sql);

  $row = $result->fetch_assoc();
  return $row[COLUMNASALDOSOCIO];
}

//Recoge todos los usuarios de la base de datos
function recogerSocios($mysqli) {
  $sql = "SELECT * FROM socio";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

//Recoge todos los cromos de la base de datos
function recogerCromos($mysqli) {
  $sql = "SELECT * FROM cromo";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

//Recoge todos los albunes de la base de datos
function recogerAlbum($mysqli) {
  $sql = "SELECT * FROM album";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}


//Recoge todos los cromos que tengan unidades disponibles de una coleccion
function recogerCromosColeccionDisponibles($mysqli,$idColeccion) {
  $sql = "SELECT * FROM cromo WHERE UnidadesDisponibles>0 AND IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

//Recoge el album de una coleccion si esta activa
function recogerAlbumColeccionDisponibles($mysqli,$idColeccion) {
  $sql = "SELECT * FROM album WHERE Estado='Activo'";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

//Recoge todos los cromos que posee el usuario para una coleccion en concreto
//Falta definir que ocurre si no tiene ningun cromo
function recogerCromosColeccionSocio($mysqli,$idColeccion,$idSocio) {
  $sql = "SELECT * FROM poseecromo WHERE IdColeccion=$idColeccion AND IdSocio=$idSocio";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

//Recoge todos el album que posee el usuario para una coleccion en concreto
//Falta definir que ocurre si no tiene ningun cromo
function recogerAlbumColeccionSocio($mysqli,$idColeccion,$idSocio) {
  $sql = "SELECT * FROM poseealbum WHERE IdColeccion=$idColeccion AND IdSocio=$idSocio";
  $result = $mysqli->query($sql);
  if($results->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

function actualizarSaldoUsuario($mysqli,$idSocio,$nuevoSaldo) {
  $sql = "UPDATE socio SET Saldo=$nuevoSaldo WHERE IdSocio = $idSocio";
  if ($mysqli->query($sql) === TRUE) {
    echo "Actualizado Correctamente";
  } else {
    echo "Error al actualizar: " . $mysqli->error;
  }
}

function actualizarCromosDisponiblesTienda($mysqli,$idCromo,$nuevaCantidad) {
  $sql = "UPDATE cromo SET UnidadesDisponibles=$nuevaCantidad WHERE IdCromo = $idCromo";
  if ($mysqli->query($sql) === TRUE) {
    echo "Actualizado Correctamente";
  } else {
    echo "Error al actualizar: " . $mysqli->error;
  }
}

function actualizarCantidadCromoUsuario($mysqli,$idSocio,$idCromo,$nuevaCantidad) {
  $sql = "UPDATE poseecromo SET Cantidad=$nuevaCantidad WHERE IdSocio = $idSocio AND IdCromo = $idCromo" ;
  if ($mysqli->query($sql) === TRUE) {
    echo "Actualizado Correctamente";
  } else {
    echo "Error al actualizar: " . $mysqli->error;
  }
}

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

//Metodo para consultar los albunes (prueba)
function recogerDatosAlbunes($mysqli) {
  $sql = "SELECT * FROM album";
  $result = $mysqli->query($sql);

 while ($row = $result->fetch_assoc()) {
   foreach($row as $key => $value){
      echo $key . " " . $value .";";
    }
    echo "<br>";
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

function recogerDatosCromos($mysqli) {
  $sql = "SELECT * FROM cromo";
  $result = $mysqli->query($sql);
  $numLineas = $result->num_rows;

  while ($row = $result->fetch_assoc()) {
    echo json_encode($row['Nombre']);
  }
}

?>
