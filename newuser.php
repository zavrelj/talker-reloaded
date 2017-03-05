<?
if ($_SERVER['HTTP_HOST']=='talker2.net') {
  header("location: http://www.talker2.net/newuser.php");  
}

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");

session_start();
require('system.inc.php');

echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>  
  <meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title>DS | REGISTRACE</title>
      <link rel='stylesheet' type='text/css' media='all' href='style/index/index.css' />
      <link rel="Shortcut Icon" type="image/gif" href="favicon.ico">
      <!-- OVERLAY //-->
            <link rel="stylesheet" href="style/t2/overlay/lightbox.css" type="text/css" media="screen" />
            <script type="text/javascript" src="script/overlay/prototype.js"></script>
            <script type="text/javascript" src="script/overlay/lightbox.js"></script>
            <script type="text/javascript" src="script/overlay/warningoverlay.js"></script>
                        
            <script language="javascript" type="text/javascript">
            <!--
            	
                  var myGlobalHandlers = 
            	{
            		onCreate: function()
            		{
            			Element.show('systemWorking');
            			document.body.style.cursor = 'wait';
            		},
            		onComplete: function() 
            		{	
            			if(Ajax.activeRequestCount == 0)
            			{
            				Element.hide('systemWorking');
            				document.body.style.cursor = 'default';
            			}
            		},
            		onFailure: function() 
            		{
            			alert('Sorry. There was an error processing your request.');
            		}

            	};
            	
                       	
            	var currentBaseUrl = 'http://www.g3n.us/';
            //-->
            </script>
            <!-- OVERLAY //-->
</head>           

<body>
  <div id="topbar">
            <img src="imgs/ds_logo.png">		
		
		        <p id="welcome_note">
              Děkujeme za Váš zájem stát se členy diskuzního serveru DS!<br />
              Registrace do systému je velmi prostá. Níže prosím vyplňte požadované uživatelské jméno
              (upozorňujeme, že toto jméno musí mít délku minimálně tři znaky) a dále vyplňte dvakrát (to kvůli vyloučení možnosti překlepu) požadované heslo.<br />
              Heslo volte pokud možno takové, aby bylo těžko odhalitelné případným útočníkem. Zpravidla se doporučuje kombinace velkých a malých písmen a číslic.
              Rozhodně není vhodné používat jako heslo např. jméno Vaší přítelkyně nebo psa!<br />
              Uživatelské jméno volte vhodně, neboť ho již nelze, narozdíl od hesla, později změnit!<br />
              Přejeme příjemné zážitky!<br /><br />
               
            </p>  
            <div id="regin">
                  <form name="reginForm" method="post" action="regger.php">
        					<label><? echo $LNG_MAINPAGE_USERNAME_LABEL; ?></label>
                  <input name="regflogin" type="text" size="15" maxlength="15">
                  <label><? echo $LNG_MAINPAGE_PASSWORD_LABEL; ?></label>
				          <input name="regfpassword" type="password" size="15" maxlength="40">
                  <label><? echo $LNG_MAINPAGE_PASSWORD2_LABEL; ?></label>
                  <input name="reg2fpassword" type="password" size="15" maxlength="40">
                  <br /><br /><br /><br />
                  <input name="register" type="submit" id="register" value="<? echo $LNG_MAINPAGE_REGIN_SUBMIT; ?>">
                  </form>
            </div>      
		          		
		
		<?
		$note = $_GET["note"];
		if ($note != null){
			$note_text = _oxNoter($note);
			
			?>
                             <!-- <noscript> //-->
                             <div><br /><br /><br />UPOZORNĚNÍ: <? echo $note_text; ?></div>
                             <!-- </noscript> //-->
                             
                             <!--
                             <script language="javascript" type="text/javascript">
                             
                              showNewPlayerLightbox('<?echo $note; ?>');
                             
                             </script>
                             //-->
                                                          
                             
                  <? } ?>
                  
                  
                  
            
                              
                  

	</body>
</html>
