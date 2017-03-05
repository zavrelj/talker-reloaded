<?
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");

session_start();
require('system.inc.php');


$timecr = time() + $SUMMER_TIME;

$active_result=_oxResult("SELECT userid FROM $TABLE_USERS WHERE active=1");
$active_count=mysql_num_rows($active_result);

$all_result=_oxResult("SELECT userid FROM $TABLE_USERS");
$all_count=mysql_num_rows($all_result);

$result=_oxResult("SELECT COUNT(roomid) as rooms_num FROM $TABLE_ROOMS");
$record=mysql_fetch_array($result);
$rooms=$record["rooms_num"];

$result=_oxResult("SELECT lastaccess FROM $TABLE_USERS ORDER BY lastaccess DESC LIMIT 0,1");
$record=mysql_fetch_array($result);
$last_act=$record["lastaccess"];
$last_act = date("d.m.Y, H:i:s", $last_act);

//check out browser type
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
   echo '<h1>INTERNET EXPLORER NENÍ PODPOROVÁN!</h1>';
   echo '<p>TALKER2 je v současné době optimalizován pro <a href="http://www.getfirefox.com">Firefox</a>.</p>';
   echo '<p>TALKER2 lze v případě nutnosti používat i s IE, přesto doporučuji pro plné využití všech možností systému právě Firefox.</p>';
}
 

//$main_style=rand(1, 3);
//echo "this is something new";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="<? echo $timecr ?>">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title><? echo "$TITLE_NAME" ?></title>
      <link rel='stylesheet' type='text/css' media='all' href='style/index/index55.css' />
      <script language="javascript" src="script/sifr.js"></script>
      <link rel="Shortcut Icon" type="image/gif" href="favicon.ico">
</head>

<body>
	<div id="topbar">
            <img src="imgs/t2_logo.png">
  </div>
	<?/* <div class="secondbar"></div> */?>

	<div id="wrapper">

            <div id="header">
		
		</div>

		<div id="content">

			<div id="blog">
				<div class="entry">
					<h2 class="title">Vítejte!</h2>
             <p>
                Tady by se měl jednou objevit nějaký nadšený uvítací text.
                Some things just can not die! <br />
                We're BACK! <br />
                TALKER2                    
             </p>
         </div>
    	</div>

			
      <div id="sidebar">
				<?
				 $note = $_GET["note"];
				 if ($note != null){
				     $note_text = _oxNoter($note);
				?>
                        
                        <h2 class="sidetitle">Upozornění</h2>             
                            <p> <? echo $note_text; ?> </p>
				
                        <? } ?>
                        
                        
                        
                        <h2 class="sidetitle">Přihlášení</h2>
					<br />
                              <form name="loginForm" method="post" action="logger.php">
					
                              <? /*
                              <fieldset>
						<legend><? echo $LNG_MAINPAGE_SIGNON_LABEL; ?></legend>
                              */ ?>
						<label><? echo $LNG_MAINPAGE_USERNAME_LABEL; ?></label>
						<br />
                                    <input name="logflogin" type="text" size="15" maxlength="15">
						<br />
						<label><? echo $LNG_MAINPAGE_PASSWORD_LABEL; ?></label>
						<br />
                                    <input name="logfpassword" type="password" size="15" maxlength="40">

					<? /*
                              <!--	<input name="invisible" type="checkbox">
						<label><? echo $LNG_MAINPAGE_INVISIBLE_LABEL; ?></label>
					*/ ?>	
                                    <br />
						<input name="login" type="submit" value="<? echo $LNG_MAINPAGE_LOGIN_SUBMIT; ?>">
					
                              <? /* </fieldset> */ ?>
				      </form>
				      
				      <? /*
                              <!-- REGIN WINDOW //-->
				      
				      <!-- REGIN WINDOW
				      <form name="reginForm" method="post" action="regger.php">
					<fieldset>
						<legend>Registrace do systému</legend>

						<label><? echo $LNG_MAINPAGE_USERNAME_LABEL; ?></label>
						<input name="regflogin" type="text" size="15" maxlength="15">

						<label><? echo $LNG_MAINPAGE_PASSWORD_LABEL; ?></label>
						<input name="regfpassword" type="password" size="15" maxlength="40">

						<label><? echo $LNG_MAINPAGE_PASSWORD2_LABEL; ?></label>
						<input name="reg2fpassword" type="password" size="15" maxlength="40">

						<input name="register" type="submit" value="<? echo $LNG_MAINPAGE_REGIN_SUBMIT; ?>">
					</fieldset>
				      </form>
				      REGIN WINDOW //-->
				      */ ?>
			 
					
					
             <h2 class="sidetitle">Registrace</h2>
                              <p>
					   <a href="http://www.talker2.net/admin_reg/newuser.php">>> přejít na formulář</a>
                              </p>
                              
                        <? /*
                        <h2 class="sidetitle">Seznam uľivatelů</h2>
                              <br />
                              <?
                              $userListResult=_oxResult("SELECT login FROM $TABLE_USERS ORDER BY login ASC");
                              while($userListArray=MySQL_Fetch_array($userListResult)) {
                                    $user_name = $userListArray['login'];
                                    ?>
                                          <img src="ico/<? echo "$user_name" ?>.gif" width="20" height="25" class="user_icon" /> <b><? echo $user_name;?></b> <br />
                                    <?
                              }
                              ?>
                        */ ?>
                        
                                    
                  </div>

		</div>
		

		<br class="spacer" />

      </div>
      

	<script type="text/javascript">
	//<![CDATA[
	/* Replacement calls. Please see documentation for more information. */

	if(typeof sIFR == "function"){

	// This is the preferred "named argument" syntax
		sIFR.replaceElement(named({sSelector:"h1", sFlashSrc:"script/sava.swf", sColor:"#0B3CC5", sLinkColor:"#000000", sBgColor:"#F2F3F5", sHoverColor:"#CCCCCC", nPaddingTop:0, nPaddingBottom:0, sFlashVars:"textalign=left&offsetTop=0"}));

			sIFR.replaceElement(named({sSelector:"h2", sFlashSrc:"script/sava.swf", sColor:"#0B3CC5", sLinkColor:"#000000", sBgColor:"#F2F3F5", sHoverColor:"#CCCCCC", nPaddingTop:"0", nPaddingBottom:"0" ,sFlashVars:"textalign=left&offsetTop=0"}));

	// This is the older, ordered syntax
	//	sIFR.replaceElement("h1", "./themes/site_themes/default/avenir.swf", "#cccccc", "#000000", "#FFFFFF", "#FFFFFF", 0, 0, 0, 0);

	};

	//]]>
	</script>

</body>
</html>
