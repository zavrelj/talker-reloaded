<?
$tips_num=rand(0, count($TIPS)-1);
include('incl/navi.php');
?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>


<?
if ($submodule_number==1) {
	//echo "zobraz zpravy";
	include('incl/mailbox_bulletin.php');
}
if ($submodule_number==2) {
	//echo "vyhledej zpravy";
	include('incl/mailbox_search.php');
}
?>







