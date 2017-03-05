

<? //if ($fuserid != $userid) {//logged user is excluded ?>

<div class="userslist_left">
	<a href="gate.php?m=11&s=1&fuserid=<? echo $fuserid ?>"><img src="ico/<? echo $user_name ?>.gif" class="user_icon"/></a>
	<img src="style/<? echo "$css" ?>/lvl/<? echo "$level_icon" ?>" class="level_bar" />
</div>

<div class="userslist_right">
	<div class="userslist_header">
		<? if ($module_number==4 && $submodule_number==2) { //pokud vypisuje pratele, zobraz checkbox ?>
			<input type="checkbox" name="delprat[]" value="<? echo "$fuserid" ?>">
		<? } ?>
		<? echo "$user_name" ?>
			[

			<? if ($location_number!=0) {?>
				<a href="gate.php?m=10&s=1&roomid=<?echo $location_number?>">
					<? echo $infolocation ?>
				</a>
				<? if ($location_dscrb!="") {?>
					<? echo $location_dscrb ?>
				<?}?>
			<?}else{?>
				<? echo $infolocation ?>
			<? } ?>

			| <? echo date("d.m.Y H:i:s", "$user_lastaccess"); ?>
                  
                  | <? echo date("d.m.Y H:i:s", "$user_regdate"); ?>
			
			| <? echo $currentAT; ?>

			<? if ($o==1 || $o==3) { ?>
				| status:<?echo $user_status;?>]
			<? } ?>

			<? if ($o==2) { ?>
				| komentáø:<? echo "$friendnote" ?>]
			<? } ?>
			
			]

			<?
                  /*
			<? if ($fuserid != $userid) { ?>
				[<a href="gate.php?m=2&selrec=<?echo $user_name; ?>">napsat zprávu (deprecated)</a>]
			<? } ?>
			*/
			?>

			<? if ($friend_online == 1) { ?>
				[ONLINE]
		<? } ?>
	</div>

	<div class="userslist_action"><? include('incl/action_pannel2.php'); ?></div>
</div>

<? //} ?>







