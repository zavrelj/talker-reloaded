<strong>základní informace o uživateli <? echo "$user_info_login" ?></strong>

<br />

<strong>ikonka: </strong><img src="ico/<? echo "$user_info_login" ?>.gif" />

<br />

<strong>jméno: </strong><? echo "$user_info_login" ?>

<br />

<strong>datum registrace: </strong><? echo date("d.m.Y  H:i:s", $user_info_regdate); ?>

<br />

<strong>poslední aktivita: </strong><? echo date("d.m.Y  H:i:s", $user_info_lastaccess); ?>

<br />

<strong>počet AT: </strong><? echo "$user_info_AT"; ?>

<br />

<strong>umístění: </strong> 
<? if ($user_location_number!=0) {?>
	<a href="gate.php?m=10&s=1&roomid=<?echo $user_location_number?>">
		<? echo "$user_info_location"; ?>
	</a>
	<? if ($user_location_dscrb != "") {?>
		<? echo "$user_location_dscrb"; ?>
	<? }?>
<?}else{?>
	<? echo "$user_info_location"; ?>
<?}?>

<br />

<strong>online: </strong>
<? if ($user_info_active==0) { ?>
	ne
<?}else{?>
	ano
<?}?>
