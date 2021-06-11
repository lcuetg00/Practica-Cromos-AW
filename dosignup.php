<?php
	include "./dataFiles/filefunctions.php";
	if (count(get_included_files()) != 2) {
		header("location: ./index.php?error=fileCantBeIncluded");
		exit();
	}
	if (isset($_SESSION["user"]) || !isset($_POST["submit"])) {
		header("location: ./index.php");
		exit();
	}
	define("CANNONICALROOTPATH", "./");
	session_start();

	$user = $_POST["user"];
	$password = $_POST["password"];
	$passwordrep = $_POST["passwordrep"];

	// Validar usuario y contraseña
	if (!isset($user) || empty($user)) {
		header("location: ./signup.php?error=userNotSet");
		exit();
	}
	if (!isset($password) || empty($password)) {
		header("location: ./signup.php?error=passwordNotSet");
		exit();
	}
	if (strcmp($password, $passwordrep) != 0) {
		header("location: ./signup.php?error=passwordDoesntMatch");
		exit();
	}
	if (!preg_match("/([a-zA-Z][a-zA-Z0-9]{3,16})/", $user)) {
		header("location: ./signup.php?error=userInvalid");
		exit();
	}
	if (!preg_match("/([a-zA-Z0-9!?.-]{6,16})/", $password)) {
		header("location: ./signup.php?error=passwordInvalid");
		exit();
	}

	$pwlen = strlen($password);
	if (strncasecmp("1234567890123456", $password, $pwlen) == 0 ||
			strncasecmp("abcdefghijklmnop", $password, $pwlen) == 0 ||
			strcmp("password", $password) == 0) {
		header("location: ./signup.php?error=passwordUnsafe");
		exit();
	}

	if (userExists($user)) {
		header("location: ./signup.php?error=userAlreadyExists");
		exit();
	}

	// Éxito -> registrar y redirigir
	writeUser($user, $password, false);
	$_SESSION["user"] = $user;
	$_SESSION["saldo"] = 0;
	header("location: ./user/main.php");
	exit();
?>
