<?
/*
$setstatus = $_POST['setstatus'];
$custom_status = $_POST['custom_status'];
*/

$setmenu = $_POST['setmenu'];
$custom_menu = $_POST['custom_menu'];

$setusrskin = $_POST['setusrskin'];
$skin_input = $_POST['skin_input'];

$setdefbg = $_POST['setdefbg'];
$bg_select = $_POST['bg_select'];

$setusrbg = $_POST['setusrbg'];
$userbg = $_POST['userbg'];

$setalert = $_POST['setalert'];
$mobil = $_POST['mobil'];
$email = $_POST['email'];

$setautologout = $_POST['setautologout'];
$autologout = $_POST['autologout'];

$setrownum = $_POST['setrownum'];
$rownum = $_POST['rownum'];

$setnet = $_POST['setnet'];
$address01 = $_POST['address01'];
$label01 = $_POST['label01'];
$address02 = $_POST['address02'];
$label02 = $_POST['label02'];
$address03 = $_POST['address03'];
$label03 = $_POST['label03'];
$address04 = $_POST['address04'];
$label04 = $_POST['label04'];
$address05 = $_POST['address05'];
$label05 = $_POST['label05'];

$seteditor = $_POST['seteditor'];
$custom_editor = $_POST['custom_editor'];

/*
$setlang = $_POST['setlang'];
$lang_select = $_POST['lang_select'];
*/

//A
//|
//|
//|
//to co je nad timto komentarem by se melo odehrat pred inkluzi headeru pro spravnou funkcnost!!!!!!!!!!!!!!!







if ($setusrskin == změnit && $skin_input !="" && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET css='$skin_input' WHERE userid='$userid'");
	?><script language="javascript">document.location="gate.php?m=5&s=1";</script> <?
}

if ($setdefbg == změnit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET bg='$bg_select' WHERE userid='$userid'");
	?><script language="javascript">document.location="gate.php?m=5&s=1";</script> <?
}

if ($setusrbg == změnit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET bg='$userbg' WHERE userid='$userid'");
	?><script language="javascript">document.location="gate.php?m=5&s=1";</script> <?
}

if ($setalert == nastavit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET mobil='$mobil', email='$email' WHERE userid='$userid'");
}

if ($setautologout == nastav && $db_passwd == $session_passwd) {
	//pokud je v promenne cislo, ktere je zaroven v danem rozsahu, zapis do DB
	//jinak neprovadej nic, v DB zustane posledni platne zadana hodnota
	if (is_numeric($autologout) && $autologout >= 300 && $autologout <= 1200) {
		_oxMod("UPDATE $TABLE_USERS SET autologout=$autologout WHERE userid='$userid'");
	}
}

if ($setrownum == nastav && $db_passwd == $session_passwd) {
	//pokud je v promenne cislo, ktere je zaroven kladne, zapis do DB
	//jinak neprovadej nic, v DB zustane posledni platne zadana hodnota
	if (is_numeric($rownum) && $rownum >= 1) {
		_oxMod("UPDATE $TABLE_USERS SET msgs=$rownum WHERE userid='$userid'");
	}
}

if ($setnet == nastavit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET address01='$address01', label01='$label01', address02='$address02', label02='$label02', address03='$address03', label03='$label03', address04='$address04', label04='$label04', address05='$address05', label05='$label05' WHERE userid=$userid");
}

/*
if ($setstatus == nastavit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET status='$custom_status' WHERE userid=$userid");
}
*/

if ($setmenu == nastavit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET menu='$custom_menu' WHERE userid=$userid");
}

if ($seteditor == nastavit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET editor='$custom_editor' WHERE userid=$userid");
}

if ($setaction_pannel == nastavit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET action_pannel='$action_pannel' WHERE userid=$userid");
}

/*
if ($setlang == změnit && $db_passwd == $session_passwd) {
	_oxMod("UPDATE $TABLE_USERS SET user_lang='$lang_select' WHERE userid=$userid");
}
*/


$result=_oxResult("SELECT regdate, AT, mobil, email, autologout, password, bg, css, msgs, address01, label01, address02, label02, address03, label03, address04, label04, address05, label05, status, menu, editor FROM $TABLE_USERS WHERE userid=$userid");
$record=mysql_fetch_array($result);
$timestampvalue = $record["regdate"];
$formatteddate = date("d.m.Y  H:i:s",$timestampvalue);
$countAT = $record["AT"];
$mobil_db = $record["mobil"];
$email_db = $record["email"];
$autologout_db = $record["autologout"];
$rownum_db = $record["msgs"];
$bg_db = $record["bg"];
$css_db = $record["css"];

