<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	include "../sqldatabase/conectarbd.php";
	include_once "./../debugops.php";

	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}
	include "../cromosuser_header.php";

	if (isset($_POST['input'])) {
	    if ($_POST['input'] == $_SESSION['captcha']) {
			$_SESSION["saldo"] = $_SESSION["saldo"]+20;
	        $msg = '<span style="color:green">Has acertado!</span><p>Añadidos 20 créditos de saldo</p><p>Saldo actual: ' . $_SESSION["saldo"] .'</p>';
			$db = connectToDatabase();
			actualizarSaldoUsuario($db, $_SESSION["dbId"], $_SESSION["saldo"]);
			closeConnection($db);
	    } else {
	        $msg = '<span style="color:red">Respuesta incorrecta</span><p>Saldo actual: ' . $_SESSION["saldo"] .'</p>';
		}
	} else {
		$msg = "";
	}
?>

    <h2>Resuelve el captcha</h2>

    <div style='margin:15px'>
        <img src="./captchaGenerator/captcha.php">
    </div>

    <form method="POST" action=
            " <?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="input"/>
        <input type="hidden" name="flag" value="1"/>
        <input type="submit" value="Resolver" name="submit"/>
    </form>

    <div style='margin-bottom:5px'>
        <?php echo $msg; ?>
    </div>

<?php
	include "../cromosuser_footer.php";
?>
