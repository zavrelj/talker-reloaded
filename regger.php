<?
session_start();
require('system.inc.php');

/*REGISTRATION*/

	$regflogin = $_POST['regflogin'];
	$regfpassword = $_POST['regfpassword'];
	$reg2fpassword = $_POST['reg2fpassword'];


	if($regflogin!=null && $regfpassword!=null && $reg2fpassword!=null) {

		$regfloginlength=strlen($regflogin);
		if ($regfloginlength >= 3) {
			$regflogin = strtolower($regflogin);

			$isRegistered = _oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$regflogin'");

				if(mysql_num_rows($isRegistered)) {

					header("location: newuser.php?note=801");
				}else{
  					if ($regfpassword == $reg2fpassword) {

						$now = time()+$SUMMER_TIME;
						if (ereg("(^[[:alnum:]]+$)", $regflogin)) {

							$hash_password=md5($regfpassword);


							_oxMod("INSERT INTO $TABLE_USERS VALUES (LAST_INSERT_ID(),'$regflogin','$hash_password',$now,$now,0,0,0,'','','',1200,'','','','','','','','','','','','','','','','',0,0,0,0,'','t2',10,'','','','','','','','','','','available','1',0,'','',1,'','cz')");
							copy("style/default/icon-defaultuser.gif", "ico/$regflogin.gif");


							$justRegistered = _oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$regflogin'");
							$registeredUser = mysql_fetch_array($justRegistered);

							$userid = $registeredUser["userid"];
							//_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now WHERE userid='$userid'");


							//$_SESSION['userid'] = $userid;
							//$_SESSION['login'] = $regflogin;
							//$_SESSION['password'] = $psswd;


							$now = time() + $SUMMER_TIME;
							_oxMod("INSERT INTO $TABLE_MAILBOX VALUES (1, $userid, 'Hello $regflogin !:)<br />Welcome.<br />We are very glad that you are one of us now! We hope you enjoy your membership here.<br />If there is anything we can help you with, do not hesistate to contact me.<br />Have a nice day!', $now, 0, $userid, 0)");

							header("location: newuser.php?note=811");



						}else{
							header("location: newuser.php?note=805");
						}

					}else{
						header("location: newuser.php?note=807");
					}
				}


		}else{
			header("location: newuser.php?note=806");
		}


	}else{
		header("location: newuser.php?note=804");
	}
?>
