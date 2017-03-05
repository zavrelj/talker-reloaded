<?

$privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
$is_private = $privateArray["private"];
if ($is_private != 0) {
	$sess_out = updatelastaction($userid, "privátní diskuzi ve statistice");
}else{
	$sess_out = updatelastaction($userid, $roomid.";ve statistice");
}

$result=_oxResult("SELECT name, founderid, founddate, FK_topic, count, book_count FROM $TABLE_ROOMS WHERE roomid=$roomid");
$record=mysql_fetch_array($result);
$roomname=$record["name"];
$owner_id=$record["founderid"];
$founddate=$record["founddate"];
$topic_id=$record["FK_topic"];
$topic_name = getTopicName($topic_id);
$count=$record["count"];
$book_count=$record["book_count"];




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


?>

<strong>název: </strong><? echo $roomname;?> <br />
<strong>kategorie: </strong><? echo $topic_name;?> <br />
<strong>vlastník: </strong><? echo getUserLogin($owner_id);?> <br />
<? if ($keepers!="") {?>
<strong>správci: </strong><? echo $keepers;?> <br />
<? } ?>
<strong>datum založení: </strong><? echo date("d.m.Y  H:i:s", "$founddate");?> <br />
<strong>počet příspěvků: </strong><? echo $count;?> <br />
<strong>oblíbenost: </strong><? echo $book_count;?> <br />
				<?
					$viewers_result=_oxResult("SELECT viewer_id, last_access FROM $TABLE_ROOM_VIEWERS WHERE roomid=$roomid");
					if (mysql_num_rows($viewers_result) != 0) { //pokud v tomto klubu jiz byli uzivatele

						?><strong>návštěvníci diskuze</strong> <br /><?

						$x=0;
						while ($viewers_record=mysql_fetch_array($viewers_result)) {
							$viewer_id=$viewers_record["viewer_id"];
							$last_access=$viewers_record["last_access"];
							$x++;
			               	?><img src="ico/<?echo getUserLogin($viewer_id)?>.gif" title="<?echo getUserLogin($viewer_id)." [".date("d.m.Y H:i:s", $last_access)."]"?>" />
			               	<?echo getUserLogin($viewer_id);?>|poslední přístup:
			               	<? echo date("d.m.Y H:i:s", $last_access);?>|
			               	<a href="gate.php?m=11&s=1&fuserid=<?echo $viewer_id?>">informace o uľivateli</a><?
							if ($x >=1) { echo "</div><div>"; $x=0;}
						}

						?><?
					}
				?>



