<form method="post" action="gate.php?m=10&s=1">
<label>zobrazit pouze příspěvky od uživatele:</label>
<input type="text" name="fusername">
<input type="hidden" name="roomid" value="<? echo $roomid ?>">
<input type="submit" name="fuser_show" value="<? echo $LNG_SHOW; ?>">
</form>
