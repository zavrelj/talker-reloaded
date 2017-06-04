<?

$vote = $_POST['vote'];
$create_pool = $_POST['create_pool'];
$destroy = $_POST['destroy'];
$anonym = $_POST['anonym'];
$question = $_POST['question'];
$answ01 = $_POST['answ01'];
$answ02 = $_POST['answ02'];
$answ03 = $_POST['answ03'];
$answ04 = $_POST['answ04'];
$answ05 = $_POST['answ05'];
$answ06 = $_POST['answ06'];
$answ07 = $_POST['answ07'];
$answ08 = $_POST['answ08'];
$answ09 = $_POST['answ09'];
$pool_radio = $_POST['pool_radio'];
$pool_id = $_POST['pool_id'];
$archive = $_POST['archive'];
$destroy_pool = $_POST['destroy_pool'];

$privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
$is_private = $privateArray["private"];
if ($is_private != 0) {
	$sess_out = updatelastaction($userid, "priv�tn� diskuzi v anket�");
}else{
	$sess_out = updatelastaction($userid, $roomid.";v anket�");
}

$result=_oxResult("SELECT name, founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
$record=mysql_fetch_array($result);
$roomname=$record["name"];
$room_founderid=$record["founderid"];



if($destroy_pool==smazat && $db_passwd == $session_passwd) {
	_oxMod("DELETE FROM $TABLE_POOLS WHERE pool_id=$pool_id");
}


if($vote == hlasovat && $db_passwd == $session_passwd) {
	$pool_radio++; // zvyseni je potreba aby souhlasili indexy, nebot pole je indexovano od 0, zatimco odpovedi od 1
	$result=_oxResult("SELECT voters FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=0");
	$record=mysql_fetch_array($result);
	$voters=$record["voters"];

	$voters=$voters.$pool_radio.$userid.";";

	_oxMod("UPDATE $TABLE_POOLS SET answ0".$pool_radio."=answ0".$pool_radio."+1, voters='$voters' WHERE pool_id=$pool_id");

}


if ($create_pool == vytvo�it && $db_passwd == $session_passwd) {

	$result=_oxResult("SELECT pool_id FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=0");
	$record=mysql_fetch_array($result);
	$pool_id=$record["pool_id"];



	$pool_data = Array($answ01, $answ02, $answ03, $answ04, $answ05, $answ06, $answ07, $answ08, $answ09);

	for ($i=0; $i<=8; $i++) {
		if ($pool_data[$i] != "") {
			$count++;
			$answ_text = $answ_text.$pool_data[$i]."#";
		}
	}

	if($destroy == del) {
			//vyhledam soucasnou anketu a smazu ji, vytvorim novou anketu
			_oxMod("DELETE FROM $TABLE_POOLS WHERE pool_id=$pool_id");
	}

	if($destroy == archive) {
			//vyhledam soucasnou anketu stavajiciho klubu, nastavim ji archive na 1 a vytvorim zcela novou anketu
			_oxMod("UPDATE $TABLE_POOLS SET archive=1 WHERE pool_id=$pool_id");
	}

	if ($anonym) {
			_oxMod("INSERT INTO $TABLE_POOLS VALUES(LAST_INSERT_ID(), $roomid, '$question', '', '', '', '', '', '', '', '', '', $count, '$answ_text', 0,'',0)");
		}else{
			_oxMod("INSERT INTO $TABLE_POOLS VALUES(LAST_INSERT_ID(), $roomid, '$question', '', '', '', '', '', '', '', '', '', $count, '$answ_text', 0,'',1)");
	}

}


$result=_oxResult("SELECT voters FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=0");
$record=mysql_fetch_array($result);
$voters=$record["voters"];
$voters_arr = split(";", $voters); //rozdelim voters podle stredniku
$voters_num = Count($voters_arr);

for ($i=0; $i<=$voters_num-2; $i++) {

	$voters_name[$i]=substr($voters_arr[$i], 1);
	$voters_answ[$i]=substr($voters_arr[$i], 0, 1);
	$voters_login[$i]=getUserLogin($voters_name[$i]);

	if ($voters_name[$i] == $userid) {
		$votted=1;
	}
}



$pool_result=_oxResult("SELECT * FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=0");
$pool_record=mysql_fetch_array($pool_result);
$answs_text=$pool_record["answs_text"];
$pool_id=$pool_record["pool_id"];
$question=$pool_record["question"];
$answ01=$pool_record["answ01"];
$answ02=$pool_record["answ02"];
$answ03=$pool_record["answ03"];
$answ04=$pool_record["answ04"];
$answ05=$pool_record["answ05"];
$answ06=$pool_record["answ06"];
$answ07=$pool_record["answ07"];
$answ08=$pool_record["answ08"];
$answ09=$pool_record["answ09"];
$public_answ=$pool_record["public"];

$answ_arr = split("#", $answs_text); //pole nazvu odpovedi
$part_num = Count($answ_arr);

$answ_val_arr = Array($answ01, $answ02, $answ03, $answ04, $answ05, $answ06, $answ07, $answ08, $answ09); //pole hodnot odpovedi



$archive_result=_oxResult("SELECT pool_id FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=1");
$archive_num_rows=mysql_num_rows($archive_result);




$deniers_result=_oxResult("SELECT denier_id FROM $TABLE_ROOM_DENIERS WHERE roomid=$roomid");
if (mysql_num_rows($deniers_result) != 0) {
	while($deniers_record=mysql_fetch_array($deniers_result)) {
		if ($deniers_record["denier_id"] == $userid) { //pokud je moje id mezi zakazanymi, nastavim si prepinac na userid
				$denyier=$userid;
		}
	}
}



?>




<? if ($denyier!=$userid) { ?>

<? echo $question ?>
<? if ($room_founderid==$userid || $user_level == 5) { ?>
<form action="gate.php?m=10&s=2" method="post">
<input type="hidden" name="roomid" value="<?echo $roomid?>">
<input type="hidden" name="pool_id" value="<?echo $pool_id?>">
<input type="submit" name="destroy_pool" value="smazat">
</form>
<? } ?>

<form action="gate.php?m=10&s=2" method="post">
	<? for ($i=0; $i<=$part_num-2; $i++) { ?>
		<div>
                  <input type="radio" value="<? echo $i; ?>" name="pool_radio" <? if($i==0) {?> checked="checked" <?}?> >
		      <? $num = $i+1; echo $num.". ".$answ_arr[$i]."&nbsp;&nbsp;&nbsp;[".$answ_val_arr[$i]."]"; ?>
		</div>
      <? } ?>

	<? if ($votted != 1) {?>
		<input type="hidden" name="roomid" value="<?echo $roomid?>">
		<input type="hidden" name="pool_id" value="<?echo $pool_id?>">
		<input type="submit" name="vote" value="hlasovat" class="button">
	<? } ?>
</form>

<? if ($public_answ !=0 && $voters_num-1 !=0) {?>

detailn� v�sledky
<? $j=0;?>
<? for ($i=0; $i<=$voters_num-2; $i++) { ?>
<? $j++ ?>
<a href="gate.php?m=11&s=1&fuserid=<?echo $voters_name[$i];?>">
	<img src="ico/<?echo $voters_login[$i];?>.gif" alt="<?echo $voters_login[$i];?>" />
</a>
<br>
(<?echo $voters_answ[$i];?>)
<? if ($j >=22) { echo "</div><div>"; $j=0;} ?>
<? } ?>
<? } ?>

<? if ($archive_num_rows != 0) {?>
<form action="gate.php?m=10&s=2" method="post">
	<input type="hidden" name="roomid" value="<?echo $roomid?>">
	<input type="submit" name="archive" value="<? echo $LNG_SHOW; ?> archiv anket">
</form>
<? } ?>

<!-- tady se bude pripadne zobrazovat archiv anket -->
			<?
			if ($archive == "zobrazit archiv anket") {
				$archive_result=_oxResult("SELECT * FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=1 ORDER BY pool_id DESC");
				$archive_num_rows=mysql_num_rows($archive_result);
				if ($archive_num_rows!=0) {
					?>
					archiv anket
					<?
				}

				while ($archive_record=mysql_fetch_array($archive_result)) {

					$arch_pool_id=$archive_record["pool_id"];
					$arch_answs_text=$archive_record["answs_text"];
					$arch_question=$archive_record["question"];
					$arch_answ01=$archive_record["answ01"];
					$arch_answ02=$archive_record["answ02"];
					$arch_answ03=$archive_record["answ03"];
					$arch_answ04=$archive_record["answ04"];
					$arch_answ05=$archive_record["answ05"];
					$arch_answ06=$archive_record["answ06"];
					$arch_answ07=$archive_record["answ07"];
					$arch_answ08=$archive_record["answ08"];
					$arch_answ09=$archive_record["answ09"];

					$arch_answ_arr = split("#", $arch_answs_text); //pole nazvu odpovedi
					$arch_part_num = Count($arch_answ_arr);

					$arch_answ_val_arr = Array($arch_answ01, $arch_answ02, $arch_answ03, $arch_answ04, $arch_answ05, $arch_answ06, $arch_answ07, $arch_answ08, $arch_answ09); //pole hodnot odpovedi

					?>
					<? echo $arch_question ?>
					<? if ($room_founderid==$userid) { ?>
						<form action="gate.php?m=10&s=2" method="post">
							<input type="hidden" name="roomid" value="<?echo $roomid?>">
							<input type="hidden" name="pool_id" value="<?echo $arch_pool_id?>">
							<input type="hidden" name="archive" value="archiv" class="button">
							<input type="submit" name="destroy_pool" value="smazat" class="button2">
						</form>
					<? } ?>

					<? for ($i=0; $i<=$arch_part_num-2; $i++) { ?>
					<? $num = $i+1; echo $num.". ".$arch_answ_arr[$i]."&nbsp;&nbsp;&nbsp;[".$arch_answ_val_arr[$i]."]"; ?>
					<? } ?>
            		<?

				}
			}
			?>
			<!-- tady se bude pripadne zobrazovat archiv anket -->
<? } ?>
