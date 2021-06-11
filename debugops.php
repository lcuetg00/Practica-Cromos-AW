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
	function deleteAndBuildDebugUserDataFile() {
		clearAllUsers();
		writeUser("admin", "admin", true);
		writeUser("miguel", "1234aa", false);
		writeUser("admin2", "admin", true);
		writeUser("cesar", "aa1234", false);
		writeUser("luis", "12aa34", false);
	}
 ?>
