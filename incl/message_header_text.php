<? echo $user_name ?> @ <? echo $formatteddate ?>

<? if (mysql_num_rows($loc_result)!=0 && $fuserid!=$userid) {?>
	[ONLINE|
	<? if ($location_number!=0) {?>
		<a href="gate.php?m=10&s=1&roomid=<?echo $location_number?>"><? echo $infolocation ?></a>
		<? if ($location_dscrb!="") {?>
			<?echo $location_dscrb ?>
		<? } ?>
	<?}else{?>
		<? echo $infolocation ?>
	<?}?>
	|<? echo date("H:i:s", "$infolastaccess"); ?>
	|<?echo $infostatus; ?>
	]
<? } ?>







