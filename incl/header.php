<?
//com01
//toto je zacatek skriptu pro zobrazeni casu potrebnemu
//k vygenerovani stranky, konec skriptu a zaroven zobrazeni
//namereneho casu je umisteno na konci kazdeho modulu
$gen_script_start=time()+substr(microtime(),0,8);


//com02
//HTMLhlavicky pro vyprazdeni cache pameti a nastaveni
//expirace stranky na aktualni hodnotu, cimz by melo byt zajisteno
//aby client pozadoval po serveru v kazdem okamziku novou stranku
//a netahal starou stranku z cache pameti
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");

//com03
//nastartovani session pro nasledne ulozeni session promennych
//dojde v podstate k vytvoreni souboru v adresari session (ktery
//je nastaven v PHP interpretu jako adresar pro ukladani session
//promennych) a v tomto souboru se zapisou hodnoty, ktere byly
//definovany ve skriptu jako pole _SESSION, v pripade, ze session
//jiz existuje, dojde k precteni techto hodnot a naplneni pole
//_SESSION
session_start();

//com04
//pozadavek na nacteni hodnot a funkci ze souboru system.inc.php
require('system.inc.php');



//com05
//naplneni promennych hodnotami z pole _SESSION, viz com03
$userid = $_SESSION['userid'];
$password = $_SESSION['password'];
$login = $_SESSION['login'];
$last_log_time = $_SESSION['last_log_time'];
$invisible = $_SESSION['invisible'];

//com06
//new status - v pripade, ze dojde k vyberu stavu uzivatele v selectboxu
//na vrchu stranky, dojde zaroven k odeslani prislusneho kodu prostrednictvim
//adresniho radku, tedy metodou GET, zde je pak tento kod zachycen a vlozen
//do promenne ns
$ns = $_GET['ns'];

//com08
//zde se resi poprve problematika neopravneneho pristupu do systemu
//system je uzavren a schovan za logovacim formularem, ktery je po vlozeni
//dat odeslan na stranku logger.php, kde dojde k porovnani vlozenych dat s daty
//v databazi a v pripade shody take k naplneni session promennych, ktere jsou zde
//nasledne vytazeny z pole SESSION viz com03 a com05
//zde dochazi ke kontrole, zda neni userid, ktere ma obsahovat cislo prihlaseneho uzivatele
//prazdne, nulove, ci zda je vubec definovano, pokud tomu tak neni, dochazi okamzite k ukonceni
//generovani stranky a presmerovani na prihlasovaci formular, v opacnem pripade se jeste
//pro jistotu porovna heslo se session s heslem z databaze prislusejici id prihlaseneho uzivatele
//vzhledem k tomu, ze se tento skript provadi v head.php, ktery je vlozen na zacatku kazdeho souboru
//systemu, je zajisteno, ze pokus o primy vstup neprihlaseneho uzivatele napr. do diskuze skonci
//presmerovanim na prihlasovaci formular
//zde by se mohl do budoucna vyresit model anonymniho prohlizeni obsahu systemu a teprve prispivani
//by bylo podmineno registraci a prihlasenim
if ($userid != "" && $userid != null && $userid != 0) {
	$perm_result=_oxResult("SELECT password FROM $TABLE_USERS WHERE userid=$userid");
	$perm_record=mysql_fetch_array($perm_result);

	$db_passwd = $perm_record["password"];
	$session_passwd = $password;

	if($db_passwd != $session_passwd) {
		header("location: index.php?note=809");
	}

}else{
	header("location: index.php?note=809");
	exit();
}






//com09
//snaha o zajisteni aktualniho casu pricitanim jedne hodiny v letnich mesicich
//vychazi se z toho, ze webserver nereflektuje na zimni a letni cas
$timecr = time() + $SUMMER_TIME;
$time = date("H:i:s",$timecr);
$date = date("d.m.Y",$timecr);

//com10
//pokud neni promenna ns prazdna, pak vytahni z pole dostupnych stavu uzivatele
//ten, ktery odpovida dane hodnote v ns a zaroven aktualizuj stav uzivatele v
//databazi, vice o ns viz com06
if ($ns!="") {
	$new_stat=$LNG_STATUS_LIST[$ns];
	_oxMod("UPDATE $TABLE_USERS SET status='$new_stat' WHERE userid=$userid");
	$_GET['note'] = 406;
}

//com11
//zatim zde nic neni a popis bude doplnen a zjistim, k cemu to tu vlastne je :)
if ($custom_status != "") {

}


//com12
//jelikoz byl uspesne overen prihlaseny uzivatel, muzeme pristoupit ke kroku naplneni nekterych
//uzivatelskych hodnot z databaze do systemu
$select_active_user = _oxResult("SELECT AT, level, css, bg, status, location FROM $TABLE_USERS WHERE userid='$userid'");
$active_user = mysql_fetch_array($select_active_user);
$currentAT = $active_user["AT"];
$user_level = $active_user["level"];
$css = $active_user["css"];
$bg = $active_user["bg"];
$status = $active_user["status"];
$infolocation = $active_user["location"];
$level_icon = _oxShowLevel($user_level);


//com13
//zde resime, zda a kolik zprav v poste uzivatele je neprectenych
//pokud je vysledek neprazdny, tedy existuji neprectene zpravy, pak se poctem neprectenych
//zprav naplni hodnota newnum
$result = _oxResult("SELECT COUNT(viewed) AS viewed FROM $TABLE_MAILBOX WHERE toid = '$userid' AND viewed = 0 AND sender = $userid");
if ($result != "") {
	$res = mysql_fetch_array($result);
	$newnum=$res["viewed"];
      
      //zde si vytahneme jmeno uzivatele, ktery zaslal jako prvni novou zpravu
      $messageFromIDArray = _oxQuery("SELECT fromid FROM $TABLE_MAILBOX WHERE toid = '$userid' AND viewed = 0 AND sender = $userid");
      $messageFromID = $messageFromIDArray['fromid'];
      //echo $messageFromID;
      $messageFromName = getUserLogin($messageFromID);
      //echo $messageFromName;
}



