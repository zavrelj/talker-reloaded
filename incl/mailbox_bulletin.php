  <form name="postform" method="post" action="gate.php?m=2&s=1" onsubmit="return submitForm();">
	<? $genhash =  time().mt_rand(100000, 499999); ?>
	<input type="hidden" name="formGenHashValue" value="<? echo $genhash ?>">

	<div class="editor">
			<!-- EDITOR WINDOW //-->
			<?
			//zde dojde k nacteni preferovaneho editoru prispevku
			//zaroven je treba odeslat informaci, ze se nachazime v poste, podle cehoz
			//bude zvolen prislusny typ formulare a odesilanych dat

			$edit_module=0;
			//echo "EDITOR:".$editor;
			include('incl/editor.php');
			?>
			<!-- EDITOR WINDOW //-->
	</div>

	<div class="navigation">
		
            
            <!-- NAVIGATION WINDOW //-->
		<?
            //fuserid, ktery obsahuje id uzivatele, jehoz prispevky se maji zobrazit,
            //je v prubehu vypisovani prispevku prepsan!!!
            //tomu je treba zabranit tak, ze vezmeme puvodni verzi, ulozime do pomocne promenne
            //a po probehnuti cyklu naplnime id uzivatele hodnotou teto pomocne promenne
            $fuserid_orig = $fuserid;
            ?>
            <? $navigation_id=11 ?>
		<? include('incl/navigation.php'); ?>
		<? $navigation_id=0 ?>
		<!-- NAVIGATION WINDOW //-->
	</div>
	</form>


	<form name="mailboxform" method="post" action="gate.php?m=2&s=1" id="mailboxform">
		<div id="selection_buttons">
    <input type="button" value="<? echo $LNG_BULLETIN_SELECTALL; ?>" onClick="selectAllMsg('mailboxform', 'delmsg[]');">
		<input type="button" value="<? echo $LNG_BULLETIN_UNSELECTALL; ?>" onClick="unselectAllMsg('mailboxform', 'delmsg[]');">
		<input type="button" value="<? echo $LNG_BULLETIN_SELECTBETWEEN; ?>" onClick="selectRangeMsg('mailboxform', 'delmsg[]');">
		<input type="button" value="<? echo $LNG_BULLETIN_SELECTINVERT; ?>" onClick="selectInvertMsg('mailboxform', 'delmsg[]');">
		<input name="del" type="submit" value="<? echo $LNG_BULLETIN_DELETESELECTED; ?>">
		<input type="hidden" name="what" value="<? echo $what ?>">
    </div>
		
            
            
            <div id="wrap">
            
            <? if ($preview==$LNG_PREVIEW && $parsedMessageContent !="" && $db_passwd == $session_passwd) {?>
			<? include('incl/message_preview.php');?>
		<? } ?>

		<?
		while($show_record=MySQL_Fetch_array($showvalue)) {
			$timestampvalue = $show_record["date"];
			$formatteddate = date("d.m.Y  H:i:s",$timestampvalue);
			$viewed = $show_record["viewed"];
                  
                  //this is for swap of background of post
                  if ($bg_flag==1) {
                        $bg_flag=2;
                  }else{
                        $bg_flag=1;
                  }
                        
			//PUVODNE MISTO user_name BYLO receivername, V PRIPADE PROBLEMU VRATIT
			//$receivername = getUserLogin($show_record["toid"]);
			$user_name = getUserLogin($show_record["toid"]);

			if ($show_record["fromid"] == $userid) {
				$info_toid=$show_record["toid"];
				$loc_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE userid=$info_toid AND active=1");
				if (mysql_num_rows($loc_result)!=0) {
					$inforesult = _oxResult("SELECT location, lastaccess, status FROM $TABLE_USERS WHERE userid=$info_toid");
					$inforecord = mysql_fetch_array($inforesult);
					$infolocation = $inforecord["location"];
					$infolastaccess = $inforecord["lastaccess"];
					$infostatus = $inforecord["status"];
					$locationArray = getLocation($infolocation);
					$infolocation = $locationArray['infolocation'];
					$location_number = $locationArray['location_number'];
				}
				$fuserid = $show_record["toid"];
				$user_name = getUserLogin($fuserid);
				//$hiscurrentAT = getUserAT($fuserid);
				$fuser_level = getUserLevel($fuserid);
				$level_icon = _oxShowLevel($fuser_level);
        //$hisimg=_oxShowAT($hiscurrentAT);
				$message_type=0;//odeslana zprava
				include('incl/message.php');
			}


			if ($show_record["toid"] == $userid) {
				$info_fromid=$show_record["fromid"];
				$loc_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE userid=$info_fromid AND active=1");
				if (mysql_num_rows($loc_result)!=0) {
					$inforesult = _oxResult("SELECT location, lastaccess, status FROM $TABLE_USERS WHERE userid=$info_fromid");
					$inforecord = mysql_fetch_array($inforesult);
					$infolocation = $inforecord["location"];
					$infolastaccess = $inforecord["lastaccess"];
					$infostatus = $inforecord["status"];
					$locationArray = getLocation($infolocation);
					$infolocation = $locationArray['infolocation'];
					$location_number = $locationArray['location_number'];
				}
				$sentdate = $show_record["date"];
				$fuserid = $show_record["fromid"];
				$user_name = getUserLogin($fuserid);
				//$hiscurrentAT = getUserAT($fuserid);
				$fuser_level = getUserLevel($fuserid);
				$level_icon = _oxShowLevel($fuser_level);
        //$hisimg=_oxShowAT($hiscurrentAT);
				if ($viewed==0) {
					$message_type=1;//prijata zprava - neprectena
				}else{
					$message_type=2;//prijata zprava - prectena
				}
				include('incl/message.php');
			}
		}
		?>
		
	     </div>
		
		
	</form>


	<form action="gate.php?m=2&s=1" method="post">
	<div class="navigation">
		<!-- NAVIGATION WINDOW //-->
		<? $navigation_id=12 ?>
		<? //$fuserid = ""; //has to be deleted, otherwise listing of all users fail ?>
		<? $fuserid = $fuserid_orig; ?>
            <? include('incl/navigation.php'); ?>
		<? $navigation_id=0 ?>
		<!-- NAVIGATION WINDOW //-->
	</div>
	</form>

	<? _oxMod("UPDATE $TABLE_MAILBOX SET viewed=1 WHERE toid=$userid"); ?>
