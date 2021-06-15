<!-- La página que incluya este fichero requiere llamar a session_start() -->
<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<?php
	define("AVALIABLEQUESTIONS", 14);

	function getQuestionSetAnswer() {
		$i = rand(0, AVALIABLEQUESTIONS-1) * 2;
		$data = file(CANNONICALROOTPATH."user/questionsGame/questionsData");
		$_SESSION["answer"] = $data[$i+1];
		return $data[$i];
	}
?>
