<?

$backvalue = $_POST['backvalue'];
$back = $_POST['back'];
$frwdvalue = $_POST['frwdvalue'];
$frwd = $_POST['frwd'];
$end = $_POST['end'];
$endvalue = $_POST['endvalue'];
$start = $_POST['start'];
$startvalue = $_POST['startvalue'];

$fuser_show = $_POST['fuser_show'];


//echo "fuserid: ".$fuserid;


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



/*
if (isSet($fuserid) || $fuserid==$userid) {
	echo "userid:".$userid;
      $isOneUser = 0;
}else{
	$isOneUser = 1;
}
*/


//echo "isOne: ".$isOneUser;

include('incl/navi.php');

?>


<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>

<?
if ($submodule_number==1 || $submodule_number==3) {
	//echo "zobraz prispevky";
	include('incl/live_show.php');
}
if ($submodule_number==2) {
	//echo "vyhledej prispevky";
	include('incl/live_search.php');
}
?>





