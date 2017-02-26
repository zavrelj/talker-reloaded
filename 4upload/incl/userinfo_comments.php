<? if ($famecount != 0) { ?>

komentáře k uživateli <? echo "$user_info_login" ?>
			<?	while($famerecord=MySQL_Fetch_array($fameresult)) { ?>
			<div>

				<? $fame_userid = getUserId($famerecord["login"]);?>

				<?
				//pokud se uzivatel da do ciziho infa, uvidi pouze komentare od pratel,
				//neuvidi vsak od koho jsou
				//if ($userid==$fuserid) {
				?>
				<a href="gate.php?m=11&s=1&fuserid=<? echo $fame_userid; ?>">
					<img src="ico/<? echo $famerecord["login"]; ?>.gif" alt="<? echo $famerecord["login"]; ?>" title="<? echo $famerecord["login"]; ?>">
				</a>
				<?
				//}
				?>

				<? echo $famerecord["note"]; ?>
			</div>
			<? } ?>
<? }else{ ?>
	k uživateli <? echo "$user_info_login" ?> nejsou žádné komentáře
<? } ?>
