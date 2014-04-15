<?php
// admin overview page
session_start();
include '../lib/base.inc.php';
include '../lib/utility.class.php';
$u = new Utility();
$x = rand(1,9999);


// update status
if ( isset($_POST['statusUpdate']) && $_POST['statusUpdate']=="y" ) {
	foreach ( $_POST['entrants'] as $entrantID ) {
		$u->updateStatus( $_POST['newStatus'] , $entrantID );
	}
}


// auto set for pending records if no status set
if( !isset($_GET['status']) ){ $_GET['status']='p'; }

// generate html
$html = $u->displayAdminLogin();

// check for logged cookie
if($_COOKIE['logged']=='y'){ $html = $u->displayAdminEntrants(); }

	
// check log in credentials
if(isset($_POST['sentForm']) && $_POST['sentForm']=="y"){
	
    if($u->checkPassword($_POST)){ 
		setcookie('logged','y');
		$html = $u->displayAdminEntrants();
    } else {
    	$html = $u->displayAdminLogin($error);
    }
	
}


// This is to help dump CC firewall cache so we can see refreshed images when we make updates.
$x = rand(1,9999);

//updated local page template
include_once('/export/home/common/template/T25globalincludes'); // do not modify this line
include_once (CDB_REFACTOR_ROOT."feed2.tool"); // do not modify this line

//set variables for og tags and other meta data
$page_title = _title_;
$page_description = _meta_description_;
$keywords = _meta_keywords_;
$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
include 'CCOMRheader.template'; // do not modify this line
?>

<link rel="stylesheet" type="text/css" href="../css/main.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="/common/tools/css/style.css?x=<?php echo $x; ?>" />
<?php include '../lib/fonts.inc.php'; ?>

<!-- pagecontainer -->
<div class="pageContainer admin">

    <!-- header image -->
    <img src="../images/header-admin.jpg" alt="<? echo _title_; ?>" width="990" border="0" />
 
    <!-- overview -->
	<?php echo $html; ?>

</div>
<!-- end pagecontainer -->
    
<!-- local scripts -->
<script type="text/javascript" src="../js/inc.js" language="javascript"></script>
<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

<?php include 'CCOMRfooter.template'; ?>
