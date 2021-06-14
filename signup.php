<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
	    define("CANNONICALROOTPATH", "./");
	    include "./sessionManagement.php";

	    if (isset($_SESSION["user"])) {
		    header("location: ./index.php");
		    exit();
	    }
	
	    include_once "./cromos_header.php";
    ?>

    <section class="signup-form">
        <div class="signup-form-form">
            <form action="dosignup.php" method="post">
              <div class="imgcontainer">
                <br><img src="img/avatar.png" alt="Avatar" class="avatar">
                <br><br><label><c> REGISTRARSE </c></label><br><br>
              </div>

              <div class="container">
                <label for="uname"><b>Nombre de usuario: </b></label>
                <input type="text" placeholder="Introduce tu nombre de usuario" name="user" required>
                <br><br>

                <label for="psw"><b>Contrase&ntilde;a: </b></label>
                <input type="text" placeholder="Introduce tu contrase&ntilde;a" name="password" required>
                <br><br>

                <label for="psw"><b>Vuelve a introducir la contrase&ntilde;a: </b></label>
                <input type="text" placeholder="Vuelve a introducir la contrase&ntilde;a" name="passwordrep" required>
                <br><br>

                <button type="submit" name="submit"> Crear Cuenta </button>
              </div>

              <div class="container">
                <button type="button" style="float: right;" class="volverbtn"> Volver </button>
              </div>
              <br><br><br>
            </form>
        </div>
			<?php
			if (isset($_GET["error"])) {
				switch ($_GET["error"]) {
					case "passwordDoesntMatch":
						echo "<p>Las contrase&ntilde;as no coinciden</p>";
						break;
					case "userInvalid";
						echo "<p>El campo usuario debe contener de 4 a 16 caracteres alfadecimales y debe empezar por una letra</p>";
					break;
					case "passwordInvalid";
						echo "<p>El campo contrase&ntilde;a debe contener de 6 a 16 caracteres alfadecimales, incluídos \"! ? . -\"</p>";
					break;
					case "passwordUnsafe";
						echo "<p>La contrase&ntilde;a introducida no es lo suficientemente segura</p>";
					break;
					case "userAlreadyExists";
						echo "<p>El usuario introducido ya existe</p>";
					break;
					case "";
						echo "<p></p>";
					break;
				}
			}
		 ?>
    </section>
    <?php
	    include_once "cromos_footer.php"
    ?> 
</body>

</html>
