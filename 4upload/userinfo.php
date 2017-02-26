<?
$now=time()+$SUMMER_TIME;

$user_info = $_POST['user_info'];
$show_info = $_POST['show_info'];

if ($submodule_number==1) {
	$userInfoArray = _oxQuery("SELECT login, regdate, lastaccess, AT, active, location FROM $TABLE_USERS WHERE userid=$fuserid");

	$user_info_login = $userInfoArray["login"];
	$user_info_regdate = $userInfoArray["regdate"];
	$user_info_lastaccess = $userInfoArray["lastaccess"];
	$user_info_AT = $userInfoArray["AT"];
	$user_info_active = $userInfoArray["active"];
	$user_info_location = $userInfoArray["location"];

	$userLocationArray = getLocation($user_info_location);
	$user_info_location = $userLocationArray['infolocation'];
	$user_location_number = $userLocationArray['location_number'];
	$user_location_dscrb = $locationArray['location_dscrb'];
}



/*
if ($submodule_number==2) {

	//prijem a zapis informaci do DB
	$setdetails = $_POST['setdetails'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$birth = $_POST['birth'];
	$age = $_POST['age'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$e_mail = $_POST['e_mail'];
	$web = $_POST['web'];
	$icq = $_POST['icq'];
	$hobby = $_POST['hobby'];
	$sex = $_POST['sex'];
	$single = $_POST['single'];
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$eyes = $_POST['eyes'];
	$hair = $_POST['hair'];

	if ($setdetails == nastavit && $db_passwd == $session_passwd) {
		_oxMod("UPDATE $TABLE_USERS SET name='$name', surname='$surname', birth='$birth', age='$age', address='$address', phone='$phone', e_mail='$e_mail', web='$web', icq='$icq', hobby='$hobby', sex='$sex', single='$single', height='$height', weight='$weight', eyes='$eyes', hair='$hair' WHERE userid=$userid");
	}


	//ziskani informaci z DB a jejich vypis
	$userInfoArray = _oxQuery("SELECT login, name, surname, birth, age, address, phone, e_mail, web, icq, hobby, sex, single, height, weight, eyes, hair FROM $TABLE_USERS WHERE userid=$fuserid");

	$user_info_login = $userInfoArray["login"];
	$user_info_name = $userInfoArray["name"];
	$user_info_surname = $userInfoArray["surname"];
	$user_info_birth = $userInfoArray["birth"];
	$user_info_age = $userInfoArray["age"];
	$user_info_address = $userInfoArray["address"];
	$user_info_phone = $userInfoArray["phone"];
	$user_info_email = $userInfoArray["e_mail"];
	$user_info_web = $userInfoArray["web"];
	$user_info_icq = $userInfoArray["icq"];
	$user_info_hobby = $userInfoArray["hobby"];
	$user_info_sex = $userInfoArray["sex"];
	$user_info_single = $userInfoArray["single"];
	$user_info_height = $userInfoArray["height"];
	$user_info_weight = $userInfoArray["weight"];
	$user_info_eyes = $userInfoArray["eyes"];
	$user_info_hair = $userInfoArray["hair"];

	if ($user_info_name=="" && $user_info_surname=="" && $user_info_birth=="" && $user_info_age=="" && $user_info_address=="" && $user_info_phone=="" && $user_info_email=="" && $user_info_web=="" && $user_info_icq=="" && $user_info_hobby=="" && $user_info_sex=="" && $user_info_single=="" && $user_info_height=="" && $user_info_weight=="" && $user_info_eyes=="" && $user_info_hair=="") {
		$detail_info = 0;
	}else{
		$detail_info = 1;
	}
}
*/





if ($submodule_number==3) {
	$userInfoArray = _oxQuery("SELECT login, viewers FROM $TABLE_USERS WHERE userid=$fuserid");

	$user_info_login = $userInfoArray["login"];
	$user_info_viewers = $userInfoArray["viewers"];
	$user_info_viewers_id = split(",", $user_info_viewers); //rozdelim viewers podle carky
	$user_info_viewers_num=Count($user_info_viewers_id);

	if ($user_info_viewers == "") {
		$user_info_viewers = $user_info_viewers.$userid.",";
		_oxMod("UPDATE $TABLE_USERS SET viewers='$user_info_viewers' WHERE userid=$fuserid");
	}else{
		$user_info_viewers_arr = split(",", $user_info_viewers);

		if (!in_array ($userid, $user_info_viewers_arr)) {
			$user_info_viewers = $user_info_viewers.$userid.",";
			_oxMod("UPDATE $TABLE_USERS SET viewers='$user_info_viewers' WHERE userid=$fuserid");
		}
	}
}





if ($submodule_number==4) {
	$user_info_login = getUserLogin($fuserid);

	$fameresult = _oxResult("SELECT login, note FROM $TABLE_USERS, $TABLE_FRIENDS WHERE $TABLE_USERS.userid=$TABLE_FRIENDS.userid and $TABLE_FRIENDS.friendid=$fuserid ORDER BY login ASC");
	$famecount = mysql_num_rows($fameresult);
}




if ($submodule_number==5) {
	$user_info_login = getUserLogin($fuserid);

	$room_result = _oxResult("SELECT roomid, name, founderid, count, private FROM $TABLE_ROOMS WHERE founderid=$fuserid ORDER BY name ASC");
	$room_num_rows = mysql_num_rows($room_result);

	$book_result = _oxResult("SELECT $TABLE_ROOMS.roomid, $TABLE_ROOMS.name, $TABLE_ROOMS.founderid, $TABLE_ROOMS.count, $TABLE_ROOMS.private FROM $TABLE_ROOMS, $TABLE_ROOMS_BOOKMARKS WHERE $TABLE_ROOMS.roomid=$TABLE_ROOMS_BOOKMARKS.FK_room AND $TABLE_ROOMS_BOOKMARKS.FK_user=$fuserid AND $TABLE_ROOMS_BOOKMARKS.FK_user!=$TABLE_ROOMS.founderid ORDER BY name ASC");
	$book_num_rows = mysql_num_rows($book_result);
}



