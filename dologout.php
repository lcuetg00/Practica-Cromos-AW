<?php
	if (count(get_included_files()) != 1) {
		header("location: ./index.php?error=fileCantBeIncluded");
		exit();
	}
	session_start();
	
	$_SESSION = array();
	header("location: ./index.php");
	exit();
 ?>
