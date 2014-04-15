<?php
include 'lib/base.inc.php';
include 'lib/utility.class.php';
$u = new Utility();

// get html to display to page
$html = $u->displayEntrantsMobile('vote',_perGallery_,$_GET['id'],$_GET['gid'],$_GET['ag']);

// generate age group text if necessary
if(_age_groups_=='y'){
	foreach($age_group_array as $value=>$name){
		if($_GET['ag']==$value){ $agName = '- '.$name; }	
	}
}

// This is to help dump CC firewall cache so we can see refreshed images when we make updates.
$x = rand(1,9999);
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title><?php echo _title_; ?> on MIX 96.9</title>
<link rel="stylesheet" href="css/foundation.css">
<link rel="stylesheet" href="css/mobile.css">

<!-- <link rel="stylesheet" type="text/css" href="css/main.css?x=<?php echo $x; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="/common/tools/css/style.css?x=<?php echo $x; ?>" /> -->
<?php include 'lib/fonts.inc.php'; ?>

<script src="js/vendor/custom.modernizr.js"></script>

</head>
<body>

	<nav class="top-bar">
		<ul class="title-area">
			<li class="name"><h1><a href="http://www.mix969.com">MIX 96.9</a></h1></li>
			<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
		</ul>

		<section class="top-bar-section">
			<ul class="right">
		      <li class="divider"></li>
		      <li class="active"><a href="http://www.mix969.com/photos/">Photos</a></li>
		      <li class="divider"></li>
		      <li class="active"><a href="http://www.iheart.com/live/45/?autoplay=true">Listen Live</a></li>
		      <li class="divider"></li>
		      <li class="active"><a href="/articles/">News</a></li>
		      <li class="divider"></li>
		      <li class="active"><a href="/cc-common/contests/">Contests</a></li>
		      <li class="divider"></li>
		   </ul>
		</section>

	</nav>

	<img src="images/header-mix.jpg" style="margin:-30px auto 10px;" />

	<div class="row">
		<div class="large-12 columns">
			<p><strong><?php echo _title_; ?> on MIX 96.9 - Vote Below</strong></p>
			
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">

			<?php echo $html; ?>

		<!-- <ul data-orbit>
		  <li data-orbit-slide="headline-1">
		    <img src="images/testpic.jpg" style="margin-bottom:10px;" />
		    <p>Support Frank G.</p>
		    <ul class="button-group round">
				  <li style="width:50%;"><a style="width:100%;" href="#" class="button secondary">Vote For Me</a></li>
				  <li style="width:50%;">
				  	<a href="#" class="button" style="width:100%; color:#fff!important;" 
					  onclick="
					    window.open(
					      'https://m.facebook.com/sharer.php?u='+encodeURIComponent(location.href), 
					      'facebook-share-dialog', 
					      'width=626,height=436'); 
					    return false;">Share It!
					 </a>
					</li>
				</ul>
		  </li>
		  
		  <li data-orbit-slide="headline-2">
		    <img src="images/testpic.jpg" style="margin-bottom:10px;" />
		    <p>Support Ricky R.</p>
		    <ul class="button-group round">
			  <li style="width:50%;"><a style="width:100%;" href="#" class="button secondary">Vote For Me</a></li>
			  <li style="width:50%;"><a style="width:100%; color:#fff!important;" href="#" class="button">Share It!</a></li>
			</ul>
		  </li>
		  
		  <li data-orbit-slide="headline-3">
		    <img src="images/testpic.jpg" style="margin-bottom:10px;" />
		    <p>Support Steve H.</p>
		    <ul class="button-group round">
			  <li style="width:50%;"><a style="width:100%;" href="#" class="button secondary">Vote For Me</a></li>
			  <li style="width:50%;"><a style="width:100%; color:#fff!important;" href="#" class="button">Share It!</a></li>
			</ul>
				
			</li>
		  	
		</ul>

		</div>
	</div>
	<a href="#" style="display:none;" data-orbit-link="headline-1" data-orbit-slide-number="1"></a>
		  
<a href="#" style="display:none;" data-orbit-link="headline-2" data-orbit-slide-number="2"></a>
		  
	<a href="#" style="display:none;" data-orbit-link="headline-3" data-orbit-slide-number="3"></a>
		-->  

	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
			<p><em>Brought to you by:</em></p>
			<p>Blah blah bladkj fsaj fslk fklsjf sdalkjf ks jkldf jlsadj f asdjf dsal fks adlfjsad fjsa</p>
		</div>
		</div>
	</div>

  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
  <script src="js/foundation.min.js"></script>
  <!--
  
  <script src="js/foundation/foundation.js"></script>
  
  <script src="js/foundation/foundation.alerts.js"></script>
  
  <script src="js/foundation/foundation.clearing.js"></script>
  
  <script src="js/foundation/foundation.cookie.js"></script>
  
  <script src="js/foundation/foundation.dropdown.js"></script>
  
  <script src="js/foundation/foundation.forms.js"></script>
  
  <script src="js/foundation/foundation.joyride.js"></script>
  
  <script src="js/foundation/foundation.magellan.js"></script>
  
  <script src="js/foundation/foundation.orbit.js"></script>
  
  <script src="js/foundation/foundation.reveal.js"></script>
  
  <script src="js/foundation/foundation.section.js"></script>
  
  <script src="js/foundation/foundation.tooltips.js"></script>
  
  <script src="js/foundation/foundation.topbar.js"></script>
  
  <script src="js/foundation/foundation.interchange.js"></script>
  
  <script src="js/foundation/foundation.placeholder.js"></script>
  
  <script src="js/foundation/foundation.abide.js"></script>
  
  -->
  
	<script>
	$(document).foundation();
	
	// get slide from hash
	if(location.hash.indexOf("#slide") !== -1) {
	    //.fx.off = true;
	    $("[data-orbit-slide-number='"+location.hash.substr(6)+"']").click(); // If you edit the #slide to something else remember to change the number inside the substr.
	    //$.fx.off = false;
	    $('.orbit-timer').click(); //Clicks pause
	}
	else {
		$("[data-orbit-slide-number='1']").click(); // If you edit the #slide to something else remember to change the number inside the substr.
	   $('.orbit-timer').click(); //Clicks pause
	}
	</script>



  	<!-- local scripts -->
	<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
	<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

  	<iframe name="picframe" width="1" height="1" src="picview.php" frameborder="0" scrolling="no" ></iframe>

</body>
</html>