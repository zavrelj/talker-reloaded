<?

if ($changename == zmìnit && $db_passwd == $session_passwd) {
	if ($newroomname <> "") {
		if ($private) {$private_db=1;}else{$private_db=0;}
		_oxMod("UPDATE $TABLE_ROOMS SET name='$newroomname', private=$private_db WHERE roomid=$roomid");
		$roomname=$newroomname;
	}
}



if($change_cat == zmìnit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_ROOMS SET FK_topic=$change_category_select WHERE roomid=$roomid");
}



if ($changehome == vytvoøit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_ROOMS SET home='$homecontent_parsed', home_source='$homecontent_source' WHERE roomid=$roomid");
}




if ($changeminihome == vytvoøit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_ROOMS SET minihome='$minihomecontent_parsed', minihome_source='$minihomecontent_source' WHERE roomid=$roomid");
}




if ($seticon == zmìnit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_ROOMS SET icon='$icon' WHERE roomid=$roomid");
}



if ($changeowner == zmìnit && $db_passwd == $session_passwd) {
	$result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$newownername'");
	if (mysql_num_rows($result) != 0) {
		$record=mysql_fetch_array($result);
		$newownerid=$record["userid"];
		_oxMod("UPDATE $TABLE_ROOMS SET founderid=$newownerid WHERE roomid=$roomid");
		_oxMod("DELETE FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$newownerid AND FK_room=$roomid"); //pokud ma vlastnik predavany klub v oblibenych, smazu jeho zaznam
		_oxMod("UPDATE $TABLE_ROOMS_BOOKMARKS SET FK_user=$newownerid WHERE FK_room=$roomid AND FK_user=$userid"); //predam klub v oblibenych novemu vlastnikovi
		//PREDELAT
		_oxMod("INSERT INTO $TABLE_ROOMS_BOOKMARKS VALUES ($userid, $roomid)"); //sam si dam klub do oblibenych
		_oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count+1 WHERE roomid=$roomid"); //srovna stavy oblibenosti
		//zprava pro noveho vlastnika klubu
		$now=time()+$SUMMER_TIME;
		$result=_oxResult("SELECT name FROM $TABLE_ROOMS WHERE roomid=$roomid");
		$record=mysql_fetch_array($result);
		_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $newownerid, '".$LNG_DISCUSSION_OWNERSHIP." <a href=gate.php?m=10&s=1&roomid=".$roomid.">".$record["name"]."</a>', $now, 0, $newownerid, 0)");
	}
}



if ($changeallows == nastavit && $db_passwd == $session_passwd) {
	if ($delown) {
		_oxMod("UPDATE $TABLE_ROOMS SET delown=1 WHERE roomid=$roomid");
	}else{
		_oxMod("UPDATE $TABLE_ROOMS SET delown=0 WHERE roomid=$roomid");
	}


	if ($allowrite) {
		_oxMod("UPDATE $TABLE_ROOMS SET allowrite=1 WHERE roomid=$roomid");
	}else{
		_oxMod("UPDATE $TABLE_ROOMS SET allowrite=0 WHERE roomid=$roomid");
	}
}




if ($setkeepers == nastavit && $db_passwd == $session_passwd) {

	$result_auditor = _oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
	$record_auditor =mysql_fetch_array($result_auditor);
	$auditor=$record_auditor["founderid"];



	$keepers_arr = split(",", $keepers);
	$keepers_num = Count($keepers_arr);

	for ($i=0; $i<=$keepers_num-1; $i++) {
		$keepers_arr[$i]=trim($keepers_arr[$i]);
		$keeper_name=$keepers_arr[$i];
		$keepers_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$keeper_name' AND userid!=$auditor");
		if (mysql_num_rows($keepers_result) != 0) { //zamezim vytazeni neexistujiciho uzivatele
			$keepers_record=mysql_fetch_array($keepers_result);
			$keeper_id[$i] = $keepers_record["userid"];
		}
	}



	_oxMod("DELETE FROM $TABLE_ROOM_KEEPERS WHERE roomid=$roomid");


	$keepers_num = Count($keeper_id);
	for ($i=0; $i<=$keepers_num-1; $i++) {
		_oxMod("INSERT INTO $TABLE_ROOM_KEEPERS VALUES($roomid, $keeper_id[$i])");
	}
}





if ($setdeniers == nastavit && $db_passwd == $session_passwd) {

	$result_auditor = _oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
	$record_auditor =mysql_fetch_array($result_auditor);
	$auditor=$record_auditor["founderid"];



	$deniers_arr = split(",", $deniers);
	$deniers_num = Count($deniers_arr);

	for ($i=0; $i<=$deniers_num-1; $i++) {
		$deniers_arr[$i]=trim($deniers_arr[$i]);
		$denier_name=$deniers_arr[$i];
		$deniers_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$denier_name' AND userid!=$auditor");
		if (mysql_num_rows($deniers_result) != 0) {
			$deniers_record=mysql_fetch_array($deniers_result);
			$denier_id[$i] = $deniers_record["userid"];
		}
	}



	_oxMod("DELETE FROM $TABLE_ROOM_DENIERS WHERE roomid=$roomid");


	$deniers_num = Count($denier_id);
	for ($i=0; $i<=$deniers_num-1; $i++) {
		_oxMod("INSERT INTO $TABLE_ROOM_DENIERS VALUES($roomid, $denier_id[$i])");
	}

}