$address01 = $record["address01"];
$label01 = $record["label01"];
$address02 = $record["address02"];
$label02 = $record["label02"];
$address03 = $record["address03"];
$label03 = $record["label03"];
$address04 = $record["address04"];
$label04 = $record["label04"];
$address05 = $record["address05"];
$label05 = $record["label05"];

$status = $record["status"];
$menu = $record["menu"];
$editor = $record["editor"];
$action_pannel = $record["action_pannel"];



/*
if ($changepasswd == změnit && $db_passwd == $session_passwd) {

	$passwd = $record["password"];
	$currentpasswd=substr(md5($currentpasswd), 0, 32);

	if ($currentpasswd == $passwd && $newpasswd == $newpasswdretype) {
		$newpasswd=md5($newpasswd);
		_oxMod("UPDATE $TABLE_USERS SET password='$newpasswd' WHERE userid='$userid'");
		$_GET['note'] = 401;
	}else{
		$_GET['note'] = 402;
	}
}
*/



?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>


<div class="settings_header">
<strong>nahrát ikonku</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje změnu ikonky</li>
	<li>maximální velikost ikonky je 5 kB, formát je gif, jpg, png</li>
	<li>rozměry ikonky by měly být šířka 40 bodů a výška 50 bodů, v opačném případě systém přizpůsobí velikost těmto hodnotám</li>
</ul>
<form method="post" action="gate.php?m=5&s=1" enctype="multipart/form-data">
<label>vyber ikonku</label>
<input type="file" name="userfile">
<input type="submit" name="upload" value="nahrát">
</form>
</div>





<div class="settings_header">
<strong>změnit heslo</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje změnu přihlašovacího hesla do systému</li>
	<li>je nutné zadat současné heslo a potom dvakrát po sobě heslo nové</li>
	<li>UPOZORNĚNÍ: hesla jsou kódována algoritmem, který neumožňuje zpětné dekódování, zapomenuté heslo tudíž nezjistí ani administrátor!</li>
</ul>
<form method="post" action="gate.php?m=5&s=1">
<label>současné heslo</label>
<input type="password" name="currentpasswd" size="20">
<label>nové heslo</label>
<input type="password" name="newpasswd" size="20">
<label>nové heslo znovu</label>
<input type="password" name="newpasswdretype" size="20">
<input type="submit" name="changepasswd" value="změnit">
</form>
</div>

<div class="settings_header">
<strong>nastavit odkazy</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje nastavit oblíbené stránky</li>
	<li>po kliknutí na jméno v rozbalovacím menu v horní části se vytvoří nové okno a v něm vaše oblíbená stránka</li>
	<li>odkazy se aktualizují až po druhém kliknutí na tlačítko nastavit</li>
</ul>
<form name="netform" method="post" action="gate.php?m=5&s=1">
<label>adresa</label>
<input type="text" name="address01" value="<?if ($address01 != "") {echo $address01;}else{echo "http://";}?>" size="30" maxlength="100">
<label>název</label>
<input type="text" name="label01" value="<?if ($label01 != "") {echo $label01;}?>" size="15" maxlength="40">
<br />
<label>adresa</label>
<input type="text" name="address02" value="<?if ($address02 != "") {echo $address02;}else{echo "http://";}?>" size="30" maxlength="100">
<label>název</label>
<input type="text" name="label02" value="<?if ($label02 != "") {echo $label02;}?>" size="15" maxlength="40">
<br />
<label>adresa</label>
<input type="text" name="address03" value="<?if ($address03 != "") {echo $address03;}else{echo "http://";}?>" size="30" maxlength="100">
<label>název</label>
<input type="text" name="label03" value="<?if ($label03 != "") {echo $label03;}?>" size="15" maxlength="40">
<br />
<label>adresa</label>
<input type="text" name="address04" value="<?if ($address04 != "") {echo $address04;}else{echo "http://";}?>" size="30" maxlength="100">
<label>název</label>
<input type="text" name="label04" value="<?if ($label04 != "") {echo $label04;}?>" size="15" maxlength="40">
<br />
<label>adresa</label>
<input type="text" name="address05" value="<?if ($address05 != "") {echo $address05;}else{echo "http://";}?>" size="30" maxlength="100">
<label>název</label>
<input type="text" name="label05" value="<?if ($label05 != "") {echo $label05;}?>" size="15" maxlength="40">
<br />
<input type="submit" name="setnet" value="nastavit">
</form>
</div>


