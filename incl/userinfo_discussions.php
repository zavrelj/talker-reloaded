<strong>seznam diskuzí uživatele <? echo "$user_info_login" ?></strong>


<br /><br />

<? if($room_num_rows!=0) { ?>
<strong>vlastní diskuze</strong> <br />
			<?
			while($room_record=MySQL_Fetch_array($room_result)) {

				if($room_record["private"]!=1) {
			?>
					<a href="gate.php?m=10&s=1&roomid=<? echo $room_record["roomid"]; ?>">
						<? echo $room_record["name"]; ?>
					</a>
					[<? echo $room_record["count"]; ?>] <br />

			<?
				}
			}
			?>



<? }else{ ?>
uživatel <? echo "$user_info_login" ?> nemá žádné vlastní diskuze <br />
<? } ?>


<br /><br />


<? if($book_num_rows!=0) { ?>
<strong>sledované diskuze</strong> <br />
			<?
			while($book_record=MySQL_Fetch_array($book_result)) {

				if($book_record["private"]!=1) {
			?>
					<a href="gate.php?m=10&s=1&roomid=<? echo $book_record["roomid"]; ?>">
						<? echo $book_record["name"]; ?>
					</a>
					[<? echo getUserLogin($book_record["founderid"]); ?>]
					[<? echo $book_record["count"]; ?>] <br />
			<?
				}
			}
			?>


<? }else{ ?>
uživatel <? echo "$user_info_login" ?> nemá žádné sledované diskuze <br />
<? } ?>
