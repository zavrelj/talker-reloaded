<?
$sess_out = updatelastaction($userid, $roomid.";odstranit");

//$destroy = $_POST['destroy'];

$result=_oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
$record=mysql_fetch_array($result);
$founderid=$record["founderid"];

if ($founderid == $userid || $user_level == 5) { 


            $result=_oxResult("SELECT name, count FROM $TABLE_ROOMS WHERE roomid=$roomid");
            $record=mysql_fetch_array($result);
            $roomname=$record["name"];
            $roomcount=$record["count"];
            
            
            $privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
            $is_private = $privateArray["private"];
            if ($is_private != 0) {
            	$sess_out = updatelastaction($userid, "privátní diskuzi v odstranění");
            }else{
            	$sess_out = updatelastaction($userid, $roomid.";v odstranění");
            }
            
            //updatelastaction($userid, $roomid.";odstranit");
            ?>
            
            
            ! POZOR !
            Opravdu chcete trvale odstranit diskuzi
            <? echo "$roomname" ?>,která obsahuje <? echo "$roomcount" ?>
            <? if ($roomcount==1) {?> příspěvek ?<? } if ($roomcount==2 or $roomcount==3 or $roomcount==4) {?> příspěvky ?<? } if ($roomcount>=5 or $roomcount==0) {?> příspěvků ? <? } ?>
            <form action="gate.php?m=6" method="post">
            	<input type="hidden" name="roomid" value="<? echo $roomid ?>">
            	<input type="submit" name="destroy" value="ano">
            </form>
            
            <? if ($from_where=="book") { ?>
            	<form action="gate.php?m=6" method="post">
            <? }else{ ?>
            	<form action="gate.php?m=10&s=1" method="post">
            <? } ?>
            	<input type="hidden" name="roomid" value="<? echo $roomid ?>">
            	<input type="submit" name="destroy" value="ne" class="button">
            	</form>
<? }else{ ?>
<strong>Nemáte dostatečná práva pro vstup do nastavení této diskuze!</strong>
<? } ?>            	

