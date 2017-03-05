<?

$search = $_POST['search'];
$roomname = $_POST['roomname'];
$selectbox = $_POST['selectbox'];
$topic_id = $_GET['topic_id'];
$subtopic_id = $_GET['subtopic_id'];

if($search == vyhledat && $roomname != "" && $db_passwd == $session_passwd) {
	if ($selectbox != "a") {
		$search_result = _oxResult("SELECT roomid, name, founderid, FK_topic, count, icon FROM $TABLE_ROOMS WHERE name LIKE '%".addslashes($roomname)."%' AND FK_topic=$selectbox AND private=0");
	}else{
		$search_result = _oxResult("SELECT roomid, name, founderid, FK_topic, count, icon FROM $TABLE_ROOMS WHERE name LIKE '%".addslashes($roomname)."%' AND private=0");
	}
	$num_rows=mysql_num_rows($search_result);
}



$add_subcategory = $_POST['add_subcategory'];
$subcategory_name = $_POST['subcategory_name'];
$add_subcategory_select = $_POST['add_subcategory_select'];

if ($add_subcategory == "přidat" && $db_passwd == $session_passwd) {
      if ($add_subcategory_select != "a" && $subcategory_name != null) {
            //echo $add_subcategory_select;
            //echo "<br />";
            //echo $subcategory_name;
            //echo "<br />";
            //echo "test successful!";
            //echo "<br />";
            //nejprve musime zjistit cislo posledni subkategorie v dane kategorii
            $lastSubcategoryNumberArray = _oxQuery("SELECT MAX(PK_subtopic) as subtopic_num FROM $TABLE_SUBTOPICS WHERE FK_topic=$add_subcategory_select");
            $lastSubcategoryNumber = $lastSubcategoryNumberArray['subtopic_num'];
            //echo $lastSubcategoryNumber;
            //echo "<br />"; 
            $newSubcategoryNumber = $lastSubcategoryNumber+1;
            //pote pridame do tabulky subkategorii novy zaznam, ktery bude obsahovat:
            //cislo subkategorie +1, cislo kategorie, nazev subkategorie
            _oxMod("INSERT INTO $TABLE_SUBTOPICS VALUES ($newSubcategoryNumber, $add_subcategory_select, '$subcategory_name')");
      }else{
            echo "nebyla vybrána kategorie nebo nebyl zadán název subkategorie";
      }            
}



$subcategory_name = $_POST['subcategory_name'];
$subcategory_id = $_POST['subcategory_id'];
$category_id = $_POST['category_id'];
$change_subcategory_name = $_POST['change_subcategory_name'];


if ($change_subcategory_name == "změnit název subkategorie" && $db_passwd == $session_passwd) {
      if ($subcategory_name != null) {
            //echo $category_id;
            //echo "<br />";
            //echo $subcategory_id;
            //echo "<br />";
            //echo $subcategory_name;
            //echo "<br />";
            //echo "test successful!";
            //echo "<br />";
            //nejprve musime zjistit cislo posledni subkategorie v dane kategorii
            //$lastSubcategoryNumberArray = _oxQuery("SELECT MAX(PK_subtopic) as subtopic_num FROM $TABLE_SUBTOPICS WHERE FK_topic=$add_subcategory_select");
            //$lastSubcategoryNumber = $lastSubcategoryNumberArray['subtopic_num'];
            //echo $lastSubcategoryNumber;
            //echo "<br />"; 
            //$newSubcategoryNumber = $lastSubcategoryNumber+1;
            //pote pridame do tabulky subkategorii novy zaznam, ktery bude obsahovat:
            //cislo subkategorie +1, cislo kategorie, nazev subkategorie
            _oxMod("UPDATE $TABLE_SUBTOPICS SET subtopic_name='$subcategory_name' WHERE FK_topic=$category_id AND PK_subtopic=$subcategory_id");
      }else{
            echo "nebyl zadán název subkategorie";
      }            
}

$delete_subcategory = $_POST['delete_subcategory'];

if ($delete_subcategory == "smazat subkategorii" && $db_passwd == $session_passwd) {
      //smazat lze pouze subkategorii s cislem vetsim nez nula
      if ($subcategory_id != 0) {
             
            
            //echo $category_id;
            //echo "<br />";
            //echo $subcategory_id;
            //echo "<br />";
            //echo $subcategory_name;
            //echo "<br />";
            //echo "test successful!";
            //echo "<br />";
            
            
            //presuneme vsechny diskuze z mazane subkategorie do subkategorie 0
            _oxMod("UPDATE $TABLE_ROOMS SET FK_subtopic=0 WHERE FK_topic=$category_id AND FK_subtopic=$subcategory_id");
            
            //smazeme subkategorii
            _oxMod("DELETE FROM $TABLE_SUBTOPICS WHERE FK_topic=$category_id AND PK_subtopic=$subcategory_id");
            
            //nejprve musime zjistit cislo posledni subkategorie v dane kategorii
            //$lastSubcategoryNumberArray = _oxQuery("SELECT MAX(PK_subtopic) as subtopic_num FROM $TABLE_SUBTOPICS WHERE FK_topic=$add_subcategory_select");
            //$lastSubcategoryNumber = $lastSubcategoryNumberArray['subtopic_num'];
            //echo $lastSubcategoryNumber;
            //echo "<br />"; 
            //$newSubcategoryNumber = $lastSubcategoryNumber+1;
            //pote pridame do tabulky subkategorii novy zaznam, ktery bude obsahovat:
            //cislo subkategorie +1, cislo kategorie, nazev subkategorie
            //_oxMod("UPDATE $TABLE_SUBTOPICS SET subtopic_name='$subcategory_name' WHERE FK_topic=$category_id AND PK_subtopic=$subcategory_id");
      }           
}







//slouzi k vyprazdeni cashe po odeslani formulare, na nekterych serverech
//nefungje a je treba ji zakomentovat
//ob_end_flush();

?>

<? /* SUBMENU */ ?>
<? //include('incl/sub_menu.php'); ?>
<? /* SUBMENU */ ?>

<?
if ($submodule_number==1) {
	//echo "vkladam seznam temat";
	include('incl/topics_list.php');
}
if ($submodule_number==2) {
	//echo "vkladam nova diskuze";
	include('incl/topics_new_discussion.php');
}
if ($submodule_number==3) {
	//echo "vkladam hledat diskuzi";
	include('incl/topics_search_discussion.php');
}
if ($submodule_number==4) {
	//echo "vkladam přidat subkategorii";
	include('incl/topics_add_subcategory.php');
}
?>




