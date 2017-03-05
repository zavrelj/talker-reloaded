<?
require('db.inc.php');
//require('lang/en.php');
//----------------------------SYNTAX DEFINITION-----------------------------------------
/*
formulare posilat zasadne metodou POST!

form_nazevFormulare
form_nazevFormulare_typprvku_popisPrvku

typy prvku:
text - input text formular
pswd - input password formular
chck - input checkbox formular
rdio - input radio formular
slct - select formular
optn - option formular
sbmt - input submit formular
form - jmeno formulare
area - textarea formular
hidn - input hidden formular

poradi atributu formu: name, method, action
poradi atributu prvku: name, type, value

pole ...Array nazývat podle podmínky výběru, nebo podle vybírané hodnoty

syntax outside promennych (databaze, formular, session):
$slovo_slovo_slovo

syntax inside promennych (PHP skript):
$formSlovoSlovoSlovo - pokud byla naplnena formularovou hodnotou
$urlSlovoSlovoSlovo - pokud byla naplnena hodnotou z adresniho radku (metodou GET)
$dbaseSlovoSlovoSlovo - pokud byla naplnena databazovou hodnotou
$sessSlovoSlovoSlovo - pokud byla naplnena session hodnotou
$scrptSlovoSlovoSlovo - pokud vznikla vystupem z funkce

syntax promennych uvnitr funkce:
$_slovoSlovoSlovo

syntax inside konstant (PHP skript):
SLOVO_SLOVO_SLOVO

syntax user-defined funkci:
_oxSlovoSlovo - pokud neni funkce soucasti PHP, byla definovana uzivatelsky

*/

//----------------------------BLOK NASTAVENI KONSTANT--------------------------------

//doba po ktere dojde k automatickemu odhlaseni ze sytemu
//autologout zajistuje pripadne cron demon na serveru
$AUTOLOGOUT_TIME=1200;


/* tables names */
$TABLE_ROOMS="ds_rooms";
$TABLE_ROOMS_ACCESS="ds_rooms_access";
$TABLE_ROOMS_BOOKMARKS="ds_rooms_bookmarks";

$TABLE_ROOM="ds_room";
$TABLE_ROOM_VIEWERS="ds_room_viewers";
$TABLE_ROOM_DENIERS="ds_room_deniers";
$TABLE_ROOM_KEEPERS="ds_room_keepers";
$TABLE_ROOM_BANNED_WRITERS="ds_room_banned_writers";

$TABLE_FRIENDS="ds_friends";
$TABLE_MAILBOX="ds_mailbox";
$TABLE_POOLS="ds_pools";
$TABLE_USERS="ds_users";
$TABLE_STATS="ds_stats";
$TABLE_LOGS="ds_logs";
$TABLE_TOPICS="ds_topics";
$TABLE_SUBTOPICS="ds_subtopics";

//server name
$SERVER_NAME="localhost";

//nazev vasi mutace ds (zobrazi se v title)
$TITLE_NAME="DS";

//implicitni jazyk, pouzity zejmena na index.php, nebo obecne pred prihlasenim uzivatele
$DEFAULT_LANG="cz";

//nastavuje parametry obrazku velikost je v bytech
$IMG_MAX_SIZE=1000000;
$IMG_MAX_WIDTH=700;
$IMG_MAX_HEIGHT=700;

//nastavuje parametry ikonky
$ICON_MAX_SIZE=5120; //5kb

//nastavuje kolik se nahrava obrazku k jedne polozce - je treba vytvorit prislusny pocet
//formularovych prvku rucne !!
//pocitame od nuly !!!
$FILE_UPLOADED=5;

//nastavuje pocet zachovavanych prihlaseni uzivatele do systemu
$USER_LOGS = 10;

//nastavuje pocet znaku z nazvu posledni lokace uzivatele, ktere se maji zobrazit
$LOCATION_LENGTH = 30;

/* global variables */
$SUMMER_TIME = 0; //pridat k aktualnimu casu na serveru 3600s v obdobi zimy

//nastavuje dobu, ktera musi uplynout mezi jednotlivymi impresemi v systemu, aby byl zapocitan AT
$AT_DELAY = 10;

//nastavuje pocet vypisovanych udaju ve statistikach
$STAT_ROWS = 10;













/* *************************************function for LEVELS**************************************** */
function _oxShowLevel($user_level){

	switch ($user_level) {
	     case 0:
	     $img="lvl0.gif";
	     break;
	     case 1:
       $img="lvl1.gif";
	     break;
       case 2:
	     $img="lvl2.gif";
	     break;
	     case 3:
	     $img="lvl3.gif";
	     break;
	     case 4:
	     $img="lvl4.gif";
	     break;
	     case 5:
	     $img="lvl5.gif";
	     break;
	}		
      
      return $img;
}
/* *************************************function for LEVELS**************************************** */





/* *************************************function for ATbars**************************************** */
//this function is DEPRECATED!!!!
function _oxShowAT($currentAT){

	if ($currentAT > -1 & $currentAT <= 1000) {
		$img="at0.png";
	}else{
	if ($currentAT > 1000 & $currentAT <= 2000) {
		$img="at1.png";
	}else{
	if ($currentAT > 2000) {
		$img="at2.png";
	}
	}
	}

	return $img;
}
/* *************************************function for ATbars**************************************** */









//----------------------------BLOK DEFINIC FUNKCI--------------------------------


//----LVL0----
//funkce, ktere pro svuj chod nevyuzivaji jine uzivatelske funkce


//***writeErrLog*** - zapisuje chybu do /log/error.log
function _oxWriteErrorLog($message) {
	$string=date("d.m.Y H:i:s", time())." | ".$message."\n";
	$filename = "log/error.log";
	$fp = fopen ($filename, "a");
	$content = fwrite ($fp, $string);
	fclose ($fp);
}

//BALICEK FUNKCI CHECKINPUT - kontrola vstupu od uzivatele


function checkInputText($input) {
	//odstrani veskere html tagy
	$input = strip_tags($input);

	return $input;
}

function checkInputNumber($input) {
	//odstrani veskere html tagy
	$input = strip_tags($input);
	if(!is_numeric($input)) {
		$input = 0;
	}

	return $input;
}


