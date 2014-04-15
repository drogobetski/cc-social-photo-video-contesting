<?php
include 'lib/base.inc.php';
include 'lib/utility.class.php';
//$u = new Utility();

$step=1; 

// form step 1 submit
if(isset($_POST['preForm']) && $_POST['preForm']=="y"){
	

	// check image validity
	if($contest['contest_type'] ==1 || $contest['contest_type'] ==3){
		if(!$u->isValidImage($_FILES['image'],600,5)){ $errors['message'] .='<br /><span class="errortext">* You have an incorrectly formatted image.<br /><br /><span class="errortext"> - Accepted file types: .jpg, .gif<br /></span><span class="errortext"> - Minimum width: 600px<br /></span><span class="errortext"> - Maximum size: 3MB</span>'."\n"; $errors['image'] = 'class="error"';}
	}
	

	// check audio file validity
	if($contest['contest_type'] ==2){
			if($_FILES['userfile']['size']>0 && !$u->isValidFile($_FILES['userfile'],5)){
				$errors['message'] .='<br /><span class="errortext">* You have an incorrectly formatted file.<br /><br /><span class="errortext"> - Accepted file types: .mp3<br /></span><span class="errortext"> - Maximum size: 5MB</span>'."\n"; $errors['image'] = 'class="error"';
			}
	}

	
	// no errors...
	if(empty($errors)==true){
		
	    // no crop needed
		if($contest['contest_type'] ==2){
			$u->doData($_POST);
			$step = 2;
		}
		// crop needed - send to crop page
		else {
			$step = 2;
		}
	}
	
}


// form step 2 submit
if(isset($_POST['sentForm']) && $_POST['sentForm']=="y"){
	$u->doCrop($_POST,$_POST['filename']);
	$u->doThumb($_POST['filename']);
	$u->doData($_POST);
	$step=3;
}


// determine html to output to page
switch($step){
	
    // entry form
	case 1:
		$html = $u->displaySubmitForm($errors);
		break;

    // crop form if image upload
	case 2:
		if($contest['contest_type'] ==2){ $html = $u->displaySuccess($_POST['userfile']); }
		else {
			$imgData = $u->prepImages($_FILES['image'],_orig_w_);
			$html = $u->displaySubmittedData($_POST,$imgData['filename']);
			$html .= $u->displayCropHeaders($imgData['orig_w'],$imgData['orig_h']);
			$html .= $u->displayImageCrop($imgData['filename']);
			$html .= '</fieldset>'."\n";
		}
		break;
	
	// success page	
	case 3:
		$html = $u->displaySuccess($_POST['filename']);
		break;
	
	
}

// This is to help dump CC firewall cache so we can see refreshed images when we make updates.
$x = rand(1,9999);

//updated local page template
include_once('/export/home/common/template/T25globalincludes'); // do not modify this line
include_once (CDB_REFACTOR_ROOT."feed2.tool"); // do not modify this line

//set variables for og tags and other meta data
$page_title = $contest['title'];
$page_description = $contest['meta_description'];
$keywords = _$contest['meta_keywords'];
$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
include 'CCOMRheader.template'; // do not modify this line
?>

<link rel="stylesheet" type="text/css" href="css/main.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="/common/tools/css/style.css?x=<?php echo $x; ?>" />
<?php include 'lib/fonts.inc.php'; ?>

<!-- pagecontainer -->
<div class="pageContainer">

    <!-- header image -->
    <img src="images/header.jpg?x=<?php echo $x; ?>" alt="<? echo $tagname; ?>" width="990" border="0" />

	<p class="center"><a href="<?php echo $contest['link']; ?>" target="_top">&laquo; back to mainpage</a></p>
	
	<? echo $html; ?>
  
</div>
<!-- end pagecontainer -->

<!-- local scripts -->
<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

<?php include 'CCOMRfooter.template'; ?>