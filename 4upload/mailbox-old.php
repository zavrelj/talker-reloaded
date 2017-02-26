<?

$selrec = $_GET['selrec'];

$del = $_POST['del'];
$delmsg = $_POST['delmsg'];
$delreceivermsg = $_POST['delreceivermsg'];

$send = $_POST['send'];
$view = $_POST['view'];
$messageContent = $_POST['message_content'];
$postform_genhash = $_POST['postform_genhash'];

//$messageto = $_POST['messageto'];

$backvalue = $_POST['backvalue'];
$back = $_POST['back'];
$frwdvalue = $_POST['frwdvalue'];
$frwd = $_POST['frwd'];
$end = $_POST['end'];
$endvalue = $_POST['endvalue'];
$start = $_POST['start'];
$startvalue = $_POST['startvalue'];
$chosen = $_POST['chosen'];
$memselectbox = $_POST['memselectbox'];
$calculate = $_POST['calculate'];
$selectbox = $_POST['selectbox'];


if ($send == odeslat && $db_passwd == $session_passwd) {


	//prevede obsah zpravy do formy zpetne zobrazitelne ve WYSIWYGu
	//nejspis bude potreba pouze u nahledu....
	if ($editor == 2) {
		//format content for preloading
		if (!(isset($_POST["message_content"]))) {
			$messageContent = "";
		} else {
			//retrieve posted value
			$messageContent = rteSafe($_POST["message_content"]);
		}
	}


	//nejdriv zkontroluje zda uz neni prispevek odeslan - muze se stat stisknutim
	//F5, ze bude dvakrat odeslano to same



	$isAlreadySentArray = _oxQuery("SELECT fromid FROM $TABLE_MAILBOX WHERE fromid=$userid AND toid=$receiver_id AND genhash=$postform_genhash");
	if ($isAlreadySentArray['fromid'] == "") {



		//replaceMessage se provede pouze v plaintext modech
		if ($editor == 0 || $editor == 1) {
			$parsedMessageContent = replaceMessage($messageContent);
			$parsedMessageContent = addslashes($parsedMessageContent);
		}else{
			$parsedMessageContent = $messageContent;
		}


		if ($receiver_id != -1 && $receiver_id != $userid && $parsedMessageContent != "") {
			$now=time()+$SUMMER_TIME;
			//jednou se zprava ulozi pro prijemce
			_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $receiver_id, '$parsedMessageContent', $now, 0, $receiver_id, $postform_genhash)");
			//podruhe se ulozi kopie pro odesilatele
			_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $receiver_id, '$parsedMessageContent', $now, 0, $userid, $postform_genhash)");
		}


		$receiverNoticeArray = _oxQuery("SELECT login, mobil, email, active FROM $TABLE_USERS WHERE userid='$receiver_id'");
		$active_receiver = $receiverNoticeArray["active"];


		if ($active_receiver == 0) {
			$mobil_db = $receiverNoticeArray["mobil"];
			$email_db = $receiverNoticeArray["email"];
			$receiver_name = $receiverNoticeArray["login"];

			if ($mobil_db != "") {
				//odesle zpravu z posty na mobil
				$mobil_message_content=substr($parsed_message_content, 0, 100);
				//mail("$mobil_db", "BlowFly||$receiver_name", "od:$login:$mobil_message_content");
			}

			if ($email_db!="") {
				//odesle zpravu z posty na email
				//mail("$mobil_db", "BlowFly||$receiver_name", "od:$login:$parsed_message_content");
			}
		}

	}







	//NAVIGACE
	//jelikoz je zmena poctu zobrazovanych prispevku navesena pres stisk
	//klavesy enter na zaslani prazdneho prispevku, je treba tady provest vynulovani
	//navigacnich hodnot, jinak to dela blbosti
	//odeslani skutecneho prispevku stejne zobrazi posledni prispevky, takze
	// pri teto situaci ono vynulovani vubec nevadi
	$frwdvalue= 0;
	$backvalue= 0;
	$startvalue= 0;
	$endvalue= 0;


}