if ($submodule_number==6) {
	//echo "jsem v userinfu<br>";

	$changepage = $_POST['changepage'];

	$messageContent = $_POST['message_content'];

	//echo "normal: ".$messageContent."<br>";


	/*****************************
	V DB existuji dve verze textu - jedna pro WYSIWYG, druha pro PLAINTEXT
	Podle toho v cem piseme, ulozime source a parsed verzi a pote vytahneme
	z DB verzi, podle toho, ktery editor je zapnuty.
	Pokud bylo psano ve WYSIWYGU a mame zapnuty PLAINTEXT, vypiseme upozorneni,
	opacne zrovna tak....










	/****PUVODNI VERZE
	//replaceMessage a addslashes se provede pouze v plaintext modech a v TinyMCE
	if ($editor == 0 || $editor == 1 || $editor == 3) {
			$parsedMessageContent = replaceMessage($messageContent);
			$parsedMessageContent = addslashes($parsedMessageContent);
		}else{
			$parsedMessageContent = $messageContent;
	}
	*/



	//replaceMessage a addslashes se provede pouze v plaintext modech a v TinyMCE
	if ($editor == 0 || $editor == 1) {
		//echo "EDITOR JE PLAINTEXT<br>";
		$parsedMessageContent = replaceMessage($messageContent);

		$parsedMessageContent = addslashes($parsedMessageContent);
	}elseif ($editor == 3){
		$parsedMessageContent = replaceUrl($messageContent);
		$parsedMessageContent = replaceImg($messageContent);

		$parsedMessageContent = addslashes($parsedMessageContent);

	}else{
		$parsedMessageContent = $messageContent;
	}

	//echo "jsem v userinfu<br>";

	//echo "parsed: ".$parsedMessageContent."<br>";
	//echo "normal: ".$messageContent."<br>";
	//echo "userid: ".$userid."<br>";


	if ($changepage == upravit && $db_passwd == $session_passwd) {
		//pokud je editorem plaintext, editor_type je 0
		if ($editor == 0 || $editor == 1) {
			_oxMod("UPDATE $TABLE_USERS SET infopage='$parsedMessageContent', infopage_source='$messageContent', infopage_editor_type=0 WHERE userid=$userid");
		}else{
			_oxMod("UPDATE $TABLE_USERS SET infopage='$parsedMessageContent', infopage_source='$messageContent', infopage_editor_type=1 WHERE userid=$userid");
		}
	}

	$result=_oxResult("SELECT infopage, infopage_source, infopage_editor_type FROM $TABLE_USERS WHERE userid=$fuserid");
	$record=mysql_fetch_array($result);


	//POKUD existuje parsovany text, budu resit jak byl napsan, jinak vypisu prazdne hodnoty
	if ($record["infopage"]!="") {

		//echo $record["infopage_editor_type"];
		//echo $editor;
		//pokud mame nastaven PLAINTEXT editor a text byl napsan v PLAINTEXTU, zobraz
		if (($editor == 0 || $editor == 1) && $record["infopage_editor_type"]==0) {
			$wrong_editor=0;
			$parsedMessageContent = $record["infopage"];
			$messageContent = $record["infopage_source"];
		}else{

			$messageContent = "NEUKLADAT! NEBYLO NAPSANO PLAINTEXT EDITOREM!!!";
			$wrong_editor=1;

			//pokud mame nastaven WYSIWYG editor a text byl napsan ve WYSIWYGU, zobraz
			if (($editor == 3) && $record["infopage_editor_type"]==1) {
				$wrong_editor=0;
				$parsedMessageContent = $record["infopage"];
				$messageContent = $record["infopage_source"];
			}else{
				$messageContent = "NEUKLADAT! NEBYLO NAPSANO WYSIWYG EDITOREM!!!";
				$wrong_editor=1;
			}



		}




	}else{
		$messageContent = "";
	}



	//echo "jsem v userinfu<br>";


}


if ($submodule_number==7) {
	$user_info_login = getUserLogin($fuserid);

	$userLogsResult = _oxResult("SELECT log_time, log_IP, log_host, log_agent FROM $TABLE_LOGS WHERE FK_user=$fuserid ORDER BY log_time DESC");
}






//$info_page = $inforecord["infopage"];
?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>

<div>

<? /* SUBMENU */ ?>
<?

if ($submodule_number==1) {
	//echo "vkladam zakladni info";
	include('incl/userinfo_basic.php');
}
if ($submodule_number==2) {
	//echo "vkladam detailni info";
	include('incl/userinfo_details.php');
}
if ($submodule_number==3) {
	//echo "vkladam statistiky";
	include('incl/userinfo_stats.php');
}
if ($submodule_number==4) {
	//echo "vkladam komentare";
	include('incl/userinfo_comments.php');
}
if ($submodule_number==5) {
	//echo "vkladam diskuze";
	include('incl/userinfo_discussions.php');
}
if ($submodule_number==6) {
	//echo "vkladam osobni stranku";
	include('incl/userinfo_userpage.php');
}
if ($submodule_number==7) {
	//echo "vkladam prihlaseni";
	include('incl/userinfo_logs.php');
}


?>
<? /* SUBMENU */ ?>

</div>		
