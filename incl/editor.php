<?
//promenna edit_module obsahuje kod, ktery urcuje, do ktereho modulu je editor vkladan
//a podle toho odesila prislusna data
//0 - posta
//1 - diskuze
//2 - homepage
//3 - minihomepage
//4 - osobni stranka
?>



<div class="editor_input_area">
	<? /* naplneno aktualni hodnotou CSS pro pouziti v javascriptu */ ?>
      <input type="hidden" name="css" value="<? echo $css; ?>">

      <!-- RAW_PLAIN_TEXT //-->
	<? if ($editor == 0) { ?>

            <div>
                  <!--<a href="http://docs.oxyy.org/index.php/Seznam_speci%C3%A1ln%C3%ADch_znak%C5%AF" target="new"><? echo $LNG_EDITOR_HOWTO; ?></a>//-->
            </div>


		<? if ($edit_module == 0) { ?>
			<?
			if ($receiver==""){
			$receiver = "x";
			}
			?>

			<div>
			<? echo $LNG_EDITOR_RECEIVER; ?>
			<img name="messagetoico" src="ico/<? echo $receiver ?>.gif" />
			<label><? echo $LNG_EDITOR_TYPENAME; ?></label>
			<input type="text" name="formReceiverName" size="15" maxlength="15" value="<? if ($receiver == "x") { $receiver=""; } echo $receiver ?>" onChange="findUser();">

			<label><? echo $LNG_EDITOR_ORSELECTFRIEND; ?></label>
			<select name="selectfriend" onChange="changeIt();">
				<option name="friend" value="x">- - -</option>
				<?
				/* vyber vsechny lidi, ktere ma v pratelich zalogovany user */
				$friendresult = _oxResult("SELECT login FROM $TABLE_USERS, $TABLE_FRIENDS where $TABLE_USERS.userid=$TABLE_FRIENDS.friendid and $TABLE_FRIENDS.userid=$userid ORDER BY login ASC");

				while($friendrecord=MySQL_Fetch_array($friendresult)) {
					$friendname = $friendrecord["login"];
					?><option name="friend" value="<? echo "$friendname" ?>"><? echo "$friendname" ?></option><?
				}
				?>
			</select>
			</div>


			<div>
			<!-- EDITACNI OKNO //-->
			<textarea name="formMessageContent" rows="7" cols="95"><? if ($viewing==1) {echo stripslashes($uncheckedMessageContent); $viewing=0;}?></textarea>
			<!-- EDITACNI OKNO //-->
			</div>
		<? } ?>

		<? if ($edit_module == 1) { ?>
			<!-- EDITACNI OKNO //-->
			<? if ($allowritevalue != 1 && $userid != $auditor && $userid != $allower) { ?>
				<textarea name="formMessageContent" rows="7" cols="95" disabled="disabled">DISKUZE JE POUZE PRO ČTENÍ, VKLÁDAT PŘÍSPĚVKY MŮŽE POUZE VLASTNÍK</textarea>
			<? }elseif ($banned_wryiter == $userid && $userid != $auditor && $userid != $allower) { ?>
				<textarea name="formMessageContent" rows="7" cols="95" disabled="disabled">MÁTE ZÁKAZ ZÁPISU DO DISKUZE, KONTAKTUJTE VLASTNÍKA</textarea>
			<? }else{ ?>
				<textarea name="formMessageContent" rows="7" cols="95"><? if ($viewing==1) {echo stripslashes($uncheckedMessageContent); $viewing=0;}?></textarea>
			<? } ?>
			<!-- EDITACNI OKNO //-->
			<input type="hidden" name="roomid" value="<? echo $roomid ?>">
		<? } ?>

		<? if ($edit_module == 4) { ?>
			<? //echo "wrong_editor: ".$wrong_editor."<br>"; ?>
			<? if ($wrong_editor == 1) { ?>
				TEXT, který se pokouąíte editovat nebyl napsán v PLAINTEXT editoru, z tohoto důvodu není moľné text editovat.<br>
				POKUD chcete text editovat, musíte zvolit v NASTAVENÍ typ editoru WYSIWYG!
			<? }else{ ?>
				<textarea name="formMessageContent" rows="20" cols="100"><? echo stripslashes($uncheckedMessageContent); ?></textarea>
			<? } ?>
		<? } ?>
	<? } ?>
	<!-- RAW_PLAIN_TEXT //-->




	<!-- JS_PLAIN_TEXT //-->
	<? if ($editor == 1) { ?>
		<!-- JAVASCRIPT ENHANCEMENT//-->
		vloľit smile:
		<a href="#" onClick="smile(6);">
			<img src="../style/<?echo $css;?>/smile/01.png" alt="(úsměv)" />
		</a>
		<a href="#" onClick="smile(7);">
			<img src="../style/<?echo $css;?>/smile/02.png" alt="(vztek)" />
		</a>
		<a href="#" onClick="smile(8);">
			<img src="../style/<?echo $css;?>/smile/03.png" alt="(smutek)" />
		</a>
		<a href="#" onClick="smile(9);">
			<img src="../style/<?echo $css;?>/smile/04.png" alt="(polibek)" />
		</a>
		<a href="#" onClick="smile(10);">
			<img src="../style/<?echo $css;?>/smile/05.png" alt="(posměch)" />
		</a>
		<a href="#" onClick="smile(11);">
			<img src="../style/<?echo $css;?>/smile/06.png" alt="(údiv)" />
		</a>
		<a href="#" onClick="smile(12);">
			<img src="../style/<?echo $css;?>/smile/07.png" alt="(pláč)" />
		</a>
		<a href="#" onClick="smile(13);">
			<img src="../style/<?echo $css;?>/smile/08.png" alt="(stud)" />
		</a>
		<a href="#" onClick="smile(14);">
			<img src="../style/<?echo $css;?>/smile/09.png" alt="(zmatení)" />
		</a>
		<a href="#" onClick="smile(15);">
			<img src="../style/<?echo $css;?>/smile/10.png" alt="(smích)" />
		</a>
		<a href="#" onClick="smile(16);">
			<img src="../style/<?echo $css;?>/smile/11.png" alt="(ąibal)" />
		</a>

		<div>
			<label>číslo diskuze</label>
			<input type="text" name="jscript_room_id">
			<label>název</label>
			<input type="text" name="jscript_room_name">
			[<a href="#" onClick="tag(0)">vloľit diskuzi<noscript><? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>]
		</div>

		<div>
			<label>adresa</label>
			<input type="text" name="jscript_href" value="http://" onClick="javascript:this.form.jscript_href.focus();this.form.jscript_href.select();">
			<label>název</label>
			<input type="text" name="jscript_name">
			[<a href="#" onClick="tag(1)">vloľit odkaz<noscript><? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>]
		</div>

		<div>
			<label>adresa</label>
			<input type="text" name="jscript_src" value="http://" onClick="javascript:this.form.jscript_src.focus();this.form.jscript_src.select();">
			<label>text</label>
			<input type="text" name="jscript_alt">
			[<a href="#" onClick="tag(2)">vloľit obrázek<noscript><? echo $LNG_JAVASCRIPT_REQUIRED; ?></noscript></a>]
		</div>
		<!-- JAVASCRIPT ENHANCEMENT//-->


            <div>
                  <!--<a href="http://docs.oxyy.org/index.php/Seznam_speci%C3%A1ln%C3%ADch_znak%C5%AF" target="new"><? echo $LNG_EDITOR_HOWTO; ?></a>//-->
            </div>

            <? if ($edit_module == 0) { ?>
			<?
			if ($receiver==""){
				$receiver = "x";
			}
			?>
			<img name="messagetoico" src="ico/<? echo $receiver ?>.gif" width="40" height="50" class="icon2">
			<!-- EDITACNI OKNO //-->
			<textarea name="formMessageContent" rows="7" cols="95"><? if ($viewing==1) {echo stripslashes($uncheckedMessageContent); $viewing=0;}?></textarea>
			<!-- EDITACNI OKNO //-->
			<label>adresát:</label>
			<input type="text" name="formReceiverName" size="15" maxlength="15" value="<? if ($receiver == "x") { $receiver=""; } echo $receiver ?>" onChange="findUser();">
			<label>přítel:</label>
			<select name="selectfriend" onChange="changeIt();">
				<option name="friend" value="x">vyber</option>
				<?
				/* vyber vsechny lidi, ktere ma v pratelich zalogovany user */
				$friendresult = _oxResult("SELECT login FROM $TABLE_USERS, $TABLE_FRIENDS where $TABLE_USERS.userid=$TABLE_FRIENDS.friendid and $TABLE_FRIENDS.userid=$userid ORDER BY login ASC");
				while($friendrecord=MySQL_Fetch_array($friendresult)) {
					$friendname = $friendrecord["login"];
					?>
					<option name="friend" value="<? echo "$friendname" ?>"><? echo "$friendname" ?></option>
					<?
				}
				?>
			</select>
			<? } ?>

			<? if ($edit_module == 1) { ?>
				<!-- EDITACNI OKNO //-->
				<? if ($allowritevalue != 1 && $userid != $auditor && $userid != $allower) { ?>
					<textarea name="formMessageContent" rows="7" cols="95" class="editor_input" DISABLED>DISKUZE JE POUZE PRO ČTENÍ, VKLÁDAT PŘÍSPĚVKY MŮŽE POUZE VLASTNÍK</textarea>
				<? }elseif ($banned_wryiter == $userid && $userid != $auditor && $userid != $allower) { ?>
					<textarea name="formMessageContent" rows="7" cols="95" class="editor_input" DISABLED>MÁTE ZÁKAZ ZÁPISU DO DISKUZE, KONTAKTUJTE VLASTNÍKA</textarea>
				<? }else{ ?>
					<textarea name="formMessageContent" rows="7" cols="95" class="editor_input"><? if ($viewing==1) {echo stripslashes($uncheckedMessageContent); $viewing=0;}?></textarea>
				<? } ?>
				<!-- EDITACNI OKNO //-->
				<input type="hidden" name="roomid" value="<? echo $roomid ?>">
			<? } ?>

			<? if ($edit_module == 4) { ?>
				<? //echo "wrong_editor: ".$wrong_editor."<br>"; ?>
				<? if ($wrong_editor == 1) { ?>
					TEXT, který se pokou‘íte editovat nebyl napsán v PLAINTEXT editoru, z tohoto důvodu není možné text editovat.<br>
					POKUD chcete text editovat, musíte zvolit v NASTAVENÍ typ editoru WYSIWYG!
				<? }else{ ?>
					<textarea name="formMessageContent" rows="20" cols="100"><? echo stripslashes($uncheckedMessageContent); ?></textarea>
				<? } ?>
			<? } ?>
	<? } ?>
	<!-- JS_PLAIN_TEXT //-->


	<!-- WYSIWYG TinyMCE //-->
	<? if ($editor == 2) { ?>

		<!-- tinyMCE -->
                  <script language="javascript" type="text/javascript" src="plugins/tiny_mce/tiny_mce.js"></script>
                  <script language="javascript" type="text/javascript">
	           // Notice: The simple theme does not use all options some of them are limited to the advanced theme
                  tinyMCE.init({
                        mode : "textareas",
                        theme : "simple",
                        content_css : "/style/default/tinymce_content.css",
                        editor_css : "/style/default/tinymce_editor.css"

                  });
                  </script>
            <!-- /tinyMCE -->


		<? if ($edit_module == 0) {//posta ?>
			<?
			if ($receiver==""){
				$receiver = "x";
			}
			?>
			<img name="messagetoico" src="ico/<? echo $receiver ?>.gif" width="40" height="50" class="icon2">
			<? include('incl/editor_wysiwyg_tinymce.php'); ?>
			<label>adresát:</label>
			<input type="text" name="formReceiverName" size="15" maxlength="15" value="<? if ($receiver == "x") { $receiver=""; } echo $receiver ?>" onChange="findUser();">
			<label>přítel:</label>
			<select name="selectfriend" onChange="changeIt();">
				<option name="friend" value="x">- - -</option>
				<?
				/* vyber vsechny lidi, ktere ma v pratelich zalogovany user */
				$friendresult = _oxResult("SELECT login FROM $TABLE_USERS, $TABLE_FRIENDS where $TABLE_USERS.userid=$TABLE_FRIENDS.friendid and $TABLE_FRIENDS.userid=$userid ORDER BY login ASC");
				while($friendrecord=MySQL_Fetch_array($friendresult)) {
					$friendname = $friendrecord["login"];

					?>
					<option name="friend" value="<? echo "$friendname" ?>"><? echo "$friendname" ?></option>
					<?
				}
				?>
			</select>
		<? } ?>

		<? if ($edit_module == 1) {//diskuze ?>
			<? include('incl/editor_wysiwyg_tinymce.php'); ?>
		<? } ?>

		<? if ($edit_module == 4) {//osobni stranka ?>
			<? include('incl/editor_wysiwyg_tinymce.php'); ?>
		<? } ?>

	<? } ?>
	<!-- WYSIWYG TinyMCE//-->
