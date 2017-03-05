zobrazit všechny uživatele, seřadit podle:
[<a href="gate.php?m=4&s=3&show_all=1">jména</a>]
[<a href="gate.php?m=4&s=3&show_all=2">poslední aktivity</a>]
[<a href="gate.php?m=4&s=3&show_all=3">data registrace</a>]
[<a href="gate.php?m=4&s=3&show_all=4">počtu AT</a>]
[<a href="gate.php?m=4&s=3&show_all=5">levelu</a>]

<?
while($logged=MySQL_Fetch_array($usersResult)) {
	$user_name = $logged["login"];
	$currentAT = $logged["AT"];
	$user_level = $logged["level"];
  $infolocation = $logged["location"];
	$user_status = $logged["status"];
	$user_online = $logged["active"];
	$user_lastaccess = $logged["lastaccess"];
	$user_regdate = $logged["regdate"];
	$level_icon = _oxShowLevel($user_level);
	$fuserid=getUserId($user_name);

	$locationArray = getLocation($infolocation);
	$infolocation = $locationArray['infolocation'];
	$location_number = $locationArray['location_number'];
	
?>
<div>
	<? include('incl/users_infotext.php'); ?>
</div>
<? } ?>


