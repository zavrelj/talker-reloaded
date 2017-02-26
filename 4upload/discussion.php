<?

//echo $auditor;
//echo $userid;
//echo $set_password;
//echo $current_password;
//echo $new_password;
//echo $new_password2;

//echo "discussionFormPassword:".$discussionFormPassword;

//echo "roomid: ".$roomid;

/******pravdepodobne zbytecne - toto resi skript uvedeny vyse
if (!IsSet($roomid) && !IsSet($create_room)) { //pokud neexistuje roomid, vyhodit
	session_destroy();
	//header("location: logout.php?userid=$userid");
	//die();
}
*/

//echo "lalala";

include('incl/discussion_actions.php');

//echo "po incluzi akci";
//echo "roomid: ".$roomid;

//vytahnu si posledni pistup uzivatele do diskuze kvuli zobrazovani prispevku
$accessresult = _oxResult("SELECT access_time FROM $TABLE_ROOMS_ACCESS WHERE FK_user=$userid AND FK_room=$roomid");
$accessrecord= mysql_fetch_array($accessresult);
$lastaccess = $accessrecord["access_time"];

//echo "po incluzi akci";

//aktualizuje posledni pristup do sledovane diskuze
$now=time()+$SUMMER_TIME;
_oxMod("UPDATE $TABLE_ROOMS_ACCESS SET access_time=$now WHERE FK_user=$userid AND FK_room=$roomid");



$result2 = _oxResult("SELECT name, founderid, delown, allowrite, home, minihome, private, icon FROM $TABLE_ROOMS WHERE roomid=$roomid");
$record2 =mysql_fetch_array($result2);
$roomname=$record2["name"];
$auditor=$record2["founderid"];
$auditorname = getUserLogin($auditor);
$delownvalue=$record2["delown"];
$allowritevalue=$record2["allowrite"];
$homepage=$record2["home"];
$minihomepage=$record2["minihome"];
$private_db=$record2["private"];
$icon_db=$record2["icon"];


$viewers_result=_oxResult("SELECT viewer_id FROM $TABLE_ROOM_VIEWERS WHERE viewer_id=$userid AND roomid=$roomid");
$now=time() + $SUMMER_TIME;
if (mysql_num_rows($viewers_result) != 0) {
	_oxMod("UPDATE $TABLE_ROOM_VIEWERS SET last_access=$now WHERE viewer_id=$userid AND roomid=$roomid");
}else{
	_oxMod("INSERT INTO $TABLE_ROOM_VIEWERS VALUES ($roomid, $userid, $now)");
}




$deniers_result=_oxResult("SELECT denier_id FROM $TABLE_ROOM_DENIERS WHERE roomid=$roomid");
if (mysql_num_rows($deniers_result) != 0) {
	while($deniers_record=mysql_fetch_array($deniers_result)) {
		if ($deniers_record["denier_id"] == $userid) { //pokud je moje id mezi zakazanymi, nastavim si prepinac na userid
				$denyier=$userid;
		}
	}
}



$banned_writers_result=_oxResult("SELECT banned_writer_id FROM $TABLE_ROOM_BANNED_WRITERS WHERE roomid=$roomid");
if (mysql_num_rows($banned_writers_result) != 0) {
	while($banned_writers_record=mysql_fetch_array($banned_writers_result)) {
		if ($banned_writers_record["banned_writer_id"] == $userid) { //pokud je moje id mezi zakazanymi, nastavim si prepinac na userid
				$banned_wryiter=$userid;
		}
	}
}






//pokud odpovida cislo prihlaseneho uzivatele cislu spravce dane diskuze v databazi
//nastavime prepinac allower na toto cislo
$keepers_result=_oxResult("SELECT keeper_id FROM $TABLE_ROOM_KEEPERS WHERE roomid=$roomid");
if (mysql_num_rows($keepers_result) != 0) {
	while($keepers_record=mysql_fetch_array($keepers_result)) {
		if ($keepers_record["keeper_id"] == $userid) { //pokud je moje id mezi spravci, nastavim si prepinac na userid
				$allower=$userid;
		}
	}
}else{
	$allower=0;
}





$pool_result=_oxResult("SELECT pool_id FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=0");
$pool_num_rows=mysql_num_rows($pool_result);




$tips_num=rand(0, count($TIPS)-1);


//echo "pred navi";

include('incl/navi.php');


