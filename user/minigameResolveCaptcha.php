<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	include "../sqldatabase/conectarbd.php";
	//include_once "./../debugops.php";

	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}

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

	include "../cromosuser_header.php";
?>

<div class="content">
	<div class="vContainerCenteredContents">
	    <h3>Resuelve el captcha</h3>
	    <div>
	        <img width="15%" height="15%" style="margin-top: 15px;" src="./captchaGenerator/captcha.php">
	    </div>

	    <form method="POST" action=" <?php echo $_SERVER['PHP_SELF']; ?>">
	        <input type="text" name="input" style="width: 80px;"/></input></br>
	        <input type="hidden" name="flag" value="1"/></input>
	        <input type="submit" value="Resolver" name="submit"/></input>
	    </form>

	    <div style='margin-top:15px'>
	        <?php echo $msg; ?>
	    </div>
	</div>
</div>
<?php
	include "../cromosuser_footer.php";
?>
