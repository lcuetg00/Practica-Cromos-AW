<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<?php
	function userExists($user) {
		$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'r');
		while (true) {
			if (feof($fp)) { return false; }
			$u = fgets($fp);
			if (feof($fp)) { return false; }
			$p = fgets($fp);
			if (feof($fp)) { return false; }
			$r = fgets($fp);
			if (strlen($user) == (strlen($u)-1) &&
					strncasecmp($user, $u, strlen($u)-1) == 0) {
				return true;
			}
		}
		return false;
	}
	function userPasswordExists($user, $password) {
		$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'r');
		while (true) {
			if (feof($fp)) { return false; }
			$u = fgets($fp);
			if (feof($fp)) { return false; }
			$p = fgets($fp);
			if (feof($fp)) { return false; }
			$r = fgets($fp);
			if (strlen($user) == (strlen($u)-1) &&
					strlen($password) == (strlen($p)-1) &&
					(strncasecmp($user, $u, strlen($u)-1) == 0) &&
					(strncasecmp($password, $p, strlen($p)-1) == 0)) {
				return true;
			}
		}
		return false;
	}
	function hasUserPasswordAdminRights($user, $password) {
		$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'r');
		while (true) {
			if (feof($fp)) { return 0; }
			$u = fgets($fp);
			if (feof($fp)) { return 0; }
			$p = fgets($fp);
			if (feof($fp)) { return 0; }
			$r = fgets($fp);
			if ((strncasecmp($user, $u, strlen($u)-1) == 0) &&
					(strncasecmp($password, $p, strlen($p)-1) == 0)) {
				if (substr($r, 0, 1) == '*') {
					return 2;
				} else {
					return 1;
				}
			}
		}
		return 0;
	}
	function findUserIndex($user) {
			$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'r');
			$i = 0;
			while (true) {
				if (feof($fp)) { return false; }
				$u = fgets($fp);
				if (feof($fp)) { return false; }
				$p = fgets($fp);
				if (feof($fp)) { return false; }
				$r = fgets($fp);
				if (strlen($user) == (strlen($u)-1) &&
						strncasecmp($user, $u, strlen($u)-1) == 0) {
					return $i;
				}
				$i = $i + 3;
			}
			return -1;
	}
	function writeUser($user, $password, $adminRights) {
		$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'a');
		fwrite($fp, $user.PHP_EOL);
		fwrite($fp, $password.PHP_EOL);
		if($adminRights) {
			fwrite($fp, '*'.PHP_EOL);
		} else {
			fwrite($fp, '-'.PHP_EOL);
		}
		fclose($fp);
	}
	function deleteUser($user) {
		$r = findUserIndex($user);
		if ($r == -1) { return; }
		$f = file(CANNONICALROOTPATH."dataFiles/userData");
		unset($f[$r]);
		unset($f[$r+1]);
		unset($f[$r+2]);
		file_put_contents(CANNONICALROOTPATH."dataFiles/userData", implode("", $f));
	}
	function clearAllUsers() {
		file_put_contents(CANNONICALROOTPATH."dataFiles/userData", "");
	}
?>
