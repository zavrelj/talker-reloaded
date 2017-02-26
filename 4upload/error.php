<?
//session_start();
//include('system.inc.php');
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>TALKER2 - CHYBA</title>
		<link rel=stylesheet href="style/index/index.css" type="text/css">
		<script language="javascript" src="script.js"></script>
	</head>

	<body>
		<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">

			<!-- radek pro header content //-->
			<!--
			<tr>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td><img src="sys_imgs/sys_logo_left.gif" width="324px" height="108px"></td>
							<td width="100%" height="108px"><img src="sys_imgs/sys_logo_mid.gif" width="100%" height="108px"></td>
							<td><img src="sys_imgs/sys_logo_right.gif" width="177px" height="108px"></td>
						</tr>
					</table>
				</td>
			</tr>
			//-->
			<!-- radek pro header content //-->


			<!-- zacatek struktury stredni casti //-->

			<tr>
				<td align="center" valign="top">
					<table border="0" class="table_border" width="800px">
        	       		<tr>
							<td class="article_header" colspan="2" align="center">
								<h1>TALKER2 | CHYBA SYSTÉMU</h1>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td align="center">
								<font class="article_header">

											<?
											if ($_GET[err_no]==101) {
												echo "Systém se nemůže spojit s databázovým serverem, pravděpodobně došlo k výpadku.<br> Byla zaslána informace administrátorovi, který co nejdříve uvede vše do pořádku.";
												//mail("+420721882706@sms.eurotel.cz", "talker2 | chyba systemu", "vypadek databaze, check log file!");
											}

											if ($_GET[err_no]== 201) {
												echo "uživatel neexistuje";
											}

											if ($_GET[err_no]== 202) {
												echo "špatné heslo";
											}

											if ($_GET[err_no]== 203) {
												echo "uživatelské heslo nesplňuje požadované parametry: heslo musí mít minimálně 3 a maximálně 20 znaků, není povolena diakritika";
											}

											if ($_GET[err_no]== 204) {
												echo "došlo k pokusu o neautorizovaný přístup do systému";
											}

											if ($_GET[err_no]== 301) {
												echo "uživatel tohoto jména je již zaregistrován";
											}

											if ($_GET[err_no]== 302) {
												echo "hesla si neodpovidají, je třeba zadat dvakrát stejné heslo";
											}

											if ($_GET[err_no]== 303) {
												echo "heslo musí mít 3-20 znaků anglické abecedy volitelně podtržítko, diakritika není povolena";
											}

											if ($_GET[err_no]== 401) {
												echo "vaše sezení vypršelo, 20 minut jste nepracovali se systémem a byli jste z bezpečnostních důvodů odhlášeni, musíte se znovu přihlásit";
											}

											if ($_GET[err_no]== 801) {
												echo "Vše proběhlo OK";
											}
											if ($_GET[err_no]== 901) {
												echo "Výsledek dotazu je prázdný...";
											}
											?>

								</font>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td colspan="2" align="center">
								<a href="index.php">zpět na úvodní stránku</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	</table>
</html>