//***checkInputLogin*** - funkce overuje, zda bylo do prihlasovaciho formulare zadano 3-20 znaku angl. abecedy vcetne mozneho podtrzitka a cislic
function _oxCheckInputLogin($form_username, $form_password) {
	if (ereg("^[a-zA-Z0-9_]{3,20}$", $form_username) && ereg("^[a-zA-Z0-9_]{3,20}$", $form_password)) {
		return true;
	}else{
		return false;
	}

}

function _oxCheckInputMail() {
}

function _oxCheckInputImg() {
}

function _oxCheckInputHref() {
}





//----LVL0----

















//----LVL1----
//funkce, ktere pro svuj chod vyuzivaji uzivatelske funkce LVL0


//***myQuery*** - funkce pro zpracovani dotazu do DB
function _oxQuery($query) {
	global $scrptSQLConnection;

	//@ potlaci zobrazeni chyboveho hlaseni
	@$result = mysql_query($query, $scrptSQLConnection);

	//pokud neprijde vysledek, vypise chybove hlaseni do logu a presmeruje na bezpecnou stranku a vypise upozorneni
	if(!$result) {
		_oxWriteErrorLog(sprintf("internal error %d:%s\n ", mysql_errno(), mysql_error())); //sprintf vraci retezec jako hodnotu funkce
		header("Location: error.php?err_no=101");
		exit();
	}

	//sada vysledku je vracena vzdy!, proto je treba kontrolovat jeji obsah - pocet vracenych zaznamu
	if(mysql_num_rows($result)==0) {
		$record = 0;
	}else{
		$record = mysql_fetch_array($result);
	}

	return $record;


}

//***myResult*** - funkce pro vraceni resultu
function _oxResult($query) {
	global $scrptSQLConnection;
	//@ potlaci zobrazeni chyboveho hlaseni
	$result = mysql_query($query, $scrptSQLConnection);

	//pokud neprijde vysledek, vypise chybove hlaseni do logu a presmeruje na bezpecnou stranku a vypise upozorneni
	/*
      if(!$result) {
		_oxWriteErrorLog(sprintf("internal error %d:%s\n ", mysql_errno(), mysql_error())); //sprintf vraci retezec jako hodnotu funkce
		header("Location: error.php?err_no=101");
		exit();
	}
	*/

	return $result;

}

//***myMod*** - funkce pro zpracovani modifikace DB
function _oxMod($query) {
	global $scrptSQLConnection;

	//@ potlaci zobrazeni chyboveho hlaseni
	$result = mysql_query($query, $scrptSQLConnection);
	//pokud neprijde vysledek, vypise chybove hlaseni do logu a presmeruje na bezpecnou stranku a vypise upozorneni
	
      /*
      if(!$result) {
		_oxWriteErrorLog(sprintf("internal error %d:%s\n ", mysql_errno(), mysql_error())); //sprintf vraci retezec jako hodnotu funkce
		header("Location: error.php?err_no=101");
		exit();
	}
	*/
	

}


//----LVL1----

















































//----LVL2----











function getUserLogin($input) {
	global $TABLE_USERS;
	$input = checkInputNumber($input);
	$userLoginArray = _oxQuery("SELECT login FROM $TABLE_USERS WHERE userid='$input'");
	if ($userLoginArray != 0 && $userLoginArray["login"] != "") {
		$userLogin = $userLoginArray["login"];
	}else{
		$userLogin = -1;
	}

	return $userLogin;
}



function checkUserLogin($input) {
	global $TABLE_USERS;
	$input = checkInputText($input);
	$userLoginArray = _oxQuery("SELECT login FROM $TABLE_USERS WHERE login='$input'");
	if ($userLoginArray != 0 && $userLoginArray["login"] != "") {
		$userLogin = $userLoginArray["login"];
	}else{
		$userLogin = -1;
	}

	return $userLogin;
}

function checkUserId($input) {
	global $TABLE_USERS;
	$input = checkInputNumber($input);
	$userIdArray = _oxQuery("SELECT userid FROM $TABLE_USERS WHERE userid='$input'");
	if ($userIdArray != 0 && $userIdArray["userid"] != "") {
		$userId = $userIdArray["userid"];
	}else{
		$userId = -1;
	}

	return $userId;
}




function getUserAT($userid) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	$result = _oxResult("SELECT AT FROM $TABLE_USERS WHERE userid='$userid'");
	$record = mysql_fetch_array($result);
	$AT = $record["AT"];
	return $AT;
}




function getUserLevel($userid) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	$result = _oxResult("SELECT level FROM $TABLE_USERS WHERE userid='$userid'");
	$record = mysql_fetch_array($result);
	$user_level = $record["level"];
	return $user_level;
}






//*********************************REVIDOVANE FUNKCE - BEZPECNOST***********************************

function checkUserNameValidity($user_name) {
	if (ereg("^[^_][_0-9a-z]{2,9}$", $user_name)) {
		return true;
	}else{
		return false;
	}

	//return $validity;
}

function checkUserNameUsability($user_name) {
	global $TABLE_USERS;
	$userLoginArray = _oxQuery("SELECT login FROM $TABLE_USERS WHERE login='$user_name'");
	if ($userLoginArray != 0 && $userLoginArray["login"] != "") {
		return true;
	}else{
		return false;
	}

	//return $usability;
}


//tato funkce vzdy predpoklada platne a existujici uzivatelske jmeno!!!!
function getUserId($user_name) {
	global $TABLE_USERS;
	$userIdArray = _oxQuery("SELECT userid FROM $TABLE_USERS WHERE login='$user_name'");
	$userId = $userIdArray["userid"];

	return $userId;
}
//*********************************REVIDOVANE FUNKCE - BEZPECNOST***********************************


















//----LVL2------









//BALICEK SECURITY FUNKCI - zajistuji bezpecnost aplikace

//pokud existuje session promenna user_id, nastav konvencni promenou
//v opacne pripade konvencni promennou user_id zrus a presmeruj na index.php
//promenna $user_id je pri zapnutych register_globals automaticky naplnena
//hodnotou session promenne $_SESSION["user_id"], ovsem nelze ji prepsat z GETu
//ani POSTu

