<?php
/* Social Photo/Video Contesting Contest Class
 * Original Creation Date 04.2014
 * Working with contest details
 */


class Contest {
	
	protected $contestID;

	public function __construct ( $contestID ){
		$this->id = $contestID;
	} 

	function getContestDetails(){
		$r = mysql_query("
			SELECT * 
			FROM " . CONTEST_TABLE . "
			WHERE id = '" . $this->id . "'
			");
		if(mysql_num_rows($r)>0){
			return mysql_fetch_assoc($r);
		}
		else {
			header("Location: ../index.php");
			exit;
		}
	}
}
