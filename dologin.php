<?php
	define("CANNONICALROOTPATH", "./");
	include "./debugops.php";
	include "./sessionManagement.php";
	include "./dataFiles/filefunctions.php";
	include "./sqldatabase/conectarbd.php";
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

	$userData = getUserDataByUserPassword($user, $password);
	if (is_null($userData)) {
		// Error tipo userPasswordInvalid. No se informará del tipo de error (usuario y/o contraseña). Si el usuario está intentando suplantar a alguien, no queremos darle la pista de que el usuario existe o la contraseña es válida.
		header("location: ./login.php?error=userPasswordInvalid");
		exit();
	} else if ($userData[USERDATA_ISADMIN] == true) { // Hacer sesión al administrador y redirigir
		$_SESSION["user"] = $userData[USERDATA_NAME];
		$_SESSION["admin"] = true;
		header("location: ./admin/main.php");
		exit();
	} else { // Hacer sesión al usuario y redirigir
		$db = connectToDatabase();
		$_SESSION["dbId"] = $userData[USERDATA_DBID];
		$_SESSION["user"] = $user;
		$_SESSION["saldo"] = recogerSaldoUsuario($db, $userData[USERDATA_DBID]);
		closeConnection($db);
		header("location: ./user/main.php");
		exit();
	}
?>
