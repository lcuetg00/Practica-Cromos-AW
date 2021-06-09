<?php
	session_start();
	if (count(get_included_files()) != 1) {
		header("location: ./index.php?error=fileCantBeIncluded");
		exit();
	}
	$_SESSION = array();
	header("location: ./index.php");
	exit();
 ?>
