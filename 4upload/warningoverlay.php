<?
session_start();
require('system.inc.php');

$note = $_GET["note"];
if ($note != null){
      $note_text = _oxNoter($note);
}
?>
                             

<!--NoSubAllowed-->
<div id="detour">
	<a href="javascript:void(0)" class="lbAction" rel="deactivate" style="float:right">
		<img src="style/t2/overlay/detourCloseButton.gif" class="closeLightbox" alt="Close"/>
	</a>
      	
	<h1>UPOZORNĚNÍ</h1>
	
	<div id="enterTickerContainer" class="clearfix">
		<? echo $note_text; ?>
      </div>	
</div>
