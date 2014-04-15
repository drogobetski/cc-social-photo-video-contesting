<?php
class Utility {

	####################f########################
	### FILE UTILITY & VALIDATION FUNCTIONS ####
	############################################
	
	// Get IP Address (Long form user IP)
	function getUserIP() {
		$ip = '';
		
		if (isset($_SERVER)){
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){ $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; }
			elseif (isset($_SERVER["HTTP_CLIENT_IP"])) { $ip = $_SERVER["HTTP_CLIENT_IP"]; }
			else { $ip = $_SERVER["REMOTE_ADDR"]; }
		}
		
		else {
			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) { $ip = getenv( 'HTTP_X_FORWARDED_FOR' ); }
			elseif ( getenv( 'HTTP_CLIENT_IP' ) ) { $ip = getenv( 'HTTP_CLIENT_IP' ); }
			else { $ip = getenv( 'REMOTE_ADDR' ); }
		}
		
		return $ip;
	} 

	
	// Clean the filename (Creates unique filename with timestamp on it)
	function cleanFilename($filename){
			$replace="-";
			$filename = strtolower(date("mdyHis").'-'.preg_replace("/[^a-zA-Z0-9\.]/",$replace,$filename));
			return $filename;
	}
	
	
	// Valid image size/dimension (Checks that image upload is correct filetype and size)
	function isValidImage($userfile,$minWidth,$maxSizeMB){
		$maxSize = $maxSizeMB*1024000;
		$x= getimagesize($userfile['tmp_name']);
		
		// check size
		if($x[0]<$minWidth){ $fail='y'; }
		if($userfile['size']==0){ $fail='y'; }
		if($userfile['size'] > $maxSize){ $fail='y'; }
		
		// check filetype
		$ext =  substr($userfile['name'],-3);
		if(!in_array($ext,unserialize(_supported_image_types_))){ $fail='y'; }
		
		if($fail=='y'){ return FALSE; }
		else { return TRUE; }
	}
	

	// Valid audio file size/dimension (Checks that file upload is correct filetype and size)
	function isValidFile($userfile,$maxSizeMB){
		$maxSize = $maxSizeMB*1024000;
		
		// check size
		if($userfile['size']==0){ $fail='y'; }
		if($userfile['size'] > $maxSize){ $fail='y'; }
		
		// check filetype
		$ext =  substr($userfile['name'],-3);;
		if(!in_array($ext,unserialize(_supported_file_types_))){ $fail='y'; }
		
		if($fail=='y'){ return FALSE; }
		else { return TRUE; }
	}


	// Valid email
	function isValidEmail($email) {
		// First, we check that there's one @ symbol, and that the lengths are right
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        	return false;
		}

        // Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
				return false;
			}
		}

		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}

            for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
					return false;
				}
            }
        }

        return true;
    }
	
	
	// clean the embed link (generates correct embed code if user pastes the actual URL instead of embed code)
	function getEmbed($link){
		// youtube
		if(substr($link,0,12)=='http://youtu' || substr($link,0,16)=='http://www.youtu'){
			$vid = substr($link,-11);
			$link = '<iframe width="560" height="349" src="http://www.youtube.com/embed/'.$vid.'?hd=1&rel=0" frameborder="0" allowfullscreen></iframe>';
		}
		
		// vimeo
		if(substr($link,0,12)=='http://vimeo' || substr($link,0,16)=='http://www.vimeo'){
			$vid = substr($link,-8);
			$link = '<iframe src="http://player.vimeo.com/video/'.$vid.'?title=0&amp;byline=0&amp;portrait=0" width="560" height="315" frameborder="0"></iframe>';
		}

		return $link;
	}

	// return short nae
	function getShortName($firstname,$lastname){
		return ucfirst(strtolower($firstname)).' '.substr(ucfirst($lastname),0,1).'.';
	}
    

    // echo short name
	function displayShortName($firstname,$lastname){
		echo ucfirst(strtolower($firstname)).' '.substr(ucfirst($lastname),0,1).'.';
	}


	#############################
	### VOTING FUNCTIONS ########
	#############################
	
	// Vote Form Display
	function displayVoteLogin($id,$ag,$errors) {
		
		// get entrant info
		$query = "select * from "._main_table_." where status='a' and id='".$id."'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		// generate name display
		$fname = ucfirst(strtolower(($row['fname'])));
		$lname = substr(strtoupper($row['lname']),0,1);
		$name = $fname.' '.$lname;
		
		// display pet name if necessary
		if(_contest_type_==3){ $name = $row['petname']; }
		
		// display the vote box
		$html = '<div class="voteBox">'."\n";
		if(_contest_type_==1 || _contest_type_==3){ $html .= '<img src="'._files_path_.'t_'.$row['userfile'].'" />'.">\n"; } 
		$html .= '<form action="" method="post" id="theform"><input type="hidden" name="sentForm" value="y" /><input type="hidden" name="id" value="'.$id.'" /><input type="hidden" name="ag" value="'.$ag.'" />';
    	$html .= $errors;
    	$html .= '<p><strong>Please enter your email to vote for '.$name.'.</strong><br />'."\n";
		$html .= '* You may vote once per valid email address per day.<br />'."\n";
		$html .= '* IP addresses are stored to avoid fake email addresses and vote falsifying.<br />'."\n";
		$html .= '* Email or vote falsifying is grounds for immediate disqualification.</p>'."\n";
		$html .= '<p class="center">Your Email:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" class="required email input" value="" /><br /><input type="submit" class="button" name="submit" value="Submit" /></p>'."\n";
		$html .= '</form>'."\n";
		$html .= '</div>'."\n";
		
		return $html;

	}

	
	// Vote Success Display
	function displayVoteSuccess($id){
		
		$userIP = $this->getUserIP();
		
		// get entrant info
		$query = "select * from "._main_table_." where status='a' and id='".$id."'";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		
		$fname = ucfirst(strtolower(($row['fname'])));
		$lname = substr(strtoupper($row['lname']),0,1);
		$name = $fname.' '.$lname;
		if(_contest_type_==3){ $name = $row['petname']; }
		
		// diplay the vote box
		$html = '<div class="voteBox">'."\n";
		if(_contest_type_==1 || _contest_type_==3){ $html .= '<img src="'._files_path_.'t_'.$row['userfile'].'" />'.">\n"; }
    	$html .= '<p>Voting from: '.$userIP.'</p>'."\n";
		$html .= '<p>Thanks for your vote!</p>'."\n";
		$html .= '<p><a href="index.php">&laquo; back to main page...</a></p>'."\n";
		$html .= '</div>'."\n";
		
		return $html;

	}
	
	
	// Check voting from this IP address and email today
	function checkForVote($vars){
		
		$userIP = $this->getUserIP();
		$today = date("Y-m-d 00:00:00");
		
		if(_age_groups_=='y'){ $agSQL = "and entrant_ag='".$vars['ag']."'"; $agText = 'in this age group '; }
		
		// check for the vote today with matching email
		$query="select email from "._voters_table_." where email='".$vars['email']."' and vote='x' ".$agSQL." and stamp >= '".$today."'";
		$result=mysql_query($query);

		// this email has already voted today
		if(mysql_num_rows($result)>0){ $voted=TRUE; $return['error'] = '<p class="error">Sorry, this email has already voted '.$agText.'today.</p>'."\n"; }
	
		
		// check for the vote today with matching ip address
		$query2 = "select count(ip_address) from "._voters_table_." where ip_address='".$userIP."' ".$agSQL." and vote='x' and stamp >= '".$today."'";
		$result2 = mysql_query($query2);
		$row2=mysql_fetch_row($result2);
		
        // this ip address has already voted the max allowed numnber of time today
		if($row2[0] >= _ipcount_){ $voted=TRUE; $return['error'] = '<p class="error">Sorry, this IP address has already voted the maximum number of times '.$agText.'today.</p>'."\n"; }
		
		// Place vote in database
		if($voted==FALSE || !isset($voted)) {
			$this->doVote($vars,$today);
			$return['success'] = '<p class="success">Thanks for your vote!</p>';
		}
		
		return $return;
	
	}

	
	// Create record for user for current day and add vote	
	function doVote($vars,$today){
		
		$userIP = $this->getUserIP();
		if(_age_groups_=='y'){ $agSQL = "and entrant_ag='".$vars['ag']."'"; $agText = 'in this age group '; }
		
		// check for the vote today with matching email
		$query="select email from "._voters_table_." where email='". $vars['email'] ."' ".$agSQL." and stamp >= '". $today ."'";
		$result=mysql_query($query);
		
		// haven't voted yet today
		if(mysql_num_rows($result)==0){
			
			// log the voter in the voters table
			$query="insert into "._voters_table_."(id,ip_address,stamp,email,vote,entrant_id,entrant_ag) VALUES('','$userIP',NOW(),'$vars[email]','x','$vars[id]','$vars[ag]')";
			$result=mysql_query($query);
			
			// add a vote to that entrant's record
			$query="update "._main_table_." set votes=votes+1 where id='$vars[id]' ";
			$result=mysql_query($query);

		}
		
	}
	
	
	################################
	### DISPLAY FUNCTIONS ##########
	################################
	
	// Generate galleries
	function generateGalleries( $type , $offset='' , $galleryid=1 , $groupID='' ){
		
		// for contest with different groups
		if($groupID !=''){ $whereSQL = "and group_id='" . $groupID . "'"; }
		
		// select entrants
		$q = "select * from " . _main_table_ . " where status='a' " . $whereSQL . " order by fname asc, lname asc";
		$r = mysql_query($q);
		
		// how many galleries will there be?
		$totGalleries = ceil(mysql_num_rows($r)/_perGallery_);
		
		$i=1;
		
		$html  = '<!-- Start Gallery Tabs -->'."\n";
		$html .= '<div class="tabsbox">'."\n";
		
		while($i <= $totGalleries){
			$startRow = ($i-1)*_perGallery_;
			$endRow = $i*(_perGallery_-1);
			if($i==$totGalleries){ $endRow = (mysql_num_rows($r)-1); }
			$thumb = mysql_result($r,$startRow,'userfile');
			
			// get some specified variables
			switch(_contest_type_){
				
				// photo upload contest
				case 1:
				$thumbImg = '<img src="'._files_path_.'t_'.$thumb.'" />';
				$thumbImgActive = '<img src="'._files_path_.'t_'.$thumb.'" />';
				$startFirstName = mysql_result($r,$startRow,'fname');
				$startLastName = mysql_result($r,$startRow,'lname');
				$endFirstName = mysql_result($r,$endRow,'fname');
				$endLastName = mysql_result($r,$endRow,'lname');
				break;
				
				// video contest
				case 2:
				$thumbImg = 'View this Gallery';
				$thumbImgActive = '<strong>Current Gallery</strong>';
				$startFirstName = mysql_result($r,$startRow,'fname');
				$startLastName = mysql_result($r,$startRow,'lname');
				$endFirstName = mysql_result($r,$endRow,'fname');
				$endLastName = mysql_result($r,$endRow,'lname');
				break;
				
				// pet contest
				case 3:
				$thumbImg = '<img src="'._files_path_.'t_'.$thumb.'" />';
				$thumbImgActive = '<img src="'._files_path_.'t_'.$thumb.'" />';
				$startFirstName = mysql_result($r,$startRow,'petname');
				$startFirstName = ucfirst(strtolower($startFirstName));
				$startLastName = '';
				$endFirstName = mysql_result($r,$endRow,'petname');
				$endFirstName = ucfirst(strtolower($endFirstName));
				$endLastName = '';
				break;
				
				// audio upload contest
				case 2:
				$thumbImg = 'View this Gallery';
				$thumbImgActive = '<strong>Current Gallery</strong>';
				$startFirstName = mysql_result($r,$startRow,'fname');
				$startLastName = mysql_result($r,$startRow,'lname');
				$endFirstName = mysql_result($r,$endRow,'fname');
				$endLastName = mysql_result($r,$endRow,'lname');
				break;
			}
			
			
			// generate the gallery tabs (div.gallerytab)
			if(($offset/_perGallery_)+1==$i){ 
			    $thumbImg=$thumbImgActive;
			    $html .= '<div class="gallerytab active"><strong>Gallery '.$i.'</strong><br />'.$this->getShortName($startFirstName,$startLastName).'- '.$this->getShortName($endFirstName,$endLastName).'<br />'.$thumbImg.'</div>'."\n";
			} else {
				$html .= '<div class="gallerytab">Gallery '.$i.'<br />'.$this->getShortName($startFirstName,$startLastName).'- '.$this->getShortName($endFirstName,$endLastName).'<br /><a href="'.$type.'-entrants.php?ag='.$_GET['ag'].'&gid='.$i.'">'.$thumbImg.'</a>'.'</div>'."\n";
			}
			
			$i++;
		}
		
		$html .= '</div>'."\n";
		$html .= '<!-- End Gallery Tabs -->'."\n";
		
		return $html;
	}
	
	
	// Generate the user file display
	function displayEntrants( $type , $perGallery , $id = '' , $gid = '' , $ageGroup = '' ){
		
		if(!isset($gid)){ $gid=1; }
		if(!isset($id)) { $id=1; }
		
        // set offset according to gallery
		$offset = ($gid-1)*$perGallery;
		
		$orderby = 'fname asc, lname asc';
		if(_contest_type_==3){ $orderby = 'petname asc'; }
		
		if($ageGroup !=''){ $whereSQL = "and group_id='".$ageGroup."'"; }
		
		$q = "select * from "._main_table_." where status='a' ".$whereSQL." order by ".$orderby." limit ".$offset.",".$perGallery;
		$r = mysql_query($q);
		$tots = mysql_num_rows($r);
		
		// we have results
		if(mysql_num_rows($r)){
		
			if($tots<$perGallery){
				$galleryTotal = $tots;
			} else {
				$galleryTotal = $perGallery;
			}
		
			$x=1;
			$z=rand(1,9999);
			
			$openhtml = '<!-- Start Gallery Display -->'."\n";
			$openhtml .= '<div class="galleryDisplay">'."\n";
		
			// previous slide button
			$prevhtml = '<a href="#" onclick="picframe.location.href=\'picview.php\'" id="prev1" class="slidemover"><img src="images/prev-btn.gif" border="0" class="slidebtn" /></a>';
			
			$currhtml  = '<!-- Start Slider Box -->';
			$currhtml .= '<div id="contentbox">';
			
			// Loop through entrants
			while($row = mysql_fetch_array($r)){
				
				
				// get some specified variables
				switch(_contest_type_){
					
					// photo upload contest
					case 1:
					    $content = '<img src="'._files_path_.$row['userfile'].'?x='.$z.'" class="galleryImage" width="480" height="400" />'."\n";
					    $thumb = _files_path_.'t_'.$row['userfile'];
					break;
					
					// audio video contest
					case 2:
						
						// Video
						if($row['embed']!=''){ $content = urldecode($row['embed']); }
						
						// Audio
						else {
							$content  = '<script language="JavaScript" src="js/audio-player.js"></script>'."\n";
							$content .= '<center><object type="application/x-shockwave-flash" data="js/player.swf" id="audioplayer1" height="24" width="180">'."\n";
							$content .= '<param name="movie" value="js/player.swf">'."\n";
							$content .= '<param name="FlashVars" value="playerID=1&amp;soundFile=userfiles/'.$row['userfile'].'">'."\n";
							$content .= '<param name="quality" value="high">'."\n";
							$content .= '<param name="menu" value="false">'."\n";
							$content .= '<param name="wmode" value="transparent">'."\n";
							$content .= '</object></center>'."\n";
						}

						$thumb = 'images/thumb.jpg';

					break;
					
					// pet contest
					case 3:
					    $content = '<img src="'._files_path_.$row['userfile'].'?x='.$z.'" class="galleryImage" width="480" height="400" />'."\n";
					    $row['fname'] = ucfirst(strtolower($row['petname']));
					    $thumb = _files_path_.'t_'.$row['userfile'];
					break;
				}
				
				$currhtml .= '<div style="text-align:center;"><strong>'._title_.' - Gallery '.$gid.'<br />'.$this->getShortName($row['fname'],$row['lname']).'</strong><br /><strong>'.$x.'</strong> of <strong>'.$galleryTotal.'</strong> in this gallery<br /><br />'.$content."\n";
				
				// add vote/share button
				if($type=='vote') {
					$currhtml .= '<form action="vote.php" method="post"><input type="hidden" name="id" value="'.$row['id'].'" /><input type="hidden" name="ag" value="'.$_GET['ag'].'" /><input type="submit" class="button" value="Vote For Me" /><a href="https://www.facebook.com/dialog/feed?app_id=257993677563555&link='.$_SERVER['SCRIPT_URI'].'%23'.$x.'&picture=http://'.$_SERVER['HTTP_HOST']._link_.'/'.$thumb.'&name='.$this->getShortName($row['fname'],$row['lname']).'-'._title_.'&caption=Vote%20Now!&description='._meta_description_.'&redirect_uri=http://'.$_SERVER['HTTP_HOST'].'" target="_blank" class="button share">Share on Facebook</a></form>';
					$currhtml .= '<p><strong>Get everyone you know to vote!<br />Share '.ucfirst(strtolower($row['fname'])).'\'s link elsewhere!</strong><br /><input type="text" class="input sharebox" value="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'#'.$x.'" /></p>';
				}
				
				$currhtml .= '</div>';
				$x++;
				
			}
			
			$currhtml .= '</div>'."\n";
			$currhtml .= '<!-- End Slider Box -->';
			
			// next button td
			$nexthtml = '<a href="#" onclick="picframe.location.href=\'picview.php\'" id="next1" class="slidemover"><img src="images/next-btn.gif" border="0" class="slidebtn" /></a>';
				
			$closehtml = '</div>'."\n";
			
			
			// Combine with gallery tabs
			$html = $this->generateGalleries( $type , $offset , $gid , $ageGroup );
			$html .= '<p class="galleryPage"><a href="'._link_.'">&laquo; back to mainpage</a></p>';
			$html .= $openhtml.$prevhtml.$currhtml.$nexthtml.$closehtml;
			}
		
		else {
			$html = '<p>&nbsp;</p><p>There are no current entrants.</p><p>&nbsp;</p><p>&nbsp;</p>'."\n";
		}
		
		return $html;
	}
	

	// display winner on the index page
	function displayWinners(){
		$query="select * from "._main_table_." where status='w' order by group_id asc, votes desc";
		$result=mysql_query($query); 
		
		// Loop through entrants
		while($row = mysql_fetch_array($result)){
				
				$html = '<p><strong>'.$this->getShortName($row['fname'],$row['lname']).'.</strong><br />';
				
				// Photo Contest
				if(_contest_type_==1){
					$html .= '<img src="'._files_path_.$row['userfile'].'" class="galleryImage" width="480" height="400" />'."\n";
				}
				
				// A/V Contest
				if(_contest_type_==2){
					
					// Video
					if($row['embed']!=''){
						$html .= urldecode($row['embed']);
					}
					
					// MP3
					else {
						$html .= '<script language="JavaScript" src="js/audio-player.js"></script>'."\n";
                    	$html .= '<center><object type="application/x-shockwave-flash" data="js/player.swf" id="audioplayer1" height="24" width="180">'."\n";
                    	$html .= '<param name="movie" value="js/player.swf">'."\n";
                    	$html .= '<param name="FlashVars" value="playerID=1&amp;soundFile=userfiles/'.$row['userfile'].'">'."\n";
                    	$html .= '<param name="quality" value="high">'."\n";
                    	$html .= '<param name="menu" value="false">'."\n";
                    	$html .= '<param name="wmode" value="transparent">'."\n";
                    	$html .= '</object></center>'."\n";
					}
				
				}
				
				// Photo Contest
				if(_contest_type_==3){
					$html .= '<img src="'._files_path_.$row['userfile'].'" class="galleryImage" width="480" height="400" />'."\n";
				}

				$html .= '</p>'."\n";
		}
		
		return $html;
	}


	// display winner on the index page
	function displayWinnerAg($ageGroupID){
		$query = "select * from "._main_table_." where status='w' and group_id = '".$ageGroupID."' order by votes desc";
		$result = mysql_query($query);

		foreach($age_group_array as $key=>$val){
			if($key==$ageGroupID){ $ageGroup = $val; }
		}
		
		// Loop through entrants
		while($row = mysql_fetch_array($result)){
				
				$html .= '<p>'.$ageGroup.'<br /><strong>'.$this->getShortName($row['fname'],$row['lname']).'.</strong><br />';
				
				// Photo Contest
				if(_contest_type_==1){
					$html .= '<img src="'._files_path_.$row['userfile'].'" class="galleryImage" width="480" height="400" />'."\n";
				}
				
				// A/V Contest
				if(_contest_type_==2){
					
					// Video
					if($row['embed']!=''){
						$html .= urldecode($row['embed']);
					}
					
					// MP3
					else {
						$html .= '<script language="JavaScript" src="js/audio-player.js"></script>'."\n";
                    	$html .= '<center><object type="application/x-shockwave-flash" data="js/player.swf" id="audioplayer1" height="24" width="180">'."\n";
                    	$html .= '<param name="movie" value="js/player.swf">'."\n";
                    	$html .= '<param name="FlashVars" value="playerID=1&amp;soundFile=userfiles/'.$row['userfile'].'">'."\n";
                    	$html .= '<param name="quality" value="high">'."\n";
                    	$html .= '<param name="menu" value="false">'."\n";
                    	$html .= '<param name="wmode" value="transparent">'."\n";
                    	$html .= '</object></center>'."\n";
					}
				
				}
				
				// Photo Contest
				if(_contest_type_==3){
					$html .= '<img src="'._files_path_.$row['userfile'].'" class="galleryImage" width="480" height="400" />'."\n";
				}

				$html .= '</p>'."\n";
		}
		
		return $html;
	}
	
	
	#######################################
	### SUBMISSION DISPLAYS ###############
	#######################################
	
	function displaySubmitForm($errors='') {
		$html .= '<fieldset>';
    	$html .= '<legend>'._title_.' Submission Form</legend>'."\n";
    	$html .= '<p class="small center"><em>* All fields are required</em></p>'."\n";
		$html .= $errors['message'];
    	$html .= '<form action="" id="theform" method="post" enctype="multipart/form-data">'."\n";
    	$html .= '<input type="hidden" name="preForm" value="y" /><input type="hidden" name="MAX_FILE_SIZE" value="'.(_max_file_size_*1024000).'" />'."\n";
    	
		$html .= '<p><label class="form">Entrant\'s First Name *</label>'."\n";
    	$html .= '<input type="text" class="input required" name="fname" /></p>'."\n";
		
		$html .= '<p><label class="form">Entrant\'s Last Name *</label>'."\n";
    	$html .= '<input type="text" class="input required" name="lname" /></p>'."\n";
		
		
		
		// Age groups
		if(_age_groups_=='y'){
			$html .= '<p><labe class="form"l>Age Group *</label>' . "\n";
    		$html .= '<select name="group_id" validate="required:true">';
			global $age_group_array;
			foreach($age_group_array as $value=>$name){
				$html .= '<option value="' . $value . '">' . $name . '</option>' . "\n";	
			}
			$html .= '</select>' . "\n";
		}

		
		// Pet contest
		if(_contest_type_==3){ 
			$html .= '<p><label class="form">Your Pet\'s Name *</label>' . "\n";
    		$html .= '<input type="text" class="input" name="petname required" /></p>' . "\n";
		}
		
		
		// Group Contest
		if(_group_contest_=='y'){ 
			$html .= '<p><label class="form">Group Name</label>' . "\n";
    		$html .= '<input type="text" class="input" name="groupname required" /></p>'."\n";
		}
		
		
		// Permission form
		if(_parent_permission_=='y'){ 
			$html .= '<p><label class="form">Parent/Guardian Name</label class="form">'."\n";
    		$html .= '<input type="text" class="input" name="pgname" /></p>'."\n";
		}
    	
		$html .= '<p><label class="form">Contact Email *</label>'."\n";
    	$html .= '<input type="text" class="input required email" name="email" /></p>'."\n";
    	
    	$html .= '<p><label class="form">Phone *</label>'."\n";
    	$html .= '<input type="text" class="input required" name="phone" /></p>'."\n";
    	
		$html .= '<p><label class="form">I am 18 or older *</label>'."\n";
    	$html .= '<input type="checkbox" class="checkbox" name="misc_1" validate="required:true" /></p>'."\n";
		
		
    	
		switch(_contest_type_){
			
			case 1:
			$html .= '<p>&nbsp;</p>'."\n";
			$html .= '<p><label '.$errors['img'].' class="form">Upload Image *<br /><span class="subtext">Must be a .jpg or .gif file at least '._orig_w_.'px wide.</span><br /><span class="subtext">Max file size: '._max_file_size_.'MB</span></label>'."\n";
    		$html .= '<input type="file" name="image" id="image" class="input required" /></p>'."\n";
			break;
			
			case 2:
			$html .= '<div class="videoinstructions">';
			$html .= '<p><strong>STOP! PLEASE READ CAREFULLY:</strong></p>'."\n";
			$html .= '<ol>'."\n";
			$html .= '<li>You must first upload your video to YouTube (or similar). If you do not have a YouTube account, please visit <a href="http://www.youtube.com" target="_blank">YouTube</a> and create an account. YouTube is FREE.</li>'."\n";
			$html .= '<li>Once you have uploaded your video to YouTube (or similar), find the SHARE link for your YouTube located directly underneath your video by pressing the SHARE button (it\'s a grey square).</li>'."\n";  
			$html .= '<li>When you press the SHARE button, you will see a long code that looks similar to this: <strong>http://youtu.be/giMuPCce04M</strong></li>'."\n";
			$html .= '<li>COPY and PASTE that code into the "PASTE VIDEO SHARE URL" field here on the Entry Page.</li>'."\n";
			$html .= '<li>PLEASE MAKE SURE YOUR VIDEO IS SET TO "PUBLIC" so that everyone can view it. Videos set to "private" will not be entered into the contest.</li>'."\n";
			$html .= '</ol>'."\n";
			$html .= '<p>***WE ARE NOT RESPONSIBLE for entries that are submitted incorrectly.***</p></div>';
			$html .= '<p><label '.$errors['embed'].' class="form">Paste Video Share URL *<br /><span class="subtext">(Link to the video. i.e. <em>http://youtu.be/giMuPCce04M)</em></span></label>'."\n";
    		$html .= '<textarea name="embed" class="textarea required"></textarea></p>'."\n";
			break;
			
			case 3:
			$html .= '<p><label '.$errors['img'].' class="form">Upload Image *<br /><span class="subtext">Must be a .jpg or .gif file at least '._orig_w_.'px wide.</span><br /><span class="subtext">Max file size: '._max_file_size_.'MB</span></label>'."\n";
    		$html .= '<input type="file" name="image" id="image" class="input required" /></p>'."\n";
			break;
			
			case 4:
			$html .= '<p><label '.$errors['userfile'].' class="form">Upload an .MP3 file from your computer *<br /><span class="subtext">Max size: '._max_file_size_.'MB</span></label>'."\n";
    		$html .= '<input type="file" name="userfile" /></p>'."\n";
			break;
			
		}
    	
		$html .= '<div class="clear"></div>'."\n";
    	$html .= '<p class="center"><input type="submit" name="submit" class="button wide" value="Enter Now!" /></p>'."\n";
    	$html .= '</form>'."\n";
    	$html .= '</fieldset>'."\n";
		
		return $html;
	}
	
	
	// Submitted form data for verification
	function displaySubmittedData($vars,$filename) {
		$html .= '<fieldset>';
    	$html .= '<legend>'._title_.' Submission Form</legend>'."\n";
    	
		// form with hidden fields
		$html .= '<form action="" method="post" enctype="multipart/form-data">'."\n";
    	$html .= '<input type="hidden" name="sentForm" value="y" />'."\n";
    	$html .= '<input type="hidden" name="MAX_FILE_SIZE" value="'.(_max_file_size_*1024).'" />'."\n";
		$html .= '<input type="hidden" name="filename" value="'.$filename.'" />'."\n";
    	$html .= '<input type="hidden" name="fname" value="'.$vars['fname'].'" />'."\n";
		$html .= '<input type="hidden" name="lname" value="'.$vars['lname'].'" />'."\n";
		$html .= '<input type="hidden" name="pgname" value="'.$vars['pgname'].'" />'."\n";
		$html .= '<input type="hidden" name="groupname" value="'.$vars['groupname'].'" />'."\n";
		$html .= '<input type="hidden" name="group_id" value="'.$vars['group_id'].'" />'."\n";
		$html .= '<input type="hidden" name="petname" value="'.$vars['petname'].'" />'."\n";
		$html .= '<input type="hidden" name="email" value="'.$vars['email'].'"/>'."\n";
		$html .= '<input type="hidden" name="phone" value="'.$vars['phone'].'"/>'."\n";
		
        // misc variables for general usage
		$html .= '<input type="hidden" name="misc_1" value="'.$vars['misc_1'].'"/>';
		$html .= '<input type="hidden" name="misc_2" value="'.$vars['misc_2'].'"/>';
		$html .= '<input type="hidden" name="misc_3" value="'.$vars['misc_3'].'"/>';
		$html .= '<input type="hidden" name="misc_4" value="'.$vars['misc_4'].'"/>';
		$html .= '<input type="hidden" name="misc_5" value="'.$vars['misc_5'].'"/>';
		
		$html .= '<h2>Entrant Info:</h2>';
		$html .= '<p><strong>'.$vars['fname'].' '.$vars['lname'].'</strong> - '.$vars['email'].' - '.$vars['phone'].'</p>'."\n";
		
		// show age group
		if(_age_groups_=='y'){
			$html .= '<p><strong>Age Group'."\n";
    		
			global $age_group_array;
			foreach($age_group_array as $value=>$name){
				if($value==$vars['group_id']){ $html .= '</strong><br />'.$name; }
			}
			
			$html .= '</p>'."\n";
		}
		
		// show parent/guardian name
		if(_parent_permission_=='y'){
			$html .= '<p><strong>Parent/Guradian\'s Name'."\n";
    		$html .= '</strong><br />'.$vars['pgname'].'</p>'."\n";
		}
		
		// show group name
		if(_group_contest_=='y'){
			$html .= '<p style="margin-left:40px;"><strong>Group\'s Name'."\n";
    		$html .= '</strong><br />'.$vars['groupname'].'</p>'."\n";
		}
		
		// show petname
		if(_contest_type_==3){ 
			$html .= '<p><strong>Your Pet\'s Name'."\n";
    		$html .= '</strong><br />'.$vars['petname'].'</p>'."\n";
		}
		
    	
		$html .= '<p>&nbsp;</p>';
		$html .= '<h>Time to crop your image!</h2><h3 style="margin:10px 40px;">Click and drag your mouse over the large selection and check the thumbnail on the right to see what it will look like.</h3><h3 style="margin:10px 40px;">Then click the "CROP" button to finalize.</h3>';
		
		return $html;
	
	}
	
	
	// Successful submission
	function displaySuccess($filename) {
		$html .= '<fieldset>';
    	$html .= '<legend>'._title_.' Submission Form</legend>';
    	$html .= '<p>&nbsp;</p>'."\n";
		$html .= '<p><strong>Thank you for submitting your entry into the contest!</strong></p>'."\n";
		$html .= '<p><strong>*** Remember, your entry will not appear on the site until it is approved! May take up to 48 hrs.</strong></p>'."\n";
		
		// release form
		if(_parental_permission_=='y'){
			$html .= '<p>Dont forget! - <strong><a href="pdf/'._release_form_.'" target="_blank">Download the parental release form here</a>.</strong></p>';
		}
		
		// show image if there is one
		if(_contest_type_==1  || _contest_type_==3) {
			$html .= '<p><strong>Image:</strong><br />';
			$html .= '<img src="userfiles/'.$filename.'?x='.rand(1,9999).'" />';
			$html .= '</p>'."\n";
		}
		
    	$html .= '<p><a href="'._link_.'" target="_top">Click here</a> to return to main <strong>'._title_.'</strong> page.</p>'."\n";
		$html .= '</fieldset>'."\n";

		return $html;

	}
	
	
	#######################################
	### DATA RETRIEVAL FUNCTIONS ##########
	#######################################
	
	// get basic item detail
	function getEntryDetail($id) {
		$query = "select * from "._main_table_." where id='$id'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		$html .= '<p><strong>'.$row['fname'].' '.$row['lname'].'</strong></p>';
		$html .= '<p><img src="'._files_path_.$row['userfile'].'" width="480"/></p>';
		
		return $html;
	}
	
	// get item details in result form
	function getEntryDetailAdmin($id) { 
		$query = "select * from "._main_table_." where id='$id'";
		$result = mysql_query($query);		
		return $result;
	}
	
	
	#############
	### ADMIN ###
	#############
	
	// login to admin
	function displayAdminLogin($errors=''){
		$html .= '<p class="maintext">Please log in to the admin below:</p>';
		$html .= '<form id="theform" method="post" action="">'."\n";
		$html .= '<input type="hidden" name="sentForm" value="y" />'."\n";
		$html .= '<p><label>Username</label><input type="text" name="uname" class="required" /></p>'."\n";
		$html .= '<p><label>Password</label><input type="password" name="pword" class="required" /></p>'."\n";
        $html .= '<p><label>&nbsp;</label><input type="submit" class="button" name="submit" value="Submit" /></p>'."\n";
		$html .= '</form>'."\n";
		return $html;
	}
	
	
	// Show entrants
	function displayAdminEntrants(){
		$success='y';
		$query = "select * from "._main_table_." where status='".$_GET['status']."' order by lname asc";
		$result = mysql_query($query);
		$number = mysql_num_rows($result);
		
		if($_GET['status']=='p'){$newStatus='a'; $type = 'Pending'; $activeLink = '<strong>PENDING ENTRANTS</strong>'; $inactiveLink = '<strong><a href="index.php?status=a">VIEW ACTIVE ENTRANTS</a></strong>';  }
		if($_GET['status']=='a'){$newStatus='p'; $type = 'Active'; $activeLink = '<strong>ACTIVE ENTRANTS</strong>'; $inactiveLink = '<strong><a href="index.php?status=p">VIEW PENDING ENTRANTS</a></strong>'; }
		
		$html .= '<p>'.$activeLink.' - '.$inactiveLink.'<br />'."\n";
	
		$html .= 'Total <strong>'.$type.'</strong> Entrants: <strong>'.$number.'</strong></p>'."\n";
		$html .= '<form action="" method="post"><input type="hidden" name="statusUpdate" value="y" /><input type="hidden" name="newStatus" value="'.$newStatus.'" />';
		$html .= '<input type="submit" name="submit" class="button" value="Update Statuses" />';
		$html .= '<table class="adminTable" cellspacing="0">'."\n";
		$html .= '<tr class="theader"><td>Entrant</td><td>Votes</td><td>Contact Email</td><td>Details</td><td>Status</td><td>Change Status</td><td>Delete</td></tr>'."\n";
		
		while($row = mysql_fetch_array($result)){
			if($color=="#ffffff"){ $color="#e9e9e9"; }
			else{ $color="#ffffff"; }
			if($row['status']=="p"){ $flagchange="a";
			$class='style="color:#990000;"'; }
			else { $flagchange="p"; }
			if($row['status']=='a'){ $status="Active"; }
			else { $status="Pending"; }
			$entered =strtotime($row['date_entered']);
			$entered = date('m/d/y',$entered);
			$html .= '<tr bgcolor="'.$color.'">'."\n";
			$html .= '<td><strong>'.ucfirst($row['lname']).', '.ucfirst($row['fname']).'</strong></td><td>'.$row['votes'].'</td><td><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td><td><a class="inline" href="#entrant'.$row['id'].'" >View</a></td><td>'.$status.'</td><td '.$class.'><input type="checkbox" name="entrants[]" value="'.$row['id'].'" /></td><td><a href="javascript:centerPop(\'delete-entrant.php?id='.$row['id'].'\',\'pop\',300,300)"><img src="../images/delete-btn.gif" border="0" /></a></td>'."\n";
			$html .= '</tr>'."\n";
			$html .= '<div style="display:none"><div id="entrant'.$row['id'].'">'.$this->displayAdminDetail($row['id']).'</div></div>';
			$audio="";
			$video="";
		}
		
		$html .= '</table>'."\n";
		$html .= '</form>'."\n";
		
		return $html;
	}
	
	function displayAdminDetail($id){
	
		$query = "select * from "._main_table_." where id='$id'";
		$result = mysql_query($query);
		
		while($row = mysql_fetch_array($result)){
			if($row['status']=="a"){ $status="Active"; }
			if($row['status']=="p"){ $status="Pending"; }
			$entered =strtotime($row['date_entered']);
			$entered = date('m-d-Y',$entered);
			
			if(_contest_type_==1){
				$name = $row['fname'].' '.$row['lname'];
			}
			
			if(_contest_type_==3){
				$name = $row['petname'];
			}
			
			if(_group_contest_=='y'){
				$name = $row['groupname'];
			}
			
			// Video
			if(_contest_type_ ==2){
			
				if($row['embed']!=''){
					$content = urldecode($row['embed']);
				}
					
				// MP3
				else {
					$content = '<script language="JavaScript" src="../js/audio-player.js"></script>'."\n";
					$content .= '<center><object type="application/x-shockwave-flash" data="../js/player.swf" id="audioplayer1" height="24" width="180">'."\n";
					$content .= '<param name="movie" value="../js/player.swf">'."\n";
					$content .= '<param name="FlashVars" value="playerID=1&amp;soundFile=../userfiles/'.$row['userfile'].'">'."\n";
					$content .= '<param name="quality" value="high">'."\n";
					$content .= '<param name="menu" value="false">'."\n";
					$content .= '<param name="wmode" value="transparent">'."\n";
					$content .= '</object></center>'."\n";
				}
			}
			else {
					
				$content .=  '<img src="../'._files_path_.$row['userfile'].'?x='.$x.'" style="border:1px solid #e4e4e4;" width="480" height="400" /></div>'."\n";
					
			}
			
			$html .=  '<div class="admindetail"><h2>'.$name.' - ('.$row['votes'].' votes)</h2>';
			$html .=  '<p>Date Entered: <strong>'.$entered.'</strong></p>'."\n";
			$html .=  '<strong><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></strong> &middot; <strong>'.$row['phone'].'</strong><br />'."\n";
			
			$html .=  'Status: <strong>'.$status.'</strong></p>'."\n";
			
			$html .=  $content.'</div>'."\n";
		}
		
		return $html;
	
	}
	
	
	// status updater
	function updateStatus($status,$entrantID){
		$updateQuery = "update "._main_table_." set status = '".$status."' where id='".$entrantID."'";
		$updateResult = mysql_query($updateQuery);
	}
	
	
	// login credential checker
	function checkPassword($vars){
		$q = "select uname from " . _admin_table_ . " where uname='" . $vars['uname'] . "' and pword = '" . $vars['pword'] . "'";
		$r = mysql_query($q);
		if(mysql_num_rows($r)>0){
			return true;
		}
		else {
		    return false;
		}
	}
	
	
	#######################################
	### DATA INSERTION ####################
	#######################################
	
	function doData($vars) {
		
		if($_FILES['userfile']['size']>0){
			if(!$vars['filename']){ $vars['filename'] = $this->cleanFilename($_FILES['userfile']['name']); }
			move_uploaded_file($_FILES['userfile']['tmp_name'],'userfiles/'.$vars['filename']);
		}
		
		$embed = $this->getEmbed($vars['embed']);
		
		$query = "insert into "._main_table_." (id,date_entered,fname,lname,pgname,petname,groupname,group_id,misc_1,misc_2,embed,userfile,email,phone,status) VALUES('',NOW(),'".ucfirst(strtolower($vars['fname']))."','".ucfirst(strtolower($vars['lname']))."','$vars[pgname]','".ucfirst(strtolower($vars['petname']))."','$vars[groupname]','$vars[group_id]','$vars[misc_1]','$vars[misc_2]','$embed','$vars[filename]','$vars[email]','$vars[phone]','p')";
		$result = mysql_query($query);
	}
	
	
	function deleteData($id) {
		$query = "delete from "._main_table_." where id='".$id."'";
		$result = mysql_query($query);
	}
	
	
	function displayDeleteForm($id) {
		$query = "select fname,lname,groupname,petname,userfile from "._main_table_." where id='".$id."'";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		
		$name =$row['fname'].' '.$row['lname'];
		if(_group_contest_=='y'){ $name = $row['groupname']; }
		if(_contest_type_==3){ $name = $row['petname']; }
		
		$html .= '<form action="" method="post"><input type="hidden" name="sentForm" value="y" /><input type="hidden" name="id" value="'.$id.'" />'."\n";
		$html .= '<p>Are you sure you want to delete<br /><strong>'.$name.'</strong>?';
		$html .= '<br /><img src="../'._files_path_.'t_'.$row['userfile'].'" style="border:1px solid #e4e4e4;" width="120" height="100" /></p>'."\n";
		$html .= '<p><input type="submit" name="submit" class="button" value="Delete This Entrant" /></p>'."\n";
		$html .= '</form>'."\n";
		return $html;
	}
	
	
	function displayDeleteSuccess() {
		$html .= '<p>Entrant successfully deleted.</p>'."\n";
		$html .= '<p><a class="submit" href="javascript:closeReload()">Close Window<a></p>'."\n";
		return $html;
	}
	
	
	#######################################
	### IMAGE CROPPING FUNCTIONS ##########
	#######################################
	
	// Display headers
	function displayCropHeaders($orig_w,$orig_h){
		$html .= '<script src="js/jquery.Jcrop.pack.js?x=123"></script>
			<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
			<script type="text/javascript">
				$(function(){
					$(\'#cropbox\').Jcrop({
						aspectRatio: '._pic_ratio_.',
						setSelect: [0,0,'.$orig_w.','.$orig_h.'],
						onSelect: updateCoords,
						onChange: updateCoords
					});
				});
				
				function updateCoords(c)
				{
					showPreview(c);
					$("#x").val(c.x);
					$("#y").val(c.y);
					$("#w").val(c.w);
					$("#h").val(c.h);
				}
				
				function showPreview(coords)
				{
					var rx = 240 / coords.w;
					var ry = 200 / coords.h;
					
					$("#preview img").css({
						width: Math.round(rx*'.$orig_w.')+\'px\',
						height: Math.round(ry*'.$orig_h.')+\'px\',
						marginLeft:\'-\'+  Math.round(rx*coords.x)+\'px\',
						marginTop: \'-\'+ Math.round(ry*coords.y)+\'px\'
					});
				}
			</script>
			<style type="text/css">
				#preview
				{
					width: 240px;
					height: 200px;
					overflow:hidden;
				}
			</style>';
		return $html;
	}
	
	
	// Crop display
	function displayImageCrop($filename){
		$html ='<table style="margin-left:30px;">
			<tr>
				<td style="padding:8px;">
					<img src="'._files_path_.$filename.'" id="cropbox" alt="cropbox" />	
				</td>
				<td valign="top" style="padding:8px;">
					<h2 style="margin-top:0;">Thumb Preview:</h2>
					<div id="preview">
						<img src="'._files_path_.$filename.'" alt="thumb" />
					</div>
					<p>&nbsp;</p>
					<input type="submit" class="button" name="submit" value="Click to Crop Image" />
				</td>
			</tr>
		</table>
			<p>
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
			</p>
		</form>';
		return $html;
	}
	
	// Prep image
	function prepImages($image,$orig_w){
		$imageFile = $image['tmp_name'];
		$filename = $this->cleanFilename(basename( $image['name']));
		
		list($width, $height) = getimagesize($imageFile);
		
		$src = imagecreatefromjpeg($imageFile);
		$orig_h = ($height/$width)* $orig_w;
		$tmp = imagecreatetruecolor($orig_w, $orig_h);
		imagecopyresampled($tmp, $src, 0,0,0,0,$orig_w,$orig_h,$width,$height);
		imagejpeg($tmp, _files_path_.$filename,100);
		
		imagedestroy($tmp);
		imagedestroy($src);
		
		$imgData = array();
		$imgData['filename'] = urlencode($filename);
		$imgData['orig_w'] = $orig_w;
		$imgData['orig_h'] = $orig_h;
		return $imgData;
	}
	
	
	// Create images
	function doCrop($vars,$filename){
		
		// Do main
		$main_src = imagecreatefromjpeg(_files_path_.$filename);
	
		$main_tmp = imagecreatetruecolor(_pic_w_, _pic_h_);
		imagecopyresampled($main_tmp, $main_src, 0,0,$vars['x'],$vars['y'],_pic_w_,_pic_h_,$vars['w'],$vars['h']);
		imagejpeg($main_tmp,_files_path_.$filename,100);
		
		imagedestroy($main_tmp);
		imagedestroy($main_src);
	}
	
	function doThumb($name){
		$thumb_src = imagecreatefromjpeg(_files_path_.$name);
	
		$thumb_tmp = imagecreatetruecolor(_thumb_w_, _thumb_h_);
		imagecopyresampled($thumb_tmp, $thumb_src, 0,0,0,0,_thumb_w_,_thumb_h_,480,400);
		imagejpeg($thumb_tmp,_files_path_.'t_'.$name,100);
		
		imagedestroy($thumb_tmp);
		imagedestroy($thumb_src);
	}


	// MOBILE
	function displayEntrantsMobile( $type , $perGallery , $id = '' , $gid = '' , $ageGroup = '' ){
		
		if(!isset($gid)){ $gid=1; }
		if(!isset($id)) { $id=1; }
		
        // set offset according to gallery
		$offset = ($gid-1)*$perGallery;
		
		$orderby = 'fname asc, lname asc';
		if(_contest_type_==3){ $orderby = 'petname asc'; }
		
		if($ageGroup !=''){ $whereSQL = "and group_id='".$ageGroup."'"; }
		
		$q = "select * from "._main_table_." where status='a' ".$whereSQL." order by ".$orderby." limit ".$offset.",".$perGallery;
		$r = mysql_query($q);
		$tots = mysql_num_rows($r);
		
		// we have results
		if(mysql_num_rows($r)){
		
			if($tots<$perGallery){
				$galleryTotal = $tots;
			} else {
				$galleryTotal = $perGallery;
			}
		
			$x=1;
			$z=rand(1,9999);
			
			$openhtml = '<!-- Start Gallery Display -->'."\n";
			$openhtml .= '<ul data-orbit>'."\n";
			
			// Loop through entrants
			while($row = mysql_fetch_array($r)){

				$mainhtml .= '<li data-orbit-slide="slide-'.$x.'">'."\n";
				
				
				// get some specified variables
				switch(_contest_type_){
					
					// photo upload contest
					case 1:
					 	$fullname = $this->getShortName($row['fname'],$row['lname']);
						$mainhtml .= '<img src="'._files_path_.$row['userfile'].'?x='.$z.'" style="margin-bottom:10px;" />';
						$thumb = _files_path_.'t_'.$row['userfile'];
					break;
					
					// audio video contest
					case 2:
						
						$fullname = $this->getShortName($row['fname'],$row['lname']);

						// Video
						if($row['embed']!=''){ $mainhtml .= urldecode($row['embed']); }
						
						// Audio
						else {
							$mainhtml .= '<script language="JavaScript" src="js/audio-player.js"></script>'."\n";
							$mainhtml .= '<center><object type="application/x-shockwave-flash" data="js/player.swf" id="audioplayer1" height="24" width="180">'."\n";
							$mainhtml .= '<param name="movie" value="js/player.swf">'."\n";
							$mainhtml .= '<param name="FlashVars" value="playerID=1&amp;soundFile=userfiles/'.$row['userfile'].'">'."\n";
							$mainhtml .= '<param name="quality" value="high">'."\n";
							$mainhtml .= '<param name="menu" value="false">'."\n";
							$mainhtml .= '<param name="wmode" value="transparent">'."\n";
							$mainhtml .= '</object></center>'."\n";
						}

						$thumb = 'images/thumb.jpg';

					break;
					
					// pet contest
					case 3:
					    $mainhtml .= '<img src="'._files_path_.$row['userfile'].'?x='.$z.'" class="galleryImage" width="480" height="400" />'."\n";
					    $fullname = ucfirst(strtolower($row['petname']));
					    $thumb = _files_path_.'t_'.$row['userfile'];
					break;
				}
				
				// rest of content in li
				$mainhtml .= '<p>Support '.$fullname.'</p>';
    			$mainhtml .= '<ul class="button-group round">';
				$mainhtml .= '<li style="width:50%;"><a style="width:100%;" href="#" class="button secondary">Vote For Me</a></li>';
				$mainhtml .= '<li style="width:50%;">
							  	<a href="#" class="button" style="width:100%; color:#fff!important;" 
								  onclick="
								    window.open(
								      \'https://m.facebook.com/sharer.php?u=\'+encodeURIComponent(location.href), 
								      \'facebook-share-dialog\', 
								      \'width=626,height=436\'); 
								    return false;">Share It!
								 </a>
								</li>
							</ul>';
		
				$x++;

				$mainhtml .= '</li>'."\n";

				$mainhtml .= '<a href="#" style="display:none;" data-orbit-link="slide-'.$x.'" data-orbit-slide-number="'.$x.'"></a>';
				
			}
			
			
			// next button td
			$nexthtml = '<a href="#" onclick="picframe.location.href=\'picview.php\'" id="next1" class="slidemover"><img src="images/next-btn.gif" border="0" class="slidebtn" /></a>';
				
			$closehtml = '</ul>'."\n";
			
			
			// Combine with gallery tabs
			$html .= $openhtml.$mainhtml.$closehtml;
			}
		
		else {
			$html = '<p>&nbsp;</p><p>There are no current entrants.</p><p>&nbsp;</p><p>&nbsp;</p>'."\n";
		}
		
		return $html;
	}

}