<?php
include('../lib/config.php');
include('../lib/db.php');
include('../lib/classes/contest.class.php');

$c = new Contest(1);

$contest = $c->getContestDetails();


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

  <!-- header -->
  <div class="header">
    <div class="buttonbox">
    <?php switch($contest['status']){
      case 1: // entry period
        echo '<a href="enter.php" class="button big entervote">Enter Now</a>'."\n";
        echo '<a href="entrants.php" class="button big view">View Entrants</a>'."\n";
        $caption = 'Enter Now!';
        break;
        
      case 2: // voting
        echo '<a href="entrants.php" class="button big entervote">Vote Now</a>'."\n";
        $caption = 'Vote Now!';
        break;
        
      case 3: // awaiting winner
        echo '<a href="entrants.php" class="button big view">View Entrants</a>'."\n";
        $caption = 'Winner(s) Announced Soon!';
        break;

      case 4: // winner
        echo '<a href="entrants.php" class="button big view">View Entrants</a>'."\n";
        $caption = 'We Have Our Winner(s)!';
        break;
    }
    
    ?>
    </div>
    <div class="clear"></div>
  </div>

  <!-- content column -->
  <div class="lcol">

    <?php echo $contest['body']; ?>
  
    <!-- winner display -->
    <?php
    if($contest['status']==4){
      $winnerHTML = $u->displayWinners();
      echo $winnerHTML;
    }
    ?>

    <?php echo '<p><em><strong>'.$contest['name'].' is brought to you by:</strong></em></p>'; ?>
    
	  
	</div>
    
  <!-- sidebar column -->
  <div class="rcol">
      
    <!-- sharing buttons -->
    <div id="shareit">
      <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $_SERVER['SCRIPT_URI']; ?>&amp;send=false&amp;layout=standard&amp;width=290&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; height:30px;" allowTransparency="true"></iframe>
      <div class="fbshare"><a href="https://www.facebook.com/dialog/feed?app_id=257993677563555&link=<?php echo $_SERVER['SCRIPT_URI']; ?>&picture=http://<?php echo $_SERVER['HTTP_HOST']._link_; ?>/images/thumb.jpg&name=<?php echo $page_title; ?>%20on%20<?php echo $contest['station_name']; ?>&caption=<?php echo $caption; ?>&description=<?php echo $contest['meta_description']; ?>&redirect_uri=http://<?php echo $_SERVER['HTTP_HOST']; ?>" target="_blank">SHARE</a></div>
    </div>
    
    
    <!-- rules -->
    <?php if($contest['contest_rules_url']!=''){ ?>
    <div class="rulesbox rounded">
    <p>For contest rules, <a href="<?php echo $contest['contest_rules_url']; ?>">CLICK HERE</a></p>
    </div>
    <?php } ?>
    

    <!-- box ad -->
    <div class="adbox">
        <div id="DARTad300x250"><script>DFP.pushAd({div:"DARTad300x250",size:"300x250",position:"3307"} );</script></div>
    </div>

 	</div>
    
  <div class="clear"></div>

</div>
<!-- end pagecontainer -->


<!-- local machine footer -->
  <?php include('../inc/footer-local.inc.php'); ?>


<!-- cc footer -->
  <!-- local scripts -->
  <!-- <script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
  <script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>-->

  <?php //nclude 'CCOMRfooter.template'; ?>