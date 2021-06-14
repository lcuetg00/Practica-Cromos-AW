<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}

	include "../sqldatabase/conectarbd.php";
	include "../cromosuser_header.php";

?>
<h3> Seleccione un album para Comprar Cromos </h3>

<script>
function myFunction(idCromo,idUser) {
  alert(idCromo);
  alert(idUser);
  //Llamada ajax para comprar el cromo
}
</script>

<?php
$idColeccion=1;
$db = connectToDatabase();
mostrarCromosColeccionComprar($db,1,$_SESSION["dbId"]);
?>

<?php
	include "../cromosuser_footer.php";
?>
