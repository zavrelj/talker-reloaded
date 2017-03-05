<?
session_start();
require('system.inc.php');

 /* REGISTRACE*/

	$regflogin = $_POST['regflogin'];
	$regfpassword = $_POST['regfpassword'];
	$reg2fpassword = $_POST['reg2fpassword'];


	if($regflogin!=null && $regfpassword!=null && $reg2fpassword!=null) {

		$regfloginlength=strlen($regflogin);
		if ($regfloginlength >= 3) {
			$regflogin = strtolower($regflogin);

			$isRegistered = _oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$regflogin'");

				if(mysql_num_rows($isRegistered)) {

					header("location: mainpage.php?status=1");
				}else{
  					if ($regfpassword == $reg2fpassword) {

						$now = time()+$SUMMER_TIME;
						if (ereg("(^[[:alnum:]]+$)", $regflogin)) {

							$hash_password=md5($regfpassword);


							_oxMod("INSERT INTO $TABLE_USERS VALUES (LAST_INSERT_ID(),'$regflogin','$hash_password',$now,'',$now,'',0,0,'','','',1200,'','','','','','','','','','','','','','','','',0,0,0,0,'','style/osx/osx_system.css',10,'','','','','','','','','','','jsem k dispozici','1','2','1','','','')");
							copy("data/default.gif", "ico/$regflogin.gif");


							$justRegistered = _oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$regflogin'");
							$registeredUser = mysql_fetch_array($justRegistered);

							$userid = $registeredUser["userid"];
							_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now WHERE userid='$userid'");

							$psswd=substr(md5($regfpassword), 0, 20);


							$_SESSION['userid'] = $userid;
							$_SESSION['login'] = $regflogin;
							$_SESSION['password'] = $psswd;


							$now = time() + $SUMMER_TIME;
							_oxMod("INSERT INTO $TABLE_MAILBOX VALUES (1, $userid, 'Dobrý den $regflogin !:)<br>Vítám Vás v systému.<br>Jsem velice rád, že jste se stal/a členem a doufám, že se Vám zde bude líbit.<br>Pokud budete mít jakýkoliv dotaz ohledně systému, neváhejte mi napsat zprávu do po‘ty.<br>Přeji příjemný den!', $now, 0, $userid)");

							header("location: mainpage.php?status=11");


						}else{
							header("location: mainpage.php?status=5");
						}
					}else{
						header("location: mainpage.php?status=7");
					}
				}
		}else{
			header("location: mainpage.php?status=6");
		}

	}else{
		header("location: mainpage.php?status=4");
	}
?>
