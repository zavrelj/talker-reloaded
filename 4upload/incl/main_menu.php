<div id="main_menu">
  <ul>
    <li <? if($module_number==1) {?> id="current" <? } ?>>
    	<a href="gate.php?m=1&s=1"><? echo $LNG_MAIN_MENU_SYSTEM; ?></a>
    </li>

    <li <? if($module_number==2) {?> id="current" <? } ?>>
    	<a href="gate.php?m=2&s=1"><? echo $LNG_MAIN_MENU_MAILBOX; ?></a>
    </li>

    <li <? if($module_number==3) {?> id="current" <? } ?>>
    	<a href="gate.php?m=3&s=1"><? echo $LNG_MAIN_MENU_TOPICS; ?></a>
    </li>

   	<? /* V menu se zobrazi navic kolonka DISKUZE */ ?>
	<? if ($module_number == 10) { ?>
   	<li <? if($module_number==10) {?> id="current" <? } ?>>
	   	<a href="gate.php?m=10&s=1&roomid=<? echo $menuRoomID; ?>"><? echo $LNG_MAIN_MENU_DISCUSSION; ?></a>
    </li>
    <? } ?>
	

	<li <? if($module_number==4) {?> id="current" <? } ?>>
	   	<a href="gate.php?m=4&s=1"><? echo $LNG_MAIN_MENU_USERS; ?></a>
    </li>

    <? /* V menu se zobrazi navic kolonka INFORMACE */ ?>
	<? if ($module_number == 11) { ?>
    <li <? if($module_number==11) {?> id="current" <? } ?>>
		<a href="gate.php?m=11&s=1&fuserid=<? echo $fuserid; ?>"><? echo getUserLogin($fuserid); ?></a>
	</li>
    <? } ?>
	

	  <li <? if($module_number==5) {?> id="current" <? } ?>>
	   	<a href="gate.php?m=5&s=1"><? echo $LNG_MAIN_MENU_SETTINGS; ?></a>
    </li>

    <li <? if($module_number==6) {?> id="current" <? } ?>>
		<a href="gate.php?m=6"><? echo $LNG_MAIN_MENU_BOOKMARKS; ?></a>
    </li>

    <li <? if($module_number==7) {?> id="current" <? } ?>>
		<a href="gate.php?m=7&s=1"><? echo $LNG_MAIN_MENU_LIVE; ?></a>
    </li>

	  <li <? if($module_number==8) {?> id="current" <? } ?>>
		<a href="gate.php?m=8"><? echo $LNG_MAIN_MENU_HELP; ?></a>
    </li>

    <li <? if($module_number==9) {?> id="current" <? } ?>>
		<a href="logout.php?m=9"><? echo $LNG_MAIN_MENU_LOGOUT; ?></a>
    </li>
  </ul>

</div>
<div id="main_menu_bottom"></div>