//com14
//nahodne vybere cislo hlaseni (tipy, rady, vtipy, citaty, atp.) z pole ANNOUNCE
//a toto cislo vlozi do ann_num
$ann_num=rand(0, count($ANNOUNCE)-1);


//com15
//uzivatel ma moznost si zvolit pozici hlavni nabidky
//pokud je custom_menu prazde, neprisel jsem z nastaveni a musim zjistit preferovane umisteni menu
//z databaze
if ($custom_menu == "") {
	$result=_oxResult("SELECT menu FROM $TABLE_USERS WHERE userid=$userid");
	$record=mysql_fetch_array($result);
	$custom_menu = $record["menu"];
}

//com17
//system vyuziva k identifikaci pozice v nabidce funkci promennych z adresniho radku m a s
//m obsahuje cislo polozky hlavniho menu a s cislo polozky submenu
//podle ziskaneho cisla modulu se zmeni barva prislusneho tlacitka
$module_number = $_GET['m'];
$submodule_number = $_GET['s'];

//com07
//ciste pro lepsi orientaci v hlavni nabidce dochazi k pridani zalozky
//DISKUZE do hlavni nabidky v pripade, ze se uzivatel nachazi v nejake diskuzi
//v opacnem pripade se tato zalozka v hlavni nabidce nezobrazuje
//abychom vedeli, kdy zalozku DISKUZE zobrazit, pouzivame k tomu roomid, ktery
//obsahuje nejakou hodnotu prave pokud je uzivatel v diskuzi, tedy
//pokud existuje roomid v adresnim, bude do main menu pridana zalozka diskuze
//a dojde ke zmene sirky menu ve stylu - bude nactnen jiny
if ($_GET['roomid']!="") {
	$menuRoomID = $_GET['roomid'];
	//$MAIN_MENU_LEFT = main_menu_left_discussion;
}elseif ($_POST['roomid']!=""){
	$menuRoomID = $_POST['roomid'];
	//$MAIN_MENU_LEFT = main_menu_left_discussion;
}else{
	//$MAIN_MENU_LEFT = main_menu_left;
}


//com19
//tady si vytahnu podle aktualniho userid preferovany zpusob vkladani textu
$editorArray = _oxQuery("SELECT editor FROM $TABLE_USERS WHERE userid=$userid");
$editor = $editorArray['editor'];