if ($set_banned_writers == nastavit && $db_passwd == $session_passwd) {

	$result_auditor = _oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
	$record_auditor =mysql_fetch_array($result_auditor);
	$auditor=$record_auditor["founderid"];



	$banned_writers_arr = split(",", $banned_writers);
	$banned_writers_num = Count($banned_writers_arr);

	for ($i=0; $i<=$banned_writers_num-1; $i++) {
		$banned_writers_arr[$i]=trim($banned_writers_arr[$i]);
		$banned_writer_name=$banned_writers_arr[$i];
		$banned_writers_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$banned_writer_name' AND userid!=$auditor");
		if (mysql_num_rows($banned_writers_result) != 0) {
			$banned_writers_record=mysql_fetch_array($banned_writers_result);
			$banned_writer_id[$i] = $banned_writers_record["userid"];
		}
	}


	//smaze stary seznam
	_oxMod("DELETE FROM $TABLE_ROOM_BANNED_WRITERS WHERE roomid=$roomid");


	$banned_writers_num = Count($banned_writer_id);
	for ($i=0; $i<=$banned_writers_num-1; $i++) {
		//zapise novy seznam
		_oxMod("INSERT INTO $TABLE_ROOM_BANNED_WRITERS VALUES($roomid, $banned_writer_id[$i])");
	}

}






if($destroy_pool==smazat && $db_passwd == $session_passwd) {
	_oxMod("DELETE FROM $TABLE_POOLS WHERE pool_id=$pool_id");
}



//zakomentovana podminka bohuzel v javascriptu nefunguje, zkusime zda je ZCELA funkcni druha
//if (($del == "smazat oznaèené" || $del == "smazat") && $db_passwd == $session_passwd) {
if (isSet($delmsg) && $db_passwd == $session_passwd) {
	echo "jsem tu";
	$delresult=_oxResult("SELECT date FROM $TABLE_ROOM WHERE roomid=$roomid");
	while($delrecord=MySQL_Fetch_array($delresult)) {
		$deldate=$delrecord["date"];

		for ($i=0; $i<Count($delmsg); $i++) {
			if ($delmsg[$i] == $deldate) {
				echo "mazu prispevek";
				_oxMod("DELETE FROM $TABLE_ROOM WHERE roomid=$roomid AND date=$delmsg[$i]");
				_oxMod("UPDATE $TABLE_ROOMS SET count=count-1 WHERE roomid=$roomid");
			}
		}
	}
}



/*
if($book == sledovat && $db_passwd == $session_passwd) {

	//nejdriv zkontroluje zda uz neni dana diskuze zabookovana - muze se stat stisknutim
	//F5, ze bude bookovat dvakrat to same
	$isAlreadyBookedArray = _oxQuery("SELECT FK_user FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
	if ($isAlreadyBookedArray['userid'] == "") {
		$now=time()+$SUMMER_TIME;
		//PREDELAT
		_oxMod("INSERT INTO $TABLE_ROOMS_BOOKMARKS VALUES ($userid, $roomid)");
		_oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count+1 WHERE roomid=$roomid");
	}
}


if($book == nesledovat && $db_passwd == $session_passwd) {
	_oxMod("DELETE FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
	_oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count-1 WHERE roomid=$roomid");
}
*/

if($set_password == "nastavit/zmìnit" && $db_passwd == $session_passwd) {
	//nastavi heslo diskuze
	$discussionDBPasswordArray = _oxQuery("SELECT discussion_password FROM $TABLE_ROOMS WHERE roomid=$roomid");
	$discussionDBPassword = $discussionDBPasswordArray['discussion_password'];

	if ($discussionDBPassword == $current_password && $new_password == $new_password2) {
		//pokud se zadane aktualni heslo shoduje s heslem v databazi
		//a zaroven se shoduji nova hesla, proved zmenu
		_oxMod("UPDATE $TABLE_ROOMS SET discussion_password='$new_password' WHERE roomid=$roomid");
	}else{
		echo "spatne aktualni heslo, nebo se hesla neshoduji";
	}
}

//ZOBRAZIT POUZE PRISPEVKY OD JEDNOHO UZIVATELE
if ($fuser_show=="zobrazit" && $db_passwd == $session_passwd) {
	$isOneUser = 1;

	//NAVIGACE
	//jelikoz je zmena poctu zobrazovanych prispevku navesena pres stisk
	//klavesy enter na zaslani prazdneho prispevku, je treba tady provest vynulovani
	//navigacnich hodnot, jinak to dela blbosti
	//odeslani skutecneho prispevku stejne zobrazi posledni prispevky, takze
	// pri teto situaci ono vynulovani vubec nevadi
	$frwdvalue= 0;
	$backvalue= 0;
	$startvalue= 0;
	$endvalue= 0;

}

//echo "FUSERID v discussion_actions.php:".$fuserid."<br />";
if ($fuserid!=null) {
	$isOneUser = 1;
}else{
	$isOneUser = 0;
}

//echo "isOne v discussion_actions.php: ".$isOneUser;

?>
