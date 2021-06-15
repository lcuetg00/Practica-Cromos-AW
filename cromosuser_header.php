<!-- La página que incluya este fichero requiere llamar a session_start() -->
<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
<?php
	echo '<p>Bienvenido "' . $_SESSION["user"] . '" a la web. Saldo actual: ' . $_SESSION["saldo"] . '</p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'user/main.php">Página usuario</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'index.php">Página principal</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'dologout.php">Cerrar sesión</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'user/minigameResolveCaptcha.php">Minijuego - Resolver captcha</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'user/minigameAnswerQuestions.php">Minijuego - Responder pregunta</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'user/verColeccion.php">Ver Colección</a></p>';
  echo '<p><a href="' . CANNONICALROOTPATH.'user/comprarCromos.php">Comprar Cromos</a></p>';
  echo '<p><a href="' . CANNONICALROOTPATH.'user/comprarAlbum.php">Comprar Album</a></p>';
 ?>
 	<p>_________________________________________________________</p>
