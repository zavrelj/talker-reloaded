<!-- SPRAVCI DISKUZE //-->
			<?
				$ownerArray=_oxQuery("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
				$ownerID = $ownerArray["founderid"];
			?>

			VLASTNIK DISKUZE
			<img src="ico/<?echo getUserLogin($ownerID)?>.gif" />
			<?echo getUserLogin($ownerID)?>|
			<a href="gate.php?m=11&s=1&fuserid=<?echo $ownerID?>">informace o uživateli</a>

			<?
				$keepers_result=_oxResult("SELECT keeper_id FROM $TABLE_ROOM_KEEPERS WHERE roomid=$roomid");
				if (mysql_num_rows($keepers_result) != 0) { //pokud ma tento klub spravce

			?>
			SPRAVCI DISKUZE
										<div>
									<?
										$x=0;
										while ($keepers_record=mysql_fetch_array($keepers_result)) {
											$keeper_id=$keepers_record["keeper_id"];
											$x++;
			        		       	?>
			        		       			<img src="ico/<?echo getUserLogin($keeper_id)?>.gif" />
			        		       			<?echo getUserLogin($keeper_id)?>|
			        		       			<a href="gate.php?m=11&s=1&fuserid=<?echo $keeper_id?>">informace o uživateli</a>
			        		       	<?
											if ($x >=3) { echo "</div><div>"; $x=0;}

										}
									?>

											</div>
			<? } ?>
<!-- SPRAVCI DISKUZE //-->
