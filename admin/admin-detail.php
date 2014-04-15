<?php
// popup details about entrant
include('../inc/base.inc.php');
include('../inc/utility.class.php');
$x = rand(1,9999);

$u = new Utility();
$html= $u->displayAdminDetail($_GET['id']);
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/main.css?x=<?php echo $x; ?>" />

</head>
<body>
    <div id="container">

        <?php echo $html; ?>

    </div>

<!-- local scripts -->
<script src="/common/tools/js/scripts.js?x=<?php echo $x; ?>"></script>
<script src="/common/tools/js/functions.js?x=<?php echo $x; ?>"></script>

</body>
</html>