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
	if (!preg_match("/[a-zA-Z][a-zA-Z0-9]{3, 15}/", $user)) {
		header("location: ./login.php?error=userInvalid");
		exit();
	}
	if (!preg_match("/[a-zA-Z]([a-zA-Z0-9]!?.-){5, 15}/", $password)) {
		header("location: ./login.php?error=passwordInvalid");
		exit();
	}

	include "./dataFiles/filefunctions.php"
	if (userExists("./dataFiles/userData", $user)) {
		header("location: ./login.php?error=userAlreadyExists");
		exit();
	}

	// Éxito -> registrar y redirigir
	// TODO: Guardar datos en fichero.
	$_SESSION["user"] = $u;
	header("location: ./user/main.php");
	exit();
?>
