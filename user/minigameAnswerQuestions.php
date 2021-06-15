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

	$lastAnswer = "";
	if (isset($_SESSION["answer"])) {
		$lastAnswer = $_SESSION["answer"];
	}


	include "./questionsGame/questions.php";
	$question = getQuestionSetAnswer();
	//echo $_SESSION["answer"];
	echo '<h2>Responde correctamente</h2>
    <form method="POST" action="'.$_SERVER['PHP_SELF'].'">
		<h3>Pregunta: '.$question.'</h3>
        <input type="text" name="input"/>
        <input type="hidden" name="flag" value="1"/>
        <input type="submit" value="Contestar" name="submit"/>
    </form>';

	if (isset($_POST['input'])) {
		//echo $lastAnswer . "</br>";
		//echo strlen($lastAnswer) . "</br>";
		//echo $_POST['input'] . "</br>";
		//echo strlen($_POST['input']) . "</br>";
	    if ($_POST['input'] !== "" &&
				strlen($_POST['input']) == (strlen($lastAnswer)-1) &&
				(strncasecmp($_POST['input'], $lastAnswer, (strlen($lastAnswer)-1)) == 0)) {
	    //if ($_POST['input'] !== "" && stristr($lastAnswer, $_POST['input'])) {
			$_SESSION["saldo"] = $_SESSION["saldo"]+20;
	        $msg = '<span style="color:green">Has acertado!</span><p>Añadidos 20 créditos de saldo</p><p>Saldo actual: ' . $_SESSION["saldo"] .'</p>';
			$db = connectToDatabase();
			actualizarSaldoUsuario($db, $_SESSION["dbId"], $_SESSION["saldo"]);
			closeConnection($db);
			$_POST['input'] = "";
			unset($_POST);
	    } else {
	        $msg = '<span style="color:red">Respuesta incorrecta</span><p>Saldo actual: ' . $_SESSION["saldo"] .'</p>';
			$_POST['input'] = "";
			unset($_POST);
		}
	} else {
		$msg = "";
	}
?>

    <div style='margin-bottom:5px'>
        <?php echo $msg; ?>
    </div>
	<div style='margin-bottom:5px'>
		Fuente preguntas: <a href="https://psicologiaymente.com/cultura/preguntas-trivial">Web psicologiaymente</a>
	</div>

<?php
	include "../cromosuser_footer.php";
?>
