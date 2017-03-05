<?
session_start();
include('incl/header.php');

echo '<?xml version="1.0" encoding="utf-8"?>'; 
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
	<head>
		<?
            /* 
		zde opet dochazi k vymazani pameti cache a nastaveni expirace na aktualni hodnotu
		mozna je to tu zbytecne 2x - viz com02
		*/
            ?>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="<? echo $timecr ?>">

		<?
		/*
		nastaveni znakove sady
		*/
            ?>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">


		<?
		/*
		nastaveni zahlavi prohlizece, TITLE_NAME je nazev aplikace/serveru, jmeno uzivatele, datum a cas
		pozdeji by se zde mohl objevit i aktualni modul, ovsem k tomu je treba zmena struktury stranek
		*/
            ?>
		
		<title><? echo "$TITLE_NAME" ?> :: <? echo "$login" ?> :: <? echo "$module_name" ?> :: <? echo "$date" ?> :: <? echo "$time" ?></title>

    	      <?
    	      /*
		nacteni preferovaneho kaskadniho stylu, jehoz hodnota byla ziskana z databaze
		*/
            ?>
            
            <? $css_source = substr($css, 0, 7); ?>
            <? if ($css_source=="http://") { ?>    	       
                  <link rel=stylesheet href="<? echo $css ?>" type="text/css">
            <? }else{ ?>
                  <link rel=stylesheet href="style/<? echo $css ?>/<? echo $css ?>.css" type="text/css">
            <? } ?>
            
            
            
            
            <!-- OVERLAY //-->
            <link rel="stylesheet" href="style/<? echo $css ?>/overlay/lightbox.css" type="text/css" media="screen" />
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
            	
                       	
            	var currentBaseUrl = 'http://www.talker2.net/';
            //-->
            </script>
            <!-- OVERLAY //-->
            
            
            
            
            
            
      
      <?
      /*
      nacteni preferovaneho chovani menu
      */
      ?>
      
      <? //echo $custom_menu; ?>
     	<? if ($custom_menu == "0") { ?>
		   <style>
		        /* styl pro zafixovany cockpit vceten menu */
              
            #fixed
            {
            position: fixed;
            width: 100%;
            background: #FFFFFF;
            }
            
            /* nastavuje vysku mezery mezi submenu a vlastnim obsahem prislusneho modulu */
            #sub_fixed
            {
            /*height: 128px;*/
            height: 180px;
            }
       </style>
	<? } ?>
            

    	<?
	/*
      nastaveni favicon - ikonka zobrazujici se pred adresou na adresnim radku a v oblibenych polozkach v
	ramci prohlizece
	*/
      ?>
      
    	<link rel="Shortcut Icon" type="image/gif" href="favicon.ico">


    	<?
    	/*
	nacteni systemoveho javascriptu
	*/
      ?>
      
    	<script language="javascript" src="script/sys.js"></script>
    	<script language="javascript" src="script/js_plain_text.js"></script>
    	
    	<?
      /*
      nacteni skriptu pro hodiny
      */
      ?>
    	<!--[if IE]><script type="text/javascript" src="script/excanvas.js"></script><![endif]-->
      <script type="text/javascript" src="script/coolclock.js"></script>



	<?
      /*
      from wordpress, possible copyright violation
      */
      ?>
      
    	<script type="text/javascript">
		//<![CDATA[
		function addLoadEvent(func) {if ( typeof wpOnload!='function'){wpOnload=func;}else{ var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}}
		//]]>
		</script>
		<script type="text/javascript" src="script/fat.js"></script>
		<style type="text/css">* html { overflow-x: hidden; }</style>
	<?
      /*
      from wordpress, possible copyright violation
      */
      ?>
      
      </head>

	<body>
			<?
                  /*
                  NOUZOVÉ UPOZORNENÍ ADMINISTRÁTORA
			
                  <!--
			<tr>
				<td align="center">
					<h2>POZOR: za chvíli vypnu databázi kv?li upgrade systému, odhlaąte se prosím...</h2>
				</td>
			</tr>
			//-->
			
                  NOUZOVÉ UPOZORNENÍ ADMINISTRÁTORA
			*/
                  ?>

      <div id="fixed">
			   <? /* COCKPIT WINDOW */ ?>
			   <? include('incl/cockpit.php'); ?>
			   <? /* COCKPIT WINDOW */ ?>
                  
			   <? /* MAIN MENU */ ?>
			   <? include('incl/main_menu.php'); ?>
			   <? /* MAIN MENU */ ?>
			
		     	                                    	     
		     <? /* SUBMENU */ ?>
                 <? if ($module_number == 1 || $module_number == 2 || $module_number == 3 || $module_number == 4 || $module_number == 5 || $module_number == 6 || $module_number == 7 || $module_number == 8 || $module_number == 10 || $module_number == 11) { ?>
                        <? include('incl/sub_menu.php'); ?>
                 <? } ?>       
	       <? /* SUBMENU */ ?>
			</div>
			
                  
			
                  <? /* MEZERA MEZI SUBMENU A VLASTNIM OBSAHEM */ ?>
                  <div id="sub_fixed">
                  </div>
                  <? /* MEZERA MEZI SUBMENU A VLASTNIM OBSAHEM */ ?>      

			<? if ($module_number == 1) { ?>
				<? include('system.php'); ?>
			<? } ?>

			<? if ($module_number == 2) { ?>
				<? include('mailbox.php'); ?>
			<? } ?>

			<? if ($module_number == 3) { ?>
				<? include('topics.php'); ?>
			<? } ?>

			<? if ($module_number == 4) { ?>
				<? include('users.php'); ?>
			<? } ?>

			<? if ($module_number == 5) { ?>
				<? include('settings.php'); ?>
			<? } ?>

			<? if ($module_number == 6) { ?>
				<? include('bookmarks.php'); ?>
			<? } ?>

			<? if ($module_number == 7) { ?>
				<? include('live.php'); ?>
			<? } ?>

			<? if ($module_number == 8) { ?>
				<? include('help.php'); ?>
			<? } ?>

			<? if ($module_number == 10) { ?>
				<? //echo "roomid: ".$roomid; ?>
				<? include('discussion.php'); ?>
				<? //echo "jdu do diskuze"; ?>
			<? } ?>

			<? if ($module_number == 11) { ?>
				<? include('userinfo.php'); ?>
			<? } ?>





			<div id="footer">
			<?
			$gen_script_time = substr(time()+substr(microtime(),0,8)-$gen_script_start,0,6);
			?>

			<? /* W3C Standards */ ?>
			<p>
			    <br />
			    powered by <a href="http://www.php.net">PHP</a><br />
			    page rendered in <? echo "$gen_script_time" ?> seconds<br />
				<a href="http://validator.w3.org/check?uri=referer">
				   	<img src="style/default/icon-xhtml.gif" alt="validate this page" border="0" />
			    </a>
				
                      <?
                      /*
			    <a href="http://validator.w3.org/check?uri=referer">
			    <img src="style/default/icon-xhtml.gif" alt="validate this page" border="0" />
			    </a>
			    */
                      ?>
			    
                      <a href="http://jigsaw.w3.org/css-validator/check/referer?warning=no&profile=css2">
			    	<img src="style/default/icon-css.gif" alt="validate css on this page" border="0" />
			    </a>
  			</p>
  			</div>


	</body>
</html>















