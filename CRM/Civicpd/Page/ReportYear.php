<?php

	require_once 'CRM/Core/Page.php';
	
	class CRM_Civicpd_Page_ReportYear extends CRM_Core_Page {	
	  function run() {
	  
	  // This script is called via jQuery.post() and sets the session year variable 
	  if(isset($_REQUEST['new_year'])) {
		$new_year = $_REQUEST['new_year'];
		$_SESSION['report_year'] = $new_year;
		$output = 1;
	  } else {
		$output = 0;
	  }
	
	  $this->assign('output', $output);
	
	  parent::run();
	
	}
}