function _oxCheckSession() {
	global $TABLE_USERS;

	//v pripade, ze se pokusi uzivatel dostat do systemu neprihlaseny (system nenajde jeho session promennou user_id)
	//bude tento uzivatel presmerovan na stranku s hlaseni, kde se dozvi o nutnosti prihlaseni a bude mu nabidnut
	//odkaz na prihlasovaci stranku

	$_sessUserID = $_SESSION['user_id'];
	$_sessUserLogin = $_SESSION['user_login'];
	$_sessUserPassword = $_SESSION['user_password'];
	//$last_log_time = $_SESSION['last_log_time'];
	//$invisible = $_SESSION['invisible'];


	//tato cast zkontroluje zda je predane user_id (i v pripade pokusu o utok) skutecne platne
	//-porovna se proti heslu v session a v DB
	if ($_sessUserID != "" && $_sessUserID != null && $_sessUserID != 0) {
		$dbasePasswordArray=_oxQuery("SELECT user_password FROM $TABLE_USERS WHERE PK_user=$_sessUserID");

		$dbasePassword = $dbasePasswordArray["user_password"];


		if($dbasePassword != $_sessUserPassword) {
			header("location: error.php?err_no=204");
		}

	}else{
		header("location: error.php?err_no=204");
	}

}

function _oxCheckServerName() {
	global $SERVER_NAME;
	list($http, $slash, $server) = explode("/",$_SERVER['HTTP_REFERER']);
	if($server != $SERVER_NAME) {
		header("Location: login.php");
		exit();
	}
}

//kontroluje zda IP adresa, ktera byla pri loginu do systemu ulozena do DB se v prubehu prace
//s aplikaci nezmenila
function _oxCheckIP() {
}


//kontroluje zda se stranka, ktera vyvolala aktualni stranku nachazi na pravem serveru
function _oxCheckDomain() {
}


































//OSTATNI A POMOCNE FUNKCE


//vrací hodnotu posledního přístupu uživatele do aplikace
function _oxGetUserLastAccess($user_id) {
	global $TABLE_USERS;
	$last_access_array=myQuery("SELECT last_access FROM $TABLE_USERS WHERE user_id=$user_id");
	$last_access=$last_access_array['last_access'];
	return $last_access;
}


//funkce vraci citelnou velikost souboru
function _oxSize($bytes) {
  $types =  Array("B","kB","MB","GB","TB");
   $current = 0;
  while ($bytes > 1024) {
   $current++;
   $bytes /= 1024;
  }
  return round($bytes,2)." ".$types[$current];
}


//vypisuje poznamky podle prislusneho kodu, can be used only after language file inclusion!!!!
function _oxNoter($note) {
	global $IMG_MAX_SIZE, $IMG_MAX_WIDTH, $IMG_MAX_HEIGHT;
	global $LNG_NOT_OR_WRONG_VALUE;
	global $LNG_SESSION_EXPIRED;
	global $LNG_TOO_BIG_IMAGE;
	global $LNG_IMAGE_DIMENSION;
	global $LNG_IMAGE_WRONG_FORMAT;
	global $LNG_IMAGE_SECURITY;
	global $LNG_IMAGE_NOT_AVAILABLE;
	global $LNG_SYSTEM_ERROR;
	global $LNG_ITEM_ADDED;
	global $LNG_ITEM_EDITED;
	global $LNG_ITEM_DELETED;

	global $LNG_USER_ALREADY_REGISTERED;
	global $LNG_USER_DOESNT_EXIST;
	global $LNG_WRONG_PASSWORD;
	global $LNG_TYPE_USERNAME_AND_PASSWORD;
	global $LNG_ONLY_ENGLISH_ALPHABET;
	global $LNG_USER_MIN_3LETTERS;
	global $LNG_PASSWORDS_DONT_MATCH;
	global $LNG_AUTO_LOGOUT;
	global $LNG_ACCESS_DENIED;
	global $LNG_LOGOUT_SUCCESSFUL;
	global $LNG_REGISTRATION_SUCCESSFUL;
	global $LNG_USER_ALREADY_LOGGED;
	global $LNG_NEW_PASSWORD_SUCCESS;
	global $LNG_NEW_PASSWORD_FAILURE;
	global $LNG_ICON_WRONG_FORMAT;
	global $LNG_ICON_WRONG_SIZE;
	global $LNG_ICON_UPLOADED;
	global $LNG_SET_LANGUAGE_SUCCESS;
	global $LNG_SET_STATUS_SUCCESS;
	global $LNG_SET_DETAILS_SUCCESS;
	global $LNG_SET_SKIN_SUCCESS;

	global $LNG_COCKPIT_WARNING_USER_NOT_FOUND;
	global $LNG_COCKPIT_WARNING_RECEIVER_NOT_USABLE;
	global $LNG_COCKPIT_WARNING_RECEIVER_NOT_VALID;
	global $LNG_COCKPIT_WARNING_MESSAGE_EMPTY;
	global $LNG_COCKPIT_WARNING_MESSAGE_ALREADY_SENT;


	switch ($note) {
			case "001":
			$note_text=$LNG_NOT_OR_WRONG_VALUE;
			break;
			case "002":
                  $note_text=$LNG_SESSION_EXPIRED;
			break;
                  case "060":
			$note_text=$LNG_TOO_BIG_IMAGE;
			break;
			case "061":
			$note_text=$LNG_IMAGE_DIMENSION;
			break;
			case "062":
			$note_text=$LNG_IMAGE_WRONG_FORMAT;
			break;
			case "063":
			$note_text=$LNG_IMAGE_SECURITY;
			break;
			case "064":
			$note_text=$LNG_IMAGE_NOT_AVAILABLE;
			break;
			case "055":
			$note_text=$LNG_SYSTEM_ERROR;
			break;

			case "101":
			$note_text=$LNG_ITEM_ADDED;
			break;
			case "102":
			$note_text=$LNG_ITEM_EDITED;
			break;
			case "103":
			$note_text=$LNG_ITEM_DELETED;
			break;

			case "801":
			$note_text=$LNG_USER_ALREADY_REGISTERED;
			break;
			case "802":
			$note_text=$LNG_USER_DOESNT_EXIST;
			break;
			case "803":
			$note_text=$LNG_WRONG_PASSWORD;
			break;
			case "804":
			$note_text=$LNG_TYPE_USERNAME_AND_PASSWORD;
			break;
			case "805":
			$note_text=$LNG_ONLY_ENGLISH_ALPHABET;
			break;
			case "806":
			$note_text=$LNG_USER_MIN_3LETTERS;
			break;
			case "807":
			$note_text=$LNG_PASSWORDS_DONT_MATCH;
			break;
			case "808":
			$note_text=$LNG_AUTO_LOGOUT;
			break;
			case "809":
			$note_text=$LNG_ACCESS_DENIED;
			break;
			case "810":
			$note_text=$LNG_LOGOUT_SUCCESSFUL;
			break;
			case "811":
			$note_text=$LNG_REGISTRATION_SUCCESSFUL;
			break;
			case "812":
			$note_text=$LNG_USER_ALREADY_LOGGED;
			break;

			case "201":
			$note_text=$LNG_COCKPIT_WARNING_USER_NOT_FOUND;
			break;
			case "202":
			$note_text=$LNG_COCKPIT_WARNING_RECEIVER_NOT_USABLE;
			break;
			case "203":
			$note_text=$LNG_COCKPIT_WARNING_RECEIVER_NOT_VALID;
			break;

			case "301":
			$note_text=$LNG_COCKPIT_WARNING_MESSAGE_EMPTY;
			break;
			case "302":
			$note_text=$LNG_COCKPIT_WARNING_MESSAGE_ALREADY_SENT;
			break;

			case "401":
			$note_text=$LNG_NEW_PASSWORD_SUCCESS;
			break;
			case "402":
			$note_text=$LNG_NEW_PASSWORD_FAILURE;
			break;
			case "403":
			$note_text=$LNG_ICON_WRONG_FORMAT;
			break;
			case "404":
			$note_text=$LNG_ICON_WRONG_SIZE;
			break;
			case "405":
			$note_text=$LNG_SET_LANGUAGE_SUCCESS;
			break;
			case "406":
			$note_text=$LNG_SET_STATUS_SUCCESS;
			break;
			case "407":
			$note_text=$LNG_SET_DETAILS_SUCCESS;
			break;
			case "408":
			$note_text=$LNG_ICON_UPLOADED;
			break;
			case "409":
			$note_text=$LNG_SET_SKIN_SUCCESS;
			break;



	}
	return $note_text;
}