if ($view == náhled && $db_passwd == $session_passwd) {
	$viewing=1;

    //prevede obsah zpravy do formy zpetne zobrazitelne ve WYSIWYGu
	//nejspis bude potreba pouze u nahledu....
	if ($editor == 2) {
		//format content for preloading
		if (!(isset($_POST["message_content"]))) {
			$messageContent = "";
		} else {
			//retrieve posted value
			$messageContent = rteSafe($_POST["message_content"]);
		}
	}


	//replaceMessage se provede pouze v plaintext modech
	if ($editor == 0 || $editor == 1) {
		$parsedMessageContent = replaceMessage($messageContent);
		$previewMessageContent = stripslashes($parsedMessageContent);
	}else{
		$previewMessageContent = stripslashes($messageContent);
	}




	//NAVIGACE
	//vedle stisku enter lze odeslat zmenenou hodnotu i pres nahled
	//proto i zde dochazi k vynulovani hodnot
	$frwdvalue= 0;
	$backvalue= 0;
	$startvalue= 0;
	$endvalue= 0;


}



























//sender obsahuje vzdy ID uzivatele, u ktereho se dana zprava
//zobrazi
if ($del == "smazat oznaèené" && $db_passwd == $session_passwd) {
	$delresult=_oxResult("SELECT date FROM $TABLE_MAILBOX WHERE (fromid=$userid OR toid=$userid) AND sender=$userid ORDER BY date DESC");
	while($delrecord=MySQL_Fetch_array($delresult)) {
		$deldate=$delrecord["date"];

		for ($i=0; $i<Count($delmsg); $i++) {
			if ($delmsg[$i] == $deldate) {
				//MAZU JEN SVOU
				_oxMod("DELETE FROM $TABLE_MAILBOX WHERE date=$delmsg[$i] AND sender=$userid");
			}
		}

		for ($i=0; $i<Count($delreceivermsg); $i++) {
			if($delreceivermsg[$i] == $deldate) {
				//MAZU I TU DRUHOU
				_oxMod("DELETE FROM $TABLE_MAILBOX WHERE date=$delreceivermsg[$i] AND fromid=$userid");
			}
		}





	}
}










	$result = _oxResult("SELECT login FROM $TABLE_USERS, $TABLE_MAILBOX WHERE $TABLE_USERS.userid=$TABLE_MAILBOX.fromid AND $TABLE_MAILBOX.toid = $userid ORDER BY date DESC");
	$record = mysql_fetch_array($result);
	$last_sender = $record["login"];


	$currentAT = getUserAT($userid);
	$img=_oxShowAT($currentAT);









	//pokud byl proveden vyber ze seznamu pratel a nejednalo se o void plozku
	//nastav jako prijemce tento vyber
	if ($selectfriend != null && $selectfriend != "x") {
		$receiver= $selectfriend;

	}else{
		//pokud byl v messageto neexistujici uzivatel nebo byla prazdna (tj. obsahuje -1)
		//nebo pokud byla vybrana void polozka ze seznamu pratel, nastav jako defaultniho prijemce
		//posledniho odesilatele zpravy pro prihlaseneho uzivatele
		//v opacnem pripade nastav jako defaultniho prijemce posledniho prijemce zpravy
		if ($messageto == -1 || !isSet($messageto) || $selectfriend == "x") {
			$receiver= $last_sender;
		}else{
			$receiver= $messageto;
		}
	}

	if ($selrec != null) {
		$receiver= $selrec;
	}





















$tips_num=rand(0, count($TIPS)-1);












//***********************NAVIGACE*****************************************
//echo "OLD_ROWNUM: ".$_SESSION['old_rownum']."<br>";

$allMsgsCountResult = _oxResult("SELECT COUNT(fromid) AS all_msgs_count FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid) OR (fromid=$userid AND sender=$userid)) ORDER BY date DESC");
$allMsgsCountArray = mysql_fetch_array($allMsgsCountResult);
$allMsgsCount = $allMsgsCountArray['all_msgs_count'];

//echo "POCET VSECH PRISPEVKU DISKUZE: ".$allMsgsCount."<br>";

//tady se plni hodnota rownum pro nasledne selecty prispevku podle
//ruznych podminek

//pokud nedoslo k navigaci v ramci diskuze (za navigaci se povazuje
//i odeslani prispevku a nahled), znamena to, ze jsme do
//ni prave prisli a vytahneme z DB preferovanou hodnotu pro pocet
//zobrazovanych zprav
//pokud doslo k odeslani prispevku, nahledu nebo fakticke navigaci
//pomoci buttonu, prevezmu si cislo, z policka show_msgs_count a
//tento pocet prispevku zobrazim

