<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: CDPReport.php                                                |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file is the user's reporting control panel and provides       |
| a snapshot of their CPD activities and credits based on the year   |
| in question.                                                       |
|                                                                    |
+--------------------------------------------------------------------+
*/

require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_CPDReport extends CRM_Core_Page {
  function run() {
  	
  	/**
	 * Preprocess this page before we do anything 
	 * Check if we are just listing out the snapshot or if there has been an update 
	 * or new activity added to the this contact's CPD record.
	 */
	 
	// Find the ID of the person viewing this page 
    $session = CRM_Core_Session::singleton();
	$contact_id = $session->get('userID');
	
	// Find the Year we are interested in and the date to print the report for. Default to this year
	$current_year = date("Y");
		
	if(!isset($_SESSION["report_year"])) {
		$_SESSION["report_year"] = $current_year;
	}
	
	$this->assign('report_year', $_SESSION["report_year"]);
	
	// Build a drop-down for changing the report year session variable
	$select_years = "";
	for($i=$current_year; $i>=($current_year-15); $i--) {
		$selected = "";
		if($i == $_SESSION["report_year"]) { $selected = "selected"; }
		$select_years .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
	} 
	$this->assign('select_years', $select_years);
		
	$today = date("D M j, Y");
	$this->assign('today', $today);
	 
	if(isset($_REQUEST['clear'])) {
		// Clear the cpd message
		$_SESSION['cpd_message'] = '';
	}
	 
	if(isset($_GET['action']) || isset($_POST['action'])){
	 	
	 	$action = $_REQUEST['action'];
	 		
	 	switch ($action) {
  			case 'insert':
				// Clear the cpd message
				$_SESSION['cpd_message'] = '';
  			
				// Insert new CPD Activity based on contactid, date and category.
				$category_id	= $_POST['category_id'];
				$credit_date	= $_POST['credit_date'];
				$credits		= $_POST['credits'];
				$activity		= mysql_real_escape_string($_POST['activity']);
				$notes			= mysql_real_escape_string($_POST['notes']);
   				
				$sql = "INSERT INTO civi_cpd_activities(contact_id, category_id, credit_date, credits, activity, notes) VALUES('".$contact_id."','".$category_id."','".$credit_date."','".$credits."','".$activity."','".$notes."')";
				CRM_Core_DAO::executeQuery($sql);
   				
				break;
   				
			case 'update':
				// Clear the cpd message
				$_SESSION['cpd_message'] = '';
			
   				// Update CDPD ctivity where civi_cpd_activities.id = $activity_id 
   				if(isset($_POST['activity_id'])){
   					$activity_id 	= $_POST['activity_id'];
   					$credit_date	= $_POST['credit_date'];
   					$credits		= $_POST['credits'];
   					$activity		= mysql_real_escape_string($_POST['activity']);
   					$notes			= mysql_real_escape_string($_POST['notes']);
   					$sql = "UPDATE civi_cpd_activities SET credit_date = '".$credit_date."', credits = ".$credits.", activity = '".$activity."', notes = '".$notes."' WHERE id =" . $activity_id;
   					CRM_Core_DAO::executeQuery($sql); 
   				}
   				break;
   				
			case 'delete':
				// Clear the cpd message
				$_SESSION['cpd_message'] = '';
					
   				// Delete Category where id = $catid
   				if(isset($_GET['activity_id'])){
   					$catid = $_GET['activity_id'];
   					$sql = "DELETE FROM civi_cpd_activities WHERE id =" . $activity_id;
   					// CRM_Core_DAO::executeQuery($sql);
   					print $sql;
   					
   				}
   				break;
   				
			default:
   				break;
		}
 	}
  
    // Set the page-title
    CRM_Utils_System::setTitle(ts('CPD Reporting'));
    
    /**
     * After processing actions above, Query Activities table: 
     * SELECT SUM(Activities) from the database, 
     * WHERE contact_id = this person 
     * AND credit_date = 'the year in question' 
     * GROUP BY Categories 
     */
		 
	// Get the name and membership number
	// Membership number will be external_identifier
	if(isset($contact_id)){
    	$sql = "SELECT display_name, external_identifier FROM civicrm_contact WHERE id = " . $contact_id;
    	$dao = CRM_Core_DAO::executeQuery($sql);
    	while( $dao->fetch( ) ) {    
    		$display_name 			= $dao->display_name;
    		$external_identifier	= $dao->external_identifier;
    	}
    	$this->assign('display_name', $display_name);
    	$this->assign('external_identifier', $external_identifier);
	}
     
    // SUM(Activities) from the database for this contact, for this year, GROUP BY Categories
    $sql = "SELECT civi_cpd_categories.id AS id
    	, civi_cpd_categories.category AS category
    	, SUM(civi_cpd_activities.credits) AS credits
    	, civi_cpd_categories.minimum
    	, civi_cpd_categories.maximum
    	, civi_cpd_categories.description
    	FROM civi_cpd_categories
    	LEFT OUTER JOIN civi_cpd_activities
    	ON civi_cpd_activities.category_id = civi_cpd_categories.id
    	AND civi_cpd_activities.contact_id = " . $contact_id . "
    	AND EXTRACT(YEAR FROM civi_cpd_activities.credit_date) = " . $_SESSION["report_year"] . "
    	GROUP BY civi_cpd_categories.id";
		
    $dao = CRM_Core_DAO::executeQuery($sql);
    
    $output = "";
    $icounter = 1;
  	
    while( $dao->fetch( ) ) {        
        $output	.= '<tr valign="top">'
				.  '<td height="18"><span class="CE">' . $icounter . '. ' . $dao->category . '</span><br/>'
        		.  '<strong>' . abs($dao->credits) . ' credits </strong><br/>'
        		.  '(minimum ' . abs($dao->minimum) . ' credits, maximum ' . abs($dao->maximum) . ' credits)<br/>'
        		.  $dao->description . ' </td>'
    			.  '</tr>'
    			.  '<tr valign="top">'
      			.  '<td><!-- put in buttons for add edit view -->'
        		.  '<a href="/civicrm/civicpd/EditReport?action=new&amp;catid=' . $dao->id . '">New</a> | <a href="/civicrm/civicpd/EditReport?action=update&amp;catid=' . $dao->id . '">Update</a> | <a href="/civicrm/civicpd/EditReport?action=view&amp;catid=' . $dao->id . '">View</a>'
      			.  '</td>'      
    			.  '</tr>'
    			.  '<tr valign="top">'
      			.  '<td>&nbsp;</td>'
    			.  '</tr>';
    	$icounter++;
     }

	$this->assign('output', $output);
    
    // Total credits for the year
    $sql = "SELECT SUM(credits) as total_credits 
    		FROM civi_cpd_activities 
    		WHERE contact_id = ". $contact_id ." 
    		AND EXTRACT(YEAR FROM civi_cpd_activities.credit_date) = " . $_SESSION["report_year"];
    		
    $dao = CRM_Core_DAO::executeQuery($sql);
    
    while( $dao->fetch( ) ) {    
    	$total_credits = abs($dao->total_credits);
    }
    
    if(isset($total_credits)) {
    	$this->assign('total_credits', $total_credits);
    } else {
    	$this->assign('total_credits', 0);
    }
    
    parent::run();
  }
}
