<?php

	// This script is called via jQuery.post() and sets the session year variable 

	require_once 'CRM/Core/Page.php';

	if(isset($_REQUEST['new_year'])) {
		$new_year = $_REQUEST['new_year'];
		$_SESSION["report_year"] = $new_year;
		$output = 1;
	} else {
		$output = 0;
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Report Year Switcher</title>
</head>
<body>
<?php print $output; ?>
</body>
</html>