//zjistim, zda je $show_msgs_count prazdny, pokud ano, prisel
//jsem prave do diskuze
//fakticka navigace zajisti jeho naplneni, aby toto naplneni zajistila
//i tzv. pseudonavigace, tj. odeslani/nahled/refresh, je treba resit
//rownum jiz pred generovanim odesilaciho formulare

$show_msgs_count = $_POST['show_msgs_count'];
//echo "show_msgs_count: ".$show_msgs_count."<br>";


//pokud je tedy show_msgs_count prazdny, neni cislo, nebo je mensi nebo roven nule
//nastavim pocet zobrazovanych prispevku podle DB, jinak podle predane hodnoty
if ($show_msgs_count == "" || !is_numeric($show_msgs_count) || $show_msgs_count <= 0) {
	//echo "show_msgs_count je prazdny<br>";
	$showMsgsCountResult = _oxResult("SELECT msgs FROM $TABLE_USERS WHERE userid=$userid");
	$showMsgsCountRecord = mysql_fetch_array($showMsgsCountResult);
	$showMsgsCount = $showMsgsCountRecord["msgs"];
}else{
	$showMsgsCount = $show_msgs_count;
}


//tady bude cislo z db
$rownum = $showMsgsCount;

//zde si musim pocet novych prispevku zjistit manualne z DB
//do room mi prijde z bookmarku pres GET
$newMsgsCountResult = _oxResult("SELECT COUNT(fromid) AS new_msgs_count FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid AND viewed=0)) ORDER BY date DESC");
$newMsgsCountArray = mysql_fetch_array($newMsgsCountResult);
$newnr = $newMsgsCountArray['new_msgs_count'];


//pokud je newnr cislo a zaroven se nejedna o nulu, prisel jsem ze SLEDOVANYCH DISKUZI
//a musim resit zobrazovani novych prispevku

//pokud je pocet
//novych prispevku vetsi nez pocet preferovane zobrazovanych
//pak do inputu vloz hodnotu showMsgsCount, vzhledem k tomu,
//ze nove prispevky se zobrazuji pouze pri prvnim vstupu
//do diskuze, bude tato hodnota vzdy obsahovat preferovanou
//hodnotu z DB


if ($newnr != 0) {

	//pokud je mene novych prispevku, nez tech, ktere maji byt zobrazeny
	//pak zobraz nove prispevky + (pocet zobrazovanych - ty nove)
	if ($rownum > $newnr) {
		$rownum = $newnr + ($rownum-$newnr);
	}else{
		$rownum = $newnr + 2;
	}
}

//echo "POCET ZOBRAZOVANYCH PRISPEVKU DISKUZE: ".$rownum."<br>";


