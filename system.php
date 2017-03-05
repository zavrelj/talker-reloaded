<?

$result = _oxResult("SELECT COUNT(userid) as pocet FROM $TABLE_USERS");
$record = mysql_fetch_array($result);
$usercounter = $record["pocet"];

//$last_log_result = _oxResult("SELECT client FROM $TABLE_USERS WHERE userid=$userid");
//$last_log_record = mysql_fetch_array($last_log_result);

$logged = $_GET['logged'];

?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>

<? if ($logged==1) {//Pokud je jiz uzivatel prihlasen ?>


<!-- <noscript> //-->

<h1>UPOZORNĚNÍ</h1>
<h3>Účet, ke kterému jste se přihlásil/a, je již veden v systému jako aktivní!</h3>
<p>Zřejmě jste se při poslední návštěve korektně neodhlásil/a ze systému, nebo někdo jiný právě používá Váš účet!</p>

<!-- </noscript> //-->

<!--
<script language="javascript" type="text/javascript">

      showNewPlayerLightbox('812');

</script>      
//-->

<? //include('incl/warning_logged.php'); ?>
<? } ?>




<div id="content">
<?
if ($submodule_number==1) {
	//echo "vkladam systemove informace";
	include('incl/sys_info.php');
}
if ($submodule_number==2) {
	//echo "vkladam systemovou statistiku";
	include('incl/sys_statistics.php');
}
?>
</div>









