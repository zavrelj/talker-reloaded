<div class="message_left">
	<? //include('incl/message_user_icon.php'); ?>
</div>
<div class="message_right">
	<div class="message_header">
	    <? if ($module_number == 2) { ?>
			   <strong>náhled zprávy</strong>	
			<? } ?>
			<? if ($module_number == 10) { ?>
			   <strong>náhled příspěvku</strong>	
			<? } ?>
       
	</div>
	<div class="message_content"><? echo $parsedMessageContent; ?></div>
</div>
