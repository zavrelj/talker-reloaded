<?

$privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
$is_private = $privateArray["private"];
if ($is_private != 0) {
	$sess_out = updatelastaction($userid, "privátní diskuzi na homepage");
}else{
	$sess_out = updatelastaction($userid, $roomid.";na homepage");
}

$changehome = $_POST['changehome'];
$homecontent_source = $_POST['homecontent_source'];

$homecontent_parsed = replaceMessage($homecontent_source);
$homecontent_parsed = addslashes($homecontent_parsed);

if ($changehome == upravit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_ROOMS SET home='$homecontent_parsed', home_source='$homecontent_source' WHERE roomid=$roomid");
}

$result=_oxResult("SELECT name, home, home_source, founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
$record=mysql_fetch_array($result);
$roomname=$record["name"];
$homecontent_parsed=$record["home"];
$homecontent_source=$record["home_source"];


$owner_id=$record["founderid"];





$keepers_result=_oxResult("SELECT keeper_id FROM $TABLE_ROOM_KEEPERS WHERE roomid=$roomid");
if (mysql_num_rows($keepers_result) != 0) {
	while($keepers_record=mysql_fetch_array($keepers_result)) {
		$keeper_id=$keepers_record["keeper_id"];
		$keeper_name=getUserLogin($keeper_id);
		if ($keepers!="") {
			$keepers=$keepers.", ".$keeper_name;
		}else{
			$keepers=$keeper_name;
		}



		$allower_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$keeper_name' AND userid!=$owner_id");
		if (mysql_num_rows($allower_result) != 0) {
			$allower_record=mysql_fetch_array($allower_result);
			if ($allower_record["user_id"] == $userid) {
				$allower=$userid;
			}
		}else{
			$allower=0;
		}

	}
}else{
	$keepers="";
	$allower=0;
}


/*
if ($owner_id != $userid && $allower != $userid) {
	session_destroy();
	//header("location: logout.php?userid=$userid");
	die();
}
*/


//deniers - uzivatele, kteri maji zakazany pristup do klubu

$deniers_result=_oxResult("SELECT denier_id FROM $TABLE_ROOM_DENIERS WHERE roomid=$roomid");
if (mysql_num_rows($deniers_result) != 0) {
	while($deniers_record=mysql_fetch_array($deniers_result)) {
		if ($deniers_record["denier_id"] == $userid) {
				$denyier=$userid;
		}
	}
}

?>


<? if ($denyier!=$userid) { ?>

		<? echo stripslashes($homecontent_parsed); ?>

		<? if ($owner_id==$userid || $allower==$userid) {  ?>
		<form action="gate.php?m=10&s=3" method="post">
		upravit homepage diskuze
		<textarea name="homecontent_source" rows="20" cols="100"><? echo "$homecontent_source"; ?></textarea>
		<input type="hidden" name="roomid" value="<? echo $roomid ?>">
		<input type="submit" name="changehome" value="upravit" class="button">
		</form>
		<? } ?>

<? } ?>







