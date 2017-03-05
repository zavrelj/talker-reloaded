					<? if ($wrong_format==1) { ?>
						! neplatný formát ikonky!
							<? $wrong_format=0; ?>
					<? } ?>

					<? if ($wrong_format2==1) { ?>
							! neplatný formát ikonky!
							<? $wrong_format2=0; ?>
					<? } ?>

					<? if ($wrong_size==1) { ?>
							! ikonka je vìtší než 5kB !
							<? $wrong_size=0; ?>
					<? } ?>

					<? if ($wrong_psswd==1) { ?>
							! špatné heslo, nebo hesla nesouhlasí !
							<? $wrong_psswd=0; ?>
					<? } ?>

					<? if ($psswd_ok==1) { ?>
							! heslo úspìšnì zmìnìno, odhlaste se prosím a pøihlašte se s novým heslem !
							<? $psswd_ok=0; ?>
					<? } ?>

					<div id="cockpit_background">

						<div id="cockpit_content">

							<div id="cockpit_logged_user">
								<img src="ico/<? echo "$login" ?>.gif" class="cockpit_icon">
								<img src="style/<? echo "$css" ?>/at/<? echo "$img" ?>" class="cockpit_atbar">
							</div>

							<div id="cockpit_default">
								<? if ($newnum != 0) { ?>
									<? include('incl/cockpit_content_newmail.php'); ?>
								<? }elseif ($sess_out!=0){ ?>
									<? include('incl/cockpit_content_sessout.php'); ?>
								<? }elseif ($cockpit_warning != null){ ?>
									<? include('incl/cockpit_content_warning.php'); ?>
								<? }else{ ?>

									<? include('incl/cockpit_content_default.php'); ?>

								<? } ?>


								<!--<div id="status_list">//-->
								<!-- STATUS LIST //-->
								<form name="status_select_form" method="post">
									<select id="cockpit_window_status_select" name="cockpit_window_status_select" onChange="javascript:location='gate.php?m=1&s=1&ns='+document.status_select_form.cockpit_window_status_select.options[document.status_select_form.cockpit_window_status_select.selectedIndex].value;" class="cockpit_window_select">
									<? for ($i=0; $i<=count($LNG_STATUS_LIST)-1; $i++) { ?>

										<!--
										<option name="user" value="<? echo $i; ?>" <?if ($LNG_STATUS_LIST[$i]==$status) { echo "SELECTED"; }?>><? echo $LNG_STATUS_LIST[$i]; ?></option>
										//-->

										<?if ($LNG_STATUS_LIST[$i]==$status) {?>
											<option name="user" value="<? echo $i; ?>" SELECTED><? echo $LNG_STATUS_LIST[$i]; ?></option>
											<?
											$default=1;
											echo "vybran defaultni status";
											?>
										<? }else{ ?>
											<option name="user" value="<? echo $i; ?>"><? echo $LNG_STATUS_LIST[$i]; ?></option>
										<? } ?>

									<? } ?>

									<? if (!isSet($default) || isSet($custom_status)) {?>
										<option name="user" value="-1" SELECTED>--<? echo $LNG_STATUS_OWN; ?>--</option>
									<? } ?>

									</select>
								</form>
								<!-- STATUS LIST //-->
								<!--</div>//-->

								<!--<div id="internet_list">//-->
								<!-- INTERNET LIST //-->
								<form name="link_select_form" method="post">
									<?
									$links_result = _oxResult("SELECT address01, label01, address02, label02, address03, label03, address04, label04, address05, label05  FROM $TABLE_USERS WHERE userid=$userid");
									$links_record = mysql_fetch_array($links_result);
									?>

									<select id="cockpit_window_link_select" name="cockpit_window_link_select" onChange="javascript:showNet(document.link_select_form.cockpit_window_link_select.options[document.link_select_form.cockpit_window_link_select.selectedIndex].value); document.link_select_form.cockpit_window_link_select.selectedIndex = 0;" class="cockpit_window_select">
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

								</form>
								<!-- INTERNET LIST //-->
								<!--</div>//-->

								<!--<div id="online_list">//-->
								<!-- ONLINE LIST //-->
								<form name="user_select_form" method="post">
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

									<select id="cockpit_window_user_select" name="cockpit_window_user_select" onChange="location='gate.php?m=2&selrec='+document.user_select_form.cockpit_window_user_select.options[document.user_select_form.cockpit_window_user_select.selectedIndex].value;" class="cockpit_window_select">
										<option SELECTED>aktivní: <? echo "$onlineFriendsCount/$countthem" ?></option>

									<?
									while($logged=mysql_fetch_array($select_logged_users)) {
										$user = $logged["login"];
									?>
										<option name="user" value="<? echo "$user" ?>"><? echo "$user" ?></option>
									<?
									}
									?>

									</select>
								</form>
								<!-- ONLINE LIST //-->
								<!--</div>//-->







							</div>

						</div>





						<div id="empty"></div>

					</div>
