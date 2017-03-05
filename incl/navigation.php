<?
/*
navigation_id:
11 - mailbox top
12 - mailbox bottom
21 - room top
22 - room bottom
31 - live top
32 - live bottom
*/
//echo "navigationid: ".$navigation_id;
?>

<div id="message_counter">
	<p><? echo $msg_from."-".$msg_to."/".$allMsgsCount; ?></p>
</div>

<div id="navigation_buttons">
	<p>
	<?if ($frwdvalue > 0) {?>
		<? // pokud je navigace room, cili 21 a 22 zapni roomid
		if ($navigation_id == 21 || $navigation_id == 22) { ?>
			<input type="hidden" name="roomid" value="<? echo $roomid ?>">
		<? } ?>
		<input type="hidden" name="fuserid" value="<? echo $fuserid ?>">
		<input type="submit" name="start" value="<? echo $LNG_NAVIGATION_NEWEST_SUBMIT; ?>">
	<?}else{?>
		<input type="submit" name="start" value="<? echo $LNG_NAVIGATION_NEWEST_SUBMIT; ?>" disabled="disabled" id="disabled">
	<?}?>

	<?if ($frwdvalue > 0) {?>
		<? // pokud je navigace room, cili 21 a 22 zapni roomid
		if ($navigation_id == 21 || $navigation_id == 22) { ?>
			<input type="hidden" name="roomid" value="<? echo $roomid ?>">
		<? } ?>
		<input type="hidden" name="fuserid" value="<? echo $fuserid ?>">
		<input type="hidden" name="frwdvalue" value="<?echo $frwdvalue?>">
		<input type="submit" name="frwd" value="<? echo $LNG_NAVIGATION_NEWER_SUBMIT; ?>">
	<?}else{?>
		<input type="submit" name="frwd" value="<? echo $LNG_NAVIGATION_NEWER_SUBMIT; ?>" disabled="disabled" id="disabled">
	<?}?>


	<?
	// pokud je navigace bottom, cili 12, 22, 32, zapni classu pro td
	if ($navigation_id == 12 || $navigation_id == 22 || $navigation_id == 32) { ?>
		<input type="hidden" name="show_msgs_count" size="5" value="<? echo $showMsgsCount ?>">
	<? }else{ ?>
		<input type="text" name="show_msgs_count" size="5" value="<? echo $showMsgsCount ?>">
	<? } ?>
	<? // pokud je navigace room, cili 21 a 22 zapni roomid
		if ($navigation_id == 21 || $navigation_id == 22) { ?>
		<input type="hidden" name="roomid" value="<? echo $roomid ?>">
	<? } ?>

	<?if ($backvalue < $allMsgsCount-$rownum) {?>
		<? // pokud je navigace room, cili 21 a 22 zapni roomid
		if ($navigation_id == 21 || $navigation_id == 22) { ?>
			<input type="hidden" name="roomid" value="<? echo $roomid ?>">
		<? } ?>
		<input type="hidden" name="fuserid" value="<? echo $fuserid ?>">
		<input type="hidden" name="backvalue" value="<?echo $backvalue?>">
		<input type="submit" name="back" value="<? echo $LNG_NAVIGATION_OLDER_SUBMIT; ?>">
	<?}else{?>
		<input type="submit" name="back" value="<? echo $LNG_NAVIGATION_OLDER_SUBMIT; ?>" disabled="disabled" id="disabled">
	<?}?>

	<?if ($backvalue < $allMsgsCount-$rownum) {?>
		<? // pokud je navigace room, cili 21 a 22 zapni roomid
		if ($navigation_id == 21 || $navigation_id == 22) { ?>
			<input type="hidden" name="roomid" value="<? echo $roomid ?>">
		<? } ?>
		<input type="hidden" name="fuserid" value="<? echo $fuserid ?>">
		<input type="submit" name="end" value="<? echo $LNG_NAVIGATION_OLDEST_SUBMIT; ?>">
	<?}else{?>
		<input type="submit" name="end" value="<? echo $LNG_NAVIGATION_OLDEST_SUBMIT; ?>" disabled="disabled" id="disabled">
	<?}?>
	</p>
</div>

