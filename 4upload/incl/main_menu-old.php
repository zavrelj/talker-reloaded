<div id="main_menu">
  <ul>
    <li><a href="#">SYSTÉM</a></li>
    <li id="current"><a href="#">POŠTA</a></li>
    <li><a href="#">TÉMATA</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
</div>













<table cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div id="main_menu">

				<div class="<? echo $MODULE01_BTN_BG; ?>">
					<a href="gate.php?m=1&s=1">
						<? echo $LNG_MAIN_MENU_SYSTEM; ?>
					</a>
				</div>

				<div class="<? echo $MODULE02_BTN_BG; ?>">
					<a href="gate.php?m=2">
						<? echo $LNG_MAIN_MENU_MAILBOX; ?>
					</a>
				</div>

				<div class="<? echo $MODULE03_BTN_BG; ?>">
					<a href="gate.php?m=3&s=1">
						<? echo $LNG_MAIN_MENU_TOPICS; ?>
					</a>
				</div>

				<!-- V menu se zobrazi navic kolonka DISKUZE //-->
				<? if ($module_number == 10) { ?>
				<div class="<? echo $MODULE10_BTN_BG; ?>">
					<a href="gate.php?m=10&s=1&roomid=<? echo $menuRoomID; ?>">
						<? echo $LNG_MAIN_MENU_DISCUSSION; ?>
					</a>
				</div>
				<? } ?>
				<!--//-->

				<div class="<? echo $MODULE04_BTN_BG; ?>">
					<a href="gate.php?m=4&s=1">
						<? echo $LNG_MAIN_MENU_USERS; ?>
					</a>
				</div>

				<!-- V menu se zobrazi navic kolonka INFORMACE//-->
				<? if ($module_number == 11) { ?>
				<div class="<? echo $MODULE11_BTN_BG; ?>">
					<a href="gate.php?m=11&s=1&fuserid=<? echo $menuForeignUserID; ?>">
						<? echo getUserLogin($menuForeignUserID); ?>
					</a>
				</div>
				<? } ?>
				<!--//-->

				<div class="<? echo $MODULE05_BTN_BG; ?>">
					<a href="gate.php?m=5&s=1&usrid=<? echo "$userid" ?>">
						<? echo $LNG_MAIN_MENU_SETTINGS; ?>
					</a>
				</div>

				<div class="<? echo $MODULE06_BTN_BG; ?>">
					<a href="gate.php?m=6">
						<? echo $LNG_MAIN_MENU_BOOKMARKS; ?>
					</a>
				</div>

				<div class="<? echo $MODULE07_BTN_BG; ?>">
					<a href="gate.php?m=7">
						<? echo $LNG_MAIN_MENU_LIVE; ?>
					</a>
				</div>

				<div class="<? echo $MODULE08_BTN_BG; ?>">
					<a href="gate.php?m=8">
						<? echo $LNG_MAIN_MENU_HELP; ?>
					</a>
				</div>

				<div class="<? echo $MODULE09_BTN_BG; ?>">
					<a href="logout.php?m=9">
						<? echo $LNG_MAIN_MENU_LOGOUT; ?>
					</a>
				</div>
			</div>
		</td>
	</tr>
</table>