//funkce zkontroluje zda ma obrazek predpokladane parametry,
//zapise ho na server a vrati jmeno souboru
function _oxImgHandler($img_type, $img_size, $img_temp, $current_id, $i) {
	global $IMG_MAX_SIZE, $IMG_MAX_WIDTH, $IMG_MAX_HEIGHT;

	if ($img_type=="" || $img_size=="" || $img_temp=="") {
		return 65;
	}elseif ($img_size > $IMG_MAX_SIZE){
	    return 60;
	}elseif ($img_type != "image/pjpeg"){
		return 62;
	}elseif (!is_uploaded_file($img_temp)){
		return 63;
	}else{
		copy($img_temp,"items_imgs/".$current_id."_".$i.".jpg");
	    unlink($img_temp);
		return $current_id."_".$i;
	}
}


















//funkce provede kompletni agendu aktualizace uzivatel v systemu
function _oxUpdateUserActivity($_userID, $_userLocation) {
	global $TABLE_USERS, $SUMMER_TIME, $formChckInvisible;


	$dbaseUserActivityArray = _oxQuery("SELECT user_last_activity, user_autologout FROM $TABLE_USERS WHERE PK_user='$_userID'");
	$dbaseUserLastActivity = $dbaseUserActivityArray["user_last_activity"];
	$dbaseUserAutologout = $dbaseUserActivityArray["user_autologout"];

	$scrptPresentTime=time()+$SUMMER_TIME;

	if ($formChckInvisible != 1) {
		_oxMod("UPDATE $TABLE_USERS SET user_last_activity=$scrptPresentTime, user_location='$_userLocation' WHERE PK_user='$_userID'");
	}

	if (($scrptPresentTime - $userLastActivity) > 5 && $formChckInvisible != 1) {
		_oxMod("UPDATE $TABLE_USERS SET user_last_activity=$scrptPresentTime, user_AT=user_AT+1 WHERE PK_user='$_userID'");
	}

	if (($now - $userLastActivity) > $userAutoLogout && $formChckInvisible != 1) {
		$session_expired=1;
		_oxMod("UPDATE $TABLE_USERS SET user_online=0 WHERE PK_user=$_userID");
		_oxMod("UPDATE $TABLE_USERS SET user_last_login=$scrptPresentTime WHERE PK_user=$_userID");
		session_destroy();
		//odtud se vraci rizeni na head.php, kde se zjisti, ze neexistuje session
	}else{
		$session_expired=0;
	}


	$usersOnlineResult = _oxResult("SELECT PK_user, user_last_activity, user_autologout FROM $TABLE_USERS WHERE user_online=1");

	while ($usersOnline = mysql_fetch_array($usersOnlineResult)) {
			$userLastActivity = $usersOnline["user_last_activity"];
			$userAutologout = $usersOnline["user_autologout"];
			$onlineUserID = $usersOnline["PK_user"];

			if (($now-$userLastActivity) > $userAutologout) {
				_oxMod("UPDATE $TABLE_USERS SET user_online=0 WHERE PK_user='$onlineUserID'");
			}
	}

	return $session_expired; //vrati prepinac
}


















//funkce provede kontrolu vstupnich informaci z adresniho radku, ktere stranka ocekava
//a prijima pro dalsi funkcnost
function _oxWatchDog($_variableValue, $_expectedType, $_variableName) {
	global $TABLE_WORDS;

	//zkoumame zda hodnota splnuje dane pozadavky

	if($_expectedType=="number") {
		//pokud je ocekavany typ promenne number zkontroluji, zda prommena neni prazdna
		//a zaroven odpovida tomuto typu, v opacnem pripade presmeruji na bezpecnou stranku
		//(systemova hlaseni), vypisi chybovou hlasku a ukoncim beh skriptu
		if($_variableValue !="" && !is_numeric($_variableValue)) {
			echo "::UPOZORNĚNÍ<br>";
			echo "----------------------------------------------------------------------------------------<br>";
			echo "1. Generování této stránky bylo ukončeno!<br>";
			echo "2. Integrita stránky byla naru‘ena pokusem o úpravu adresního řádku!<br>";
			echo "3. Zasahovat do adresního řádku se nedoporučuje!<br>";
			echo "4. Pokračovat lze kliknutím na libovolnou položku hlavního menu!<br>";
			exit();

		}else{

			//pokud je predano z adresniho radku jako hodnota ocekavane cislo, pak
			//zjistim (v pripade, ze bylo predano word_id) zda splnuje rozsah
			if ($_variableName == "word_id") {

				$_dbaseWordIDResult = _oxResult("SELECT PK_word, word_name FROM $TABLE_WORDS WHERE PK_word=$_variableValue");

				if (mysql_num_rows($_dbaseWordIDResult) != 0) {
					$_dbaseWordIDArray = mysql_fetch_array($_dbaseWordIDResult);
					$_dbaseWordName = $_dbaseWordIDArray["word_name"];
					$scrptWordMode=1;
					$_watchDogReturnArray["wordName"] = $_dbaseWordIDArray["word_name"];
					$_watchDogReturnArray["wordMode"] = 1;
				}else{
					$scrptWordMode=0;
					$_watchDogReturnArray["wordMode"] = 0;
				}
			}

			if ($_variableName == "page_code") {
				if ($_variableValue=="001" || $_variableValue=="002" || $_variableValue=="003" || $_variableValue=="001" || $_variableValue=="001") {
					$_watchDogReturnArray["pageCode"] = $_variableValue;
				}else{
					$_watchDogReturnArray["pageCode"] = "";
				}
			}

			$_watchDogReturnArray["variableValue"] = $_variableValue;

			return $_watchDogReturnArray;
		}
	}
}



