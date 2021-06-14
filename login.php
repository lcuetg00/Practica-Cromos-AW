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

        <section class="login-form">
            <form action="dologin.php" method="post">
              <div class="imgcontainer">
                <br><img src="img/avatar.png" alt="Avatar" class="avatar">
                <br><br><label><c>INICIAR SESION</c></label><br><br>
              </div>

              <div class="container">
                <label for="uname"><b>Nombre de usuario: </b></label>
                <input type="text" placeholder="Introduce tu nombre de usuario" name="user" required>
                <br><br>

                <label for="psw"><b>Contraseña: </b></label>
                <input type="text" placeholder="Introduce tu contraseña" name="password" required>
                <br><br>

                <button type="submit" name ="submit"> Iniciar Sesión </button>
                <!-- <label><input type="checkbox" checked="checked" name="remember"> Recordarme </label> --> 
              </div>

              <div class="container">
                <button type="button" class="volverbtn"> Volver </button>
                <span class="greentxt">¿No tienes cuenta?   <a href="#"> Registrarse </a></span>
                <!-- <span class="psw">¿Has olvidado la <a href="#">contraseña</a>?</span> --> 
              </div>
              <?php
		        if (isset($_GET["error"])) {
			        switch ($_GET["error"]) {
				        case "userNotSet";
					        echo "<p>El campo usuario está incompleto</p>";
				        break;
				        case "passwordNotSet";
					        echo "<p>El campo contraseña está incompleto</p>";
				        break;
				        case "userPasswordInvalid";
					        echo "<p class='p'>El usuario y/o la contraseña no existen en la base de datos</p>";
				        break;
			        }
		        }
	          ?>

            </form>
        </section>

        <?php
	        include_once "./cromos_footer.php"
        ?>
    </body>

</html>

