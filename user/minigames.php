<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	if (!isset($_SESSION["dbId"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosuser_header.php";
?>

<div class="content">
	<div class="vContainerCenteredContents">
		<h2>MINIJUEGOS</h2>
		<a href="./minigameAnswerQuestions.php"><button>Minijuego responder preguntas</button></a>
		<a href="./minigameResolveCaptcha.php"><button>Minijuego resolver captcha</button></a>
	</div>
</div>

<?php
	include "../cromosuser_footer.php";
?>