/*
//zjistime, zda je diskuze sledovana a podle toho nastavime volbu
$result3 = _oxResult("SELECT FK_user FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
$record3 = mysql_fetch_array($result3);
if ($record3 != "") {
	$bookvalue="nesledovat";
}else{
	$bookvalue="sledovat";
}
*/



//echo "po navi";







//zde se zjisti, zda uz byl nekdy uzivatel v teto diskuzi
//pokud ano, aktualizuje se jeho zaznam, pokud ne, vytvori se novy
$now = time()+$SUMMER_TIME;
//echo "roomid: ".$roomid."<br>";
$resultAccess = _oxResult("SELECT FK_user FROM $TABLE_ROOMS_ACCESS WHERE FK_room=$roomid AND FK_user=$userid");
if (mysql_num_rows($resultAccess)==0) {
	//echo "jsem tu poprve";
	_oxMod("INSERT INTO $TABLE_ROOMS_ACCESS VALUES ($userid, $roomid, $now)");
}else{
	//echo "updatuji datum pristupu";
	_oxMod("UPDATE $TABLE_ROOMS_ACCESS SET access_time=$now WHERE FK_user=$userid AND FK_room=$roomid");
}


//zjistim, zda pro diskuzi existuje v DB pristupove heslo, pokud ano, vyzadam si od
//uzivatele jeho zadani
$discussionDBPasswordArray = _oxQuery("SELECT discussion_password FROM $TABLE_ROOMS WHERE roomid=$roomid");
$discussionDBPassword = $discussionDBPasswordArray['discussion_password'];
//echo "<br>".$discussionDBPassword."<br>";

?>



<? if ($denyier==$userid) { ?>
	zakázaný pøístup do diskuze, kontaktujte správce
	(<a href="gate.php?m=2&selrec=<?echo $auditorname;?>"><? echo $auditorname; ?></a>)
<? } ?>

<? if($discussionDBPassword != "" && $_SESSION['current_discussion_id'] != $roomid && ($discussionFormPassword == "" || $discussionFormPassword != $discussionDBPassword)) { ?>
	pro pøístup do diskuze musíte zadat heslo
	<form method="post" action="gate.php?m=10&s=1">
		<label>heslo diskuze</label>
		<input name="check_password" type="password" />
		<input name="roomid" type="hidden" value="<? echo $roomid?>">
		<input type="submit" value="vstoupit">
	</form>
<? }else{ ?>
	<?
	//pokud bylo heslo zadano spravne, nebo neni vyzadovano, zapiseme do sezeni id aktualni diskuze
	//v pripade, ze budeme chtit provest s diskuzi jakoukoliv akci, bude nejprve zjisteno, zda se
	//hodnota id diskuze v session shoduje s id aktualni diskuze, pokud ano, vse se provede bez problemu
	//pokud ne, bude vyzadovano heslo
	$_SESSION['current_discussion_id'] = $roomid;
	?>

	<? /* SUBMENU */ ?>
	<? //include('incl/sub_menu.php'); ?>
	<? /* SUBMENU */ ?>

	<? /* SUBMENU */ ?>
	<?
	if ($submodule_number==1) {
		//echo "vkladam diskuzi";
		include('incl/room_bulletin.php');
	}
	if ($submodule_number==2) {
		//echo "vkladam anketu";
		include('incl/room_survey.php');
	}
	if ($submodule_number==3) {
		//echo "vkladam homepage";
		include('incl/room_homepage.php');
	}
	if ($submodule_number==4) {
		//echo "vkladam statistiku";
		include('incl/room_statistics.php');
	}
	if ($submodule_number==5) {
		//echo "vkladam online";
		include('incl/room_online_users.php');
	}
	if ($submodule_number==6) {
		//echo "vkladam spravce";
		include('incl/room_admins.php');
	}
	if ($submodule_number==7) {
		//echo "vkladam zakazy";
		include('incl/room_admins.php');
	}
	if ($submodule_number==8) {
		//echo "vkladam nastaveni";
		include('incl/room_settings.php');
	}
	if ($submodule_number==10) {
		//echo "vkladam odstraneni";
		include('incl/room_destroy.php');
	}
	if ($submodule_number==11) {
		//echo "vkladam vyhledani prispevku daneho uzivatele";
		include('incl/room_user_search.php');
	}

	?>
	<? /* SUBMENU */ ?>

<? } ?>