/*********************************FUNCTION SET FOR USER INFO**********************************************/


function _oxGetUserLogin($_userID) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	$_dbaseUserLoginArray = _oxQuery("SELECT user_login FROM $TABLE_USERS WHERE PK_user=$_userID");
	$_dbaseUserLogin = $_dbaseUserLoginArray["user_login"];
	return $_dbaseUserLogin;
}

function _oxGetUserId($_userName) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	$_dbaseUserIdArray = _oxQuery("SELECT PK_user FROM $TABLE_USERS WHERE user_login='$_userName'");
	$_dbaseUserId = $_dbaseUserIdArray["PK_user"];
	return $_dbaseUserId;
}

function _oxGetUserAT($_userID) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	$_dbaseUserATArray = _oxQuery("SELECT user_AT FROM $TABLE_USERS WHERE PK_user=$_userID");
	$_dbaseUserAT = $_dbaseUserATArray["user_AT"];
	return $_dbaseUserAT;
}

/*********************************FUNCTION SET FOR USER INFO**********************************************/



//funkce na zaklade prijatych parametru zasle do databaze potrebny dotaz
//o zobrazeni daneho mnozstvi zprav v poste a vysledny result vrati
function _oxGetMailsPagingResult($_userID, $_pagingType, $_rowsCount, $_backwardValue, $_forwardValue) {
	global $TABLE_MAILS;
	$_dbaseMailsCountResult = _oxResult("SELECT mail_from_id FROM $TABLE_MAILS WHERE ((mail_to_id=$_userID AND mail_sender=$_userID) OR (mail_from_id=$_userID AND mail_sender=$_userID)) ORDER BY mail_date DESC");
	$_dbaseMailsCount = mysql_num_rows($_dbaseMailsCountResult);

	//echo "mailscount: ".$_dbaseMailsCount."<br>";

	/*
	if ($calculate == nastavit) {
		if ($scrptSelectBox==$dbaseMailsCount) {//pokud chce zobrazovat vzdy vse, dame do db, identifikator -1
			_oxMod("UPDATE $TABLE_USERS SET user_msgs=-1 WHERE PK_user=$sessUserID");
		}else{
			_oxMod("UPDATE $TABLE_USERS SET user_msgs=$scrptSelectBox WHERE PK_user=$sessUserID");
		}
		$rownum = $scrptSelectBox;
		$chosen = 1;
		$scrptForwardValue = 0;
		$scrptBackwardValue = 0;
		$scrptStartValue = 0;
		$endvalue = 0;
	}else{
		if ($chosen == 1) {
			$scrptSelectBox = $memselectbox;
			$rownum = $memselectbox;
		}
	}
	*/


	/*
	if ($chosen != 1) {
		$dbaseUserMsgsArray=_oxQuery("SELECT user_msgs FROM $TABLE_USERS WHERE PK_user=$sessUserID");
		$dbaseUserMsgs=$dbaseUserMsgsArray["user_msgs"];

		if ($newnum == 0) {
			if ($dbaseUserMsgs != -1) {
				$rownum = $dbaseUserMsgs;//tady bude cislo z db
			}else{
				$rownum = $dbaseMailsCount;
			}
		}else{
			if ($dbaseUserMsgs != -1) {
				$rownum = $dbaseUserMsgs;//tady bude cislo z db
			}else{
				$rownum = $dbaseMailsCount;
			}

			if ($rownum > $newnum) {//pokud je vic radku zobrazovanych nez novych
				$rownum = $newnum + ($rownum-$newnum);
			}else{
				$rownum = $newnum+2;
			}
		}
	}
	*/

	if ($_pagingType == start) {
		$_forwardValue = 0;
		$_backwardValue = $_forwardValue;
		$_dbaseMailsPagingResult = _oxResult("SELECT * FROM $TABLE_MAILS WHERE ((mail_to_id=$_userID AND mail_sender=$_userID) OR (mail_from_id=$_userID AND mail_sender=$_userID)) ORDER BY mail_date DESC LIMIT 0, $_rowsCount");
	}else{
		if ($_pagingType == finish) {
			$_endCount = $_dbaseMailsCount - $_rowsCount;
			$_forwardValue = $_dbaseMailsCount - $_rowsCount;
			$_backwardValue = $_dbaseMailsCount - $_rowsCount;
			$_dbaseMailsPagingResult = _oxResult("SELECT * FROM $TABLE_MAILS WHERE ((mail_to_id=$_userID AND mail_sender=$_userID) OR (mail_from_id=$_userID AND mail_sender=$_userID)) ORDER BY mail_date DESC LIMIT $_endCount, $_rowsCount");
		}else{


			if ($_pagingType == backward) {
				$_backwardValue = $_backwardValue + $_rowsCount;
				$_forwardValue = $_forwardValue + $_rowsCount;
				$_dbaseMailsPagingResult = _oxResult("SELECT * FROM $TABLE_MAILS WHERE ((mail_to_id=$_userID AND mail_sender=$_userID) OR (mail_from_id=$_userID AND mail_sender=$_userID)) ORDER BY mail_date DESC LIMIT $_backwardValue, $_rowsCount");
			}else{
				if($_pagingType == forward) {
					$_forwardValue = $_forwardValue - $_rowsCount;
					if ($_forwardValue < 0) {$_forwardValue = 0;}
					$_backwardValue = $_forwardValue;
					$_dbaseMailsPagingResult = _oxResult("SELECT * FROM $TABLE_MAILS WHERE ((mail_to_id=$_userID AND mail_sender=$_userID) OR (mail_from_id=$_userID AND mail_sender=$_userID)) ORDER BY mail_date DESC LIMIT $_forwardValue, $_rowsCount");
				}else{
					if($_pagingType == void){
						$_backwardValue = 0;
						$_dbaseMailsPagingResult = _oxResult("SELECT * FROM $TABLE_MAILS WHERE ((mail_to_id=$_userID AND mail_sender=$_userID) OR (mail_from_id=$_userID AND mail_sender=$_userID)) ORDER BY mail_date DESC LIMIT 0, $_rowsCount");
					}
				}

			}

		}
	}

	$_mailsPagingReturnArray["result"] = $_dbaseMailsPagingResult;
	$_mailsPagingReturnArray["forwardValue"] = $_forwardValue;
	$_mailsPagingReturnArray["backwardValue"] = $_backwardValue;
	$_mailsPagingReturnArray["endCount"] = $_endCount;
	$_mailsPagingReturnArray["mailsCount"] = $_dbaseMailsCount;
	return $_mailsPagingReturnArray;
}










