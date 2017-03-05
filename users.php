<?

$now=time()+$SUMMER_TIME;



if ($submodule_number==1) {
	$usersResult = _oxResult("SELECT login, AT, level, location, lastaccess, regdate, status FROM $TABLE_USERS WHERE active=1 ORDER BY login ASC");
}



if ($submodule_number==2) {

	$pratsubmit = $_POST['pratsubmit'];
	$pratname = $_POST['pratname'];
	$pratnote = $_POST['pratnote'];
	$del = $_POST['del'];
	$delprat = $_POST['delprat'];
	$add_friend_name = $_GET['add'];


	if ($pratsubmit == "přidat přítele" && $db_passwd == $session_passwd) {
		
    $result=_oxResult("SELECT login FROM $TABLE_USERS WHERE login='$pratname'");
		if (mysql_num_rows($result) != 0) {
			$numero=getUserId($pratname);

			$result=_oxResult("SELECT userid FROM $TABLE_FRIENDS WHERE friendid=$numero AND userid=$userid");
			$is_friend=mysql_num_rows($result);

			if ($numero != 0 && $numero != $userid && $is_friend == 0) {

				$parsed_pratnote = strip_tags($pratnote,"<i>,<b>,<h1>,<h2>,<h3>");
				$parsed_pratnote = nl2br($parsed_pratnote);

				_oxMod("INSERT INTO $TABLE_FRIENDS VALUES ($userid, $numero, '$parsed_pratnote')");

				$now=time()+$SUMMER_TIME;
				_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $numero, '".$LNG_FRIENDS_ADD." ".$parsed_pratnote."', $now, 0, $numero, 0)");
			}else{
				$not_exist=1;
			}
		}else{
			$not_exist=1;
		}
	}


	if ($pratsubmit == "změnit komentář" && $db_passwd == $session_passwd) {
		$numero=getUserId($pratname);
		if ($numero <> 0 && $numero <> $userid) {
			$result=_oxResult("SELECT * FROM $TABLE_FRIENDS WHERE userid=$userid AND friendid=$numero");
			$record=mysql_num_rows($result);
			if ($record <> 0) {
				$parsed_pratnote = strip_tags($pratnote,"<i>,<b>,<h1>,<h2>,<h3>");
				$parsed_pratnote = nl2br($parsed_pratnote);
				_oxMod("UPDATE $TABLE_FRIENDS SET note='$parsed_pratnote' WHERE userid=$userid AND friendid=$numero");

				//zprava pro pritele
				$now=time()+$SUMMER_TIME;
				$his_login=getUserLogin($userid);
				_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $numero, '".$LNG_FRIENDS_CHANGE." ".$parsed_pratnote."', $now, 0, $numero, 0)");
			}
		}
	}




	if ($del == "smazat označené" && $db_passwd == $session_passwd) {
		$delprat_count = Count($delprat);
		echo "pocet oznacenych: ".$delprat_count;
		for ($i=0; $i<=$delprat_count-1; $i++) {
			echo "cislo pritele: ".$delprat[$i];
			_oxMod("DELETE FROM $TABLE_FRIENDS WHERE userid=$userid AND friendid=$delprat[$i]");

			$now=time()+$SUMMER_TIME;
			$his_login=getUserLogin($userid);
			_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $delprat[$i], '".$LNG_FRIENDS_DEL."', $now, 0, $delprat[$i], 0)");
		}
	}



	$result = _oxResult("SELECT $TABLE_USERS.login, $TABLE_USERS.location, $TABLE_USERS.lastaccess, $TABLE_USERS.regdate, $TABLE_USERS.AT, $TABLE_USERS.active, $TABLE_FRIENDS.friendid, $TABLE_FRIENDS.note FROM $TABLE_USERS, $TABLE_FRIENDS WHERE $TABLE_USERS.userid=$TABLE_FRIENDS.friendid AND $TABLE_FRIENDS.userid=$userid ORDER BY $TABLE_USERS.login ASC");
	$friend_num = mysql_num_rows($result);



}






if ($submodule_number==3) {

	$show_all = $_GET['show_all'];

	if ($show_all==1) {
		$usersResult = _oxResult("SELECT login, AT, level, location, lastaccess, regdate, status, active FROM $TABLE_USERS ORDER BY login ASC");
	}

	if ($show_all==2) {
		$usersResult = _oxResult("SELECT login, AT, level, location, lastaccess, regdate, status, active FROM $TABLE_USERS ORDER BY lastaccess DESC");
	}

	if ($show_all==3) {
		$usersResult = _oxResult("SELECT login, AT, level, location, lastaccess, regdate, status, active FROM $TABLE_USERS ORDER BY regdate DESC");
	}

	if ($show_all==4) {
		$usersResult = _oxResult("SELECT login, AT, level, location, lastaccess, regdate, status, active FROM $TABLE_USERS ORDER BY AT DESC");
	}
	
	if ($show_all==5) {
		$usersResult = _oxResult("SELECT login, AT, level, location, lastaccess, regdate, status, active FROM $TABLE_USERS ORDER BY level DESC");
	}
}

?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>

<? /* SUBMENU */ ?>
<?

if ($submodule_number==1) {
	//echo "vkladam aktivni";
	include('incl/users_online.php');
}
if ($submodule_number==2) {
	//echo "vkladam pratele";
	include('incl/users_friends.php');
}
if ($submodule_number==3) {
	//echo "vkladam vsichni";
	include('incl/users_all.php');
}
if ($submodule_number==4) {
	//echo "vkladam vyhledat";
	include('incl/users_search.php');
}

?>
<? /* SUBMENU */ ?>

