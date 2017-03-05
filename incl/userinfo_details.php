<? if ($detail_info == 1) { ?>
detailní informace o uživateli <? echo "$user_info_infologin" ?>


	<? if ($user_info_name != "") { ?>
		<div><strong>jméno: </strong><? echo $user_info_name ?></div>
	<? } ?>

	<? if ($user_info_surname != "") { ?>
	<div><strong>příjmení: </strong><? echo $user_info_surname ?></div>
	<? } ?>

	<? if ($user_info_birth != "") { ?>
	<div><strong>datum narození: </strong><? echo $user_info_birth ?></div>
	<? } ?>

	<? if ($user_info_age != "") { ?>
	<div><strong>věk: </strong><? echo $user_info_age ?></div>
	<? } ?>

	<? if ($user_info_address != "") { ?>
	<div><strong>adresa: </strong><? echo $user_info_address ?></div>
	<? } ?>

	<? if ($user_info_phone != "") { ?>
	<div><strong>telefon: </strong><? echo $user_info_phone ?></div>
	<? } ?>

	<? if ($user_info_email != "") { ?>
	<div><strong>e-mail: </strong><a href="mailto:<?echo $user_info_email ?>"><? echo $user_info_email ?></a></div>
	<? } ?>

	<? if ($user_info_web != "") { ?>
	<div><strong>web: </strong><a href="<? echo $user_info_web ?>" target="new"><? echo $user_info_web ?></a></div>
	<? } ?>

	<? if ($user_info_icq != "") { ?>
	<div><strong>icq: </strong><? echo $user_info_icq ?><img src="http://status.icq.com/online.gif?icq=<? echo $user_info_icq ?>&img=9" /></div>
	<? } ?>

	<? if ($user_info_hobby != "") { ?>
	<div><strong>zájmy: </strong><? echo $user_info_hobby ?></div>
	<? } ?>

	<? if ($user_info_sex != "") { ?>
	<div><strong>pohlaví: </strong><? echo $user_info_sex ?></div>
	<? } ?>

	<? if ($user_info_single != "") { ?>
	<div><strong>svobodný/á: </strong><? echo $user_info_single ?></div>
	<? } ?>

	<? if ($user_info_height != "") { ?>
	<div><strong>výška: </strong><? echo $user_info_height ?></div>
	<? } ?>

	<? if ($user_info_weight != "") { ?>
	<div><strong>váha: </strong><? echo $user_info_weight ?></div>
	<? } ?>

	<? if ($user_info_eyes != "") { ?>
	<div><strong>oči: </strong><? echo $user_info_eyes ?></div>
	<? } ?>

	<? if ($user_info_hair != "") { ?>
	<div><strong>vlasy: </strong><? echo $user_info_hair ?></div>
	<? } ?>

<? }else{ ?>
<div>Uživatel <? echo "$user_info_login" ?> o sobě nenapsal žádné detailní informace</div>
<? } ?>


<? if ($fuserid==$userid) { ?>
<form method="post" action="gate.php?m=11&s=2">
	<div>
	<label>jméno</label>
	<input type="text" name="name" size="50" value="<? echo $user_info_name ?>">
	</div>

	<div>
	<label>příjmení</label>
	<input type="text" name="surname" size="50" value="<?echo $user_info_surname ?>">
	</div>

	<div>
	<label>datum narození</label>
	<input type="text" name="birth" size="50" class="input_form" value="<?echo $user_info_birth ?>">
	</div>

	<div>
	<label>věk</label>
	<input type="text" name="age" size="50" class="input_form" value="<?echo $user_info_age ?>">
	</div>

	<div>
	<label>adresa</label>
	<input type="text" name="address" size="50" class="input_form" value="<?echo $user_info_address ?>">
	</div>

	<div>
	<label>telefon</label>
	<input type="text" name="phone" size="50" class="input_form" value="<?echo $user_info_phone ?>">
	</div>

	<div>
	<label>e-mail</label>
	<input type="text" name="e_mail" size="50" class="input_form" value="<?echo $user_info_email ?>">
	</div>

	<div>
	<label>web</label>
	<input type="text" name="web" size="50" class="input_form" value="<?echo $user_info_web ?>">
	</div>

	<div>
	<label>icq</label>
	<input type="text" name="icq" size="50" class="input_form" value="<?echo $user_info_icq ?>">
	</div>

	<div>
	<label>zájmy</label>
	<input type="text" name="hobby" size="50" class="input_form" value="<?echo $user_info_hobby ?>">
	</div>

	<div>
	<label>pohlaví</label>
	<input type="text" name="sex" size="50" class="input_form" value="<?echo $user_info_sex ?>">
	</div>

	<div>
	<label>svobodný/á</label>
	<input type="text" name="single" size="50" class="input_form" value="<?echo $user_info_single ?>">
	</div>

	<div>
	<label>výška</label>
	<input type="text" name="height" size="50" class="input_form" value="<?echo $user_info_height ?>">
	</div>

	<div>
	<label>váha</label>
	<input type="text" name="weight" size="50" class="input_form" value="<?echo $user_info_weight ?>">
	</div>

	<div>
	<label>oči</label>
	<input type="text" name="eyes" size="50" class="input_form" value="<?echo $user_info_eyes ?>">
	</div>

	<div>
	<label>vlasy</label>
	<input type="text" name="hair" size="50" class="input_form" value="<?echo $user_info_hair ?>">
	</div>

	<div>
	<input type="submit" name="setdetails" value="nastavit" class="button">
	</div>

</form>
<? } ?>