//----------------------------STARE FUNKCE Z TCZ--------------------------------














function updatelastaction($userid) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	global $SUMMER_TIME;
	global $AT_DELAY;
	global $invisible;



	//ZJISTENI POSLEDNIHO PRISTUPU A DOBY ODHLASENI Z DATABAZE
	//vybere z databaze posledni pristup a dobu odhlasovani u prihlaseneho uzivatele
	$select_active_user = _oxResult("SELECT lastaccess, autologout FROM $TABLE_USERS WHERE userid='$userid'");
	$active_user = mysql_fetch_array($select_active_user);
	$last_activity = $active_user["lastaccess"];
	$autologout = $active_user["autologout"];
	
	//echo $last_activity;
	//echo "<br />";
	//echo $autologout;

	$now=time()+$SUMMER_TIME;


	//AKTUALIZACE POSLEDNIHO PRISTUPU A UMISTENI
	//pokud nema uzivatel nastaven rezim neviditelnosti, aktualizuje jeho posledni pristup do systemu a
	//modul, ve kterem se nachazi
	if ($invisible != 1) {
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now WHERE userid='$userid'");
	}


	//POCITANI ATCEK
	//pokud je rozdil mezi aktualnim casem a posledni aktivitou vetsi nez stanovena hodnota a zaroven neni
	//prihlaseny uzivatel v rezimu neviditelnosti, nastavi mu posledni pristup na aktualni hodnotu
	//a pripocte AT
	if (($now - $last_activity) > $AT_DELAY && $invisible != 1) {
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now, AT=AT+1 WHERE userid='$userid'");
	}


	//ODHLASOVANI PRIHLASENEHO UZIVATELE
	//pokud je rozdil mezi aktualnim casem a posledni aktivitou vetsi nez doba odhlasovani a zaroven
	//neni prihlaseny uzivatel v rezimu neviditelnosti, zapne se prepinac o vyprsenem sezeni, nastavi
	//se do databaze, ze uzivatel neni aktivni a nastavi se jeho posledni prihlaseni na aktualni cas
	//v opacnem pripade se vypne prepinac o vyprsenem sezeni
	if (($now - $last_activity) > $autologout && $invisible != 1) {
		$sess_out=1;
		_oxMod("UPDATE $TABLE_USERS SET active=0 WHERE userid='$userid'");
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now WHERE userid='$userid'");
		//session_destroy();
		//odtud se vraci rizeni na head.php, kde se zjisti, ze neexistuje session
	}else{
		$sess_out=0;
	}


	//ODHLASOVANI OSTATNICH UZIVATELU
	//vyberou se uzivatele, kteri maji v databazi uvedeno, ze jsou aktivni
	//zkontroluje se, zda je u nich rozdil mezi aktualnim case a posledni aktivitou
	//mensi nez doba odhlaseni, pokud je vetsi, nastavi se, ze nejsou aktivni
	$select_active_users = _oxResult("SELECT userid, lastaccess, autologout FROM $TABLE_USERS WHERE active=1");

	while ($active_users = mysql_fetch_array($select_active_users)) {
			$last_activity = $active_users["lastaccess"];
			$autologout = $active_users["autologout"];
			$usrid = $active_users["userid"];

			if (($now-$last_activity) > $autologout) {
				_oxMod("UPDATE $TABLE_USERS SET active=0 WHERE userid='$usrid'");
			}
	}


	//pokud je zapnuty prepinac o vyprsenem sezeni, znici se sezeni a odesle se informace
	if ($sess_out==1) {
		session_destroy();
		$_GET['note'] = 002;
      }

	//return $sess_out; //vrati prepinac pro pripadne zobrazeni upozorneni uzivateli
}

























function updatelastaction_backup($userid, $location) {
	global $TABLE_USERS; //rekne funkci, ze ma pouzit globalni promennou
	global $SUMMER_TIME;
	global $invisible;


	$select_active_user = _oxResult("SELECT lastaccess, autologout FROM $TABLE_USERS WHERE userid='$userid'");
	$active_user = mysql_fetch_array($select_active_user);
	$last_activity = $active_user["lastaccess"];
	$autologout = $active_user["autologout"];

	$now=time()+$SUMMER_TIME;

	if ($invisible != 1) {
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now, location='$location' WHERE userid='$userid'");
	}

	if (($now - $last_activity) > 10 && $invisible != 1) {
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now, AT=AT+1 WHERE userid='$userid'");
	}

	if (($now - $last_activity) > $autologout && $invisible != 1) {
		$sess_out=1;
		_oxMod("UPDATE $TABLE_USERS SET active=0 WHERE userid='$userid'");
		_oxMod("UPDATE $TABLE_USERS SET lastaccess=$now WHERE userid='$userid'");
		//session_destroy();
		//odtud se vraci rizeni na head.php, kde se zjisti, ze neexistuje session
	}else{
		$sess_out=0;
	}

	$select_active_users = _oxResult("SELECT userid, lastaccess, autologout FROM $TABLE_USERS WHERE active=1");

	while ($active_users = mysql_fetch_array($select_active_users)) {
			$last_activity = $active_users["lastaccess"];
			$autologout = $active_users["autologout"];
			$usrid = $active_users["userid"];

			if (($now-$last_activity) > $autologout) {
				_oxMod("UPDATE $TABLE_USERS SET active=0 WHERE userid='$usrid'");
			}
	}

	if ($sess_out==1) {
		session_destroy();
	}

	return $sess_out; //vrati prepinac
}


















