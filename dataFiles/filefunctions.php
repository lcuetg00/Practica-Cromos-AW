<!-- La página que incluya este fichero debe definir CANNONICALROOTPATH -->
<?php
	define("USERDATA_DBID", "dbId");
	define("USERDATA_NAME", "nameId");
	define("USERDATA_PASSWORD", "password");
	define("USERDATA_ISADMIN", "isAdmin");
	function getUserDataByUserPassword($user, $password) {
		$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'r');
		while (true) {
			if (feof($fp)) { break; }
			$id = fgets($fp);
			if (feof($fp)) { break; }
			$u = fgets($fp);
			if (feof($fp)) { break; }
			$p = fgets($fp);
			if (feof($fp)) { break; }
			$r = fgets($fp);
			if (strlen($user) == (strlen($u)-1) &&
					strlen($password) == (strlen($p)-1) &&
					(strncasecmp($user, $u, strlen($u)-1) == 0) &&
					(strncasecmp($password, $p, strlen($p)-1) == 0)) {
				return  array(
					USERDATA_DBID => $id,
					USERDATA_NAME => $u,
					USERDATA_PASSWORD => $p,
					USERDATA_ISADMIN => (substr($r, 0, 1) == '*')
				);
			}
		}
		return null;
	}
	function findUserIndex($user) {
			$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'r');
			$i = 0;
			while (true) {
				if (feof($fp)) { break; }
				$id = fgets($fp);
				if (feof($fp)) { break; }
				$u = fgets($fp);
				if (feof($fp)) { break; }
				$p = fgets($fp);
				if (feof($fp)) { break; }
				$r = fgets($fp);
				if (strlen($user) == (strlen($u)-1) &&
						strncasecmp($user, $u, strlen($u)-1) == 0) {
					return $i;
				}
				$i = $i + 4;
			}
			return -1;
	}
	function writeUser($dbId, $user, $password, $adminRights) {
		$fp = fopen(CANNONICALROOTPATH."dataFiles/userData", 'a');
		fwrite($fp, $dbId.PHP_EOL);
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
		unset($f[$r+4]);
		unset($f[$r+3]);
		unset($f[$r+1]);
		unset($f[$r]);
		file_put_contents(CANNONICALROOTPATH."dataFiles/userData", implode("", $f));
	}
	function clearAllUsers() {
		file_put_contents(CANNONICALROOTPATH."dataFiles/userData", "");
	}
?>
