<div id="message2" class="updated fade">
	<p>
		<a href="gate.php?m=2&s=1">
			<? if ($newnum==1) { ?>
				<? echo $LNG_COCKPIT_ONENEWMESSAGE; ?> <br /> (p�e V�m <? echo $messageFromName; ?>)
			<? } ?>

			<? if ($newnum >=2 && $newnum <=4) { ?>
				V po�t� m�te <? echo $newnum; ?> nep�e�ten� zpr�vy! <br /> (p�e V�m i <? echo $messageFromName; ?>)
			<? } ?>

			<? if ($newnum >=5) { ?>
				V po�t� m�te <? echo $newnum; ?> nep�e�ten�ch zpr�v! <br /> (p�e V�m tak� <? echo $messageFromName; ?>)
			<? } ?>
		</a>
	</p>
</div>

<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>


