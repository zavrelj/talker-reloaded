<?
//zjistim si, kolik je aktualne v systemu temat
$topicsCountArray = _oxQuery("SELECT COUNT(PK_topic) as topics_count FROM $TABLE_TOPICS");
$topicsCount = $topicsCountArray['topics_count'] ;
//echo $topicsCount;

$topic_id = $_GET['topic_id'];

if ($topic_id == null || $topic_id >= $topicsCount) {
	$topic_id = 0;
}

$subtopic_id = $_GET['subtopic_id'];

if ($subtopic_id == null) {
	$subtopic_id=0;
}

?>

<form method="post" name="create_discussion_form" action="gate.php?m=10&s=1">

<div>
	<label>Název diskuze</label>
	<input type="text" name="cr_roomname" size="80" maxlength="200" class="input_form">
	<input type="checkbox" name="cr_private">privátní (nebude zobrazena v seznamu diskuzí)
</div>

<div>
	<label>Kategorie diskuze</label>
	
      
      <!-- pokud byla zvolena konkretni kategorie, nedam uz na vyber jine, dulezite kvuli podkategoriim //-->
      <? if ($topic_id != null && $topic_id < $topicsCount) {?>
            <? $topic_name=getTopicName($topic_id); ?>
            <? echo $topic_name; ?>
            <input type="hidden" name="create_category_select" value="<? echo $topic_id?>">
      <? }else{ ?>
            <select id="create_category_select" name="create_category_select" onChange="javascript:location='gate.php?m=3&s=2&topic_id='+document.create_discussion_form.create_category_select.options[document.create_discussion_form.create_category_select.selectedIndex].value;" class="cockpit_window_select">
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
      		      <? } ?>
      		
      
      	<? } ?>
      	</select>
      	
      <? } ?>	
	
	
	
</div>

<!-- pokud je lvl5, zpristupnim editaci //-->
<? if ($user_level==5) { ?>
<div>
	<label>Subkategorie diskuze</label>
	
      <? if ($subtopic_id != null) {?>
            <? $subtopic_name=getSubTopicName($subtopic_id); ?>
            <? echo $subtopic_name; ?>
            <input type="hidden" name="create_subcategory_select" value="<? echo $subtopic_id?>">
      <? }else{ ?>      
            <? if ($topic_id == null || $topic_id >= $topicsCount) { ?>
                  <select id="create_subcategory_select" name="create_subcategory_select" disabled="disabled"></noscript>
            <? }else{ ?>
                  <select id="create_subcategory_select" name="create_subcategory_select">
            <? } ?>      
      	
            <?
      	//Podle poctu temat vygenerujeme radky
      	$subtopicsResult = _oxResult("SELECT PK_subtopic, subtopic_name FROM $TABLE_SUBTOPICS WHERE FK_topic=$topic_id ORDER BY subtopic_name ASC");
      
      	while($subtopicsArray = MySQL_Fetch_array($subtopicsResult)) {
      		$subtopic_number = $subtopicsArray['PK_subtopic'];
      		$subtopic_name = $subtopicsArray['subtopic_name'];
      	?>
      
      		<? if ($subtopic_id == $subtopic_number) {?>
      			<option value="<? echo $subtopic_number ?>" SELECTED><? echo $subtopic_name; ?></option>
      		<?}else{?>
      			<option value="<? echo $subtopic_number ?>"><? echo $subtopic_name; ?></option>
      		<?}?>
      
      	<? } ?>
      	</select>
      
      <? } ?>	
</div>
<? } ?>

<div>
	<label>heslo pro přístup do diskuze</label>
	<input type="password" name="cr_new_password" size="20" maxlength="20">
	<label>heslo pro přístup do diskuze znovu</label>
	<input type="password" name="cr_new_password2" size="20" maxlength="20">
</div>

<div>
	<label>Správci diskuze, zadejte jména oddělená čárkou (např. tirra, geekon, matejcik)</label><br />
	<input type="text" name="cr_keepers" size="60" class="input_form">
</div>

<div>
	<label>Zakázat přístup, zadejte jména oddělená čárkou (např. tirra, geekon, matejcik)</label><br />
	<input type="text" name="cr_deniers" size="60" class="input_form">
</div>

<div>
	<label>Zakázat zápis, zadejte jména oddělená čárkou (např. tirra, geekon, matejcik)</label><br />
	<input type="text" name="cr_banned_writers" size="60" class="input_form">
</div>

<div>
	<fieldset>
		<legend>Uživatelská práva</legend>
		<input type="checkbox" name="cr_delown" value="true" CHECKED>
		<label>povolit uživatelům mazání vlastních příspěvků</label><br />
		<input type="checkbox" name="cr_allowrite" value="true" CHECKED>
		<label>povolit uživatelům psaní příspěvků</label><br />
	</fieldset>
</div>

<div>
	<fieldset>
		<legend>Anketa diskuze</legend>
		<input type="checkbox" name="anonym">
		<label>anonymní (nebude zobrazeno kdo jak hlasoval)</label><br />
		
            <label for="cr_question">otázka</label>
		<input type="text" name="cr_question" id="cr_question" size="60" maxlength="200"><br />
		<label>1. odpověď</label>
		<input type="text" name="cr_answ01" size="60" maxlength="100"><br />
		<label>2. odpověď</label>
		<input type="text" name="cr_answ02" size="60" maxlength="100"><br />
		<label>3. odpověď</label>
		<input type="text" name="cr_answ03" size="60" maxlength="100"><br />
		<label>4. odpověď</label>
		<input type="text" name="cr_answ04" size="60" maxlength="100"><br />
		<label>5. odpověď</label>
		<input type="text" name="cr_answ05" size="60" maxlength="100"><br />
		<label>6. odpověď</label>
		<input type="text" name="cr_answ06" size="60" maxlength="100"><br />
		<label>7. odpověď</label>
		<input type="text" name="cr_answ07" size="60" maxlength="100"><br />
		<label>8. odpověď</label>
		<input type="text" name="cr_answ08" size="60" maxlength="100"><br />
		<label>9. odpověď</label>
		<input type="text" name="cr_answ09" size="60" maxlength="100"><br />
	</fieldset>
</div>

<div>
	<fieldset>
		<legend>Mini homepage diskuze</legend>
		<textarea name="cr_minihomecontent" rows="10" cols="100"></textarea>
	</fieldset>
</div>

<div>
	<fieldset>
		<legend>Homepage diskuze</legend>
		<textarea name="cr_homecontent" rows="20" cols="100"></textarea>
	</fieldset>
</div>

<div>
	<input type="submit" name="create_room" value="<? echo $LNG_DISCUSSION_CREATE; ?>">
</div>

</form>



