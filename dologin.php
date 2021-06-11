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

	// Validar usuario y contraseña
	if (!isset($user) || empty($user)) {
		header("location: ./login.php?error=userNotSet");
		exit();
	}
	if (!isset($password) || empty($password)) {
		header("location: ./login.php?error=passwordNotSet");
		exit();
	}

	$adm = hasUserPasswordAdminRights($user, $password);
	if ($adm === 0) {
		// Error tipo userPasswordInvalid. No se informará del tipo de error (usuario y/o contraseña). Si el usuario está intentando suplantar a alguien, no queremos darle la pista de que el usuario existe o la contraseña es válida.
		header("location: ./login.php?error=userPasswordInvalid");
		exit();
	} else if ($adm === 1) { // Éxito -> hacer sesión al usuario y redirigir
		$_SESSION["user"] = $user;
		//$_SESSION["saldo"] = $; // BD datos
		header("location: ./user/main.php");
		exit();
	} else if ($adm === 2) { // Éxito -> hacer sesión al administrador y redirigir
		$_SESSION["user"] = $user;
		$_SESSION["admin"] = true;
		//$_SESSION["saldo"] = $; // BD datos
		header("location: ./admin/main.php");
		exit();
	} else {
		// Error ?
	}
?>
