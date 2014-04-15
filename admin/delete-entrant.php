<?php
// delete entrant from system - double verify
include('../inc/base.inc.php');
include('../inc/utility.class.php');

$u = new Utility();

if(isset($_POST['sentForm']) && $_POST['sentForm']=='y'){
	$u->deleteData($_POST['id']);
	$success='y';
}

if(!isset($success)){
	$html = $u->displayDeleteForm($_GET['id']);
}

else {
	$html = $u->displayDeleteSuccess();
}

?>

<!doctype html>
<html lang="en" class="no-js">
<head>
<title>Delete Entrant</title>
<style>
body {
	line-height: 1.8em;
	color: black;
	background-color: #e4e4e4;
	background-image: url(images/popupbg.jpg);
	background-repeat: repeat-x;
	background-position: left top;
	font-size: 62.5%;
	font-size:14px;
	font-family:Helvetica, Arial, sans-serif;
	text-align:center;
}
</style>
</head>

<body>

<?php echo $html; ?>

<!-- local scripts -->
<script type="text/javascript" src="../js/inc.js" language="javascript"></script>
<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

</body>
</html>