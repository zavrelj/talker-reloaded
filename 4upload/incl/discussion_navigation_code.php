<?
//***********************NAVIGACE*****************************************
//echo "OLD_ROWNUM: ".$_SESSION['old_rownum']."<br>";

$newnr = $_GET['newnr'];
//echo "POCET NOVYCH PRISPEVKU DISKUZE: ".$newnr."<br>";

$allMsgsCountResult = _oxResult("SELECT COUNT(fromid) AS all_msgs_count FROM $TABLE_ROOM WHERE roomid=$roomid ORDER BY date DESC");
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

//pokud je newnr cislo a zaroven se nejedna o nulu, prisel jsem ze SLEDOVANYCH DISKUZI
//a musim resit zobrazovani novych prispevku

//pokud je pocet
//novych prispevku vetsi nez pocet preferovane zobrazovanych
//pak do inputu vloz hodnotu showMsgsCount, vzhledem k tomu,
//ze nove prispevky se zobrazuji pouze pri prvnim vstupu
//do diskuze, bude tato hodnota vzdy obsahovat preferovanou
//hodnotu z DB


if (is_numeric($newnr) && $newnr != 0) {

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
	$show_result= _oxResult("SELECT * FROM $TABLE_ROOM WHERE roomid=$roomid ORDER BY date DESC LIMIT 0,$rownum");

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
		$show_result= _oxResult("SELECT * FROM $TABLE_ROOM WHERE roomid=$roomid ORDER BY date DESC LIMIT $end,$rownum");

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

			$show_result= _oxResult("SELECT * FROM $TABLE_ROOM WHERE roomid=$roomid ORDER BY date DESC LIMIT $backvalue,$rownum");

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
				$backvalue = $frwdvalue;
				$show_result = _oxResult("SELECT * FROM $TABLE_ROOM WHERE roomid=$roomid ORDER BY date DESC LIMIT $frwdvalue,$rownum");

            	$msg_from = $allMsgsCount - $frwdvalue;
				if ($msg_from >= $rownum) {
					$msg_to = $msg_from - $rownum + 1;
				}else{
					$msg_to = 1;
				}

            }else{
				$backvalue = 0;
				$show_result = _oxResult("SELECT * FROM $TABLE_ROOM WHERE roomid=$roomid ORDER BY date DESC LIMIT 0,$rownum");

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