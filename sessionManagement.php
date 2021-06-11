<?php
	$timeExtension = 1800;
	session_start();
	// Mecanismo utilizado en usuarios que hayan iniciado sesión y que no sean administradores.
	if (isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
		if (!isset($_SESSION["timeout"])) {
			$_SESSION["timeout"] = $timeExtension + time();
		} else if (time() > $_SESSION["timeout"]) {
			session_destroy();
			session_write_close();
			session_unset();
			$_SESSION = array();
			header("location: " . CANNONICALROOTPATH."index.php?error=timeout");
			exit();
		} else {
			$_SESSION["timeout"] = $timeExtension + time();
		}
	}
 ?>