//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA P O S T A AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
if ($module_number==2) {
	//*********************************ZAKLADNI NASTAVENI*****************************************

	if ($_GET['fuserid']!=null) {
		$fuserid = checkUserId($_GET['fuserid']);
	}elseif ($_POST['fuserid']!=null){
		$fuserid = checkUserId($_POST['fuserid']);
	}elseif ($_POST['fusername']!=null){
		//pokud prislo jmeno, je treba naplnit jednak
		$fuserid=getUserId($_POST['fusername']);
	}

	//pokud neprislo platne fuserid nebo jmeno, bude fuseridem prihlaseny userid a zapisu error
	if($fuserid == -1){
		$fuserid = $userid;
		$_GET['note'] = 201;
	}

	if(isSet($_POST['fuser_show']) && $_POST['fusername']==null){
		$fuserid = $userid;
		$_GET['note'] = 201;
	}




	//*********************************PROMENNE*****************************************
	$selrec = $_GET['selrec'];
	$del = $_POST['del'];
	$delmsg = $_POST['delmsg'];
	$delreceivermsg = $_POST['delreceivermsg'];
	$send = $_POST['send'];
	$preview = $_POST['preview'];


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
	$fuser_show = $_POST['fuser_show'];



	//*********************************AKCE SEND*****************************************
	if ($send == $LNG_SEND && $db_passwd == $session_passwd) {
		//akce send je vyvolana, pokud obsahuje POST promenna send prislusnou textovou hodnotu
		//akce send pozaduje:
		//1. adresata zpravy ($formReceiverName)
		//2. obsah zpravy ($formMessageContent)
		//3. kod pro zamezeni opetovneho odeslani pri refreshi stranky ($formGenHashValue)




		//PREJMENOVANI meesageto - ReceiverName
		//1. ReceiverName
		//musi obsahovat platne jmeno adresata
		//platnost jmena urci regularni vyraz
		//platne jmeno je slozeno z 3-20 znaku anglicke abecedy a cislice
		$uncheckedReceiverName = $_POST['formReceiverName'];

		//zjisti se platnost jmena uzivatele
		//pokud je jmeno platne, zjisti se, zda existuje uzivatel tohoto platneho jmena



		if (checkUserNameValidity($uncheckedReceiverName)) {

			$validReceiverName = $uncheckedReceiverName;
			if (checkUserNameUsability($validReceiverName)) {
				$usableReceiverName = $validReceiverName;
				$usableReceiver = true;
			}else{
				$usableReceiver = false;
				$_GET['note'] = 202;
			}

		}else{
			$_GET['note'] = 203;
		}




		//2. MessageContent
		//kontrola obsahu zpravy se provede pouze v plaintext editorech
		$uncheckedMessageContent = $_POST['formMessageContent'];

		if ($editor == 0 || $editor == 1) {
			$parsedMessageContent = replaceMessage($uncheckedMessageContent);
			$parsedMessageContent = addslashes($parsedMessageContent);
		}else{
			$parsedMessageContent = $uncheckedMessageContent;
		}

		if ($parsedMessageContent != "") {
			$usableMessage = true;
		}else{
			$usableMessage = false;
			$_GET['note'] = 301;
		}

		//3. GenHashValue
		//unikatni kod, ktery zamezuje nekolikanasobnemu odeslani zpravy pri stisku F5 (refreshi stranky)
		//vzhledem k tomu, ze uzivatel nema moznost hodnotu nijak ovlivnit, neprovadi se test validity
		//pro zjisteni pouzitelnosti GenHash je treba pouzitelny uzivatel
		$usableGenHashValue = $_POST['formGenHashValue'];
		if ($usableReceiver) {
			$usableReceiverID = getUserId($usableReceiverName);
			$isAlreadySentArray = _oxQuery("SELECT fromid FROM $TABLE_MAILBOX WHERE fromid=$userid AND toid=$usableReceiverID AND genhash=$usableGenHashValue");

			if ($isAlreadySentArray['fromid'] == "") {
				$usableGenHash = true;
			}else{
				$usableGenHash = false;
				$_GET['note'] = 302;
			}
		}



		if ($usableReceiver && $usableMessage && $usableGenHash && $usableReceiverID != $userid) {

			$now=time()+$SUMMER_TIME;
			//jednou se zprava ulozi pro prijemce
			_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $usableReceiverID, '$parsedMessageContent', $now, 0, $usableReceiverID, $usableGenHashValue)");
			//podruhe se ulozi kopie pro odesilatele
			_oxMod("INSERT INTO $TABLE_MAILBOX VALUES ($userid, $usableReceiverID, '$parsedMessageContent', $now, 0, $userid, $usableGenHashValue)");

			$receiverNoticeArray = _oxQuery("SELECT login, mobil, email, active FROM $TABLE_USERS WHERE userid='$usableReceiverID'");
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

	}


	//*********************************AKCE PREVIEW*****************************************
	//include('incl/preview_action.php');
	if (($preview == $LNG_PREVIEW || $refresh == 'aktualizovat') && ($db_passwd == $session_passwd)) {
		//akce preview je vyvolana, pokud obsahuje POST promenna preview prislusnou textovou hodnotu
		//akce preview pozaduje:
		//1. obsah zpravy ($formMessageContent)

		$viewing=1;

		//1. MessageContent
		//kontrola obsahu zpravy se provede pouze v plaintext editorech
		$uncheckedMessageContent = $_POST['formMessageContent'];

		if ($editor == 0 || $editor == 1) {
			$parsedMessageContent = replaceMessage($uncheckedMessageContent);
			$parsedMessageContent = stripslashes($parsedMessageContent);
		}else{
			$parsedMessageContent = stripslashes($uncheckedMessageContent);
		}

		if ($parsedMessageContent != "") {
			$usableMessage = true;
		}else{
			$usableMessage = false;
			//$_GET['note'] = 301;
		}

		//NAVIGACE
		//vedle stisku enter lze odeslat zmenenou hodnotu i pres nahled
		//proto i zde dochazi k vynulovani hodnot
		$frwdvalue= 0;
		$backvalue= 0;
		$startvalue= 0;
		$endvalue= 0;
	}

	//*********************************AKCE ZOBRAZIT PRISPEVKY OD JEDNOHO UZIVATELE*****************************************
	if ($fuser_show=="zobrazit" && $db_passwd == $session_passwd) {
		$isOneUser = 1;

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

	
      if ($fuserid!=null) {
	     $isOneUser = 1;
      }else{
	     $isOneUser = 0;
      }
      
      /* spatna verze, nefunguje na serveru!!!
      if (!isSet($fuserid)) {
		$isOneUser = 0;
	}else{
		$isOneUser = 1;
	}
	*/

	//*********************************AKCE SMAZAT*****************************************
	//sender obsahuje vzdy ID uzivatele, u ktereho se dana zprava
	//zobrazi
	//if (($del == "smazat označené" || $del == "smazat") && $db_passwd == $session_passwd) {
	if (isSet($delmsg) && $db_passwd == $session_passwd) {
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


	//*********************************NASTAVENI POSLEDNIHO ODESILATELE JAKO DEFAULTNIHO PRIJEMCE*****************************************
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


}
//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA P O S T A AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

























if ($module_number==11) {
	//USERINFO predpoklada existenci fuserid pro svuj chod, proto resim vzdy
	if ($_GET['fuserid']!=null) {
		$fuserid = checkUserId($_GET['fuserid']);
	}elseif ($_POST['fuserid']!=null){
		$fuserid = checkUserId($_POST['fuserid']);
	}elseif ($_POST['user_info']!=null){
		//pokud prislo jmeno, je treba naplnit jednak
		$fuserid=getUserId($_POST['user_info']);
	}

	//pokud neprislo platne fuserid nebo jmeno, bude fuseridem prihlaseny userid a zapisu error
	//toto bude platit pouze v nekterych pripadech dle hodnoty submodule_number
	if($fuserid == -1 || !isSet($fuserid)){
		//echo "menim fuserid";
		$fuserid = $userid;
		$_GET['note'] = 201;
	}
	
	
	if ($submodule_number==2) {
          	//prijem a zapis informaci do DB
          	$setdetails = $_POST['setdetails'];
          	$name = $_POST['name'];
          	$surname = $_POST['surname'];
          	$birth = $_POST['birth'];
          	$age = $_POST['age'];
          	$address = $_POST['address'];
          	$phone = $_POST['phone'];
          	$e_mail = $_POST['e_mail'];
          	$web = $_POST['web'];
          	$icq = $_POST['icq'];
          	$hobby = $_POST['hobby'];
          	$sex = $_POST['sex'];
          	$single = $_POST['single'];
          	$height = $_POST['height'];
          	$weight = $_POST['weight'];
          	$eyes = $_POST['eyes'];
          	$hair = $_POST['hair'];
                     
          	if ($setdetails == nastavit && $db_passwd == $session_passwd) {
          		_oxMod("UPDATE $TABLE_USERS SET name='$name', surname='$surname', birth='$birth', age='$age', address='$address', phone='$phone', e_mail='$e_mail', web='$web', icq='$icq', hobby='$hobby', sex='$sex', single='$single', height='$height', weight='$weight', eyes='$eyes', hair='$hair' WHERE userid=$userid");
          	      $_GET['note'] = 407;       
            }
                     
                     
          	//ziskani informaci z DB a jejich vypis
          	$userInfoArray = _oxQuery("SELECT login, name, surname, birth, age, address, phone, e_mail, web, icq, hobby, sex, single, height, weight, eyes, hair FROM $TABLE_USERS WHERE userid=$fuserid");
                     
          	$user_info_login = $userInfoArray["login"];
          	$user_info_name = $userInfoArray["name"];
          	$user_info_surname = $userInfoArray["surname"];
          	$user_info_birth = $userInfoArray["birth"];
          	$user_info_age = $userInfoArray["age"];
          	$user_info_address = $userInfoArray["address"];
          	$user_info_phone = $userInfoArray["phone"];
          	$user_info_email = $userInfoArray["e_mail"];
          	$user_info_web = $userInfoArray["web"];
          	$user_info_icq = $userInfoArray["icq"];
          	$user_info_hobby = $userInfoArray["hobby"];
          	$user_info_sex = $userInfoArray["sex"];
          	$user_info_single = $userInfoArray["single"];
          	$user_info_height = $userInfoArray["height"];
          	$user_info_weight = $userInfoArray["weight"];
          	$user_info_eyes = $userInfoArray["eyes"];
          	$user_info_hair = $userInfoArray["hair"];
                     
          	if ($user_info_name=="" && $user_info_surname=="" && $user_info_birth=="" && $user_info_age=="" && $user_info_address=="" && $user_info_phone=="" && $user_info_email=="" && $user_info_web=="" && $user_info_icq=="" && $user_info_hobby=="" && $user_info_sex=="" && $user_info_single=="" && $user_info_height=="" && $user_info_weight=="" && $user_info_eyes=="" && $user_info_hair=="") {
          		$detail_info = 0;
          	}else{
          		$detail_info = 1;
          	}
      }
	
	
	

}




if ($module_number==7) {

	if ($_GET['fuserid']!=null) {
		$fuserid = checkUserId($_GET['fuserid']);
	}elseif ($_POST['fuserid']!=null){
		$fuserid = checkUserId($_POST['fuserid']);
	}elseif ($_POST['fusername']!=null){
		//pokud prislo jmeno, je treba naplnit jednak
		$fuserid=getUserId($_POST['fusername']);
	}

	//pokud neprislo platne fuserid nebo jmeno, bude fuseridem prihlaseny userid a zapisu error
	if($fuserid == -1){
		$fuserid = $userid;
		$_GET['note'] = 201;
	}

	if(isSet($_POST['fuser_show']) && $_POST['fusername']==null){
		$fuserid = $userid;
		$_GET['note'] = 201;
	}

}





//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA S E T T I N G S AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
if ($module_number==5) {

	//*********************************PROMENNE*****************************************
	$changepasswd = $_POST['changepasswd'];
	$currentpasswd = $_POST['currentpasswd'];
	$newpasswd = $_POST['newpasswd'];
	$newpasswdretype = $_POST['newpasswdretype'];

	$upload = $_POST['upload'];
	$userfile_size = $HTTP_POST_FILES['userfile']['size'];
	$userfile_type = $HTTP_POST_FILES['userfile']['type'];
	$userfile = $HTTP_POST_FILES['userfile']['tmp_name'];
	$wrong_size = $_POST['wrong_size'];
	//echo $userfile_size;
	//echo $userfile_type;
	//echo $userfile;

	$setlang = $_POST['setlang'];
	$lang_select = $_POST['lang_select'];

	$setstatus = $_POST['setstatus'];
	$custom_status = $_POST['custom_status'];
	
	$setdefskin = $_POST['setdefskin'];
      $skin_select = $_POST['skin_select'];



	//*********************************AKCE NAHRAT IKONKU*****************************************
	if ($upload == nahrát && $db_passwd == $session_passwd) {
		if($userfile_size <= $ICON_MAX_SIZE) {
						
                  if(($userfile_type == "image/gif") || ($userfile_type == "image/pjpeg") || ($userfile_type == "image/jpeg") || ($userfile_type == "image/x-png") || ($userfile_type == "image/png")) {
				if (is_uploaded_file($userfile)) {
                              copy($userfile, "ico/$login.gif");
                              $_GET['note'] = 408;
                        }      
                  }else{
				$_GET['note'] = 403;
			}
		}else{
			$_GET['note'] = 404;
		}

	}


	//*********************************AKCE ZMENIT HESLO*****************************************
	if ($changepasswd == změnit && $db_passwd == $session_passwd) {
		//get current password form database
		$passwordArray=_oxQuery("SELECT password FROM $TABLE_USERS WHERE userid=$userid");
		$passwd = $passwordArray["password"];

		$currentpasswd=substr(md5($currentpasswd), 0, 32);

		if ($currentpasswd == $passwd && $newpasswd == $newpasswdretype) {
			$newpasswd=md5($newpasswd);
			_oxMod("UPDATE $TABLE_USERS SET password='$newpasswd' WHERE userid='$userid'");
			$_SESSION['password'] = $newpasswd; //write new password into actual session
			$_GET['note'] = 401;
		}else{
			$_GET['note'] = 402;
		}
	}

	//*********************************AKCE ZMENIT JAZYK*****************************************
	if ($setlang == změnit && $db_passwd == $session_passwd) {
		_oxMod("UPDATE $TABLE_USERS SET user_lang='$lang_select' WHERE userid=$userid");

		//set new language immediately, otherwise change will take effect after page reload
		require('lang/'.$lang_select.'.php');
		$_GET['note'] = 405;
	}

	//*********************************AKCE ZMENIT STATUS*****************************************
	if ($setstatus == nastavit && $db_passwd == $session_passwd) {
		_oxMod("UPDATE $TABLE_USERS SET status='$custom_status' WHERE userid=$userid");
		$status = $custom_status;
		$_GET['note'] = 406;
	}
	
	//*********************************AKCE ZMENIT SKIN*****************************************
	if ($setdefskin == změnit && $skin_select !="" && $db_passwd == $session_passwd) {
	     _oxMod("UPDATE $TABLE_USERS SET css='$skin_select' WHERE userid='$userid'");
	     $css = $skin_select;
	     $_GET['note'] = 409;
      }

}
//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA S E T T I N G S AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA































//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA D I S K U Z E AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
if ($module_number==10) {
	
	//na zacatku je treba zjistit, zda vstupujeme do jiz existujici mistnosti
	$roomid = $_POST['roomid'];
	$create_room = $_POST['create_room'];

	if (!IsSet($roomid) || is_nan($roomid)) {
		$roomid = $_GET['roomid'];


		if (!IsSet($create_room)) {
			@$check_result=_oxResult("SELECT roomid FROM $TABLE_ROOMS WHERE roomid='$roomid'");
			//pokud neexistuje roomid, vypsat upozornění a ukončit provádění skriptu
			if (mysql_num_rows($check_result)==0) {
				//session_destroy();
				?>
				Požadovaná diskuze neexistuje!
				<?
				//header("location: logout.php?userid=$userid");
				exit();
			}
		}
	}
	
	//echo "roomid: ".$roomid;

	if ($_GET['fuserid']!=null) {
		$fuserid = checkUserId($_GET['fuserid']);
	}elseif ($_POST['fuserid']!=null){
		$fuserid = checkUserId($_POST['fuserid']);
	}elseif ($_POST['fusername']!=null){
		//pokud prislo jmeno, je treba naplnit jednak
		$fuserid=getUserId($_POST['fusername']);
	}
	
	//echo "FUSERID v header.php:".$fuserid."<br />";

	//pokud neprislo platne fuserid nebo jmeno, bude fuseridem prihlaseny userid a zapisu error
	if($fuserid == -1){
		$fuserid = $userid;
		$_GET['note'] = 201;
	}

	if(isSet($_POST['fuser_show']) && $_POST['fusername']==null){
		$fuserid = $userid;
		$_GET['note'] = 201;
	}
      
      //*********************************AKCE CREATE***************************************
      if ($create_room == $LNG_DISCUSSION_CREATE && $db_passwd == $session_passwd) {
      
                  //naplneni promennych
              $cr_roomname = $_POST['cr_roomname'];
	            $cr_new_password = $_POST['cr_new_password'];
	            $cr_new_password2 = $_POST['cr_new_password2'];
	            $cr_delown = $_POST['cr_delown'];
	            $cr_allowrite = $_POST['cr_allowrite'];
	            $cr_private = $_POST['cr_private'];
	            $create_category_select = $_POST['create_category_select'];
	            $create_subcategory_select = $_POST['create_subcategory_select'];
              $cr_homecontent_source = $_POST['cr_homecontent'];
	            $cr_minihomecontent_source = $_POST['cr_minihomecontent'];
                  
                  
                  if ($create_subcategory_select==null) {
                        $create_subcategory_select=0;
                  }
                  
	            $cr_homecontent_parsed = replaceMessage($cr_homecontent_source);
	            $cr_homecontent_parsed = addslashes($cr_homecontent_parsed);
	            $cr_minihomecontent_parsed = replaceMessage($cr_minihomecontent_source);
	            $cr_minihomecontent_parsed = addslashes($cr_minihomecontent_parsed);
                  
	            $cr_keepers = $_POST['cr_keepers'];
	            $cr_deniers = $_POST['cr_deniers'];
	            $cr_banned_writers = $_POST['cr_banned_writers'];
	            $cr_question = $_POST['cr_question'];
	            $cr_answ01 = $_POST['cr_answ01'];
	            $cr_answ02 = $_POST['cr_answ02'];
	            $cr_answ03 = $_POST['cr_answ03'];
	            $cr_answ04 = $_POST['cr_answ04'];
	            $cr_answ05 = $_POST['cr_answ05'];
	            $cr_answ06 = $_POST['cr_answ06'];
	            $cr_answ07 = $_POST['cr_answ07'];
	            $cr_answ08 = $_POST['cr_answ08'];
	            $cr_answ09 = $_POST['cr_answ09'];
	                 
	                 
                  //tvorba diskuze
	            $now=time()+$SUMMER_TIME;
	            if ($cr_delown) {$cr_delown_db=1;}else{$cr_delown_db=0;}
	            if ($cr_allowrite) {$cr_allowrite_db=1;}else{$cr_allowrite_db=0;}
	            if ($cr_private) {$cr_private_db=1;}else{$cr_private_db=0;}
                  
	            if ($cr_roomname == "") {
	            	$cr_roomname = "Bez názvu";
	            }    
                  
	            if ($cr_new_password != $cr_new_password2) {
	            	$cr_new_password = "";
	            }    
                  
                  //_oxMod("INSERT INTO talker2_rooms VALUES ('LAST_INSERT_ID()', 'ZZZZZZZ', '', '0', '1', '5555', '1', '1', '', '', '', '', '1', '1', '0', '5555', '', '1')");
	            _oxMod("INSERT INTO $TABLE_ROOMS VALUES (LAST_INSERT_ID(), '$cr_roomname', '$cr_new_password', 0, $userid, $now, $create_category_select, $create_subcategory_select, '$cr_homecontent_parsed', '$cr_homecontent_source', '$cr_minihomecontent_parsed', '$cr_minihomecontent_source', $cr_delown_db, $cr_allowrite_db, $cr_private_db, $now, '', 1)");
                  //_oxMod("INSERT INTO $TABLE_ROOMS VALUES (LAST_INSERT_ID(), '$cr_roomname', '$cr_new_password', 0, '$userid', '$now', '$create_category_select', '$create_subcategory_select', '$cr_homecontent_parsed', '$cr_homecontent_source', '$cr_minihomecontent_parsed', '$cr_minihomecontent_source', '$cr_delown_db', '$cr_allowrite_db', '$cr_private_db', '$now', '', 1)");
	            //zjistim si posledni id klubu
	            $roomid_result=_oxResult("SELECT MAX(roomid) AS roomid FROM $TABLE_ROOMS");
	            $roomid_record=mysql_fetch_array($roomid_result);
	            $roomid=$roomid_record["roomid"];
                  
              
              // AUDITOR - vyuziva se pro tvorbe spravcu, atp.
              $result_auditor = _oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
	            $record_auditor =mysql_fetch_array($result_auditor);
	            $auditor=$record_auditor["founderid"];
              
              //KEEPERS - tvorba spravcu
	            $keepers_arr = split(",", $cr_keepers);
	            $keepers_num = Count($keepers_arr);
                  
	            for ($i=0; $i<=$keepers_num-1; $i++) {
	            	$keepers_arr[$i]=trim($keepers_arr[$i]);
	            	$keeper_name=$keepers_arr[$i];
	            	
                //tady to vypada, ze neexistuje result, protoze to vraci chybu nasledujiciho radku, ze nemuze provest mysql_num_rows
                $keepers_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$keeper_name' AND userid!=$auditor");
	            	if (mysql_num_rows($keepers_result) != 0) {
	            		$keepers_record=mysql_fetch_array($keepers_result);
	            		$keeper_id[$i] = $keepers_record["userid"];
	            	}   
	            }    
                  
	            $keepers_num = Count($keeper_id);
	            for ($i=0; $i<=$keepers_num-1; $i++) {
	            	_oxMod("INSERT INTO $TABLE_ROOM_KEEPERS VALUES($roomid, $keeper_id[$i])");
	            }    
                  
                  
                  
	            //DENIERS - tvorba zakazu
	            $deniers_arr = split(",", $cr_deniers);
	            $deniers_num = Count($deniers_arr);
                  
	            for ($i=0; $i<=$deniers_num-1; $i++) {
	            	$deniers_arr[$i]=trim($deniers_arr[$i]);
	            	$denier_name=$deniers_arr[$i];
	            	$deniers_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$denier_name' AND userid!=$auditor");
	            	if (mysql_num_rows($deniers_result) != 0) {
	            		$deniers_record=mysql_fetch_array($deniers_result);
	            		$denier_id[$i] = $deniers_record["userid"];
	            	}   
	            }    
                  
	            $deniers_num = Count($denier_id);
	            for ($i=0; $i<=$deniers_num-1; $i++) {
	            	_oxMod("INSERT INTO $TABLE_ROOM_DENIERS VALUES($roomid, $denier_id[$i])");
	            }    
                  
                  
                  
	            //BANNED_WRITERS - tvorba zabanovanych
	            $banned_writers_arr = split(",", $cr_banned_writers);
	            $banned_writers_num = Count($banned_writers_arr);
                  
	            for ($i=0; $i<=$banned_writers_num-1; $i++) {
	            	$banned_writers_arr[$i]=trim($banned_writers_arr[$i]);
	            	$banned_writer_name=$banned_writers_arr[$i];
	            	$banned_writers_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$banned_writer_name' AND userid!=$auditor");
	            	if (mysql_num_rows($banned_writers_result) != 0) {
	            		$banned_writers_record=mysql_fetch_array($banned_writers_result);
	            		$banned_writer_id[$i] = $banned_writers_record["userid"];
	            	}   
	            }    
                  
	            $banned_writers_num = Count($banned_writer_id);
	            for ($i=0; $i<=$banned_writers_num-1; $i++) {
	            	_oxMod("INSERT INTO $TABLE_ROOM_BANNED_WRITERS VALUES($roomid, $banned_writer_id[$i])");
	            }    
                  
             	//BOOKMARK - prida diskuzi do seznamu sledovanych diskuzi vlastnika
	            _oxMod("INSERT INTO $TABLE_ROOMS_BOOKMARKS VALUES ($userid, $roomid)");
                  
                  
                                   
	            //POOL - ze zadanych odpovedi do ankety vytvori pole
	            $cr_pool_data = Array($cr_answ01, $cr_answ02, $cr_answ03, $cr_answ04, $cr_answ05, $cr_answ06, $cr_answ07, $cr_answ08, $cr_answ09);
                  
	            //pole slouci v textovou promennou odpovedi
	            for ($i=0; $i<=8; $i++) {
	            	if ($cr_pool_data[$i] != "") {
	            		$cr_count++;
	            		$cr_answ_text = $cr_answ_text.$cr_pool_data[$i]."#";
	            	}   
	            }    
                  
	            //pokud neni otazka ani textova promenna odpovedi prazdne, vytvori anketu
	            if ($cr_question !="" && $cr_answ_text !="") {
                  
                  
	            	if ($anonym) {
	            		_oxMod("INSERT INTO $TABLE_POOLS VALUES('', $roomid, '$cr_question', '', '', '', '', '', '', '', '', '', $cr_count, '$cr_answ_text', 0,'',0)");
	            	}else{
	            		_oxMod("INSERT INTO $TABLE_POOLS VALUES('', $roomid, '$cr_question', '', '', '', '', '', '', '', '', '', $cr_count, '$cr_answ_text', 0,'',1)");
	            	}   
	            }    
                  
                  
      
      
      
      }
      
      
      // NASTAVENI DISKUZE
      if ($submodule_number==1) {
             //********************************PROMENNE************************************************
             $changename = $_POST['changename']; 
            
            
            //*********************************AKCE ZMENIT NAZEV***************************************
            if ($changename == změnit && $db_passwd == $session_passwd) {
              echo "změna jména diskuze je zatím nefunkční";
            }
      
      }
      
      
      
      
  //*********************************ZAKLADNI NASTAVENI*****************************************
	$result_auditor = _oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
	$record_auditor =mysql_fetch_array($result_auditor);
	$auditor=$record_auditor["founderid"];
      
      //musime zjistit, jaky je pouzity editor
	      
      //zjistime, zda je diskuze sledovana a podle toho nastavime volbu
      $result3 = _oxResult("SELECT FK_user FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
      $record3 = mysql_fetch_array($result3);
      if ($record3 != "") {
          	$bookvalue="nesledovat";
      }else{
           	$bookvalue="sledovat";
      }
         
      
	


	//*********************************PROMENNE*****************************************
	$anonym = $_POST['anonym'];
	$pool_id = $_POST['pool_id'];
	$destroy_pool = $_POST['destroy_pool'];

	$send = $_POST['send'];
	$preview = $_POST['preview'];
	//mazani skupiny oznacenych prispevku
	$del = $_POST['del'];
	$delmsg = $_POST['delmsg'];
	//echo "delmsg: ".$delmsg."<br>";

	//mazani jednotneho prispevku
	$dele = $_POST['dele'];
	$del_id = $_POST['del_id'];

	//echo $dele;
	//echo $del_id;


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

	$changeowner = $_POST['changeowner'];
	$newownername = $_POST['newownername'];

	$changehome = $_POST['changehome'];
	$homecontent_source = $_POST['homecontent'];
	$changeminihome = $_POST['changeminihome'];
	$minihomecontent_source = $_POST['minihomecontent'];

	$homecontent_parsed = replaceMessage($homecontent_source);
	$homecontent_parsed = addslashes($homecontent_parsed);
	$minihomecontent_parsed = replaceMessage($minihomecontent_source);
	$minihomecontent_parsed = addslashes($minihomecontent_parsed);

	$seticon = $_POST['seticon'];
	$icon = $_POST['icon'];

	$setkeepers = $_POST['setkeepers'];
	$keepers = $_POST['keepers'];

	$setdeniers = $_POST['setdeniers'];
	$deniers = $_POST['deniers'];

	$set_banned_writers = $_POST['set_banned_writers'];
	$banned_writers = $_POST['banned_writers'];

	$change_cat = $_POST['change_cat'];
	$change_category_select = $_POST['change_category_select'];

	$changename = $_POST['changename'];
	$newroomname = $_POST['newroomname'];
	$private = $_POST['private'];

	$changeallows = $_POST['changeallows'];
	$delown = $_POST['delown'];
	$allowrite = $_POST['allowrite'];

	$book = $_GET['book'];

	$fuser_show = $_POST['fuser_show'];

	$discussionFormPassword = $_POST['check_password'];

	$set_password = $_POST['set_password'];
	$current_password = $_POST['current_password'];
	$new_password = $_POST['new_password'];
	$new_password2 = $_POST['new_password2'];

      
      //*********************************AKCE SEND*****************************************
	if ($send == $LNG_SEND && $db_passwd == $session_passwd) {
		            
            //akce send je vyvolana, pokud obsahuje POST promenna send prislusnou textovou hodnotu
		//akce send pozaduje:
		//1. obsah zpravy ($formMessageContent)
		//2. kod pro zamezeni opetovneho odeslani pri refreshi stranky ($formGenHashValue)

		//1. MessageContent
		//kontrola obsahu zpravy se provede pouze v plaintext editorech
		$uncheckedMessageContent = $_POST['formMessageContent'];
				
		if ($editor == 0 || $editor == 1) {
			$parsedMessageContent = replaceMessage($uncheckedMessageContent);
			$parsedMessageContent = addslashes($parsedMessageContent);
		}else{
			$parsedMessageContent = $uncheckedMessageContent;
		}

		if ($parsedMessageContent != "") {
			$usableMessage = true;
		}else{
			$usableMessage = false;
			$_GET['note'] = 301;
		}

		//2. GenHashValue
		//unikatni kod, ktery zamezuje nekolikanasobnemu odeslani zpravy pri stisku F5 (refreshi stranky)
		//vzhledem k tomu, ze uzivatel nema moznost hodnotu nijak ovlivnit, neprovadi se test validity
		$usableGenHashValue = $_POST['formGenHashValue'];
		$isAlreadySentArray = _oxQuery("SELECT fromid FROM $TABLE_ROOM WHERE fromid=$userid AND roomid=$roomid AND genhash=$usableGenHashValue");

		if ($isAlreadySentArray['fromid'] == "") {
			$usableGenHash = true;
		}else{
			$usableGenHash = false;
			$_GET['note'] = 302;
		}


		if ($usableMessage && $usableGenHash) {
			$now = time()+$SUMMER_TIME;
			//echo $usableGenHashValue."<br>";
			//echo $roomid."<br>";
			//echo $parsedMessageContent."<br>";
			//echo $userid."<br>";
			//echo $now."<br>";

			_oxMod("INSERT INTO $TABLE_ROOM VALUES (LAST_INSERT_ID(), $roomid, $userid, '$parsedMessageContent', $now, $usableGenHashValue)");
			_oxMod("UPDATE $TABLE_ROOMS SET count=count+1 WHERE roomid=$roomid");
			_oxMod("UPDATE $TABLE_ROOMS SET last=$now WHERE roomid=$roomid");
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

	//*********************************AKCE PREVIEW*****************************************
	//include('incl/preview_action.php');
	if (($preview == $LNG_PREVIEW || $refresh == 'aktualizovat') && ($db_passwd == $session_passwd)) {
		//akce preview je vyvolana, pokud obsahuje POST promenna preview prislusnou textovou hodnotu
		//akce preview pozaduje:
		//1. obsah zpravy ($formMessageContent)

		$viewing=1;

		//1. MessageContent
		//kontrola obsahu zpravy se provede pouze v plaintext editorech
		$uncheckedMessageContent = $_POST['formMessageContent'];

		if ($editor == 0 || $editor == 1) {
			$parsedMessageContent = replaceMessage($uncheckedMessageContent);
			$parsedMessageContent = stripslashes($parsedMessageContent);
		}else{
			$parsedMessageContent = stripslashes($uncheckedMessageContent);
		}

		if ($parsedMessageContent != "") {
			$usableMessage = true;
		}else{
			$usableMessage = false;
			//$_GET['note'] = 301;
		}

		//NAVIGACE
		//vedle stisku enter lze odeslat zmenenou hodnotu i pres nahled
		//proto i zde dochazi k vynulovani hodnot
		$frwdvalue= 0;
		$backvalue= 0;
		$startvalue= 0;
		$endvalue= 0;
	}



	//pokud neni uzivatel v rezimu neviditelny, nastavi se mu aktualni pozice
	//bylo by vhodnejsi ukladat pouze ciselny kod modulu, ktery by se potom v ramci modulu UZIVATELE interpretoval
	//do textove formy
	//pokud se jedna o diskuzi, je treba rozlisit, zda jde o privatni ci nikoliv
	//pokud se jedna o informace o uzivateli, pak doplnit jmeno uzivatele
	if ($invisible != 1) {
	     /* TOHLE ZAPNOUT, KDYBY TO DOLE NESLO 
           $privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
		$is_private = $privateArray["private"];
		if ($is_private == 0) {
			//pokud neni diskuze privatni, pak do location ulozi cislo diskuze a zaroven zapise, ze se jedna
			//o cislo dikuze, nikoliv o cislo modulu
			//echo "diskuze neni privatni";
			_oxMod("UPDATE $TABLE_USERS SET location='$roomid' WHERE userid='$userid'");
		}else{
			//echo "diskuze je privatni";
			_oxMod("UPDATE $TABLE_USERS SET location='$module_name' WHERE userid='$userid'");
		}
            */	
	}
	
	
	
	//*********************************AKCE BOOKMARK*****************************************
      if($book == sledovat && $db_passwd == $session_passwd) {

	     //nejdriv zkontroluje zda uz neni dana diskuze zabookovana - muze se stat stisknutim
	     //F5, ze bude bookovat dvakrat to same
	     $isAlreadyBookedArray = _oxQuery("SELECT FK_user FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
	     if ($isAlreadyBookedArray['userid'] == "") {
	           	$now=time()+$SUMMER_TIME;
		    //PREDELAT
		    _oxMod("INSERT INTO $TABLE_ROOMS_BOOKMARKS VALUES ($userid, $roomid)");
		    _oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count+1 WHERE roomid=$roomid");
	     }
      }


      if($book == nesledovat && $db_passwd == $session_passwd) {
	     _oxMod("DELETE FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
	     _oxMod("UPDATE $TABLE_ROOMS SET book_count=book_count-1 WHERE roomid=$roomid");
      }
      
      //zjistime, zda je diskuze sledovana a podle toho nastavime volbu
      $result3 = _oxResult("SELECT FK_user FROM $TABLE_ROOMS_BOOKMARKS WHERE FK_user=$userid AND FK_room=$roomid");
      $record3 = mysql_fetch_array($result3);
      if ($record3 != "") {
         	$bookvalue="nesledovat";
      }else{
           	$bookvalue="sledovat";
      }
     
      
      
      



}
//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA D I S K U Z E AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA





//com18
//hodnoty polozek hlavniho menu a submenu vyuzijeme k nastaveni
//kaskadnich stylu pro oba typy menu
_oxSetMainMenuCSS($module_number);
_oxSetSubMenuCSS($submodule_number);


//zde se pro ucely titulku stranky naplni promenna nazvem modulu podle cisla modulu
if ($module_number==1) {
	$module_name=$LNG_MAIN_MENU_SYSTEM;
}
if ($module_number==2) {
	$module_name=$LNG_MAIN_MENU_MAILBOX;
}
if ($module_number==3) {
	$module_name=$LNG_MAIN_MENU_TOPICS;
}
if ($module_number==4) {
	$module_name=$LNG_MAIN_MENU_USERS;
}
if ($module_number==5) {
	$module_name=$LNG_MAIN_MENU_SETTINGS;
}
if ($module_number==6) {
	$module_name=$LNG_MAIN_MENU_BOOKMARKS;
}
if ($module_number==7) {
	$module_name=$LNG_MAIN_MENU_LIVE;
}
if ($module_number==8) {
	$module_name=$LNG_MAIN_MENU_HELP;
}
if ($module_number==10) {
	$module_name=$LNG_MAIN_MENU_DISCUSSION;
}
if ($module_number==11) {
	$module_name=$LNG_MAIN_MENU_USER;
}










//pokud neni uzivatel v rezimu neviditelny, nastavi se mu aktualni pozice
//bylo by vhodnejsi ukladat pouze ciselny kod modulu, ktery by se potom v ramci modulu UZIVATELE interpretoval
//do textove formy

//pokud se jedna o diskuzi, je treba rozlisit, zda jde o privatni ci nikoliv
//pokud se jedna o informace o uzivateli, pak doplnit jmeno uzivatele

if ($invisible != 1) {
	if ($module_number==4){ //uzivatele
		//$sess_out = updatelastaction($userid, "sekci INFORMACE O UŽIVATELI ".$infologin);
		_oxMod("UPDATE $TABLE_USERS SET location='$module_name' WHERE userid='$userid'");
	
      
      
      }elseif($module_number==10) { //diskuze
	               
           
           //tenhle if tu musi byt, prestoze je prazdny! diky nemu to funguje, ted nemam naladu resit proc, hlavne ze jo!
	     // TOHLE VYPNOUT, KDYBY TO NESLO a ZAPNOUT NAHORE
           $privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
		$is_private = $privateArray["private"];
		if ($is_private == 0) {
			//pokud neni diskuze privatni, pak do location ulozi cislo diskuze a zaroven zapise, ze se jedna
			//o cislo dikuze, nikoliv o cislo modulu
			//echo "diskuze neni privatni";
			_oxMod("UPDATE $TABLE_USERS SET location='$roomid' WHERE userid='$userid'");
		}else{
			//echo "diskuze je privatni";
			_oxMod("UPDATE $TABLE_USERS SET location='$module_name' WHERE userid='$userid'");
		}
      
      
      
      }else{	
            _oxMod("UPDATE $TABLE_USERS SET location='$module_name' WHERE userid='$userid'");
	}
}








//$sess_out = updatelastaction($userid);

updatelastaction($userid);

//get note message
//it has to be exactly here, otherwise it wont catch notes under it...
$note = $_GET['note'];
$note_text = _oxNoter($note);






?>
