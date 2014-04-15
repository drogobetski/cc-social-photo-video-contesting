<?php
include 'lib/base.inc.php';
include 'lib/utility.class.php';
$u = new Utility();

// get html to display to page
$html = $u->displayEntrants('view',_perGallery_,$_GET['id'],$_GET['gid'],$_GET['ag']);

// generate age group text if necessary
if(_age_groups_=='y'){
	foreach($age_group_array as $value=>$name){
		if($_GET['ag']==$value){ $agName = '- '.$name; }	
	}
}

// This is to help dump CC firewall cache so we can see refreshed images when we make updates.
$x = rand(1,9999);

//updated local page template
include_once('/export/home/common/template/T25globalincludes'); // do not modify this line
include_once (CDB_REFACTOR_ROOT."feed2.tool"); // do not modify this line

//set variables for og tags and other meta data
$page_title = $contest['title'];
$page_description = $contest['meta_description'];
$keywords = $contest['meta_keywords'];
$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
include 'CCOMRheader.template'; // do not modify this line
?>

<link rel="stylesheet" type="text/css" href="css/main.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="/common/tools/css/style.css?x=<?php echo $x; ?>" />
<?php include 'lib/fonts.inc.php'; ?>

<!-- pagecontainer -->
<div class="pageContainer center">
 
    <?php echo $html; ?>
       
    <iframe name="picframe" width="1" height="1" src="picview.php" frameborder="0" scrolling="no" ></iframe>
    
</div>
<!-- end pagecontainer -->

<!-- local scripts -->
<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

<?php include 'CCOMRfooter.template'; ?>