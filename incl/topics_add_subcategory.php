<? echo $LNG_TOPICS_ADD_SUBCATEGORY; ?>

			<form method="post" action="gate.php?m=3&s=1">
			<label>název subkategorie</label>
			<input type="text" name="subcategory_name" size="60" maxlength="200">
			<label><? echo $LNG_TOPICS_DISCUSSION_CATEGORY; ?></label>
			
                  <select id="add_subcategory_select" name="add_subcategory_select">
				<option value="a">vyber kategorii</option>
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
              
			<input type="submit" name="add_subcategory" value="přidat">
			</form>

