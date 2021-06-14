<?php

define("COLUMNAIDSOCIO","IdSocio");
define("COLUMNASALDOSOCIO","Saldo");

define("COLUMNAIDCOLECCION","IdColeccion");
define("COLUMNAESTADO","Estado");

define("COLUMNANOMBRE","Nombre");
define("COLUMNAUNIDADESDISPONIBLES","UnidadesDisponibles");
define("COLUMNAIMAGEN","Imagen");

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

//Metodo para devolver todas las filas obtenidas de una consulta
function recogerDatosConsulta($mysqli, $sql) {
  $result = $mysqli->query($sql);
  return $result;
}



function insertarUsuario($mysqli) {
  $sql = "INSERT INTO socio (IdSocio, Saldo) VALUES (null,0)";
  if ($mysqli->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $sql = "SELECT * FROM socio ORDER BY IdSocio DESC";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  return $row[COLUMNAIDSOCIO];
}

function insertarColeccion($mysqli, $nombreColeccion, $nombres, $precios, $cantidades, $imagenes) {
    $sql = "INSERT INTO coleccion(IdColeccion, Estado,Nombre) VALUES (null,'Activo',"$nombreColeccion")";
    if ($mysqli->query($sql) === TRUE) { //recogemos el id nuevo y le metemos los cromos
      $sqlRecogerId = "SELECT * FROM coleccion ORDER BY IdSocio DESC";
      $result = $mysqli->query($sqlRecogerId);
      $row = $result->fetch_assoc();
      $idColeccion = $row[COLUMNAIDCOLECCION];

      for($i=0;i<count($nombreColeccion);i++) {
        //Trato la imagen para poder aniadirla a la base de datos
        $pos = strpos($imagen[$i], 'base64,');
        $blobData= base64_decode(substr($imagen[$i], $pos + 7));
        //Creo la sentencia y la ejecuto
        $sqlInsertarCromos = "INSERT INTO cromo(IdCromo, Nombre,UnidadesDisponibles,Imagen,Precio,IdColeccion) VALUES (null,$nombres[$i],$cantidades[$i],$blobData,$precios[$i],$idColeccion)";
        $mysqli->query($sql);
      }

    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

//Devuelve el saldo del usuario con el id insertado
function recogerSaldoUsuario($mysqli,$idSocio) {
  $sql = "SELECT Saldo FROM socio WHERE IdSocio = $idSocio";
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
  if($result->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

function recogerCromosColeccion($mysqli,$idColeccion) {
  $sql = "SELECT * FROM cromo WHERE IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  if($result->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}


//Recoge todos los cromos que tengan unidades disponibles de una coleccion
function recogerCromosColeccionDisponibles($mysqli,$idColeccion) {
  $sql = "SELECT * FROM cromo WHERE UnidadesDisponibles>0 AND IdColeccion=$idColeccion";
  $result = $mysqli->query($sql);
  if($result->num_rows === 0) {
    //no hay resultados
  }
  return $result;
}

//Recoge el album de una coleccion si esta activa
function recogerColeccionDisponibles($mysqli) {
  $sql = "SELECT * FROM album WHERE IdColeccion IN (SELECT * FROM coleccion WHERE Estado='Activo')";
  $result = $mysqli->query($sql);
  if($result->num_rows === 0) {
    //no hay resultados
  }
  return json_encode($result);
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


function recogerEstadoColeccion($mysqli, $idColeccion, $idSocio) {
  $sql = "SELECT * FROM cromo WHERE IdColeccion=$idColeccion";
  $resultadoColeccion = $mysqli->query($sql);
  $numeroCromosColeccion = $resultadoColeccion->num_rows;

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
function mostrarAlbunesUsuario($mysqli,$idSocio,$idColeccion) {
  $result = recogerAlbunesUsuario($mysqli,$idSocio);
  echo '<table id="tableAlbum" border="1">';
  echo "<tr>";
  echo "<td>Nombre</td>";
  echo "<td>Acceder Album</td>";
  echo "<tr>";
  while($rowitem = mysqli_fetch_array($result)) {
    $buscarDatosAlbum = recogerAlbumById($mysqli,$rowitem['IdAlbum']);
    $filaAlbum = mysqli_fetch_array($buscarDatosAlbum);
    if($filaAlbum['IdColeccion']==$idColeccion) {
      echo "<tr>";
      echo "<td>" . $filaAlbum['Nombre'] . "</td>";
      echo "<td>Llamar a mostrarCromosUsuario</td>";
      echo "</tr>";
    }
  }
  echo "</table>";
}

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