</div>








<div class="editor_buttons_area">
	<? if ($edit_module == 0) {// POSTA ?>
	<input name="refresh" type="submit" value="<? echo $LNG_REFRESH; ?>" accesskey="r" title="pro aktualizaci stránky lze také pouľít ALT+R">
      <input name="send" type="submit" value="<? echo $LNG_SEND; ?>" accesskey="s" title="pro odeslání lze také pouľít ALT+S">
	<input name="preview" type="submit" value="<? echo $LNG_PREVIEW; ?>" accesskey="v" title="pro náhled lze také pouľít ALT+V">
	<!-- zajistuje fungovani pseudonavigace (uchovani aktualniho poctu)
	zobrazovanych prispevku i po odeslani noveho, ci nahledu //-->
	<!-- <input type="hidden" name="show_msgs_count" value="<? echo $rownum ?>"> //-->
	<? } ?>

	<? if ($edit_module == 1) {//DISKUZE ?>
		<? if ($allowritevalue != 1 && $userid != $auditor && $userid != $allower) { ?>
		! diskuze je pouze pro čtení !
		<? }elseif ($banned_wryiter == $userid && $userid != $auditor && $userid != $allower) { ?>
		! máte zákaz zápisu !
		<?}else{?>
		<input name="refresh" type="submit" value="<? echo $LNG_REFRESH; ?>" accesskey="r" title="pro aktualizaci stránky lze také pouľít ALT+R">
            <input name="send" type="submit" value="<? echo $LNG_SEND; ?>" accesskey="s" title="pro odeslání lze také pouľít ALT+S">
		<input name="preview" type="submit" value="<? echo $LNG_PREVIEW; ?>" accesskey="v" title="pro náhled lze také pouľít ALT+V">
		<!-- zajistuje fungovani pseudonavigace (uchovani aktualniho poctu)
		zobrazovanych prispevku i po odeslani noveho, ci nahledu //-->
		<!-- <input type="hidden" name="show_msgs_count" value="<? echo $rownum ?>"> //-->
		<? } ?>
	<? } ?>

	<? if ($edit_module == 4 && $wrong_editor != 1) {//OSOBNI STRANKA ?>
		<input type="hidden" name="fuserid" value="<?echo $userid?>">
		<input type="submit" name="changepage" value="upravit" class="button">
	<? } ?>
</div>
