<?

if ($_SERVER['HTTP_HOST']=='g3n.us') {
  header("location: http://www.g3n.us/");  
}

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
/*
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
   echo '<h1>DOPORUČUJEME FIREFOX!</h1>';
   echo '<p>TALKER2 je v současné době optimalizován pro webový prohlížeč <a href="http://www.getfirefox.com">Firefox</a>.</p>';
   echo '<p>Internet Explorer a další prohlížeče lze v případě nutnosti používat, přesto doporučujeme pro plné využití všech možností systému právě Firefox.</p>';
}
*/
 

//$main_style=rand(1, 3);
//echo "this is something new";

echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="<? echo $timecr ?>">
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title><? echo "$TITLE_NAME" ?></title>
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
            	
                       	
            	var currentBaseUrl = 'http://ds.zavrel.net/';
            //-->
            </script>
            <!-- OVERLAY //-->
</head>

<body>
	<div id="topbar">
            <img src="imgs/ds_logo.png">
                 
            
            <div id="login">
                  <form name="loginForm" method="post" action="logger.php">
                  <label><? echo $LNG_MAINPAGE_USERNAME_LABEL; ?></label>
                  <input name="logflogin" type="text" size="15" maxlength="15">
                  <label><? echo $LNG_MAINPAGE_PASSWORD_LABEL; ?></label>
                  <input name="logfpassword" type="password" size="15" maxlength="40">
                  <input name="login" type="submit" value="<? echo $LNG_MAINPAGE_LOGIN_SUBMIT; ?>">
      		        </form>
            </div>
          
          
           <br />
           <!-- <a href="http://www.getfirefox.com"><p style="margin-left:20px">If you're havin' IE problems, I feel bad for you, son - I got 99 problems but the bitch ain't one.</p></a> //-->
           <p class="footer">
                  <a href="newuser.php">registrace</a> | <a href="http://ds.zavrel.net">blog</a> | &copy; DS 2010
           </p>
          
          
          <?
      			 $note = $_GET["note"];
      			 if ($note != null){
      			     $note_text = _oxNoter($note);
      			     
      		           ?>
                             <!-- <noscript> //-->
                             <div>UPOZORNĚNÍ: <? echo $note_text; ?></div>
                             <!-- </noscript> //-->
                             
                             <!--
                             <script language="javascript" type="text/javascript">
                             
                              showNewPlayerLightbox('<?echo $note; ?>');
                             
                             </script>
                             //-->
                                                          
                             
                  <? } ?>
                  
                  
                  
                  
                  
                  
                  
                  
      
           
          
                 
    
      </div>	
	
</body>
</html>
