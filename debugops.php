<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	$DEBUGGING = True;
	$TRACECOUNT = 0;

	function trace($message) {
		echo '<hr />;'.$TRACECOUNT++.'<code>'.$message.'</code><hr />';
	}

	function tarr($arr) {
		echo '<hr />'.$TRACECOUNT++.'<code>';
		print_r($arr);
		echo '</code><hr />';
	}

	// Requiere -> include "./dataFiles/filefunctions.php";
	// Requiere -> include "./sqldatabase/conectarbd.php";
	function deleteAndBuildDebugUserDataFile() {
		clearAllUsers();
		$db = connectToDatabase();
		writeUser(					-1, "admin",	"admin",	true);
		writeUser(insertarUsuario($db), "miguel",	"1234aa",	false);
		writeUser(					-1, "admin2",	"admin",	true);
		writeUser(insertarUsuario($db), "cesar",	"aa1234",	false);
		writeUser(insertarUsuario($db), "luis",		"12aa34",	false);
		closeConnection($db);
	}
 ?>
