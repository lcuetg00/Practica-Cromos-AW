<!-- La página que incluya este fichero requiere llamar a session_start() -->
<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
<?php
	echo '<p>Bienvenido "' . $_SESSION["user"] . '" a la página de administración</p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'admin/main.php">Página administrador</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'index.php">Página principal</a></p>';
	echo '<p><a href="' . CANNONICALROOTPATH.'dologout.php">Cerrar sesión</a></p>';
 ?>
 	<p>_________________________________________________________</p>
