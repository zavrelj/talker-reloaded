<? if ($not_exist == 1) { ?>
	! uživatel neexistuje, je již v seznamu, nebo chcete přidat sebe sama !
<? } ?>

<form method="post" action="gate.php?m=4&s=2">
<? if ($friend_num!=0) { ?>
	<input type="hidden" name="what" value="<? echo $what ?>">
	<input name="del" type="submit" value="smazat označené" class="button">
<? } ?>


<?
while($record=MySQL_Fetch_array($result)) {

	$user_name = $record["login"];
	$friendnote = $record["note"];
	$infolocation = $record["location"];
	$user_lastaccess = $record["lastaccess"];
	$user_regdate = $record["regdate"];
	$currentAT = $record["AT"];
	$fuserid = $record["friendid"];
	$user_online = $record["active"];


	$locationArray = getLocation($infolocation);
	$infolocation = $locationArray['infolocation'];
	$location_number = $locationArray['location_number'];

	$img = _oxShowAT($friendcurrentAT);
?>
	<div>
		<? include('incl/users_infotext.php'); ?>
	</div>
<? } ?>

<form name="addfriend" action="gate.php?m=4&s=2" method="post">
<fieldset>
	<legend>přidat přítele/změnit komentář</legend>
	<label>jméno</label>
	<input type="text" name="pratname" value="<? echo $add_friend_name ?>" maxlength="15">
	<label>komentář</label>
	<input type="text" name="pratnote">
	<input type="submit" name="pratsubmit" value="přidat přítele">
	<input type="submit" name="pratsubmit" value="změnit komentář">
</fieldset>
</form>

