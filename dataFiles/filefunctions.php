<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<?php
	function userExists($user) {
		$array_userData = file(CANNONICALROOTPATH."dataFiles/userData");
		for($i = 0; $i+2 < sizeof($array_userData); $i = i+3) {
			$u = $array_userData[$i];
			if ((strncasecmp($user, $u, strlen($u)-2) == 0)) {
				return true;
			}
		}
	}
	function userPasswordExists($user, $password) {
		$array_userData = file(CANNONICALROOTPATH."dataFiles/userData");
		for($i = 0; $i+2 < sizeof($array_userData); $i = $i+3) {
			$u = $array_userData[$i];
			$p = $array_userData[$i+1];
			if ((strncasecmp($user, $u, strlen($u)-2) == 0) &&
				(strncasecmp($password, $p, strlen($p)-2) == 0)) {
					return true;
			}
		}
		return false;
	}
	function writeUser($user, $password, $adminRights) {

	}
	function deleteUser($i) {

	}
?>
