<!--
Obsah a chovani panelu akci ovlivnuje:
1. zda jde o prispevek psany prihlasenym uzivatelem
2. zda je zvolenym editorem WYSIWYG ci nikoliv
3. zda se jedna o modul diskuze, posta nebo zive
//-->


<!-- RULES FOR MODULE USERS //-->
<? if ($module_number==4) {//pokud jsme v USERS?>
      <? if ($fuserid == $userid) {//pokud je prihlaseny uzivatel zobrazenym uzivatelem?>
            <a href="gate.php?m=11&s=1&fuserid=<?echo $fuserid?>"><? echo $LNG_ACTION_INFORMATION; ?></a>
      <? } ?>
      <? if ($fuserid != $userid) {//pokud neni prihlaseny uzivatel zobrazenym uzivatelem?>
            <a href="gate.php?m=2&s=1&selrec=<?echo $user_name?>"><? echo $LNG_ACTION_MAILBOX; ?></a>
            <a href="gate.php?m=11&s=1&fuserid=<?echo $fuserid?>"><? echo $LNG_ACTION_INFORMATION; ?></a>
            <?
	     //pokud neni uzivatel jiz v mem seznamu pratel, povolim jeho pridani
	     if ($is_already_friend_array["friendid"] =="") {
	     ?>
		<? if ($submodule_number != 2) {//pokud nejsme v FRIENDS ?>
			<a href="gate.php?m=4&s=2&add=<?echo $user_name?>"><? echo $LNG_ACTION_ADDFRIEND; ?></a>
		<? } ?>
	     <? } ?>
      <? } ?>      
<? } ?>


<!-- RULES FOR MODULE DISCUSSION //-->
<? if ($module_number==10) {//pokud jsme v DISCUSSION ?>
	<? if ($fuserid != $userid) {//POKUD PRIHLASENY UZIVATEL NENI AUTOREM PRISPEVKU?>
            <? if ($editor==0 || $editor==1) { ?>
                  <a href="#" onClick="msgReplyPlainText('[b]<? echo "$user_name" ?>[/b]', '[b][<? echo $formatteddate ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:[/b]');"><? echo $LNG_ACTION_REPLY; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
            <? } ?>
            <? if ($editor==2) { ?>
                  <a href="#" onClick="msgReplyTinyMCE('[b]<? echo "$user_name" ?>[/b]', '[b][<? echo $formatteddate ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:[/b]');"><? echo $LNG_ACTION_REPLY; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
            <? } ?>
            <a href="gate.php?m=2&s=1&selrec=<?echo $user_name?>"><? echo $LNG_ACTION_MAILBOX; ?></a>
            <a href="gate.php?m=11&s=1&fuserid=<?echo $fuserid?>"><? echo $LNG_ACTION_INFORMATION; ?></a>
            
            <? if ($is_already_friend_array["friendid"] =="") {//pokud neni uzivatel jiz v mem seznamu pratel, povolim jeho pridani?>
				<? if ($submodule_number != 2) {//pokud nejsme v FRIENDS ?>
					<a href="gate.php?m=4&s=2&add=<?echo $user_name?>"><? echo $LNG_ACTION_ADDFRIEND; ?></a>
				<? } ?>
	     <? } ?>
	<? } ?>
      
      	<? if ($fuserid == $userid) {//POKUD PRIHLASENY UZIVATEL JE AUTOREM PRISPEVKU?>
            <? if ($editor==0 || $editor==1) { ?>
				<a href="#" onClick="msgReplyPlainText('[b]upraveno[/b]', '[b][<? echo $formatteddate ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:[/b]');"><? echo $LNG_ACTION_EDIT; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
			<? } ?>

			<? if ($editor==2) { ?>
				<a href="#" onClick="msgReplyTinyMCE('[b]upraveno[/b]', '[b][<? echo $formatteddate ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:[/b]');"><? echo $LNG_ACTION_EDIT; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
			<? } ?>
		
		
      	<? } ?>
      
      
      
      	<? if (($userid == $auditor) OR ($userid == $fuserid && $delownvalue == 1) OR ($allower==$userid) OR ($user_level == 5)) {//POKUD PRIHLASENY UZIVATEL JE AUDITOREM, SPRAVCEM, NEBO AUTOREM A AUTORUM JE ZAROVEN POVOLENO MAZAT PRISPEVKY?>
			<a href="#" onClick="delOneMsg('roomform', 'delmsg[]', '<? echo $timestampvalue ?>');"><? echo $LNG_ACTION_DELETE; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
		<? } ?>
<? } ?>


<!-- RULES FOR MODULE MAILBOX //-->
<? if ($module_number==2) {//pokud jsme v MAILBOX ?>
	<? if ($fuserid != $userid) {//POKUD PRIHLASENY UZIVATEL NENI AUTOREM PRISPEVKU?>
            <? if ($editor==0 || $editor==1) { ?>
                  <a href="#" onClick="onIco('<? echo "$user_name" ?>');"><? echo $LNG_ACTION_REPLY; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
            <? } ?>
            <? if ($editor==2) { ?>
                  <a href="#" onClick="onIco('<? echo "$user_name" ?>');"><? echo $LNG_ACTION_REPLY; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
            <? } ?>
            <!--<a href="gate.php?m=2&s=1&selrec=<?echo $user_name?>"><? echo $LNG_ACTION_MAILBOX; ?></a>//-->
            <a href="gate.php?m=11&s=1&fuserid=<?echo $fuserid?>"><? echo $LNG_ACTION_INFORMATION; ?></a>
            <? if ($is_already_friend_array["friendid"] =="") {//pokud neni uzivatel jiz v mem seznamu pratel, povolim jeho pridani?>
				<? if ($submodule_number != 2) {//pokud nejsme v FRIENDS ?>
					<a href="gate.php?m=4&s=2&add=<?echo $user_name?>"><? echo $LNG_ACTION_ADDFRIEND; ?></a>
				<? } ?>
	     	<? } ?>
      
      <? } ?>
      
      <? if ($fuserid == $userid) {//POKUD PRIHLASENY UZIVATEL JE AUTOREM PRISPEVKU?>
            <? if ($editor==0 || $editor==1) { ?>
			<a href="#" onClick="msgReplyPlainText('[b]upraveno[/b]', '[b][<? echo $formatteddate ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:[/b]');"><? echo $LNG_ACTION_EDIT; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
		<? } ?>

		<? if ($editor==2) { ?>
			<a href="#" onClick="msgReplyTinyMCE('[b]upraveno[/b]', '[b][<? echo $formatteddate ?>&nbsp;|&nbsp;<? echo "$msgid" ?>]:[/b]');"><? echo $LNG_ACTION_EDIT; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
		<? } ?>
		
            
      <? } ?>                  
      <a href="#" onClick="delOneMsg('mailboxform', 'delmsg[]', '<? echo $timestampvalue ?>');"><? echo $LNG_ACTION_DELETE; ?><noscript> <? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>
<? } ?>






































