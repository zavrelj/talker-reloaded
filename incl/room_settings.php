<?
$privateArray = _oxQuery("SELECT private FROM $TABLE_ROOMS WHERE roomid='$roomid'");
$is_private = $privateArray["private"];
if ($is_private != 0) {
	$sess_out = updatelastaction($userid, "privátní diskuzi v nastavení");
}else{
	$sess_out = updatelastaction($userid, $roomid.";v nastavení");
}

$result=_oxResult("SELECT name, home_source, minihome_source, delown, allowrite, founderid, FK_topic, private, icon FROM $TABLE_ROOMS WHERE roomid=$roomid");
$record=mysql_fetch_array($result);
$roomname=$record["name"];

$homecontent_source=$record["home_source"];
$minihomecontent_source=$record["minihome_source"];

$delown=$record["delown"];
$allowrite=$record["allowrite"];
$private=$record["private"];
$topic_id=$record["FK_topic"];
$owner_id=$record["founderid"];
$icon_db=$record["icon"];
$ownername = getUserLogin($owner_id);




$auditor_result = _oxResult("SELECT founderid FROM $TABLE_ROOMS WHERE roomid=$roomid");
$auditor_record = mysql_fetch_array($auditor_result);
$auditor = $auditor_record["founderid"];


//VYGENEROVANI OBSAHU POLOZKY SPRAVCI
//vybere vsechny spravce dane diskuze
//do keeper_id vlozi vzdy cislo uzivatele-spravce
//do keeper_name vlozi jmeno uzivatele-spravce
//pokud neni textovy retezec prazdny, prida k jeho obsahu jmeno noveho spravce
//jinak bude v textovem retezci pouze jmeno tohoto spravce

//zkusi zjistit, zda prihlaseny uzivatel je spravcem, podle porovnani jmena spravce
//a jmena prihlaseneho uzivatele
//pokud je prihlaseny uzivatel spravcem, nastavi jeho cislo do allower

$keepers_result=_oxResult("SELECT keeper_id FROM $TABLE_ROOM_KEEPERS WHERE roomid=$roomid");
if (mysql_num_rows($keepers_result) != 0) {
	while($keepers_record=mysql_fetch_array($keepers_result)) {
		$keeper_id=$keepers_record["keeper_id"];
		$keeper_name=getUserLogin($keeper_id);
		if ($keepers!="") {
			$keepers=$keepers.", ".$keeper_name;
		}else{
			$keepers=$keeper_name;
		}



		$allower_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE login='$keeper_name' AND userid!=$owner_id");
		if (mysql_num_rows($allower_result) != 0) {
			$allower_record=mysql_fetch_array($allower_result);
			if ($allower_record["userid"] == $userid) {
				$allower=$userid;
			}
		}else{
			$allower=0;
		}

	}
}else{
	$keepers="";
	$allower=0;
}


