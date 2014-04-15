<?php
// copyright 2013 ccme

// Error reporting
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ERROR);

// Clear Channel File Upload Contesting
$contestID = 1; // enter contest id to retrieve details

// connect to db
define('_db_host_' , 'ccomr-common-user.ccrd.clearchannel.com');
define('_db_uname_' , 'phoenix');
define('_db_pword_' , 'DYQ1343e');
define('_db_name_' , 'phoenix_contesting');

$dbh = mysql_connect(_db_host_ , _db_uname_ , _db_pword_) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db(_db_name_);

$q = "select * from contest_details left join contest_stations on contest_stations.id=contest_details.station_id where contest_details.id='" . $contestID . "'";
$r = mysql_query($q);

if(mysql_num_rows($r)>0){ $contest = mysql_fetch_assoc($r);	}

if($contest['station_id']==9){ $rootFolder = '/common/'; }
else { $rootFolder = '/pages/'; }

// Contest Details
define('_title_' , $contest['name']);
define('_meta_description_' , $contest['meta_description']);
define('_meta_keywords_' , $contest['meta_keywords']);
define('_link_' , $rootFolder.$contest['folder_name']);
define('_entrant_type_' , 'Entrant');
define('_station_name_' , $contest['station_name']);


// Contest Settings
define('_contest_type_' , $contest['contest_type']); // contest type (1=Person Photo, 2=Video, 3=Pet Photo 4=Audio)
define('_status_' , $contest['contest_status']); // contest status (1=entry,2=voting,3=winnner,4=maintenance)
define('_group_contest_' , $contest['group_contest']); // is this a contest for groups also?
define('_parental_permission_' , $contest['parental_permission']); // is this a contest where under 18 is allowed?
define('_release_form_' , $contest['release_form_name']); // location in the pdf/ folder of the release form
define('_rules_form_' , $contest['rules_form_name']); // location in the pdf/ folder of the rules form

$hasAgeGroups = 'n';
if(!empty($contest['age_groups'])){
    $hasAgeGroups = 'y';
    global $age_group_array;
	$age_group_array = unserialize($contest['age_groups']);
}
	
define('_age_groups_' , $hasAgeGroups); // Are there age groups? If so, define array


// Database
define('_main_table_' , $contest['main_table']); // table that collects user information and tallies votes
define('_voters_table_', $contest['voters_table']); // table that records voters and their information
define('_admin_table_' , 'contest_users'); // table that holds admin users and their logins


// Upload settings
define('_perGallery_' , 20); // images per gallery. If there are many entrants you can raise this number as only 7 galleries fit on the page.
define('_files_path_' , 'userfiles/');
define('_pic_w_' , 480);
define('_pic_h_' , 400);
define('_thumb_w_' , 120);
define('_thumb_h_' , 100);
define('_pic_ratio_' , 1.2);
define('_orig_w_' , 600);
define('_max_file_size_' , 5); // size of file upload in MB
define('_max_text_words_' , 300); // max words in text field
define('_max_text_chars_' , 1000); // max chars in text field
define('_supported_file_types_' , serialize(array('mp3','MP3'))); // file types users can upload
define('_supported_image_types_' , serialize(array('jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG'))); // image types users can upload


// Theme Settings
define('_link_color_' , $contest['color_links']); // color of the h2, links and form border
define('_formbg_color_' , $contest['color_secondary']); // color of the form bg
define('_calendar_' , $contest['calendar']); // display a calendar graphic


// Voting
define('_ipcount_' , 3); // number of votes per ip address. this allows for 3 people voting from the same computer or ip address.