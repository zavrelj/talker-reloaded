<? if ($parsedMessageContent != "") { ?>
NÁHLED OSOBNÍ STRÁNKY
<? echo stripslashes($parsedMessageContent); ?>
<? }else{ ?>
UŽIVATEL DOSUD NEVYTVOŘIL OBSAH <br />
------------------------------- <br />
<? } ?>


<? if ($fuserid==$userid) { ?>
		<form name="postform" method="post" action="gate.php?m=11&s=6">
		EDITACE OSOBNÍ STRÁNKY
		<?
		$edit_module=4;
		//echo "EDITOR:".$editor;
		include('incl/editor.php');
		?>
		</form>
<? } ?>



