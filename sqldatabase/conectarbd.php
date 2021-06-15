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

function insertarUsuario($mysqli) { // Returns: IdSocio del socio insertado.
  $sql = "INSERT INTO socio (IdSocio, Saldo) VALUES (null,0)";
  $mysqli->query($sql);
  $sql = "SELECT * FROM socio ORDER BY IdSocio DESC";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  return $row[COLUMNAIDSOCIO];
}

function insertarAlbum($mysqli, $nombreAlbum, $precio, $idColeccion) {
  $sql = "INSERT INTO album(IdAlbum, Nombre, Precio, IdColeccion) VALUES (null,$nombreAlbum,$precio,$idColeccion)";
  $mysqli->query($sql);
}
function insertarColeccion($mysqli, $nombreColeccion, $nombres, $precios, $cantidades, $imagenes) { // Returns: El Id de la colección recién creada.
    $sql = "INSERT INTO coleccion(IdColeccion, Estado,Nombre) VALUES (null,'Activo','$nombreColeccion')";
    $mysqli->query($sql);
      $result = $mysqli->query("SELECT * FROM coleccion ORDER BY IdColeccion DESC");
      $row = $result->fetch_assoc();
      $idColeccion = $row[COLUMNAIDCOLECCION];
	  $db = new PDO("mysql:host=localhost;dbname=cromos", DBUSER, DBPASSWORD);
      for($i=0;$i<count($nombres);$i++) {
		  $stmt = $db->prepare("INSERT INTO cromo(IdCromo, Nombre,UnidadesDisponibles,Imagen,Precio,IdColeccion) VALUES (null,?,?,?,?,?)");
		  $stmt->bindParam(1, $nombres[$i]);
		  $stmt->bindParam(2, $cantidades[$i]);
		  $stmt->bindParam(3, $imagenes[$i]);
		  $stmt->bindParam(4, $precios[$i]);
		  $stmt->bindParam(5, $idColeccion);
		  $stmt->execute();
      }
	  return $idColeccion;
}
function insertarColeccionAlbum($nombreColeccion, $nombres, $precios, $cantidades, $imagenes, $precioAlbum) {
	$mysqli = connectToDatabase();
	$idColeccion = insertarColeccion($mysqli, $nombreColeccion, $nombres, $precios, $cantidades, $imagenes);
	insertarAlbum($mysqli, "Album ".$nombreColeccion, $precioAlbum, $idColeccion);
	closeConnection($mysqli);
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

function actualizarCromoDisponiblesTienda($mysqli,$idCromo,$nuevaCantidad) {
  $sql = "UPDATE cromo SET UnidadesDisponibles=$nuevaCantidad WHERE IdCromo = $idCromo";
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









///////////////////////////////METODOS PARA QUE COMPRE EL USUARIO CROMOS


//Muestra los cromos de una coleccion en concreto para comprarlos en el kiosco
function mostrarCromosColeccionComprar($mysqli,$idColeccion,$idSocio) {
  $result = recogerCromosColeccionDisponibles($mysqli,$idColeccion);
  echo '<table id="tableCromos" border="1">';
  echo "<tr>";
  echo "<td>Nombre</td>";
  echo "<td>Unidades Disponibles</td>";
  echo "<td>Imagen</td>";
  echo "<td>Precio</td>";
  echo "<td>Comprar 1 unidad</td>";
  echo "</tr>";
  while($rowitem = mysqli_fetch_array($result)) {
    //form
    echo "<tr>";
    echo "<td>" . $rowitem[COLUMNANOMBRE] . "</td>";
    echo "<td>" . $rowitem[COLUMNAUNIDADESDISPONIBLES] . "</td>";
    $image = $rowitem['Imagen'];
    echo"<td>";
      echo '<img width="150" height="210" src="data:image/jpg;base64,' . base64_encode( $image ) . '" />';
    echo"</td>";
    echo "<td>" . $rowitem['Precio'] . "</td>";
    echo "<td>" . '<INPUT TYPE="BUTTON" NAME="EDIT_PRODUCT_FROM_SEARCH"
onclick="myFunction('.$rowitem['IdCromo'].','.$idSocio.');" VALUE="Comprar">' ."</td>";
    echo "</tr>";
    // /form
  }
  echo "</table>";
}

///////////////////////////METODOS PARA LA PRAGINA PRINCIPAL DEL USUARIO
//Mostra en una tabla todos los albunes que posee un usuario
//Muestras: Nombre, Boton para ver los cromos que tiene?


//Mostra en una tabla todos los cromos de una coleccion en concreto de un usuario
//Muestras: Nombre, Unidades que tiene, Su imagen
function mostrarCromosUsuario($mysqli,$idSocio,$idColeccion) {
  $result = recogerCromosUsuario($mysqli,$idSocio);
  echo '<table id="tableCromos" border="1">';
  echo "<tr>";
  echo "<td>Nombre</td>";
  echo "<td>Unidades obtenidas</td>";
  echo "<td>Imagen</td>";
  echo "<tr>";
  while($rowitem = mysqli_fetch_array($result)) {
    $buscarDatosCromo = recogerCromoById($mysqli,$rowitem['IdCromo']);
    $filaCromo=mysqli_fetch_array($buscarDatosCromo);
    if($filaCromo['IdColeccion']==$idColeccion) {
      echo "<tr>";
      echo "<td>" . $filaCromo['Nombre'] . "</td>";
      echo "<td>" . $rowitem['Cantidad'] . "</td>";
      $image = $filaCromo['Imagen'];
      echo"<td>";
        echo '<img width="150" height="210" src="data:image/jpg;base64,' . base64_encode( $image ) . '" />';
      echo"</td>";
      echo "</tr>";
    }
  }
  echo "</table>";
}

///////////////////////////////////METODOS PARA EL ADMIN
//Método diseñado para el admin.
//Muestra una tabla Con todas las colecciones
//Implementar que cuando se pulse el boton enseñe los cromos de la coleccion
function mostrarColeccionesKiosco($mysqli) {
  $result = recogerDatosColecciones($mysqli);
  echo '<table id="tableColeccion" border="1">';
  echo "<tr>";
  echo "<td>Nombre Coleccion</td>";
  echo "<td>Estado</td>";
  echo "<td> </td>";
  echo "<tr>";
  while($rowitem = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $rowitem[COLUMNANOMBRE] . "</td>";
    echo "<td>" . $rowitem['Estado'] . "</td>";
    echo '<td> <input type="button" value="Ver Cromos de esta coleccion"> </td>';
    echo "</tr>";
  }
  echo "</table>";
}

//Metodo de admin
//Muestra los cromos de una coleccion en concreto
function mostrarCromosColeccionKiosco($mysqli,$idColeccion) {
  $result = recogerCromosColeccion($mysqli,$idColeccion);
  echo '<table id="tableCromos" border="1">';
  echo "<tr>";
  echo "<td>Nombre</td>";
  echo "<td>Unidades Disponibles</td>";
  echo "<td>Imagen</td>";
  echo "<tr>";
  while($rowitem = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $rowitem[COLUMNANOMBRE] . "</td>";
    echo "<td>" . $rowitem[COLUMNAUNIDADESDISPONIBLES] . "</td>";
    $image = $rowitem['Imagen'];
    echo"<td>";
      echo '<img width="150" height="210" src="data:image/jpg;base64,' . base64_encode( $image ) . '" />';
    echo"</td>";
    echo "</tr>";
  }
  echo "</table>";
}

$mysqli = connectToDatabase();
//recogerDatosAlbunes($mysqli);
//recogerDatosCromos($mysqli);

//$saldo = recogerSaldoUsuario($mysqli,2);
//echo $saldo;
//recogerSaldoUsuario($mysqli,3);
//recogerImagenesCromos($mysqli);
//recogerSaldoUsuario($mysqli,2);
//actualizarSaldoUsuario($mysqli,2,30);
//actualizarCantidadCromoUsuario($mysqli,2,1,3);
//actualizarEstadoColeccion($mysqli,1,false);
//$id = insertarUsuario($mysqli);
//echo $id;

//echo "Funciona";
//$string = recogerEstadoColeccion($mysqli,1,2);
//echo $string;
//$string2 = recogerEstadoColeccion($mysqli,1,3);
//echo $string2;
//mostrarColeccionesKiosco($mysqli);
//mostrarCromosUsuario($mysqli,1,1);
//mostrarCromosColeccionKiosco($mysqli,1);
//mostrarAlbunesUsuario($mysqli,2,1);
//mostrarCromosColeccionComprar($mysqli,2);
//$algo = recogerColeccionDisponibles($mysqli);
//echo $algo;
//$algo =recogerIndiceInicialCromoColeccion($mysqli, 1);
//echo $algo;
//$algo2 =recogerIndiceInicialCromoColeccion($mysqli, 2);
//echo $algo2;
//echo prueba($mysqli);
//incrementarCromoUsuario($mysqli,1,1);
//comprarCromoUsuario($mysqli,1,4);


//mostrarAlbunesUsuario($mysqli,1);
//crearTablasAlbum($mysqli,1,1);
