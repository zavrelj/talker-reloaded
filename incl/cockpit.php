<div id="cockpit_content">

	
            
      <div id="cockpit_logged_user">
		<img src="ico/<? echo "$login" ?>.gif" />
		<img src="style/<? echo "$css" ?>/lvl/<? echo "$level_icon" ?>" />
	</div>
	
      <div id="cockpit_default">

		<div id="cockpit_clock">
                  <noscript><? echo $time; ?></noscript>
                  <script>
                        document.writeln('<canvas id="clockid" class="CoolClock:oxyyRail:26"></canvas>');
                  </script>
            </div>
            
    <div id="cockpit_list">
			<form name="cockpit_select_form" method="post">

				<? /* STATUS LIST */ ?>
				<select id="cockpit_window_status_select" name="cockpit_window_status_select" onChange="javascript:location='gate.php?m=<?echo $module_number?>&s=<?echo $submodule_number?>&roomid=<?echo $roomid?>&ns='+document.cockpit_select_form.cockpit_window_status_select.options[document.cockpit_select_form.cockpit_window_status_select.selectedIndex].value;" class="cockpit_window_select">
				<? for ($i=0; $i<=count($LNG_STATUS_LIST)-1; $i++) { ?>

					<?
					/*
					<option name="user" value="<? echo $i; ?>" <?if ($LNG_STATUS_LIST[$i]==$status) { echo "SELECTED"; }?>><? echo $LNG_STATUS_LIST[$i]; ?></option>
					*/
                              ?>

					<?if ($LNG_STATUS_LIST[$i]==$status) {?>
						<option name="user" value="<? echo $i; ?>" SELECTED><? echo $LNG_STATUS_LIST[$i]; ?></option>
						<?
						$default=1;
						//echo "default status selected";
						?>
					<? }else{ ?>
						<option name="user" value="<? echo $i; ?>"><? echo $LNG_STATUS_LIST[$i]; ?></option>
					<? } ?>

				<? } ?>

				<? if (!isSet($default) || isSet($custom_status)) {?>
					<? /* <option name="user" value="-1" SELECTED>--<? echo $LNG_STATUS_OWN; ?>--</option> */ ?>
					<option name="user" value="-1" SELECTED><? echo $status; ?></option>
				<? } ?>

				</select>
				<? /* STATUS LIST */ ?>

				<? /* INTERNET LIST */ ?>
			    <?
				$links_result = _oxResult("SELECT address01, label01, address02, label02, address03, label03, address04, label04, address05, label05  FROM $TABLE_USERS WHERE userid=$userid");
				$links_record = mysql_fetch_array($links_result);
				?>

				<select id="cockpit_window_link_select" name="cockpit_window_link_select" onChange="javascript:showNet(document.cockpit_select_form.cockpit_window_link_select.options[document.cockpit_select_form.cockpit_window_link_select.selectedIndex].value); document.link_select_form.cockpit_window_link_select.selectedIndex = 0;" class="cockpit_window_select">
					<option name="url" SELECTED>internet</option>
					<option name="url" value="http://www.seznam.cz">Seznam.cz</option>
					<option name="url" value="http://www.centrum.cz">Centrum.cz</option>
				<? if ($links_record["address01"] != "" && $links_record["label01"] != "") { ?>
					<option name="url" value="<? echo $links_record["address01"]; ?>"><? echo $links_record["label01"]; ?></option>
				<?}?>
				<? if ($links_record["address02"] != "" && $links_record["label02"] != "") { ?>
					<option name="url" value="<? echo $links_record["address02"]; ?>"><? echo $links_record["label02"]; ?></option>
				<?}?>
				<? if ($links_record["address03"] != "" && $links_record["label03"] != "") { ?>
					<option name="url" value="<? echo $links_record["address03"]; ?>"><? echo $links_record["label03"]; ?></option>
				<?}?>
				<? if ($links_record["address04"] != "" && $links_record["label04"] != "") { ?>
					<option name="url" value="<? echo $links_record["address04"]; ?>"><? echo $links_record["label04"]; ?></option>
				<?}?>
				<? if ($links_record["address05"] != "" && $links_record["label05"] != "") { ?>
					<option name="url" value="<? echo $links_record["address05"]; ?>"><? echo $links_record["label05"]; ?></option>
				<?}?>

				</select>
			    <? /* INTERNET LIST */ ?>

			    <? /* ONLINE LIST */ ?>
			    <?
				$now=$timecr;
				$select_logged_users = _oxResult("SELECT login FROM $TABLE_USERS WHERE active=1 AND userid != $userid ORDER BY login ASC");
				$countthem = mysql_num_rows($select_logged_users);
				?>

				<?
				//spocita aktivni pratele
				$onlineFriendsCountArray = _oxQuery("SELECT COUNT($TABLE_FRIENDS.friendid) AS friends_count FROM $TABLE_USERS, $TABLE_FRIENDS where $TABLE_USERS.userid=$TABLE_FRIENDS.friendid and $TABLE_FRIENDS.userid=$userid AND $TABLE_USERS.active=1");
				$onlineFriendsCount = $onlineFriendsCountArray['friends_count'];
				?>

				<select id="cockpit_window_user_select" name="cockpit_window_user_select" onChange="location='gate.php?m=2&selrec='+document.cockpit_select_form.cockpit_window_user_select.options[document.cockpit_select_form.cockpit_window_user_select.selectedIndex].value;" class="cockpit_window_select">
					<option SELECTED>online: <? echo "$onlineFriendsCount/$countthem" ?></option>

				<?
				while($logged=mysql_fetch_array($select_logged_users)) {
					$user = $logged["login"];
				?>
					<option name="user" value="<? echo "$user" ?>"><? echo "$user" ?></option>

				<?
				}
				?>

				</select>
				<? /* ONLINE LIST */ ?>

			</form>
       	</div>


		<? if ($newnum != 0) { ?>
                  <? include('incl/cockpit_content_newmail.php'); ?>
		<? }elseif ($note != null){ ?>
                  <? include('incl/cockpit_content_warning.php'); ?>
		<? }else{ ?>
                  <? include('incl/cockpit_content_default.php'); ?>
            <? } ?>
           

	</div>

</div>

