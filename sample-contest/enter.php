<?php
include('../lib/config.php');
include('../lib/db.php');
include('../lib/classes/contest.class.php');

$c = new Contest(1);
$contest = $c->getContestDetails();

$step=1; 


// form step 2 submit
if(isset($_POST['sentForm']) && $_POST['sentForm']=="y"){
	//$u->doCrop($_POST,$_POST['filename']);
	//$u->doThumb($_POST['filename']);
	//$u->doData($_POST);
	$step=2;
}



// This is to help dump CC firewall cache so we can see refreshed images when we make updates.
$x = rand(1,9999);

// local machine header
  include('../inc/header-local.inc.php');


// cc header
  //updated local page template
  /*include_once('/export/home/common/template/T25globalincludes'); // do not modify this line
  include_once (CDB_REFACTOR_ROOT."feed2.tool"); // do not modify this line

  //set variables for og tags and other meta data
  $page_title = $contest['name'];
  $page_description = $contest['description'];
  $keywords = _$contest['keywords'];
  $url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

  $useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
  include 'CCOMRheader.template'; // do not modify this line*/
?>

<link rel="stylesheet" type="text/css" href="../css/main.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.css?x=<?php echo $x; ?>" media="screen" />

<?php include('../inc/fonts.inc.php'); ?>

<!-- pagecontainer -->
<div class="pageContainer">

    <!-- header image -->
    <img src="images/header.jpg?x=<?php echo $x; ?>" alt="<? echo $contest['name']; ?>" width="990" border="0" />

	<p class="center"><a href="<?php echo $contest['link']; ?>" target="_top">&laquo; back to mainpage</a></p>
	
	<form action="" id="theForm" method="post">
		<p><label>First Name</label><input type="text" name="fname" class="required" value="" /></p>
		<p><label>Last Name</label><input type="text" name="lname" class="required" value="" /></p>
		<p><label>Email Address</label><input type="text" name="email" class="email required" value="" /></p>
		<p><label>Telephone</label><input type="text" name="phone" class="required" value="" /></p>
		<h3>Now it's time to enter the URL where your picture or video can be found.</h3>
		<h4>For Instagram, the url may look something like: <strong>http://instagram.com/p/mbtqP1ziH_/</strong></h4>
		<h4>For Vine, the url may look something like: <strong>https://vine.co/v/M5daDXbAYeh</strong></h4>
		<h4>For Twitter, the url may look something like: <strong>https://twitter.com/KISSFMPhoenix/status/456160172008689664/photo/1</strong></h4>
		<p><label>Your Image URL</label><input type="text" name="url" class="required" /></p>
		<p><input type="submit" name="submit" value="Enter Now" /></p>

	</form>
  
</div>
<!-- end pagecontainer -->

<!-- local machine footer -->
  <?php include('../inc/footer-local.inc.php'); ?>


<!-- cc footer -->
  <!-- local scripts -->
  <!-- <script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
  <script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>-->

  <?php //nclude 'CCOMRfooter.template'; ?>