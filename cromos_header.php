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
						<li><a href="./index.php">Inicio</a></li>
						<li><a href="./productos.php">Productos</a></li>
						<li><a href="./eventos.php">Eventos</a></li>
					</ul>
				</nav>
				<div class="headerButtons">
					<a class="cta" href="./login.php"><button>Iniciar Sesión</button></a>
					<a class="cta" href="./signup.php"><button>Registro</button></a>
				</div>
			</header>