//pokud je uzivatel vlastnikem diskuze, spravcem diskuze nebo spravcem systemu, zobrazi se mu nastaveni
if ($owner_id == $userid || $allower == $userid || $user_level== 5) {
	
            $deniers_result=_oxResult("SELECT denier_id FROM $TABLE_ROOM_DENIERS WHERE roomid=$roomid");
            if (mysql_num_rows($deniers_result) != 0) {
            	while($deniers_record=mysql_fetch_array($deniers_result)) {
            		$denier_id=$deniers_record["denier_id"];
            		if ($deniers!="") {
            			$deniers=$deniers.", ".getUserLogin($denier_id);
            		}else{
            			$deniers=getUserLogin($denier_id);
            		}
            	}
            }else{
            	$deniers="";
            }
            
            
            $banned_writers_result=_oxResult("SELECT banned_writer_id FROM $TABLE_ROOM_BANNED_WRITERS WHERE roomid=$roomid");
            if (mysql_num_rows($banned_writers_result) != 0) {
            	while($banned_writers_record=mysql_fetch_array($banned_writers_result)) {
            		$banned_writer_id=$banned_writers_record["banned_writer_id"];
            		if ($banned_writers!="") {
            			$banned_writers=$banned_writers.", ".getUserLogin($banned_writer_id);
            		}else{
            			$banned_writers=getUserLogin($banned_writer_id);
            		}
            	}
            }else{
            	$banned_writers="";
            }
            
            
            
            $pool_result=_oxResult("SELECT * FROM $TABLE_POOLS WHERE roomid=$roomid AND archive=0");
            
            $pool_num_rows=mysql_num_rows($pool_result);
            
            if ($pool_num_rows != 0) {
            
            	$pool_record=mysql_fetch_array($pool_result);
            	$question=$pool_record["question"];
            	$answs_text=$pool_record["answs_text"];
            	$answ01=$pool_record["answ01"];
            	$answ02=$pool_record["answ02"];
            	$answ03=$pool_record["answ03"];
            	$answ04=$pool_record["answ04"];
            	$answ05=$pool_record["answ05"];
            	$answ06=$pool_record["answ06"];
            	$answ07=$pool_record["answ07"];
            	$answ08=$pool_record["answ08"];
            	$answ09=$pool_record["answ09"];
            
            	$answ_arr = split("#", $answs_text);
            
            }
            ?>
            
            <!-- diky hodnote predane do o lze pohodlne nastavit, kam se bude stranka vracet
            muze se napriklad vratit do bulletinu (1) nebo zpet do nastaveni diskuze (3) //-->
            
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Změnit název diskuze</strong> <br />
            <label>nový název</label>
            <input type="text" name="newroomname" value="<? echo $roomname ?>" size="80" maxlength="200"> <br />
            <? if ($allower==null) { ?>
            <input type="checkbox" name="private" <? if ($private!=0) {echo 'checked="checked"';}?>>
            <label>privátní (nebude zobrazen v systému)</label> <br />
            <? } ?>
            <input type="hidden" name="roomid" value="<? echo $roomid ?>">
            <input type="submit" name="changename" value="změnit">
            </div>
            </form>
            
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Nastavit/Změnit heslo diskuze</strong> <br />
            <label>aktuální heslo</label>
            <input type="password" name="current_password" size="20" maxlength="20"> <br />
            <label>nové heslo</label>
            <input type="password" name="new_password" size="20" maxlength="20"> <br />
            <label>nové heslo znovu</label>
            <input type="password" name="new_password2" size="20" maxlength="20"> <br />
            <input type="hidden" name="roomid" value="<? echo $roomid ?>">
            <input type="submit" name="set_password" value="nastavit/změnit">
            </div>
            </form>
            
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Změnit kategorii</strong> <br />
            	<select id="change_category_select" name="change_category_select">
            	<?
            	//Podle poctu temat vygenerujeme radky
            	$topicsResult = _oxResult("SELECT PK_topic, topic_name FROM $TABLE_TOPICS ORDER BY topic_name ASC");
            
            	while($topicsArray = MySQL_Fetch_array($topicsResult)) {
            		$topic_number = $topicsArray['PK_topic'];
            		$topic_name = $topicsArray['topic_name'];
            	?>
            
            	<? if ($topic_id == $topic_number) {?>
            		<option value="<? echo $topic_number ?>" selected="selected"><? echo $topic_name; ?></option>
            	<?}else{?>
            		<option value="<? echo $topic_number ?>"><? echo $topic_name; ?></option>
            	<?}?>
            
            	<? } ?>
            	</select>
            	<input type="hidden" name="roomid" value="<? echo $roomid ?>">
            	<input type="submit" name="change_cat" value="změnit">
            </div>
            </form>
            
            
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Změnit ikonku diskuze</strong> <br />
            <label>URL adresa ikonky</label>
            <input type="text" name="icon" size="70" value="<? if($icon_db!="") {echo $icon_db;}else{echo "http://";} ?>">
            <input type="hidden" name="roomid" value="<? echo $roomid ?>">
            <input type="submit" name="seticon" value="změnit" class="button">
            </div>
            </form>
            
            <? //if ($allower==null) { DEPRECATED?>
            <? if ($owner_id == $userid || $user_level== 5) { ?>
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Změnit vlastníka diskuze</strong> <br />
            <label>nový vlastník</label>
            <input type="text" name="newownername" value="<? echo $ownername ?>" size="15" maxlength="15">
            <input type="hidden" name="roomid" value="<? echo $roomid ?>">
            <input type="submit" name="changeowner" value="změnit">
            </div>
            </form>
            <?}?>
            
            <? //if ($allower==null) { DEPRECATED?>
            <? if ($owner_id == $userid || $user_level== 5) { ?>
            <form method="post" action="gate.php?m=10&s=6">
            <div class="settings">
            <strong>Správci diskuze</strong> <br />
            zadejte jména oddělená čárkou (např. tirra, geekon, matejcik)<br />
            <label>jména</label>
            <input type="text" name="keepers" value="<? echo $keepers ?>" size="70">
            <input type="hidden" name="roomid" value="<? echo $roomid ?>">
            <input type="submit" name="setkeepers" value="nastavit">
            </div>
            </form>
            <? } ?>
            
            <? //if ($allower==null) { DEPRECATED?>
            <? if ($owner_id == $userid || $user_level== 5) { ?>
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Zakázat přístup</strong> <br />
            zadejte jména oddělená čárkou (např. tirra, geekon, matejcik)<br />
            <label>jména</label>
            <input type="text" name="deniers" value="<? echo $deniers ?>" size="70" />
            <input type="hidden" name="roomid" value="<? echo $roomid ?>" />
            <input type="submit" name="setdeniers" value="nastavit" />
            </div>
            </form>
            <? } ?>
            
            <? //if ($allower==null) { DEPRECATED?>
            <? if ($owner_id == $userid || $user_level== 5) { ?>
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Zakázat zápis</strong> <br />
            zadejte jména oddělená čárkou (např. tirra, geekon, matejcik)<br />
            <label>jména</label>
            <input type="text" name="banned_writers" value="<? echo $banned_writers ?>" size="70" />
            <input type="hidden" name="roomid" value="<? echo $roomid ?>" />
            <input type="submit" name="set_banned_writers" value="nastavit" />
            </div>
            </form>
            <? } ?>
            
            
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Nastavit uživatelská práva</strong> <br />
            <input type="checkbox" name="delown" value="true" <? if ($delown!=0) {echo 'checked="checked"';}?> />
            <label>povolit uživatelům mazání vlastních příspěvků</label><br />
            <input type="checkbox" name="allowrite" value="true" <? if ($allowrite!=0) {echo 'checked="checked"';}?> />
            <label>povolit uživatelům psaní příspěvků</label><br />
            <input type="hidden" name="roomid" value="<? echo $roomid ?>" />
            <input type="submit" name="changeallows" value="nastavit" />
            </div>
            </form>
            
            
            <form method="post" action="gate.php?m=10&s=2">
            <div class="settings">
            <strong>Vytvořit anketu diskuze</strong> <br />
            <input type="checkbox" name="anonym" />
            <label>anonymní (nebude zobrazeno kdo jak hlasoval)</label> <br />
            <label>otázka</label>
            <input type="text" name="question" value="<?echo $question ?>" size="60" maxlength="200" /> <br />
            <label>1. odpověď</label>
            <input type="text" name="answ01" value="<?echo $answ_arr[0] ?>" size="60" maxlength="100" /> <br />
            <label>2. odpověď</label>
            <input type="text" name="answ02" value="<?echo $answ_arr[1] ?>" size="60" maxlength="100" /> <br />
            <label>3. odpověď</label>
            <input type="text" name="answ03" value="<?echo $answ_arr[2] ?>" size="60" maxlength="100" /> <br />
            <label>4. odpověď</label>
            <input type="text" name="answ04" value="<?echo $answ_arr[3] ?>" size="60" maxlength="100" /> <br />
            <label>5. odpověď</label>
            <input type="text" name="answ05" value="<?echo $answ_arr[4] ?>" size="60" maxlength="100" /> <br />
            <label>6. odpověď</label>
            <input type="text" name="answ06" value="<?echo $answ_arr[5] ?>" size="60" maxlength="100" /> <br />
            <label>7. odpověď</label>
            <input type="text" name="answ07" value="<?echo $answ_arr[6] ?>" size="60" maxlength="100" /> <br />
            <label>8. odpověď</label>
            <input type="text" name="answ08" value="<?echo $answ_arr[7] ?>" size="60" maxlength="100" /> <br />
            <label>9. odpověď</label>
            <input type="text" name="answ09" value="<?echo $answ_arr[8] ?>" size="60" maxlength="100" /> <br />
            
            <? if ($pool_num_rows != 0) { ?>
            	<input type="hidden" name="roomid" value="<?echo $roomid?>" />
            	<input type="radio" name="destroy" value="del" checked="checked" />
            	<label>smazat současnou anketu</label>
            	<input type="radio" name="destroy" value="archive" />
            	<label>archivovat současnou anketu</label>
            <? } ?>
            
            <input type="hidden" name="roomid" value="<? echo $roomid ?>" />
            <input type="submit" name="create_pool" value="vytvořit" />
            </div>
            </form>
            
            
            <form method="post" action="gate.php?m=10&s=1">
            <div class="settings">
            <strong>Vytvořit mini homepage diskuze (zobrazí se přímo v diskuzi)</strong> <br />
            <textarea name="minihomecontent" rows="10" cols="100"><? echo "$minihomecontent_source"; ?></textarea><br />
            <input type="hidden" name="roomid" value="<? echo $roomid ?>" />
            <input type="submit" name="changeminihome" value="vytvořit" />
            </div>
            </form>
            
            
            <form method="post" action="gate.php?m=10&s=5">
            <div class="settings">
            <strong>Vytvořit homepage diskuze</strong> <br />
            <textarea name="homecontent" rows="20" cols="100"><? echo "$homecontent_source"; ?></textarea><br />
            <input type="hidden" name="roomid" value="<? echo $roomid ?>" />
            <input type="submit" name="changehome" value="vytvořit" />
            </div>
            </form>
            
<? }else{ ?>
<strong>Nemáte dostatečná práva pro vstup do nastavení této diskuze!</strong>
<? } ?>            
