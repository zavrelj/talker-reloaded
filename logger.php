<?
session_start();
require('system.inc.php');


/*LOGIN*/
	$logflogin = $_POST['logflogin'];
	$logfpassword = $_POST['logfpassword'];
	$invisible = $_POST['invisible'];

	$logflogin = strtolower($logflogin);

	$isRegistered = _oxResult("SELECT userid, password, active FROM $TABLE_USERS WHERE login='$logflogin'");


	if(!mysql_num_rows($isRegistered)) {
		header("location: index.php?note=802");

  	}else{
		$registeredUser = mysql_fetch_array($isRegistered);

		$psswd=substr(md5($logfpassword), 0, 32);



		if($registeredUser["password"] == $psswd) {

			//$logfpassword = serialize($logfpassword);

			$userid = $registeredUser["userid"];

			$result=_oxResult("SELECT active FROM $TABLE_USERS WHERE userid=$userid");
			$record=mysql_fetch_array($result);
			$already_logged = $record["active"];

			$now=time()+$SUMMER_TIME;

			if (!$invisible){
				_oxMod("UPDATE $TABLE_USERS SET active=1 WHERE userid='$userid'");
				_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now WHERE userid='$userid'");
			}

			//echo $userid;
			$_SESSION['userid'] = $userid;
			$_SESSION['login'] = $logflogin;
			$_SESSION['password'] = $psswd;
			$_SESSION['last_log_time'] = $now;


			if ($invisible) {
				$_SESSION['invisible'] = 1;
			}else{
				$_SESSION['invisible'] = 0;
			}




			//tady zapiseme do DB hodnoty aktualniho prihlaseni
			//cas - $now
			//IP adresa- $REMOTE_ADDR
			//server - $REMOTE_HOST
			//prohlížeè a systém - $HTTP_USER_AGENT

			$log_time = time()+$SUMMER_TIME;
			$log_IP = $_SERVER["REMOTE_ADDR"];
			$log_host = $_SERVER["REMOTE_HOST"];
			$log_agent = $_SERVER["HTTP_USER_AGENT"];


			//zjisti pocet zaznamu prihlaseneho uzivatele
			$userLogCountArray = _oxQuery("SELECT COUNT(log_time) AS log_count FROM $TABLE_LOGS WHERE FK_user='$userid'");
			$userLogCount = $userLogCountArray['log_count'];
			//echo "userLogCount: ".$userLogCount;

			//pokud je pocet zaznamu roven preferovane hodnote, vybere a vymaze
			//nejstarsi zaznam prihlaseneho uzivatele
			if ($userLogCount == $USER_LOGS) {
				$userLogArray = _oxQuery("SELECT MIN(log_time) AS oldest_log_time FROM $TABLE_LOGS WHERE FK_user='$userid'");
				$oldest_log_time = $userLogArray['oldest_log_time'];
				_oxMod("DELETE FROM $TABLE_LOGS WHERE log_time=$oldest_log_time AND FK_user='$userid'");
			}

			//zapise novy zaznam o prihlaseni prihlaseneho uzivatele
			_oxMod("INSERT INTO $TABLE_LOGS VALUES ($userid, $log_time, '$log_IP', '$log_host', '$log_agent')");






			if ($already_logged==0) {
				header("location: gate.php?m=1&s=2");
			}else{
				header("location: gate.php?m=1&s=2&new=1&logged=1");
			}



		}else{
			if ($logfpassword != "") {
				$userid = $registeredUser["userid"];

				$log_time = time()+$SUMMER_TIME;
				$log_IP = $_SERVER["REMOTE_ADDR"];
				$log_host = $_SERVER["REMOTE_HOST"];
				$log_agent = $_SERVER["HTTP_USER_AGENT"];

				_oxMod("INSERT INTO $TABLE_MAILBOX VALUES (1, $userid, '".$LNG_LOGGER_WRONG_PASSWORD_01."<br />".$LNG_LOGGER_WRONG_PASSWORD_02."<select><option>".$LNG_LOGGER_WRONG_PASSWORD_03."</option><option>".$logfpassword."</option></select><br />".$LNG_LOGGER_WRONG_PASSWORD_04." ".$log_IP."<br />".$LNG_LOGGER_WRONG_PASSWORD_05." ".$log_host."<br />".$LNG_LOGGER_WRONG_PASSWORD_06." ".$log_agent."<br />".$LNG_LOGGER_WRONG_PASSWORD_07."', $log_time, 0, $userid, 0)");
			}
			header("location: index.php?note=803");
		}

	}
?>
