<div class="message_left">
	<? include('incl/message_user_icon.php'); ?>
</div>

<div class="message_right">
	<? if ($timestampvalue > $lastaccess && $lastaccess != "" && $user_name!=$login) { ?>
		<div class="message_header_new">
	<? }elseif ($module_number==02 && $message_type==1) {//posta-prijata-neprectena ?>
		<div class="message_header_new">
	<? }else{ ?>
		<div class="message_header">
	<? } ?>

			<? include('incl/message_header.php'); ?>
    </div>
	<div class="message_content"><? include('incl/message_content.php'); ?></div>
	<div class="message_action"><? include('incl/action_pannel2.php'); ?></div>
</div>

<!--
<div id="p2915222" class="post bg<? echo $bg_flag; ?>">
      <div class="inner"><span class="corners-top"><span></span></span>
      	<div class="postbody">
	           	
			<p class="author"><a href="#p2915222"><img src="./styles/prosilver/imageset/icon_post_target.gif" width="11" height="9" alt="Post" title="Post" /></a> by <strong><a href="./memberlist.php?mode=viewprofile&amp;u=235607"><? echo $user_name ?></a></strong> on  <? echo $formatteddate ?></p>
	
			<div class="content"><? include('incl/message_content.php'); ?></div>

			<div class="notice">Last edited by <a href="./memberlist.php?mode=viewprofile&amp;u=50692" style="color: #0000CC;" class="username-coloured">Caedmon</a> on Wed Apr 11, 2007 3:43 am, edited 1 time in total					<br /><strong>Reason:</strong> <em>removed the link to the xrumer bot. That's just dumb.</em>				</div>
			
		</div>

		<dl class="postprofile" id="profile2915222">
      		<dt><a href="./memberlist.php?mode=viewprofile&amp;u=235607"><? echo $user_name ?></a></dt>

	           	<dd>Registered User</dd>
                  <dd>&nbsp;</dd>
                  <dd><strong>Posts:</strong> 18</dd><dd><strong>Joined:</strong> Tue Feb 21, 2006 3:26 pm</dd>
		</dl>
	
		<div class="back2top"><a href="#wrap" class="top" title="Top">Top</a></div>
		<span class="corners-bottom"><span></span></span>
      </div>
</div>
//-->




