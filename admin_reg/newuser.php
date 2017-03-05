<?
session_start();
require('../system.inc.php');
?>

<html>
      <meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title>TALKER2 | REGISTRACE</title>
      <link rel='stylesheet' type='text/css' media='all' href='../style/index/index.css' />
      <script language="javascript" src="../script/sifr.js"></script>
      <link rel="Shortcut Icon" type="../image/gif" href="favicon.ico">
	<head>
		<title>Registrace</title>
	</head>

	<body>
		<!-- REGIN WINDOW //-->
		<form name="reginForm" method="post" action="admin_regger.php">
        	
				<h3>Registrace nového uživatele</h3>

				<label>jméno</label>
				<input name="regflogin" type="text" size="15" maxlength="15">
                        
				<label>heslo</label>
				<input name="regfpassword" type="password" size="15" maxlength="40">
                        
				<label>heslo</label>
				<input name="reg2fpassword" type="password" size="15" maxlength="40">
                              
				<input name="register" type="submit" value="register!">
			
		</form>
		<!-- REGIN WINDOW //-->

		<?
		$note = $_GET["note"];
		if ($note != null){
			$note_text = _oxNoter($note);
			echo $note_text;
		}
		?>

	</body>
</html>
