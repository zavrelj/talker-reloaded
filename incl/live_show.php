<? if($isOneUser==1) { ?>
<form method="post" action="gate.php?m=7&s=3">
<? }else{ ?>
<form method="post" action="gate.php?m=7&s=1">
<? } ?>


<!-- NAVIGATION WINDOW //-->
<?
//fuserid, ktery obsahuje id uzivatele, jehoz prispevky se maji zobrazit,
//je v prubehu vypisovani prispevku prepsan!!!
//tomu je treba zabranit tak, ze vezmeme puvodni verzi, ulozime do pomocne promenne
//a po probehnuti cyklu naplnime id uzivatele hodnotou teto pomocne promenne
$fuserid_orig = $fuserid;
?>


<div>
      <input name="refresh" type="submit" value="aktualizovat" accesskey="r" title="pro aktualizaci stránky lze také použít ALT+R">
</div>
<? $navigation_id=31 ?>
<? include('incl/navigation.php'); ?>
<? $navigation_id=0 ?>
<!-- NAVIGATION WINDOW //-->
</form>
<br /><br />

<?

		while($show_record=MySQL_Fetch_array($live_result)) {


			$fuserid = $show_record["fromid"];
			$user_name = $show_record["login"];
			$live_user_status = $show_record["status"];
			$live_user_AT = $show_record["AT"];
			$live_user_level = $show_record["level"];
                  $live_user_message=$show_record["message"];
			$live_room_id=$show_record["roomid"];
			$live_room_name=$show_record["name"];
			$live_room_private=$show_record["private"];
			$hisimg=_oxShowLevel($live_user_level);


			$timestampvalue = $show_record["date"];
			$formatteddate = date("d.m.Y  H:i:s",$timestampvalue);

			//zkracuje dlouhy nazev diskuze
			if (strlen($live_room_name) >= $LOCATION_LENGTH) {
				$live_room_name = substr($live_room_name, 0, $LOCATION_LENGTH);
				$live_room_name = $live_room_name."...";
			}


			?>

			<? include('incl/message.php'); ?>
		<?
		}
		?>






<? if($isOneUser==1) { ?>
	<form method="post" action="gate.php?m=7&s=3">
<? }else{ ?>
	<form method="post" action="gate.php?m=7&s=1">
<? } ?>
	<!-- NAVIGATION WINDOW //-->
	<? $navigation_id=32 ?>
	<? //$fuserid = ""; //has to be deleted, otherwise listing of all users fail ?>
	<? $fuserid = $fuserid_orig; ?>
      <? include('incl/navigation.php'); ?>
	<? $navigation_id=0 ?>
	<!-- NAVIGATION WINDOW //-->
	</form>
