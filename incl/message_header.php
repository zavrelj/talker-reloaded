<!-- CHECKBOX //-->
<? if ($module_number==10) {//diskuze ?>
	<? if (($userid == $auditor) OR ($userid == $fuserid && $delownvalue == 1) OR ($allower == $userid) OR ($user_level == 5)) {?>
		<input type="checkbox" name="delmsg[]" value="<? echo $timestampvalue ?>">
	<?}?>
<? } ?>

<? if ($module_number==02) {//posta ?>
	<input type="checkbox" name="delmsg[]" value="<? echo $timestampvalue ?>">
<? } ?>
<!-- CHECKBOX //-->





<!-- OBSAH HEADERU V DISKUZI //-->
<? if ($module_number==10) {//diskuze ?>
	<? if ($timestampvalue > $lastaccess && $lastaccess != "" && $user_name!=$login) { ?>
		<? if ($the_same==1) {?>
			<? echo $LNG_BULLETIN_NEWFORYOUFROM; ?>
		<?}else{?>
			<? echo $LNG_BULLETIN_NEWFROM; ?>
		<?}?>
	<? } ?>
 	<? include('message_header_text.php'); ?>
	#<? echo $msgid ?>
<? } ?>
<!-- OBSAH HEADERU V DISKUZI //-->





<!-- OBSAH HEADERU V ODESLANE POSTE //-->
<? if ($module_number==02 && $message_type==0) {//posta-odeslana ?>
	<!--PUVODNE MISTO user_name BYLO receivername, V PRIPADE PROBLEMU VRATIT//-->
	<? echo $LNG_MESSAGE_FOR; ?>
	<? include('message_header_text.php'); ?>

	<? if ($viewed==1) {?>
		<? echo $LNG_MESSAGE_VIEWED; ?>
	<?}else{?>
		<? echo $LNG_MESSAGE_UNVIEWED; ?>
		<input type="checkbox" name="delreceivermsg[]" value="<? echo $timestampvalue ?>">
		]
	<? } ?>
<? } ?>
<!-- OBSAH HEADERU V ODESLANE POSTE //-->





<!-- OBSAH HEADERU V NEPRECTENE PRIJATE POSTE //-->
<? if ($module_number==02 && $message_type==1) {//posta-prijata-neprectena ?>
	<? echo $LNG_MESSAGE_NEWFROM; ?>
	<? include('message_header_text.php'); ?>
<? } ?>
<!-- OBSAH HEADERU V NEPRECTENE PRIJATE POSTE //-->





<!-- OBSAH HEADERU V PRECTENE PRIJATE POSTE //-->
<? if ($module_number==02 && $message_type==2) {//posta-prijata-prectena ?>
	<? echo $LNG_MESSAGE_FROM; ?>
	<? include('message_header_text.php'); ?>
<? } ?>
<!-- OBSAH HEADERU V PRECTENE PRIJATE POSTE //-->





<!-- OBSAH HEADERU V ZIVE //-->
<? if ($module_number==07) {//zive ?>
	<? echo $user_name ?> @ <? echo $formatteddate ?>
	[<a href="gate.php?m=10&s=1&roomid=<?echo $live_room_id?>"><?echo $live_room_name?></a>
	|<?echo $live_user_status; ?>]
<? } ?>
<!-- OBSAH HEADERU V ZIVE //-->






