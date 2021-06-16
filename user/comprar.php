<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}


	include "../cromosuser_header.php";
?>

<div class="content">
	<div class="vContainerCenteredContents">
		<h2>COMPRAR</h2>
		<a href="./comprarAlbum.php"><button>Comprar álbums</button></a>
		<a href="./comprarCromos.php"><button>Cromprar cromos</button></a>

<?php

	if (isset($_GET["status"])) {
		switch ($_GET["status"]) {
			case "albumExitoCompra";
				$msg = '<b style="color:green; font-size: 22px;">Album comprado con éxito</b>';
				break;
			case "albumSaldoInsuf";
				$msg = '<b style="color:red; font-size: 22px;">No tienes puntos suficientes para comprar el album</b>';
				break;
			case "albumYaComprado";
				$msg = '<b style="color:red; font-size: 22px;">Ya tienes el album, no puedes comprar otro<b>';
				break;
			case "cromoExitoCompra";
				$msg = '<b style="color:green; font-size: 22px;">Cromo comprado con éxito</b>';
				break;
			case "cromoSaldoInsuf";
				$msg = '<b style="color:red; font-size: 22px;">No tienes puntos suficiente para comprar el cromo</b>';
				break;
			case "cromoNoAlbum";
				$msg = '<b style="color:red; font-size: 22px;">No tienes el album de la colección, compra el album para poder guardar los cromos</b>';
				break;
		}
		echo '<div style="margin-top:15px">'.$msg.'</div>';
	}
	echo '</div></div>';

	include "../cromosuser_footer.php";
?>
