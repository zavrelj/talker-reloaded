<div class="bookmark_content">


	<div class="bookmark_button">
	<? if ($booklist_type=="0") {//vlastni diskuze ?>
	<form name="destroyroom" method="post" action="gate.php?m=10&s=10">
		<input type="hidden" name="from_where" value="book">
		<input type="hidden" name="roomid" value="<? echo $bookid; ?>">
		<input name="destroy" type="submit" value="<? echo $LNG_BOOKMARKS_REMOVE; ?>" style="width:70;">
	</form>
	<? } ?>

	<? if ($booklist_type=="1") {//sledovane diskuze ?>
	<form method="post" action="gate.php?m=6">
		<input type="hidden" name="roomid" value="<? echo $bookid; ?>">
		<input type="submit" name="book" value="<? echo $LNG_BOOKMARKS_UNBOOK; ?>" style="width:70;">
	</form>
	<? } ?>
	</div>



	<div class="bookmark_link">
	<? if ($show_room_ico==0 && $room_icon!="") {?>
		<a href="gate.php?m=10&s=1&roomid=<?echo $bookid;?>&newnr=<? echo $count_new_one; ?>">
			<img src="<?echo $room_icon;?>" />
		</a>
	<? } ?>

	<a href="gate.php?m=10&s=1&roomid=<? echo $bookid;?>&newnr=<? echo $count_new_one; ?>">
		<? echo $room_name; ?>
	</a>

	<? if ($booklist_type=="1") {//sledovane diskuze ?>
	(<? echo $founder; ?>)
	<? } ?>

	|<?echo $topic_name;?>|[<? echo $room_count; ?>]
	<? if ($count_new_one != 0) { ?>
		<span class="alert">[<? echo $count_new_one; ?>]</span>
	<? } ?>

	<? if ($show_home==0 && $room_home != "") { ?>
		[<a href="gate.php?m=10&s=3&roomid=<? echo $bookid?>">homepage</a>]
	<? } ?>

	<? if ($show_pool==0 && $pool_roomid != -1) { ?>
		[<a href="gate.php?m=10&s=2&roomid=<? echo $pool_roomid?>">anketa</a>]
	<? } ?>
	</div>

</div>
