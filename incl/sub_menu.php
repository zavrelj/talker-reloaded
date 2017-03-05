<div id="sub_menu">
	<ul>
		<? if ($module_number==1) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=1&s=1"><? echo $LNG_SUB_MENU_INFORMATION; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=1&s=2"><? echo $LNG_SUB_MENU_STATISTICS; ?></a>
			</div>
		<? } ?>

		<? if ($module_number==2) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=2&s=1"><? echo $LNG_SUB_MENU_MESSAGES; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=2&s=2"><? echo $LNG_SUB_MENU_SEARCH_MESSAGES; ?></a>
			</div>
		<? } ?>

		<? if ($module_number==3) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=3&s=1"><? echo $LNG_SUB_TOPICS_LIST; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=3&s=2&topic_id="><? echo $LNG_SUB_MENU_NEW_DISCUSSION; ?></a>
			</li>
			<li <? if($submodule_number==3) {?> id="current" <? } ?>>
				<a href="gate.php?m=3&s=3"><? echo $LNG_SUB_MENU_SEARCH_DISCUSSION; ?></a>
			</li>
			<? if ($user_level==5) { ?>
                        <li <? if($submodule_number==4) {?> id="current" <? } ?>>
                              <a href="gate.php?m=3&s=4"><? echo $LNG_SUB_MENU_ADD_SUBCATEGORY; ?></a>
                        </li>
                  <? } ?>
		<? } ?>

		<? if ($module_number==4) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=4&s=1"><? echo $LNG_SUB_MENU_ONLINE; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=4&s=2"><? echo $LNG_SUB_MENU_FRIENDS; ?></a>
			</li>
			<li <? if($submodule_number==3) {?> id="current" <? } ?>>
				<a href="gate.php?m=4&s=3&show_all=1"><? echo $LNG_SUB_MENU_ALL; ?></a>
			</li>
			<li <? if($submodule_number==4) {?> id="current" <? } ?>>
				<a href="gate.php?m=4&s=4"><? echo $LNG_SUB_MENU_SEARCH_USERS; ?></a>
			</li>
		<? } ?>

		<? if ($module_number==5) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=5&s=1&usrid=<? echo "$userid" ?>"><? echo $LNG_SUB_MENU_SYSTEM; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=2&fuserid=<? echo "$userid" ?>"><? echo $LNG_SUB_MENU_PERSONAL_INFO; ?></a>
			</li>
			<li <? if($submodule_number==6) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=6&fuserid=<? echo "$userid" ?>"><? echo $LNG_SUB_MENU_PERSONAL_PAGE; ?></a>
			</li>
		<? } ?>

		<? if ($module_number==6) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="#">&nbsp;</a>
                        <!--<a href="settings.php?m=6&s=1&usrid=<? echo "$userid" ?>"><? echo $LNG_SUB_MENU_BOOKMARKS_SETTINGS; ?></a>//-->
			</li>
		<? } ?>

		<? if ($module_number==7) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=7&s=1"><? echo $LNG_SUB_MENU_ALL; ?></a>
			</li>
			<? if ($isOneUser==1) { ?>
			<li <? if($submodule_number==3) {?> id="current" <? } ?>>
				<a href="gate.php?m=7&s=3&fuserid=<?echo $fuserid?>"><? echo getUserLogin($fuserid); ?></a>
			</li>
			<? } ?>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=7&s=2"><? echo $LNG_SUB_MENU_SEARCH_MESSAGES; ?></a>
			</li>
		<? } ?>

		<? if ($module_number==8) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=8&s=1"><? echo $LNG_HELP_REQUIREMENTS; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=8&s=2"><? echo $LNG_HELP_LEVELS; ?></a>
			</li>
			<li <? if($submodule_number==3) {?> id="current" <? } ?>>
				<a href="gate.php?m=8&s=3"><? echo $LNG_HELP_DISCUSSIONS; ?></a>
			</li>
		<? } ?>

		<? if ($module_number==10) { ?>
        	<li <? if($submodule_number==1) {?> id="current" <? } ?>>
        		<a href="gate.php?m=10&s=1&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_ENTRIES; ?></a>
        	</li>

			<? if ($pool_num_rows != 0) { ?>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=2&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_POLL; ?></a>
			</li>
			<? } ?>

			<? if ($homepage != "") { ?>
			<li <? if($submodule_number==3) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=3&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_HOMEPAGE; ?></a>
			</li>
			<? } ?>

			<li <? if($submodule_number==4) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=4&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_STATISTICS; ?></a>
			</li>

			<li <? if($submodule_number==5) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=5&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_ONLINE; ?></a>
			</li>

			<li <? if($submodule_number==6) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=6&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_MODERATORS; ?></a>
			</li>

			<li <? if($submodule_number==7) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=7&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_BANS; ?></a>
			</li>

			<li <? if($submodule_number==11) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=11&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_SEARCH_ENTRIES; ?></a>
        	</li>

			<? if ($auditor == $userid || $user_level== 5) { //pokud je uzivatel autorem diskuze nebo spravcem systemu ?>
			<li <? if($submodule_number==8) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=8&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_DISCUSSION_SETTINGS; ?></a>
			</li>
			<? } ?>

			<? if ($allower == $userid) { //pokud je uzivatel spravcem diskuze ?>
			<li <? if($submodule_number==8) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=8&allower=<? echo $userid ?>&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_SETTINGS; ?></a>
			</li>
			<? } ?>

			<? if ($auditor != $userid) { //pokud uzivatel neni autorem diskuze ?>
			<li <? if($submodule_number==9) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=1&roomid=<? echo $roomid ?>&book=<? echo $bookvalue ?>"><? echo $bookvalue ?></a>
			</li>
			<? } ?>

			<? if ($auditor == $userid || $user_level== 5) { //pokud je uzivatel autorem diskuze nebo spravcem systemu ?>
			<li <? if($submodule_number==10) {?> id="current" <? } ?>>
				<a href="gate.php?m=10&s=10&roomid=<? echo $roomid ?>"><? echo $LNG_SUB_MENU_DESTROY; ?></a>
			</li>
			<? } ?>
        <? } ?>

        <? if ($module_number==11) { ?>
			<li <? if($submodule_number==1) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=1&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_BASIC_INFO; ?></a>
			</li>
			<li <? if($submodule_number==2) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=2&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_DETAILED_INFO; ?></a>
			</li>
			<li <? if($submodule_number==3) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=3&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_USERS; ?></a>
			</li>
			<li <? if($submodule_number==4) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=4&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_COMMENTS; ?></a>
			</li>
			<li <? if($submodule_number==5) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=5&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_DISCUSSION; ?></a>
			</li>
			<li <? if($submodule_number==8) {?> id="current" <? } ?>>
				<a href="gate.php?m=7&s=3&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_ENTRIES; ?></a>
			</li>
			<li <? if($submodule_number==6) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=6&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_PERSONAL_PAGE; ?></a>
			</li>

			<? if ($fuserid == $userid) { ?>
			<li <? if($submodule_number==7) {?> id="current" <? } ?>>
				<a href="gate.php?m=11&s=7&fuserid=<? echo $fuserid; ?>"><? echo $LNG_SUB_MENU_LOGINS; ?></a>
			</li>
			<? } ?>
        <? } ?>
	</ul>
</div>
