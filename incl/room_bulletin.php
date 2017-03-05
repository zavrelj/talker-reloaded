<? if ($denyier!=$userid) { ?>
	<div id="discussion_info">
  <div id="discussion_name"><? echo "$roomname" ?></div>
	číslo diskuze: <? echo "$roomid" ?>
	| <?if ($private_db!=0) { ?>
		<? echo $LNG_DISCUSSION_PRIVATE; ?>
	<? }else{ ?>
		<? echo $LNG_DISCUSSION_PUBLIC; ?>
	<? } ?>
  </div>



	<? if ($minihomepage!="") { ?>
		<div id="noticeboard_header"><? echo $LNG_DISCUSSION_NOTICEBOARD; ?></div>
    <div id="noticeboard_content"><? echo stripslashes($minihomepage);?></div>
	<? } ?>

							<!-- STREDNI SEKCE //-->
							<form name="postform" method="post" action="gate.php?m=10&s=1" onsubmit="return submitForm();">
							<? $genhash =  time().mt_rand(100000, 499999); ?>
                			<input type="hidden" name="formGenHashValue" value="<? echo $genhash ?>">

            					<!-- EDITOR WINDOW //-->
								<?
								//zde dojde k nacteni preferovaneho editoru prispevku
								//zaroven je treba odeslat informaci, ze se nachazime v diskuzi, podle cehoz
								//bude zvolen prislusny typ formulare a odesilanych dat
								$edit_module=1;
								include('incl/editor.php');
								?>
								<!-- EDITOR WINDOW //-->


                                                
                                                
                                                                                    
								<!-- NAVIGATION WINDOW //-->
								<?
                                                //fuserid, ktery obsahuje id uzivatele, jehoz prispevky se maji zobrazit,
                                                //je v prubehu vypisovani prispevku prepsan!!!
                                                //tomu je treba zabranit tak, ze vezmeme puvodni verzi, ulozime do pomocne promenne
                                                //a po probehnuti cyklu naplnime id uzivatele hodnotou teto pomocne promenne
                                                $fuserid_orig = $fuserid;
                                                ?>
                                                <? $navigation_id=21 ?>
								<? include('incl/navigation.php'); ?>
								<? $navigation_id=0 ?>
								<!-- NAVIGATION WINDOW //-->



							</form>
							<!-- STREDNI SEKCE //-->





<!-- tady končí horní sekce, každý příspěvěk je v samostatné tabulce, aby při příli‘ dlouhém
příspěvku nedocházelo k roztažení celé struktury ani k ovlivňování ‘ířky ostatních příspěvků
//-->


	<form name="roomform" method="post" action="gate.php?m=10&s=1" id="roomform">
		<?if (($userid == $auditor) OR ($delownvalue == 1) OR ($allower==$userid)) {?>
		<div id="selection_buttons">	
      <input name="roomid" type="hidden" value="<? echo $roomid ?>">
			<input type="button" value="<? echo $LNG_BULLETIN_SELECTALL; ?>" onClick="selectAllMsg('roomform', 'delmsg[]');">
			<input type="button" value="<? echo $LNG_BULLETIN_UNSELECTALL; ?>" onClick="unselectAllMsg('roomform', 'delmsg[]');">
			<input type="button" value="<? echo $LNG_BULLETIN_SELECTBETWEEN; ?>" onClick="selectRangeMsg('roomform', 'delmsg[]');">
			<input type="button" value="<? echo $LNG_BULLETIN_SELECTINVERT; ?>" onClick="selectInvertMsg('roomform', 'delmsg[]');">
			<input name="del" type="submit" value="<? echo $LNG_BULLETIN_DELETESELECTED; ?>">
		</div>	
		<?}?>

		<? if ($preview==$LNG_PREVIEW && $parsedMessageContent !="" && $db_passwd == $session_passwd) {?>
			<? include('incl/message_preview.php');?>
		<? } ?>

			<?
			while($show_record=MySQL_Fetch_array($show_result)) {

			$fuserid = $show_record["fromid"];

			$his_info_result=_oxResult("SELECT login, AT, level FROM $TABLE_USERS WHERE userid=$fuserid");
			$his_info_record=mysql_fetch_array($his_info_result);

			$user_name = $his_info_record["login"];
			$hiscurrentAT = $his_info_record["AT"];
			$hisuserlevel = $his_info_record["level"];
			$hisimg=_oxShowLevel($hisuserlevel);

			$message=$show_record["message"];

			$msgid=$show_record["msg_id"];

			$timestampvalue = $show_record["date"];
			$formatteddate = date("d.m.Y H:i:s",$timestampvalue);


			//zjistim, zda je odesilatel zpravy v seznamu mych pratel
			$is_friend_user_id = getUserId("$user_name");
			$is_already_friend_array = _oxQuery("SELECT friendid FROM $TABLE_FRIENDS WHERE friendid=$is_friend_user_id AND userid=$userid");



			$loc_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE userid=$fuserid AND active=1");

			if (mysql_num_rows($loc_result)!=0 && $fuserid!=$userid) {



				$inforesult = _oxResult("SELECT location, lastaccess, status FROM $TABLE_USERS WHERE userid=$fuserid");
				$inforecord = mysql_fetch_array($inforesult);

				$infolocation = $inforecord["location"];
				//echo "INFOLOCATION: ".$infolocation;
                        $infolastaccess = $inforecord["lastaccess"];
				$infostatus = $inforecord["status"];

				$locationArray = getLocation($infolocation);
				$infolocation = $locationArray['infolocation'];
				$location_number = $locationArray['location_number'];


				/* ZJISTENI LOKACE UZIVATELE */

			}




			if ($timestampvalue > $lastaccess && $lastaccess != "" && $user_name!=$login) {
				//kontrola je zalozena na porovnani zacatku prispevku s uzivatelskym jmenem
				//pokud jsou shodne, vypise ze PRISPEVEK PRO TEBE
				//po pridani tagu <b> pred uzivatelske jmeno vsak toto prestalo fungovat
				//proto je nutne zpravu zkopirovat do arr_message, z ni odstranit tagy a kontrolu
				//provest na zbytku retezce


				$arr_message=$message;
				$arr_message=strip_tags($arr_message);
				$the_same=1;

				for ($i=0; $i<=strlen($login)-1; $i++) {
					if($login[$i]!=$arr_message[$i]) {
						$the_same=0;
					}
				}

				if ($arr_message[strlen($login)] != " " && $arr_message[strlen($login)] != ":") {
					$the_same=0;
				}
			}




			?>


			<!-- MESSAGE TABLE //-->
            <? include('incl/message.php'); ?>
            <!-- MESSAGE TABLE //-->


			<? } ?>


	</form>











	<form action="gate.php?m=10&s=1" method="post">
		<!-- NAVIGATION WINDOW //-->
		<? $navigation_id=22 ?>
		<? //$fuserid = ""; //has to be deleted, otherwise listing of all users fail ?>
		<? $fuserid = $fuserid_orig; ?>
            <? include('incl/navigation.php'); ?>
		<? $navigation_id=0 ?>
		<!-- NAVIGATION WINDOW //-->
	</form>

<?}?>

