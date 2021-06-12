<?php



function connectToDatabase() {
  $user = 'root'; //Esto es la url (una direccion ip)
  $pass = '';
  $db = 'cromos';
  $mysqli = new mysqli('localhost', $user, $pass, $db) or die("No se puede conectar");

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

//Metodo para imprimir datos de una consulta que se le pase pro parametros
//Va haciendo echo para cada linea del resultado (formateada para mostrar todos sus datos)
function recogerDatosConsulta($mysqli, $sql) {
  $result = $mysqli->query($sql);
  //$numLineas = $result->num_rows;

  while ($row = $result->fetch_assoc()) {
    foreach($row as $key => $value){
      echo $key . " " . $value .";";
    }
    echo "<br>";
  }
}

//Recoge el saldo del recogerSaldoUsuario
//Lo muesta en formato: "Saldo: 0"
function recogerSaldoUsuario($mysqli,$idSocio) {
  $sql = "SELECT Saldo FROM socio WHERE IdSocio = $idSocio";
  $result = $mysqli->query($sql);

  while ($row = $result->fetch_assoc()) {
    foreach($row as $key => $value){
      echo $key . " " . $value .";";
    }
    echo "<br>";
  }
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
function recogerImagenesCromos($mysqli) {
  $sql = "SELECT * FROM cromo";
  $result = $mysqli->query($sql);
  $numLineas = $result->num_rows;

  while ($row = $result->fetch_assoc()) {
    $imageDataString = base64_encode($row['Imagen']);
    $image = base64_decode($imageDataString);
  }
  header("content-type: image/jpeg");

  echo $image;
}

function recogerDatosCromos($mysqli) {
  $sql = "SELECT * FROM cromo";
  $result = $mysqli->query($sql);
  $numLineas = $result->num_rows;

  while ($row = $result->fetch_assoc()) {
    echo json_encode($row['Nombre']);
  }
}

$mysqli = connectToDatabase();
//recogerDatosAlbunes($mysqli);
//recogerDatosCromos($mysqli);

//recogerSaldoUsuario($mysqli,2);
//recogerSaldoUsuario($mysqli,3);

//recogerSaldoUsuario($mysqli,2);
//actualizarSaldoUsuario($mysqli,2,30);
//actualizarCantidadCromoUsuario($mysqli,2,1,3);
echo "Funciona";


?>
