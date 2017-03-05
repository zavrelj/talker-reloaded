<?
session_start();
require('system.inc.php');

$userid = $_SESSION['userid'];
$password = $_SESSION['password'];

if ($userid != "" && $userid != null && $userid != 0) {
	$perm_result=_oxResult("SELECT password FROM $TABLE_USERS WHERE userid=$userid");
	$perm_record=mysql_fetch_array($perm_result);

	$db_passwd = $perm_record["password"];
	$session_passwd = $password;

	if($db_passwd != $session_passwd) {
		header("location: index.php?note=809");
	}else{
		$now=time()+$SUMMER_TIME;
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now, active=0 WHERE userid=$userid");
		session_destroy();
		header("location: index.php?note=810");
	}


}else{
	header("location: index.php?note=809");
}



