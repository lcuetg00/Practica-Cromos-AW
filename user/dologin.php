<?php

if (!isset($_POST["submit"])) {
	header("location: ../index.php");
}
	$user = $_POST["user"];
	$password = $_POST["password"];

	// Validar usuario y contraseña

	$file_userData = "./data/userData";
	$array_userData = file($file_userData);

for ($i=0; $i<sizeof($array_userData); i=i+2) {
	$u = $array_userData[$i];
	$p = $array_userData[$i+1];
	if ((strncasecmp($user, $u, strlen($u)-1) == 0) &&
			(strncasecmp($password, $p, strlen($p)-1) == 0)) {
	}
}

?>
