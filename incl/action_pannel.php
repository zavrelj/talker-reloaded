<!--
Obsah a chovani panelu akci ovlivnuje:
1. zda jde o prispevek psany prihlasenym uzivatelem
2. zda je zvolenym editorem WYSIWYG ci nikoliv
3. zda se jedna o modul diskuze, posta nebo zive
//-->

<!-- POKUD PRIHLASENY UZIVATEL NENI AUTOREM PRISPEVKU //-->
<? if ($his_id != $userid) {?>
	<? if ($editor==0 || $editor==1) { ?>
		<? if ($module_number==02) {//posta ?>
			<input type="button" value="odpovìdìt" onClick="onIco('<? echo "$user_name" ?>');">
		<? } ?>

		<? if ($module_number==10) {//diskuze ?>
			<input type="button" value="odpovìdìt" onClick="msgReplyPlainText('<b><? echo "$user_name" ?></b>', '<b>[<? echo $formatted_date ?>&nbsp;|&nbsp;<? echo $formatted_time ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:</b>');">
		<? } ?>
	<? } ?>

	<? if ($editor==2) { ?>
		<input type="button" value="odpovìdìt" onClick="msgReplyWYSIWYG('<b><? echo "$user_name" ?></b>', '<b>[<? echo $formatted_date ?>&nbsp;|&nbsp;<? echo $formatted_time ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:</b>');">
	<? } ?>

<!-- POKUD PRIHLASENY UZIVATEL JE AUTOREM PRISPEVKU //-->
<? }else{ ?>
	<? if ($module_number!=7) {//pokud nejsme v ZIVE ?>
		<? if ($editor==0 || $editor==1) { ?>
			<input type="button" value="upravit" onClick="msgReplyPlainText('<b>upraveno</b>', '<b>[<? echo $formatted_date ?>&nbsp;|&nbsp;<? echo $formatted_time ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:</b>');">
		<? } ?>

		<? if ($editor==2) { ?>
			<input type="button" value="upravit" onClick="msgReplyWYSIWYG('<b>upraveno</b>', '<b>[<? echo $formatted_date ?>&nbsp;|&nbsp;<? echo $formatted_time ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:</b>');">
		<? } ?>
	<? } ?>
<? } ?>

<!-- POKUD PRIHLASENY UZIVATEL NENI AUTOREM PRISPEVKU //-->
<? if ($user_name != $login) {?>
	<? if ($module_number==10 || $module_number==7) {//pokud jsme v DISKUZI nebo ZIVE ?>
		<input type="button" value="pošta" onClick="msgMailbox('gate.php?m=2&selrec=<?echo $user_name?>');">
	<? } ?>
	<input type="button" value="info" onClick="msgUserInfo('gate.php?m=11&s=1&fuserid=<?echo $his_id?>');">
	<?
	//pokud neni uzivatel jiz v mem seznamu pratel, povolim jeho pridani
	if ($is_already_friend_array["friendid"] =="") {
	?>
		<input type="button" value="pøátelé" onClick="msgFriends('gate.php?m=4&s=2&add=<?echo $user_name?>');">
	<? } ?>
<? } ?>

<!-- POKUD PRIHLASENY UZIVATEL JE AUDITOREM, SPRAVCEM, NEBO AUTOREM A JE POVOLENO AUTORUM MAZAT PRISPEVKY //-->
<? if (($userid == $auditor) OR ($userid == $his_id && $delownvalue == 1) OR ($allower==$userid)) {?>
	<? if ($module_number==10) {//zatim pouze pro diskuzi ?>
		<noscript>cisty odkaz</noscript>
		<input type="button" name="del" value="smazat" onClick="delOneMsg('roomform', 'delmsg[]', '<? echo $timestampvalue ?>');">
	<? } ?>
<? } ?>