//----------------------------PARSING--------------------------------

//odstrani z url onClick, onMouseOver atp
function stripJSEvents($link) {
	//prepise obsah link na mala pismena
	//tim zajisti modifikace onClick, ONCLICK, onclick
	$link = strtolower($link);
	//echo "<br>link: ".$link."<br>";
	//nahradi javascript triggery nepodporovanym textem
	$events = array("onclick", "onload", "onmouseover", "onmouseout");
	$link = str_replace($events, 'oxincz', $link);
	//echo "<br>link: ".$link."<br>";
	return $link;
}



function replaceImg($message) {
	// Make image from [img]http://.... [/img] or [img=http://....]alt[/img]
	while(strpos($message, "[img")!==false){
		$begImg = strpos($message, "[img");
		$endImg = strpos($message, "[/img]");
		$img = substr($message, $begImg, $endImg-$begImg+6);
		$posBracket = strpos($img, "]");

		if ($posBracket != null){
				if ($posBracket == 4){
					// [img]http://.... [/img]
					$link = substr($img, 5, $endImg - $begImg -5);
					//odstrani z url onClick, onMouseOver atp
					$link = stripJSEvents($link);
					$htmlImg = '<img src="'.$link.'" />';
				} else {
					// [img=http://....]alt[/img]
					$link = substr($img, 5, $posBracket-5);
					//odstrani z url onClick, onMouseOver atp
					$link = stripJSEvents($link);
					$alt = substr($img, $posBracket+1, strpos($img, "[/img]") - $posBracket-1);
					//odstrani z alt onClick, onMouseOver atp
					$alt = stripJSEvents($alt);
					$htmlImg = '<img src="'.$link.'" alt="'.$alt.'" />';
				}
		}

		$message = str_replace($img, $htmlImg, $message);
		// searches for other [img]-nodes
	}
	return $message;
}



function replaceIcon($message) {
	global $css;  
      // defines the emoticons
      $emoticonarray = array(
      '::)'  => '01.png',
      '::('  => '03.png',
      '::*'  => '04.png',
      '::P'  => '05.png',
      ':;)'  => '11.png'
      );
      
      // generates the search and replace arrays
      foreach($emoticonarray as $emoticon => $img) {
  
       $search[] = $emoticon;
       $replace[] = '<img src="/style/dark/smile/' . $img . '" alt="' . $emoticon . '" />';
             
      
      }
  
      // searches the text passed to the function
      $message = str_replace($search, $replace, $message);
      
      // return the value
      return $message;
        		
}



function replaceUrl($message) {
	// Make link from [url]http://.... [/url] or [url=http://.... ]text[/url]
	while(strpos($message, "[url")!==false){
		$begUrl = strpos($message, "[url");
		$endUrl = strpos($message, "[/url]");
		$url = substr($message, $begUrl, $endUrl-$begUrl+6);

		$posBracket = strpos($url, "]");

		if ($posBracket != null){
			if ($posBracket == 4){
				// [url]http://.... [/url]
				$link = substr($url, 5, $endUrl - $begUrl -5);
				//odstrani z url onClick, onMouseOver atp
				$link = stripJSEvents($link);
				$htmlUrl = "<a href=$link target='_blank'>$link</a>";
			} else {
				// [url=http://....]text[/url]
				$link = substr($url, 5, $posBracket-5);
				//odstrani z url onClick, onMouseOver atp
				$link = stripJSEvents($link);
				$text = substr($url, $posBracket+1, strpos($url, "[/url]") - $posBracket-1);
				$htmlUrl = "<a href=$link target='_blank'>$text</a>";
			}
		}

		$message = str_replace($url, $htmlUrl, $message);
		// searches for other [url]-nodes
	}
	return $message;
}

function replaceMessage($message) {

	$message    = strip_tags($message);


	$message    = str_replace ("[br]", "<br>", "$message");
	$message    = str_replace ("\n", "<br>", "$message");


	// When you store the $message in a database you might get errors cause of the quotes
	$message    = str_replace("[singleQuote]", "'", $message);
	$message    = str_replace("[doubleQuote]", "\"", $message);

	$message    = str_replace ("[u]", "<u>", "$message");
	$message    = str_replace ("[/u]", "</u>", "$message");
	$message    = str_replace ("[i]", "<em>", "$message");
	$message    = str_replace ("[/i]", "</em>", "$message");
	$message    = str_replace ("[b]", "<strong>", "$message");
	$message    = str_replace ("[/b]", "</strong>", "$message");


	if ($message!="") {
		$message    = "<p>".$message."</p>";
	}
	$message    = replaceUrl($message);
	$message    = replaceImg($message);
	$message    = replaceIcon($message);

	return $message;
}



function _oxSetMainMenuCSS($module_number) {
	global $MODULE01_BTN_BG;
	global $MODULE02_BTN_BG;
	global $MODULE03_BTN_BG;
	global $MODULE04_BTN_BG;
	global $MODULE05_BTN_BG;
	global $MODULE06_BTN_BG;
	global $MODULE07_BTN_BG;
	global $MODULE08_BTN_BG;
	global $MODULE09_BTN_BG;
	global $MODULE10_BTN_BG;
	global $MODULE11_BTN_BG;

	if ($module_number==1) {
		$MODULE01_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE01_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==2) {
		$MODULE02_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE02_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==3) {
		$MODULE03_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE03_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==10) {
			$MODULE10_BTN_BG = "main_menu_btn_bg_slct";
		}else{
			$MODULE10_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==4) {
		$MODULE04_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE04_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==11) {
		$MODULE11_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE11_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==5) {
		$MODULE05_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE05_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==6) {
		$MODULE06_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE06_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==7) {
		$MODULE07_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE07_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==8) {
		$MODULE08_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE08_BTN_BG = "main_menu_btn_bg_norm";
	}

	if ($module_number==9) {
		$MODULE09_BTN_BG = "main_menu_btn_bg_slct";
	}else{
		$MODULE09_BTN_BG = "main_menu_btn_bg_norm";
	}
}

