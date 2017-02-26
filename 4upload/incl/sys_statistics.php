<div id="statistics_info"><? echo "$LNG_SYSTEM_STATISTICS_NUMOF_USERS $usercounter" ?>
<?
$result=_oxResult("SELECT COUNT(roomid) as rooms_num FROM $TABLE_ROOMS WHERE private=0");
$record=mysql_fetch_array($result);
$rooms=$record["rooms_num"];
?>

| <? echo "$LNG_SYSTEM_STATISTICS_NUMOF_DISCUSSIONS $rooms" ?>
</div>



<div class="statistics_header"><? echo "$LNG_SYSTEM_STATISTICS_NEWEST_DISCUSSIONS" ?></div>

<div class="statistics_content">
<?
$result=_oxResult("SELECT roomid, name, founddate, founderid, count, FK_topic FROM $TABLE_ROOMS WHERE private=0 ORDER BY founddate DESC LIMIT 0, $STAT_ROWS");
while ($record=mysql_fetch_array($result)) {
	$room_id=$record["roomid"];
	$room_name=$record["name"];
	$founder_id=$record["founderid"];
	$count=$record["count"];
	$topic_id=$record["FK_topic"];
	$topic_name = getTopicName($topic_id);
	$room_birth=$record["founddate"];
	$room_birth = date("d.m.Y H:i:s", $room_birth);
	$founder=getUserLogin($founder_id);

?>
	<div>
		<a href="gate.php?m=10&s=1&roomid=<?echo $room_id?>"><?echo $room_name ?></a>
		(<?echo $founder ?>)
		|<?echo $topic_name; ?>|
		[<?echo $count ?>]
		<?echo $room_birth ?>
	</div>
<? } ?>
</div>



<div class="statistics_header"><? echo "$LNG_SYSTEM_STATISTICS_FAMEMOST_DISCUSSIONS" ?></div>

<div class="statistics_content">
<?
$result=_oxResult("SELECT roomid, name, founddate, founderid, count, FK_topic, book_count FROM $TABLE_ROOMS WHERE private=0 ORDER BY book_count DESC LIMIT 0, $STAT_ROWS");
while ($record=mysql_fetch_array($result)) {
	$room_id=$record["roomid"];
	$room_name=$record["name"];
	$founder_id=$record["founderid"];
	$count=$record["count"];
	$book_count=$record["book_count"];
	$topic_id=$record["FK_topic"];
	$topic_name = getTopicName($topic_id);
	$room_birth=$record["founddate"];
	$room_birth = date("d.m.Y H:i:s", $room_birth);
	$founder=getUserLogin($founder_id);
?>
	<div>
		<a href="gate.php?m=10&s=1&roomid=<?echo $room_id?>" class="room"><?echo $room_name ?></a>
		(<?echo $founder ?>)
		|<?echo $topic_name; ?>|
		[<?echo $book_count ?>]
		<?echo $room_birth ?>
	</div>
<? } ?>
</div>


<div class="statistics_header"><? echo "$LNG_SYSTEM_STATISTICS_ACTIVEMOST_DISCUSSIONS" ?></div>

<div class="statistics_content">
<?
$result=_oxResult("SELECT roomid, name, last, founderid, count, FK_topic FROM $TABLE_ROOMS WHERE private=0 ORDER BY last DESC LIMIT 0, $STAT_ROWS");
while ($record=mysql_fetch_array($result)) {
	$room_id=$record["roomid"];
	$room_name=$record["name"];
	$founder_id=$record["founderid"];
	$count=$record["count"];
	$topic_id=$record["FK_topic"];
	$topic_name = getTopicName($topic_id);
	$last=$record["last"];
	$last = date("d.m.Y H:i:s", $last);
	$founder=getUserLogin($founder_id);
?>
	<div>
		<a href="gate.php?m=10&s=1&roomid=<?echo $room_id?>" class="room"><?echo $room_name ?></a>
		(<?echo $founder ?>)
		|<?echo $topic_name; ?>|
		[<?echo $count ?>]
		<?echo $last ?>
	</div>
<? } ?>
</div>


<div class="statistics_header"><? echo "$LNG_SYSTEM_STATISTICS_ACTIVELESS_DISCUSSIONS" ?></div>

<div class="statistics_content">
<?
$result=_oxResult("SELECT roomid, name, last, founderid, count, FK_topic FROM $TABLE_ROOMS WHERE private=0 ORDER BY last ASC LIMIT 0, $STAT_ROWS");
while ($record=mysql_fetch_array($result)) {
	$room_id=$record["roomid"];
	$room_name=$record["name"];
	$founder_id=$record["founderid"];
	$count=$record["count"];
	$topic_id=$record["FK_topic"];
	$topic_name = getTopicName($topic_id);
	$last=$record["last"];
	$last = date("d.m.Y H:i:s", $last);
	$founder=getUserLogin($founder_id);
?>
	<div>
		<a href="gate.php?m=10&s=1&roomid=<?echo $room_id?>" class="room"><?echo $room_name ?></a>
		(<?echo $founder ?>)
		|<?echo $topic_name; ?>|
		[<?echo $count ?>]
		<?echo $last ?>
	</div>
<? } ?>
</div>


<div class="statistics_header"><? echo "$LNG_SYSTEM_STATISTICS_NEWEST_USERS" ?></div>

<div class="statistics_content">
<?
$result=_oxResult("SELECT userid, login, regdate FROM $TABLE_USERS ORDER BY regdate DESC LIMIT 0, $STAT_ROWS");
while ($record=mysql_fetch_array($result)) {
	$user_id=$record["userid"];
	$user_login=$record["login"];
	$user_reg=$record["regdate"];
	$user_reg = date("d.m.Y H:i:s", $user_reg);
?>
	<div>
		<a href="gate.php?m=11&s=1&fuserid=<?echo $user_id?>"><?echo $user_login ?></a>
		<?echo $user_reg ?>
	</div>
<? } ?>
</div>


<div class="statistics_header"><? echo "$LNG_SYSTEM_STATISTICS_MOSTAT_USERS" ?></div>

<div class="statistics_content">
<?
$result=_oxResult("SELECT userid, login, AT FROM $TABLE_USERS ORDER BY AT DESC LIMIT 0, $STAT_ROWS");
while ($record=mysql_fetch_array($result)) {
	$user_id=$record["userid"];
	$user_login=$record["login"];
	$user_at=$record["AT"];
?>
	<div>
		<a href="gate.php?m=11&s=1&fuserid=<?echo $user_id?>" class="room"><?echo $user_login ?></a>
		<?echo $user_at ?>
	</div>	
<? } ?>
</div>


