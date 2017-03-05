<?
$show_m = $_GET['show_m'];
$show_o = $_GET['show_o'];

$roomid = $_POST['roomid'];
$destroy = $_POST['destroy'];
$book = $_POST['book'];


$set_book_option = $_POST['set_book_option'];
$show_new_box = $_POST['show_new_box'];
$show_room_ico_box = $_POST['show_room_ico_box'];
$show_pool_box = $_POST['show_pool_box'];
$show_home_box = $_POST['show_home_box'];







if($book == sledovat && $db_passwd == $session_passwd) {

	//nejdriv zkontroluje zda uz neni dana diskuze zabookovana - muze se stat stisknutim
	//F5, ze bude bookovat dvakrat to same
	$isAlreadyBookedArray = _oxQuery("SELECT FK_user FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
	if ($isAlreadyBookedArray['userid'] == "") {
		_oxMod("INSERT INTO $TABLE_ROOMS_BOOKMARKS VALUES ($userid, $roomid)");
		_oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count+1 WHERE roomid=$roomid");
	}
}





if($book == nesledovat && $db_passwd == $session_passwd) {
	_oxMod("DELETE FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
	_oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count-1 WHERE roomid=$roomid");
}




if($destroy == ano && $db_passwd == $session_passwd) {
	// odstrani zaznam o klubu v tabulce bookmark a rooms, vymaze ankety klubu
	_oxMod("DELETE FROM $TABLE_ROOMS WHERE roomid=$roomid");
	_oxMod("DELETE FROM $TABLE_ROOM WHERE roomid=$roomid");
	_oxMod("DELETE FROM $TABLE_ROOMS_ACCESS WHERE FK_room=$roomid");
	_oxMod("DELETE FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_room=$roomid");
	_oxMod("DELETE FROM $TABLE_POOLS WHERE roomid=$roomid");
	_oxMod("DELETE FROM $TABLE_ROOM_DENIERS WHERE roomid=$roomid");
	_oxMod("DELETE FROM $TABLE_ROOM_KEEPERS WHERE roomid=$roomid");
	_oxMod("DELETE FROM $TABLE_ROOM_VIEWERS WHERE roomid=$roomid");
}





if($set_book_option == nastavit && $db_passwd == $session_passwd) {

	if ($show_new_box==true) {
		_oxMod("UPDATE $TABLE_USERS SET show_new=1 WHERE userid=$userid");
	}else{
		_oxMod("UPDATE $TABLE_USERS SET show_new=0 WHERE userid=$userid");
	}

	if ($show_room_ico_box==true) {
		_oxMod("UPDATE $TABLE_USERS SET show_room_ico=1 WHERE userid=$userid");
	}else{
		_oxMod("UPDATE $TABLE_USERS SET show_room_ico=0 WHERE userid=$userid");
	}

	if ($show_pool_box==true) {
		_oxMod("UPDATE $TABLE_USERS SET show_pool=1 WHERE userid=$userid");
	}else{
		_oxMod("UPDATE $TABLE_USERS SET show_pool=0 WHERE userid=$userid");
	}

	if ($show_home_box==true) {
			_oxMod("UPDATE $TABLE_USERS SET show_home=1 WHERE userid=$userid");
		}else{
			_oxMod("UPDATE $TABLE_USERS SET show_home=0 WHERE userid=$userid");
	}
}





//zjisti, zda uzivateli zobrazit vsechny diskuze, nebo pouze ty s novymi prispevky
$result=_oxResult("SELECT show_new, show_room_ico, show_pool, show_home FROM $TABLE_USERS WHERE userid=$userid");
$record=mysql_fetch_array($result);
$show_new=$record["show_new"];
$show_room_ico=$record["show_room_ico"];
$show_pool=$record["show_pool"];
$show_home=$record["show_home"];



?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>



Kliknutím na odkaz <u>Moje diskuze</u> / <u>Sledované diskuze</u> dojde k vypsání všech diskuzí
bez ohledu na aktuální nastavení výpisu.


<? /* VLASTNI DISKUZE */ ?>
<div class="bookmark_header"><a href="gate.php?m=6&show_m=1"><? echo $LNG_BOOKMARKS_MY_DISCUSSIONS; ?></a></div>

			<?
			$booklist_type="0"; //nastavuje typ vypisu pro vlastni diskuze
			$resultBookmarks = _oxResult("SELECT $TABLE_ROOMS_BOOKMARKS.FK_room, $TABLE_ROOMS_ACCESS.access_time, $TABLE_ROOMS.name, $TABLE_ROOMS.count, $TABLE_ROOMS.FK_topic, $TABLE_ROOMS.home, $TABLE_ROOMS.icon FROM $TABLE_ROOMS_BOOKMARKS, $TABLE_ROOMS_ACCESS, $TABLE_ROOMS WHERE $TABLE_ROOMS_BOOKMARKS.FK_user=$userid AND $TABLE_ROOMS_BOOKMARKS.FK_room = $TABLE_ROOMS_ACCESS.FK_room AND $TABLE_ROOMS_BOOKMARKS.FK_room = $TABLE_ROOMS.roomid AND $TABLE_ROOMS_BOOKMARKS.FK_user=$TABLE_ROOMS.founderid AND $TABLE_ROOMS_ACCESS.FK_user = $userid ORDER BY $TABLE_ROOMS.name ASC");
			//$numerows = mysql_num_rows($resultBookmarks);

			while($record=MySQL_Fetch_array($resultBookmarks)) {

					$bookid = $record['FK_room'];
					$lastaccess = $record['access_time'];
					$room_name = $record["name"];
					$room_count = $record["count"];
					$topic_id = $record["FK_topic"];
					$topic_name = getTopicName($topic_id);
					$room_home = $record["home"];
					$room_icon = $record["icon"];

					if ($show_pool==0) {
						$pool_result = _oxResult("SELECT roomid FROM $TABLE_POOLS WHERE roomid=$bookid AND archive=0");

						if(mysql_num_rows($pool_result)!=0) {
							$pool_record=mysql_fetch_array($pool_result);
							$pool_roomid=$pool_record["roomid"];
						}else{
							$pool_roomid=-1;
						}
					}

					$res_new_one = _oxResult("SELECT COUNT(fromid) AS fromid FROM $TABLE_ROOM WHERE roomid=$bookid AND date > $lastaccess AND fromid <> $userid");
					$rec_new_one = mysql_fetch_array($res_new_one);
					$count_new_one = $rec_new_one["fromid"];

					//pokud ma klub nove prispevky, vypis ho
					if ($count_new_one!=0 && $show_new==1 && $show_m!=1) { ?>
						<? include('incl/bookmarks_list.php'); ?>
					<? }

					//vypis vsechny kluby
					if ($show_new==0 || $show_m==1) { ?>
						<? include('incl/bookmarks_list.php'); ?>
					<? } ?>

			<? } ?>


<? /* SLEDOVANE DISKUZE */ ?>
<div class="bookmark_header"><a href="gate.php?m=6&show_o=1" class="bookmodul"><? echo $LNG_BOOKMARKS_BOOKED_DISCUSSIONS; ?></a></div>

			<?
			$booklist_type="1"; //nastavuje typ vypisu pro sledovane diskuze
			$resultBookmarks = _oxResult("SELECT $TABLE_ROOMS_BOOKMARKS.FK_room, $TABLE_ROOMS_ACCESS.access_time, $TABLE_ROOMS.founderid, $TABLE_ROOMS.name, $TABLE_ROOMS.count, $TABLE_ROOMS.FK_topic, $TABLE_ROOMS.home, $TABLE_ROOMS.icon FROM $TABLE_ROOMS_BOOKMARKS, $TABLE_ROOMS_ACCESS, $TABLE_ROOMS WHERE ($TABLE_ROOMS_BOOKMARKS.FK_user=$userid) AND ($TABLE_ROOMS_BOOKMARKS.FK_room=$TABLE_ROOMS_ACCESS.FK_room) AND ($TABLE_ROOMS_BOOKMARKS.FK_room = $TABLE_ROOMS.roomid) AND ($TABLE_ROOMS_BOOKMARKS.FK_user!=$TABLE_ROOMS.founderid) AND $TABLE_ROOMS_ACCESS.FK_user = $userid ORDER BY $TABLE_ROOMS.name ASC");

			while($record=MySQL_Fetch_array($resultBookmarks)) {

				$founder = getUserLogin($record["founderid"]);
            	$bookid = $record["FK_room"];
				$room_name = $record["name"];
				$room_count = $record["count"];
				$topic_id=$record["FK_topic"];
				$topic_name = getTopicName($topic_id);
				$last_access = $record["access_time"];
				$room_home = $record["home"];
				$room_icon = $record["icon"];

				if ($show_pool==0) {
					$pool_result=_oxResult("SELECT roomid FROM $TABLE_POOLS WHERE roomid=$bookid");

					if(mysql_num_rows($pool_result)!=0) {
						$pool_record=mysql_fetch_array($pool_result);
						$pool_roomid=$pool_record["roomid"];
					}else{
						$pool_roomid=-1;
					}
				}

				$res_new_one = _oxResult("SELECT COUNT(fromid) AS fromid FROM $TABLE_ROOM WHERE roomid=$bookid AND date > $last_access AND fromid <> $userid");
				$rec_new_one = mysql_fetch_array($res_new_one);
				$count_new_one = $rec_new_one["fromid"];

				//pokud ma klub nove prispevky, vypis ho
				if ($count_new_one!=0 && $show_new==1 && $show_o!=1) { ?>
					<? include('incl/bookmarks_list.php'); ?>
             	<? }

				//vypis vsechny kluby
				if ($show_new==0 || $show_o==1) { ?>
					<? include('incl/bookmarks_list.php'); ?>
				<? } ?>

			<? } ?>

<form action="gate.php?m=6" method="post">
<fieldset>
	<legend>nastavit výpis diskuzí</legend>
		<div>
			<input type="checkbox" name="show_new_box" value="true" <? if ($show_new==1) {echo 'checked="checked"';}?>>
			<label>vypisovat pouze diskuze s novými příspěvky</label>
		</div>
		<div>
			<input type="checkbox" name="show_room_ico_box" value="true" <? if ($show_room_ico==1) {echo 'checked="checked"';}?>>
			<label>nezobrazovat ikonky diskuzí</label>
		</div>
		<div>
			<input type="checkbox" name="show_pool_box" value="true" <? if ($show_pool==1) {echo 'checked="checked"';}?>>
			<label>nezobrazovat zda mají diskuze ankety</label>
		</div>
		<div>
			<input type="checkbox" name="show_home_box" value="true" <? if ($show_home==1) {echo 'checked="checked"';}?>>
			<label>nezobrazovat zda mají diskuze homepage</label>
		</div>
		<div>
			<input type="submit" name="set_book_option" value="nastavit">
		</div>
</fieldset>
</form>