<div class="settings_header">
<strong>nastavit vlastní status</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje nastavit vlastní status</li>
	<li>maximální délka vlastního statusu je 50 znaků</li>
</ul>
<form name="statusform" method="post" action="gate.php?m=5&s=1">
<label>status</label>
<input type="text" name="custom_status" value="<?if ($status != "") {echo $status;}?>" size="50" maxlength="50">
<input type="submit" name="setstatus" value="nastavit">
</form>
</div>


<div class="settings_header">
<strong>nastavit chování hlavního menu</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje nastavit preferované chování hlavního panelu</li>
	<li>jednou z možností je pevné umístění panelu úplně navrchu stránky</li>
	<li>druhou možností je pohyblivý panel, který se pohybuje se stránkou</li>
</ul>
<form name="menuform" method="post" action="gate.php?m=5&s=1">
<input type="radio" name="custom_menu" value="0" <?if ($menu == "0") {echo 'checked="checked"';}?>>
<label>pevné umístění</label>
<input type="radio" name="custom_menu" value="1" <?if ($menu == "1") {echo 'checked="checked"';}?>>
<label>pohyblivé umístění</label>
<input type="submit" name="setmenu" value="nastavit" style="width:70;">
</form>
</div>

<!--
<div class="settings">
<strong>nastavit způsob vkládání textu</strong>
<ul>
	<li>PLAINTEXT editor - čistý text bez podpory Javascriptu</li>
	<li>JAVASCRIPT editor - čistý text s podporou Javascriptu</li>
	<li>WYSIWYG editor - html editor</li>
	<li>v případě, že prohlížeč nepodporuje Javascript, bude automaticky nastaven PLAINTEXT editor</li>
</ul>
<form name="editorform" method="post" action="gate.php?m=5&s=1">
<input type="radio" name="custom_editor" value="0" <?if ($editor == "0") {echo 'checked="checked"';}?>>
<label>PLAINTEXT</label>
<input type="radio" name="custom_editor" value="1" <?if ($editor == "1") {echo 'checked="checked"';}?>>
<label>JAVASCRIPT</label>
<input type="radio" name="custom_editor" value="2" <?if ($editor == "2") {echo 'checked="checked"';}?>>
<label>WYSIWYG (TinyMCE)</label>
<input type="submit" name="seteditor" value="nastavit">
</form>
</div>
//-->

<div class="settings_header">
<strong>zasílat upozornění</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje zasílání upozornění na příchozí poątu</li>
	<li>upozornění je zasíláno volitelně na mobilní telefon formou sms zprávy, nebo na e-mail</li>
	<li>v případě zaslání pomocí sms nemusí přijít celá zpráva, ale pouze text o délce jedné sms zprávy</li>
	<li>pokud máte o zasílání zájem, vyplňte svůj e-mail, nebo číslo mobilního telefonu</li>
	<li>zasílání zrušíte vymazáním políček</li>
	<li>číslo mobilního telefonu zadávejte v následujících formátech:</li>
	<li>O2: +420606xxxxxx@sms.eurotel.cz</li>
	<li>T-MOBILE: +420604xxxxxx@sms.paegas.cz nebo jmeno@click.cz</li>
	<li>VODAFONE: jmeno@vodafonemail.cz</li>
	<li>
	Zprovoznění přeposílání emailové zprávy na Vodafone.
	Zprovozněte službu u operátora, to provedete následovně:
	1. Zvolte si uživatelské jméno (např. JOSEF).
	2. Pošlete SMS zprávu ve tvaru EMAILZAP UZIVATELSKEJMENO, tedy v našem případě EMAILZAP JOSEF na tel. číslo 2255.
	3. Operátor Vás bude obratem informovat o spuštění, nebo o nespuštění sluľby (podle toho, zda Vámi vybrané uživatelské
	jméno již existuje, nebo je volné).
	Do položky mobil vypište mailbox (v našem případě by se jednalo o josef@vodafonemail.cz).
	</li>
</ul>
<form name="alertform" method="post" action="gate.php?m=5&s=1">
<label>mobil</label>
<input type="text" name="mobil" value="<?echo $mobil_db?>" size="30">
<label>e-mail</label>
<input type="text" name="email" value="<?echo $email_db?>" size="30">
<input type="submit" name="setalert" value="nastavit">
</form>
</div>

<div class="settings_header">
<strong>automaticky odhlašovat</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje automatické odhlášení ze systému po zvolené době nečinnosti</li>
	<li>systém zruší vaši session (sezení) a nastaví vaši identitu jako odhlášenou</li>
	<li>pokud po uběhnutém časové úseku nečinnosti uděláte v sytému nějakou akci, budete přesměrováni na úvodní stránku</li>
	<li>dobu nečinnosti je třeba nastavit v sekundách</li>
	<li>minimum je 300 sekund, tj. 5 minut, maximum je 1200 sekund, tj. 20 minut</li>