if ($start == $LNG_NAVIGATION_NEWEST_SUBMIT) {
	$frwdvalue = 0;
	$backvalue = $frwdvalue;
	$showvalue = _oxResult("SELECT * FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid) OR (fromid=$userid AND sender=$userid)) ORDER BY date DESC LIMIT 0,$rownum");

	$msg_from = $allMsgsCount - 0;
	if ($msg_from >= $rownum) {
		$msg_to = $msg_from - $rownum + 1;
	}else{
		$msg_to = 1;
	}

}else{
	if ($end == $LNG_NAVIGATION_OLDEST_SUBMIT) {
		$end = $allMsgsCount-$rownum;
		$frwdvalue = $allMsgsCount-$rownum;
		$backvalue = $allMsgsCount-$rownum;
		$showvalue = _oxResult("SELECT * FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid) OR (fromid=$userid AND sender=$userid)) ORDER BY date DESC LIMIT $end,$rownum");

        $msg_from = $allMsgsCount - $end;
		if ($msg_from >= $rownum) {
			$msg_to = $msg_from - $rownum + 1;
		}else{
			$msg_to = 1;
		}

	}else{


		if ($back == $LNG_NAVIGATION_OLDER_SUBMIT) {
			//pokud bylo odeslano tlacitko starsi s jinym cislem nez je aktualni hodnota rownum
			//aktualni hodnotu uchovej stranou, aktualizuj ji backvalue a pak pro select jiz pouzij
			//novou hodnotu rownum
			if ($_SESSION['old_rownum'] != $rownum) {
				$backvalue = $backvalue+$_SESSION['old_rownum'];
				$frwdvalue = $frwdvalue+$_SESSION['old_rownum'];
			}else{
				$backvalue = $backvalue+$rownum;
				$frwdvalue = $frwdvalue+$rownum;
			}

			$showvalue = _oxResult("SELECT * FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid) OR (fromid=$userid AND sender=$userid)) ORDER BY date DESC LIMIT $backvalue,$rownum");

            $msg_from = $allMsgsCount - $backvalue;
			if ($msg_from >= $rownum) {
				$msg_to = $msg_from - $rownum + 1;
			}else{
				$msg_to = 1;
			}

		}else{
			if($frwd == $LNG_NAVIGATION_NEWER_SUBMIT) {
				$frwdvalue = $frwdvalue-$rownum;
				if ($frwdvalue < 0) {$frwdvalue=0;}
				$backvalue= $frwdvalue;
				$showvalue = _oxResult("SELECT * FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid) OR (fromid=$userid AND sender=$userid)) ORDER BY date DESC LIMIT $frwdvalue,$rownum");

				$msg_from = $allMsgsCount - $frwdvalue;
				if ($msg_from >= $rownum) {
					$msg_to = $msg_from - $rownum + 1;
				}else{
					$msg_to = 1;
				}

			}else{
				$backvalue = 0;
				$showvalue = _oxResult("SELECT * FROM $TABLE_MAILBOX WHERE ((toid=$userid AND sender=$userid) OR (fromid=$userid AND sender=$userid)) ORDER BY date DESC LIMIT 0,$rownum");

				$msg_from = $allMsgsCount - 0;
				if ($msg_from >= $rownum) {
					$msg_to = $msg_from - $rownum + 1;
				}else{
					$msg_to = 1;
				}

			}

		}

	}
}


//az tady dojde k aktualizaci stareho rownumu
$_SESSION['old_rownum'] = $rownum;


//***********************NAVIGACE*****************************************



?>

<!-- SUBMENU //-->
<? include('incl/sub_menu.php'); ?>
<!-- SUBMENU //-->


	<form name="postform" method="post" action="gate.php?m=2" onsubmit="return submitForm();">
	<? $genhash =  time().mt_rand(100000, 499999); ?>
	<input type="hidden" name="postform_genhash" value="<? echo $genhash ?>">
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
		<? $navigation_id=11 ?>
		<? include('incl/navigation.php'); ?>
		<? $navigation_id=0 ?>
		<!-- NAVIGATION WINDOW //-->
	</div>
	</form>


	<form method="post" action="gate.php?m=2">
		<input name="del" type="submit" value="smazat oznaèené">
		<input type="hidden" name="what" value="<? echo $what ?>">

		<? if ($view==náhled && $previewMessageContent !="" && $db_passwd == $session_passwd) {?>
			<? include('incl/message_preview.php');?>
		<? } ?>

		<?
		while($show_record=MySQL_Fetch_array($showvalue)) {
			$timestampvalue = $show_record["date"];
			$formatteddate = date("d.m.Y  H:i:s",$timestampvalue);
			$viewed = $show_record["viewed"];

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
				$his_id = $show_record["toid"];
				$user_name = getUserLogin($his_id);
				$hiscurrentAT = getUserAT($his_id);
				$hisimg=_oxShowAT($hiscurrentAT);
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
				$his_id = $show_record["fromid"];
				$user_name = getUserLogin($his_id);
				$hiscurrentAT = getUserAT($his_id);
				$hisimg=_oxShowAT($hiscurrentAT);
				if ($viewed==0) {
					$message_type=1;//prijata zprava - neprectena
				}else{
					$message_type=2;//prijata zprava - prectena
				}
				include('incl/message.php');
			}
		}
		?>
	</form>


	<form action="gate.php?m=2" method="post">
	<div class="navigation">
		<!-- NAVIGATION WINDOW //-->
		<? $navigation_id=12 ?>
		<? include('incl/navigation.php'); ?>
		<? $navigation_id=0 ?>
		<!-- NAVIGATION WINDOW //-->
	</div>
	</form>

	<? _oxMod("UPDATE $TABLE_MAILBOX SET viewed=1 WHERE toid=$userid"); ?>







