	<table border="0">
		<tr>
			<td>
				<noscript>
					seznam pou�iteln�ch k�d�:
					1. [url][/url] pro vlo�en� odkazu<br>
					2. [img][/img] pro vlo�en� obr�zku<br>
					3. [u][/u] pro vlo�en� podtr�en�ho textu

					<? if ($edit_module == 0) { ?>
						<!-- Puvodne dochazelo po zobrazeni nahledu k vymazani viewingu ($viewing=0),
						coz se ale provedlo i pokud je Javascript zapnuty a proto nasledne nefugnoval
						nahled v kodu nize, proto bylo vymazavani viewingu odstraneno, hodnota bude
						stejne vynulovana pri zacatku behu skriptu - doufam... //-->
						<textarea name="message_content" rows="7" cols="95"><? if ($preview==$LNG_PREVIEW || $refresh== $LNG_REFRESH) {echo stripslashes($uncheckedMessageContent); }?></textarea>
					<? } ?>
					<? if ($edit_module == 1) { ?>
                        <!-- EDITACNI OKNO //-->
						<? if ($allowritevalue != 1 && $userid != $auditor && $userid != $allower) { ?>
							<textarea name="formMessageContent" rows="7" cols="95" class="editor_input" DISABLED>DISKUZE JE POUZE PRO �TEN�, VKL�DAT P��SP�VKY MَE POUZE VLASTN�K</textarea>
						<? }elseif ($banned_wryiter == $userid && $userid != $auditor && $userid != $allower) { ?>
							<textarea name="formMessageContent" rows="7" cols="95" class="editor_input" DISABLED>M�TE Z�KAZ Z�PISU DO DISKUZE, KONTAKTUJTE VLASTN�KA</textarea>
						<? }else{ ?>
							<textarea name="formMessageContent" rows="7" cols="95" class="editor_input"><? if ($preview==$LNG_PREVIEW || $refresh== $LNG_REFRESH) {echo stripslashes($uncheckedMessageContent);}?></textarea>
						<? } ?>
						<!-- EDITACNI OKNO //-->
					<? } ?>
				</noscript>
			</td>
		</tr>

		<tr>
			<td>

				<? if ($edit_module == 0) { ?>
					<textarea name="formMessageContent" rows="7" cols="95"><? if ($viewing==1) {echo stripslashes($uncheckedMessageContent); }?></textarea>
				<? } ?>
				<? if ($edit_module == 1) { ?>
					<!-- EDITACNI OKNO //-->
					<? if ($allowritevalue != 1 && $userid != $auditor && $userid != $allower) { ?>
						<textarea name="formMessageContent" rows="7" cols="95" class="editor_input" DISABLED>DISKUZE JE POUZE PRO �TEN�, VKL�DAT P��SP�VKY MَE POUZE VLASTN�K</textarea>
					<? }elseif ($banned_wryiter == $userid && $userid != $auditor && $userid != $allower) { ?>
						<textarea name="formMessageContent" rows="7" cols="95" class="editor_input" DISABLED>M�TE Z�KAZ Z�PISU DO DISKUZE, KONTAKTUJTE VLASTN�KA</textarea>
					<? }else{ ?>
						<textarea name="formMessageContent" rows="7" cols="95" class="editor_input"><? if ($preview==$LNG_PREVIEW || $refresh== $LNG_REFRESH) {echo stripslashes($uncheckedMessageContent);}?></textarea>
					<? } ?>
					<!-- EDITACNI OKNO //-->
				<? } ?>
				<? if ($edit_module == 4) { ?>

					<? //echo "wrong_editor: ".$wrong_editor."<br>"; ?>
					<? if ($wrong_editor == 1) { ?>
						TEXT, kter� se pokous�te editovat nebyl naps�n ve WYSIWYG editoru, z tohoto d�vodu nen� mo�n� text editovat.<br>
						POKUD chcete text editovat, mus�te zvolit v NASTAVEN� typ editoru PLAINTEXT!
					<? }else{ ?>
						<textarea name="formMessageContent" rows="20" cols="100"><? echo stripslashes($uncheckedMessageContent); ?></textarea>
					<? } ?>

				<? } ?>
				<input type="hidden" name="roomid" value="<? echo $roomid ?>">
			</td>
		</tr>
	</table>
