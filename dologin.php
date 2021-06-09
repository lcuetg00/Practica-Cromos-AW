<?php
	define("CANNONICALROOTPATH", "./");
	session_start();
	if (count(get_included_files()) != 1) {
		header("location: ./index.php?error=fileCantBeIncluded");
		exit();
	}
	if (isset($_SESSION["user"]) || !isset($_POST["submit"])) {
		header("location: ./index.php");
		exit();
	}

	$user = $_POST["user"];
	$password = $_POST["password"];

	// Validar usuario y contraseña
	if (!isset($user) || empty($user)) {
		header("location: ./login.php?error=userNotSet");
		exit();
	}
	if (!isset($password) || empty($password)) {
		header("location: ./login.php?error=passwordNotSet");
		exit();
	}

	include "./dataFiles/filefunctions.php";
	if (userPasswordExists($user, $password)) {
		// Éxito -> registrar y redirigir
		$_SESSION["user"] = $user;
		//$_SESSION[""] = $; // BD datos
		header("location: ./user/main.php");
		exit();
	}
	// Error tipo userPasswordInvalid. No se informará del tipo de error (usuario y/o contraseña). Si el usuario está intentando suplantar a alguien, no queremos darle la pista de que el usuario existe o la contraseña es válida.
	header("location: ./login.php?error=userPasswordInvalid");
	exit();
?>