function _oxSetSubMenuCSS($submodule_number) {
	global $SUBMODULE01_BTN_BG;
	global $SUBMODULE02_BTN_BG;
	global $SUBMODULE03_BTN_BG;
	global $SUBMODULE04_BTN_BG;
	global $SUBMODULE05_BTN_BG;
	global $SUBMODULE06_BTN_BG;
	global $SUBMODULE07_BTN_BG;
	global $SUBMODULE08_BTN_BG;
	global $SUBMODULE09_BTN_BG;
	global $SUBMODULE10_BTN_BG;
	global $SUBMODULE11_BTN_BG;


	if ($submodule_number==1) {
		$SUBMODULE01_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
		$SUBMODULE01_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==2) {
			$SUBMODULE02_BTN_BG = "sub_menu_btn_bg_slct";
		}else{
			$SUBMODULE02_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==3) {
			$SUBMODULE03_BTN_BG = "sub_menu_btn_bg_slct";
		}else{
			$SUBMODULE03_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==4) {
		$SUBMODULE04_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
		$SUBMODULE04_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==5) {
		$SUBMODULE05_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
		$SUBMODULE05_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==6) {
			$SUBMODULE06_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
			$SUBMODULE06_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==7) {
			$SUBMODULE07_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
			$SUBMODULE07_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==8) {
			$SUBMODULE08_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
			$SUBMODULE08_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==9) {
			$SUBMODULE09_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
			$SUBMODULE09_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==10) {
			$SUBMODULE10_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
			$SUBMODULE10_BTN_BG = "sub_menu_btn_bg_norm";
	}

	if ($submodule_number==11) {
			$SUBMODULE11_BTN_BG = "sub_menu_btn_bg_slct";
	}else{
			$SUBMODULE11_BTN_BG = "sub_menu_btn_bg_norm";
	}

}


function rteSafe($strText) {
	//returns safe code for preloading in the RTE
	$tmpString = $strText;

	//convert all types of single quotes
	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	$tmpString = str_replace("'", "&#39;", $tmpString);

	//convert all types of double quotes
	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);
//	$tmpString = str_replace("\"", "\"", $tmpString);

	//replace carriage returns & line feeds
	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);

	return $tmpString;
}



function getLocation($infolocation) {
	global $TABLE_ROOMS;
	global $LOCATION_LENGTH;
	$loc_arr = split(";", $infolocation); //pole nazvu odpovedi
	$loc_num = Count($loc_arr);

	$location_number = intval($loc_arr[0]);


	if ($loc_num == 2) {
		$location_dscrb = $loc_arr[1];
	}


	if ($location_number!=0) {
			$roomresult = _oxResult("SELECT name FROM $TABLE_ROOMS WHERE roomid=$location_number");
			$roomrecord = mysql_fetch_array($roomresult);
			$infolocation = $roomrecord["name"];
			if (strlen($infolocation) >= $LOCATION_LENGTH) {
				$infolocation = substr($infolocation, 0, $LOCATION_LENGTH);
				$infolocation = $infolocation."...";
			}
	}

	$locationArray['infolocation'] = $infolocation;
	$locationArray['location_number'] = $location_number;
	$locationArray['location_dscrb'] = $location_dscrb;
	return $locationArray;
}

function getTopicName($topic_id) {
	global $TABLE_TOPICS;
	$topicNameArray = _oxQuery("SELECT topic_name FROM $TABLE_TOPICS WHERE PK_topic=$topic_id");
	$topicName = $topicNameArray['topic_name'];
	return $topicName;
}

function getSubTopicName($subtopic_id) {
      global $TABLE_SUBTOPICS;
      $subTopicNameArray = _oxQuery("SELECT subtopic_name FROM $TABLE_SUBTOPICS WHERE PK_subtopic=$subtopic_id");
	$subTopicName = $subTopicNameArray['subtopic_name'];
	return $subTopicName;
}































































//----------------------------BLOK AKCI BEZICICH NA ZACATKU KAZDE STRANKY--------------------------------

//na zacatku si overime pristup do databazoveho serveru...
@$scrptSQLConnection = mysql_connect("$SQL_HOST","$SQL_USER","$SQL_PSWD");
if (!$scrptSQLConnection) {
	//pokud se nepodari pripojeni k db serveru zapise zpravu do logu a presmeruje na error.php
	_oxWriteErrorLog(sprintf("internal error %d:%s\n ", mysql_errno(), mysql_error())); //sprintf vraci retezec jako hodnotu funkce
	header("Location: error.php?err_no=101");
	exit();
}elseif (!(mysql_select_db($SQL_DBASE, $scrptSQLConnection))) {
	//pokud se pripojeni k serveru podari ale nenajde pozadovanou databazi zapise zpravu do logu a presmeruje na error.php
	_oxWriteErrorLog(sprintf("internal error %d:%s\n ", mysql_errno(), mysql_error())); //sprintf vraci retezec jako hodnotu funkce
	header("Location: error.php?err_no=101");
	exit();
}



//mysql_query("SET CHARACTER SET utf8", $scrptSQLConnection);

//SET NAMES indicates what is in the SQL statements that the client sends.
//Thus, SET NAMES 'cp1251' tells the server ``future incoming messages from this
//client are in character set cp1251.'' It also specifies the character set for
//results that the server sends back to the client. (For example, it indicates what
//character set column values are if you use a SELECT statement.)
mysql_query("SET NAMES utf8", $scrptSQLConnection);




//get prefered interface language from database
//this has to be written without any user defined function like oxQuery, otherwise script gets loop


$user_id_lang = $_SESSION['userid'];
//echo $user_id_lang;
//echo $_SESSION['userid'];
//session_destroy();

if ($user_id_lang != "" || $user_id_lang != 0 || $user_id_lang != null) {
	$userLangResult = mysql_query("SELECT user_lang FROM $TABLE_USERS WHERE userid=$user_id_lang", $scrptSQLConnection);
	$userLangArray = mysql_fetch_array($userLangResult);
	$userLang = $userLangArray['user_lang'];
	//echo "userlang: ".$userLang;
	require('lang/'.$userLang.'.php');
	//require('lang/en.php');
}else{ //for index.php - until merging with system
	require('lang/'.$DEFAULT_LANG.'.php');
}

header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");



















?>