</ul>
<form name="autologoutform" method="post" action="gate.php?m=5&s=1">

<label>nečinnost v sekundách (300-1200)</label>
<input type="text" name="autologout" value="<?echo $autologout_db?>" size="4">
<input type="hidden" name="setautologout" value="nastav">
<input type="button" onClick="checkAutoLgtValue();" value="nastavit">
</form>
</div>


<div class="settings_header">
<strong>počet zobrazovaných řádků</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje nastavit preferovaný počet zobrazovaných řádku, tj. počet zpráv v poště a počet příspěvků v diskuzích a v živě</li>
	<li>lze zadat pouze kladná čísla v rozsahu od 1 do 127</li>
</ul>
<form name="rownumform" method="post" action="gate.php?m=5&s=1">
<label>počet řádků (1-127)</label>
<input type="text" name="rownum" value="<?echo $rownum_db?>" size="4">
<input type="hidden" name="setrownum" value="nastav">
<input type="button" onClick="checkRowNumValue();" value="nastavit">
</form>
</div>


<!--
<div class="settings">
<strong>změnit vzhled</strong>
<ul>
	<li>umoľňuje kompletní změnu vzhledu systému pro konkrétního uľivatele</li>
	<li>zvolte poľadovaný vzhled a potvrďte, pokud se změna neprojeví ihned, udělejte jeątě alespoň jednu akci (přejděte do jiného modulu)</li>
	<li>nabídka vzhledů je zatím omezená, ale do budoucna se jistě roząíří</li>
	<li>pokud máte zájem vytvořit si vlastní vzhled, poľádejte administrátora systému o zpřístupnění definice vzhledů a následnou modifikací této definice vytvořte vlastní vzhled</li>
	<li>vytvořený vzhled nahrajte</li>
	<li>UPOZORNĚNÍ: v definici vzhledů neměňte zavedené názvy proměnných, pouze hodnoty! V opačném případě můľe dojít k selhání zobrazování systémových prvků</li>
</ul>


<form method="post" action="gate.php?m=5&s=1" enctype="multipart/form-data">
      <label>zadej adresu vlastního skinu (např. http://www.mujweb.cz/mujskin.css)</label>
      <input type="text" name="skin_input" value="<? if($css_db!="") {echo $css_db;}else{echo "http://";} ?>">
      <input type="submit" name="setusrskin" value="změnit">
</form>

NEBO

<form method="post" action="gate.php?m=5&s=1" enctype="multipart/form-data">
<label>vyber vzhled z nabídky systému</label>
<select name="skin_select">
	<option name="defskin" value="default">DEFAULT</option>
	<option name="defskin" value="dark">DARK</option>
	<?
      /*
      <option name="defskin" value="chemois">CHEMOIS</option>
	<option name="defskin" value="veerle">VEERLE</option>
	<option name="defskin" value="mini">MINI</option>
	<option name="defskin" value="blue">BLUE</option>
	<option name="defskin" value="green">GREEN</option>
	*/
      ?>
</select>
<input type="submit" name="setdefskin" value="změnit">
</form>
</div>


<?
/*
<div class="settings">
<strong>změnit pozadí</strong>
<form method="post" action="settings.php?m=5">
<label>z internetu</label>
<input type="text" name="userbg" size="20" value="<? if($bg_db!="") {echo $bg_db;}else{echo "http://";} ?>">
<input type="submit" name="setusrbg" value="změnit">
</form>

<form method="post" action="settings.php?m=5" enctype="multipart/form-data">
vyber pozadí
<select name="bg_select">
	<option name="defbg" value="">žádné</option>
	<option name="defbg" value="style/bgs/default.gif">DEFAULT</option>
</select>
<input type="submit" name="setdefbg" value="změnit" class="button" style="width:70;">
</form>
</div>
*/
?>

//-->


<div class="settings_header">
<strong>změnit jazyk</strong>
</div>
<div class="settings_content">
<ul>
	<li>umožňuje výběr jazyka, ve kterém bude zobrazováno rozhraní systému</li>
</ul>
<form method="post" action="gate.php?m=5&s=1">
<label>vyber jazyk</label>
<select name="lang_select">
	<option name="deflang" value="en">english</option>
	<option name="deflang" value="cz">čeština</option>
</select>
<input type="submit" name="setlang" value="změnit">
</form>
</div>
