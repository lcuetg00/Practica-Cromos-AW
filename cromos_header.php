<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<!DOCTYPE html>
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
    <p>Usuario Desconocido</p>
    <?php
	    echo '<p><a href="' . CANNONICALROOTPATH.'login.php">Login</a></p>';
	    echo '<p><a href="' . CANNONICALROOTPATH.'signup.php">Signup</a></p>';
     ?>
        <p class="b">________________________</p>
