<? echo $LNG_TOPICS_SEARCH_DISCUSSION; ?>

			<form method="post" action="gate.php?m=3&s=1">
			<label><? echo $LNG_TOPICS_DISCUSSION_NAME; ?></label>
			<input type="text" name="roomname" size="60" maxlength="200">
			<label><? echo $LNG_TOPICS_DISCUSSION_CATEGORY; ?></label>
			<select name="selectbox">
				<option value="a">všechny</option>
            	<?
				//Podle poctu temat vygenerujeme radky
				$topicsResult = _oxResult("SELECT PK_topic, topic_name FROM $TABLE_TOPICS ORDER BY topic_name ASC");

				while($topicsArray = MySQL_Fetch_array($topicsResult)) {
					$topic_number = $topicsArray['PK_topic'];
					$topic_name = $topicsArray['topic_name'];
				?>

					<? if ($topic_id == $topic_number) {?>
						<option value="<? echo $topic_number ?>" SELECTED><? echo $topic_name; ?></option>
					<?}else{?>
						<option value="<? echo $topic_number ?>"><? echo $topic_name; ?></option>
					<?}?>

				<? } ?>
            </select>
			<input type="submit" name="search" value="vyhledat">
			</form>

