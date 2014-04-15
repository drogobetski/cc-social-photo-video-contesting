<?php
include 'lib/base.inc.php';
include 'lib/utility.class.php';
$u = new utility();

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

  <!-- header -->
  <div class="header">
    <div class="buttonbox">
    <?php switch($contest['contest_status']){
      case 1: // entry period
        echo '<a href="enter.php" class="button big entervote">Enter Now</a>'."\n";
        echo '<a href="view-entrants.php" class="button big view">View Entrants</a>'."\n";
        $caption = 'Enter Now!';
        break;
        
      case 2: // voting
        echo '<a href="vote-entrants.php" class="button big entervote">Vote Now</a>'."\n";
        $caption = 'Vote Now!';
        break;
        
      case 3: // awaiting winner
        echo '<a href="view-entrants.php" class="button big view">View Entrants</a>'."\n";
        $caption = 'Winner(s) Announced Soon!';
        break;

      case 4: // winner
        echo '<a href="view-entrants.php" class="button big view">View Entrants</a>'."\n";
        $caption = 'We Have Our Winner(s)!';
        break;
    }
    
    ?>
    </div>
    <div class="clear"></div>
  </div>

  <!-- content column -->
  <div class="lcol">

    <h2><?php echo $contest['contest_heading']; ?></h2>

    <?php echo $contest['contest_text']; ?>
  
    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>  
    
    <!-- winner display -->
    <?php
    if($contest['contest_status']==4){
      if($hasAgeGroups=='y'){
        foreach($age_group_array as $key=>$val){
          $winnerHTML .= $u->displayWinnerAg($key);
        }
      }
      else { $winnerHTML = $u->displayWinners(); }
      echo $winnerHTML;
    }
    ?>

    <?php echo '<p><em><strong>'.$contest['title'].' is brought to you by:</strong></em></p>'; ?>
    
    <!-- sponsors -->
    <?php foreach($contest['sponsors'] as $sponsor){ ?>
    
      <!-- sponsorbox (add more as needed) -->
      <div class="sponsorbox rounded">
      	<a href="<?php echo $sponsor['url']; ?>" target="_blank"><img src="images/sponsor.jpg" border="0" /></a>
      	<p><strong><a href="<?php echo $sponsor['url']; ?>" target="_blank"><?php echo $sponsor['name']; ?></a></strong><br />
      	<?php echo $sponsor['name']; ?></p>
  			<div class="clear"></div>
      </div>
    
    <?php } ?>
	  
	</div>
    
  <!-- sidebar column -->
  <div class="rcol">
      
    <!-- sharing buttons -->
    <div id="shareit">
      <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $_SERVER['SCRIPT_URI']; ?>&amp;send=false&amp;layout=standard&amp;width=290&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; height:30px;" allowTransparency="true"></iframe>
      <div class="fbshare"><a href="https://www.facebook.com/dialog/feed?app_id=257993677563555&link=<?php echo $_SERVER['SCRIPT_URI']; ?>&picture=http://<?php echo $_SERVER['HTTP_HOST']._link_; ?>/images/thumb.jpg&name=<?php echo $page_title; ?>%20on%20<?php echo $contest['station_name']; ?>&caption=<?php echo $caption; ?>&description=<?php echo $contest['meta_description']; ?>&redirect_uri=http://<?php echo $_SERVER['HTTP_HOST']; ?>" target="_blank">SHARE</a></div>
    </div>
    
    <!-- release form -->
    <?php if($contest['parental_permission']=='y'){ ?>
    <div class="rulesbox rounded colored">
    <p><a href="pdf/<?php echo _release_form_; ?>">PARENTAL RELEASE FORM</a></p>
    </div>
    <?php } ?>
    
    <!-- rules -->
    <div class="rulesbox rounded">
    <p>For contest rules, <a href="pdf/<?php echo _rules_form_; ?>">CLICK HERE</a></p>
    </div>
    
    <!-- calendar if necessary -->
    <?php if($contest['calendar']=='y'){ echo '<img src="images/calendar.jpg?x='.$x.'" class="calendar" />'; } ?>

    <!-- box ad -->
    <div class="adbox">
        <div id="DARTad300x250"><script>DFP.pushAd({div:"DARTad300x250",size:"300x250",position:"3307"} );</script></div>
    </div>

 	</div>
    
  <div class="clear"></div>

</div>
<!-- end pagecontainer -->

<!-- local scripts -->
<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

<?php include 'CCOMRfooter.template'; ?>