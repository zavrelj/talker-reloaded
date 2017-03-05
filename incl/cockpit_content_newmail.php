<div id="message2" class="updated fade">
	<p>
		<a href="gate.php?m=2&s=1">
			<? if ($newnum==1) { ?>
				<? echo $LNG_COCKPIT_ONENEWMESSAGE; ?> <br /> (pí¹e Vám <? echo $messageFromName; ?>)
			<? } ?>

			<? if ($newnum >=2 && $newnum <=4) { ?>
				V po¹tì máte <? echo $newnum; ?> nepøeètené zprávy! <br /> (pí¹e Vám i <? echo $messageFromName; ?>)
			<? } ?>

			<? if ($newnum >=5) { ?>
				V po¹tì máte <? echo $newnum; ?> nepøeètených zpráv! <br /> (pí¹e Vám také <? echo $messageFromName; ?>)
			<? } ?>
		</a>
	</p>
</div>

<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>


