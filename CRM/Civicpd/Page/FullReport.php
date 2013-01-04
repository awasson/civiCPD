<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: FullReport.php                                               |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file lists a full report of all member's                      |
| annual credits under the categories in the database.               |
|                                                                    |
| NOTE: This page uses brute force and multiple trips to the         |
|       database to return this report. It must be re-factored       |
|       before it will be ready for distribution.                    |
|                                                                    |
+--------------------------------------------------------------------+
*/
require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_FullReport extends CRM_Core_Page {
  function run() {
  
  	// Add Variables for date
  	$current_year = date("Y");
		
	if(!isset($_SESSION["report_year"])) {
		$_SESSION["report_year"] = $current_year;
	}
	
	// Build a drop-down for changing the report year session variable
	$select_years = "";
	for($i=$current_year; $i>=($current_year-15); $i--) {
		$selected = "";
		if($i == $_SESSION["report_year"]) { $selected = "selected"; }
		$select_years .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
	} 
	$this->assign('select_years', $select_years);
  
    // Set the page-title
    CRM_Utils_System::setTitle(ts('Review CPD Full Report'));

    // Get Categories
    $sql = "SELECT id, category FROM civi_cpd_categories ORDER BY id ASC";

    $dao = CRM_Core_DAO::executeQuery($sql);
     
    // Set up categories array
    $arr_categories = array();
    $x = 0;
    while( $dao->fetch( ) ) {   
       	$arr_categories[$x]["category"] = $dao->category;
       	$x++;	
    }
    
    // Set up table header for full report
    $report_table = '<table class="report-table" border="0" cellspacing="0" cellpadding="0">
    					<tr>
    						<th nowrap>Last Name</th>
    						<th nowrap>First Name</th>
    						<th nowrap>Member Number</th>
    						<th nowrap>Membership Type</th>
    						<th nowrap>Member Since</th>
    						<th nowrap>Total Credits</th>';
    
    // Retrieve Categories and print in table header					
    for($x =0; $x < count($arr_categories); $x++ ) {
    	$report_table .= '<th nowrap>' . $arr_categories[$x]["category"] . '</th>';
    }
    
    // End table header
    $report_table .= '</tr>';
    
    // Pull member data so we can loop through the data and run a second query to pull the results
    $sql = "SELECT civicrm_contact.id, 
    			   civicrm_contact.last_name, 
    			   civicrm_contact.first_name, 
    			   civicrm_contact.external_identifier 
    			   FROM civicrm_contact 
    			   ORDER BY civicrm_contact.last_name";
    
    $dao = CRM_Core_DAO::executeQuery($sql);
    
    // Set up members array
    $arr_members = array();
    $x = 0;
    while( $dao->fetch( ) ) {   
       	$arr_members[$x]["id"] = $dao->id;
       	$arr_members[$x]["last_name"] = $dao->last_name;
       	$arr_members[$x]["first_name"] = $dao->first_name;
       	$arr_members[$x]["external_identifier"] = $dao->external_identifier;
       	$x++;	
    }
    
    for($x =0; $x < count($arr_members); $x++ ) {
    	// Make sure the record isn't blank
		if(!is_null($arr_members[$x]["last_name"]) || !is_null($arr_members[$x]["first_name"])) {    	
    		$report_table .= '<tr>';
    		$report_table .= '<td>' . $arr_members[$x]["last_name"] . '</td>';
    		$report_table .= '<td>' . $arr_members[$x]["first_name"] . '</td>';
    		$report_table .= '<td>' . $arr_members[$x]["external_identifier"] . '</td>';
    		$report_table .= '<td>' . 'member type' . '</td>';
    		$report_table .= '<td>' . 'member since' . '</td>';
    	
    		$sql = "SELECT civi_cpd_categories.id AS id
    			 , civi_cpd_categories.category AS category
    			 , SUM(civi_cpd_activities.credits) AS credits
    			 , civi_cpd_categories.minimum
    			 , civi_cpd_categories.maximum
    			 , civi_cpd_categories.description
    			 FROM civi_cpd_categories
    			 LEFT OUTER JOIN civi_cpd_activities
    			 ON civi_cpd_activities.category_id = civi_cpd_categories.id
    			 AND civi_cpd_activities.contact_id = " . $arr_members[$x]["id"] . "
    			 AND EXTRACT(YEAR FROM civi_cpd_activities.credit_date) = " . $_SESSION["report_year"] . "
    			 GROUP BY civi_cpd_categories.id";
    			 
    		$dao = CRM_Core_DAO::executeQuery($sql);
    		
    		$total_credits = 0;
    		$sub_cells = "";
    		
    		while( $dao->fetch( ) ) { 
    			$total_credits += abs($dao->credits); 
       			$sub_cells .= '<td>' . abs($dao->credits) . '</td>';	
    		}
    		
    		$report_table .= '<td>' . $total_credits . '</td>';
    		
    		$report_table .= $sub_cells;
    	
    		$report_table .= '</tr>';	
    	}
    	
    }
    
    
    
    			   
    			       
    // End Table
    $report_table .= '</table>';

    $this->assign( 'report_table', $report_table );
    
    parent::run();
  }
}
