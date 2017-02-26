<div><? echo "$LNG_USER_INFO_LOGS $user_info_login"; ?></div>

<?
while($userLogsArray=MySQL_Fetch_array($userLogsResult)) {
	$log_time = $userLogsArray['log_time'];
	?><div class="user_logs"><?
	echo date("d.m.Y H:i:s", "$log_time");
	echo " ".$userLogsArray['log_IP'];
	echo " ".$userLogsArray['log_host'];
	echo " ".$userLogsArray['log_agent'];
	?></div><?
}
?>
