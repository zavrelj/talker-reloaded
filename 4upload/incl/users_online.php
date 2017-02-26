<?
while($logged=MySQL_Fetch_array($usersResult)) {
	$user_name = $logged["login"];
	$currentAT = $logged["AT"];
	$infolocation = $logged["location"];
	$user_status = $logged["status"];
	$user_online = $logged["active"];
	$user_lastaccess = $logged["lastaccess"];
	$user_regdate = $logged["regdate"];
	$user_level = $logged["level"];
  $level_icon = _oxShowLevel($user_level);
	$fuserid=getUserId($user_name);

	$locationArray = getLocation($infolocation);
	$infolocation = $locationArray['infolocation'];
	$location_number = $locationArray['location_number'];
?>

	<? include('incl/users_infotext.php'); ?>

<? } ?>


