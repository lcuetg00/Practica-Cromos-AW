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
		<div class="vContainerCenteredContents">
			<h3>Bienvenido <?php echo $_SESSION["user"] ?></h3>
			<div>Saldo actual: <?php echo $_SESSION["saldo"] ?></h3>
			<div style="padding:10px 0"></div>
		</div>
		<a href="./comprar.php"><button>Comprar álbumes y cromos</button></a>
		<a href="./verColeccion.php"><button>Comprobar colección</button></a>
		<a href="./minigames.php"><button>Jugar minijuegos</button></a>
	</div>
</div>

<?php
	include "../cromosuser_footer.php";
?>
