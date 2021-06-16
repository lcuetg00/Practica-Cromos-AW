<!-- La página que incluya este fichero requiere llamar a session_start() -->
<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<!DOCTYPE html>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo CANNONICALROOTPATH; ?>style.css">
	</head>
    <body>
		<header class="header">
			<div class="headerLogo">
				<img width="30" height="30" class="logo" src="<?php echo CANNONICALROOTPATH; ?>img/avatar.png" alt="logo"></img>
			</div>
			<nav>
				<ul class="headerLinks">
					<li><a href="<?php echo CANNONICALROOTPATH; ?>index.php">Inicio</a></li>
					<li><a href="<?php echo CANNONICALROOTPATH; ?>productos.php">Productos</a></li>
					<li><a href="<?php echo CANNONICALROOTPATH; ?>eventos.php">Eventos</a></li>
				</ul>
			</nav>
			<div class="headerButtons">
				<a class="cta" href="<?php echo CANNONICALROOTPATH; ?>user/main.php"><button>Página principal</button></a>
				<a class="cta" href="<?php echo CANNONICALROOTPATH; ?>dologout.php"><button class="flashyButton">Cerrar sesión</button></a>
			</div>
		</header>
		<header class="subHeader">
			<div class="vContainerCenteredContents"><div>Usuario: "<?php echo $_SESSION["user"] ?>"</div><div>Saldo: <?php echo $_SESSION["saldo"] ?></div></div>
			<ul class="headerLinks">
				<li><a href="<?php echo CANNONICALROOTPATH; ?>user/comprar.php">Comprar</a></li>
				<li><a href="<?php echo CANNONICALROOTPATH; ?>user/verColeccion.php">Colección</a></li>
				<li><a href="<?php echo CANNONICALROOTPATH; ?>user/minigames.php">Minijuegos</a></li>
			</ul>
		</header>
