<?
$result_others=_oxResult("SELECT userid, login FROM $TABLE_USERS WHERE location=$roomid AND userid!=$userid AND active=1");
if (mysql_num_rows($result_others) != "") {
?>

<!-- SEZNAM UZIVATELU PRITOMNYCH V DISKUZI//-->
<div>
	<?
	$img_count=0;
	while ($record_others=mysql_fetch_array($result_others)) {
		$img_count++;
	?><a href="gate.php?m=10&s=5&fuserid=<?echo $record_others["userid"]?>">
	<img src="ico/<?echo $record_others["login"]?>.gif" alt="<?echo $record_others["login"]?>" />
	</a>
	<?
		if ($img_count >=18) { echo "</div><div>"; $img_count=0;}
	}?>
</div>
<!-- SEZNAM UZIVATELU PRITOMNYCH V DISKUZI//-->
<? } ?>